<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller {
	
	const INDEX_PAGE = 'index.php/user/list';

	public function action_index()
	{
		$this->response->body('Monitoring Users Controller');
	}

	public function action_list()
	{
		$user = new Model_User();


		// Get the list
		$users = $user->getList();				
				
		$view = new View('pages/user_list');
		$view->set('users', $users);
		$contents = $view->render();
		
		$this->response->body($contents);
		
	}
	
	
	public function action_edit() {
		
		$user = new Model_User($this->request->param('id'));
		
		$view = new View('pages/user_edit');
		$view->set('user', $user);

		$contents = $view->render();
				
		$this->response->body($contents);
		
		
	}

			
	
	
	public function action_save() {
		
		$post = array_map('trim', $this->request->post());
       	$id = $post['id'];
		//$post = Validation::factory($post);

       	if($id) {
       		$user = new Model_User($id);
		}
		else {
			$user = new Model_User();
			$user->set_newid();
		}
        $user->values($post); 
        
        $user->save(); 
        
        $this->request->redirect(self::INDEX_PAGE);						
	}
	
	
    public function action_delete() {

    	$user = new Model_User($this->request->param('id'));
     	
    	$user->remove('alerts');
        $user->delete();
        
        $this->request->redirect(self::INDEX_PAGE);
    }
	
	

} // End Alerts

?>
