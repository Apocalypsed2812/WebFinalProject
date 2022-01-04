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
						<button class="btn btn-success">View List Employees</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-6">
						<button class="btn btn-success">View List More Task</button>
					</div>
				</div>
            </div> 
        </div>
		

		<div style="overflow-x:auto;">
			<table cellpadding="10" cellspacing="10" border="0" style=" margin: auto">
				<tr class="header">
					<td>
						<a href="#" style="color: black">
							<span><i class="fas fa-plus-circle"></i></span>	
						</a>
						<span> Add Task</span>
					</td>
					<td>Status</td>
					<td>Tag</td>
					<td>Describe</td>
					<td>Assignee</td>
					<td>Due Date</td>
					
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i> </span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-primary">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td style="color: red">
						Yesterday
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-success">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						3.3.2021
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-secondary">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						26.12.2021
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-danger">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						1.10.2021
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-dark">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						11.9.2021
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-light">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						22.2.2021
					</td>
				</tr>
				<tr class="item">
					<td>
						<a href="#" style="color: black">
							<span><i class="far fa-check-circle"></i></span>
						</a>
						<span> Crossplatform analysis</span>
					</td>
					<td>In progress</td>
					<td>
						<span class="badge badge-pill badge-warning">App</span>
					</td>
					<td>Create an app</td>
					<td><i class="fas fa-user-tie"></i></td>
					<td>
						24.1.2021
					</td>
				</tr>
			</table>
		</div>
     </div>   
	
	<footer>
		<p class="footer-text">Copyright @ Your Website</p>
	</footer>
</body>
</html>