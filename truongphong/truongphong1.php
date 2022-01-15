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
	}
	//print_r(get_task($submission[0]['idtask'])['data'][0]['name']);
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
    <title>Trang Xác Nhận Task</title>

<?php
	//reject task
	if(isset($_POST['reject']))
	{
		$id = $_POST['id'];
		$idnv = $_POST['idnv'];
		$attach = $_FILES['attach']['name'];
		$note = $_POST['note'];
		$deadline_add = $_POST['deadline'];
		$idsm = $_POST['reject_idsm'];
		$today = date("Y-m-d");
		if ($_FILES['attach']['name'] != NULL) {
			// Kiểm tra file có vượt quá 20MB không
			if ($_FILES['attach']['size'] > 20 * 1048576) {
				echo "<script> alert('Kích thước file quá lớn!'); window.location='truongphong1.php'; </script>";
			} else {
				// Kiểm tra có file là file (*.exe, *.msi, *.sh) không được phép upload không.
				$name = $_FILES['attach']['name'];
				$fileType = pathinfo($name,PATHINFO_EXTENSION);
				$notAllowtypes = array('exe', 'msi', 'sh');
				if (!in_array($fileType,$notAllowtypes)) {
					// Kiểm tra file up lên có phải là ảnh không            
					// Nếu là ảnh tiến hành code upload
					$path = "../minhchung/"; // file sẽ lưu vào thư mục upload
					$tmp_name = $_FILES['attach']['tmp_name'];
					$name = $_FILES['attach']['name'];
					// Upload ảnh vào thư mục file
					if (move_uploaded_file($tmp_name, $path . $name)) {
						$result = update_task_rejected($id);
						//$result1 = add_reject($idnv, $id, $attach, $note);
						$result2 = update_deadline_reject($deadline_add, $id);
						$result3 = add_note_attach($note, $attach, $id);
						$result4 = update_token_rc($idsm);
						if ($result['code'] == 0 && $result2['code'] == 0){
							$countReject = count_task_submit_reject($id)['count(*)'];
							$result5 = add_task_history($idnv, $id, 'Rejected', $today, $countReject+1);
							$_SESSION['reject_success'] = 'thành công';
							//echo "<script> alert('Upload thành công!'); window.location='truongphong1.php'; </script>";
						}
						else{
							$_SESSION['reject_failed'] = 'thất bại';
						}
					} else {
						echo "<script> alert('Upload không thành công!'); window.location='truongphong1.php'; </script>";
					}
				} else {
					echo "<script> alert('File không được phép upload!'); window.location='truongphong1.php'; </script>";
				}
			}
		} 
		else 
		{
			echo "<script> alert('File không được để trống!'); window.location='truongphong1.php'; </script>";
		}
		
	}
?> 

<?php
	//complete task
	if(isset($_POST['complete']))
	{
		$idtasksm = $_POST['idtask'];
		$idsm1 = $_POST['idsm'];
		$idnv_complete = $_POST['idnv'];
		$evaluate = $_POST['evaluate'];
		$today = date("Y-m-d");
		$result = update_task_completed($idtasksm);
		$result1 = update_token_rc($idsm1);
		$result2 = add_evaluate($evaluate, $idtasksm);
		$result3 = add_task_history($idnv_complete, $idtasksm, 'Completed', $today, 0);
		if ($result['code'] == 0 && $result1['code'] == 0){
			$_SESSION['complete_success'] = 'thành công';
			//header('Location: truongphong1.php');
			//exit();
		}
		else{
			$_SESSION['complete_failed'] = 'thất bại';
		}
	}
?> 
</head>
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
                            <a class="nav-link" href="formchung.php">HomePage</a>
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


    <div class="container" style="min-height: 100vh">
		<div class="title-text">
			<p>Manager</p>
		</div>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-9 col-md-8 first-item">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-4 col-5">
						<div class="image-user">
							<img src="../user-circle.png" class="rounded-circle">
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-sm-6 col-6 text-user">
						<h3><?=$nameManager?></h3>
						<p>Trưởng phòng ban <?=$departmentManager?></p>
					</div>
				</div>
            </div>
			
			<div class="col-lg-3 col-md-4 second-item-m">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-4 col-4">
						<button onclick="window.location.href='truongphong1.php'" class="btn btn-light border-dark">View submission</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-4 col-4">
						<button onclick="window.location.href='truongphong.php'" class="btn btn-light border-dark">View List Task</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-4 col-4">
						<button onclick="window.location.href='dayoff_employee.php'" class="btn btn-light border-dark">View Dayoff</button>
					</div>
				</div>
            </div> 
        </div>
		

		<div style="overflow-x:auto;">
			<table cellpadding="10" cellspacing="10" border="0" style=" margin: auto">
				<tr class="header">
					<td></td>
					<td>ID Submit</td>
					<td>ID Task</td>
					<td>Task name</td>
					<td>Employee</td>
					<td>Actions</td>
				</tr>
				<?php 
					$submission = get_all_submissions()['data'];
					foreach($submission as $submit) {
						$name_task = get_task($submit['idtask'])['data'][0]['name'];
						$assignee = search_employee($submit['idnv'])['data'][0]['name'];
						$idnv = $submit['idnv'];
						$attach = $submit['attach'];
						$idtask = $submit['idtask'];
						$idsm = $submit['idsm'];
						$status = $submit['turnin'];
				?>
					<tr class="item">
						<td>
							<a href="#" class="btn" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#view-submission" onclick="viewMission(this)">
								<span><i class="fas fa-eye"></i></span> 
							</a>
						</td>
						<td><?=$idsm?></td>
						<td><?=$idtask?></td>
						<td><?=$name_task?></td>
						<td><?=$idnv?></td>
						<td>
							<button class = "btn btn-danger reject" id="button-reject" href="#" data-toggle="modal" data-target="#reject-task" data-id="<?=$idtask?>" data-status="<?=$status?>" data-idsm="<?=$idsm?>" data-idnv="<?=$idnv?>">Reject</button>
							<button class = "btn btn-success complete" id="button-complete" href="#"  data-toggle="modal" data-target="#complete-task"  onclick="completeStatus(this)">Complete</button>
						</td>
					</tr>
				<?php 
					}
				?>
			</table>
		</div>
     </div> 

<div id="view-submission" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View Submission</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" id="body-submission">
					
					
				</div>

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>	 
	 
<!--Reject task-->		
<div id="reject-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Reject Task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id">ID task</label>
						<input readonly value="" name="id" required class="form-control" type="text" placeholder="" id="id">
					</div>
					<div class="form-group">
						<label for="idnv">ID employee</label>
						<input readonly value="" name="idnv" required class="form-control" type="text" placeholder="" id="idnv">
					</div>
					<div class="form-group">
						<p>Attach File</p>
						<div class="custom-file">
							<label class="custom-file-label" for="customFile"></label>
							<input value=""name=" attach" type="file" class="custom-file-input" id="customFile">			
						</div>
					</div>
					<div class="form-group">
						<label for="note">Note</label>
						<input value="" name="note" required class="form-control" type="text" placeholder="" id="note">
					</div>	
					<div class="form-group">
						<label for="deadline">Deadline</label>
						<input value="" name="deadline" required class="form-control" type="date" placeholder="Deadline" id="deadline">
					</div>
				</div>

				<div class="modal-footer">
					<input type = hidden name="reject" id="reject">
					<input type = hidden name="reject_idsm" id="reject_idsm">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Reject</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

<!--Complete task-->		
<div id="complete-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Complete Task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idtask">ID task</label>
						<input readonly value="" name="idtask" required class="form-control" type="text" placeholder="" id="idtask">
					</div>
					<div class="form-group">
						<label for="idsm">ID Submit</label>
						<input readonly value="" name="idsm" required class="form-control" type="text" placeholder="" id="idsm">
					</div>
					<div class="form-group">
						<label for="idnv">ID Employee</label>
						<input readonly value="" name="idnv" required class="form-control" type="text" placeholder="" id="idnv1">
					</div>
					<div class="form-group" id="tbody-details">
						
					</div>
				</div>

				<div class="modal-footer">
					<input type = hidden name="complete" id="complete">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Complete</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

<!--Add dayoff-->		
<div id="add-dayoff" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add DayOff Manager</h3>
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

	<footer>
		<p class="footer-text">Copyright @ Your Website</p>
	</footer>
<script src="../main.js"></script>

<?php
	//show toast message
	if(isset($_SESSION['reject_success']))
	{
		echo "<script>showSuccessToast('Reject task success')</script>";
		unset($_SESSION['reject_success']);
	}
	
	else if(isset($_SESSION['reject_failed']))
	{
		echo "<script>showErrorToast('Reject task failed')</script>";
		unset($_SESSION['reject_failed']);
	}

	else if(isset($_SESSION['complete_success']))
	{
		echo "<script>showSuccessToast('Complete task success')</script>";
		unset($_SESSION['complete_success']);
	}
	
	else if(isset($_SESSION['complete_failed']))
	{
		echo "<script>showErrorToast('Complete task failed')</script>";
		unset($_SESSION['complete_failed']);
	}
?>
</body>
</html>