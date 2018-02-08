<?php
class Model_Aclrule extends ORM
{
	//protected $_db_group = 'sqlite';
	protected $_table_name  = 'aclrule';	
	var $edit;
	var $display;
	var $delete;

	protected $_has_many = array('apps' => array('model' => 'app', 'through' => 'app_aclrule'));
	
	
	public function getList() {
		$aclrules = ORM::factory('aclrule')->find_all();
		foreach ($aclrules as $aclrule) {
			$aclrules2[] = $app->setLinks();			
		}		
		return $aclrules2;
	}
	
	public function setLinks() {
		$this->edit =  Route::get('default')->uri(array('controller' => 'aclrule', 'action' => 'edit', 'id' => $this->id));
		$this->display =  Route::get('default')->uri(array('controller' => 'aclrule', 'action' => 'view', 'id' => $this->id));		
		$this->delete =  Route::get('default')->uri(array('controller' => 'aclrule', 'action' => 'delete', 'id' => $this->id));
		return $this;
	}
	
    public function set_newid() {
		$nv = DB::expr("nextval('aclrule_id_seq') as ni");
     	$this->_primary_key_value = $this->id =  DB::select($nv)->execute()->get("ni");
        return;
	}

}

?>

