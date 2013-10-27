<?php

class MyPageController extends BaseController {
  	protected $layout = 'layouts.master';
	
	public function index() {
		$path = '../mypage/index';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	} 

}