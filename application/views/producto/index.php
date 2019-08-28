<?php                    
if(isset($_alert) && $_alert){
  echo "<div id='aviso' class='alert $_alert_tipo' role='alert'>";
  echo $_alert;
  echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span>";
  echo "</button>";
  echo  "</div>";
};

?>
    <a href="<?php echo base_url('producto/addProducto');?>" class="btn btn-success" role="button"><i class="fas fa-plus"></i> Nuevo</a><br><br>
    <table id="productos_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="custom-blue">
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#productos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo base_url('producto/tabla') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { "data":"prod_code", "width": "5%"},
                    { "data":"prod_descrip"},
                    { "data":"prod_precio", "width": "10%" },
                    { "data":"prod_stock", "width": "10%"},
                    { "data":"cat_descrip" },
                    {
                        "data": null,
                        render: function ( data, type, row ) {
                            return `
                            <div class="btn-group dropleft">
                              <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('producto/editProducto/'); ?>`+row.prod_code+`"">Editar</a>
                                <a class="dropdown-item" href="<?php echo site_url('producto/deleteProducto/'); ?>`+row.prod_code+`"">Eliminar <i class="fas fa-trash-alt"></i></a>

                              </div>
                            </div>
                            `;
                        },
                        "width": "10%"                   
                    }
               ]     

        });
        $('#aviso').delay(6000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>