<?php

class HomeController extends BaseController {
  
  private $CODE_LENGTH = 3;

  protected $layout = 'layouts.master';

	public function index() {
		$path = 'home/index';

		$query  = "SELECT code, label FROM categories				";
		$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
		$query .= "AND deleted_at IS NULL							";
		$query .= "ORDER BY position ASC, code ASC				  	";

		$root_categories = DB::select($query);
		$categories = array();
		$child_categories = array();

		$category_code = Input::get('category_code');
		$category_full_label = '';

		if($category_code != '') {
			$child_code_length = strlen($category_code) + $this->CODE_LENGTH;

			$query  = "SELECT code, label FROM categories				";
			$query .= "WHERE code LIKE '" . $category_code . "%'		";
			$query .= "AND LENGTH(code) = " . $child_code_length . "	";
			$query .= "AND deleted_at IS NULL							";
			$query .= "ORDER BY position ASC, code ASC				  	";

			$child_categories = DB::select($query);			

			$category = DB::table('categories')->select('full_label')->where('code', $category_code)->first();
			$category_full_labels = explode('>>', $category->full_label);

			$idx = 0;

			// for($i = 0; $i < sizeof($category_full_labels); $i++) {
			// 	$code = substr($category_code, 1, $this->CODE_LENGTH * ($i + 1));

			$category = array('code' => '111', 'label' => '222');

			// 	$map['code'] = '111';    

			array_push($categories, $category);

			// 	//$categories[$idx] = array('code' => $code, 'label' => $category_full_labels[$i]);
			// 	//$categories[$idx] = array('code' => '111', 'label' => '222');
			// 	//$idx++;
			// }

			//$categories[] = array('code' => '111', 'label' => '222');

		}

		// $map['code'] = '111';    
		// array_push($categories, array('code' => '111'));

		$this->layout->path = $path;
		$this->layout->root_categories = $root_categories;
		$this->layout->categories = $categories;
		$this->layout->child_categories = $child_categories;

		$this->layout->category_code = $category_code;

		$this->layout->content = View::make($path, array('path' => $path, 'root_categories' => $root_categories, 'categories' => $categories, 'child_categories' => $child_categories,
 				'category_code' => $category_code));
	} 
}