<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: ../taikhoan/login.php');
        exit();
    }
    require_once('../db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register an account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .bg {
            background: #eceb7b;
        }
    </style>
</head>
<body>
<?php
    $error = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $user = '';
	$role = '';
    $department = '';

    if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email'])
    && isset($_POST['user']) && isset($_POST['role']) && isset($_POST['department']))
    {
        $first_name = $_POST['first'];
        $last_name = $_POST['last'];
        $email = $_POST['email'];
        $user = $_POST['user'];
		$role = $_POST['role'];
        $department = $_POST['department'];

        if (empty($first_name)) {
            $error = 'Please enter your first name';
        }
        else if (empty($last_name)) {
            $error = 'Please enter your last name';
        }
		else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
		else if (empty($role)) {
            $error = 'Please enter role';
        }
        else if (empty($department)) {
            $error = 'Please enter department';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else {
            // register a new account
            $result = register($user, $role, $email, $first_name, $last_name, $department);
            if ($result['code'] == 0)
			{
                //thanh cong
				//die("Register successfully");
                $_SESSION['register_success'] = 'đăng kí thành công';
				header('Location: ../giamdoc/giamdoc.php');
				exit();
            } 
			else if ($result['code'] == 2)
			{
				$error = $result['message'];
			}
			else if ($result['code'] == 3)
			{
				$error = $result['message'];
			}
			else 
			{
                $error = "An error occured. Please try again.";
            }
        }
    }
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Create a new account</h3>
                <form method="post" action="" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name</label>
                            <input value="<?= $first_name?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name</label>
                            <input value="<?= $last_name?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                            <div class="invalid-tooltip">Last name is required</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="user">Username</label>
                        <input value="<?= $user?>" name="user" required class="form-control" type="text" placeholder="Username" id="user">
                        <div class="invalid-feedback">Please enter your username</div>
                    </div>
					
					<div class="form-group">
						<label for="role">Role</label>
						<select name="role" required class="form-control" id="role">
							<?php
								$result = get_role();
								$data = $result['data'];
								foreach ($data as $item){
									$namerole = $item['name'];
							?>
									<option value="<?=$namerole?>"><?=$namerole?></option>
							<?php
								}
							?>
						</select>
					</div>

                    <div class="form-group">
						<label for="department">Department</label>
						<select name="department" required class="form-control" id="department1">
							<?php
								$result = get_name_department();
								$data = $result['data'];
								foreach ($data as $item){
									$namedepartment = $item['name'];
							?>
									<option value="<?=$namedepartment?>"><?=$namedepartment?></option>
							<?php
								}
							?>
						</select>
					</div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2">Register</button>
                        <button type="reset" class="btn btn-outline-success px-5 mt-3">Reset</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>

