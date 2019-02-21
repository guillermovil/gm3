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
        });
    </script>
</body>

</html>