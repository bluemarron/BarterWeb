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

	<form name='login_form' id='login_form' action='../member/login' method='post'>
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

				<!-- <form name='login_form' id='login_form' action='../member/login' method='post'>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 아이디</label>
						<input type='text' name='member_id' id='member_id' class='input-small' placeholder='아이디 입력' />
						<span style='padding-left:8px;'>(회원가입시 등록하신 핸드폰 번호 숫자를 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 비밀번호</label>
						<input type='password' name='passwd' id='passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li>
						<label></label>
						<a href='javascript:login();' class='btn btn-primary' style='width:78px;'>로그인</a>
						<span style='padding-left:8px;color:red;'></span>
					</li>
				<ul>
				</form> -->
			</fieldset>
		<p>
  	</div>
	<div class='well'>
	    <p>
			<fieldset>
				<legend>상품 기본정보</legend>
<!-- 				<form name='regist_form' id='regist_form' action='../member/regist' method='post'>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 아이디</label>
						<input type='text' name='member_id' id='member_id' class='input-small' placeholder='아이디 입력' />
						<span style='padding-left:8px;'>(핸드폰 번호 숫자만 입력하세요. 거래할때 사용되는 연락처이므로 중요합니다.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 비밀번호</label>
						<input type='password' name='passwd' id='passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'>(4자~15자 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 비밀번호 확인</label>
						<input type='text' name='re_passwd' id='re_passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'>(비밀번호 분실시 SMS 충전건수가 있을 경우에만 발송됩니다.</span>
					</li>

					<li>
						<label></label>
						<a href='javascript:regist();' class='btn btn-primary' style='width:78px;'>가입 완료</a>
						<span style='padding-left:8px;color:red;'>* 가입 완료 클릭시 아이디 중복검사 후 가입이 승인됩니다.</span>
					</li>
				<ul>
				</form> -->
			</fieldset>
		<p>
  	</div>
	<div class='well'>
   		<p>
			<fieldset>
				<legend>상품 상세정보</legend>
<!-- 				<form name='find_passwd_form' id='find_passwd_form' action='../member/find_passwd' method='post'>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 아이디</label>
						<input type='text' name='member_id' id='member_id' class='input-small' placeholder='아이디 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li>
						<label></label>
						<a href='javascript:find_passwd();' class='btn btn-primary' style='width:78px;'>SMS 발송</a>
						<span style='padding-left:8px;color:red;'>* 비밀번호 SMS 발송은 24시간 주기로 한번만 발송되오니 주의하세요.</span>
					</li>
				<ul>
				</form> -->
			</fieldset>
		<p>
  	</div>  

  	</form> 
@stop      