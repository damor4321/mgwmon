package MGWMon::Alert::Service;
use base MGWMon::Alert;

use strict;


# ALERT SUBCLASS:
# 1. MUST HAVE THE SAME TYPE AS IN THE ALERT TABLE
# 2. MUST IMPLEMENT VALIDATE (the alert test), BASED ON TARGET (the monitor file) AND TRIGGER: any info that is able to perform a test.

our $type = '2';

sub new {
	
	my($class, $id) = @_;
	my $self = $class->SUPER::new($id); 	
	$self->{type} = $type;
	$self->{logger} = $class->SUPER::logger();
	
	bless $self, $class;
	return $self;
}

sub validate {
		
	my $this = shift;
	my $val = $this->get_target_value($this->{type});	
	
	$this->{logger}->log("INFO: Target value for file is ".$this->{target}. " :[$val]");

	#s_N:s_C:s_A[:s_E:s_M]
	if(not $val =~ /^s_.:s_.:s_./) {
		$this->{logger}->log("ERROR: Bad value [$val] in mon file ".$this->{target});
		return 0;
	}

	my $dns_flag = substr($val,2,1);
	my $nscd_flag = substr($val,6,1);
	my $extra_flag = substr($val,10,1);
	my $postfix_flag = substr($val,14,1);
	my $queue_flag = substr($val,18,1);


	my @res = ();	
	if($dns_flag eq "n") {push (@res, "DNS");}
	if($nscd_flag eq "c") {push (@res, "NSCD"); }	
	if($this->{trigger} eq 4 and $extra_flag eq "a") {push (@res, "CFILTER or postfwd2"); }	
	if($postfix_flag eq "e" or $queue_flag eq "m") {push (@res, "POSTFIX for ". substr($this->{target},9));}

	$this->{'cause'} = join("," , @res);



	if($this->{'cause'} eq "") {
		return 0;
	}
	
	if($this->{'status'} eq 'DESACTIVADO') {		
		$this->{logger}->log("INFO: Alert " . $this->{name} ." triggered. But is DEACTIVATED.");
		return 0;		
	}


	$this->{logger}->log("INFO: Alert " . $this->{name} ." triggered: there are not running services: [" . $this->{cause}. "]");
	return 1;
}


1;
