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
		$items = array();

		$category_code = Input::get('category_code');
		$order_type = Input::get('order_type');

		$category_full_label = '';

		if($category_code != '') {
			$child_code_length = strlen($category_code) + $this->CODE_LENGTH;

			$query  = "SELECT code, label FROM categories				";
			$query .= "WHERE code LIKE '" . $category_code . "%'		";
			$query .= "AND LENGTH(code) = " . $child_code_length . "	";
			$query .= "AND deleted_at IS NULL							";
			$query .= "ORDER BY position ASC, code ASC				  	";

			$child_categories = DB::select($query);			

			if(sizeof($child_categories) == 0 && strlen($category_code) > $this->CODE_LENGTH) {
				$parent_category_code = substr($category_code, 0, strlen($category_code) - $this->CODE_LENGTH);
				$child_code_length = strlen($parent_category_code) + $this->CODE_LENGTH;

				$query  = "SELECT code, label FROM categories				";
				$query .= "WHERE code LIKE '" . $parent_category_code . "%'	";
				$query .= "AND LENGTH(code) = " . $child_code_length . "	";
				$query .= "AND deleted_at IS NULL							";
				$query .= "ORDER BY position ASC, code ASC				  	";

				$child_categories = DB::select($query);	
			}

			$category = DB::table('categories')->select('full_label')->where('code', $category_code)->first();
			$category_full_labels = explode('>>', $category->full_label);

			for($i = 0; $i < sizeof($category_full_labels); $i++) {
				$code = substr($category_code, 0, $this->CODE_LENGTH * ($i + 1));
				$category = array('code' => $code, 'label' => $category_full_labels[$i]);
				array_push($categories, $category);
			}

			if($order_type == 'popularity') {
				$query  = "SELECT i.id, i.address, i.name, m.upload_path, m.physical_image_name FROM items AS i	";
				$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 								";
				$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 									";
				$query .= "LEFT OUTER JOIN trades AS t ON (i.id = t.target_item_id AND t.status = 'REQUEST') 	";
				$query .= "WHERE c.category_code LIKE '" . $category_code . "%'									";
				$query .= "AND i.deleted_at IS NULL																";
				$query .= "AND i.display_yn = 'Y' 																";
				$query .= "GROUP BY i.id																		";
				$query .= "ORDER BY count(t.id) DESC, i.id DESC					  								";
				$query .= "LIMIT 100		 									  								";
			} else {
				$query  = "SELECT i.id, i.address, i.name, m.upload_path, m.physical_image_name FROM items AS i	";
				$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 	";
				$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 		";
				$query .= "WHERE c.category_code LIKE '" . $category_code . "%'		";
				$query .= "AND i.deleted_at IS NULL									";
				$query .= "AND i.display_yn = 'Y' 									";
				$query .= "GROUP BY i.id											";
				$query .= "ORDER BY i.id DESC 									  	";
				$query .= "LIMIT 100		 									  	";
			}

			$items = DB::select($query);
		} else {
			if($order_type == 'popularity') {
				$query  = "SELECT i.id, i.address, i.name, m.upload_path, m.physical_image_name FROM items AS i	";
				$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 								";
				$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 									";
				$query .= "LEFT OUTER JOIN trades AS t ON (i.id = t.target_item_id AND t.status = 'REQUEST') 	";
				$query .= "WHERE i.deleted_at IS NULL															";
				$query .= "AND i.display_yn = 'Y' 																";
				$query .= "GROUP BY i.id																		";
				$query .= "ORDER BY count(t.id) DESC, i.id DESC							  						";
				$query .= "LIMIT 100		 									  								";
			} else {
	 			$query  = "SELECT i.id, i.address, i.name, m.upload_path, m.physical_image_name FROM items AS i	";
				$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 	";
				$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 		";
				$query .= "WHERE i.deleted_at IS NULL								";
 				$query .= "AND i.display_yn = 'Y' 									";
				$query .= "GROUP BY i.id											";
				$query .= "ORDER BY i.id DESC 									  	";
				$query .= "LIMIT 100		 									  	";
			}

			$items = DB::select($query);
		}

		$this->layout->path = $path;
		$this->layout->root_categories = $root_categories;
		$this->layout->categories = $categories;
		$this->layout->child_categories = $child_categories;

		$this->layout->content = View::make($path, array('path' => $path, 'root_categories' => $root_categories, 'categories' => $categories, 
			'child_categories' => $child_categories, 'items' => $items, 'category_code' => $category_code, 'order_type' => $order_type));
	} 

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

}