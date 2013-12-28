<?php

class Trade extends Eloquent {
	protected $table = 'trades';

	public function getMemberTradeCountByStatus($member_id) {
		$request_count = 0;
		$complete_count = 0;
		$cancel_count = 0;
		
		$query  = "SELECT status, COUNT(*) AS count FROM trades 							 ";
		$query .= "WHERE request_member_id = '$member_id' OR target_member_id = '$member_id' ";
		$query .= "GROUP BY status 															 ";
		
		$trade_count_by_status = DB::select($query);

		for($i = 0; $i < count($trade_count_by_status); $i++) {
			if($trade_count_by_status[$i]->status == 'REQUEST')
				$request_count = $trade_count_by_status[$i]->count;
			if($trade_count_by_status[$i]->status == 'COMPLETE')
				$complete_count = $trade_count_by_status[$i]->count;			
			if($trade_count_by_status[$i]->status == 'CANCEL')
				$cancel_count = $trade_count_by_status[$i]->count;
		}

		$array = array(
		    'REQUEST' => $request_count,
		    'COMPLETE' => $complete_count,
		    'CANCEL' => $cancel_count
		);

		return $array;
	}
}