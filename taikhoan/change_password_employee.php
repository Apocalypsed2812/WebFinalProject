<?php
	require_once('../db.php');
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
		header('Location: ../taikhoan/login.php');
		exit();
	}
	$tentk = $_SESSION['user'];
?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Reset user password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php

    $post_error = '';
    $oldpass = '';
    $pass = '';
    $pass_confirm = '';
    
	if (isset($_POST['oldpass']) && isset($_POST['pass']) && isset($_POST['pass-confirm'])) {

		$oldpass = $_POST['oldpass'];
		$pass = $_POST['pass'];
		$pass_confirm = $_POST['pass-confirm'];

		if (empty($oldpass)) {
			$post_error = 'Vui lòng nhập mật khẩu cũ';
		}
		else if (!check_old_pass($oldpass, $tentk)) {
			$post_error = 'Mật khẩu cũ không đúng, vui lòng nhập lại mật khẩu cũ';
		}
		else if (empty($pass)) {
			$post_error = 'Vui lòng nhập mật khẩu mới';
		} else if (strlen($pass) < 6) {
			$post_error = 'Mật khẩu mới phải có ít nhất 6 ký tự';
		} else if ($pass != $pass_confirm) {
			$post_error = 'Xác nhận mật khẩu không trùng khớp';
		} else {
			// change pass for employee
			$result = change_password_employee($tentk, $pass);
			if ($result['code'] == 0) {
				// thành công
				$_SESSION['change_employee_success'] = 'thành công';
				header('Location: ../taikhoan/login.php');
			} else {
				$_SESSION['change_employee_failed'] = 'thất bại';
				$post_error = $result['message'];
			}
		}
	}
    
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Change Password</h3>
			<form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
				<div class="form-group">
					<label for="oldpass">Old Password</label>
					<input value="" name="oldpass" id="oldpass" type="password" class="form-control" placeholder="Old Password">
				</div>
				<div class="form-group">
					<label for="pass">New Password</label>
					<input  value="<?= $pass?>" name="pass" required class="form-control" type="password" placeholder="New Password" id="pass">
					<div class="invalid-feedback">Password is not valid.</div>
				</div>
				<div class="form-group">
					<label for="pass2">Confirm New Password</label>
					<input value="<?= $pass_confirm?>" name="pass-confirm" required class="form-control" type="password" placeholder="Confirm New Password" id="pass2">
					<div class="invalid-feedback">Password is not valid.</div>
				</div>
				<div class="form-group">
					<?php
						if (!empty($post_error)) {
							echo "<div class='alert alert-danger'>$post_error</div>";
						}
					?>
					<button class="btn btn-success px-5">Change password</button>
				</div>
			</form>
        </div>
    </div>
</div>

</body>
</html>
