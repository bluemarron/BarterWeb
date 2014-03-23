@extends('layouts.master')

@section('content')

	<script>
		function requestTrade(target_member_id, request_item_id, target_item_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../trade/create',
				data: {'target_member_id':target_member_id, 'request_item_id':request_item_id, 'target_item_id':target_item_id},
				cache: false,
				async: true,
				success: function(response) {
					window.location.reload(true);
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}

		function acceptTrade(trade_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../trade/accept',
				data: {'trade_id':trade_id},
				cache: false,
				async: true,
				success: function(response) {
					window.location.reload(true);
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
					window.location.reload(true);
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
				<i class='icon-th-large'></i> <a href='../home/index?category_code=<?=$root_categories[$j]->code?>'><?=$root_categories[$j]->label?></a>
			<?}?>
		<p>
		<?if(sizeof($categories) > 0) {?>		
	    <p>
			<i class='icon-plus'></i> 현재위치 : 
			<a href='../home/index/'>Home</a>
			<?for($i = 0; $i < sizeof($categories); $i++) {?>
				>> <a href='../home/index?category_code=<?=$categories[$i]["code"]?>'><?=$categories[$i]['label']?></a>
			<?}?>
		<p>
		<?}?>
	</div>
	<div class='well'>
		<p><i class='icon-asterisk'></i>
			아래 상품은 내가 신청한 물품입니다. 연락이 올때가지 기다리셔야 됩니다.
		</p>		
		<p>
	    	<table>
		    	<?for($j = 0; $j < sizeof($trade_by_me_items); $j++) {?>
		    		<?if($j % 4 == 0){?><tr><?}?>
					<td align='center'>
						<table>
							<tr>
								<td align='center' width='180' height='200'>
									<a href='../item/view?item_id=<?=$trade_by_me_items[$j]->target_item_id?>&category_code=<?=$category_code?>'>
									<img src='../<?=$trade_by_me_items[$j]->target_item_upload_path?><?=$trade_by_me_items[$j]->target_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
									</a>
								</td>
							</tr>
							<tr>
								<td align='center'>
									<a href='../item/view?item_id=<?=$trade_by_me_items[$j]->target_item_id?>&category_code=<?=$category_code?>'>
									<?=$trade_by_me_items[$j]->target_item_name?>
									</a>
									<br/><?=$trade_by_me_items[$j]->target_item_address?>
								</td>
							</tr>	
							<tr>
								<td align='center' colspan='2'>
									<a href='#' onclick="cancelTrade('<?=$trade_by_me_items[$j]->trade_id?>');" class='btn btn-danger' style='width:78px;'>취소</a>
								</td>	
							</tr>	
						</table>	
					</td>
		    		<?if($j % 4 == 3){?></tr><?}?>
				<?}?>
			</table>
		<p>
	</div>
	<div class='well'>
	    <p>
	    	<table width='100%' align='center'>
	    		<tr valign='top'>
					<td align='left' width='220'>
						<table>
							<tr>
								<td>
									<img src='../<?=$item->upload_path?><?=$item->physical_image_name?>' border='0' align='absmiddle' style='width:200px;' />
									<!--<? echo '../' . $item->upload_path . $item->physical_image_name?>-->
								</td>
							</tr>
						</table>
					</td>
					<td align='left'>
						<table>
							<tr>
								<td colspan='2'>
									<h3><font color='blue'><?=$item->name?></font></h3>
								</td>	
							</tr>
							<tr>
								<td colspan='2'>
									<i class='icon-asterisk'></i> 상품번호 : <strong><?=str_pad($item->id, 6, "0", STR_PAD_LEFT)?></strong>
								</td>	
							</tr>
							<tr>
								<td colspan='2'>
									<i class='icon-asterisk'></i> 등록일자 : <?=date('Y-m-d', strtotime($item->created_at))?>
								</td>	
							</tr>							
							
							<tr>
								<td height='20' colspan='2'></td>	
							</tr>	
							<tr>
								<td align='left' colspan='2'>
									<a href='#' onclick="alert('준비중입니다.');" class='btn btn-warning' style='width:30px;'>수정</a>
									<a href='#' onclick="alert('준비중입니다.');" class='btn btn-danger' style='width:30px;'>삭제</a>
								</td>	
							</tr>							
						</table>	
					</td>
				</tr>	
			</table>
		<p>
  	</div>
	
	<?
	if(sizeof($trade_by_others_items) > 0) {
	?>
		<div class='well'>
			<p><i class='icon-asterisk'></i>
				아래 상품은 거래 신청 물품입니다. 선택하신 후 연락하세요.
			</p>
		    <p>
				<table>
			    	<?for($j = 0; $j < sizeof($trade_by_others_items); $j++) {?>
			    		<?if($j % 4 == 0){?><tr><?}?>
			    		
						<td align='center'>
							<table>

								<tr>
									<td align='center' width='180' height='200'>
										<a href='../item/view?item_id=<?=$trade_by_others_items[$j]->request_item_id?>'>
										<img src='../<?=$trade_by_others_items[$j]->request_item_upload_path?><?=$trade_by_others_items[$j]->request_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
										</a>
									</td>
								</tr>
								<tr>
									<td align='center'>
										<a href='../item/view?item_id=<?=$trade_by_others_items[$j]->request_item_id?>'>
										<?=$trade_by_others_items[$j]->request_item_name?>
										</a>
										<br/><?=$trade_by_others_items[$j]->request_item_address?>
									</td>
								</tr>

								<tr>
									<td align='center' colspan='2'>
										<!-- a href='#' onclick="acceptTrade('<?=$trade_by_others_items[$j]->trade_id?>');" class='btn btn-primary' style='width:78px;'>선택</a -->
										<a href='#' onclick="alert('준비중입니다.');" class='btn btn-primary' style='width:78px;'>선택</a>
										<a href='#' onclick="cancelTrade('<?=$trade_by_others_items[$j]->trade_id?>');" class='btn btn-danger' style='width:78px;'>취소</a>
									</td>	
								</tr>										
							</table>	
						</td>
						
			    		<?if($j % 4 == 3){?></tr><?}?>
					<?}?>
				</table>
		    </p>
		</div>   
	<?
	}
	?>
  	</form> 
@stop      