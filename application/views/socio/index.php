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
    <table id="socios_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Tipo doc</th>
                <th>Nro doc</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#socios_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo base_url('socio/tabla') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [

                    { "data":"soc_id" },
                    { "data":"soc_tipodoc" },
                    { "data":"soc_nrodoc" },
                    { "data":"soc_apellido" },
                    { "data":"soc_nombre" },
                    { "data":"soc_email" },
                    {
                        "data": null,
                        render: function ( data, type, row ) {
                            return `<button type="button" class="btn btn-success btn-sm">  <i class="fas fa-pen"></i>
                            </button>
                            <a href="<?php echo site_url('socio/editSocio/'); ?>`+row.soc_id+`"" class="btn btn-success btn-sm" role="button"><i class="fas fa-pen"></i></a>
                            <a href="<?php echo site_url('socio/deleteSocio/'); ?>`+row.soc_id+`"" class="btn btn-danger btn-sm" role="button"><i class="fas fa-trash-alt"></i></a>`;
                        },
                        "width": "10%"                   
                    }
               ]     

        });
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>