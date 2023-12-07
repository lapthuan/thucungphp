<?php require_once 'config.php'?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once 'inc/header.php'?>

<body class="hold-transition login-page  light-mode">

	<div class="wrapper fadeInDown">
			<div id="formContent">

				<div class="fadeIn first">
					<h2>Đăng nhập cửa hàng</h2>
				</div>


				<form id="manage">

					<input type="text" id="login" name="tentk" class="fadeIn second myInput" placeholder="Nhập tài khoản" >

					<input type="password" id="password"  name="matkhau" class="fadeIn third myInput" placeholder="Nhập mật khẩu" >
					<button class="btn btn-flat btn-primary w-50 m-3" form="manage"> Đăng nhập</button>
				</form>


			</div>
	</div >

</body>
<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=login',
		data: new FormData($(this)[0]),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST',
		error: function(resp) {
			console.log('error', resp)

		},
		success: function(resp) {
			console.log('resp', resp)
			if(resp.msg && resp.status == "success"){
				alert_toast(resp.msg,"success")
				setTimeout(() => {
					window.location.href = "index.php"
				},2000);
			}
			if(resp.msg && resp.status == "failed"){
				alert_toast(resp.msg,"warning")
			}
		}
	})
})
</script>
</html>