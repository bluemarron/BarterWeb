<?php

class AdminController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	public function index() {
		$path = '../admin/index';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	}
}