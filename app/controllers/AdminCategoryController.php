<?php

class AdminCategoryController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	private $CODE_LENGTH = 3;
	private $BG_COLORS = array('#00BFFF', '#3CFBFF', '#B4B4FF', '#9BFA73');

	public function listForm() {
		$path = '../admin/category/list_form';

		$this->layout->path = $path;
		$this->layout->content = View::make($path, array('path' => $path, 'message' => ''));
	}

	public function getChild() {
	 	if(Request::ajax()) {
	 		$last_position = 0;

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

				$last_position = $map['position'];
			
				$query  = "SELECT code AS sub_code, label AS sub_label FROM categories			";  
				$query .= "WHERE code LIKE '" . $map['code'] . "%' 								";
				$query .= "AND LENGTH(code) = " . (strlen($code) + $this->CODE_LENGTH * 2) . "	";
				$query .= "AND deleted_at IS NULL												";

				$sub_categories = DB::select($query);

				if(sizeof($sub_categories) > 0)
					$map['has_child'] = true;    
				else
					$map['has_child'] = false;    


				$bgcolor_idx = (strlen($code) / $this->CODE_LENGTH) % 4;
				$map["bgcolor"] = $BG_COLORS[$bgcolor_idx];    

				$short_code = $map["code"];
					
				if(strlen($map["code"]) > 6)
					$short_code = substr($map["code"], 1, 6) . "..";
		
				$map["short_code"] = $short_code;

				array_push($response, $map);  
			}

			$query  = "SELECT MAX(IFNULL(code, 0)) AS max_code FROM categories			";  
			$query .= "WHERE code LIKE '" . $code . "%' 							  	";
			$query .= "AND LENGTH(code) = " . (strlen($code) + $this->CODE_LENGTH) . "	";

			$categories = DB::select($query);

			for($i = 0; $i < sizeof($categories); $i++) {
				$max_end_code = substr($categories[$i]->max_code, (-1 * $this->CODE_LENGTH));			
				$new_end_code = (int)($max_end_code) + 1;
				
				$map["code"] = $code . sprintf("%0" . $this->CODE_LENGTH . "d", $new_end_code);      
				$map["label"] = "";    
				$map["position"] = $last_position + 1;    
				$map["has_child"] = false;   
				
				$short_code = $map["code"];
					
				if(strlen($map["code"]) > 6)
					$short_code = substr($map["code"], 1, 6) . "..";
					
				$map["short_code"] = $short_code;   

				array_push($response, $map);  
	
				break;
			}

	 	// 	$map['code'] = '1';      
			// $map['label'] = 'test-1';
			// $map['position'] = 1;    

			// array_push($response, $map);  
		
			return Response::json($response);
		}
	}
}