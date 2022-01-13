<?php
    require_once('../db.php');
    session_start();
    $_SESSION['forgot'] = 'forgot password admin';
    $_SESSION['wait_admin_reset'] = 'đợi admin reset account';
?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Reset user password</title>
    <meta charset="utf-8">
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
    $error = '';
    $message = 'Nhập email và username để tiếp tục';
    $email = '';
    if (isset($_POST['email']) && isset($_POST['user'])) {
        $email = $_POST['email'];
		$user = $_POST['user'];

        if (empty($email)) {
            $error = 'Please enter your email';
        }
		else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else {
            // reset password
			if($user == 'giamdoc' and $email == 'phamhuynhanhtien123@gmail.com')
			{
				//header('Location: reset_password_admin.php');
				//exit();
                send_email($email);
                die('Please check your email to reset password');
			}
			else{
				$result = forgot_password($email, $user);
				if($result['code'] == 0)
				{
					header('Location: wait_admin_reset.php');
				    exit();
				}
                else{
                    $error = $result['message'];
                }
            }
        }
    }
?>
<div class="forgot">
    <div class="forgot-form">   
        <form method="post" action="">
            <h2><strong>Forgot Password</strong></h2>
            <div class="form-group form-group1">                
                <input name="email" id="email" type="text" placeholder=" ">
                <label for="email">Email</label>
            </div>
            <div class="form-group form-group1">                
                <input name="user" id="user" type="text" placeholder=" ">
                <label for="user">Username</label>
            </div>
            <div class="form-group form-group1">
                <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
                <button >Reset password</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
