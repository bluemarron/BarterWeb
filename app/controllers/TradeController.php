<?php

class TradeController extends BaseController {

	private $CODE_LENGTH = 3;

  	protected $layout = 'layouts.master';
	
	public function create() {
	 	if(Request::ajax()) {
			$request_member_id = Session::get('member_id');
			$target_member_id = Input::get('target_member_id');

			$request_item_id = Input::get('request_item_id');
			$target_item_id = Input::get('target_item_id');
				
			$trade = new Trade;
			$trade->request_member_id = $request_member_id;
			$trade->target_member_id = $target_member_id;
			$trade->request_item_id = $request_item_id;
			$trade->target_item_id = $target_item_id;
			$trade->status = "REQUEST";
			$trade->save();

			$trade_log = new TradeLog;
			$trade_log->trade_id = $trade->id;
			$trade_log->member_id = $request_member_id;
			$trade_log->status = "REQUEST";
			$trade_log->save();

			$response['status'] = 0;

			return Response::json($response);
		}
	}

	public function accept() {
	 	if(Request::ajax()) {
			$request_member_id = Session::get('member_id');
			$trade_id = Input::get('trade_id');

			$trade = Trade::find($trade_id);
			$trade->status = 'ACCEPT';
			$trade->save();

			$trade_log = new TradeLog;
			$trade_log->trade_id = $trade->id;
			$trade_log->member_id = $request_member_id;
			$trade_log->status = "ACCEPT";
			$trade_log->save();

			$response['status'] = 0;

			return Response::json($response);
		}
	}

	public function cancel() {
	 	if(Request::ajax()) {
			$request_member_id = Session::get('member_id');
			$trade_id = Input::get('trade_id');

			$trade = Trade::find($trade_id);
			$trade->status = 'CANCEL';
			$trade->save();

			$trade_log = new TradeLog;
			$trade_log->trade_id = $trade->id;
			$trade_log->member_id = $request_member_id;
			$trade_log->status = 'CANCEL';
			$trade_log->save();

			$response['status'] = 0;

			return Response::json($response);
		}
	}	

	public function complete() {
	 	if(Request::ajax()) {
			$request_member_id = Session::get('member_id');
			$trade_id = Input::get('trade_id');

			$trade = Trade::find($trade_id);
			$trade->status = 'COMPLETE';
			$trade->save();

			$trade_log = new TradeLog;
			$trade_log->trade_id = $trade->id;
			$trade_log->member_id = $request_member_id;
			$trade_log->status = 'COMPLETE';
			$trade_log->save();

			$response['status'] = 0;

			return Response::json($response);
		}
	}

	public function onGoingList() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '거래진행 상품을 조회하시기 위해 로그인이 필요합니다.'));
		} else {
			$path = '../trade/ongoing_list';

			$member_id = Session::get('member_id');

			$query  = "SELECT code, label FROM categories				";
			$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
			$query .= "AND deleted_at IS NULL							";
			$query .= "ORDER BY position ASC, code ASC				  	";

			$root_categories = DB::select($query);
			$categories = array();
			$child_categories = array();
			$items = array();

			$category_code = Input::get('category_code');
			$category_full_label = '';

			if($category_code != '') {
				$child_code_length = strlen($category_code) + $this->CODE_LENGTH;

				$query  = "SELECT code, label FROM categories				";
				$query .= "WHERE code LIKE '" . $category_code . "%'		";
				$query .= "AND LENGTH(code) = " . $child_code_length . "	";
				$query .= "AND deleted_at IS NULL							";
				$query .= "ORDER BY position ASC, code ASC				  	";

				$child_categories = DB::select($query);			

				if(sizeof($child_categories) == 0 && strlen($category_code) > $this->CODE_LENGTH) {
					$parent_category_code = substr($category_code, 0, strlen($category_code) - $this->CODE_LENGTH);
					$child_code_length = strlen($parent_category_code) + $this->CODE_LENGTH;

					$query  = "SELECT code, label FROM categories				";
					$query .= "WHERE code LIKE '" . $parent_category_code . "%'	";
					$query .= "AND LENGTH(code) = " . $child_code_length . "	";
					$query .= "AND deleted_at IS NULL							";
					$query .= "ORDER BY position ASC, code ASC				  	";

					$child_categories = DB::select($query);	
				}

				$category = DB::table('categories')->select('full_label')->where('code', $category_code)->first();
				$category_full_labels = explode('>>', $category->full_label);

				for($i = 0; $i < sizeof($category_full_labels); $i++) {
					$code = substr($category_code, 0, $this->CODE_LENGTH * ($i + 1));
					$category = array('code' => $code, 'label' => $category_full_labels[$i]);
					array_push($categories, $category);
				}

				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_categories AS c ON (a.id = c.item_id)														";
				$query .= "INNER JOIN item_categories AS d ON (b.id = d.item_id)														";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'REQUEST'																						";
				$query .= "AND (c.category_code LIKE '" . $category_code . "%' OR d.category_code LIKE '" . $category_code . "%')		";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			} else {
				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'REQUEST'																						";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			}

			$this->layout->path = $path;
			$this->layout->member_id = $member_id;
			$this->layout->root_categories = $root_categories;
			$this->layout->categories = $categories;
			$this->layout->child_categories = $child_categories;
			$this->layout->category_code = $category_code;

			$this->layout->content = View::make($path, array('path' => $path, 'member_id' => $member_id, 'root_categories' => $root_categories, 
				'categories' => $categories, 'child_categories' => $child_categories, 'trades' => $trades, 'category_code' => $category_code));
		}	
	} 

	public function completionList() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '거래완료 상품을 조회하시기 위해 로그인이 필요합니다.'));
		} else {
			$path = '../trade/completion_list';

			$member_id = Session::get('member_id');

			$query  = "SELECT code, label FROM categories				";
			$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
			$query .= "AND deleted_at IS NULL							";
			$query .= "ORDER BY position ASC, code ASC				  	";

			$root_categories = DB::select($query);
			$categories = array();
			$child_categories = array();
			$items = array();

			$category_code = Input::get('category_code');
			$category_full_label = '';

			if($category_code != '') {
				$child_code_length = strlen($category_code) + $this->CODE_LENGTH;

				$query  = "SELECT code, label FROM categories				";
				$query .= "WHERE code LIKE '" . $category_code . "%'		";
				$query .= "AND LENGTH(code) = " . $child_code_length . "	";
				$query .= "AND deleted_at IS NULL							";
				$query .= "ORDER BY position ASC, code ASC				  	";

				$child_categories = DB::select($query);			

				if(sizeof($child_categories) == 0 && strlen($category_code) > $this->CODE_LENGTH) {
					$parent_category_code = substr($category_code, 0, strlen($category_code) - $this->CODE_LENGTH);
					$child_code_length = strlen($parent_category_code) + $this->CODE_LENGTH;

					$query  = "SELECT code, label FROM categories				";
					$query .= "WHERE code LIKE '" . $parent_category_code . "%'	";
					$query .= "AND LENGTH(code) = " . $child_code_length . "	";
					$query .= "AND deleted_at IS NULL							";
					$query .= "ORDER BY position ASC, code ASC				  	";

					$child_categories = DB::select($query);	
				}

				$category = DB::table('categories')->select('full_label')->where('code', $category_code)->first();
				$category_full_labels = explode('>>', $category->full_label);

				for($i = 0; $i < sizeof($category_full_labels); $i++) {
					$code = substr($category_code, 0, $this->CODE_LENGTH * ($i + 1));
					$category = array('code' => $code, 'label' => $category_full_labels[$i]);
					array_push($categories, $category);
				}

				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_categories AS c ON (a.id = c.item_id)														";
				$query .= "INNER JOIN item_categories AS d ON (b.id = d.item_id)														";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'COMPLETE'																					";
				$query .= "AND (c.category_code LIKE '" . $category_code . "%' OR d.category_code LIKE '" . $category_code . "%')		";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			} else {
				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'COMPLETE'																					";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			}

			$this->layout->path = $path;
			$this->layout->member_id = $member_id;
			$this->layout->root_categories = $root_categories;
			$this->layout->categories = $categories;
			$this->layout->child_categories = $child_categories;
			$this->layout->category_code = $category_code;

			$this->layout->content = View::make($path, array('path' => $path, 'member_id' => $member_id, 'root_categories' => $root_categories, 
				'categories' => $categories, 'child_categories' => $child_categories, 'trades' => $trades, 'category_code' => $category_code));
		}	
	} 

	public function cancellationList() {
		$member_id = Session::get('member_id');

		if($member_id == '') {
			$path = '../member/login_regist_form';

			$this->layout->path = $path;
			$this->layout->content = View::make($path, array('path' => $path, 'message' => '거래취소 상품을 조회하시기 위해 로그인이 필요합니다.'));
		} else {
			$path = '../trade/cancellation_list';

			$member_id = Session::get('member_id');

			$query  = "SELECT code, label FROM categories				";
			$query .= "WHERE LENGTH(code) = " . $this->CODE_LENGTH . "	";
			$query .= "AND deleted_at IS NULL							";
			$query .= "ORDER BY position ASC, code ASC				  	";

			$root_categories = DB::select($query);
			$categories = array();
			$child_categories = array();
			$items = array();

			$category_code = Input::get('category_code');
			$category_full_label = '';

			if($category_code != '') {
				$child_code_length = strlen($category_code) + $this->CODE_LENGTH;

				$query  = "SELECT code, label FROM categories				";
				$query .= "WHERE code LIKE '" . $category_code . "%'		";
				$query .= "AND LENGTH(code) = " . $child_code_length . "	";
				$query .= "AND deleted_at IS NULL							";
				$query .= "ORDER BY position ASC, code ASC				  	";

				$child_categories = DB::select($query);			

				if(sizeof($child_categories) == 0 && strlen($category_code) > $this->CODE_LENGTH) {
					$parent_category_code = substr($category_code, 0, strlen($category_code) - $this->CODE_LENGTH);
					$child_code_length = strlen($parent_category_code) + $this->CODE_LENGTH;

					$query  = "SELECT code, label FROM categories				";
					$query .= "WHERE code LIKE '" . $parent_category_code . "%'	";
					$query .= "AND LENGTH(code) = " . $child_code_length . "	";
					$query .= "AND deleted_at IS NULL							";
					$query .= "ORDER BY position ASC, code ASC				  	";

					$child_categories = DB::select($query);	
				}

				$category = DB::table('categories')->select('full_label')->where('code', $category_code)->first();
				$category_full_labels = explode('>>', $category->full_label);

				for($i = 0; $i < sizeof($category_full_labels); $i++) {
					$code = substr($category_code, 0, $this->CODE_LENGTH * ($i + 1));
					$category = array('code' => $code, 'label' => $category_full_labels[$i]);
					array_push($categories, $category);
				}

				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_categories AS c ON (a.id = c.item_id)														";
				$query .= "INNER JOIN item_categories AS d ON (b.id = d.item_id)														";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'CANCEL'																						";
				$query .= "AND (c.category_code LIKE '" . $category_code . "%' OR d.category_code LIKE '" . $category_code . "%')		";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			} else {
				$query  = "SELECT t.id, t.status, t.updated_at, 																		";
				$query .= "	t.request_member_id, t.request_item_id, a.address AS request_item_address, a.name AS request_item_name, 	";
				$query .= "	e.upload_path AS request_item_upload_path, e.physical_image_name AS request_item_physical_image_name,		";
				$query .= "	t.target_member_id, t.target_item_id, b.address AS target_item_address, b.name AS target_item_name,			";
				$query .= "	f.upload_path AS target_item_upload_path, f.physical_image_name AS target_item_physical_image_name			";
				$query .= "FROM trades AS t																								";
				$query .= "INNER JOIN items AS a ON (t.request_item_id = a.id)															";
				$query .= "INNER JOIN items AS b ON (t.target_item_id = b.id)															";
				$query .= "INNER JOIN item_images AS e ON (a.id = e.item_id)															";
				$query .= "INNER JOIN item_images AS f ON (b.id = f.item_id)															";
				$query .= "WHERE (t.request_member_id = '" . $member_id . "' OR t.target_member_id = '" . $member_id . "')				";
				$query .= "AND t.status = 'CANCEL'																						";
				$query .= "AND a.deleted_at IS NULL AND b.deleted_at IS NULL															";
				$query .= "GROUP BY t.id																								";
				$query .= "ORDER BY t.id DESC																							";
				$query .= "LIMIT 100																									";

			 	$trades = DB::select($query);
			}

			$this->layout->path = $path;
			$this->layout->member_id = $member_id;
			$this->layout->root_categories = $root_categories;
			$this->layout->categories = $categories;
			$this->layout->child_categories = $child_categories;
			$this->layout->category_code = $category_code;

			$this->layout->query = $query;


			$this->layout->content = View::make($path, array('path' => $path, 'member_id' => $member_id, 'root_categories' => $root_categories, 
				'categories' => $categories, 'child_categories' => $child_categories, 'trades' => $trades, 'category_code' => $category_code, 'query' => $query));
		}	
	} 
}