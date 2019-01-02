<?php 
  echo validation_errors();  
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'actividad/editActividadPost',$attributes); 
?>
  <input type="text" class="form-control" id="act_code_original" name="act_code_original" value="<?php echo set_value('act_code_original',@$actividad['act_code']); ?>">
  <div class="form-row"> 
    <div class="col-sm-1">
      <label class="text-muted" for="act_code">Código:</label>
      <input type="text" class="form-control" id="act_code" name="act_code" value="<?php echo set_value('act_code',@$actividad['act_code']); ?>">
    </div>
     <div class="col-sm-3">
      <label for="act_nombre">Nombre:</label>
      <input type="text" class="form-control" id="act_nombre" name="act_nombre" value="<?php echo set_value('act_nombre',@$actividad['act_nombre']); ?>">
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>


<!-- 
Despliegue de las modalidades de la actividad
 -->

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
    <table id="modalidades_table" class="table table-bordered table-hover" style="width:80%; font-size: smaller;">
        <thead class="thead-dark">  
            <tr>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#modalidades_table').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax":{
                "url": "<?php echo base_url('modalidad/tabla/').$actividad['act_code'] ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { 
                        "data": "mod_tipo", 
                        "searchable": false,  
                        "width": "10%" 
                    },
                    { "data": "mod_precio" },
                    {
                        "data": null,
                        render: function ( data, type, row ) {
                            return `<a href="<?php echo site_url('modalidad/editModalidad/'); ?>`+row.mod_tipo+`"" class="btn btn-info btn-sm" role="button"><i class="fas fa-pen"></i></a>
                            <a href="<?php echo site_url('modalidad/deleteModalidad/'); ?>`+row.mod_tipo+`"" class="btn btn-danger btn-sm" role="button"><i class="fas fa-trash-alt"></i></a>`;
                        },
                        "width": "10%"                   
                    }
               ]     

        });
    });
</script>