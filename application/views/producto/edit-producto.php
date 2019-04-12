<?php 
  echo validation_errors();
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open_multipart(site_url().'producto/addProductoPost',$attributes); 
?>
  <input type="hidden" class="form-control" id="prod_code_original" name="prod_code_original" value="<?php echo set_value('prod_code_original',@$producto['prod_code']); ?>">
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="prod_code">Código:</label>
      <input type="text" class="form-control" id="prod_code" name="prod_code" value="<?php echo set_value('prod_code',@$producto['prod_code']); ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="col-sm-6">
      <label for="prod_descrip">Descripción:</label>
      <input type="text" class="form-control" id="prod_descrip" name="prod_descrip" value="<?php echo set_value('prod_descrip',@$producto['prod_descrip']); ?>">
    </div>
  </div>
  <div class="form-row">  
    <div class="col-sm-2">
      <label for="prod_precio">Precio:</label>
      <input type="number" class="form-control" id="prod_precio" name="prod_precio" value="<?php echo set_value('prod_precio',@$producto['prod_precio']); ?>">
    </div>
    <div class="col-sm-2">
      <label for="prod_stock">Stock:</label>
      <input type="number" class="form-control" id="prod_stock" name="prod_stock" value="<?php echo set_value('prod_stock',@$producto['prod_stock']); ?>">
    </div>
    <div class="col-sm-2">
      <p>Ctrl. de sotck:</p>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="prod_ctrl_stock" id="prod_ctrl_stock" value="Si" <?php echo set_checkbox('prod_ctrl_stock','Si', FALSE); ?> />
        <label class="custom-control-label" for="prod_ctrl_stock">Habilitar el control de stock</label> 
      </div>
    </div>


  </div>
  <div class="form-row"> 
     <div class="col-sm-4">
      <label for="cat_code">Categoría:</label>
      <?php
        $attrib = array('id' => 'cat_code', 'class' => 'form-control');
        echo form_dropdown('cat_code', $categorias, set_value('cat_code',@$producto['cat_code']),$attrib);
       ?>
    </div>
  </div>  
  <br> 
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>