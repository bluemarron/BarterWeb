@extends('layouts.admin_master')

@section('content')
	<script>
		var message = '<?=$message?>';

		if(message != '')
			alert(message);

		/* Begin of Javascript HashMap */

		Map = function(){
			this.map = new Object();
		};   
		
		Map.prototype = {   
			put : function(key, value){   
			this.map[key] = value;
		},   
		
		get : function(key){   
			return this.map[key];
		},
		
		containsKey : function(key){    
			return key in this.map;
		},
		
		containsValue : function(value){    
			for(var prop in this.map){
				if(this.map[prop] == value) return true;
			}
			return false;
		},

		isEmpty : function(key){    
			return (this.size() == 0);
		},

		clear : function(){   
			for(var prop in this.map){
				delete this.map[prop];
			}
		},

		remove : function(key){    
			delete this.map[key];
		},
		
		keys : function(){   
			var keys = new Array();   
			for(var prop in this.map){   
				keys.push(prop);
			}   
			return keys;
		},

		values : function(){   
			var values = new Array();   
			for(var prop in this.map){   
				values.push(this.map[prop]);
			}   
			return values;
		},

		size : function(){
			var count = 0;
			for (var prop in this.map) {
				count++;
			}
			return count;
			}
		};

		/* End of Javascript HashMap */

		var selectedCategories = new Map();

		function renderChildCategories(category_level) {
			var code = $('#category_level_' + category_level + ' option:selected').val();
			$('#selected_category_code').val(code);

			var category_child_level = Number(category_level) + 1;

			for(var i = category_child_level + 1; i <= 20; i++) 						
				$('#category_level_' + i).empty().attr("style", "display:none");

			if(code == '')
				return;
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../category/get_child',
				data: {'code':code},
				cache: false,
				async: true,
				success: function(response) {
					if(response.length > 0) {
						var options = '<option value="">-- ' + category_child_level + '차 분류 --</option>';

						for(var i = 0; i < response.length; i++)
							options += '<option value="' + response[i].code + '">' + response[i].label + '</option>';

					 	$('#category_level_' + category_child_level).attr("style", "display:inline").empty().html(options);
					} else {
						for(var i = category_child_level; i <= 20; i++)
							$('#category_level_' + i).empty().attr("style", "display:none");
					}
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');					
				}
			});
		}

		function appendCategory() {
			var code = $('#selected_category_code').val();

			if(code == '')
				return;

			if(selectedCategories.containsKey(code)) {
				alert('이미 추가하신 카테고리입니다.');
				return;
			}

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../category/get_full_label',
				data: {'code':code},
				cache: false,
				async: true,
				success: function(response) {
					selectedCategories.put(code, response.full_label);
					displaySelectedCategories();
				}, failure: function(response) {
					alert('일시적인 시스템 오류가 발생하였습니다.');					
				}
			});			 
		}

		function cancelCategory(code) {
			selectedCategories.remove(code);
			displaySelectedCategories();
		}

		function displaySelectedCategories() {
			$('#selected_categories').empty();

			var keys = selectedCategories.keys();

			for(var i = 0; i < keys.length; i++) {
				var selected_category = {'code': keys[i], 'full_label': selectedCategories.get(keys[i])};
				$('#selected_category_template').tmpl(selected_category).appendTo('#selected_categories');
			}
		}

		function modify() {
			if(selectedCategories.keys().length == 0) {
				alert('카테고리를 선택하신 후 [추가] 버튼을 클릭하세요.');
				modify_form.category_level_1.focus();
				return;
			}


			if(modify_form.name.value == '') {
				alert('상품명을 입력하세요.');
				modify_form.name.focus();
				return;
			}

			if(modify_form.address.value == '') {
				alert('주소를 입력하세요.');
				modify_form.address.focus();
				return;
			}

			modify_form.submit();
		}

		$(document).ready(function() {
			<?for($i = 0; $i < sizeof($item_categories); $i++) {?>
				selectedCategories.put('<?=$item_categories[$i]->code?>', '<?=$item_categories[$i]->full_label?>');
				displaySelectedCategories();
			<?}?>
		});

		function previewImage(input, seq) {
			 if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#image_preview_' + seq).attr('src', e.target.result);
					$('#image_preview_' + seq).attr('style', 'width:95px;opacity:');
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}
	</script>

	<script id='selected_category_template' class='template' type='text/x-jquery-tmpl'>
		<li id='selected_category_${code}' style='margin:0;padding:0;'>
			<input type='hidden' id='selected_category_codes[]' name='selected_category_codes[]' value='${code}' />
			<i class='icon-ok-sign'></i> ${full_label} 

			<a href='javascript:cancelCategory("${code}");' class='btn btn-danger' style='width:30px;margin-left:4px;margin-bottom:4px;'>삭제</a>
		<li>
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

  	<form name='modify_form' id='modify_form' action='../item/modify' method='post' enctype='multipart/form-data'>
	<input type='hidden' id='selected_category_code' name='selected_category_code'>
	<input type='hidden' id='item_id' name='item_id' value='<?=$item->id?>'>

  	<div class='well'>
	    <p>
			<fieldset>
				<legend>상품 카테고리</legend>

				<ul id='selected_categories'></ul>

				<ul>
					<li>
						<?for($i = 1; $i <= 20; $i++) {?>
							<?if($i == 1){?>
								<select id='category_level_<?=$i?>' name='category_level_<?=$i?>' class='span2' style='display:inline;' onchange='renderChildCategories("<?=$i?>");'>
									<option value=''>-- <?=$i?>차 분류 --</option>
									<?for($j = 0; $j < sizeof($categories); $j++) {?>
										<option value='<?=$categories[$j]->code?>'><?=$categories[$j]->label?></option>
									<?}?>
								</select>
							<?} else {?>
								<select id='category_level_<?=$i?>' name='category_level_<?=$i?>' class='span2' style='display:none;' onchange='renderChildCategories("<?=$i?>");'>
								</select>							
							<?}?>
						<?}?>
						<a href='javascript:appendCategory();' class='btn btn-success' style='width:30px;margin-bottom:10px;'>추가</a>
					</li>
				</ul>		
			</fieldset>
		<p>
  	</div>
	<div class='well'>
	    <p>
			<fieldset>
				<legend>상품 기본정보</legend>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 상품명</label>
						<input type='text' name='name' id='name' value='<?=$item->name?>' class='input-xlarge' placeholder='상품명 입력' />
						<span style='padding-left:8px;'>(12자 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 주소</label>
						<input type='text' name='address' id='address' value='<?=$item->address?>' class='input-xlarge' placeholder='주소 입력' />
						<span style='padding-left:8px;'>(5자 이내로 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 사진</label>
						<p>
							<table>
								<tr align='left'>
									<?for($i = 1; $i <= 4; $i++) {?>
										<td width='140'>
											<?if($item_images[$i-1]->seq == $i) {?>
												<img id='image_preview_<?=$i?>' src='../<?=$item_images[$i-1]->upload_path?><?=$item_images[$i-1]->physical_image_name?>' border='0' align='absmiddle' style='width:95px;' />
											<?}else{?>
												<img id='image_preview_<?=$i?>' src='../images/camera.png' border='0' align='absmiddle' style='width:95px;opacity:0.4;filter:alpha(opacity=40);' />
											<?}?>	
										</td>
									<?}?>	
								</tr>
								<tr align='left'>
									<?for($i = 1; $i <= 4; $i++){?>
										<td>
											<input type='file' name='image_<?=$i?>' id='image_<?=$i?>' style='width:95px;' onchange='previewImage(this, <?=$i?>);' />
										</td>
									<?}?>	
								</tr>
								<tr><td height='5' colspan'4'></td></tr>
								<tr align='left'>
									<?for($i = 5; $i <= 8; $i++) {?>
										<td width='140'>
											<?if($item_images[$i-1]->seq == $i) {?>
												<img id='image_preview_<?=$i?>' src='../<?=$item_images[$i-1]->upload_path?><?=$item_images[$i-1]->physical_image_name?>' border='0' align='absmiddle' style='width:95px;' />
											<?}else{?>
												<img id='image_preview_<?=$i?>' src='../images/camera.png' border='0' align='absmiddle' style='width:95px;opacity:0.4;filter:alpha(opacity=40);' />
											<?}?>	
										</td>
									<?}?>	
								</tr>
								<tr align='left'>
									<?for($i = 5; $i <= 8; $i++){?>
										<td>
											<input type='file' name='image_<?=$i?>' id='image_<?=$i?>' style='width:95px;' onchange='previewImage(this, <?=$i?>);' />
										</td>
									<?}?>	
								</tr>

							</table>
						<p>
					</li>
 					<li> 
						<label>첨부파일</label>
						<table>
							<?for($i = 1; $i <= 2; $i++){?>
							<tr>
								<td>
									<?if($item_files[$i-1]->seq == $i) {?>
										<input type='text' name='file_description_<?=$i?>' id='file_description_1' value='<?=$item_files[$i-1]->description?>' class='input-xlarge' placeholder='파일설명' /> 
										&nbsp;&nbsp;
				 						<input type='file' name='file_<?=$i?>' id='file_<?=$i?>' style='display:block;width:237px;' />
				 						<br>
				 						<a href='../../<?=$item_images[$i-1]->upload_path?><?=$item_images[$i-1]->physical_image_name?>'><?=$item_files[$i-1]->original_file_name?></a>
				 					<?}else{?>
										<input type='text' name='file_description_<?=$i?>' id='file_description_1' class='input-xlarge' placeholder='파일설명' /> 
										&nbsp;&nbsp;
				 						<input type='file' name='file_<?=$i?>' id='file_<?=$i?>' style='display:block;width:237px;' />
				 					<?}?>	
								</td>
							</tr>
							<?}?>
						</table>	
					</li>
 					<li> 
						<label>검색단어</label>
						<input type='text' name='search_keyword' id='search_keyword' value='<?=$item->search_keyword?>' class='input-xlarge' placeholder='검색단어 입력' />
						<span style='padding-left:8px;'>(콤마로 구분하여 입력하세요.)</span>
					</li>
				<ul>
			</fieldset>
		<p>
  	</div>
	<div class='well'>
   		<p>
			<fieldset>
				<legend>상품 상세정보</legend>
				<ul>
					<li> 
					    <textarea rows='12' id='description' name='description' class='span12' placeholder='설명을 입력하세요.'><?=$item->description?></textarea>
						<span style='padding-left:8px;'></span>
					</li>
				<ul>
			</fieldset>
		<p>
  	</div>  

  	<div align='center'>
   		<a href='javascript:modify();' class='btn btn-primary' style='width:78px;'>상품 수정</a>
	</div>  

  	</form> 

  	<script>
  		renderCategories('', 'Y');
  	</script>
@stop      