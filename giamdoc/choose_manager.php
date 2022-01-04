<?php
	require_once('../db.php');
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
    <title>Trang Giám Đốc</title>

	<?php
		$error = '';
		
		if(isset($_POST['chooseManager']) && isset($_POST['id_choose']) && isset($_POST['department_choose']) && isset($_POST['idChooseManager']))
		{
			$chooseManager = $_POST['chooseManager'];
			$idChoose = $_POST['id_choose'];
			$departmentChoose = $_POST['department_choose'];
			$idChooseManager = $_POST['idChooseManager'];
			$result = update_manager($chooseManager, $idChoose);
			$result1 = reset_employee($departmentChoose);
			$result2 = update_position_employee($idChooseManager);
			$result3 = update_name_manager($chooseManager, $departmentChoose);
			$result4 = reset_role_account($departmentChoose);
			$result5 = get_tentk_by_id($idChooseManager);
			$data = $result5['data'];
			$result6 = update_role_account($data[0]['tentk']);
			
            if ($result['code'] == 0 && $result1['code'] == 0 && $result2['code'] == 0 && $result3['code'] == 0 && $result4['code'] == 0 && $result6['code'] == 0){
                // thành công
				//die('Choose Manager Successful');
                header('location: giamdoc.php');
                exit();
            }
			else if ($result['code'] == 2)
			{
				die('Người này đã là trưởng phòng hiện tại, không thể chọn! Hãy chọn người khác');
				//showFailedDialog('Failed Not Choose');
				//$error = $result['message'];
			}
			else {
                //$error = $result['message'];
				die('Choose Manager Failed');
				//showFailedDialog("Một người không thể làm trưởng 2 phòng ban");
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
                            <a class="nav-link" href="giamdoc.php">HomePage</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="#" style="color: white;">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
						<li class="nav-item">
							<div class="dropdown">
								<a class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="color: white;">
									<span><i class="far fa-user-circle"></i></span>
								</a>
								<div class="dropdown-menu dropdown-menu-lg-left">
									<a class="dropdown-item" href="../taikhoan/logout.php">Log out</a>
								</div>
							</div>
                        </li>
                    </ul>
                </div>
        </nav>
	<div class="container">
		<div style="overflow-x:auto;" class="mt-5">
			<h3 class="text-center mb-5 text-primary">Choose Manager For Department</h3>
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
				<tr class="header">
					<td>ID</td>
					<td>Name</td>
					<td>Department</td>
					<td>Actions</td>
				</tr>
				<?php
					if(isset($_POST['department']) && isset($_POST['id3']))
					{
						$id3 = $_POST['id3'];
						$name_department = $_POST['department'];
						$result = get_employee_by_department($name_department, $id3);
						if($result['code'] == 0)
						{
							$data = $result['data'];
							foreach ($data as $item){
								$id = $item['idnv'];
								$name = $item['name'];
								$department = $item['department'];
						?>
								<tr class="item">
									<td><?=$id?></td>
									<td><?=$name?></td>
									<td><?=$department?></td>
									<td>
										<a href="" class="btn btn-success choose" data-toggle="modal" data-target="#reset-modal" data-name="<?=$name?>" data-id="<?=$id?>">
											Choose
										</a>
									</td>
								</tr>
						<?php
							}
						}
						else if($result['code'] == 2){
							echo "<div class='alert alert-danger'>Phòng ban được chọn không hợp lệ</div>";
							echo "<p>Click <a href='giamdoc.php'>vào đây</a>để quay lại trang giám đốc và chọn lại phòng ban</p>";
						}
					}
				?>
			</table>
		</div> 
	</div>
	
<div id="reset-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<hp class="modal-title">Choose Manager</hp>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<p>Bạn có chắc rằng muốn chọn <strong id="temp"></strong> làm trưởng phòng ?</p>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="chooseManager" id="chooseManager">
						<input type="hidden" name="idChooseManager" id="idChooseManager">
						<input value="<?=$id3?>" name="id_choose" type ="hidden">
						<input value="<?=$department?>" name="department_choose" type ="hidden">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</div>
			</form>
        </div>
    </div>

<div class="alert alert-danger alert-dismissable" id="error-message" style="display:none">
	<a id="delete-failed-modal" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed!</strong> An unknown eror occured. Please try again later.
</div>

<link rel="stylesheet" href="../style.css">
<script src="../main.js"></script>
</body>
</html>