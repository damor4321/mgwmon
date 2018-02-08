<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$view = new View('pages/main');
		$contents = $view->render();
		$this->response->body($contents);
	}

} // End Welcome
