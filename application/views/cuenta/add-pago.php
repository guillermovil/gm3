
<div class="card" style="width: 22rem;">
  <div class="card-body">
    <h5 class="card-title">Datos adicionales</h5>
    <p class="card-text">Actividad: <?php echo $act_nombre; ?><br>
    Modalidad: <?php echo $mod_descrip; ?><br>
    Precio: <?php echo $mod_precio; ?></p>
  </div>
</div>
<p>

<?php 
  echo validation_errors();
  if(isset($_errorfile) ){
    echo '<div class="alert alert-warning" role="alert">'.$_errorfile['error'].'</div>';
  }

  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'cuenta/addPagoPost',$attributes); 
?>
  <div class="form-row"> 
    <input type="hidden" class="form-control" id="ins_id" name="ins_id" value="<?php echo set_value('ins_id',@$ins_id); ?>">
     <div class="col-sm-3">
      <label for="ps_perdesde">Desde:</label>
      <input type="date" class="form-control" id="ps_perdesde" name="ps_perdesde" value="<?php echo set_value('ps_perdesde',@$desde); ?>">
    </div>
    <div class="col-sm-3">
      <label for="ps_perhasta">Hasta:</label>
      <input type="date" class="form-control" id="ps_perhasta" name="ps_perhasta" value="<?php echo set_value('ps_perhasta',@$hasta); ?>">
    </div>
  </div>
  <div class="form-row"> 
     <div class="col-sm-3">
      <label for="ps_nrorecibo">Recibo:</label>
      <input type="text" class="form-control" id="ps_nrorecibo" name="ps_nrorecibo" value="<?php echo set_value('ps_nrorecibo'); ?>">
    </div>
    <div class="col-sm-3">
      <label for="ps_fecha">Fecha:</label>
      <input type="date" class="form-control" id="ps_fecha" name="ps_fecha" value="<?php echo set_value('ps_fecha',date('Y-m-d')); ?>">
    </div>
  </div>
  <div class="form-row">    
    <div class="col-sm-3">
      <label for="ps_valor">Valor:</label>
      <input type="text" class="form-control" id="ps_valor" name="ps_valor" value="<?php echo set_value('ps_valor',@$mod_precio); ?>">
    </div>
    <div class="col-sm-5">
      <label class="text-muted" for="act_code">Medio de pago:</label>
      <?php
        $attrib = array('id' => 'mp_code', 'class' => 'form-control');
        echo form_dropdown('mp_code', $medios, '',$attrib);
       ?>
    </div>    
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
