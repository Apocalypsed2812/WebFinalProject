<?php
	require_once('../db.php');
	session_start();
	if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
        header('Location: ../taikhoan/login.php');
        exit();
    }	
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
            $result = add_dayoff_employee($numday, $reason, $attach, $tentk);
            if ($result['code'] == 0){
				$update_dayoff_employee_ngaydasudung = update_dayoff_employee_ngaydasudung($numday, $tentk);
				$update_dayoff_employee_ngayconlai = update_dayoff_employee_ngayconlai($numday, $tentk);
				if ($_FILES['attach']['name'] != NULL) {
					// Kiểm tra file có vượt quá 20MB không
					if ($_FILES['attach']['size'] > 20 * 1048576) {
						echo "<script> alert('File đăng tải không phải là file ảnh!'); window.location='tinnhannhanvien.php'; </script>";
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
								echo "<script> alert('Upload thành công!'); window.location='tinnhannhanvien.php'; </script>";
							} else {
								echo "<script> alert('Upload không thành công!'); window.location='tinnhannhanvien.php'; </script>";
							}
						} else {
							echo "<script> alert('File không được phép upload!'); window.location='tinnhannhanvien.php'; </script>";
						}
					}
				} 
				else 
				{
					echo "<script> alert('File không được để trống!'); window.location='tinnhannhanvien.php'; </script>";
				}
				header('Location: tinnhannhanvien.php');
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
<body>
<?php
	$result = get_employee_by_tentk($tentk);
	$data = $result['data'];
	foreach ($data as $item){
		$name = $item['name'];
		$id_department = $item['id_department'];
		$image = $item['image'];
	}
?>
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
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
							<td colspan="4">
								<a href="hosonhanvien.php">Profile</a>
							</td>
							
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px; background-color: #D8D8D8">
							<td colspan="3">
								<a href="tinnhannhanvien.php">Message</a>
							</td>
							<td class="text-right">
								<a href="">
									<span class="badge badge-pill badge-secondary">7</span>
								</a>
							</td>
						</tr>
						<tr class="control" style="text-align: left; font-weight: bold; font-size: 15px">
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
<?php
	$result1 = get_dayoff_by_tentk($tentk);
	$data1 = $result1['data'];
	foreach ($data1 as $item){
		$tongso = $item['tongso'];
		$ngaydasudung = $item['ngaydasudung'];
		$ngayconlai = $item['ngayconlai'];
	}
?>
			<div class="col-lg-8 card-info">
				<table class="table table-striped mt-3 mx-3" style="border-collapse: collapse; margin: auto">
					<tbody>
						<tr>
							<td colspan="8">
								<a href="" class="btn btn-primary" data-toggle="modal" data-target="#add-dayoff">Yêu cầu nghỉ phép</a>
							</td>
						
						</tr>
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Tổng số ngày nghỉ phép</td>
							<td><?=$tongso?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Số ngày đã sử dụng</td>
							<td><?=$ngaydasudung?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td><i class="fa fa-user-circle-o" style="font-size:48px"></i></td>
							<td colspan="4">Số ngày còn lại trong năm</td>
							<td><?=$ngayconlai?></td>
							<td><i class="fa fa-mail-reply" style="font-size:18px"></i></td>
							<td><i class="fa fa-trash-o" style="font-size:18px"></i></td>
						</tr>
						
						<tr>
							<td colspan="8">
								<a href="xemyeucau.php" class="btn btn-primary">Xem yêu cầu nghỉ phép</a>
							</td>
						
						</tr>
						
						<tr>
							<td>
								<?php
								if (!empty($error)) {
									echo "<div class='alert alert-danger' id='error-dayoff'>$error</div>";
								}
								?>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>

<!--Add dayoff-->		
<div id="add-dayoff" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add DayOff</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="numday">Chọn số ngày nghỉ</label>
						<select name="numday" required class="form-control" id="numday">
							<?php
								$result4 = get_ngayconlai($tentk);
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

    <p class="footer-text">Copyright @ Your Website 2017</p>

<!--<link rel="stylesheet" href="style.css">-->
<script src="main.js"></script>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</body>
</html>