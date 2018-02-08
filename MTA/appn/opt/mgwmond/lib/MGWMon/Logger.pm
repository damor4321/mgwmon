package MGWMon::Logger;

use strict;
use MGWMon::Config qw($CFG);
use Date::Format;

sub new {

    my($this, $id) = @_;     
    my $class = ref($this) || $this;

    my $self = {    	
    	'logfile'  => $CFG->{logfile},
    	'loglevel' => 0    	
    };    
        
    bless($self, $class);
    
    return $self;
}


sub start {
	
	my $this = shift;
	
	open(TR, ">>" , $this->{logfile}) or die "Cannot open log file [". $this->{logfile}."]";
	select((select(TR), $|=1)[0]);
	
	return 1;

}


sub log {
	my ($self, $str) = @_;
	print TR time2str("%d/%m/%Y %H:%M:%S",time).": $str\n";
	return;
}


sub dielog {
	my ($self, $str) = @_;
	$self->log($str);
	die($str);
}

1;
