@extends('layouts.admin_master')

@section('content')
	<script>
			
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
				<legend>회원 관리</legend>
			<fieldset>
		</p>	  		
	    <p>
	    	<table class="table table-striped">
				<tr align='center'>
					<td>가입일시</td>
					<td>아이디</td>
					<td>이름</td>
					<td>은행</td>
					<td>계좌</td>
					<td>담보금</td>
					<td>환급액</td>
					<td>SMS 한도</td>
					<td>SMS 승인</td>
					<td>선택</td>
				</tr>
				<?for($j = 0; $j < sizeof($members); $j++) {?>
		    	<tr align='center'>
					<td>
						<?=$members[$j]->created_at?>	
					</td>	
					<td>
						<?=$members[$j]->member_id?>	
					</td>
					<td>
						홍길동
					</td>					
					<td align='center'>
						농협
					</td>
					<td align='center'>
						111122223333
					</td>
					<td>
						6,000
					</td>
					<td>
						1,000,000
					</td>
					<td>
						500,000
					</td>
					<td align='center'>
						<p>[승인]</p>
						<p>[대기]</p>
					</td>	
					<td align='center'>
						<p>[완료]</p>
						<p>[취소]</p>
						<p>[삭제]</p>
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