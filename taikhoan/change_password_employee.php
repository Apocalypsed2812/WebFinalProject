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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../style.css">
</head>
<body style = " font-family: 'Poppins', sans-serif; font-size: 16px;">
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
<div class="change-password">
    <div class="change-password-form">		
		<form novalidate method="post" action="">
			<h2><strong>Change Password</strong></h2>
			<div class="form-group form-group1">				
				<input value="" name="oldpass" id="oldpass" type="password" placeholder=" ">
				<label for="oldpass">Old Password</label>
			</div>
			<div class="form-group form-group1">				
				<input  value="<?= $pass?>" name="pass" required  type="password" placeholder=" " id="pass">
				<label for="pass">New Password</label>
				
			</div>
			<div class="form-group form-group1">				
				<input value="<?= $pass_confirm?>" name="pass-confirm" required type="password" placeholder=" " id="pass2">
				<label for="pass2">Confirm New Password</label>				
			</div>
			<div class="form-group form-group1">
				<?php
					if (!empty($post_error)) {
						echo "<div class='alert alert-danger'>$post_error</div>";
					}
				?>
				<button>Change password</button>
			</div>
		</form>
    </div>
</div>

</body>
</html>
