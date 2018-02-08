<?php

class Model_Aclitem extends ORM
{
	//protected $_db_group = 'sqlite';
	protected $_table_name  = 'aclitem';		
	var $edit;
	var $display;
	var $delete;
	var $pnet;
	var $psender;
	
	
	public function __construct ($id, $header = NULL, $net = NULL, $sender = NULL, $tp = NULL) {
	/*	
		if(!$id) $this->set_newid(); //this is a new object

		
		if($tp) {
			$this->tp		= $tp;
		}
		else {
			if ($sender) $this->tp = "S";			
			if ($net) $this->tp = $this->tp . "N";
		}

		$this->header	= $header;
		$this->net		= $net;
		$this->sender	= $sender;
		$this->setAdditionalData();
	*/
		$l = $this->list_columns();
		print_r($l);	
		return $this;		
	}

	
	public function getList() {
		$aclitems = ORM::factory('aclitem')->find_all();
		foreach ($aclitems as $aclitem) {
			$aclitems2[] = $aclitem->setLinks();			
		}		
		return $aclitems2;
	}
	
	public function setAdditionalData() {

		$this->edit =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'edit_acl', 'id' => $this->id));
		$this->display =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'view_acl', 'id' => $this->id));
		$this->delete =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'delete_acl', 'id' => $this->id));
		
		$this->pnet = preg_replace("/[\/|\^|\$]/", "", $this->net);
    		$this->pnet = preg_replace("/\s*OK/", "", $this->pnet);  
		$this->psender = preg_replace("/\s*OK/", "", $this->sender);  
		
		return;
	}	

	
    public function set_newid() {
                $nv = DB::expr("nextval('aclitem_id_seq') as ni");
                $this->_primary_key_value = $this->id =  DB::select($nv)->execute()->get("ni");
                return;
    }	
		
		
}

?>

