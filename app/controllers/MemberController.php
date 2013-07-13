<?php

class MemberController extends BaseController {
  
  protected $layout = 'layouts.master';

	public function loginAndRegistForm() {
		$path = 'member/login_regist_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	} 

	public function login() {
 		$member_id = Input::get('member_id');
 		$passwd = Input::get('passwd');

		$member = DB::select("select * from members where member_id = '$member_id'");

		if($member == null || Hash::check($passwd, $member->passwd) == false) {
			$path = './member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '가입되지 않은 아이디거나 패스워드가 일치하지 않습니다.'));
		} else {
			$path = './';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path));
		}
	}

}