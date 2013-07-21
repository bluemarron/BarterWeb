<?php

class ItemController extends BaseController {
  	protected $layout = 'layouts.master';
	
	public function registForm() {
		$path = '../item/regist_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	}
}