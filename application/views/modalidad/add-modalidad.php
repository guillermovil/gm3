<?php 
  echo validation_errors();
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'modalidad/addModalidadPost',$attributes); 
?>
  <div class="form-row"> 
    <input type="hidden" class="form-control" id="act_code" name="act_code" value="<?php echo set_value('act_code',@$act_code); ?>">
    <div class="col-sm-3">
      <label class="text-muted" for="mod_tipo">Tipo:</label>
      <!-- <input type="text" class="form-control" id="mod_tipo" name="mod_tipo" value="<?php echo set_value('mod_tipo'); ?>"> -->

      <select class="select form-control" id="mod_tipo" name="mod_tipo">
       <option value="d">
        Diario
       </option>
       <option value="m2">
        Mensual 2 x semana
       </option>
       <option value="m3">
        Mensual 3 x semana
       </option>
       <option value="m6">
        Mensual todos los d&iacute;as
       </option>
       <option value="s">
        Semanal
       </option>
      </select>
    </div>
     <div class="col-sm-3">
      <label for="mod_precio">Precio:</label>
      <input type="number" min="0" max="10000" step="10" class="form-control" id="mod_precio" name="mod_precio" value="<?php echo set_value('mod_precio'); ?>">
    </div>
  </div>
  
  <br> 
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
