<?php

class AdminItemController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	private $CODE_LENGTH = 3;
	
	private $UPLOAD_IMAGE_COUNT = 8;
	private $UPLOAD_IMAGE_DEFAULT_PATH = 'upload_images/';

	private $UPLOAD_FILE_COUNT = 2;
	private $UPLOAD_FILE_DEFAULT_PATH = 'upload_files/';

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

		$query  = "SELECT seq, upload_path, physical_image_name	";
		$query .= "FROM item_images 							";
		$query .= "WHERE item_id = " . $item_id . "				";

		$db_item_images = DB::select($query);

		$item_images = array();

		for($i = 0; $i < $this->UPLOAD_IMAGE_COUNT; $i++) {
			$item_images[$i] = new ItemImage;

			for($j = 0; $j < sizeof($db_item_images); $j++) {
				if($db_item_images[$j]->seq == $i + 1) {
					$item_images[$i] = $db_item_images[$j];
					break;
				}
			}
		}		

		$query  = "SELECT seq, upload_path, physical_file_name, original_file_name, description	";
		$query .= "FROM item_files 											";
		$query .= "WHERE item_id = " . $item_id . "							";

		$db_item_files = DB::select($query);

		$item_files = array();

		for($i = 0; $i < $this->UPLOAD_FILE_COUNT; $i++) {
			$item_files[$i] = new ItemFile;

			for($j = 0; $j < sizeof($db_item_files); $j++) {
				if($db_item_files[$j]->seq == $i + 1) {
					$item_files[$i] = $db_item_files[$j];
					break;
				}
			}
		}

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

	public function modify() {
		$item_id = Input::get('item_id');
		$name = Input::get('name');
 		$address = Input::get('address');
 		$search_keyword = Input::get('search_keyword');
 		$description = Input::get('description');

		$item = Item::find($item_id);
		$item->name = $name;
		$item->address = $address;
		$item->search_keyword = $search_keyword;
		$item->description = $description;
		$item->save();
		
		$category_codes = Input::get('selected_category_codes');

		$affectedRows = ItemCategory::where('item_id', '=', $item_id)->delete();
		
		for($i = 0; $i < count($category_codes); $i++) {
			$item_category = new ItemCategory;
			$item_category->item_id = $item_id;
			$item_category->category_code = $category_codes[$i];
			$item_category->save();
		}
		
		$upload_image_path = $this->UPLOAD_IMAGE_DEFAULT_PATH . date("Ym",time()) . "/";

		for($i = 1; $i <= $this->UPLOAD_IMAGE_COUNT; $i++) {
			if(!Input::hasFile('image_' . $i))
				continue;

			$image = Input::file('image_' . $i);

			$extension =$image->getClientOriginalExtension(); //if you need extension of the file
			
			$physical_image_name = 'image_' . $item->id . '_' . $i . "." . $extension;
			$original_image_name = $image->getClientOriginalName();

			$upload_success = Input::file('image_' . $i)->move($upload_image_path, $physical_image_name);
			
			if($upload_success) {
				$affectedRows = ItemImage::where('item_id', '=', $item_id)->where('seq', $i)->delete();

				$item_image = new ItemImage;
				$item_image->item_id = $item->id;
				$item_image->seq = $i;
				$item_image->physical_image_name = $physical_image_name;
				$item_image->original_image_name = $original_image_name;
				$item_image->upload_path = $upload_image_path;

				$item_image->save();
			} 
		}
		
		$upload_file_path = $this->UPLOAD_FILE_DEFAULT_PATH . date("Ym",time()) . "/";

		for($i = 1; $i <= $this->UPLOAD_FILE_COUNT; $i++) {
			if(!Input::hasFile('file_' . $i))
				continue;

			$file = Input::file('file_' . $i);
			$description = Input::get('file_description_' . $i);

			$extension =$file->getClientOriginalExtension(); //if you need extension of the file
			
			$physical_file_name = 'file_' . $item->id . '_' . $i . "." . $extension;
			$original_file_name = $file->getClientOriginalName();

			$upload_success = Input::file('file_' . $i)->move($upload_file_path, $physical_file_name);
			
			if($upload_success) {
				$affectedRows = ItemFile::where('item_id', '=', $item_id)->where('seq', $i)->delete();

				$item_file = new ItemFile;
				$item_file->item_id = $item->id;
				$item_file->seq = $i;
				$item_file->physical_file_name = $physical_file_name;
				$item_file->original_file_name = $original_file_name;
				$item_file->upload_path = $upload_file_path;
				$item_file->description = $description;

				$item_file->save();
			}
		}
		
		return Redirect::to('./admin/item/list_form');
	}

	public function modifyDescriptionForm() {
		$path = '../admin/item/modify_description_form';

		$query = "SELECT id, default_item_description FROM managements	";
		$managements = DB::select($query);
		$management = $managements[0];

		$this->layout->path = $path;
		$this->layout->management = $management;

		$this->layout->content = View::make($path, 
			array('path' => $path, 
				'management' => $management, 
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