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
    <title>Trang Trưởng Phòng</title>

	<?php
		//check add task
		$id = '';
		$name = '';
		$desc = '';
		$idnv = '';
		$deadline = '';
		

		if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['idnv']) 
		&& isset($_POST['deadline']))
		{
			$id = $_POST['id'];
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$idnv = $_POST['idnv'];
			$deadline = $_POST['deadline'];


			if (empty($id)) {
				//$error = 'Hãy nhập số phòng ban';
				$_SESSION['error'] = 'thất bại';
			}
			else if (empty($name)) {
				//$error = 'Hãy nhập tên phòng ban';
				$_SESSION['error'] = 'thất bại';
			}
			else if (empty($desc)) {
				//$error = 'Hãy nhập trưởng phòng';
				$_SESSION['error'] = 'thất bại';
			}
			else if (empty($idnv)) {
				//$error = 'Hãy nhập liên hệ';
				$_SESSION['error'] = 'thất bại';
			}
			else if (empty($deadline)) {
				//$error = 'Hãy nhập số điện thoại';
				$_SESSION['error'] = 'thất bại';
			}

			else {
				$result = add_task($id, $name, $desc, $idnv, $deadline, $id_department);
				if ($result['code'] == 0){
					$_SESSION['success'] = 'thành công';
					//header('Location: truongphong.php');
					//exit();
				} 
				else {
					//$error = $result['message'];
					$_SESSION['failed'] = 'thất bại';
				}          
			}
		}
?>




<?php
	if(isset($_POST['id-task'])){
		$id = $_POST['id-task'];
		$result = update_task_canceled($id);
		if ($result['code'] == 0){
			// thành công
			//die('ADD DEPARTMENT SUCCESS');
			//header('Location: giamdoc.php');
			//exit();
			$_SESSION['canceled-success'] = 'thành công';
			//header('Location: truongphong.php');
			//exit();
		} 
		else {
			//$error = $result['message'];
			$_SESSION['canceled-failed'] = 'thất bại';
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
                            <a class="nav-link" href="#" style="color: white;">HomePage</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="dayoff_manager.php">DayOff</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.html">About Us</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="../contact.html">Contact Us</a>
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
					<td>
						<a href="#" style="color: black" data-toggle="modal" data-target="#add-task">
							<span><i class="fas fa-plus-circle"></i></span>	
						</a>
						<span> Add Task</span>
					</td>
					<td>Assignee</td>
					<td>Status</td>
				</tr>
				<?php 
					$tasks = get_all_tasks($id_department)['data'];
					foreach($tasks as $task) {
						$id = $task['idtask'];
						$name = $task['name'];
						$description = $task['description'];
						$assignee = search_employee($task['idnv'])['data'][0]['name'];
						$status = $task['status'];
						$deadline = $task['dueto'];
				?>
					<tr class="item viewTask temp" data-toggle="modal" data-target="#view-task" data-id="<?=$id?>" data-name="<?=$name?>" data-desc="<?=$description?>" data-assignee="<?=$assignee?>" data-status="<?=$status?>" data-deadline="<?=$deadline?>">
						<td><?=$name?></td>
						<td><?=$assignee?></td>
						<td><?=$status?></td>
					</tr>
				<?php 
					}
				?>
			</table>
		</div>
     </div>   
<!--view task-->		
<div id="view-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id-task">ID task</label>
						<input readonly value="" name="id-task" required class="form-control" type="text" placeholder="" id="id-task">
					</div>
					<div class="form-group">
						<label for="task-name">Task name</label>
						<input readonly value="" name="task-name" required class="form-control" type="text" placeholder="" id="task-name">
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<input readonly value="" name="status" required class="form-control" type="text" placeholder="" id="status">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input readonly value="" name="description" required class="form-control" type="text" placeholder="" id="description">
					</div>
					<div class="form-group">
						<label for="assignee">Assignee</label>
						<input readonly value="" name="assignee" required class="form-control" type="text" placeholder="" id="assignee">
					</div>
					<div class="form-group">
						<label for="due-to">Due to</label>
						<input readonly value="" name="due-to" required class="form-control" type="text" placeholder="" id="due-to">
					</div>
					
				</div>

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="editTask()">Edit</button>
					<button type="submit" class="btn btn-danger" id="button-cancel">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

<!--update task-->		
<div id="update-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Update task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id-task-u">ID task</label>
						<input readonly value="" name="id-task" required class="form-control" type="text" placeholder="" id="id-task-u">
					</div>
					<div class="form-group">
						<label readonly for="task-name-u">Task name</label>
						<input readonly value="" name="task-name" required class="form-control" type="text" placeholder="" id="task-name-u">
					</div>
					<div class="form-group">
						<label for="status-u">Status</label>
						<input readonly value="" name="status" required class="form-control" type="text" placeholder="" id="status-u">
					</div>
					<div class="form-group">
						<label for="assignee-u">Assignee</label>
						<input readonly value="" name="assignee" required class="form-control" type="text" placeholder="" id="assignee-u">
					</div>
					<div class="form-group">
						<label for="idnv-u">Assignee ID</label>
						<select name="idnv" required class="form-control" id="idnv-u">
							<?php
								$result = get_employee_by_id_task($id_department);
								$data = $result['data'];
								foreach ($data as $item){
									$idemployee = $item['idnv'];
							?>
									<option value="<?=$idemployee?>"><?=$idemployee?></option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="description-u">Description</label>
						<input value="" name="description" required class="form-control" type="text" placeholder="" id="description-u">
					</div>
					<div class="form-group">
						<label for="due-to-u">Due to</label>
						<input value="" name="due-to" required class="form-control" type="date" placeholder="" id="due-to-u">
					</div>
					
				</div>

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button id="update-button" type="button" class="btn btn-primary" id="button-cancel">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--Add task-->	 
<div id="add-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="truongphong.php" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add Task</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id">ID</label>
						<input value="" name="id" required class="form-control" type="text" placeholder="ID" id="id">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input value="" name="name" required class="form-control" type="text" placeholder="Name" id="name">
					</div>
					<div class="form-group">
						<label for="desc">Description</label>
						<input value="" name="desc" required class="form-control" type="text" placeholder="Description" id="desc">
					</div>
					<div class="form-group">
						<label for="idnv">Id Of Employee</label>
						<select name="idnv" required class="form-control" id="idnv">
							<?php
								$result = get_employee_by_id_task($id_department);
								$data = $result['data'];
								foreach ($data as $item){
									$idemployee = $item['idnv'];
							?>
									<option value="<?=$idemployee?>"><?=$idemployee?></option>
							<?php
								}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="deadline">Deadline</label>
						<input value="" name="deadline" required class="form-control" type="date" placeholder="Deadline" id="deadline">
					</div>

				</div>
	
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Add</button>
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
	if(isset($_SESSION['success']))
	{
		echo "<script>showSuccessToast('Add Task success')</script>";
		unset($_SESSION['success']);
	}

	else if(isset($_SESSION['error']))
	{
		echo "<script>showErrorToast('Please enter full information')</script>";
		unset($_SESSION['error']);
	}
	
	else if(isset($_SESSION['failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['failed']);
	}

	else if(isset($_SESSION['canceled-success']))
	{
		echo "<script>showSuccessToast('Canceled task success')</script>";
		unset($_SESSION['canceled-success']);
	}

	else if(isset($_SESSION['canceled-failed']))
	{
		echo "<script>showErrorToast('Canceled task failed')</script>";
		unset($_SESSION['canceled-failed']);
	}

?>
<?php
	echo "<script>cannotCancel()</script>";
?>
</body>
</html>