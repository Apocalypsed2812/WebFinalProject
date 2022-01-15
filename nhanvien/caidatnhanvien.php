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
		$idnv = $item['idnv'];
		$name = $item['name'];
		$id_department = $item['id_department'];
	}
	$count = count_task_employee($idnv);
	$count_task = $count['count(*)'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style.css">    
	<title>Trang Ảnh Hồ Sơ Nhân Viên</title>

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
            $_SESSION['notNull'] = 'không được để trống';
		}
		else {
			if ($_FILES['image']['name'] != NULL) {
				// Kiểm tra file có vượt quá 20MB không
				if ($_FILES['image']['size'] > 20 * 1048576) {
					echo "<script> alert('File được chọn có kích thước quá lớn!'); window.location='caidatnhanvien.php'; </script>";
				} else {
					// Kiểm tra có file là file (*.exe, *.msi, *.sh) không được phép upload không.
					$img_name = $_FILES['image']['name'];
					$fileType = pathinfo($img_name,PATHINFO_EXTENSION);
					$Allowtypes = array('jpg', 'png', 'gif');
					if (in_array($fileType,$Allowtypes)) {
						$path = "../images/"; // file sẽ lưu vào thư mục upload
						$tmp_name = $_FILES['image']['tmp_name'];
						// Upload ảnh vào thư mục file
						if (move_uploaded_file($tmp_name, $path . $img_name)){
							// Kiểm tra file up lên có phải là ảnh không            
							/* echo "<script> alert('Change avatar successfully!'); window.location='caidatnhanvien.php'; </script>"; */
							//$img_name = $_FILES['image']['name'];  
							$result = change_image_employee($img_name, $tentk);
							if ($result['code'] == 0){
								//header('location: caidatnhanvien.php');
								//exit();
								$_SESSION['success'] = 'thành công';
								echo "<script> alert('Change avatar successfully!'); window.location='caidatnhanvien.php'; </script>";							
							} else {
								$_SESSION['unsuccess'] = 'không thành công';
								$error = 'Không thể thêm ảnh, vui lòng thử lại';
							}	
						}
						
					} else {
						$_SESSION['notAlow'] = 'không được phép';
					}
				}
			} 
			else 
			{	
				$_SESSION['notNull'] = 'không được để trống';
			}
		}
	}
?>
</head>
<body>
	<div id="toast"></div>
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
					<a class="nav-link" href="tacvunhanvien.php">HomePage</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="#">Services</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.html">About Us</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact.html">Contact Us</a>
				</li>
				<li class="nav-item" style = "cursor: pointer;">
					<div class="dropdown">
						<a class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="color: white;">
							<span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="../taikhoan/logout.php">Log out</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
    </nav>

		<div class="row caidatnhanvien">
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
							<td onclick="window.location.href='tacvunhanvien.php'" colspan="3">
								Task
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"><?=$count_task?></span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td  onclick="window.location.href='hosonhanvien.php'" colspan="4">
								Profile
							</td>
							
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td  onclick="window.location.href='tinnhannhanvien.php'" colspan="3">
								DayOff
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"></span>
								</a>
							</td>
						</tr>
						
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px; background-color: #D8D8D8">
							<td onclick="window.location.href='caidatnhanvien.php'" colspan="3">
								Avatar
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"></span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px;">
							<td onclick="window.location.href='../taikhoan/change_password_employee.php'" colspan="3">
								Change Password
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"></span>
								</a>
							</td>
						</tr>
					</tbody>
				</table>

			</div>
            
			<div class="col-lg-8 mt-3">
				<form action="" method="POST">
					<table cellpadding="10" cellspacing="10" border="0" class="table-borderless">						
						<tbody>
							<tr>
								<td><h1>Avatar</h1></td>
							</tr>
							<tr>
								<td><img src="../images/<?=$image?>" style="width:430px; margin-left:auto;margin-right:auto"></td>
							</tr>
							<tr>
								<td><a href="" class="btn btn-primary" data-toggle="modal" data-target="#add-avatar">Change avatar</a></td>
							</tr>																				
						</tbody>
					</table>
				</form>
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
							<label class="custom-file-label" for="customFile">Avatar</label>
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
	 
<script src="../main.js"></script>
<?php
	//show toast message
	if(isset($_SESSION['success']))
	{
		echo "<script>showSuccessToast('Change image successfully')</script>";
		unset($_SESSION['success']);
		/* echo "<script>window.location='caidatnhanvien.php'; </script>"; */
	}
	else if(isset($_SESSION['unsuccess']))
	{
		echo "<script>showErrorToast('Change image failed')</script>";
		unset($_SESSION['unsuccess']);
	}
	else if(isset($_SESSION['notAlow']))
	{
		echo "<script>showErrorToast('Type image not alow')</script>";
		unset($_SESSION['notAlow']);
	}
	else if(isset($_SESSION['notNull']))
	{
		echo "<script>showErrorToast('File image not null')</script>";
		unset($_SESSION['notNull']);
	}
?>
</body>
</html>