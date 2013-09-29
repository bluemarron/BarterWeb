<?php

class MemberController extends BaseController {
  	protected $layout = 'layouts.master';
	
	public function loginAndRegistForm() {
		$path = '../member/login_regist_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	} 

	public function login() {
 		$member_id = Input::get('member_id');
 		$passwd = Input::get('passwd');

		$member = DB::table('members')->select('passwd', 'level', 'is_admin')->where('member_id', $member_id)->first();

		//$member = DB::select("SELECT * FROM members WHERE member_id = '$member_id'");
		// Error: Trying to get property of non-object
		//if($member[0] == null || Hash::check($passwd, $member[0]->passwd) == false) {
		
		if($member != null && Hash::check($passwd, $member->passwd)) {
			Session::put('member_id', $member_id);
			Session::put('level', $member->level);
			Session::put('is_admin', $member->is_admin);

			return Redirect::to('/');
		} else {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '가입되지 않은 아이디거나 패스워드가 일치하지 않습니다.'));
		}
	} 

	public function logout() {
		Session::flush();

		return Redirect::to('/');
	}

 	public function regist() {
 		$member_id = Input::get('member_id');
 		$passwd = Input::get('passwd');
		
		$member = new Member;

		$member->member_id = $member_id;
		$member->passwd = Hash::make($passwd);
		$member->save();

		return Redirect::to('/');
	}
}