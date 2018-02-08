<?php defined('SYSPATH') or die('No direct script access.');
return array(
    'pidfile' => '/MTA/datos/mgwmond/pid/mgwmond.pid',
    'msgfile' => '/MTA/datos/mgwmond/pid/mgwmond.pip',
	'smsgw'	  => 'smsgw.provider.com',
	'msgsend' => '/MTA/appn/sbin/msgsend',
	'msgsend_from' => 'mta_alerts@company.com',
	'smtpsend' => '/MTA/appn/bin/smtpsend.pl',
	'smtpsend_relayhost' => 'mta062.internaldomain:10025',
    	'options' => array(
        	'foo' => 'bar',
    	),

);
