<?php

class AdminCategoryController extends BaseController {
  	protected $layout = 'layouts.admin_master';
	
	private $CODE_LENGTH = 3;
	private $BG_COLORS = array('#00BFFF', '#3CFBFF', '#B4B4FF', '#9BFA73');

	private function getFullLabel($code) {			
		$full_label = '';

		for($category_level = 1; $category_level <= strlen($code) / $this->CODE_LENGTH; $category_level++) {
			$label = '';
			$each_code = substr($code, 0, $category_level * $this->CODE_LENGTH);

			$category = DB::table('categories')->select('code', 'label')->where('code', $each_code)->whereNull('deleted_at')->first();
			
			if($category != null)
				$label = $category->label;

			$full_label .= $label . ' >> '; 
		}
		
		if(strlen($full_label) > 0)
			$full_label = substr($full_label, 0, strlen($full_label) - 3);	
			
		return $full_label;
	}

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

				$map['bgcolor'] = $this->BG_COLORS[$bgcolor_idx];    

				$short_code = $map['code'];
					
				if(strlen($map['code']) > 6)
					$short_code = substr($map['code'], 1, 6) . '..';
		
				$map['short_code'] = $short_code;

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

			return Response::json($response);
		}
	}

	public function add() {
	 	if(Request::ajax()) {
			$code = Input::get('code');
			$label = Input::get('label');
			$position = Input::get('position');

			if(strlen($code) > 0) {
				$new_code = $code;
			} else {
				$new_code = DB::table('categories')->max('code');

				if(strlen($new_code) > 0) {
					$new_code = (int)($new_code) + 1;
					$new_code = sprintf("%0" . $this->CODE_LENGTH . "d", $new_code);
				} else {
					$new_code = sprintf("%0" . $this->CODE_LENGTH . "d", 1);
				}
			}
				
			$category = new Category;

			$category->code = $new_code;
			$category->label = $label;
			$category->position = $position;
			$category->save();

			$query  = "SELECT code FROM categories				";  
			$query .= "WHERE code LIKE '" . $new_code . "%' 	";
			$query .= "AND deleted_at IS NULL					";
			$query .= "ORDER BY position ASC, updated_at DESC	";

			$categories = DB::select($query);

			for($i = 0; $i < sizeof($categories); $i++) {
				$full_label = $this->getFullLabel($categories[$i]->code);

				DB::table('categories')
		        	->where('code', $categories[$i]->code)
		            	->update(array('full_label' => $full_label));
			}

			$response['parent_code'] = substr($new_code, 0, strlen($new_code) - $this->CODE_LENGTH);

			return Response::json($response);
		}
	}
}