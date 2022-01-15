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
    <title>Trang Nhân Viên</title>
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
                            <a class="nav-link" href="tacvunhanvien.php">HomePage</a>
                        </li>
						<li class="nav-item active">
                            <a class="nav-link" href="#" >Services</a>
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
									<a class="dropdown-item" href="./taikhoan/logout.php">Log out</a>
								</div>
							</div>
                        </li>
                    </ul>
                </div>
        </nav>
	<div class="container">
		<div style="overflow-x:auto;" class="mt-5">
			<h3 class="text-center mb-5 text-primary">Task history</h3>
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table table-striped">
				<tr class="header">
					<td>ID Task</td>
					<td>ID Employee</td>
					<td>Status</td>
					<td>Day</td>
				</tr>
				<?php
					$result = get_history_task($idnv);
					$data = $result['data'];
					foreach ($data as $item){
						$idtask = $item['idtask'];
						$idnv_history = $item['idnv'];
						$status = $item['status'];
						$day = $item['day'];
						$count = $item['count'];
				?>
						<tr class="item">
							<td><?=$idtask?></td>
							<td><?=$idnv_history?></td>
							<td><?=$status?></td>
							<td><?=$day?></td>
						</tr>
				<?php
					}
				?>
			</table>
		</div> 
	</div>
	

<script src="../main.js"></script>

</body>
</html>