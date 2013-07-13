<?php

class HomeController extends BaseController {
  
  protected $layout = 'layouts.master';

	public function index() {
		$path = 'home/index';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	} 
}