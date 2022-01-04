<?php
	require_once('../db.php');
	session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: ../taikhoan/login.php');
        exit();
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
    <title>Trang Giám Đốc</title>
</head>
<?php
	if (isset($_POST['name_reset']) && isset($_POST['id_reset'])) 
	{
		$user = $_POST['name_reset'];
		$id_reset = $_POST['id_reset'];

		$result = reset_password($user);
		$result1 = update_token($id_reset);
		if ($result['code'] == 0 && $result1['code'] == 0) {
			// thành công
			$_SESSION['reset_success'] = 'reset account thành công';
			header('Location: ../giamdoc/request.php');
			exit();
		} else {
			$error = $result['message'];
		}
	} 
?>
<body>
	<div id="toast">
	</div>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
                <a class="navbar-brand" href="#">Our Company</a>
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
                </button>
    
                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav ml-auto">
					<li class="nav-item">
                            <a class="nav-link" href="giamdoc1.php">HomePage</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="../giamdoc/request.php" style="color: white;">Reset Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../taikhoan/register.php">Create Account</a>
                        </li>
						<li class="nav-item" style = "cursor: pointer;">
							<div class="dropdown">
								<a class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="color: white;">
									<span><i class="far fa-user-circle"></i></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="../taikhoan/logout.php">Log out</a>
								</div>
							</div>
                        </li>
                    </ul>
                </div>
        </nav>
	<div class="container">
		<div style="overflow-x:auto;" class="mt-5">
			<h3 class="text-center mb-5 text-primary">Request Reset Account</h3>
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
				<tr class="header">
					<td>ID</td>
					<td>Name</td>
					<td>Email</td>
					<td>Actions</td>
				</tr>
				<?php
					$result = get_request();
					$data = $result['data'];
					foreach ($data as $item){
						$id = $item['id'];
						$name = $item['username'];
						$email = $item['email'];
				?>
						<tr class="item">
							<td><?=$id?></td>
							<td><?=$name?></td>
							<td><?=$email?></td>
							<td>
								<a href="" class="btn btn-success reset_account" data-toggle="modal" data-target="#reset-modal" data-id="<?=$id?>" data-name="<?=$name?>">
									Reset password
								</a>
							</td>
						</tr>
				<?php
					}
				?>
			</table>
		</div> 
	</div>
	
<div id="reset-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<hp class="modal-title">Reset Account</hp>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<p>Bạn có chắc rằng muốn reset <strong>this account</strong> ?</p>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id_reset" id="id_reset">
						<input type="hidden" name="name_reset" id="name_reset">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" onclick="resetLocation()" class="btn btn-danger">Reset</button>
					</div>
				</div>
			</form>
        </div>
    </div>
	
<script src="../main.js"></script>
<?php
	//show toast message
	if(isset($_SESSION['reset_success']))
	{
		echo "<script>showSuccessToast('Reset account successfully')</script>";
		unset($_SESSION['reset_success']);
	}
?>
</body>
</html>