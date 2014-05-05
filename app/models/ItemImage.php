<?php

class ItemImage extends Eloquent {
	protected $table = 'item_images';

	private $UPLOAD_IMAGE_COUNT = 8;
	private $UPLOAD_IMAGE_DEFAULT_PATH = 'upload_images/';

	public function copy($item_id, $new_item_id) {
		$upload_image_path = $this->UPLOAD_IMAGE_DEFAULT_PATH . date("Ym",time()) . "/";

		if(File::exists($upload_image_path) == false)
			File::makeDirectory($upload_image_path);

		$item_images = ItemImage::where('item_id', '=', $item_id)->get();

		for($i = 0; $i < sizeof($item_images); $i++) {
			$physical_image_name = str_replace('image_' . $item_id . '_', 'image_' . $new_item_id . '_', $item_images[$i]->physical_image_name);
			
			$org_path = $item_images[$i]->upload_path . $item_images[$i]->physical_image_name;
			$new_path = $upload_image_path . $physical_image_name;
			
			$upload_success = File::copy($org_path, $new_path);
			
			if($upload_success) {
				$item_image = new ItemImage;
				$item_image->item_id = $new_item_id;
				$item_image->seq = $item_images[$i]->seq;
				$item_image->physical_image_name = $physical_image_name;
				$item_image->original_image_name = $item_images[$i]->original_image_name;
				$item_image->upload_path = $upload_image_path;

				$item_image->save();	
			}		
		}
	}
}