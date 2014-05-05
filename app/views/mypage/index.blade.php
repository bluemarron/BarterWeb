@extends('layouts.master')

@section('content')
	<script>
		var message = '<?=$message?>';

		if(message != '')
			alert(message);

		function changePasswd() {
			/*
			if(regist_form.member_id.value == '') {
				alert('아이디를 입력하세요.');
				regist_form.member_id.focus();
				return;
			}

			if(regist_form.passwd.value == '') {
				alert('비밀번호를 입력하세요.');
				regist_form.passwd.focus();
				return;
			}

			if(regist_form.re_passwd.value == '') {
				alert('확인용 비밀번호를 입력하세요.');
				regist_form.re_passwd.focus();
				return;
			}


			if(regist_form.passwd.value != regist_form.re_passwd.value) {
				alert('비밀번호가 일치하지 않습니다. 비밀번호를 다시 입력하세요.');
				regist_form.re_passwd.focus();
				return;
			}

			regist_form.submit();
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
			width:150px;
			float:left;
		}
	    -->
   	</style>

  	<div class='well'>
	    <p>
			<fieldset>
				<legend>비밀번호 변경</legend>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 아이디</label>
						<input type='text' name='member_id' id='member_id' class='input-small' readonly />
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 현재 비밀번호</label>
						<input type='password' name='passwd' id='passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 변경 비밀번호</label>
						<input type='password' name='passwd' id='passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 변경 비밀번호 확인</label>
						<input type='password' name='passwd' id='passwd' class='input-small' placeholder='비밀번호 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li>
						<label></label>
						<a href='#' class='btn btn-primary' style='width:78px;'>비번 변경</a>
						<span style='padding-left:8px;color:red;'></span>
					</li>
				<ul>
			</fieldset>
		<p>
  	</div>
	<div class='well'>
		<p>
			<fieldset>
				<legend>SMS 충전</legend>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 충전</label>
						: <b>300</b>건 
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 사용</label>
						: <b>100</b>건 
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 입금자 성명</label>
						<input type='password' name='re_passwd' id='re_passwd' class='input-small' placeholder='입금 입력' />
						&nbsp;
						<select style='width:80px;'>
							<option>10건</option>
							<option>50건</option>
							<option>100건</option>
							<option>200건</option>
							<option>500건</option>
						</select>
						300원
						<span style='padding-left:8px;'>(입금완료 후 "SMS 충전"" 버튼을 클릭하세요.)</span>
					</li>

					<li>
						<label></label>
						<a href='javascript:regist();' class='btn btn-primary' style='width:78px;'>SMS 충전</a>
						<span style='padding-left:8px;color:red;'>* SMS 충전시 유효기간은 없으나 잔여건수 잔액은 환불되지 않습니다.</span>
					</li>
				<ul>
			</fieldset>
		<p>		
  	</div>
	<div class='well'>			
	    <p>
			<fieldset>
				<legend>SMS 관리</legend>
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 발송조건</label>
						<table>
							<tr>
								<td>
									<input type='checkbox' />&nbsp;거래신청시 발송 (예: 153번 경운기 거래신청 3명입니다.)
									<br/>
									<table>
										<tr>
											<td>
												&nbsp;&nbsp;&nbsp;
												* 확인간격:
												&nbsp;&nbsp;
											</td>	
											<td>
												<input type='radio' />&nbsp;10분&nbsp;
											</td>
											<td>	
												<input type='radio' />&nbsp;30분&nbsp;
											</td>	
											<td>
												<input type='radio' />&nbsp;1시간&nbsp;
											</td>
											<td>
												<input type='radio' />&nbsp;4시간&nbsp;
											</td>	
											<td>
												<input type='radio' />&nbsp;8시간&nbsp;
											</td>
											<td>	
												<input type='radio' />&nbsp;24시간&nbsp;
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>	
								<td>
									<input type='checkbox' />&nbsp;거래성사시 발송 (예: 154번 트렉타 0112666593 회원이 거래 선택하였습니다.)
								</td>
							</tr>
							<tr>	
								<td>
									<input type='checkbox' />&nbsp;거래완료시 발송 (예: 155번 관리기 구매결정이 "완료/취소" 되었습니다.)
								</td>	
							</tr>
						</table>
					</li>
					<li>
						<label></label>
						<a href='#' class='btn btn-primary' style='width:78px;'>조건 변경</a>
						<span style='padding-left:8px;color:red;'></span>
					</li>					
				<ul>
			</fieldset>
		<p>
  	</div>
  	
  	<!-- <div class='well'>			
	    <p>
			<fieldset>
				<legend>담보금 관리</legend> 
				<ul>
					<li> 
						<label><i class='icon-ok'></i> 입금자 성명</label>
						<input type='password' name='re_passwd' id='re_passwd' class='input-small' placeholder='입금자 입력' />
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 입금액</label>
						<input type='password' name='re_passwd' id='re_passwd' class='input-small' placeholder='입금액 입력' />원 
						<span style='padding-left:8px;'></span>
					</li>
					<li> 
						<label><i class='icon-ok'></i> 담보금</label>
						1,000,000원 
						<span style='padding-left:8px;'></span>
					</li>
					<li>
						<label></label>
						<a href='#' class='btn btn-primary' style='width:78px;'>담보금 신청</a>
						<span style='padding-left:8px;color:red;'>* 담보금 + SMS입금 계좌: 농협 623-01-064971 (예금주: 다사농기)</span>
					</li>
					<li><hr/></li>
					<li> 
						<label><i class='icon-ok'></i> 환급</label>
						<table>
							<tr>
								<td>
									은행<br/>
									<select style='width:80px;'>
										<option>- 은행 -</option>
										<option>농협</option>
										<option>수협</option>
										<option>국민은행</option>
										<option>우리은행</option>
										<option>하나은행</option>
										<option>SC제일은행</option>
									</select>
								</td>
								<td>&nbsp;</td>
								<td>
									예금주<br/>
									<input type='text' class='input-small' placeholder='예금주 입력' />
								</td>
								<td>&nbsp;</td>
								<td>
								 	계좌번호<br/>
								 	<input type='text' class='input-medium' placeholder='계좌번호 입력' />
								</td>	
							</tr>
						</table>
					</li>
					<li>
						<label></label>
						<a href='#' class='btn btn-primary' style='width:78px;'>환급 요청</a>
						<span style='padding-left:8px;color:red;'></span>
					</li>			
				<ul>
			</fieldset>
		<p>
  	</div> -->

@stop      