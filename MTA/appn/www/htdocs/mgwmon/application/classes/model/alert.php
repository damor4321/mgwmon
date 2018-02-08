<?php
class Model_Alert extends ORM
{
	//protected $_db_group = 'sqlite';
	protected $_table_name  = 'alert';	
	var $edit;
	var $display;
	var $delete;
	
	protected $_has_many = array('users' => array('model' => 'user', 'through' => 'alert_user'));

	public function getList() {
		$alerts = ORM::factory('alert')->order_by('status')->order_by('id')->find_all();
		foreach ($alerts as $alert) {
			$alerts2[] = $alert->setLinks();			
		}		
		return $alerts2;
	}
	
	public function setLinks() {
		$this->edit =  Route::get('default')->uri(array('controller' => 'alert', 'action' => 'edit', 'id' => $this->id));
		$this->display =  Route::get('default')->uri(array('controller' => 'alert', 'action' => 'view', 'id' => $this->id));
		$this->delete =  Route::get('default')->uri(array('controller' => 'alert', 'action' => 'delete', 'id' => $this->id));
		return $this;
	}
	
	
	public function getUsers() {
		return $this->users->find_all();
	}
	

	public function getNotUsers() {

		$qry_inf = DB::select('user_id')->from('alert_user')->where('alert_id', '=', $this->id);
		return DB::select('*')->from('user')->where('id', 'not in', $qry_inf)->as_object()->execute();

	}
	

	public function set_newid() {

		$nv = DB::expr("nextval('alert_id_seq') as ni");
		$this->_primary_key_value = $this->id =  DB::select($nv)->execute()->get("ni");
		return;
	}
	
	
	
	
	public function sync_daemon($conf) {


		/*
		$pidfile = $conf['pidfile'];
		if (!file_exists($pidfile)) {
                       throw new Kohana_Exception('Synchronize monitoring process: pidfile '.$pidfile.' not exists.');					
		}
	
                if (!$pid = file_get_contents($pidfile)) {
                        throw new Kohana_Exception('Cannot synchronize configuration changes with monitoring process.');
                }
                $command = "kill -HUP $pid";
                exec($command,$output,$exit_value);
                if ($exit_value != 0) {
                        throw new Kohana_Exception('Bad exit_value ['.$exit_value.'] synchronizing monitoring process. Command:#'.$command.'#. Output:#'.print_r($output).'#');
                }
		*/

		file_put_contents($conf['msgfile'], "HUP");

                return;
     }
	
     public function send_deactivated($conf) {
     	
     	$users_yes = $this->getUsers();
     	
		$ok = $ko = array();
 		foreach ($users_yes as $user) {

 			
			if($user->sms) {
						$user->sms = $user->sms . "@" . $conf['smsgw'];
						//$command = "{$conf['msgsend']} --from={$conf['msgsend_from']} --to={$user->sms} --subject=\" \"  --msgtext=\"{$this->text2}\"";
						$command = "{$conf['smtpsend']} -from={$conf['msgsend_from']} -to={$user->sms} -subject=\" \"  -body-plain=\"{$this->text2}\" -server={$conf['smtpsend_relayhost']}";
						exec($command, $output, $exit);
						$user_data = $user->object(); 
						if($exit == 0) {
							$user_data['sms_ok'] = true;
							$ok[] = $user_data; 
						}
						else {
							$user_data['sms_ko'] = $command;
							$ko[] = $user_data;
						}
                	}

                	if($user->email) {
						//$command = "{$conf['msgsend']} --from={$conf['msgsend_from']} --to={$user->email} --subject=\"DESACTIVADA {$this->name}\"  --msgtext=\"{$this->text2}\"";
						$command = "{$conf['smtpsend']} -from={$conf['msgsend_from']} -to={$user->email} -subject=\"DESACTIVADA {$this->name}\"  -body-plain=\"{$this->text2}\" -server={$conf['smtpsend_relayhost']}";
						exec($command, $output, $exit);
						$user_data = $user->object(); 
						if($exit == 0) {
							$user_data['email_ok'] = true;
							$ok[] = $user_data; 
						}
						else {
							$user_data['email_ko'] = $command;
							$ko[] = $user_data;
						}
                	}
		}
		
		return array($ok, $ko);
     }
	
        
        
}

?>
