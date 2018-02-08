<?php
class Model_User extends ORM
{
	//protected $_db_group = 'sqlite';
	protected $_table_name  = 'user';	
	var $edit;
	var $delete;
	protected $_has_many = array('alerts' => array('model' => 'alert', 'through' => 'alert_user'));
	
	
	public function getList() {
		$users = ORM::factory('user')->find_all();
		foreach ($users as $user) {
			$users2[] = $user->setLinks();			
		}		
		return $users2;
	}
	
	public function setLinks() {
		$this->edit =  Route::get('default')->uri(array('controller' => 'user', 'action' => 'edit', 'id' => $this->id));
		$this->delete =  Route::get('default')->uri(array('controller' => 'user', 'action' => 'delete', 'id' => $this->id));
		return $this;
	}
	
        public function set_newid() {
                $nv = DB::expr("nextval('user_id_seq') as ni");
                $this->_primary_key_value = $this->id =  DB::select($nv)->execute()->get("ni");
                return;
        }

}

?>
