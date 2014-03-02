@extends('layouts.admin_master')
@extends('layouts.admin_master')

@section('content')
	<script>
		function deleteItem(item_id) { 
			if(!confirm('선택하신 상품을 삭제하시겠습니까?')) 
				return;

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../../admin/item/delete',
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
			padding-bottom:0px;
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
			<fieldset>
				<legend>상품 관리</legend>
			<fieldset>
		</p>	  		
	    <p>
	    	<table class="table table-striped">
				<tr align='center'>
					<td>기능</td>
					<td>아이디</td>
					<td>상품번호</td>
					<td>사진</td>
					<td>상품명</td>
					<td>대기수</td>
					<td>상태</td>
				</tr>
				<?for($j = 0; $j < sizeof($items); $j++) {?>
		    	<tr align='center'>
					<td align='center'>
						<p>
							<!--<a href='../../admin/item/modify_form?item_id=<?=$items[$j]->id?>' class='btn btn-warning' style='width:30px;'>수정</a>-->
							<a href='#' onclick="alert('준비중입니다.');" class='btn btn-warning' style='width:30px;'>수정</a>
							<a href='#' onclick="deleteItem('<?=$items[$j]->id?>');" class='btn btn-danger' style='width:30px;'>삭제</a>
						</p>
						<p>
							<a href='#' onclick="alert('준비중입니다.');" class='btn btn-success' style='width:30px;'>노출</a>
							<a href='#' onclick="alert('준비중입니다.');" class='btn btn-primary' style='width:30px;'>복사</a>
						</p>						
					</td>	
					<td>
						<?=$items[$j]->member_id?>	
					</td>	
					<td>
						<?=$items[$j]->id?>	
					</td>
					<td align='center' width='80' height='100'>
						<img src='../../<?=$items[$j]->upload_path?><?=$items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:60px;' />				
					</td>
					<td align='center'>
						<?=$items[$j]->name?>
					</td>
					<td>
						0
					</td>
					<td>
						노출
					</td>	
		    	</tr>
				<?}?>
			</table>
		<p>
  	</div>

  	<script>
  		renderCategories('', 'Y');
  	</script>
@stop      