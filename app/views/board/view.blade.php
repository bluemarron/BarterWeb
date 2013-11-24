@extends('layouts.master')

@section('content')
	<script>
		function delete_article(id) {
			if(confirm('정말 삭제하시겠습니까?')) {
				location.href='../board/delete?id='+id;
			}
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
			<fieldset>
				<legend>게시판</legend>
			<fieldset>
		</p>		
		<p>					
			<fieldset>
			   	<label><i class="icon-ok"></i> 작성자</label>
				<?=$free_posting->member_id?>
			</fieldset>    	
			<fieldset>
			   	<label><i class="icon-ok"></i> 제목</label>
			   	<?=$free_posting->subject?>
			</fieldset>
			<fieldset>
		    	<label><i class="icon-ok"></i> 내용</label>
		   		<?=nl2br($free_posting->content)?>
		    </fieldset>
		</p>
    	<p>
	    	<div align="left">
				<a href="../board/posting_list" class="btn">목록</a>
    			<a href="../board/posting_modify_form?id=<?=$free_posting->id?>" class="btn btn-warning">수정</a>
    			<a href="javascript:delete_article('<?=$free_posting->id?>');" class="btn btn-danger">삭제</a>
			</div>	
	    </p>
  	</div>
@stop      