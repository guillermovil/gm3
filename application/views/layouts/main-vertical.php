<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Gym GV</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?php echo site_url('resources/bootstrap/css/bootstrap.min.css');?>"> 
    <link rel="stylesheet" href="<?php echo site_url('resources/bootstrap/css/style.css');?>"> 

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">


	<?php if(isset($_dt) && $_dt) { ?>
		<link rel="stylesheet" href="<?php echo site_url('resources/datatables/datatables.min.css');?>">
		<link rel="stylesheet" href="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.css');?>">
		<style type="text/css">
			tr,td { height: 30px; padding: 0.4rem;}
		</style>
	<?php } ?>

	<style type="text/css">
		.form-row{
			margin-bottom: 15px;
		}
		label {
			font-weight: smaller;
			margin-bottom: 0px;
			color: gray;
		}
	</style>

	<script src="<?php echo site_url('resources/bootstrap/js/jquery-3.3.1.min.js');?>"> </script> 
	<script src="<?php echo site_url('resources/bootstrap/js/bootstrap.min.js');?>"> </script>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
				<h4 align="center"><i class="fas fa-dumbbell"></i> Gym Gestión</h4>
            </div>

            <ul class="list-unstyled components">
                <!-- <p>Dummy Heading</p> -->
                <li class="active">
                    <a href="#sociosmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Socios</a>
                    <ul class="collapse list-unstyled" id="sociosmenu">
                        <li>
                            <a href="<?php echo site_url('socio');?>"><i class="fas fa-th"></i> Lista de socios</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('socio/addSocio');?>"><i class="fas fa-user-plus"></i> Nuevo socio</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#activmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Actividades</a>
                    <ul class="collapse list-unstyled" id="activmenu">
                        <li>
                            <a href="<?php echo site_url('actividad');?>"><i class="fas fa-th"></i> Lista de actividades</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-plus"></i> Nueva actividad</a>
                        </li>
                    </ul>
                </li>                
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Portfolio</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
            <p></p>
            <p></p>
 			<div class="col d-flex justify-content-center" style="margin-top: 70px !important;">
			<div class="card">
			  <div class="card-header">Acerca de:</div>
			  <div class="card-body">
			    <p class="card-text"><span class="font-weight-bold">Guillermo Villanueva</span>
			    	<span class="text-secondary">
			    	<br><i class="fab fa-twitter"></i> @guillermovil
			    	<br><i class="fas fa-envelope"></i> guillermovil@gmail.com
			    	<br><i class="fab fa-whatsapp"></i> +54 387 4021-332</span>
			    	<br>
			    	
			    </p>
			  </div>
			</div>
			</div>
        </nav>
<div>
	<button type="button" id="sidebarCollapse" class="btn btn-sm">
		<i class="fas fa-grip-vertical"></i>
				<span></span>
	</button>	
</div>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
					<?php if(isset($title) && $title) {
						echo "<h5>&nbsp; $title <small> $subtitle</small> </h5>";
					};?>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" style="font-size: smaller;" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php                    
              if(isset($_view) && $_view)
                  $this->load->view($_view);
            ?>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>

</html>