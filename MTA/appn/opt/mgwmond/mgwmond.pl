#!/usr/bin/perl

use strict;
use lib qw(lib /MTA/appn/lib/PDist);
use MGWMon::Config qw($CFG);
use MGWMon::Logger;
use MGWMon::Alert::Queue;
use MGWMon::Alert::Service;
use Date::Format;
use Data::Dumper;

#$SIG{HUP} = \&main::reload_alerts;

my @alerts;

my $logger = MGWMon::Logger->new();
$logger->start();

write_pid();
$logger->log("INFO: Starting mgwmond with PID $$");
main();


sub write_pid {
	
	open (my $FH, ">", $CFG->{'pidfile'}) or $logger->dielog("Cannot open pidfile ". $CFG->{'pidfile'} . " for writing PID");
	print $FH $$;
	close $FH;

}

#sub reload_alerts {	
#		
#	$logger->log("INFO: Alert configuration changes detected. Reloading data...");
#	$SIG{HUP} = \&main::reload_alerts;
#	main();
#}


sub main {

	my $alert_queue = MGWMon::Alert::Queue->new();
	my @alerts_queue = $alert_queue->load_all();

	my $alert_service = MGWMon::Alert::Service->new();
	my @alerts_service = $alert_service->load_all();

	#my $alert_another = MGWMon::Alert::Another->new();
	#my @alerts_another_type = $alert_another->load_all();


	my @alerts_another_type;
	my @alerts = (@alerts_queue, @alerts_service, @alerts_another_type);

	
	for (;;) {

		$logger->log("INFO: Starting monintoring cycle.");

		alerts_loop(@alerts);	

		$logger->log("INFO: End cycle ...Sleeping " . $CFG->{'mon_frec'} ." secs.");		
		sleep $CFG->{'mon_frec'};

		try_reload();
	}
	
}


sub alerts_loop {
	
	my @alerts = @_;
	
	foreach my $alert (@alerts){	
		#print Dumper($alert);
		process($alert);	
	}
	
	return;
}


sub process {

	my $alert = shift;



	if (not $alert->validate()) {
		$logger->log("INFO: ". $alert->{name}. " TEST OK");		
		return;
	}

	if(not validate_schedule($alert->{name})) {

		return;
	}
	
	if($alert->send_timep ne 0) {
		
		$logger->log("WARNING: TEST KO: Sending alert " .$alert->{name}. " to Subscribed users.");		
	  	$alert->send();
	}
	
	return;	
}

sub validate_schedule {

	my $name = shift;

        my $wday = time2str("%A",time);
        my $time = time2str("%H:%M",time);


        if($wday eq "Saturday" or $wday eq "Sunday") {
                $logger->log("INFO: Alert $name triggered. But is Weekend.");
                return 0;
        }

        if($wday eq "Friday" and $time gt "15:00") {
                $logger->log("INFO: Alert $name triggered. But is Friday Evening.");
                return 0;
        }

        if($time lt "09:00"  or  $time gt "17:00") {
                $logger->log("INFO: Alert $name triggered. But is Out of Office.");
                return 0;
        }
	
	return 1;

}

sub try_reload {

	return if (not -e $CFG->{'msgfile'});	
	open (my $FH, "<", $CFG->{'msgfile'}) ; my $l = <$FH>; close $FH; unlink($CFG->{'msgfile'});
	if($l eq "HUP") {
		$logger->log("INFO: Alert configuration changes detected. Reloading data...".$CFG->{'msgfile'}. " y $l");
		main();
		exit();
	}
	return;	
}
	



