<?php
class Model_AlertUser extends ORM
{
	//protected $_db_group = 'sqlite';	
	protected $_table_name  = 'alert_user';	
	protected $_belongs_to = array('alert' => array(), 'user' => array());	
}

?>