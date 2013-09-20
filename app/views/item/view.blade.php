@extends('layouts.master')

@section('content')
	
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
									<a href='#' class='btn btn-success' style='width:78px;'>관싱 상품</a>
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
										<a href='#' class='btn btn-primary' style='width:78px;'>선택</a>
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
  	</form> 
@stop      