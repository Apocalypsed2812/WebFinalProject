<?php
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
        header('Location: ../taikhoan/login.php');
        exit();
    }
	require_once('../db.php');
	$tentk = $_SESSION['user'];
	
	$result = get_employee_by_tentk($tentk);
	$data = $result['data'];
	foreach ($data as $item){
		$name = $item['name'];
		$id_department = $item['id_department'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Trang Hồ Sơ Nhân Viên</title>
    <style>
		
		*{
			box-sizing: border-box;
		}

        .footer-text{
            background-color: rgba(0, 0, 0, 0.808);
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 15px;
        }
		
		.second-item{
            background-color: #bebebe;
            height: 50px;
        }
		
		.second-item p{
			color: black;
			font-weight: bold;
			margin-left: 10px;
			margin-top: 10px;
			font-size: 20px;
        }
		
		.card-body button{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
		.card-body{
			display: flex;
			justify-content: right;	
		}
		
		.card-left{
			height: 650px;
			background-color: white;
		}
		
		.leftc{
			background-color: white;
			padding: 0;
		}
		
		.top-card{
			height: 200px;
		}
		
		.content-card{
			height: 50px;
			background-color: white;
			margin-top: 10px;
		}
		
		.search-bar{
			margin-top: 10px;
			display: flex;
			justify-content: center;
		}
		
		.form-outline{
			max-width: 80%;
			min-width: 80%;
		}
		
		.nav-item{
			margin-left: 20px;
		}
		
		.card-info{
			display: flex;
			justify-content: center;
			background-color: white;
		}
		
		.card-block{
			margin-left: 0px;
		}
		
		.content-body{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
		.content-body p{
			margin-bottom: 0;
		}
		
		.image-body{
			display: flex;
			justify-content: center;
		}
		
		
		.content-body img{
			max-width: 100%;
			max-height: 100%;
		}
		
		.content-top{
			display: flex;
			justify-content: left;
			align-items: left;
			font-size: 30px;
		}
		
		.content-top p{
			margin-bottom: 0;
		}
		
		.image-top{
			display: flex;
			justify-content: center;
			height: 300px;
		}
		
		.cv-top{
			display: flex;
			justify-content: left;
			color:rgba(143, 142, 142, 0.959)
		}
		
		table{
			min-width: 100%;
			background-color: white;
			color: black;
		}
		
		.card-task{
			display: flex;
			justify-content: center;
			margin-top: 50px;
		}
		
		td p{
			margin-bottom: 0;
		}
    </style>
<?php
	$result = get_employee_by_tentk($tentk);
	$data = $result['data'];
	foreach ($data as $item){
		$image = $item['image'];
	}
?>

<?php
	
	if(isset($_POST['update_avatar'])){
		if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $error = 'Vui lòng upload ảnh của bạn';
		}
		else {
			$img_name = $_FILES['image']['name'];  
			$result = change_image_employee($img_name, $tentk);
			if ($result['code'] == 0){
				header('location: caidatnhanvien.php');
				exit();
			} else {
				$error = 'Không thể thêm ảnh, vui lòng thử lại';
			}
		}
	}
?>
</head>
<body>
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
					<a class="nav-link" href="#" style="color: white;">HomePage</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Services</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About Us</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact Us</a>
				</li>
				<li class="nav-item" style = "cursor: pointer;">
					<div class="dropdown">
						<a class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="color: white;">
							<span><i class="fa fa-user-o" aria-hidden="true"></i></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="../taikhoan/logout.php">Log out</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
    </nav>

		<div class="row">
			<div class="col-lg-4 col-md-12 left mt-3">
				<table cellpadding="10" cellspacing="10" class="table table-borderless" style="margin: auto;">
					<tbody>
						<tr>
							<td colspan="4">
								<div class="image-top">
									<img src="../images/<?=$image?>">
								</div>
								<div class="content-top">
									<p><?=$name?></p>
								</div>
								<div class="cv-top">
									<p>Nhân viên <?=$id_department?></p>
								</div>
							</td>
						</tr>
			
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td colspan="3">
								<a href="tacvunhanvien.php">Task</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary">42</span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td colspan="4">
								<a href="hosonhanvien.php">Profile</a>
							</td>
							
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td colspan="3">
								<a href="tinnhannhanvien.php">Message</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary">7</span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px;">
							<td colspan="4">
								<a href="hoatdongnhanvien.php">Action Log</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px; background-color: #D8D8D8">
							<td colspan="3">
								<a href="caidatnhanvien.php">System Settings</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary">1</span>
								</a>
							</td>
						</tr>
						
					</tbody>
				</table>

			</div>
            
			<div class="col-lg-5 mt-3">
				<form action="" method="POST">
					<table cellpadding="10" cellspacing="10" border="0" class="table-borderless">
						<div>Public Profile</div> 
						<tbody>
							<tr>
								<td>
									<div class="form-group">
										<label for="name">Họ tên</label>
										<input id="name" type="text" name="name" class="form-control">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label for="name">Ngày sinh</label>
										<input id="birth" type="date" name="birth" class="form-control">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label for="address">Địa chỉ</label>
										<input id="address" type="text" name="address" class="form-control">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label for="email">Email</label>
										<input id="email" type="text" name="email" class="form-control">
									</div>
								</td>
							</tr>
							<tr>
								<td><button type="submit" href="update.php" class="btn btn-primary">Cập nhật thông tin</button></td>
							</tr>
							<tr>
								<td><hr size="1"></td>
							</tr>
							<tr>
								<td><a href="../taikhoan/change_password_employee.php" class="btn btn-primary">Đổi mật khẩu</a></td>
							</tr>
							<tr>
								<?php
									if (!empty($error)) {
										echo "<div class='alert alert-danger'>$error</div>";
									}
								?>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
            <div class="col-lg-3 mt-3">
				<table cellpadding="10" cellspacing="10" border="0" class="table table-borderless" >
					<tbody>
						<tr>
							<td><a href="hosonhanvien.php" class="btn btn-primary">Đến trang hồ sơ</a></td>
						</tr>
                        <tr>
							<td>Ảnh đại diện</td>
						</tr>
						<tr>
							<td><img src="../images/<?=$image?>" style="width:100%"></td>
						</tr>
                        <tr>
							<td><a href="" class="btn btn-primary" data-toggle="modal" data-target="#add-avatar">sửa ảnh</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
    <p class="footer-text">Copyright @ Your Website 2017</p>
	
<!--Add modal avatar-->
<div id="add-avatar" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" novalidate enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Change Avatar</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="custom-file">
							<input value=""name="image" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
							<label class="custom-file-label" for="customFile">Ảnh đại diện</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="update_avatar" id="update_avatar">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Change</button>
				</div>
			</div>
		</form>
	</div>
</div>
	 
<script src="main.js"></script>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</body>
</html>