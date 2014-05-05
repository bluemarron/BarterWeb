<?php

class ItemCategory extends Eloquent {
	protected $table = 'item_categories';
	
	public function copy($item_id, $new_item_id) {
		$item_categories = ItemCategory::where('item_id', '=', $item_id)->get();

		for($i = 0; $i < sizeof($item_categories); $i++) {
			$item_category = new ItemCategory;
			$item_category->item_id = $new_item_id;
			$item_category->category_code = $item_categories[$i]->category_code;
			$item_category->save();
		}
	}

}