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

		$path = 'board/regist_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	}

}