<?php
class ItemPopupController extends BaseController {
  	protected $layout = 'layouts.popup_master';

	private $CODE_LENGTH = 3;

	private $UPLOAD_IMAGE_COUNT = 8;
	private $UPLOAD_IMAGE_DEFAULT_PATH = 'upload_images/';

	private $UPLOAD_FILE_COUNT = 2;
	private $UPLOAD_FILE_DEFAULT_PATH = 'upload_files/';

	public function zoomInItemImage() {
	 	$item_id = Input::get('item_id');
	 	$item_image_seq = Input::get('item_image_seq');

		$query  = "SELECT i.id, i.member_id, i.address, i.name, i.description, m.upload_path, m.physical_image_name, i.created_at ";
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

 		$path = '../item/zoom_in_item_image';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, 
			array('path' => $path, 
				  'item' => $item, 
				  'item_images' => $item_images,
				  'item_image_seq' => $item_image_seq
			));
	}
}