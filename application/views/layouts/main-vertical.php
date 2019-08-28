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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	<script src="<?php echo site_url('resources/bootstrap/js/bootstrap.min.js');?>"> </script>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
				<h4 align="center"><i class="fas fa-dumbbell"></i> Gym Gestión</h4>
            </div>
            <div id="grupo">
            <ul class="list-unstyled components">
                <!-- <p>Dummy Heading</p> -->
   

                <li>
                    <a href="#boardmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" aria-controls="boardmenu" data-parent="#grupo">Dashboards</a>
                    <ul class="collapse list-unstyled" id="boardmenu">
                        <li id="board1">
                            <a href="<?php echo site_url('board');?>"><i class="fas fa-tachometer-alt"></i> Dashboard 1</a>
                        </li>
                        <li id="board2">
                            <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard 2</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="#sociosmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" aria-controls="sociosmenu" data-parent="#grupo">Socios</a>
                    <ul class="collapse list-unstyled" id="sociosmenu">
                        <li id="socioslista">
                            <a href="<?php echo site_url('socio');?>"><i class="fas fa-th"></i> Lista de socios</a>
                        </li>
                        <li id="sociosnuevo">
                            <a href="<?php echo site_url('socio/addSocio');?>"><i class="fas fa-user-plus"></i> Nuevo socio</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#activmenu" data-toggle="collapse" aria-expanded="false" aria-control="activmenu" class="dropdown-toggle" data-parent="#grupo">Actividades</a>
                    <ul class="collapse list-unstyled" id="activmenu">
                        <li id="activlista">
                            <a href="<?php echo site_url('actividad');?>"><i class="fas fa-th"></i> Lista de actividades</a>
                        </li>
                        <li id="activnuevo">
                            <a href="<?php echo site_url('actividad/addActividad');?>"><i class="fas fa-plus"></i> Nueva actividad</a>
                        </li>
                    </ul>
                </li>                


                <li>
                    <a href="#ventmenu" data-toggle="collapse" aria-expanded="false" aria-control="ventmenu" class="dropdown-toggle" data-parent="#grupo">Ventas</a>
                    <ul class="collapse list-unstyled" id="ventmenu">
                        <li id="categlista">
                            <a href="<?php echo site_url('categoria');?>"><i class="fas fa-th"></i> Lista de categorías</a>
                        </li>
                        <li id="prodlista">
                            <a href="<?php echo site_url('producto');?>"><i class="fas fa-th"></i> Lista de productos</a>
                        </li>  
                        <li id="ventgrid">
                            <a href="<?php echo site_url('venta');?>"><i class="fas fa-th"></i> Ventas</a>
                        </li>                          
                        <li id="ventlista">
                            <a href="<?php echo site_url('venta/addVenta');?>"><i class="fas fa-th"></i> Nueva venta</a>
                        </li>                                             
                    </ul>
                </li>                



            </ul>
            </div>
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
	<button type="button" id="sidebarCollapse" class="btn btn-sm" data-target="#sidebar">
		<i class="fas fa-grip-vertical"></i>
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
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('login/logout');?>"><i class="fas fa-sign-out-alt"></i> Salir</a>
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
			var $myGroup = $('#grupo');
			$myGroup.on('show.bs.collapse','.collapse', function() {
				$myGroup.find('.collapse.show').collapse('hide');
			});   
			$('#<?php echo $menu0; ?>').addClass( "show" );
			$('#<?php echo $menu1; ?>').addClass( "active" );
        });
    </script>
</body>

</html>