<?php

class Item extends Eloquent {
	protected $table = 'items';
 	protected $softDelete = true;

	public function getMemberItemCount($member_id) {
		$request_count = 0;
		$complete_count = 0;
		$cancel_count = 0;
		
		$query  = "SELECT COUNT(*) AS count FROM items 	";
		$query .= "WHERE member_id = '$member_id' 		";

		$db_rows = DB::select($query);
		return $db_rows[0]->count;
	}

	public function copy($id) {
		$org_item = Item::find($id);
		
		$item = new Item;
		$item->member_id = $org_item->member_id;
		$item->name = '[복사]' . $org_item->name;
		$item->address = $org_item->address;
		$item->search_keyword = $org_item->search_keyword;
		$item->description = $org_item->description;
		$item->display_yn = 'N';
		$item->save();

		return $item->id;
	}

	public function softDelete($id) {
		$item = Item::find($id);
		$item->delete();
	}
} 