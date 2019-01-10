<?php 
  echo validation_errors();  
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'modalidad/updPreciosPost',$attributes); 
?>
  <input type="hidden" class="form-control" id="act_code" name="act_code" value="<?php echo set_value('act_code',@$act_code); ?>">
  <div class="form-row"> 
    <div class="col-sm-3">
      <label class="text-muted" for="act_code">Porcentaje:</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white">%</span>
        </div>
        <input type="number" min="0" max="100" class="form-control border-left-0" id="upd_precio" name="upd_precio" value="<?php echo set_value('upd_precio',@$upd_precio); ?>">
      </div>
      <small class="text-muted">Porc. de actualización para la actividad (entre 0% y 100%)</small>
    </div>
  </div>
  <br><br>
  <div class="form-row">
	<div class="form-check">
	  <input class="form-check-input" type="checkbox" value="1" id="upd_all" name="upd_all">
	  <label class="form-check-label" for="defaultCheck1">
	    Aplicar a todas las actividades del gimnasio <i class="fas fa-exclamation-triangle text-warning"></i>.
	  </label>
	</div>    
  </div>
  <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Aplicar</button>
</form>
