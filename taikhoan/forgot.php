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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
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
			if($user == 'giamdoc' and $email == 'admin@gmail.com')
			{
				header('Location: reset_password_admin.php');
				exit();
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Forgot Password</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" id="email" type="text" class="form-control" placeholder="Email address">
                </div>
				<div class="form-group">
                    <label for="user">Username</label>
                    <input name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
				<?php
                    echo "<div class='alert alert-primary'>$message</div>"
				?>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Reset password</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
