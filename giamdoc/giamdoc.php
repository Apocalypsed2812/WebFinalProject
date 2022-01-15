<?php
	session_start();
	require_once('../db.php');
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
<?php
	//check add department
	$error = '';
	$id = '';
    $name = '';
    $contact = '';
	$phone = '';
	$describe = '';

    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['contact']) 
	&& isset($_POST['phone']) && isset($_POST['describe']))
    {
		$id = $_POST['id'];
        $name = $_POST['name'];
		$contact = $_POST['contact'];
		$phone = $_POST['phone'];
        $describe = $_POST['describe'];


        if (empty($id)) {
            //$error = 'Hãy nhập số phòng ban';
			$_SESSION['error'] = 'thất bại';
        }
		else if (empty($name)) {
            //$error = 'Hãy nhập tên phòng ban';
			$_SESSION['error'] = 'thất bại';
        }
		else if (empty($contact)) {
            //$error = 'Hãy nhập liên hệ';
			$_SESSION['error'] = 'thất bại';
        }
		else if (empty($phone)) {
            //$error = 'Hãy nhập số điện thoại';
			$_SESSION['error'] = 'thất bại';
        }
        else if (empty($describe)) {
            //$error = 'Hãy nhập mô tả của phòng ban';
			$_SESSION['error'] = 'thất bại';
        }
        else {
            $result = add_department($id, $name, $contact, $phone, $describe);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc.php');
                //exit();
				$_SESSION['success'] = 'thành công';
				//echo "<script>showSuccessToast()</script>";
            } 
			else {
                //$error = $result['message'];
				$_SESSION['failed'] = 'thất bại';
            }          
        }
    }
?>

<?php
	//check update department
	$error1 = '';
	$id1 = '';
    $name1 = '';
    $contact1 = '';
	$phone1 = '';
	$describe1 = '';

    if (isset($_POST['id1']) && isset($_POST['name1']) && isset($_POST['contact1']) 
	&& isset($_POST['phone1']) && isset($_POST['describe1']) && isset($_POST['update']))
    {
		$id1 = $_POST['id1'];
        $name1 = $_POST['name1'];
		$contact1 = $_POST['contact1'];
		$phone1 = $_POST['phone1'];
        $describe1 = $_POST['describe1'];
		$id = $_POST['update'];

		if (empty($name1)) {
            $error = 'Hãy nhập tên phòng ban';
        }
		else if (empty($contact1)) {
            $error = 'Hãy nhập liên hệ';
        }
		else if (empty($phone1)) {
            $error = 'Hãy nhập số điện thoại';
        }
        else if (empty($describe1)) {
            //$error = 'Hãy nhập mô tả của phòng ban';
			$_SESSION['update_error'] = 'thành công';
        }
        else {
            $result = update_department($id1, $name1, $contact1, $phone1, $describe1, $id);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc.php');
                //exit();
				$_SESSION['update_success'] = 'thành công';
            } else {
                //$error1 = $result['message'];
				$_SESSION['update_failed'] = 'thành công';
            }          
        }
    }
?>

<?php
	//delete department
	if (isset($_POST['delete']))
	{
		$idDelete = $_POST['delete'];
		$result = delete_department($idDelete);
            if ($result['code'] == 0){
                // thành công
				//die('ADD DEPARTMENT SUCCESS');
                //header('Location: giamdoc.php');
                //exit();
				$_SESSION['delete_success'] = 'thành công';
            } else {
                //$error = $result['message'];
				//die("Delete failed");
				$_SESSION['delete_failed'] = 'thành công';
            }          
	}
?>
</head>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="giamdoc.php">HomePage</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="#">Service</a>
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
			
			<div class="col-lg-3 col-md-4 second-item-m">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12 btnem">
						<button onclick="employeePage()" class="btn btn-light border-dark">View List Employees</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12 btnday">
						<button onclick="dayOffPage()" class="btn btn-light border-dark">View List Day Off</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<button onclick="requestPage()" class="btn btn-light border-dark">Reset Password</button>
					</div>
				</div>
            </div> 
        </div>
		
		
		<div class="row" style="margin-bottom: 20px">
            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
				<form action="" method="post">
					<div class="form-group search" style="border: 1px solid gray; border-radius: 8px">
						<input type="search" id="form" name="search" class="form-control" placeholder="Search Department...">
					</div>
				</form>
            </div>

			<div class="col-lg-1 col-md-1">
            </div>
			
			<div class="col-lg-2 col-md-2 col-sm-4 col-4 text-left add">
				<button class="btn" style = "font-weight: bold; color: black; border: 1px solid black" data-toggle="modal" data-target="#add-modal">Add</button>
            </div>
			
			<div class="col-lg-2 col-md-2 col-sm-4 col-4 text-center chooseManage">
				<button class="btn" style = "font-weight: bold; color: black; border: 1px solid black" data-toggle="modal" data-target="#chooseManager-modal">Choose</button>
            </div>
			
			
			<div class="col-lg-2 col-md-2 col-sm-4 col-4 sort text-right">
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
					<td>Manager</td>
					<td>Contact</td>
					<td>Phone</td>
					<td>Descirbe</td>
				</tr>
				<?php
					if(isset($_POST['search']))
					{
						$temp = $_POST['search'];
						$result = search_department($temp);
					}
					else if(isset($_POST['asc']))
					{
						$result = sort_by_az();
					}
					else if(isset($_POST['desc']))
					{
						$result = sort_by_za();
					}
					else{
						$result = get_department();
					}
					
					$data = $result['data'];
					foreach ($data as $item){
						$id = $item['id'];
						$name = $item['name'];
						$manager = $item['manager'];
						$contact = $item['contact'];  
						$phone = $item['phone'];  
						$describe = $item['description'];  
				?>
						<tr class="item">
							<td>
								<a href="#" class="btn view" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#info-modal" data-id="<?=$id?>" data-name="<?=$name?>" data-manager="<?=$manager?>" data-contact="<?=$contact?>" data-phone="<?=$phone?>" data-describe="<?=$describe?>">
									<span><i class="fas fa-eye"></i></span> 
								</a>
								<a href="#" class="btn edit idUpdate" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#update-modal" data-id="<?=$id?>" data-name="<?=$name?>" data-manager="<?=$manager?>" data-contact="<?=$contact?>" data-phone="<?=$phone?>" data-describe="<?=$describe?>">
								<span><i class="fas fa-pen"></i></span>
								</a>
								<a href="#" class="btn delete_department" style="border-radius: 70%; background-color: #D8D8D8" data-toggle="modal" data-target="#delete-modal" data-id="<?=$id?>" data-name="<?=$name?>" data-manager="<?=$manager?>" data-contact="<?=$contact?>" data-phone="<?=$phone?>" data-describe="<?=$describe?>">
									<span><i class="fas fa-trash-alt"></i></span> 
								</a>
							</td>
							<td><?=$id?></td>
							<td><?=$name?></td>
							<td><?=$manager?></td>
							<td><?=$contact?></td>
							<td><?=$phone?></td>
							<td><?=$describe?></td>
						</tr>
				<?php
					}
				?>
			</table>
		</div>
     </div> 

<!--Add department modal-->	 
<div id="add-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add Department</h3>
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
						<label for="contact">Contact</label>
						<input value="" name="contact" required class="form-control" type="text" placeholder="Contact" id="contact">
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input value="" name="phone" required class="form-control" type="text" placeholder="Phone" id="phone">
					</div>
					<div class="form-group">
						<label for="describe">Descirbe</label>
						<textarea id="describe" name="describe" rows="4" class="form-control" placeholder="Describe"></textarea>
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

<!--Update department modal-->	 	
<div id="update-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Update Department</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id1">ID</label>
						<input value="" name="id1" required class="form-control" type="text" placeholder="ID" id="id1">
					</div>
					<div class="form-group">
						<label for="name1">Name</label>
						<input value="" name="name1" required class="form-control" type="text" placeholder="Name" id="name1">
					</div>
					<div class="form-group">
						<label for="contact1">Contact</label>
						<input value="" name="contact1" required class="form-control" type="text" placeholder="Contact" id="contact1">
					</div>
					<div class="form-group">
						<label for="phone1">Phone</label>
						<input value="" name="phone1" required class="form-control" type="text" placeholder="Phone" id="phone1">
					</div>
					<div class="form-group">
						<label for="describe1">Descirbe</label>
						<textarea id="describe1" name="describe1" rows="4" class="form-control" placeholder="Describe"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<?php
						if (!empty($error)) {
							echo "<div class='alert alert-danger'>$error1</div>";
						}
					?>
                </div>

				<div class="modal-footer">
					<input type="hidden" name="update" id="id_department">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--Choose manager modal-->	 
<div id="chooseManager-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="choose_manager.php" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Choose Manager</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id3_gd">Id Of Department</label>
						<select name="id3_gd" required class="form-control" id="id3_gd">
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
						<label for="department_gd">Name Of Department</label>
						<input value="Nhân Sự" readonly name="department_gd" required class="form-control" id="department_gd">
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" onclick="managerLocation()" class="btn btn-success">Choose</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--View department modal-->	 
<div id="info-modal" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View Information Department</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idinfo">ID</label>
						<input readonly value="" name="id" required class="form-control" type="text" placeholder="Idinfo" id="id2">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input readonly value="" name="name" required class="form-control" type="text" placeholder="Name" id="name2">
					</div>
					<div class="form-group">
						<label for="manager">Manager</label>
						<input readonly value="" name="manager" required class="form-control" type="text" placeholder="" id="manager2">
					</div>
					<div class="form-group">
						<label for="contact">Contact</label>
						<input readonly value="" name="contact" required class="form-control" type="text" placeholder="Contact" id="contact2">
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input readonly value="" name="phone" required class="form-control" type="text" placeholder="Phone" id="phone2">
					</div>
					<div class="form-group">
						<label for="describe">Descirbe</label>
						<textarea readonly id="describe2" name="describe" rows="4" class="form-control" placeholder="Describe"></textarea>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
				</div>
			</div>
	</div>
</div>

<!-- Delete Confirm Modal -->
<div id="delete-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Department</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete the department <strong id ="name_delete"></strong> ?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="delete" id="id_delete_department">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete</button>
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
		echo "<script>showSuccessToast('Add department success')</script>";
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
	
	else if(isset($_SESSION['update_success']))
	{
		echo "<script>showSuccessToast('Update department success')</script>";
		unset($_SESSION['update_success']);
	}

	else if(isset($_SESSION['update_error']))
	{
		echo "<script>showErrorToast('Please enter full information')</script>";
		unset($_SESSION['update_error']);
	}
	
	else if(isset($_SESSION['update_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['update_failed']);
	}	

	else if(isset($_SESSION['delete_success']))
	{
		echo "<script>showSuccessToast('Delete department success')</script>";
		unset($_SESSION['delete_success']);
	}
	
	else if(isset($_SESSION['delete_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['delete_failed']);
	}	
	else if(isset($_SESSION['register_success']))
	{
		echo "<script>showSuccessToast('Register successfully')</script>";
		unset($_SESSION['register_success']);
	}
	else if(isset($_SESSION['choose_manager_success']))
	{
		echo "<script>showSuccessToast('Choose manager successfully')</script>";
		unset($_SESSION['choose_manager_success']);
	}	
	else if(isset($_SESSION['choose_manager_error']))
	{
		echo "<script>showErrorToast('Please choose other')</script>";
		unset($_SESSION['choose_manager_error']);
	}
	else if(isset($_SESSION['choose_manager_failed']))
	{
		echo "<script>showErrorToast('An occured error, please try again')</script>";
		unset($_SESSION['choose_manager_failed']);
	}
?>
</body>
</html>