@extends('layouts.master')

@section('content')
	<script>
		var message = "<?=$message?>";

		if(message != "")
			alert(message);

		function login() {
			if(login_form.member_id.value == "") {
				alert("아이디를 입력하세요.");
				login_form.member_id.focus();
				return;
			}

			if(login_form.passwd.value == "") {
				alert("비밀번호를 입력하세요.");
				login_form.passwd.focus();
				return;
			}
				
			login_form.submit();
		}

		function regist() {
			if(regist_form.member_id.value == "") {
				alert("아이디를 입력하세요.");
				regist_form.member_id.focus();
				return;
			}

			if(regist_form.passwd.value == "") {
				alert("비밀번호를 입력하세요.");
				regist_form.passwd.focus();
				return;
			}

			if(regist_form.re_passwd.value == "") {
				alert("확인용 비밀번호를 입력하세요.");
				regist_form.re_passwd.focus();
				return;
			}


			if(regist_form.passwd.value != regist_form.re_passwd.value) {
				alert("비밀번호가 일치하지 않습니다. 비밀번호를 다시 입력하세요.");
				regist_form.re_passwd.focus();
				return;
			}

			regist_form.submit();
		}


		function find_passwd() {
			if(find_passwd_form.member_id.value == "") {
				alert("아이디를 입력하세요.");
				find_passwd_form.member_id.focus();
				return;
			}

			alert("서비스 준비중입니다.");
			
			//find_passwd_form.submit();
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

  	<div class="well">
	    <p>
			<fieldset>
				<legend>로그인</legend>
				<form name="login_form" id="login_form" action="../member/login" method="post">
				<ul>
					<li> 
						<label><i class="icon-ok"></i> 아이디</label>
						<input type="text" name="member_id" id="member_id" class="input-small" placeholder="아이디 입력" />
						<span style="padding-left:8px;">(회원가입시 등록하신 핸드폰 번호 숫자를 입력하세요.)</span>
					</li>
					<li> 
						<label><i class="icon-ok"></i> 비밀번호</label>
						<input type="password" name="passwd" id="passwd" class="input-small" placeholder="비밀번호 입력" />
						<span style="padding-left:8px;"></span>
					</li>
					<li>
						<label></label>
						<a href="javascript:login();" class="btn btn-primary" style="width:78px;">로그인</a>
						<span style="padding-left:8px;color:red;"></span>
					</li>
				<ul>
				</form>
			</fieldset>
			<!--
			<fieldset>
				<legend>로그인</legend>
			</fieldset>

	    	<form name="login_form" id="login_form" action="../member/login" class="form-inline">
				<i class="icon-ok"></i> 아이디 <input type="text" id="member_id" name="member_id" class="input-small" placeholder="아이디 입력" />
				<i class="icon-ok"></i> 비밀번호 <input type="password" id="passwd" name="passwd" class="input-small" placeholder="비밀번호 입력" />
				<label class="checkbox">
				<input type="checkbox"> Remember me
				</label>
				<a href="javascript:login();" class="btn btn-primary">로그인</a>
			</form>
		-->
		<p>
  	</div>
	<div class="well">
	    <p>
			<fieldset>
				<legend>신규 가입</legend>
				<form name="regist_form" id="regist_form" action="../member/regist" method="post">
				<ul>
					<li> 
						<label><i class="icon-ok"></i> 아이디</label>
						<input type="text" name="member_id" id="member_id" class="input-small" placeholder="아이디 입력" />
						<span style="padding-left:8px;">(핸드폰 번호 숫자만 입력하세요. 거래할때 사용되는 연락처이므로 중요합니다.)</span>
					</li>
					<li> 
						<label><i class="icon-ok"></i> 비밀번호</label>
						<input type="password" name="passwd" id="passwd" class="input-small" placeholder="비밀번호 입력" />
						<span style="padding-left:8px;">(4자~15자 이내로 입력하세요.)</span>
					</li>
					<li> 
						<label><i class="icon-ok"></i> 비밀번호 확인</label>
						<input type="text" name="re_passwd" id="re_passwd" class="input-small" placeholder="비밀번호 입력" />
						<span style="padding-left:8px;">(비밀번호 분실시 SMS 충전건수가 있을 경우에만 발송됩니다.</span>
					</li>

					<li>
						<label></label>
						<a href="javascript:regist();" class="btn btn-primary" style="width:78px;">가입 완료</a>
						<span style="padding-left:8px;color:red;">* 가입 완료 클릭시 아이디 중복검사 후 가입이 승인됩니다.</span>
					</li>
				<ul>
				</form>
			</fieldset>
		<p>
  	</div>
	<div class="well">
   		<p>
			<fieldset>
				<legend>비밀번호 찾기</legend>
				<form name="find_passwd_form" id="find_passwd_form" action="../member/find_passwd" method="post">
				<ul>
					<li> 
						<label><i class="icon-ok"></i> 아이디</label>
						<input type="text" name="member_id" id="member_id" class="input-small" placeholder="아이디 입력" />
						<span style="padding-left:8px;"></span>
					</li>
					<li>
						<label></label>
						<a href="javascript:find_passwd();" class="btn btn-primary" style="width:78px;">SMS 발송</a>
						<span style="padding-left:8px;color:red;">* 비밀번호 SMS 발송은 24시간 주기로 한번만 발송되오니 주의하세요.</span>
					</li>
				<ul>
				</form>
			</fieldset>
		<p>
  </div>  
@stop      