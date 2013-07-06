<?php

class MemberController extends BaseController {
  
  protected $layout = 'layouts.master';

	public function loginAndRegist() {
		$path = 'member/login_regist';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	} 
}