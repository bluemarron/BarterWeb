<?php

class Item extends Eloquent {
	protected $table = 'items';

	public function getMemberItemCount($member_id) {
		$request_count = 0;
		$complete_count = 0;
		$cancel_count = 0;
		
		$query  = "SELECT COUNT(*) AS count FROM items 	";
		$query .= "WHERE member_id = '$member_id' 		";

		$db_rows = DB::select($query);
		return $db_rows[0]->count;
	}
}