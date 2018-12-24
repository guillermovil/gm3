<?php 
  echo validation_errors();
  if(isset($_errorfile) ){
    echo '<div class="alert alert-warning" role="alert">'.$_errorfile['error'].'</div>';
  }
  echo '<pre>';
  print_r($socio);
  echo '</pre>';   
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
      <label for="soc_nacimiento">Soc_nacimiento:</label>
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
      <label for="soc_domicilio">Soc_domicilio:</label>
      <input type="text" class="form-control" id="soc_domicilio" name="soc_domicilio" value="<?php echo set_value('soc_domicilio',$socio['soc_domicilio']); ?>">
    </div>
  </div>
  <div class="form-row">  
    <div class="col-sm-3">
      <label for="soc_telefono">Soc_telefono:</label>
      <input type="text" class="form-control" id="soc_telefono" name="soc_telefono" value="<?php echo set_value('soc_telefono',$socio['soc_telefono']); ?>">
    </div>
    <div class="col-sm-3">
      <label for="soc_email">Soc_email:</label>
      <input type="email" class="form-control" id="soc_email" name="soc_email" value="<?php echo set_value('soc_email',$socio['soc_email']); ?>">
    </div>
  </div>
  <div class="form-row">
  <div class="col-sm-6">
      <label for="soc_foto">Foto:</label>
      <input type="file" class="form-control" id="soc_foto" name="soc_foto">
      <?php
        echo base64_decode($socio['soc_foto']);
      ?>
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


