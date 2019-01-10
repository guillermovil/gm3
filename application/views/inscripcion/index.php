<!-- 
ins_id integer
soc_id integer
act_code text
mod_tipo text
ins_vencimiento
-->

<a href="<?php echo base_url('inscripcion/addInscripcion/').$soc_id;?>" class="btn btn-success" role="button"><i class="fas fa-plus"></i> Inscribir</a>
<p></p>
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
    <table id="inscripciones_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="thead-dark">  
            <tr>
                <th>Id</th>
                <th>Actividad</th>
                <th>Modalidad</th>
                <th>Vencimiento</th>
                <th>Acciones</th>                
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#inscripciones_table').DataTable({
            "processing": true,
            "paging": false,
            "searching": false,
            "info": false,
            "ajax":{
                "url": "<?php echo base_url('inscripcion/tabla/').$soc_id; ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { 
                        "data": "ins_id", 
                        "searchable": false,  
                        "width": "5%" 
                    },
                    { "data": "act_nombre" },
                    { "data": "mod_nombre" },
                    { 
                        "data": "ins_vencimiento",
                        render: function(data, type, row){
                            if(type === "sort" || type === "type"){
                                return data;
                            }
                            if (data !== null && data != ''){
                                var fecha = new Date(data);

                                let options = {  
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                }; 
                                return fecha.toLocaleString('es-419',options);
                            }else{
                                return null;
                            } 
                        }
                    },
                    {
                        "data": null,
                        render: function ( data, type, row ) {
                        	if (row.dif > 0){
                        		closeb = `  <a href="<?php echo site_url('inscripcion/closeInscripcion/'); ?>`+row.ins_id+'/'+row.soc_id+`"" class="btn btn-warning btn-sm" title="Anular" role="button"><i class="fas fa-ban"></i></a>`;
                        	}else{
                        		closeb=``;
                        	}
                            return `<a href="<?php echo site_url('inscripcion/deleteInscripcion/'); ?>`+row.ins_id+'/'+row.soc_id+`"" class="btn btn-danger btn-sm" title="Eliminar" role="button"><i class="fas fa-trash-alt"></i></a>`+closeb;
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