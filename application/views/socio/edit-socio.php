<?php 
  echo validation_errors();
  if(isset($_errorfile) ){
    echo '<div class="alert alert-warning" role="alert">'.$_errorfile['error'].'</div>';
  }
  //echo '<pre>';               //debug array socio
  //print_r($socio);
  //echo '</pre>';   
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open_multipart(site_url().'socio/editSocioPost',$attributes); 
?>
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="soc_tipodoc">Tipo:</label>
      <input type="text" class="form-control" id="soc_tipodoc" name="soc_tipodoc" value="<?php echo set_value('soc_tipodoc',$socio['soc_tipodoc']); ?>">
    </div>
     <div class="col-sm-3">
      <label for="soc_nrodoc">Nro documento:</label>
      <input type="text" class="form-control" id="soc_nrodoc" name="soc_nrodoc" value="<?php echo set_value('soc_nrodoc',$socio['soc_nrodoc']); ?>">
    </div>
    <div class="col-sm-2">
      <label for="soc_nacimiento">Nacimiento:</label>
      <input type="date" class="form-control" id="soc_nacimiento" name="soc_nacimiento" value="<?php echo set_value('soc_nacimiento',$socio['soc_nacimiento']); ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-3">
      <label for="soc_apellido">Apellido:</label>
      <input type="text" class="form-control" id="soc_apellido" name="soc_apellido" value="<?php echo set_value('soc_apellido',$socio['soc_apellido']); ?>">
    </div>
    <div class="col-sm-3">
      <label for="soc_nombre">Nombre:</label>
      <input type="text" class="form-control" id="soc_nombre" name="soc_nombre" value="<?php echo set_value('soc_nombre',$socio['soc_nombre']); ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-6">
      <label for="soc_domicilio">Domicilio:</label>
      <input type="text" class="form-control" id="soc_domicilio" name="soc_domicilio" value="<?php echo set_value('soc_domicilio',$socio['soc_domicilio']); ?>">
    </div>
  </div>
  <div class="form-row">  
    <div class="col-sm-3">
      <label for="soc_telefono">Telefono:</label>
      <input type="text" class="form-control" id="soc_telefono" name="soc_telefono" value="<?php echo set_value('soc_telefono',$socio['soc_telefono']); ?>">
    </div>
    <div class="col-sm-3">
      <label for="soc_email">Email:</label>
      <input type="email" class="form-control" id="soc_email" name="soc_email" value="<?php echo set_value('soc_email',$socio['soc_email']); ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-3">
      <img src="<?php echo site_url('socio/showfoto/'.$socio['soc_id']);?>" width="150" style='-moz-box-shadow: 0 0 5px #333;-webkit-box-shadow: 0 0 5px #333;box-shadow: 0 0 5px #333;'>
    </div>  

    <div class="col-sm-3">

      <label for="soc_foto"><i class="fas fa-camera-retro"></i> Foto:</label>
      <input type="file" class="form-control" id="soc_foto" name="soc_foto" style="height:43px; font-size:12px; font-color:gray;">
      <span class="small text-muted"> Seleccionar otra imágen (200 x 200 px inferior a 500 kbytes) </span>
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
