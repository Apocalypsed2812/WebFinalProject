<?php
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
        header('Location: ../taikhoan/login.php');
        exit();
    }
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
	<link rel="stylesheet" href="../style.css">
    <title>Trang Trưởng Phòng</title>
</head>
<?php
	if(isset($_POST['approved']))
	{
		$tentk = $_POST['approved'];
		$result = update_status_approved($tentk);
		if($result['code'] == 0)
		{
			$_SESSION['dayoffapproved'] = 'thành công rồi';
			//header('Location: dayoff.php');
		}
		else{
			//die('An occrud error approved');
			$_SESSION['error'] = 'thất bại';
		}
	}
	
	else if(isset($_POST['refused']))
	{
		$tentk = $_POST['refused'];
		$result = update_status_refused($tentk);
		if($result['code'] == 0)
		{
			$_SESSION['dayoffrefused'] = 'thành công rồi';
			//header('Location: dayoff.php');
		}
		else{
			//die('An occrud error refused');
			$_SESSION['error'] = 'thất bại';
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
                            <a class="nav-link" href="truongphong.php">HomePage</a>
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
		<div style="overflow-x:auto;" class="mt-5">
			<h3 class="text-center mb-5 text-primary">Request Day Off</h3>
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
				<tr class="header">
					<td>ID</td>
					<td>Number Off</td>
					<td>Reason</td>
					<td>Attach File</td>
					<td>Actions</td>
					<td></td>
				</tr>
				<?php
					$result = get_dayoff_employee();
					$data = $result['data'];
					foreach ($data as $item){
						$id = $item['id'];
						$numoff = $item['numberoff'];
						$reason = $item['reason'];
						$attach = $item['attach'];
						$tentk = $item['tentk'];
				?>
						<tr class="item">
							<td><?=$id?></td>
							<td><?=$numoff?></td>
							<td><?=$reason?></td>
							<td><a href="../minhchung/<?=$attach?>"><?=$attach?></a></td>
							<td>
								<a href="" class="btn btn-primary" data-toggle="modal" data-target="#dayoff-modal" onclick = "viewDayoff(this)">
									Detail
								</a>
							</td>
							<td>
								<a href="" class="btn btn-success dayoffa" data-toggle="modal" data-target="#approved-modal" data-numberoff="<?=$numoff?>" data-reason="<?=$reason?>" data-attach="<?=$attach?>" data-tentk="<?=$tentk?>">
									Agree
								</a>
								<a href="" class="btn btn-danger dayoffr" data-toggle="modal" data-target="#refused-modal" data-numberoff="<?=$numoff?>" data-reason="<?=$reason?>" data-attach="<?=$attach?>" data-tentk="<?=$tentk?>">
									Disagree
								</a>
							</td>
						</tr>
				<?php
					}
				?>
			</table>
		</div> 
	</div>
	
<div id="dayoff-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Detail Request Day Off</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body" id="body-dayoff">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
        </div>
    </div>
<!-- Approved dayoff Modal -->
<div id="approved-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Approved Dayoff</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<p>Do you <b>agree</b> with employees leaving?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="approved" id="id_approved">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">OK</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

<!-- Refused dayoff Modal -->
<div id="refused-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Refused Dayoff</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<p>Do you <b>disagree</b> with employees leaving?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="refused" id="id_refused">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">OK</button>
				</div>
			</div>
		</form>
	</div>
</div>	 
	
<script src="../main.js"></script>
<?php
	//show toast message
	if(isset($_SESSION['dayoffapproved']))
	{
		echo "<script>showSuccessToast('Approved dayoff for employee success')</script>";
		unset($_SESSION['dayoffapproved']);
	}	

	else if(isset($_SESSION['dayoffrefused']))
	{
		echo "<script>showSuccessToast('Refused dayoff for employee success')</script>";
		unset($_SESSION['dayoffrefused']);
	}
	
	else if(isset($_SESSION['error']))
	{
		echo "<script>showErrorToast('An occured error')</script>";
		unset($_SESSION['error']);
	}	
?>
</body>
</html>