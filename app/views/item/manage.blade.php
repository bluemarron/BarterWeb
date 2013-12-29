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

	<form name='manage_form' id='manage_form' action='../item/manage' method='post' enctype='multipart/form-data'>
  	<div class='well'>
	    <p>
			<table class="table table-striped">
				<tr align='center'>
					<td>기능</td>
					<td>상품번호</td>
					<td>사진</td>
					<td>상품명</td>
					<td>대기수</td>
					<td>상태</td>
				</tr>
				<?for($j = 0; $j < sizeof($items); $j++) {?>
		    	<tr align='center'>
					<td align='center'>
						<p>[수정][삭제]</p>
						<p>[노출][복사]</p>
					</td>	
					<td>
						<?=$items[$j]->id?>	
					</td>
					<td align='center' width='80' height='100'>
						<img src='../<?=$items[$j]->upload_path?><?=$items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:60px;' />				
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
	
  	</form> 
@stop      