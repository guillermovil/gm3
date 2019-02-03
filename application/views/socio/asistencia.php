<?php 
  echo validation_errors();
  if(isset($_errorfile) ){
    echo '<div class="alert alert-warning" role="alert">'.$_errorfile['error'].'</div>';
  }
  // echo '<pre>';               //debug array socio
  // print_r($opciones);
  // echo '</pre>';   
?>


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

<div class="row justify-content-start">
	<div class="col-6">
		<div class="card bg-light" >
			<div class="card-body">
				<p class="card-text">Asistencia de: <?php echo $socio['soc_apellido'].', '.$socio['soc_nombre']; ?><br>
				Documento: <?php echo $socio['soc_tipodoc'].' - '.$socio['soc_nrodoc']; ?><br>
				</p>
			</div>
		</div>
	</div>
</div>

<br>
<?php
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'socio/asistenciaPost',$attributes); 
?>
  <input type="hidden" class="form-control" id="soc_id" name="soc_id" value="<?php echo set_value('soc_id',@$socio['soc_id']); ?>">
  <div class="form-row">
    <div class="col-sm-2">
      <label for="asi_fecha">Fecha:</label>
      <input type="date" class="form-control" id="asi_fecha" name="asi_fecha" value="<?php echo set_value(date('Y-m-d'),date('Y-m-d')); ?>">
    </div>
	<div class="col-sm-3">
		<label for="opciones[]">Actividades:</label>
		<?php
		foreach ($opciones as $key => $value) {
		  echo "<div class='checkbox'><input type='checkbox' name='opciones[]' value='{$key}' checked> {$value}</div>";
		}
		?>
		
	</div>    
  </div> 
  <button type="submit" class="btn btn-primary">Confirmar</button>
</form>
<br><br>
<div class="row justify-content-start">
	<div class="col-6">
		<h5>Registro de asistencia</h5>
		<table id="asistencia_table" class="table table-sm table-hover table-bordered" style="width:100%; font-size: 12px;">
		    <thead class="thead-light">  
		        <tr>
		        	<th>Fecha</th>
		            <th>Actividad</th>
		            <th>Acciones</th>
		        </tr>
		    </thead>
		</table>
	</div>
</div>
<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#asistencia_table').DataTable({
            "processing": true,
            "serverSide": false,
            "paging": true,
            "searching": false,
            "info": false,
            "serverSide": false,
            "lengthChange": false,
            "pageLength": 10,
            "pagingType": "simple",


            "ajax":{
                "url": "<?php echo base_url('socio/tabla_asistencia/').$socio['soc_id']; ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { 
                    	"data": "asi_fecha",
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

                    { "data": "act_nombre" },
                    {
                        "data": null,
                        "className": "text-center",
                        render: function ( data, type, row ) {
                            return `<a href="<?php echo site_url('actividad/deleteActividad/'); ?>`+row.act_code+`"" class="btn btn-sm" role="button"><i class="fas fa-trash-alt"></i></a>`;
                        },
                        "width": "6%"                   
                    }
               ]     

        });
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });        
    });
</script>