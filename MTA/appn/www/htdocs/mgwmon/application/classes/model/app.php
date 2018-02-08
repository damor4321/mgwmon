<?php
class Model_App extends ORM
{
	//protected $_db_group = 'sqlite';
	protected $_table_name  = 'app';	
	var $edit;
	var $display;
	var $delete;

	 protected $_has_many = array('aclrules' => array('model' => 'aclrule', 'through' => 'app_aclrule'));

	public function getList($limit = NULL, $offset = 0) {
		
		if($limit) {
			$apps = ORM::factory('app')->order_by('queue')->order_by('id')->limit($limit)->offset($offset)->find_all();
		}
		else {
			//$apps = ORM::factory('app')->order_by('client_id')->order_by('id')->find_all();
			$apps = ORM::factory('app')->order_by('queue')->order_by('id')->find_all();
		}
		
		foreach ($apps as $app) {
			$apps2[] = $app->setLinks();			
		}		
		return $apps2;
	}
	

	
	
	
	public function setLinks() {
		$this->edit =  Route::get('default')->uri(array('controller' => 'acl', 'action' => 'edit', 'id' => $this->id));
		$this->display =  Route::get('default')->uri(array('controller' => 'acl', 'action' => 'view', 'id' => $this->id));
		$this->delete =  Route::get('default')->uri(array('controller' => 'acl', 'action' => 'delete', 'id' => $this->id));
		return $this;
	}
	
	
	public function getAclrules() {
		return $this->aclrules->order_by('tp')->order_by('status')->find_all();
	}	
	
    public function set_newid() {
		$nv = DB::expr("nextval('app_id_seq') as ni");
     	$this->_primary_key_value = $this->id =  DB::select($nv)->execute()->get("ni");
        return;
	}

}

?>