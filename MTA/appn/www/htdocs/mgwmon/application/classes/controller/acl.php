<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Acl extends Controller {
	
	const INDEX_PAGE = 'index.php/acl/list';

	public function action_index()
	{
		$this->response->body('ACLs Controller 2');
	}

	
	public function action_list2()
	{
		$app = new Model_App();
		$list = array();

		// Get the list
		$apps = $app->getList();
		$view = new View('pages/app_list');
		$view->set('apps', $apps);
		$contents = $view->render();
		$this->response->body($contents);
		
	}

	public function action_list()
	{
		$app = new Model_App();
		$list = array();

        
		// Get the list
		$count = ORM::factory('app')->count_all();
		$config = Kohana::$config->load('pagination');
        
		$pagination = Pagination::factory(array(
                'total_items' => $count,
                'current_page'   => array('source' => 'query_string', 'key' => 'page'), 
                'items_per_page' => 16,
                'view'           => 'pagination/basic',
                'auto_hide'      => TRUE,
        ));
		$page_links = $pagination->render();
        
		$apps = $app->getList($pagination->items_per_page, $pagination->offset);
		
		$view = new View('pages/app_list');
		$view->set('apps', $apps);
		$view->set('page_links', $page_links);
		$contents = $view->render();
		$this->response->body($contents);
		
	}
	
	
	
	
	public function page($pagenum) {
		
		
		$view = new View('pages/products');
 
		// Instantiate Pagination, passing it the total number of product rows.
		$paging = new Pagination(array
			(
			'total_items' => ORM::factory('product')->with('category')->count_all(),
			));
 
		// render the page links
		$view->pagination = $paging->render();
 
		// Display X items per page, from offset = page number
		$this->template->content->products = ORM::factory('product')
			->with('category')
			->orderby(array('category:description' => 'ASC', 'code' => 'ASC'))
			->limit($paging->items_per_page, $paging->sql_offset)
			->find_all();
	}
	
		
	
	public function action_edit() {
		
		$app = new Model_App($this->request->param('id'));

		$this->_print_edit($app);

	}

	
	public function action_view() {
		
		$app = new Model_App($this->request->param('id'));
		$aclrules = $app->getAclrules();
		
		
		$view = new View('pages/app_view');
		$view->set('app', $app);
		$view->set('aclrules', $aclrules);

		$this->response->body($view->render());
		
		
	}
	

	
	
	
   public function action_save() {
   			
		$post = array_map('trim', $this->request->post());		
		$id = $post['id'];
	       	
		$rel = new Model_AppAclrule();
	
		if($id) {
			$app = new Model_App($id);
		}
		else {
			
			$app = new Model_App();
			$app->set_newid();
		}
	   	$app->values($post); 	
		$app->save();

		$this->_print_edit($app);
		

		/*
		$content = View::factory('pages/app_dlr')
			->bind('app', $app)
			->bind('aclrules', $aclrules)
			->render();
			
		$this->response->body($content);
		return;			

		$this->request->redirect(self::INDEX_PAGE);*/					

   }
	

    public function action_delete() {

    	$app = new Model_App($this->request->param('id'));
     	
    	$app->remove('aclrules');
        $app->delete();
        
        $this->request->redirect(self::INDEX_PAGE);
    }
	
    private function _print_edit ($app, $error=false) { 

			$aclrules = $app->getAclrules();
			
			
			$aclrules_file = "http://mtaadmin.internaldomain:8001/mgwmon/media/data/aclrules.json";
			$content = View::factory('pages/app_edit')
			->bind('app', $app)
			->bind('aclrules', $aclrules)
			->bind('aclrules_file', $aclrules_file)
			->render();

			$this->response->body($content);
    	
    }
    

    public function action_crud() {
    	
		$app = new Model_App($this->request->query('appid'));
		$post = array_map('trim', $this->request->post());
		
    	if($this->request->query('op') == "show") {   	
			$aclrules = $app->getAclrules();
			$result = array();
		    foreach ($aclrules as $aclrule) $result[] = $aclrule->as_array();
			echo json_encode($result);
			return;
    	}
    	
    	if($this->request->query('op') == "save") {

			/*$RES = print_r($this->request, true);
			$post = print_r($post, true);
			file_put_contents("/tmp/recoge", "$RES\n\n\n$post");
			die();*/
    		    		
    		$aclrule = new Model_Aclrule();
			$aclrule->values($post);
			$aclrule->set_newid();
			$aclrule->save();	    	
	    	$aclrule->add('apps', $app, true);

	    	$post['id'] = $aclrule->id;
	    	echo json_encode($post);
    		return;    		
    	}
    	
		if($this->request->query('op') == "update") {

			$aclrule = new Model_Aclrule($post['id']);
			$aclrule->values($post); 	
	    	$aclrule->save();
	    	echo json_encode($post);
    		return;    		
		}
    	
		if($this->request->query('op') == "delete") {

			$aclrule = new Model_Aclrule($this->request->post('id'));
			$aclrule->remove('apps', $app);
			$aclrule->delete();
			echo json_encode(array('success'=>true));
			return;
		}    	
    	
    }
    


} // End App

?>
