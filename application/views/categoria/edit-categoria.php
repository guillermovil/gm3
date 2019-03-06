<?php 
  echo validation_errors();  
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'categoria/editCategoriaPost',$attributes); 
?>
  <input type="hidden" class="form-control" id="cat_code_original" name="cat_code_original" value="<?php echo set_value('cat_code_original',@$categoria['cat_code']); ?>">
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="cat_code">Código:</label>
      <input type="text" class="form-control" id="cat_code" name="cat_code" value="<?php echo set_value('cat_code',@$categoria['cat_code']); ?>">
    </div>
     <div class="col-sm-3">
      <label for="cat_descrip">Descripción:</label>
      <input type="text" class="form-control" id="cat_descrip" name="cat_descrip" value="<?php echo set_value('cat_descrip',@$categoria['cat_descrip']); ?>">
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Guardar</button>
</form>
