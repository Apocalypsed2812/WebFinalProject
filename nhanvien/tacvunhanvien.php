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
		$image = $item['image'];
	}
	$tasks = get_all_tasks_employee($idnv)['data'];
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../style.css">
    <title>Trang Tác Vụ Nhân Viên</title>
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
			
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px; background-color: #D8D8D8">
							<td colspan="3">
								<a href="tacvunhanvien.php">Task</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary"><?=$count_task?></span>
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
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
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
			<div class="col-lg-8 card-info">
				<table class="table table-striped mt-3 mx-3" style="border-collapse: collapse; margin: auto">
					<tbody>
						<tr class="header">
							<td>ID Task</td>
							<td>Task name</td>
							<td>Assignee</td>
							<td>Status</td>
							<td>Due Date</td>
							<td></td>
						</tr>
						<?php 
							foreach($tasks as $task) {
								$id = $task['idtask'];
								$name = $task['name'];
								$description = $task['description'];
								$assignee = search_employee($task['idnv'])['data'][0]['name'];
								$idnv = $task['idnv'];
								$status = $task['status'];
								$deadline = $task['dueto'];
								$evaluation = $task['evaluate'];
								//viewTaskEmployee
						?>
							<tr class="item" >
								<td><?=$id?></td>
								<td><?=$name?></td>
								<td><?=$assignee?></td>
								<td><?=$status?></td>
								<td><?=$deadline?></td>
								<td>
									<button class = "btn btn-danger" href="#" data-toggle="modal" data-target="#view-task" id="button-reject" onclick="viewTaskOfEmployee(this)">View</button>
									<button class = "submit btn btn-success" href="#" data-toggle="modal" data-target="#submit-task" data-id="<?=$id?>" data-status="<?=$status?>" data-deadline="<?=$deadline?>" data-idnv="<?=$idnv?>">Submit</button>	
								</td>
							</tr>
						<?php 
							}
						?>

						<tr style="background-color: white" colspan="8">
							<td>
								<?php
								if (!empty($error)) {
									echo "<div class='alert alert-danger' id='error-dayoff'>$error</div>";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<a class="btn btn-primary" href="task_history.php">Xem lịch sử nộp task</a>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
    <p class="footer-text">Copyright @ Your Website 2017</p>

<!--submit-->		
<div id="submit-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Submit</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="content">Nhập nội dung</label>
						<input value="" name="content" class="form-control" type="text" id="content">
					</div>

					<div class="form-group">
						<div class="custom-file">
							<input value="" name="attach" type="file" class="custom-file-input" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<input type = hidden name="id_nv_task" id="id_nv_task">
					<input type = hidden name="submit_task" id="submit_task">
					<input type = hidden name="deadline_task" id="deadline_task">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info" id="button-submit">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!--view-->		
<div id="view-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View Task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body" id="tbody-view">
					
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info" id="button-start">Start</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--View reject task-->
<div id="rejected-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View Task Reject</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
					<thead>
						<tr>
							<td>ID task</td>
							<td>Note</td>				
							<td>Attach File</td>
						</tr>
					</thead>
					
					<tbody id="tbody">
						
					</tbody>
					
				</table>     
				

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info">Start</button>
				</div>
			</div>
	</div>
</div>

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