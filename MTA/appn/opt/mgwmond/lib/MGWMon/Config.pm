package MGWMon::Config;

use strict;

require Exporter;
our @ISA = qw(Exporter);
our @EXPORT_OK = qw($CFG);
our $CFG;

my $cfile = "config/mgwmond.ini";
load_config($cfile);

sub load_config {


	my $file = shift;
	open my $FH , "<", $file or die ("cannot open file $file");
	while (my $line = <$FH>) {
		chomp $line;
		next if(not $line);							
		my ($k, $v) = $line =~ /(.*?)=(.*)/;
		$k =~ s/\s//g; $v =~ s/^\s*//;			
		$CFG->{$k} = $v	if($k and $v);

	}

}

1;

