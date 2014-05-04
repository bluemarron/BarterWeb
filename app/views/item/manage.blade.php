@extends('layouts.master')

@section('content')
	<script>
		function deleteItem(item_id) { 
			if(!confirm('선택하신 상품을 삭제하시겠습니까?')) 
				return;

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../item/delete',
				data: {'item_id':item_id},
				cache: false,
				async: true,
				success: function(response) {
					window.location.reload(true);
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}

		function copyItem(item_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../item/copy',
				data: {'item_id':item_id},
				cache: false,
				async: true,
				success: function(response) {
					window.location.reload(true);
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}

		function displayItem(item_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../item/display',
				data: {'item_id':item_id},
				cache: false,
				async: true,
				success: function(response) {
					window.location.reload(true);
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');
				}
			});	
		}

		function hideItem(item_id) { 
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../item/hide',
				data: {'item_id':item_id},
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

	<form name='manage_form' id='manage_form' action='../item/manage' method='post' enctype='multipart/form-data'>
  	<div class='well'>
	    <p>
			<table class="table table-striped">
				<tr>
					<td style='text-align:center'>기능</td>
					<td style='text-align:center'>상품번호</td>
					<td style='text-align:center'>사진</td>
					<td style='text-align:center'>상품명</td>
					<td style='text-align:center'>대기수</td>
					<td style='text-align:center'>노출여부</td>
				</tr>
				<?for($j = 0; $j < sizeof($items); $j++) {?>
		    	<tr>
					<td style='text-align:center'>
						<p> 
							<a href='../item/modify_form?item_id=<?=$items[$j]->id?>' class='btn btn-warning' style='width:30px;'>수정</a>
							<a href='#' onclick="deleteItem('<?=$items[$j]->id?>');" class='btn btn-danger' style='width:30px;'>삭제</a>
						</p>
						<p>
							<?if($items[$j]->display_yn == 'N'){?>
								<a href='#' onclick="displayItem('<?=$items[$j]->id?>');" class='btn btn-success' style='width:30px;'>노출</a>
							<?} else {?>
								<a href='#' onclick="hideItem('<?=$items[$j]->id?>');" class='btn btn-inverse' style='width:30px;'>숨김</a>
							<?}?>	
							<a href='#' onclick="copyItem('<?=$items[$j]->id?>');" class='btn btn-primary' style='width:30px;'>복사</a>
						</p>	
					</td>	
					<td style='text-align:center'>
						<?=$items[$j]->id?>	
					</td>
					<td style='text-align:center' width='80' height='100'>
						<img src='../<?=$items[$j]->upload_path?><?=$items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:60px;' />				
					</td>
					<td style='text-align:center'>
						<?=$items[$j]->name?>
					</td>
					<td style='text-align:center'>
						0
					</td>
					<td style='text-align:center'>
						<?=$items[$j]->display_yn?>
					</td>	
		    	</tr>
				<?}?>
			</table>
		<p>
  	</div>
	
  	</form> 
@stop      