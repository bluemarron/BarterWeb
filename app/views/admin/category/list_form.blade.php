@extends('layouts.admin_master')

@section('content')
	<script>
		// renderCategory (<- viewChild)
		function renderCategories(category_code, toggle_yn) { 		
  			var $child_category = $('#' + category_code + '_child');
  			var $folder_ico_img = $('#img_' + category_code);
  		
  			/*
  			if(toggle_yn == 'Y' && $('#img_' + category_code).attr('src') != undefined) {
				if($('#img_' + category_code).attr('src').indexOf('plus') > 0)
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
				url: './category_proc.php',
				data: {'mode':'view_child', 'category_code':category_code},
				cache: false,
				async: true,
				success: function(resp_data) {		
       				$child_category.empty();
       		
       				for(var i = 0; i < resp_data.length - 1; i++)
						$('#CategoryTempl').tmpl(resp_data[i]).clone().appendTo($child_category);
					
				  	$('#newCategoryTempl').tmpl(resp_data[resp_data.length - 1]).clone().appendTo($child_category);
				  	
				  if(resp_data.length == 1) 
				  	$('#folder_icon_' + category_code).html($('#folderIconWhiteBoxTempl').tmpl());
				}, failure: function(resp_data) {
					alert('¿À·ù°¡ ¹ß»ýÇÏ¿´½À´Ï´Ù.');					
				}
			});	
			*/
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
				<legend>카테고리 관리</legend>
				
			</fieldset>
		<p>
  	</div>

  	<script>
  		renderCategories('', 'Y');
  	</script>
@stop      