<?php 
  echo validation_errors();  
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'modalidad/editModalidadPost',$attributes); 
?>
  <input type="hidden" class="form-control" id="act_code" name="act_code" value="<?php echo set_value('act_code',@$modalidad['act_code']); ?>">
  <input type="hidden" class="form-control" id="mod_tipo" name="mod_tipo" value="<?php echo set_value('mod_tipo',@$modalidad['mod_tipo']); ?>">
  <div class="form-row"> 
    <div class="col-sm-3">
      <label class="text-muted" for="act_code">Precio:</label>
      <input type="text" class="form-control" id="mod_precio" name="mod_precio" value="<?php echo set_value('mod_precio',@$modalidad['mod_precio']); ?>">
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Guardar</button>
</form>

