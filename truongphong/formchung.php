<?php
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
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
		$image = $item['image'];
	}
	$tasks = get_all_tasks_employee($idnv)['data'];
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
    <title>Trang Tác Vụ Nhân Viên</title>
</head>
<?php
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$result = update_task_inprogress($id);
		if ($result['code'] == 0){
			// thành công
			//die('ADD DEPARTMENT SUCCESS');
			//header('Location: giamdoc.php');
			//exit();
			$_SESSION['start_success'] = 'thành công';
			//header('Location: tacvunhanvien.php');
			//exit();
		} 
		else {
			//$error = $result['message'];
			$_SESSION['start_failed'] = 'thất bại';
		}          
	}
?>
<?php
	if(isset($_POST['content']) && isset($_POST['submit_task'])){
		$content = $_POST['content'];
		$attach = $_FILES['attach']['name'];
		$idTask = $_POST['submit_task'];
		$deadlineTask = $_POST['deadline_task'];
		$idnv_submit = $_POST['id_nv_task'];
		$today = date("Y-m-d");
		if(empty($content))
		{
			$error = 'Vui lòng nhập nội dung';
		}
		else if(empty($attach))
		{
			$error = 'Vui lòng chọn file đính kèm';
		}
		else{
			$result = update_task_waiting($idTask);
			$numberDay = compute_dayoff($deadlineTask, $today);
			if($numberDay > 0){
				$result1 = add_submission($idnv, $idTask, $attach, $content, $deadlineTask, 'late');
			}
			else{
				$result1 = add_submission($idnv, $idTask, $attach, $content, $deadlineTask, 'normal');
			} 
			if ($result['code'] == 0 && $result1['code'] == 0){
				$count_task_submit = count_task_submit($idTask)['count(*)'];
				$result2 = add_task_history($idnv_submit, $idTask, 'Submit', $today, $count_task_submit + 1);
				if ($_FILES['attach']['name'] != NULL) {
					// Kiểm tra file có vượt quá 20MB không
					if ($_FILES['attach']['size'] > 20 * 1048576) {
						echo "<script> alert('File đăng tải không phải là file ảnh!'); window.location='tacvunhanvien.php'; </script>";
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
								echo "<script> alert('Upload thành công!'); window.location='tacvunhanvien.php'; </script>";
							} else {
								echo "<script> alert('Upload không thành công!'); window.location='tacvunhanvien.php'; </script>";
							}
						} else {
							echo "<script> alert('File không được phép upload!'); window.location='tacvunhanvien.php'; </script>";
						}
					}
				} 
				else 
				{
					echo "<script> alert('File không được để trống!'); window.location='tacvunhanvien.php'; </script>";
				}
				$_SESSION['submit_success'] = 'thành công';
			}
			else {
				//$error = $result['message'];
				$_SESSION['submit_failed'] = 'thất bại';
			}  
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
					<a class="nav-link" href="#" style="color: white;">HomePage</a>
				</li>
				<li class="nav-item">
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

		<div class="row tacvunhanvien">
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
									<p>Trưởng Phòng <?=$id_department?></p>
								</div>
							</td>
						</tr>
			
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td onclick="window.location.href='truongphong.php'" colspan="4">
								Manage Task
							</td>
							
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td  onclick="window.location.href='hosonhanvien.php'" colspan="4">
								Profile
							</td>
							
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px;">
							<td  onclick="window.location.href='tinnhannhanvien.php'" colspan="3">
								DayOff
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"></span>
								</a>
							</td>
						</tr>
						
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
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
        </div>
		<p class="footer-text">Copyright @ Your Website 2017</p>
<script src="../main.js"></script>
<?php
	//show toast message
	if(isset($_SESSION['start_success']))
	{
		echo "<script>showSuccessToast('Get task success')</script>";
		unset($_SESSION['success']);
	}
	
	else if(isset($_SESSION['start_failed']))
	{
		echo "<script>showErrorToast('Get task failed')</script>";
		unset($_SESSION['failed']);
	}

	else if(isset($_SESSION['submit_success']))
	{
		echo "<script>showSuccessToast('Submit task success')</script>";
		unset($_SESSION['submit_success']);
	}
	
	else if(isset($_SESSION['submit_failed']))
	{
		echo "<script>showErrorToast('Submit task failed')</script>";
		unset($_SESSION['submit_failed']);
	}
?>
</body>
</html>