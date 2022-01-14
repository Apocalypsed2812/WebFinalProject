<?php
	session_start();
	require_once('../db.php');
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
        header('Location: ../taikhoan/login.php');
        exit();
    }
	
	$user = $_SESSION['user'];
    $result = get_employee_by_tentk($user);
	$data = $result['data'];
	foreach ($data as $item){
		$nameManager = $item['name'];
		$departmentManager = $item['department'];
		$id_department = $item['id_department'];
        $roleManager = $item['role'];
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
    <link rel="stylesheet" href="../style.css">
    <title>Trang yêu cầu nghỉ phép</title>
    
</head>
<?php
	//check add dayoff
	$error = '';
	$numday = '';
    $reason = '';
    $attach = '';
    
    if (isset($_POST['numday']) && isset($_POST['reason']))
    {
		$numday = $_POST['numday'];
        $reason = $_POST['reason'];

        if (empty($numday)) {
            $error = 'Hãy nhập số phòng ban';
        }
		else if (empty($reason)) {
            $error = 'Hãy nhập lí do';
        }
        else {
			$attach = $_FILES['attach']['name'];
            $result = add_dayoff_employee($numday, $reason, $attach, $user, $roleManager);
            if ($result['code'] == 0){
				$update_dayoff_employee_ngaydasudung = update_dayoff_employee_ngaydasudung($numday, $user);
				$update_dayoff_employee_ngayconlai = update_dayoff_employee_ngayconlai($numday, $user);
				if ($_FILES['attach']['name'] != NULL) {
					// Kiểm tra file có vượt quá 20MB không
					if ($_FILES['attach']['size'] > 20 * 1048576) {
						echo "<script> alert('File đăng tải không phải là file ảnh!'); window.location='dayoff_manager.php'; </script>";
					} else {
						// Kiểm tra có file là file (*.exe, *.msi, *.sh) không được phép upload không.
						if (
							$_FILES["attach"]["type"] != "file/exe" || $_FILES["attach"]["type"] != "file/msi" || 
							$_FILES["attach"]["type"] != "file/sh"
						) {
							// Kiểm tra file up lên có phải là ảnh không            
							// Nếu là ảnh tiến hành code upload
							$path = "../minhchung/"; // file sẽ lưu vào thư mục upload
							$tmp_name = $_FILES['attach']['tmp_name'];
							$name = $_FILES['attach']['name'];
							// Upload ảnh vào thư mục file
							if (move_uploaded_file($tmp_name, $path . $name)) {
								echo "<script> alert('Upload thành công!'); window.location='dayoff_manager.php'; </script>";
							} else {
								echo "<script> alert('Upload không thành công!'); window.location='dayoff_manager.php'; </script>";
							}
						} else {
							echo "<script> alert('File không được phép upload!'); window.location='dayoff_manager.php'; </script>";
						}
					}
				} 
				else 
				{
					echo "<script> alert('File không được để trống!'); window.location='dayoff_manager.php'; </script>";
				}
				//header('Location: dayoff_manager.php');
				//exit();
            } 
			else if($result['code'] == 2){
				//die('Không thể thêm yêu cầu');
				$error = 'Yêu cầu đang được duyệt, không thể thêm yêu cầu';
			}
			else if($result['code'] == 3){
				//die('Không thể thêm yêu cầu');
				$error = 'Phải đợi 7 ngày sau mới được tạo yêu cầu mới';
			}
			else {
                $error = $result['message'];
            }          
        }
    }
?>
<body>
<?php
	$result = get_employee_by_tentk($user);
	$data = $result['data'];
	foreach ($data as $item){
		$name = $item['name'];
		$id_department = $item['id_department'];
		$image = $item['image'];
	}
?>
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
					<a class="nav-link" href="truongphong.php" style="color: white;">HomePage</a>
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
			
<?php
	$result1 = get_dayoff_by_tentk($user);
	$data1 = $result1['data'];
	foreach ($data1 as $item){
		$tongso = $item['tongso'];
		$ngaydasudung = $item['ngaydasudung'];
		$ngayconlai = $item['ngayconlai'];
	}
?>
			<div class="col-lg-8 card-info">
				<table class="table table-striped mt-3 mx-3" style="border-collapse: collapse; margin: auto">
					<tbody>
						<tr>
							<td colspan="8">
								<a href="" class="btn btn-primary" data-toggle="modal" data-target="#add-dayoff">Yêu cầu nghỉ phép</a>
							</td>
						
						</tr>
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Tổng số ngày nghỉ phép</td>
							<td><?=$tongso?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Số ngày đã sử dụng</td>
							<td><?=$ngaydasudung?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Số ngày còn lại trong năm</td>
							<td><?=$ngayconlai?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td colspan="8">
								<a href="xemyeucautp.php" class="btn btn-primary">Xem yêu cầu nghỉ phép</a>
							</td>
						
						</tr>
						
						<tr>
							<td>
								<?php
								if (!empty($error)) {
									echo "<div class='alert alert-danger' id='error-dayoff'>$error</div>";
								}
								?>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>

<!--Add dayoff-->		
<div id="add-dayoff" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add DayOff Employee</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="numday">Chọn số ngày nghỉ</label>
						<select name="numday" required class="form-control" id="numday">
							<?php
								$result4 = get_ngayconlai($user);
								$data4 = $result4['data'];
								for($i = 1; $i <= $data4[0]['ngayconlai']; $i++)
								{
							?>
									<option value="<?=$i?>"><?=$i?></option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="reason">Lí do</label>
						<input value="" name="reason" required class="form-control" type="text" placeholder="Reason" id="reason">
					</div>
					<div class="form-group">
						<p>Nộp minh chứng</p>
						<div class="custom-file">
							<label class="custom-file-label" for="customFile"></label>
							<input value=""name="attach" type="file" class="custom-file-input" id="customFile">			
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info">Send request</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

    <p class="footer-text">Copyright @ Your Website 2017</p>

<!--<link rel="stylesheet" href="style.css">-->
<script src="main.js"></script>
</body>
</html>