package MGWMon::User;

use strict;
use MGWMon::Config qw($CFG);
use DBI;

our $connection = DBI->connect($CFG->{'db_dsn'}, $CFG->{'db_user'}, $CFG->{'db_pwd'}) || die ("Cant connect db...");
sub get_conn { return $connection;}

$| = 1;				

sub new {

    my($this, $data) = @_;     
    my $class = ref($this) || $this;
    my $self;
        
	if (ref($data)) {
		$self = $data;
	}
	else {
		$self->{'id'} = $data;						
	}

    $self->{'columns'} = [ qw(id name email sms) ];    
        
    bless($self, $class);        
    
    return $self;
}


sub connect {
	
	my $self=shift;
	$self->{dbh} = User::get_conn();
	return $self->{dbh};
}


sub load {

    my $this = shift;
    my $class = ref($this) || $this;
    
	my $sql = "select * from \"user\" where id='".$this->{id}."'";

	my $sth = $this->{dbh}->prepare($sql);
	$sth->execute or die "SQL Error: $DBI::errstr\n";
	my $hr = $sth->fetchrow_hashref;
		
	foreach my $key (@{$this->{'columns'}}) {
		$this->{$key} = $hr->{$key} if defined($hr->{$key});
	}

}

1;
