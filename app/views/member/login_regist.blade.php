@extends('layouts.master')

@section('content')
	<script>
		function save() {
			if(form.nickname.value == "") {
				alert("작성자를 입력하세요.");
				form.nickname.focus();
				return;
			}

			if(form.passwd.value == "") {
				alert("패스워드를 입력하세요.");
				form.passwd.focus();
				return;
			}

			if(form.re_passwd.value == "") {
				alert("확인용 패스워드를 입력하세요.");
				form.re_passwd.focus();
				return;
			}


			if(form.passwd.value != form.re_passwd.value) {
				alert("패스워드가 일치하지 않습니다. 패스워드를 다시 입력하세요.");
				form.re_passwd.focus();
				return;
			}

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
  <div class="well">
    <h4>기존 가입자</h4>
    <p>
    	<form class="form-inline">
			  <i class="icon-ok"></i> 아이디 <input type="text" class="input-small" placeholder="아이디 입력">
			  <i class="icon-ok"></i> 비밀번호 <input type="password" class="input-small" placeholder="비밀번호 입력">
			  <!--
			  <label class="checkbox">
			    <input type="checkbox"> Remember me
			  </label>
				-->
			  <button type="submit" class="btn">로그인</button>
			</form>
		<p>
		<!--	
		<p>	
			<form name="form" id="form" action="/board/free_posting_regist_save" method="post">
			  <fieldset>
			    <label><i class="icon-ok"></i> 아이디</label>
			    <input type="text" id="member_id" name="member_id" class="span4" placeholder="아이디를 입력하세요.">
			  </fieldset>

			  <fieldset>
			    <label><i class="icon-ok"></i> 비밀번호</label>
			    <input type="password" id="member_passwd" name="member_passwd" class="span4" placeholder="비밀번호를 입력하세요.">
			  </fieldset>

			</form>
		</p>
    <p>
    	<div align="center">
				<a href="javascript:save();" class="btn btn-primary">로그인</a>
			</div>	
    </p>
  	-->
  </div>
@stop      