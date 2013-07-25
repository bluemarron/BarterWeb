<?php

class AdminCategoryController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	public function listForm() {
		$path = '../admin/category/list_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	}
}