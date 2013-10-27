<?php

class CategoryController extends BaseController {
  	protected $layout = 'layouts.master';
	
	private $CODE_LENGTH = 3;

	public function getChild() {
	 	if(Request::ajax()) {
	 		$response = array();	
	 		
			$code = Input::get('code');

			$query  = "SELECT code, label, position FROM categories						";  
			$query .= "WHERE code LIKE '" . $code . "%' 							  	";
			$query .= "AND LENGTH(code) = " . (strlen($code) + $this->CODE_LENGTH) . "	";
			$query .= "AND deleted_at IS NULL											";
			$query .= "ORDER BY position ASC, code ASC									";

			$categories = DB::select($query);

			for($i = 0; $i < sizeof($categories); $i++) {
				$map['code'] = $categories[$i]->code;
				$map['label'] = $categories[$i]->label;
				$map['position'] = $categories[$i]->position;

				array_push($response, $map);
			}

			return Response::json($response);
		}
	}

	public function getFullLabel() {
	 	if(Request::ajax()) {
			$code = Input::get('code');

			$query  = "SELECT full_label FROM categories ";  
			$query .= "WHERE code = '" . $code . "' 	 ";
			$query .= "LIMIT 1						 	 ";

			$categories = DB::select($query);

			for($i = 0; $i < sizeof($categories); $i++) {
				$response['full_label'] = $categories[$i]->full_label;
				break;
			}

			return Response::json($response);
		}
	}
}