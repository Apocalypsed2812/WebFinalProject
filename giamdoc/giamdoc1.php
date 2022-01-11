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
	//check add employee
	$error = '';
	$id = '';
    $name = '';
    $tentk = '';
    $position = '';
	$department = '';

    if (isset($_POST['name']) && isset($_POST['user']) && isset($_POST['position']) 
	&& isset($_POST['department']) && isset($_POST['idnv']) 
	&& isset($_POST['id_department']) && isset($_POST['email']) && isset($_POST['phone']) 
	&& isset($_POST['indentity']) && isset($_POST['gender'])
	&& isset($_POST['role']))
    {
		$id = $_POST['idnv'];
        $name = $_POST['name'];
        $user = $_POST['user'];
		$position = $_POST['position'];
		$department = $_POST['department'];
		$id_department = $_POST['id_department'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$indentity = $_POST['indentity'];
		$gender = $_POST['gender'];
		$role = $_POST['role'];
	
		if (empty($id)) {
            //$error = 'Hãy nhập mã nhân viên';
			$_SESSION['addemployee_error'] = 'thất bại';
        }
        else if (empty($name)) {
            //$error = 'Hãy nhập tên nhân viên';
			$_SESSION['addemployee_error'] = 'thất bại';
        }
		else if (empty($user)) {
            //$error = 'Hãy nhập tên tài khoản của nhân viên';
			$_SESSION['addemployee_error'] = 'thất bại';
        }
		else if (empty($position)) {
            //$error = 'Hãy nhập chức vụ của nhân viên';
			$_SESSION['addemployee_error'] = 'thất bại';
        }
		else if (empty($department)) {
            //$error = 'Hãy nhập phòng ban của nhân viên';
			$_SESSION['addemployee_error'] = 'thất bại';
        }
        else {
			$image = $_FILES['image']['name'];  
            $result = add_employee($id, $name, $user, $position, $department, $id_department, $email, $phone, $indentity, $gender, $image, $role);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc1.php');
                //exit();
				$_SESSION['addemployee_success'] = 'thành công';
            } 
			else if ($result['code'] == 4){
				$_SESSION['error_choose_department'] = 'lỗi chọn phòng ban';
            }else {
                //$error = $result['message'];
				$_SESSION['addemployee_failed'] = 'thất bại';
            }          
        }
    }
?>

<?php
	//check delete employee
	if (isset($_POST['delete']))
	{
		$idDelete = $_POST['delete'];
		$result = delete_employee($idDelete);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc1.php');
                //exit();
				$_SESSION['delete_success'] = 'thành công';
            } else {
                //$error = $result['message'];
				//die("Delete failed");
				$_SESSION['delete_failed'] = 'thành công';
            }          
	}
?>

<?php
	//check update employee
	$error2 = '';
	$id2 = '';
    $name2 = '';
    $tentk2 = '';
    $position2 = '';
	$department2 = '';
	
    if (isset($_POST['namenv2']) && isset($_POST['idnv2']) && isset($_POST['tentk2']) 
	&& isset($_POST['position2']) && isset($_POST['updateEmployee'])
	&& isset($_POST['email2']) && isset($_POST['phone2'])
	&& isset($_POST['indentity2']) && isset($_POST['gender2']))
    {
		$id2 = $_POST['idnv2'];
        $name2 = $_POST['namenv2'];
        $tentk2 = $_POST['tentk2'];
		$position2 = $_POST['position2'];
		$email2  = $_POST['email2'];
		$phone2  = $_POST['phone2'];
		$indentity2  = $_POST['indentity2'];
		$gender2  = $_POST['gender2'];
		$id = $_POST['updateEmployee'];

		if (empty($id2)) {
            $error = 'Hãy nhập mã nhân viên';
        }
		else if (empty($name2)) {
            $error = 'Hãy nhập tên nhân viên';
        }
		else if (empty($tentk2)) {
            $error = 'Hãy nhập tên tài khoản';
        }
		else if (empty($position2)) {
            $error = 'Hãy nhập chức vụ của nhân viên';
        }
        else {
            $result = update_employee($id2, $name2, $tentk2, $position2, $email2, $phone2, $indentity2, $gender2, $id);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc1.php');
                //exit();
				$_SESSION['update_success'] = 'thành công';
            } else {
                //$error2 = $result['message'];
				$_SESSION['update_failed'] = 'thành công';
            }          
        }
    }
?>
<body>
	<div id="toast">
    </div>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
                <a class="navbar-brand" href="">Our Company</a>
    
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
                            <a class="nav-link" href="../giamdoc/request.php">Reset Password</a>
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


    <div class="container">
		<div class="title-text">
			<p>GIÁM ĐỐC ĐIỀU HÀNH</p>
		</div>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-9 col-md-8 first-item">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-4 col-5">
						<div class="image-user">
							<img src="../user-circle.png" class="rounded-circle">
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-sm-6 col-7 text-user">
						<h3>Director</h3>
						<p>director@gmail.com</p>
					</div>
				</div>
            </div>
			
			<div class="col-lg-3 col-md-4  second-item">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-6 col-12">
						<button onclick="departmentPage()" class="btn" style="color: black; border: black solid 1px">View List Department</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-12">
						<button onclick="dayOffPage()" class="btn" style="color: black; border: black solid 1px">View List Day Off</button>
					</div>
				</div>
            </div> 
        </div>
		
		
		<div class="row" style="margin-bottom: 20px">
            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
				<form action="" method="post">
					<div class="form-group search" style="border: 1px solid gray; border-radius: 8px">
						<input type="search" id="form" name="search" class="form-control" placeholder="Search Employee...">
					</div>
				</form>
            </div>

			<div class="col-lg-3 col-md-1">
            </div>
			
			<div class="col-lg-2 col-md-2 col-sm-6 col-6 add text-left">
				<button class="btn" style = "font-weight: bold; color: black; border: 1px solid black" data-toggle="modal" data-target="#add-modal">Add</button>
            </div>
			
			<div class="col-lg-2 col-md-3 col-sm-6 col-6 sort text-right">
				<div class="dropdown">
					<button class="btn" style = "font-weight: bold; color: black; border: 1px solid black" class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">Sort</button>			
					<div class="dropdown-menu dropdown-menu-lg-left">
						<form action="" method="post">
							<input type="hidden" name="asc" id="asc">
							<button type="submit" class="dropdown-item">A->Z</button>
						</form>
						<form action="" method="post">
							<input type="hidden" name="desc" id="desc">
							<button type="submit" class="dropdown-item">Z->A</button>
						</form>
					</div>
				</div>
            </div>
			
		</div>

		<div style="overflow-x:auto;">
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
				<tr class="header">
					<td></td>
					<td>ID</td>
					<td>Name</td>
					<td>Email</td>
					<td>Position</td>
					<td>Department</td>
				</tr>
				<?php
					if(isset($_POST['search']))
					{
						$temp = $_POST['search'];
						$result = search_employee($temp);
					}
					else if(isset($_POST['asc']))
					{
						$result = sort_by_az_employee();
					}
					else if(isset($_POST['desc']))
					{
						$result = sort_by_za_employee();
					}
					else{
						$result = get_employee();
					}
					
					$data = $result['data'];
					foreach ($data as $item){
						$idnv = $item['idnv'];
						$name = $item['name'];
						$username = $item['username'];
						$position = $item['position'];
						$email =  $item['email'];
						$department = $item['department']; 
						$id_department = $item['id_department']; 
						$phone = $item['phone']; 
						$indentity = $item['indentity'];
						$gender = $item['gender'];
				?>
						<tr class="item">
							<td>
								<a href="#" class="btn viewEmployee" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#info-modal" data-id="<?=$idnv?>" data-name="<?=$name?>" data-tentk="<?=$username?>" data-position="<?=$position?>" data-department="<?=$department?>" data-iddepartment="<?=$id_department?>" data-email="<?=$email?>" data-phone="<?=$phone?>" data-indentity="<?=$indentity?>" data-gender="<?=$gender?>">
									<span><i class="fas fa-eye"></i></span> 
								</a>
								<a href="#" class="btn deleteEmployee" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#delete-modal" data-id="<?=$idnv?>" data-name="<?=$name?>" data-tentk="<?=$tentk?>" data-position="<?=$position?>" data-department="<?=$department?>">
									<span><i class="fas fa-trash-alt"></i></span> 
								</a>
								<a href="#" class="btn editEmployee" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#update-modal" data-id="<?=$idnv?>" data-name="<?=$name?>" data-tentk="<?=$username?>" data-position="<?=$position?>" data-department="<?=$department?>" data-iddepartment="<?=$id_department?>" data-email="<?=$email?>" data-phone="<?=$phone?>" data-indentity="<?=$indentity?>" data-gender="<?=$gender?>">
									<span><i class="fas fa-pen"></i></span> 
								</a>
							</td>
							<td><?=$idnv?></td>
							<td><?=$name?></td>
							<td><?=$email?></td>
							<td><?=$position?></td>
							<td><?=$department?></td>
						</tr>
				<?php
					}
				?>
			</table>
		</div>
     </div>   

<!--view information modal employee-->
<div id="info-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View Information Employee</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idnv">ID</label>
						<input readonly value="" name="idnv" required class="form-control" type="text" placeholder="Idnv" id="idnv">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input readonly value="" name="name" required class="form-control" type="text" placeholder="Name" id="namenv">
					</div>
					<div class="form-group">
						<label for="username">TenTK</label>
						<input readonly value="" name="username" required class="form-control" type="text" placeholder="Username" id="username">
					</div>
					<div class="form-group">
						<label for="position">Position</label>
						<input readonly value="" name="position" required class="form-control" type="text" placeholder="Position" id="position">
					</div>
					<div class="form-group">
						<label for="department">Department</label>
						<input readonly value="" name="department" required class="form-control" type="text" placeholder="Department" id="department">
					</div>
					<div class="form-group">
						<label for="id_department">ID Of Department</label>
						<input readonly value="" name="id_department" required class="form-control" type="text" placeholder="Id department" id="id_department">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input readonly value="" name="email" required class="form-control" type="text" placeholder="Email" id="email">
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input readonly value="" name="phone" required class="form-control" type="text" placeholder="Phone" id="phone">
					</div>
					<div class="form-group">
						<label for="indentity">Indentity</label>
						<input readonly value="" name="indentity" required class="form-control" type="text" placeholder="Indentity" id="indentity">
					</div>
					<div class="form-group">
						<label for="gender">Gender</label>
						<input readonly value="" name="gender" required class="form-control" type="text" placeholder="Gender" id="gender">
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
				</div>
			</div>
	</div>
</div>

<!--Add modal employee-->
<div id="add-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add Employee</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idnv">ID</label>
						<input value="" name="idnv" required class="form-control" type="text" placeholder="Idnv" id="idnv1">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input value="" name="name" required class="form-control" type="text" placeholder="Name" id="namenv1">
					</div>
					<div class="form-group">
						<label for="user">Username</label>
						<input value="" name="user" required class="form-control" type="text" placeholder="Username" id="user1">
					</div>
					<div class="form-group">
						<label for="position">Position</label>
						<select name="position" required class="form-control" id="position">
							<option value="male">Manager</option>
							<option value="female">Employee</option>
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
						<label for="id_department">ID Of Department</label>
						<select name="id_department" required class="form-control" id="id_department1">
							<?php
								$result = get_id_department();
								$data = $result['data'];
								foreach ($data as $item){
									$iddepartment = $item['id'];
							?>
									<option value="<?=$iddepartment?>"><?=$iddepartment?></option>
							<?php
								}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input value="" name="email" required class="form-control" type="text" placeholder="Email" id="email1">
					</div>

					<div class="form-group">
						<label for="phone">Phone</label>
						<input value="" name="phone" required class="form-control" type="text" placeholder="Phone" id="phone1">
					</div>

					<div class="form-group">
						<label for="indentity">Indentity</label>
						<input value="" name="indentity" required class="form-control" type="text" placeholder="Indentity" id="indentity1">
					</div>

					<div class="form-group">
						<label for="gender">Gender</label>
						<select name="gender" required class="form-control" id="gender1">
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>

					<div class="form-group">
                        <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
                            <label class="custom-file-label" for="customFile">Ảnh đại diện</label>
                        </div>
                    </div>

					<div class="form-group">
						<label for="role">Role</label>
						<select name="role" required class="form-control" id="role1">
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

				</div>
				
				<div class="form-group">
					<?php
						if (!empty($error)) {
							echo "<div class='alert alert-danger'>$error</div>";
						}
					?>
                </div>

				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Add</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

<!-- Delete Confirm Modal -->
<div id="delete-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Employee</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<p>Bạn có chắc rằng muốn xóa nhân viên <strong id ="name_delete_employee"></strong> ?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="delete" id="id_delete">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Xóa</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--Update employee modal-->	 	
<div id="update-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Update Employee</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idnv2">ID</label>
						<input value="" name="idnv2" required class="form-control" type="text" placeholder="Idnv" id="idnv2">
					</div>
					<div class="form-group">
						<label for="name2">Name</label>
						<input value="" name="namenv2" required class="form-control" type="text" placeholder="Name" id="namenv2">
					</div>
					<div class="form-group">
						<label for="tentk2">TenTk</label>
						<input value="" name="tentk2" required class="form-control" type="text" placeholder="Tentk" id="tentk2">
					</div>
					<div class="form-group">
						<label for="position2">Position</label>
						<input value="" name="position2" required class="form-control" type="text" placeholder="Position" id="position2">
					</div>
					<div class="form-group">
						<label for="department2">Department</label>
						<input readonly value="" name="department2" required class="form-control" type="text" placeholder="Position" id="department2">
					</div>
					<div class="form-group">
						<label for="id_department2">ID Of Department</label>
						<input readonly value="" name="id_department2" required class="form-control" type="text" placeholder="Position" id="id_department2">
					</div>
					<div class="form-group">
						<label for="email2">Email</label>
						<input value="" name="email2" required class="form-control" type="text" placeholder="Email" id="email2">
					</div>

					<div class="form-group">
						<label for="phone2">Phone</label>
						<input value="" name="phone2" required class="form-control" type="text" placeholder="Phone" id="phone2">
					</div>

					<div class="form-group">
						<label for="indentity2">Indentity</label>
						<input value="" name="indentity2" required class="form-control" type="text" placeholder="Indentity" id="indentity2">
					</div>

					<div class="form-group">
						<label for="gender2">Gender</label>
						<input value="" name="gender2" required class="form-control" type="text" placeholder="Indentity" id="gender2">
					</div>
				</div>
				
				<div class="form-group">
					<?php
						if (!empty($error)) {
							echo "<div class='alert alert-danger'>$error2</div>";
						}
					?>
                </div>

				<div class="modal-footer">
					<input type="hidden" name="updateEmployee" id="id_employee">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Update</button>
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
	if(isset($_SESSION['addemployee_success']))
	{
		echo "<script>showSuccessToast('Add employee success')</script>";
		unset($_SESSION['addemployee_success']);
	}	
	else if(isset($_SESSION['addemployee_error']))
	{
		echo "<script>showErrorToast('Please enter full information')</script>";
		unset($_SESSION['addemployee_error']);
	}
	else if(isset($_SESSION['addemployee_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['addemployee_failed']);
	}	
	else if(isset($_SESSION['update_success']))
	{
		echo "<script>showSuccessToast('Update employee success')</script>";
		unset($_SESSION['update_success']);
	}
	else if(isset($_SESSION['update_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['update_failed']);
	}	

	else if(isset($_SESSION['delete_success']))
	{
		echo "<script>showSuccessToast('Delete employee success')</script>";
		unset($_SESSION['delete_success']);
	}
	
	else if(isset($_SESSION['delete_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['delete_failed']);
	}	
	else if(isset($_SESSION['error_choose_department']))
	{
		echo "<script>showErrorToast('Department choose not exist')</script>";
		unset($_SESSION['error_choose_department']);
	}	
	
?>
</body>
</html>