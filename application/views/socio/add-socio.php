<?php 
  echo validation_errors();
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'socio/addSocioPost'); 
?>
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="soc_tipodoc">Tipo:</label>
      <input type="text" class="form-control" id="soc_tipodoc" name="soc_tipodoc">
    </div>
     <div class="col-sm-3">
      <label for="soc_nrodoc">Nro documento:</label>
      <input type="text" class="form-control" id="soc_nrodoc" name="soc_nrodoc">
    </div>
    <div class="col-sm-2">
      <label for="soc_nacimiento">Soc_nacimiento:</label>
      <input type="date" class="form-control" id="soc_nacimiento" name="soc_nacimiento">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-3">
      <label for="soc_apellido">Apellido:</label>
      <input type="text" class="form-control" id="soc_apellido" name="soc_apellido">
    </div>
    <div class="col-sm-3">
      <label for="soc_nombre">Nombre:</label>
      <input type="text" class="form-control" id="soc_nombre" name="soc_nombre">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-6">
      <label for="soc_domicilio">Soc_domicilio:</label>
      <input type="text" class="form-control" id="soc_domicilio" name="soc_domicilio">
    </div>
  </div>
  <div class="form-row">  
    <div class="col-sm-3">
      <label for="soc_telefono">Soc_telefono:</label>
      <input type="text" class="form-control" id="soc_telefono" name="soc_telefono">
    </div>
    <div class="col-sm-3">
      <label for="soc_email">Soc_email:</label>
      <input type="email" class="form-control" id="soc_email" name="soc_email">
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


