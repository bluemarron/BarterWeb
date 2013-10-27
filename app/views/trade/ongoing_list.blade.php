@extends('layouts.master')

@section('content')

	<script>
		function completeTrade(trade_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../trade/complete',
				data: {'trade_id':trade_id},
				cache: false,
				async: true,
				success: function(response) {
					alert('거래가 완료되었습니다.');
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}

		function cancelTrade(trade_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../trade/cancel',
				data: {'trade_id':trade_id},
				cache: false,
				async: true,
				success: function(response) {
					alert('거래가 취소되었습니다.');
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}
	</script>

	<style> 
	    <!--
		fieldset ul, fieldset li{
			border:0; margin:0; padding:0; list-style:none;
		}
		fieldset li{
			clear:both;
			list-style:none;
			padding-bottom:10px;
		}

		fieldset input{
			float:left;
		}
		fieldset label{
			width:120px;
			float:left;
		}
	    -->
   	</style>

  	<div class='well'>
	    <p>
			<i class='icon-plus'></i> 카테고리 : 
			<?for($j = 0; $j < sizeof($root_categories); $j++) {?>
				<i class='icon-th-large'></i> <a href='../trade/ongoing?category_code=<?=$root_categories[$j]->code?>'><?=$root_categories[$j]->label?></a>
			<?}?>
		<p>
		<?if(sizeof($categories) > 0) {?>		
	    <p>
			<i class='icon-plus'></i> 현재위치 : 
			<a href='../home/index/'>Home</a>
			<?for($i = 0; $i < sizeof($categories); $i++) {?>
				>> <a href='../trade/ongoing?category_code=<?=$categories[$i]["code"]?>'><?=$categories[$i]['label']?></a>
			<?}?>
		<p>
		<?}?>
		<?if(sizeof($child_categories) > 0) {?>		
	    <p>
			<?for($i = 0; $i < sizeof($child_categories); $i++) {?>
				<i class='icon-th'></i>
				<a href='../trade/ongoing?category_code=<?=$child_categories[$i]->code?>'><?=$child_categories[$i]->label?></a></a>
			<?}?>
		<p>
		<?}?>
  	</div>
	<div class='well'>
	    <p>
	    	<table>
		    	<?for($j = 0; $j < sizeof($trades); $j++) {?>
		    		<?if($j % 2 == 0){?><tr><?}?>
					<td align='center'>
						<table>
							<tr>
								<td align='center' colspan='2'>거래진행 #<?=$j+1?></td>
							</tr>
							<tr>
								<?if($member_id == $trades[$j]->request_member_id){?>
									<td>
										<table>
											<tr>
												<td align='center' width='180' height='200'>
													<a href='../item/view?item_id=<?=$trades[$j]->request_item_id?>&category_code=<?=$category_code?>'>
													<img src='../<?=$trades[$j]->request_item_upload_path?><?=$trades[$j]->request_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
													</a>
												</td>
											</tr>
											<tr>
												<td align='center'>
													<a href='../item/view?item_id=<?=$trades[$j]->request_item_id?>&category_code=<?=$category_code?>'>
													<?=$trades[$j]->request_item_name?>
													</a>
													<br/><?=$trades[$j]->request_item_address?>
												</td>
											</tr>	
										</table>
									</td>
									<td>
										<table>
											<tr>
												<td align='center' width='180' height='200'>
													<a href='../item/view?item_id=<?=$trades[$j]->target_item_id?>&category_code=<?=$category_code?>'>
													<img src='../<?=$trades[$j]->target_item_upload_path?><?=$trades[$j]->target_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
													</a>
												</td>
											</tr>
											<tr>
												<td align='center'>
													<a href='../item/view?item_id=<?=$trades[$j]->target_item_id?>&category_code=<?=$category_code?>'>
													<?=$trades[$j]->target_item_name?>
													</a>
													<br/><?=$trades[$j]->target_item_address?>
												</td>
											</tr>	
										</table>
									</td>
								<?} else {?>
									<td>
										<table>
											<tr>
												<td align='center' width='180' height='200'>
													<a href='../item/view?item_id=<?=$trades[$j]->target_item_id?>&category_code=<?=$category_code?>'>
													<img src='../<?=$trades[$j]->target_item_upload_path?><?=$trades[$j]->target_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
													</a>
												</td>
											</tr>
											<tr>
												<td align='center'>
													<a href='../item/view?item_id=<?=$trades[$j]->target_item_id?>&category_code=<?=$category_code?>'>
													<?=$trades[$j]->target_item_name?>
													</a>
													<br/><?=$trades[$j]->target_item_address?>
												</td>
											</tr>	
										</table>
									</td>								
									<td>
										<table>
											<tr>
												<td align='center' width='180' height='200'>
													<a href='../item/view?item_id=<?=$trades[$j]->request_item_id?>&category_code=<?=$category_code?>'>
													<img src='../<?=$trades[$j]->request_item_upload_path?><?=$trades[$j]->request_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
													</a>
												</td>
											</tr>
											<tr>
												<td align='center'>
													<a href='../item/view?item_id=<?=$trades[$j]->request_item_id?>&category_code=<?=$category_code?>'>
													<?=$trades[$j]->request_item_name?>
													</a>
													<br/><?=$trades[$j]->request_item_address?>
												</td>
											</tr>	
										</table>
									</td>
								<?}?>						
							</tr>
							<tr><td height='5' colspan='2'></td></tr>
							<tr>
								<td align='center' colspan='2'>
									<a href='#' onclick="completeTrade('<?=$trades[$j]->id?>');" class='btn btn-primary' style='width:78px;'>거래완료</a>
									<a href='#' onclick="cancelTrade('<?=$trades[$j]->id?>');" class='btn btn-danger' style='width:78px;'>거래취소</a>
								</td>
							</tr>				
						</table>	
					</td>
		    		<?if($j % 2 == 1){?></tr><?}?>
				<?}?>
			</table>
		<p>
  	</div>
	


  	</form> 
@stop      