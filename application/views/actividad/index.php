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
    <table id="actividades_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="custom-blue">  
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#actividades_table').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax":{
                "url": "<?php echo base_url('actividad/tabla') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { 
                        "data": "act_code", 
                        "searchable": false,  
                        "width": "5%" 
                    },
                    { "data": "act_nombre" },
                    {
                        "data": null,
                        "className": "text-center",
                        render: function ( data, type, row ) {
                            return `
                            <div class="btn-group dropleft">
                              <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('actividad/editActividad/'); ?>`+row.act_code+`"">Editar</a>
                                <a class="dropdown-item" href="<?php echo site_url('inscripcion/index_inscripciones/'); ?>`+row.act_code+`"">Inscripciones</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo site_url('actividad/deleteActividad/'); ?>`+row.act_code+`"">Eliminar <i class="fas fa-trash-alt"></i></a>

                              </div>
                            </div>

                            `;
                        },
                        "width": "7%"                   
                    }
               ]     

        });
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });        
    });
</script>