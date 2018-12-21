    <table id="actividades_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="thead-dark">  
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
                        "searchable": false 
                    },
                    { "data": "act_nombre" },
                    {
                        "data": null,
                        render: function ( data, type, row ) {
                            return `<button type="button" class="btn btn-success btn-sm">  <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>`;
                        },
                        "width": "10%"                   
                    }
               ]     

        });
    });
</script>