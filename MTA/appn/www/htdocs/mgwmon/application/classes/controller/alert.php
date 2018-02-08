<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Alert extends Controller {
	
	const INDEX_PAGE = 'index.php/alert/list';

	public function action_index()
	{
		$this->response->body('Alerts Controller');
	}

	
	public function action_list()
	{
		$alert = new Model_Alert();
		$list = array();

		// Get the list
		$alerts = $alert->getList();
		$view = new View('pages/alert_list');
		$view->set('alerts', $alerts);
		$contents = $view->render();
		$this->response->body($contents);
		
	}
	
		
	
	public function action_edit() {
		
		$alert = new Model_Alert($this->request->param('id'));

		$this->_print_edit($alert);

	}

	
	public function action_view() {
		
		$alert = new Model_Alert($this->request->param('id'));
		$users_yes = $alert->getUsers();
		
		
		$view = new View('pages/alert_view');
		$view->set('alert', $alert);
		$view->set('users_yes', $users_yes);

		$this->response->body($view->render());
		
		
	}
	
	
	
	
   public function action_save() {
		
		$post = array_map('trim', $this->request->post());		
		$id = $post['id'];
		$users_yes = explode(" ", $post['users_yes']);
	       	
		$rel = new Model_AlertUser();
	
		if($id) {
			$alert = new Model_Alert($id);
			$last_status = $alert->{'status'};
		}
		else {
			
			$alert = new Model_Alert();
			$alert->set_newid();
			$last_status = $post['status'];
		}
	   	$alert->values($post); 	
	    	$alert->save();
					
		$alert->remove('users');
		//print_r($post['users_yes']);
		//die("H");
		if( $post['users_yes'] ) $alert->add('users', $users_yes, true);
				
		
		try {
			$conf = Kohana::$config->load('mgwmon');
	    		$alert->sync_daemon($conf);
		}
		catch(Exception	$e) {
			$this->_print_edit($alert, $e->getMessage());
			return;
		}
				
		if($post['status'] == 'DEACTIVATED' and $last_status == 'ACTIVE' and isset($post['send_alert_deact'])) {

			list($ok, $ko) = $alert->send_deactivated($conf);

			$content = View::factory('pages/alert_dlr')
			->bind('alert', $alert)
			->bind('ok', $ok)
			->bind('ko', $ko)
			->render();
			
			$this->response->body($content);
			return;			
		}

		$this->request->redirect(self::INDEX_PAGE);					

   }
	

    public function action_delete() {

    	$alert = new Model_Alert($this->request->param('id'));
     	
    	$alert->remove('users');
        $alert->delete();
        
        $this->request->redirect(self::INDEX_PAGE);
    }
	
    private function _print_edit ($alert, $error=false) { 

			$users_yes = $alert->getUsers();
			$users_not = $alert->getNotUsers();
			$content = View::factory('pages/alert_edit')
			->bind('alert', $alert)
			->bind('users_yes', $users_yes)
			->bind('users_not', $users_not)
			->bind('error_message', $error)
			->render();

			$this->response->body($content);
    	
    }
    

} // End Alerts

?>
