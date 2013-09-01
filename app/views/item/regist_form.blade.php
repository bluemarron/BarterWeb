@extends('layouts.master')

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

			for(var i = category_child_level; i <= 20; i++)
				$('#category_level_' + i).attr("style", "display:none");

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
						$('#category_level_' + category_child_level).empty();
						$('#category_level_' + category_child_level).append('<option value="">-- ' + category_child_level + '차 분류 --</option>');

						for(var i = 0; i < response.length; i++)
							$('#category_level_' + category_child_level).append('<option value="' + response[i].code + '">' + response[i].label + '</option>');
						
						$('#category_level_' + category_child_level).attr("style", "display:inline");
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

		function regist() {
			if(regist_form.name.value == '') {
				alert('상품명을 입력하세요.');
				regist_form.name.focus();
				return;
			}

			if(regist_form.address.value == '') {
				alert('주소를 입력하세요.');
				regist_form.address.focus();
				return;
			}

			regist_form.submit();
		}

		$(document).ready(function() {
			var defaultDescription = '* 상품상세설명 : 예) 동작 정상입니다. 깔끔합니다.' + '\r\n';
			defaultDescription += '* 원하는상품은 : 예) 아세아 관리기 또는 경운기입니다.' + '\r\n';
			defaultDescription += '* 생 산 년 도 : 예) 2000년 6월' + '\r\n';
			defaultDescription += '* 배 송 방 법 : 예) 착불배송/선불배송/오셔서 확인 후 거래 조건입니다.' + '\r\n\r\n';

			defaultDescription += '>> 위 내용은 예를 들어 설명한 것이며 필요 없을 시 삭제하셔도 됩니다.' + '\r\n';
			defaultDescription += '또한 개인 상세주소나 개인정보를 과다노출할 경우 범죄의 표적이 될 수 있으니 거래성사 후 알려주는 것이 안전합니다.' + '\r\n';
			defaultDescription += '명심하세요.';

			$("textarea#description").val(defaultDescription);

			$('input[id=file_1]').change(function() {
				$('#file_name_1').val($(this).val());
			});

			$('input[id=file_2]').change(function() {
				$('#file_name_2').val($(this).val());
			});
		});

		function previewImage(input, seq) {
			 if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#image_preview_' + seq).attr('src', e.target.result);
					$('#image_preview_' + seq).attr('style', 'opacity:');
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}
	</script>

	<script id='selected_category_template' class='template' type='text/x-jquery-tmpl'>
		<li id='selected_category_${code}' style='margin:0;padding:0;'>
			<input type='hidden' id='selected_category_codes[]' name='selected_category_codes[]' value='${code}' />
			<i class='icon-ok-sign'></i> ${full_label} <a href='javascript:cancelCategory("${code}");'><img src='../images/delete.png' border='0' align='absmiddle' style='margin-left:4px;margin-bottom:4px;' /></a>
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

	<form name='regist_form' id='regist_form' action='../item/regist' method='post' enctype='multipart/form-data'>
	<input type='hidden' id='selected_category_code' name='selected_category_code'>

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
						<a href='javascript:appendCategory();'><img src='../images/add.png' border='0' align='absmiddle' style='margin-left:4px;margin-bottom:10px;'></a> 
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
						<input type='text' name='name' id='name' class='input-xlarge' placeholder='상품명 입력' />
						<span style='padding-left:8px;'>(12자 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 주소</label>
						<input type='text' name='address' id='address' class='input-xlarge' placeholder='주소 입력' />
						<span style='padding-left:8px;'>(5자 이내로 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 사진</label>
						<p>
							<table>
								<tr align='center'>
									<td><img id='image_preview_1' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_2' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_3' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_4' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_5' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_6' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_7' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
									<td><img id='image_preview_8' src='../images/camera.png' border='0' align='absmiddle' style='width:120px;opacity:0.4;filter:alpha(opacity=40);' /></td>
								</tr>
								<tr align='center'>
									<?for($i = 1; $i <= 8; $i++){?>
										<td>
											<input type='file' name='image_<?=$i?>' id='image_<?=$i?>' style='display:none;' onchange='previewImage(this, <?=$i?>);' />
											<a class='btn btn-info' onclick='$("input[id=image_<?=$i?>]").click();'>등록</a>
										</td>
									<?}?>	
								</tr>
							</table>
						<p>
					</li>
 					<li> 
						<label><i class='icon-ok'></i> 첨부파일</label>

						<table>
							<tr>
								<td>
									<input type='text' name='file_description_1' id='file_description_1' class='input-xlarge' placeholder='파일설명' /> 
									&nbsp;
			 						<input type='file' name='file_1' id='file_1' style='display:none;' />

			 						<div class='input-append'>
										<input type='text' name='file_name_1' id='file_name_1' class='input-xlarge' />
										<a class='btn' onclick='$("input[id=file_1]").click();'>파일찾기</a>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<input type='text' name='file_description_2' id='file_description_2' class='input-xlarge' placeholder='파일설명' /> 
									&nbsp;
			 						<input type='file' name='file_2' id='file_2' style='display:none;' />

			 						<div class='input-append'>
										<input type='text' name='file_name_2' id='file_name_2' class='input-xlarge' />
										<a class='btn' onclick='$("input[id=file_2]").click();'>파일찾기</a>
									</div>
								</td>
							</tr>	
						</table>	
					</li>
 					<li> 
						<label><i class='icon-ok'></i> 검색단어</label>
						<input type='text' name='search_keyword' id='search_keyword' class='input-xlarge' placeholder='검색단어 입력' />
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
					    <textarea rows='12' id='description' name='description' class='span12' placeholder='설명을 입력하세요.'></textarea>
						<span style='padding-left:8px;'></span>
					</li>
				<ul>
			</fieldset>
		<p>
  	</div>  

  	<div align='center'>
   		<a href='javascript:regist();' class='btn btn-primary' style='width:78px;'>상품 등록</a>
	</div>  


  	</form> 
@stop      