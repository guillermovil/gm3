<?php 
	if(isset($_alert) && $_alert){
	  echo "<div id='aviso' class='alert $_alert_tipo' role='alert'>";
	  echo $_alert;
	  echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
	  echo "<span aria-hidden='true'>&times;</span>";
	  echo "</button>";
	  echo  "</div>";
	};
?>
<div class="row justify-content-center align-items-center">
<?php 
	$attributes = array('role' => 'form', 'id' => 'myform');
 	echo form_open(site_url().'login/auth',$attributes); 
?>
			<div class="form-row">
				<label for="username">Usuario</label>
				<input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
			</div>
			<div class="form-row">
				<label for="password">Contraseña</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" value="remember-me"> Recuerdame
				</label>
			</div>
			<br>
			<button class="btn btn-sm btn-primary" type="submit">Ingresar</button>
		</form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>