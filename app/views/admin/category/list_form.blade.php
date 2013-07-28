@extends('layouts.admin_master')

@section('content')
	<script>
		// renderCategory (<- viewChild)
		function renderCategories(code, toggle_yn) { 	
			var $child_category = $('#' + code + '_child');
  			var $folder_ico_img = $('#img_' + code);
  		
  			if(toggle_yn == 'Y' && $('#img_' + code).attr('src') != undefined) {
				if($('#img_' + code).attr('src').indexOf('plus') > 0)
				{
					$folder_ico_img.attr('src', $folder_ico_img.attr('src').replace('plus', 'minus'));
					$child_category.attr('style', 'display:block');
				} else {
					$folder_ico_img.attr('src', $folder_ico_img.attr('src').replace('minus', 'plus'));
					$child_category.attr('style', 'display:none');
					return;
				}
			}
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../../admin/category/get_child',
				data: {'code':code},
				cache: false,
				async: true,
				success: function(response) {
					$child_category.empty();
   
       				for(var i = 0; i < response.length - 1; i++) {
    					if(response[i].has_child) {
							$('#category_has_child_template').tmpl(response[i]).clone().appendTo($child_category);
						} else {
							$('#category_no_child_template').tmpl(response[i]).clone().appendTo($child_category);
						}
					}
			
				  	$('#new_category_template').tmpl(response[response.length - 1]).clone().appendTo($child_category);
				  	
				  	if(response.length == 1) 
				  		$('#folder_icon_' + code).html($('#folder_icon_white_box_template').tmpl());
					
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');					
				}
			});
  		}		
	</script>

	<script id='category_has_child_template' type='text/x-jquery-tmpl'>
		<div style='margin-top:4px;margin-left:${code.length + 10}px;'>
			<span id='folder_icon_${code}'>
				<a href='javascript:renderCategories("${code}", "Y");'><img id='img_${code}' src='../../images/folder_plus.gif' border='0' align='absmiddle'></a> 
			</span>
			
			<input type='text' id='label_${code}' name='label_${code}' value='${label}' style='width:120px;background-color:${bgcolor}' onKeyUp='enterKeyForUpdate("${code}");'>					
			<input type='text' id='position_${code}' name='position_${code}' value='${position}' style='width:14px;text-align:right;background-color:#ffff96' onKeyUp='enterKeyForUpdate("${code}");'>					
			<span title="${code}">(${short_code})</span>
			<a href='javascript:updateCategory("${code}");'><img src='../../images/save.png' border='0' align='absmiddle'></a> 
			<a href='javascript:deleteCategory("${code}");'><img src='../../images/delete.png' border='0' align='absmiddle'></a> 
			<a href='javascript:renderCategories("${code}", "Y");'><img src='../../images/add_child.png' border='0' width='18' align='absmiddle'></a>
		</div>
		<div id="${code}_child">
		</div>
	</script>

	<script id='category_no_child_template' type='text/x-jquery-tmpl'>
		<div style='margin-top:4px;margin-left:${code.length + 10}px;'>
			<span id='folder_icon_${code}'>
				<!--<img src='../../images/white_box.gif' border='0' align='absmiddle'>-->
				&nbsp;&nbsp;
			</span>
			
			<input type='text' id='label_${code}' name='label_${code}' value='${label}' style='width:120px;background-color:${bgcolor}' onKeyUp='enterKeyForUpdate("${code}");'>					
			<input type='text' id='position_${code}' name='position_${code}' value='${position}' style='width:14px;text-align:right;background-color:#ffff96' onKeyUp='enterKeyForUpdate("${code}");'>					
			<span title="${code}">(${short_code})</span>
			<a href='javascript:updateCategory("${code}");'><img src='../../images/save.png' border='0' align='absmiddle'></a> 
			<a href='javascript:deleteCategory("${code}");'><img src='../../images/delete.png' border='0' align='absmiddle'></a> 
			<a href='javascript:renderCategories("${code}", "Y");'><img src='../../images/add_child.png' border='0' width='18' align='absmiddle'></a>
		</div>
		<div id="${code}_child">
		</div>
	</script>

	<script id='new_category_template' type='text/x-jquery-tmpl'>
		<div style='margin-top:4px;margin-left:${code.length + 10}px;'>
			<span id='folder_icon_${code}'>
				<!--<img src='../../images/white_box.gif' border='0' align='absmiddle'>-->
				&nbsp;&nbsp;
			</span>	
			<input type='text' id='label_${code}' name='label_${code}' value='' style='width:120px;background-color:#ffffff' onKeyUp='enterKeyForAdd('${code}');'>
			<input type='text' id='position_${code}' name='position_${code}' value='${position}' style='width:14px;text-align:right;background-color:#ffff96' onKeyUp='enterKeyForAdd('${code}');'>					
			(${short_code})
			<a href='javascript:addCategory("${code}");'><img src='../../images/add.png' border='0' align='absmiddle'></a> 
		<div>
	</script>	

	<script id='folder_icon_white_box_template' type='text/x-jquery-tmpl'>
		<!--<img src='../../images/white_box.gif' border='0' align='absmiddle'>-->
		&nbsp;&nbsp;
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
				<legend>카테고리 관리</legend>
				<form name='form' id='form' method='post'>
					<div id='_child'></div>

				</form>
			</fieldset>
		<p>
  	</div>

  	<script>
  		renderCategories('', 'Y');
  	</script>
@stop      