<?php

class ItemController extends BaseController {
  	protected $layout = 'layouts.master';
	
	private $CODE_LENGTH = 3;
	private $UPLOAD_IMAGE_COUNT = 8;
	private $UPLOAD_IMAGE_PATH = 'upload_images/';

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
		$category_codes = Input::get('selected_category_codes');

		$item = new Item;
		$item->member_id = $member_id;
		$item->name = $name;
		$item->address = $address;
		$item->save();

		for($i = 0; $i < count($category_codes); $i++) {
			$item_category = new ItemCategory;
			$item_category->item_id = $item->id;
			$item_category->category_code = $category_codes[$i];
			$item_category->save();
		}

		for($i = 1; $i <= $this->UPLOAD_IMAGE_COUNT; $i++) {
			if(!Input::hasFile('image_' . $i))
				continue;

			$image = Input::file('image_' . $i);

			$filename = $image->getClientOriginalName();
			$extension =$image->getClientOriginalExtension(); //if you need extension of the file
			$upload_success = Input::file('image_' . $i)->move($this->UPLOAD_IMAGE_PATH, $filename);
			
			if($upload_success) {
				$item_image = new ItemImage;
				$item_image->item_id = $item->id;
				$item_image->image_url = $filename;
				$item_image->save();
			}
		}

		$path = '../home/index';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path));
	}
}