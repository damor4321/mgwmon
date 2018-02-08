<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Access extends Controller {
	
	const INDEX_PAGE = 'index.php/access/edit';

	public function action_index()
	{
		$this->response->body('Access Controller');
	}

	
	
	public function action_list()
	{

		try {
			$acl = new Model_Smtpacl($this->request->param('id'));
		}
		catch(Exception	$e) {
			print_r($e->getMessage());
			return;
		}

		// Get the list
		$acls = $acl->getAclObjects();		
		
		$view = new View('pages/access_list');
		$view->set('acls', $acls);
		$contents = $view->render();
		$this->response->body($contents);
		
	}
	
	
	
	
	public function action_edit() {

		
		try {
			$acl = new Model_Smtpacl($this->request->param('id') );
			foreach(explode ("," ,$acl->type) as $type) { 
				$acl_lines[] = $acl->getAclFile($type);
			}
			
		}
		catch(Exception	$e) {
			print_r($e->getMessage());
			return;
		}
		
		//print_r($acl_lines);
		
		
		
		$a= explode(',', $acl->type);
		
		if(in_array('senderallow', $a) && in_array('netallow', $a)) { 
		
			$netallow = $acl->groupNetAcl($acl_lines[0]);
			$senderallow = $acl->groupSenderAcl($acl_lines[1]);

			$diff1 = $acl->checkAclHeaders($netallow, $senderallow);		
			$diff2 = $acl->checkAclHeaders($senderallow, $netallow);

			print_r($diff1);
			print_r($diff2);

			if( !empty($diff1) || !empty($diff2) ) {

				die("TAAYTYT");
				if(!empty($diff1)) array_unshift($diff1, "WARNING: the following applications have NET info but not FROM info:");
				if(!empty($diff2)) array_unshift($diff2, "WARNING: the following applications have FROM info but not NET info:");
				$view = new View('pages/access_warn1');
				$view->set('diff1', $diff1);
				$view->set('diff2', $diff2);
				$this->response->body($view->render());
				
			}
			else {
				$acl_items = $acl->getAclItems($senderallow, $netallow);
				//$view = new View('pages/access_present1');
				print_r($acl_items);
				die("BYE");
				$view->set('acl_items', $acl_items);
				$this->response->body($view->render());
			}
			
		}
			
	}

} // End Access

?>
