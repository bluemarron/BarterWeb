<?php

class ItemController extends BaseController {
  	protected $layout = 'layouts.master';
	
	private $CODE_LENGTH = 3;

	private $UPLOAD_IMAGE_COUNT = 8;
	private $UPLOAD_IMAGE_DEFAULT_PATH = 'upload_images/';

	private $UPLOAD_FILE_COUNT = 2;
	private $UPLOAD_FILE_DEFAULT_PATH = 'upload_files/';

	public function registForm() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '상품등록을 위해 로그인이 필요합니다.'));
		} else {
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

	public function regist() {
		$member_id = Session::get('member_id');

 		$name = Input::get('name');
 		$address = Input::get('address');
 		$search_keyword = Input::get('search_keyword');
 		$description = Input::get('description');

		$item = new Item;
		$item->member_id = $member_id;
		$item->name = $name;
		$item->address = $address;
		$item->search_keyword = $search_keyword;
		$item->description = $description;
		$item->save();

		$category_codes = Input::get('selected_category_codes');

		for($i = 0; $i < count($category_codes); $i++) {
			$item_category = new ItemCategory;
			$item_category->item_id = $item->id;
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
				$item_image = new ItemImage;
				$item_image->item_id = $item->id;
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
				$item_file = new ItemFile;
				$item_file->item_id = $item->id;
				$item_file->physical_file_name = $physical_file_name;
				$item_file->original_file_name = $original_file_name;
				$item_file->upload_path = $upload_file_path;
				$item_file->description = $description;

				$item_file->save();
			}
		}

		return Redirect::to('/');
	}
}