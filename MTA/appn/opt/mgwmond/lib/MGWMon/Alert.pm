package MGWMon::Alert;

use strict;
use MGWMon::Config qw($CFG);
use MGWMon::Logger;
use MGWMon::User;
use DBI;
use Data::Dumper;	

# DATABASE CONNECTION IS STATIC
our $connection = DBI->connect($CFG->{'db_dsn'}, $CFG->{'db_user'}, $CFG->{'db_pwd'}) || die ("Cant connect db...");
sub connect { return $connection; }


$| = 1;
our $logger = MGWMon::Logger->new();
$logger->start();			
sub logger { return $logger;}
  
sub new {

    my($this, $id) = @_;     
    my $class = ref($this) || $this;

    my $self;
    $self->{'columns'} = [ qw(id name target trigger text text2 note status counter dbh counter2) ];    

	if (ref($id)) { #IS A ROW OF ALERT TABLE
		$self = $id; 
		$self->{'counter'} = undef;		
		$self->{'counter2'} = undef;		
	}
	else {
		$self->{'id'} = $id; #IS AN INITIALIZATION PASSING THE ID
	}	        
    
    bless($self, $class);
    
	$self->{dbh} = MGWMon::Alert::connect(); # DATABASE CONNECTION IS STATIC (ONLY ONE FOR ALL THE CLASS OBJECTS)
    
    return $self;
}


	

sub load {

    my $this = shift;
    my $class = ref($this) || $this;
    
	my $sql = "select * from alert where id='".$this->{id}."'";
	#$logger->log("Executing $sql");

	my $sth = $this->{dbh}->prepare($sql);
	$sth->execute or $logger->dielog("SQL ERROR: $DBI::errstr");
	my $hr = $sth->fetchrow_hashref;
		
	foreach my $key (@{$this->{'columns'}}) {
		$this->{$key} = $hr->{$key} if defined($hr->{$key});
	}

}


sub load_all {

    my $this = shift;
    my $class = ref($this) || $this;
    
    my @result;
    
	my $sql = "select * from alert where type='".$this->{type}."'";
	$logger->log("Executing $sql");

	my $sth = $this->{dbh}->prepare($sql);
	$sth->execute or $logger->dielog("SQL ERROR: $DBI::errstr");
	
	while (my $hr = $sth->fetchrow_hashref ()) {
		push(@result, $class->new($hr)); # $class->new($hr) for POLYMORFISM
	}
	
	return @result;
}


sub load_users {

    my $this = shift;
    my $class = ref($this) || $this;
    
    my @result;
    
	my $sql = " select \"user\".* from alert_user, \"user\" where alert_user.alert_id='". $this->{id}."' and alert_user.user_id=\"user\".id";   
	$logger->log("Executing $sql");

	my $sth = $this->{dbh}->prepare($sql);
	$sth->execute or $logger->dielog("SQL ERROR: $DBI::errstr");
	
	while (my $hr = $sth->fetchrow_hashref ()) {
		push(@result, MGWMon::User->new($hr));
		
	}

	return @result;
}


sub get_target_value() {

	my $this = shift;
	my $type = shift;
	
	my $file = ($type eq 1) ? $CFG->{'mon_dir'} ."/". $this->{'target'} : $CFG->{'mon_services_dir'} ."/". $this->{'target'};
	my $FH;
	
	if ((not open ($FH , "<", $file)) and ($this->{counter2} le 1) ) {
		$logger->log("ERROR: Cannot open monitor file $file. Sending Alert to Admin Address");

		#my @args;
		#push(@args, $CFG->{'msgsend'});
		#push(@args, '--from=' . $CFG->{'msgsend_from'});
		#push(@args, '--to=' . $CFG->{'to_admin'});
		#push(@args, '--subject=MGWMON: BAD FUNCTION IN '. $this->{'target'}. ' FILE');
		#push(@args, '--msgtext=Cannot open mon file '.$file);		
		#$this->send_command(@args);
		#$args[2] = "--to=" . $CFG->{'sms_to_admin'} . "@" .  $CFG->{'smsgw'};
		#$this->send_command(@args);
		#$this->{counter2} ++;
		return;		
	}
	
	my $val = <$FH>; chomp $val;
	close $FH;
	return $val;	
}


## Overwrite in child classes.
sub validate {
	
}

sub send0 {

	my $this = shift;
	
	my @users = $this->load_users();	
	foreach my $user (@users) {

		#$MSGSEND --from=$from --to=$to --subject="MTA ALERT `hostname`: $1" --msgtext="MTA ALERT `hostname`: $2"		
		$logger->log("INFO: Sending alert to ".$user->{name}." [".$user->{email}."] [".$user->{sms}."]");	

		my @args;

		my $more_text = ($this->{'type'} eq 1) ? $CFG->{'additional_text'} : "";

		if($user->{'sms'}) {
			push(@args, $CFG->{'msgsend'});
			push(@args, "--from=" . $CFG->{'msgsend_from'});
			push(@args, "--to=" . $user->{'sms'} . "@" .  $CFG->{'smsgw'});
			push(@args, '--subject= ');
			push(@args, '--msgtext=' . $this->{'text'} . ": ". $this->{cause} ." ". $more_text);
			$this->send_command(@args);
		}

		if($user->{'email'}) {
			@args = ();
			push(@args, $CFG->{'msgsend'});
			push(@args, "--from=" . $CFG->{'msgsend_from'});
			push(@args, "--to=" . $user->{'email'});
			push(@args, '--subject=' . $CFG->{'msgsend_subject'} . " " . $this->{'target'} );
			push(@args, '--msgtext=' . $this->{'text'} . ": ". $this->{cause} ." ". $more_text);
			$this->send_command(@args);
		}
		
	}
	
}

sub send {

	my $this = shift;
	
	my @users = $this->load_users();	
	foreach my $user (@users) {
		$logger->log("INFO: Sending alert to ".$user->{name}." [".$user->{email}."] [".$user->{sms}."]");	

		my @args;

		my $more_text = ($this->{'type'} eq 1) ? $CFG->{'additional_text'} : "";

		if($user->{'sms'}) {
			push(@args, $CFG->{'smtpsend'});
			push(@args, "-from=" . $CFG->{'msgsend_from'});
			push(@args, "-to=" . $user->{'sms'} . "@" .  $CFG->{'smsgw'});
			push(@args, '-subject= ');
			push(@args, '-body-plain="' . $this->{'text'} . ": ". $this->{cause} ." ". $more_text .'"');
			push(@args, '-server=' . $CFG->{'smtpsend_relayhost'});
			$this->send_command(@args);
		}

		if($user->{'email'}) {
			@args = ();
			push(@args, $CFG->{'smtpsend'});
			push(@args, "-from=" . $CFG->{'msgsend_from'});
			push(@args, "-to=" . $user->{'email'});
			push(@args, '-subject="' . $CFG->{'msgsend_subject'} . " " . $this->{'target'} .'"');
			push(@args, '-body-plain="' . $this->{'text'} . ": ". $this->{cause} ." ". $more_text .'"');
			push(@args, '-server=' . $CFG->{'smtpsend_relayhost'});
			$this->send_command(@args);
		}
		
	}
	
}



sub send_command {

	my ($this, @args) = @_;
	
		
	my $rc = 0xffff & system @args;
	#my $rc = "1";
	my $str = sprintf("DEBUG: system(%s) returned %#04x: ", "@args", $rc);

	if ($rc == 0) {
    	$logger->log("$str : It ran with normal exit");
	} 
	elsif ($rc == 0xff00) {
    	$logger->log("$str : Command failed: $!");
	} 
	elsif (($rc & 0xff) == 0) {
    	$rc >>= 8;
    	$logger->log("$str : It ran with non-zero exit status $rc");
	} 
	else {
    	$str .= ": It ran with ";
    	if ($rc &   0x80) {
        	$rc &= ~0x80;
        	$str .= "Coredump from ";
    	} 
    	$str .= "Signal $rc";
    	$logger->log($str)
	} 
	
	my $ok = ($rc == 0);
	
}	


sub send_timep {

	my $this = shift;
	$this->{counter} ++;
	$logger->log("DEBUG :".$this->{name}. " counter:[".$this->{counter}."]");

	#@TODO: include as config var . 120 is frec*4
	if($this->{counter} >= 120) { 
		$logger->log("DEBUG :".$this->{name}. " reset counter to zero");
		$this->{counter} = 0;
		return 0;
	 }

	#a: 1-: 0sec, 2-:30sec, 3-:4min, 4-: 15min, 5-: 30min, 6-: 45min, 7-: 1h, 8-: 1h15min	
	my @steps = (1,2,8);
	foreach my $i (@steps) {
		return 1 if($this->{counter} == $i); 
	}
       
	my $mod = $this->{counter} % 30;	
	return 1 if($mod == 0);

	$logger->log("DEBUG : alert ". $this->{name} ." is triggered ...but skipping send it for this time =[". $this->{counter} ."]");
	return 0;

}


1;  
