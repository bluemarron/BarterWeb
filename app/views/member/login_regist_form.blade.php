@extends('layouts.master')

@section('content')
	<script>
		var message = "<?=$message?>";

		if(message != "")
			alert(message);

		function save() {
			if(form.member_id.value == "") {
				alert("아이디를 입력하세요.");
				form.member_id.focus();
				return;
			}

			if(form.passwd.value == "") {
				alert("패스워드를 입력하세요.");
				form.passwd.focus();
				return;
			}
				
			form.submit();
		}
	</script>
  <div class="well">
    <h4>기존 가입자</h4>
    <p>
    	<form name="form" id="form" action="../member/login" class="form-inline">
			<i class="icon-ok"></i> 아이디 <input type="text" id="member_id" name="member_id" class="input-small" placeholder="아이디 입력">
			<i class="icon-ok"></i> 비밀번호 <input type="password" id="passwd" name="passwd" class="input-small" placeholder="비밀번호 입력">
			<!--
			<label class="checkbox">
			<input type="checkbox"> Remember me
			</label>
			-->
			<a href="javascript:save();" class="btn btn-primary">로그인</a>
		</form>
	<p>
  </div>
@stop      