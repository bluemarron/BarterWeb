@extends('layouts.master')

@section('content')

	<script>
		function save() {
			if(form.subject.value == "") {
				alert("제목을 입력하세요.");
				form.subject.focus();
				return;
			}

			if(form.subject.value == "") {
				alert("제목을 입력하세요.");
				form.subject.focus();
				return;
			}

			if(form.content.value == "") {
				alert("내용을 입력하세요.");
				form.content.focus();
				return;
			}
				
			form.submit();
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
			<form name="form" id="form" action="../board/modify" method="post">
		    	<input type="hidden" id="id" name="id" value="<?=$free_posting->id?>">
				<fieldset>
				    <label><i class="icon-ok"></i> 작성자</label>
				    <?=$member_id?>
				</fieldset>

				<fieldset>
				    <label><i class="icon-ok"></i> 제목</label>
				    <input type="text" id="subject" name="subject" value="<?=$free_posting->subject?>" class="span12" placeholder="제목을 입력하세요.">
				</fieldset>
				  
				<fieldset>
				    <label><i class="icon-ok"></i> 내용</label>
				    <textarea rows="12" id="content" name="content" class="span12" placeholder="내용을 입력하세요."><?=$free_posting->content?></textarea>
				</fieldset>
			</form>
		</p>
    	<p>
	    	<div align="left">
					<a href="javascript:save();" class="btn btn-primary">저장</a>
					<a href="../board/posting_list" class="btn">취소</a>
			</div>	
	    </p>
  	</div>
@stop      