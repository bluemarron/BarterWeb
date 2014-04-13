@extends('layouts.admin_master')

@section('content')
  	<?
    echo HTML::style('assets/css/jquery.cleditor.css');
    echo HTML::script('assets/js/jquery.cleditor.js');
	?>
	<script type="text/javascript">
    	$(document).ready(function () { $("#description").cleditor(); });
  	</script>
	<script>
		var message = '<?=$message?>';

		if(message != '')
			alert(message);

		function modify() {
			//alert(modify_form.description.value);
			alert("테스트중입니다.");
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