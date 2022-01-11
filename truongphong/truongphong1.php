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
	$submission = get_all_submissions()['data'];
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
    <title>Trang Trưởng Phòng</title>
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
            $result = add_dayoff_employee($numday, $reason, $attach, $user);
            if ($result['code'] == 0){
				$update_dayoff_employee_ngaydasudung = update_dayoff_employee_ngaydasudung($numday, $user);
				$update_dayoff_employee_ngayconlai = update_dayoff_employee_ngayconlai($numday, $user);
				if ($_FILES['attach']['name'] != NULL) {
					// Kiểm tra file có vượt quá 20MB không
					if ($_FILES['attach']['size'] > 20 * 1048576) {
						echo "<script> alert('File đăng tải không phải là file ảnh!'); window.location='truongphong.php'; </script>";
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
								echo "<script> alert('Upload thành công!'); window.location='truongphong.php'; </script>";
							} else {
								echo "<script> alert('Upload không thành công!'); window.location='truongphong.php'; </script>";
							}
						} else {
							echo "<script> alert('File không được phép upload!'); window.location='truongphong.php'; </script>";
						}
					}
				} 
				else 
				{
					echo "<script> alert('File không được để trống!'); window.location='truongphong.php'; </script>";
				}
				header('Location: truongphong.php');
				exit();
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
<?php
	//reject task
	if(isset($_POST['reject']))
	{
		$id = $_POST['id'];
		$idnv = $_POST['idnv'];
		$attach = $_FILES['attach']['name'];
		$note = $_POST['note'];
		$deadline_add = $_POST['deadline'];
		$result = update_task_rejected($id);
		$result1 = add_reject($idnv, $id, $attach, $note);
		$result2 = update_deadline_reject($deadline_add, $id);
		if ($result['code'] == 0){
			if ($_FILES['attach']['name'] != NULL) {
				// Kiểm tra file có vượt quá 20MB không
				if ($_FILES['attach']['size'] > 20 * 1048576) {
					echo "<script> alert('File đăng tải không phải là file ảnh!'); window.location='truongphong1.php'; </script>";
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
							echo "<script> alert('Upload thành công!'); window.location='truongphong1.php'; </script>";
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
		else{

		}
	}
?> 

<?php
	//complete task
	if(isset($_POST['complete']))
	{
		$idtasksm = $_POST['idtask'];
		$idsm1 = $_POST['idsm'];
		$evaluate = $_POST['evaluate'];
		$result = update_task_completed($idtasksm);
		$result1 = update_token_rc($idsm1);
		$result2 = add_evaluate($evaluate, $idtasksm);
		if ($result['code'] == 0 && $result1['code'] == 0){
			header('Location: truongphong1.php');
			exit();
		}
		else{

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
					<td>ID Submit</td>
					<td>ID Task</td>
					<td>Task name</td>
					<td>Attach</td>
					<td>Actions</td>
				</tr>
				<?php 
					foreach($submission as $submit) {
						$name_task = get_task($submit['idtask'])['data'][0]['name'];
						$assignee = search_employee($submit['idnv'])['data'][0]['name'];
						$attach = $submit['attach'];
						$idtask = $submit['idtask'];
						$idsm = $submit['idsm'];
						$status = $submit['turnin'];
				?>
					<tr class="item" data-toggle="modal" data-target="#view-task">
						<td><?=$idsm?></td>
						<td><?=$idtask?></td>
						<td><?=$name_task?></td>
						<td><a href="../minhchung/<?=$attach?>"><?=$attach?></a></td>
						<td>
							<button class = "btn btn-danger" id="button-reject" href="#" data-toggle="modal" data-target="#reject-task" data-id="<?=$id?>" data-status="<?=$status?>">Reject</button>
							<button class = "btn btn-success complete" id="button-complete" href="#"  data-toggle="modal" data-target="#complete-task"  onclick="completeStatus(this)">Complete</button>
						</td>
					</tr>
				<?php 
					}
				?>
			</table>
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
						<input value="" name="id" required class="form-control" type="text" placeholder="" id="id">
					</div>
					<div class="form-group">
						<label for="idnv">ID employee</label>
						<input value="" name="idnv" required class="form-control" type="text" placeholder="" id="idnv">
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
						<input value="" name="idtask" required class="form-control" type="text" placeholder="" id="idtask">
					</div>
					<div class="form-group">
						<label for="idsm">ID Submit</label>
						<input value="" name="idsm" required class="form-control" type="text" placeholder="" id="idsm">
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
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</body>
</html>