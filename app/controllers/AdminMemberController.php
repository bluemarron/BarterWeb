<?php

class AdminMemberController extends BaseController {
  	protected $layout = 'layouts.admin_master';

	public function listForm() {
		$path = '../admin/member/list_form';

		$query  = "SELECT id, member_id, created_at FROM members AS m	";
		$query .= "ORDER BY id DESC 									";
		$query .= "LIMIT 100		 									";

		$members = DB::select($query);

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'members' => $members, 'message' => ''));
	}
}