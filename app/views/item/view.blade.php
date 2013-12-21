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
					alert('거래를 신청하였습니다.');
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
					alert('거래를 선택하였습니다.');
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
					alert('거래를 취소하였습니다.');
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
	    <p>
	    	<table width='100%' align='center'>
	    		<tr valign='top'>
					<td align='center' width='370'>
						<table>
							<tr>
								<td>
									<img src='../<?=$item->upload_path?><?=$item->physical_image_name?>' border='0' align='absmiddle' style='width:350px;' />
								</td>
							</tr>
							<tr><td height='5'></td></tr>
							<tr>
								<td>			
							    	<table align='center' cellspacing='2'>
								    	<?for($j = 0; $j < 8; $j++) {?>
								    		<?if($j % 4 == 0){?><tr><?}?>
											<td align='center' width='85'>
												<?if(sizeof($item_images) > $j) {?>
													<img src='../<?=$item_images[$j]->upload_path?><?=$item_images[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:80px;' />	
												<?}else{?>
													<img src='../images/camera.png' border='0' align='absmiddle' style='width:80px;opacity:0.2;filter:alpha(opacity=40);' />
												<?}?>	
											</td>
								    		<?if($j % 4 == 3){?></tr><?}?>
										<?}?>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td align='center'>
						<table>
							<tr>
								<td colspan='2'>
									<i class='icon-asterisk'></i> 상품번호 : <strong><?=str_pad($item->id, 6, "0", STR_PAD_LEFT)?></strong>
									<i class='icon-asterisk'></i> 등록일자 : <?=date('Y-m-d', strtotime($item->created_at))?>
								</td>	
							</tr>
							<tr>
								<td colspan='2'>
									<h3><font color='red'><?=$item->name?></font></h3>
								</td>	
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</td>
								<td>: <?=$item->address?></td>
							</tr>	
							<tr>
								<td width='75'><i class='icon-ok'></i> 등록상품</td>
								<td>: 00개</td>
							</tr>	
							<tr>
								<td width='75'><i class='icon-ok'></i> 대기상품</td>
								<td>: 00개</td>
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 거래진행</td>
								<td>: 00개</td>
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 거래완료</td>
								<td>: 00개</td>
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 거래취소</td>
								<td>: 00개</td>
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 미결상품</td>
								<td>: 00개</td>
							</tr>
							<tr>
								<td width='75'><i class='icon-ok'></i> 담보금액</td>
								<td>: 50,000원</td>
							</tr>
							<tr>
								<td height='20' colspan='2'></td>	
							</tr>	
							<tr>
								<td align='center' colspan='2'>
									<a href='#' class='btn btn-success' style='width:78px;'>관심 상품</a>
								</td>	
							</tr>							
						</table>	
					</td>
				</tr>	
			</table>
		<p>
  	</div>
	
	<div class='well'>
		<p><i class='icon-asterisk'></i> 상품설명</p>
	    <p><?=nl2br($item->description)?></p>
	</div>   
	<?if($member_id != '' && $member_id != $item_member_id){?>
		<?if(sizeof($my_items) > 0) {?>
			<div class='well'>
				<p><i class='icon-asterisk'></i> 거래하실 자신의 상품을 [선택]하세요. 중복으로 [선택] 가능합니다.</p>
			    <p>
					<table>
				    	<?for($j = 0; $j < sizeof($my_items); $j++) {?>
				    		<?if($j % 4 == 0){?><tr><?}?>
							<td align='center'>
								<table>
									<tr>
										<td align='center' width='180' height='200'>
											<a href='../item/view?item_id=<?=$my_items[$j]->id?>' target='_blank'>
											<img src='../<?=$my_items[$j]->upload_path?><?=$my_items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
											</a>
										</td>
									</tr>
									<tr>
										<td align='center'>
											<a href='../item/view?item_id=<?=$my_items[$j]->id?>' target='_blank'>
											<?=$my_items[$j]->name?>
											</a>
											<br/><?=$my_items[$j]->address?>
										</td>
									</tr>
									<tr>
										<td align='center' colspan='2'>
											<a href='#' onclick="requestTrade('<?=$item->member_id?>', '<?=$my_items[$j]->id?>', '<?=$item->id?>');" class='btn btn-primary' style='width:78px;'>선택</a>
										</td>	
									</tr>	
								</table>	
							</td>
				    		<?if($j % 4 == 3){?></tr><?}?>
						<?}?>
					</table>
			    </p>
			</div>   
		<?}?>	
	<?} else {?>
		<?if(sizeof($trade_items) > 0) {?>
			<div class='well'>
				<p><i class='icon-asterisk'></i>
				<?if($member_id != ''){?>
					아래 상품은 거래 신청 물품입니다. 선택하신 후 연락하세요.
				<?} else {?>	
					아래 상품은 물물교환 대기 중입니다. 위 상품고객은 거래선택하세요.
				<?}?>	
				</p>
			    <p>
					<table>
				    	<?for($j = 0; $j < sizeof($trade_items); $j++) {?>
				    		<?if($j % 4 == 0){?><tr><?}?>
				    		
							<td align='center'>
								<table>

									<tr>
										<td align='center' width='180' height='200'>
											<a href='../item/view?item_id=<?=$trade_items[$j]->request_item_id?>' target='_blank'>
											<img src='../<?=$trade_items[$j]->request_item_upload_path?><?=$trade_items[$j]->request_item_physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
											</a>
										</td>
									</tr>
									<tr>
										<td align='center'>
											<a href='../item/view?item_id=<?=$trade_items[$j]->request_item_id?>' target='_blank'>
											<?=$trade_items[$j]->request_item_name?>
											</a>
											<br/><?=$trade_items[$j]->request_item_address?>
										</td>
									</tr>

									<?if($member_id != ''){?>
										<tr>
											<td align='center' colspan='2'>
												<?if($trade_items[$j]->status == 'REQUEST'){?>
													<a href='#' onclick="acceptTrade('<?=$trade_items[$j]->trade_id?>');" class='btn btn-primary' style='width:78px;'>선택</a>
												<?} else if($trade_items[$j]->status == 'ACCEPT'){?>
													<a href='#' onclick="cancelTrade('<?=$trade_items[$j]->trade_id?>');" class='btn btn-danger' style='width:78px;'>취소</a>
												<?}?>	
											</td>	
										</tr>										
									<?}?>
								</table>	
							</td>
							
				    		<?if($j % 4 == 3){?></tr><?}?>
						<?}?>
					</table>
			    </p>
			</div>   
		<?}?>
	<?}?>
  	</form> 
@stop      