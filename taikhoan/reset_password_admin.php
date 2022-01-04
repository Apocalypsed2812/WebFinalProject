<?php
	require_once('../db.php');
	session_start();
	if (!isset($_SESSION['forgot'])) {
		header('Location: login.php');
		exit();
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
<?php

    $error = '';
    $user = '';
	
	if (isset($_POST['user'])) 
	{
		$user = $_POST['user'];
		
		if (empty($user)) {
			$error = 'Vui lòng nhập Email';
		} 
		else {
			// reset pass
			$result = reset_password_admin($user);
			if ($result['code'] == 0) {
				// thành công
				session_destroy();
				setcookie('reset_admin_success', $user, time() + 3600 *24);
				header('Location: login.php');
				exit();
			} else {
				$error = $result['message'];
			}
		}
	}
	
    
  
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Reset Account Admin</h3>
			<form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
				<p>Vui lòng nhập username để tiến hành reset tài khoản</p>
				<div class="form-group">
					<label for="user">Username</label>
					<input  value="" name="user" required class="form-control" type="text" placeholder="Username" id="user">
				</div>
				<div class="form-group">
					<?php
						if (!empty($error)) {
							echo "<div class='alert alert-danger'>$error</div>";
						}
					?>
					<button type ="submit" class="btn btn-success px-5">Reset</button>
				</div>
			</form>
        </div>
    </div>
</div>


</body>
</html>
