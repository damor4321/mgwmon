<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'conn' => array
	(
		'user'		=> 'user',
		'password'	=> 'passwd',
		'timeout'	=> 90,
		'appn_dir'	=> '/MTA/appn',
		'queue_conf_dir'	=> '/MTA/appn/etc/psfix',
		'queue_conf_dir'	=> '/MTA/datos/mgwmond/test',
	),
	
	'roles' => array
	(
		'testtc'	=> array(
							'title'		=> 'Role One',
							'hosts' 	=> array('mta069.internaldomain', 'mta069.internaldomain'),
							'queues' 	=> array('qintmass-ipfromlock' => array('netallow', 'senderallow'), 
												 'qintmass-iplock' => array('netallow'))
		),
		'intmasstc'	=> array(
							'title'		=> 'Role Two',
							'hosts' 	=> array('mta060.internaldomain', 'mta061.internaldomain'),
							'queues' 	=> array('qintmass-ipfromlock' => array('netallow', 'senderallow'), 
												 'qintmass-iplock' => array('netallow'))
		),

		'intapptc'	=> array(
							'title'		=> 'Role Three',
							'hosts' 	=> array('mta062.internaldomain', 'mta063.internaldomain'),
							'queues' 	=> array('qintapp-ipfromlock' => array('netallow', 'senderallow'), 
												 'qintapp-iplock' => array('netallow'), 
												 'qintblackhole1', 
												 'qintblackhole2'),
		),
		
		'extenttc'	=> array(
							'title'		=> 'Role Four',
							'hosts' 	=> array('mta070.internaldomain'),
							'queues' 	=> array('qextent-companies' => array('netallow', 'senderallow'), 
												 'qextent-countries' => array('netallow', 'senderallow'))
		),
		
		'extsaltc'	=> array(
							'title'		=> 'Role Five',		
							'hosts' 	=> array('mta071.internaldomain'),
							'queues' 	=> array( 'qextsal-countries' => array('netallow'))
		),
		
		'tlstc'	=> array(
							'title'		=> 'Role SIx',		
							'hosts' 	=> array('mta099.internaldomain'),
							'queues' 	=> array( 't1gcompany-ent' => array('netallow','fromfilter', 'rcptfilter'),
												  't1gcompany-sal' => array('netallow','fromfilter'))
		)		
						
	)

);


