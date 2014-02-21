<?php

class AdminItemController extends BaseController {
  	protected $layout = 'layouts.admin_master';

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