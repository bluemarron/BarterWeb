<?php

class ItemController extends BaseController {
  	protected $layout = 'layouts.master';
	
	private $CODE_LENGTH = 3;

	public function registForm() {
		$path = '../item/regist_form';

		$query  = "SELECT code, label FROM categories				";
		$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
		$query .= "AND deleted_at IS NULL							";
		$query .= "ORDER BY position ASC, code ASC				  	";

		$categories = DB::select($query);

		$this->layout->path = $path;
		$this->layout->categories = $categories;

		$this->layout->content = View::make($path, array('path' => $path, 'categories' => $categories, 'message' => ''));
	}
}