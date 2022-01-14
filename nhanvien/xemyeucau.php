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
		$name = $item['name'];
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
    <title>Trang Giám Đốc</title>
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
                            <a class="nav-link" href="../giamdoc/giamdoc1.php">HomePage</a>
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
			<h3 class="text-center mb-5 text-primary">Request DayOff Of Employee</h3>
			<p>Xin chào<span class="text-danger"> <?=$tentk?></span></p>
			<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto" class="table">
				<tr class="header">
					<td>Số ngày nghỉ</td>
					<td>Lí do</td>
					<td>File đính kèm</td>
					<td>Trạng thái</td>
				</tr>
				<?php
					$result = request_dayoff_by_tentk($tentk);
					$data = $result['data'];
					foreach ($data as $item){
						$songaynghi = $item['numberoff'];
						$lido = $item['reason'];
						$dinhkem = $item['attach'];
						$trangthai = $item['status'];
				?>
						<tr class="item">
							<td><?=$songaynghi?></td>
							<td><?=$lido?></td>
							<td><a href="../minhchung/<?=$dinhkem?>"><?=$dinhkem?></a></td>
							<td><?=$trangthai?></td>
						</tr>
				<?php
					}
				?>
			</table>
		</div> 
	</div>
	
<link rel="stylesheet" href="../style.css">	
<script src="../main.js"></script>
</body>
</html>