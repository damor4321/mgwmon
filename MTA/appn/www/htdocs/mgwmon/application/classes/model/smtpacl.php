<?php
class Model_Smtpacl extends Model
{
	var $edit;
	var $display;
	var $delete;
	
	var $id;
	var $title;
	var $queue;	
	var $type;
	
	
	public function __construct ($id, $title = NULL, $queue = NULL, $type = NULL) {
		
		$this->id = $id;
		
		
		if(is_numeric($id)) { //this object is only for querys
			return $this;
		}
		
		//if(!$id) $this->setNewId(); //this is a new object
		
		if(!$title) {
			$this->load($id);
			
		}
		else {
			$this->title	= $title;
			$this->queue	= $queue;
			$this->type		= $type;
		}

		$this->setLinks();
		
		return $this;		
	}

	
	public function load($id) {

		
		//preg_match("/^(?P<role>[^\d]*)(?P<qindex>\d)(?P<tindex>\d)$/", $id, $m);
		preg_match("/^(?P<role>[^\d]*)(?P<qindex>\d)$/", $id, $m);
		$conf = Kohana::$config->load('admon');
		
		$this->role		= $m['role'];
		$this->title    = $conf['roles'][$this->role]['title'];

		$keys = array_keys($conf['roles'][$this->role]['queues']);
		$this->queue	= $keys[ $m['qindex'] ];
		
		//$this->type	=  $conf['roles'][$this->role]['queues'][$this->queue][ $m['tindex'] ];
		$this->type		= implode ( "," , $conf['roles'][$this->role]['queues'][$this->queue] );
		return;			
	}
	
	public function setLinks() {

		$this->edit =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'edit', 'id' => $this->id));
		$this->display =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'view', 'id' => $this->id));
		$this->delete =  Route::get('default')->uri(array('controller' => 'access', 'action' => 'delete', 'id' => $this->id));
		return;
	}	
	
	
	//
	
	public function getAclFile($type) {

		$conf = Kohana::$config->load('admon');
		
		$host = $conf['roles'][$this->role]['hosts'][0];

		$acl_dir = "{$conf['conn']['queue_conf_dir']}/{$this->queue}/maps";
		
		
		$this->sftp = new Net_SFTP($host);
		if (!$this->sftp->login($conf['conn']['user'], $conf['conn']['password'])) {
    			die('Login Failed');
		}

		
		$this->sftp->chdir($acl_dir);
				
		$contents = $this->sftp->get($type);		
		
		$lines = preg_split('/\n/', $contents);
		
		return $lines;
	}

	
	public function groupNetAcl($all_lines) {

		$group = array();
		$lnum = count($all_lines);		
		reset($all_lines);
		$i=0;
		
		
		$below_line = "";
		foreach ($all_lines as $line) {
			
			if(preg_match("/^\s*$/", $line, $m)) {
				$bellow_line = $line;
				continue;
			}

			//echo "ANT:$below_line<br>";
			//echo "$line<br>";

			$below_line_is_net = preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $below_line, $m);
			$below_line_is_key = preg_match("/^#[^#].*/", $below_line, $m);
			$line_is_net = preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $line, $m);
			$line_is_key = preg_match("/^#[^#].*/", $line, $m);
			
			if($below_line_is_key && $line_is_net) {
				
				//echo "ANTES HEADER, AHORA IP<br>";
				foreach($group as $key=>$arr_with_nets) {
					if(empty($arr_with_nets)) { array_push($group[$key],$line); }
				}
				if(!in_array($line ,  $group[$below_line])) array_push($group[$below_line],$line); //ojo
				$below_line = $line;
				continue;											
			}

			if($below_line_is_net && $line_is_net) {
			
				foreach($group as $key=>$arr_with_nets) {
					if(in_array($below_line, $arr_with_nets)) {
						array_push($group[$key],$line);
					}					
				}
				$below_line = $line;
				continue;															
			}
				
			if($line_is_key) {
				$group[$line] = array();
				$below_line = $line;
			}
			
		}
		
		array_shift($group); array_shift($group); array_pop($group);
		return $group;
	}
	
	
	
	
	public function groupSenderAcl($all_lines) {

		$group = array();
		$lnum = count($all_lines);		
		reset($all_lines);
		$i=0;
		
		while($i < $lnum) {
			
			//echo "ES ".$all_lines[$i]."<br>";
			$r1 = preg_match("/^#[^#].*/", $all_lines[$i], $m, NULL, 0);
			
			if($r1 == 1) {

				$header = $m[0];
				$i++;					
				
				while($i < $lnum ) {
					//echo "-->ES ".$all_lines[$i]."<br>";
					$r2 = preg_match("/^#[^#].*/", $all_lines[$i], $m, NULL, 0);
					if($r2 == 1) {$i--; break;}
					
					if ($all_lines[$i] != "") $group[ $header ][] = $all_lines[$i];
					$i++;
				}		
			}
   			$i++;
		}
		
		array_shift($group); array_pop($group);
		
		return $group;
	}
		
	public function checkAclHeaders($group1, $group2) {	

		$keys_g1 = array_keys($group1);
		$diff_headers = array();
		foreach ($keys_g1 as $k) {
			if (!array_key_exists($k, $group2)) {$diff_headers[] = $k;}
		}

		return $diff_headers;		
	}
	
	
	public function getAclItems($senderallow, $netallow) {
		
		$sender_keys = array_keys($senderallow);
	
			
		$acl_items = array();
		foreach ($sender_keys as $k) {
				$acl_items[$k] = new Model_Aclitem(NULL, $k, $senderallow[$k], $netallow[$k]);
		}
		
		return $acl_items;				
	}
	

	public function getAclItemsFromTable() {
		
		
		$aclitem = new Model_Aclitem();
		$acl_items = $aclitem->getList();
		
		return $acl_items;				
	}

	
    public function deleteAclItemFromTable($id) {

    	$aclitem = new Model_Aclitem($id);
     	
        return $aclitem->delete();
        
    }	
	
    
	public function getAclObjects() { //LOS OBJETOS

		$conf = Kohana::$config->load('admon');
		$roles = $conf['roles'];
		$acl_files = array();
		$idx = 0;
		foreach (array_keys($roles) as $role) {
			
			$qindex = 0;
			foreach(array_keys($roles[$role]['queues']) as $queue) {
				$types = $roles[$role]['queues'][$queue];
				
				if(is_array($types)) {
					/*$tindex = 0;
					foreach($types as $type) {
						$id = "{$role}{$qindex}{$tindex}";
						$acl_files[] = new Model_Smtpacl($id, $roles[$role]['title'], $queue, $type);
						$tindex++;
					}*/
					$id = "{$role}{$qindex}";
					$acl_files[] = new Model_Smtpacl($id, $roles[$role]['title'], $queue, implode(',', $types));
				}
				$qindex++;
			}
			$idx++;
		}		
		return $acl_files;
	}
		

        
        
}

?>
