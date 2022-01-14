<?php
	require_once('../db.php');
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
		header('Location: login.php');
		exit();
	}
?>
<?php

$error = '';
$post_error = '';
$pass = '';
$pass_confirm = '';
$user = $_SESSION['user'];

if (isset($_POST['pass']) && isset($_POST['pass-confirm'])) {
    $pass = $_POST['pass'];
    $pass_confirm = $_POST['pass-confirm'];

    if (empty($pass)) {
        $post_error = 'Vui lòng nhập mật khẩu';
    } else if (strlen($pass) < 6) {
        $post_error = 'Mật khẩu phải có ít nhất 6 ký tự';
    } else if ($pass != $pass_confirm) {
        $post_error = 'Xác nhận mật khẩu không trùng khớp';
    } else {
        // reset pass
        $result = change_password($user, $pass);
        if ($result['code'] == 0) {
            // thành công
            session_destroy();
            setcookie('change_password_success', $user, time() + 3600 *24);
            header('Location: login.php');
            exit();
        } else {
            $post_error = $result['message'];
        }
    }
}  
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Change Password</h3>

            <?php
                if (!empty($error)){
                    echo "<div class='alert alert-danger'>$error</div>";
                } else {
                    ?>
                    <form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
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
						<div class="form-group">
							<h4>Hoặc</h4>
							<p>Nhấn <a href="logout.php">vào đây</a> để thực hiện việc đăng xuất</p>
							<a class="btn btn-success px-5" href="logout.php">Log out</a>
						</div>
                    </form>
                    <?php
                }
            ?>
        </div>
    </div>
</div>

</body>
</html>
