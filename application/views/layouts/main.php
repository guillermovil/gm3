<!DOCTYPE html>
<html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>Gym GV</title>
			<!-- Tell the browser to be responsive to screen width -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

			<link rel="stylesheet" href="<?php echo site_url('resources/bootstrap/css/bootstrap.min.css');?>"> 
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">


			<?php if(isset($_dt) && $_dt) { ?>
				<link rel="stylesheet" href="<?php echo site_url('resources/datatables/datatables.min.css');?>">
				<link rel="stylesheet" href="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.css');?>">
			<?php } ?>

	</head>
	<body>


		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="#">
						<img src="<?php echo site_url('resources/image/Gym-Icon.png');?>" width="30" height="30" class="d-inline-block align-top" alt="">
						<span class="font-weight-bold">Gym Gestió</span>
				</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Actividades <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Socios</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Dropdown
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
				</ul>
			</div>
		</nav>        
		<br>
		<div class="container">
		  <div class="col-lg-12">
              <?php                    
              if(isset($_view) && $_view)
                  $this->load->view($_view);
              ?>                    
      	</div>
   	</div>
	</body>
</html>

