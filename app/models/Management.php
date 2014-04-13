<?php

class Management extends Eloquent {
	protected $table = 'managements';
 	protected $softDelete = true;

	public function getManagement() {
		$query  = "SELECT id, default_item_description FROM managements	";

		$db_rows = DB::select($query);
		return $db_rows[0];
	}

	public function softDelete($id) {
		$item = Management::find($id);
		$item->delete();
	}
} 