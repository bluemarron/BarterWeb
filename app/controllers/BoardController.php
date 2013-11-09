<?php

class BoardController extends BaseController {
  	protected $layout = 'layouts.master';
	

	public function postingList() {
		$member_id = Session::get('member_id');

		$free_postings = FreePosting::orderBy('id', 'desc')->get();

		$path = 'board/posting_list';

		$this->layout->path = $path;
		$this->layout->free_postings = $free_postings;
		$this->layout->content = View::make($path, array('path' => $path, 'free_postings' => $free_postings));
	}

	public function registForm() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '게시판 글 작성을 위해 로그인이 필요합니다.'));
			return;
		} 

		$path = 'board/regist_form'; 

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	}

	public function regist() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '게시판 글 작성을 위해 로그인이 필요합니다.'));
			return;
		} 

		$subject = Input::get('subject');
		$content = Input::get('content');

		$free_posting = new FreePosting;

		$free_posting->member_id = $member_id;
		$free_posting->subject = $subject;
		$free_posting->content = $content;
		$free_posting->save();

		return Redirect::to('./board/posting_list');
	}
}