<?php 
  echo validation_errors();
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'actividad/addActividadPost',$attributes); 
?>
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="act_code">Código:</label>
      <input type="text" class="form-control" id="act_code" name="act_code" value="<?php echo set_value('act_code'); ?>">
    </div>
     <div class="col-sm-3">
      <label for="act_nombre">Nombre:</label>
      <input type="text" class="form-control" id="act_nombre" name="act_nombre" value="<?php echo set_value('act_nombre'); ?>">
    </div>
  </div>
  
  <br> 
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
