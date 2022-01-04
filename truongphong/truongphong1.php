<?php 
	session_start();
	require_once('../db.php');
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
    <title>Trang Trưởng Phòng</title>
    <style>
        
		*{
			box-sizing: border-box;
		}

        .first-item{
			border: solid 1px black;
			height: 150px;
        }
		
		.second-item{
			background-color: white;
		}
		
		.second-item button{
			margin-bottom: 5px;
			margin-top: 20px;
			width: 100%;
		}

        .main-text{
            background-color: #737884d7;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
        }

        .footer-text{
            background-color: rgba(0, 0, 0, 0.808);
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 20px;
        }
		
        table{
            width: 100%;
            text-align: center;
        }
        td{
            padding: 10px;
        }
        tr.item{
            border-top: 1px solid #5e5e5e;
            border-bottom: 1px solid #5e5e5e;
        }

        tr.item:hover{
            background-color: #d9edf7;
        }

        tr.item td{
            min-width: 150px;
        }

        tr.header{
            font-weight: bold;
        }

        a{
            text-decoration: none;
        }
        a:hover{
            color: deeppink;
            font-weight: bold;
        }

        td img {
            max-height: 100px;
        }
		
		.title-text{
			font-weight: bold;
			font-size: 20px;
			margin-top: 10px;
		}
		
		.image-user {
			background-color: white;
			display: flex;
			justify-content: right;
			margin-top: 15px;
		}
		
		.nav-item{
			margin-left: 20px;
		}
		
		.add{
			background-color: white;
		}
		
		.add button{
			width: 70%;
		}
		
		.sort button{
			width: 70%;
		}
		
		.sort{
			background-color: white;
		}
		
		.search{
			background-color: white;
			margin-bottom: 10px;
		}
		
		.search input{
			width: 330px;
		}

		.text-user{
			margin-top: 40px;
			background-color: white;

		}
		
		body{
			min-height: 100vh;
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
						<li class="nav-item">
                            <a class="nav-link" href="#">
								Icon
							</a>
                        </li>
                    </ul>
                </div>
        </nav>


    <div class="container">
		<div class="title-text">
			<p>Manager</p>
		</div>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-9 col-md-8 first-item">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-4 col-5">
						<div class="image-user">
							<img src="user-circle.png" class="rounded-circle">
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-sm-6 col-6 text-user">
						<h3>Anh Tiến</h3>
						<p>at@gmail.com</p>
					</div>
				</div>
            </div>
			
			<div class="col-lg-3 col-md-4  second-item">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-6 col-6">
						<button onclick="window.location.href='truongphong1.php'" class="btn btn-light border-dark">View submissions</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-6">
						<button onclick="window.location.href='truongphong.php'" class="btn btn-light border-dark">View List Task</button>
					</div>
				</div>
            </div> 
        </div>
		

		<div style="overflow-x:auto;">
			<table cellpadding="10" cellspacing="10" border="0" style=" margin: auto">
				<tr class="header">
					<td>Task name</td>
					<td>Assignee</td>
					<td>Attach</td>
				</tr>
				<?php 
					foreach($submission as $submit) {
						$name_task = get_task($submit['idtask'])['data'][0]['name'];
						$assignee = search_employee($submit['idnv'])['data'][0]['name'];
						$attach = $submit['attach'];
				?>
					<tr class="item" data-toggle="modal" data-target="#view-task">
						<td><?=$name_task?></td>
						<td><?=$assignee?></td>
						<td><?=$attach?></td>
					</tr>
				<?php 
					}
				?>
			</table>
		</div>
     </div>   
<!--Add dayoff-->		
<div id="view-task" class="modal fade" role="dialog"> 
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">View submit</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="idtask">ID task</label>
						<input value="" name="idtask" required class="form-control" type="text" placeholder="" id="idtask">
					</div>
					<div class="form-group">
						<label for="idnv">ID employee</label>
						<input value="" name="idnv" required class="form-control" type="text" placeholder="" id="idnv">
					</div>
					<div class="form-group">
						<label for="attach">Attach</label>
						<input value="" name="attach" required class="form-control" type="text" placeholder="" id="attach">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input value="" name="description" required class="form-control" type="text" placeholder="" id="description">
					</div>					
				</div>

				<div class="modal-footer">
					<input type = hidden name="upfile" id="upfile">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Reject</button>
					<button type="submit" class="btn btn-info">Complete</button>
				</div>
			</div>
		</form>
	</div>
</div>	 

	<footer>
		<p class="footer-text">Copyright @ Your Website</p>
	</footer>
</body>
</html>