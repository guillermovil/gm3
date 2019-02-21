<?php 
	if(isset($_alert) && $_alert){
	  echo "<div id='aviso' class='alert $_alert_tipo' role='alert'>";
	  echo $_alert;
	  echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
	  echo "<span aria-hidden='true'>&times;</span>";
	  echo "</button>";
	  echo  "</div>";
	};
	$attributes = array('role' => 'form', 'id' => 'myform');
 	echo form_open(site_url().'login/auth',$attributes); 
?>
		<div class="form-row">
			<label for="username">Username</label>
			<input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
		</div>
		<div class="form-row">
			<label for="password" class="sr-only">Password</label>
			<input type="password" name="password" class="form-control" placeholder="Password" required>
		</div>
		<div class="checkbox">
			<label>
			<input type="checkbox" value="remember-me"> Recuerdame
			</label>
		</div>
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
	</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>