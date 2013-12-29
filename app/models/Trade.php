<?php

class Trade extends Eloquent {
	protected $table = 'trades';

	public function getMemberTradeCountByStatus($member_id) {
		$request_count = 0; // 거래대기 
		$accept_count = 0;	// 거래진행 
		$complete_count = 0; // 거래완료
		$cancel_count = 0;	// 거래취소
		
		$query  = "SELECT status, COUNT(*) AS count FROM trades 							 ";
		$query .= "WHERE request_member_id = '$member_id' OR target_member_id = '$member_id' ";
		$query .= "GROUP BY status 															 ";
		
		$trade_count_by_status = DB::select($query);

		for($i = 0; $i < count($trade_count_by_status); $i++) {
			$status = $trade_count_by_status[$i]->status;

			if($status == 'REQUEST')
				$request_count = $trade_count_by_status[$i]->count;
			else if($status == 'ACCEPT')
				$accept_count = $trade_count_by_status[$i]->count;
			else if($status == 'COMPLETE')
				$complete_count = $trade_count_by_status[$i]->count;			
			else if($status == 'CANCEL')
				$cancel_count = $trade_count_by_status[$i]->count;
		}

		$array = array(
		    'REQUEST' => $request_count,
		    'ACCEPT' => $accept_count,
		    'COMPLETE' => $complete_count,
		    'CANCEL' => $cancel_count
		);

		return $array;
	}
}