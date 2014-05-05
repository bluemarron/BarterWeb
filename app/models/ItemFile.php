<?php

class ItemFile extends Eloquent {
	protected $table = 'item_files';
	
	private $UPLOAD_FILE_COUNT = 2;
	private $UPLOAD_FILE_DEFAULT_PATH = 'upload_files/';

	public function copy($item_id, $new_item_id) {
		$upload_file_path = $this->UPLOAD_FILE_DEFAULT_PATH . date("Ym",time()) . "/";

		if(File::exists($upload_file_path) == false)
			File::makeDirectory($upload_file_path);

		$item_files = ItemFile::where('item_id', '=', $item_id)->get();

		for($i = 0; $i < sizeof($item_files); $i++) {
			$physical_file_name = str_replace('file_' . $item_id . '_', 'file_' . $new_item_id . '_', $item_files[$i]->physical_file_name);
			
			$org_path = $item_files[$i]->upload_path . $item_files[$i]->physical_file_name;
			$new_path = $upload_file_path . $physical_file_name;
			
			$upload_success = File::copy($org_path, $new_path);
			
			if($upload_success) {
				$item_file = new ItemFile;
				$item_file->item_id = $new_item_id;
				$item_file->seq = $item_files[$i]->seq;
				$item_file->physical_file_name = $physical_file_name;
				$item_file->original_file_name = $item_files[$i]->original_file_name;
				$item_file->upload_path = $upload_file_path;

				$item_file->save();	
			}		
		}
	}
}