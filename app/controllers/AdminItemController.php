<?php

class AdminItemController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	private $CODE_LENGTH = 3;

	public function listForm() {
		$path = '../admin/item/list_form';

		$query  = "SELECT i.id, i.member_id, i.address, i.name, m.upload_path, m.physical_image_name FROM items AS i	";
		$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 	";
		$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 		";
		$query .= "WHERE i.deleted_at IS NULL								";
		$query .= "GROUP BY i.id											";
		$query .= "ORDER BY i.id DESC 									  	";
		$query .= "LIMIT 100		 									  	";

		$items = DB::select($query);

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'items' => $items, 'message' => ''));
	}

	public function modifyForm() {
		$member_id = Session::get('member_id');
		$item_id = Input::get('item_id');

		$path = '../admin/item/modify_form';

		$query  = "SELECT code, label FROM categories				";
		$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
		$query .= "AND deleted_at IS NULL							";
		$query .= "ORDER BY position ASC, code ASC				  	";

		$categories = DB::select($query);

		$query  = "SELECT i.id, i.member_id, i.address, i.name, i.description, i.search_keyword, m.upload_path, m.physical_image_name, i.created_at ";
		$query .= "FROM items AS i											";
		$query .= "INNER JOIN item_categories AS c ON (i.id = c.item_id) 	";
		$query .= "INNER JOIN item_images AS m ON (i.id = m.item_id) 		";
		$query .= "WHERE i.id = " . $item_id . "							";
		$query .= "LIMIT 1		 									  		";

		$items = DB::select($query);
		$item = $items[0];

		$query  = "SELECT upload_path, physical_image_name	";
		$query .= "FROM item_images 						";
		$query .= "WHERE item_id = " . $item_id . "			";

		$item_images = DB::select($query);

		$query  = "SELECT upload_path, physical_file_name, description	";
		$query .= "FROM item_files 										";
		$query .= "WHERE item_id = " . $item_id . "						";

		$item_files = DB::select($query);

		$query  = "SELECT c.code, c.full_label										";
		$query .= "FROM item_categories AS i 										";
		$query .= "INNER JOIN categories AS c ON (i.category_code = c.code) 		";
		$query .= "WHERE i.item_id = " . $item_id . "								";

		$item_categories = DB::select($query);

		$this->layout->path = $path;
		$this->layout->categories = $categories;

		$this->layout->content = View::make($path, 
			array('path' => $path, 
				'categories' => $categories, 
				'item' => $item, 
				'item_categories' => $item_categories, 
			    'item_images' => $item_images, 
			    'item_files' => $item_files, 
				'message' => ''));
	}

	public function delete() {
		if(Request::ajax()) {
		
		 	$item_id = Input::get('item_id');
	/*
			$item = Item::find($item_id);
			$item->deleted_at = time();
			$item->save();
			*/
			$_Item = App::make('Item');
			$_Item->softDelete($item_id);

			$response['status'] = 0;

			return Response::json($response);
		}
	}
}