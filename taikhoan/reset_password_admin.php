<?php
	require_once('../db.php');
	session_start();
	/*if (!isset($_SESSION['forgot'])) {
		header('Location: login.php');
		exit();
	}*/
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
    $post_error = '';
    $email = '';

    $display_email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);

    if (isset($_GET['email']) && isset($_GET['token'])){
        $email = $_GET['email'];
        $token = $_GET['token'];
        if (!filter_var($email, FILTER_SANITIZE_EMAIL)){
            $error = "Đây không phải là email hợp lệ";
        } else if (strlen($token) != 32){
            $error = "Đây không phải là reset token hợp lệ";
        } else {
            //xử lý POST
            if (isset($_POST['email']) && isset($_POST['user'])) {

                $email = $_POST['email'];
                $user = $_POST['user'];

                if (empty($email)) {
                    $post_error = 'Vui lòng nhập Email';
                } else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                    $post_error = 'Đây không phải là một địa chỉ email hợp lệ';
                } else if (empty($user)) {
                    $post_error = 'Vui lòng username';
                } else {
                    // reset pass
                    $result = reset_password_admin($user, $email);
					if ($result['code'] == 0) {
						// thành công
						session_destroy();
						setcookie('reset_admin_success', $user, time() + 3600 *24);
						header('Location: login.php');
						exit();
					} else {
						$post_error = $result['message'];
					}
				}
            }else { 
                //$post_error = "Không thể post lên sever";
                //print_r($_POST);
            }
        } 
    } else {
            $error = "Email hoặc token không hợp lệ"; 
    }
  
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Reset Account Admin</h3>
			<?php
                if (!empty($error)){
                    echo "<div class='alert alert-danger'>$error</div>";
                } else {
                    ?>
                    <form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input readonly value="<?=$display_email?>" name="email" id="email" type="text" class="form-control" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <label for="user">Username</label>
                            <input  value="" name="user" required class="form-control" type="text" placeholder="Username" id="user">
                            <div class="invalid-feedback">Password is not valid.</div>
                        </div>
                        <div class="form-group">
                            <?php
                                if (!empty($post_error)) {
                                    echo "<div class='alert alert-danger'>$post_error</div>";
                                }
                            ?>
                            <button class="btn btn-success px-5">Reset password</button>
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
