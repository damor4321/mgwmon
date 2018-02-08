package MGWMon::Alert::Queue;
use base MGWMon::Alert;

use strict;


# ALERT SUBCLASS:
# 1. MUST HAVE THE SAME TYPE AS IN THE ALERT TABLE
# 2. MUST IMPLEMENT VALIDATE (the alert test), BASED ON TARGET (the monitor file) AND TRIGGER: any info that is able to perform a test.

our $type = '1';

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
	
	if(not $val =~ /^\d+$/) {
		$this->{logger}->log("ERROR: Bad value [$val] in mon file ".$this->{target});
		return 0;
	}

	if($val <= $this->{'trigger'}) {
		return 0;
	}
	
	if($this->{'status'} eq 'DEACTIVATED') {		
		$this->{logger}->log("INFO: Alert " . $this->{name} ." triggered. But is DEACTIVATED.");
		return 0;		
	}

	$this->{'cause'} = $val;				
	$this->{logger}->log("INFO: Alert " . $this->{name} ." triggered: [" . $this->{cause}. " > " . $this->{trigger} ."]");
	return 1;
}


1;
