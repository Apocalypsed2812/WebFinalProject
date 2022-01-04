<?php
	session_start();
	require_once('../db.php');
	if (isset($_SESSION['user']) && $_SESSION['role'] == 'user') {
		header('Location: change_password.php');
		exit();
	}
	
    $error = '';
	
	if(isset($_COOKIE['user']) && isset($_COOKIE['pass']))
	{
		$user = $_COOKIE['user'];
		$pass = $_COOKIE['pass'];
	}
	else
	{
		$user = '';
		$pass = '';
	}
	
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        } else {
            $result_employee = login_employee($user, $pass);
            $result_admin = login_admin($user, $pass);
            if ($result_employee['code']==0){
                $data = $result_employee['data'];
                //print_r($data['role']);
                //check_role($user, $data['role']);
				
				if(isset($_POST['remember']))
				{
					setcookie('user', $user, time() + 3600 *24);
					setcookie('pass', $pass, time() + 3600 *24);
				}
				
				$_SESSION['user'] = $user;
				$role = $data['role'];
			    if($role == 'manager')
				{
					$_SESSION['role'] = 'manager';
					header('Location: ../truongphong/truongphong.php');
				}
				else if($role == 'user'){
					$_SESSION['role'] = 'user';
					header('Location: change_password.php');
				}
				else if($role == 'employee'){
					$_SESSION['role'] = 'employee';
					header('Location: ../nhanvien/tacvunhanvien.php');
				}
				else{
					header('Location: login.php');
				}
            } 
            else if($result_admin['code']==0){
                if(isset($_POST['remember']))
				{
					setcookie('user', $user, time() + 3600 *24);
					setcookie('pass', $pass, time() + 3600 *24);
				}
				$_SESSION['user'] = $user;
                $_SESSION['role'] = 'admin';
                header('Location: ../giamdoc/giamdoc.php');
                exit();
            } 
			else {
                $error = 'Invalid username or password';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../style.css">
    <title>Login Page</title>
</head>
<body style = " font-family: 'Poppins', sans-serif; font-size: 16px;">
    <div id="toast">
    </div>
    <div class="login">
        <div class="login-form">
            <form action="" method="post" id="loginForm">
                <h1>Login</h1>
                <div class="form-group form-group1">
                    <input type="text" placeholder=" " name="user" id="username" value="<?=$user?>">
                    <label for="username">Username</label>
                </div>
                <div class="form-group form-group1">
                    <input type="password" placeholder=" " name="pass" id="password" value="<?=$pass?>">
                    <label for="password">Password</label>
                </div>
				<div class="form-group custom-control custom-checkbox form-group1">
                    <input name = "remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group form-group1">
					<?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button>Sign In</button>
                </div>
            </form>
            <div class="form-group form-group1">
				<p>Click <a href="forgot.php" style="color: blue">here</a> to reset your password</p>
            </div>
        </div>
    </div>
<script src="../main.js"></script>
<?php
	//show toast message
	if(isset($_COOKIE['change_password_success']))
	{
        echo "<script>showSuccessToast('Change password successfully')</script>";
        setcookie('change_password_success', "", time() - 3600 *24);
	}
    else if(isset($_COOKIE['reset_admin_success']))
	{
        echo "<script>showSuccessToast('Reset password admin successfully')</script>";
        setcookie('reset_admin_success', "", time() - 3600 *24);
	}
    
?>
</body>
</html>