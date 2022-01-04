<?php
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
        header('Location: ../taikhoan/login.php');
        exit();
    }
	require_once('../db.php');
	$tentk = $_SESSION['user'];
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
    <title>Trang Hồ Sơ Nhân Viên</title>
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
			min-width: 100%;
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
<?php
	$result = get_employee_by_tentk($tentk);
	$data = $result['data'];
	foreach ($data as $item){
		$idnv = $item['idnv'];
		$name = $item['name'];
		$position = $item['position'];
		$id_department = $item['id_department'];
		$email = $item['email'];
		$phone = $item['phone'];  
		$indentity = $item['indentity'];
		$gender = $item['gender'];
		$image = $item['image'];
	}
?>
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
			
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td colspan="3">
								<a href="tacvunhanvien.php">Task</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary">42</span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px; background-color: #D8D8D8">
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
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Tên</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-smile-o" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$name?></p>
							</div>
							<div class="card-body">
									
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Chức Vụ</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-handshake-o" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$position?></p>
							</div>
							<div class="card-body">

							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Email</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-address-card-o" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$email?></p>
							</div>
							<div class="card-body">

							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Phone Number</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-phone" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$phone?></p>
							</div>
							<div class="card-body">

							</div>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Identity</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-id-card" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$indentity?></p>
							</div>
							<div class="card-body">
	
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 mt-3">
						<div class="card card-block">
							<div class="second-item">
								<p>Gender</p>
							</div>
							<div class="mt-3 image-body">
								<i class="fa fa-mars" style="font-size:48px"></i>
							</div>
							<div class="content-body">
								<p><?=$gender?></p>
							</div>
							<div class="card-body">
				
							</div>
						</div>
					</div>

					
				</div>
			</div>
		</div>
    <p class="footer-text">Copyright @ Your Website 2017</p>

</body>
</html>