<?php
class Model_AppAclrule extends ORM
{
	//protected $_db_group = 'sqlite';	
	protected $_table_name  = 'app_aclrule';	
	protected $_belongs_to = array('app' => array(), 'aclrule' => array());	
}

?>