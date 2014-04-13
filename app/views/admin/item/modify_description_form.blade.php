@extends('layouts.admin_master')

@section('content')
    <?
    echo HTML::style('assets/css/smart_editor2_in.css');

	?>	
	<script>
		var message = '<?=$message?>';

		if(message != '')
			alert(message);

		function modify() {
			// modify_form.submit();
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
<body class="smartOutput se2_inputarea">
	<p>
		<b><u>에디터 내용:</u></b>
	</p>

	<div style="width:736px;">
	<?php
		// $postMessage = $_POST["ir1"]; 
		// echo $postMessage;
	?>
	</div>
	
	<hr>
	<p>
		<b><span style="color:#FF0000">주의: </span>sample.php는 샘플 파일로 정상 동작하지 않을 수 있습니다. 이 점 주의바랍니다.</b>
	</p>
	
	<?php echo(htmlspecialchars_decode('&lt;img id="test" width="0" height="0"&gt;'))?>
	
<script>
	if(!document.getElementById("test")) {
		alert("PHP가 실행되지 않았습니다. 내용을 로컬 파일로 전송한 것이 아니라 서버로 전송했는지 확인 해 주십시오.");
	}
</script>


  	<form name='modify_form' id='modify_form' action='../../admin/item/modify_description' method='post' enctype='multipart/form-data'>

	<div class='well'>
   		<p>
			<fieldset>
				<legend>상품 상세정보</legend>
				<ul>
					<li> 
					    <textarea rows='12' id='description' name='description' class='span12' placeholder='설명을 입력하세요.'><?=$management->default_item_description?></textarea>
						<span style='padding-left:8px;'></span>
					</li>
				<ul>
			</fieldset>
		<p>
  	</div>  

  	<div align='center'>
   		<a href='javascript:modify();' class='btn btn-primary' style='width:78px;'>수정</a>
	</div>  

  	</form> 
@stop      