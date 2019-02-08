<!-- 
CREATE TABLE public.pagossocios
(
    ins_id integer NOT NULL DEFAULT nextval('pagossocios_ins_id_seq'::regclass),
    ps_perdesde timestamp without time zone NOT NULL,
    ps_perhasta timestamp without time zone,
    ps_nrorecibo integer,
    ps_valor numeric(10,2) NOT NULL,
    ps_created timestamp without time zone NOT NULL DEFAULT now(),
    CONSTRAINT pk_pagossocios_ins_id PRIMARY KEY (ins_id, ps_perdesde),
    CONSTRAINT fk_pagossocios_inscripciones FOREIGN KEY (ins_id)
        REFERENCES public.inscripciones (ins_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
-->

<a href="<?php echo base_url('cuenta/addPago/').$ins_id;?>" class="btn btn-success" role="button"><i class="fas fa-plus"></i> Registrar pago</a>
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

	<div class="card" style="width: 22rem;">
	  <div class="card-body">
	    <p class="card-text">Actividad: <?php echo $act_nombre; ?><br>
	    Modalidad: <?php echo $mod_descrip; ?><br>
	    Precio: <?php echo $mod_precio; ?>
	    <?php 
	    	if ($estadogral == 0){
	    		echo "<span class='badge badge-danger'>Posee deuda</span>";
	    	}else{
	    		echo "<span class='badge badge-success'>Al día</span>";
	    	}
	    ?></p>
	  </div>
	</div>
	<p>

    <table id="pagos_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="custom-blue">  
            <tr>
                <th>Id</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Recibo</th>
                <th>Fecha</th>
                <th>Valor</th>
                <th>Registro</th>
                <th>Acciones</th>                
            </tr>
        </thead>
    </table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pagos_table').DataTable({
            "processing": true,
            "paging": true,
            "searching": true,
            "info": true,
            "ajax":{
                "url": "<?php echo base_url('cuenta/tabla/').$ins_id; ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                    { 
                        "data": "ins_id", 
                        "searchable": false,  
                        "visible": false
                    },
                    { 
                        "data": "ps_perdesde",
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
                        "data": "ps_perhasta",
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
                    	"data": "ps_nrorecibo",
                    	"width": "7%" 
                    },
                    { 
                        "data": "ps_fecha",
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
                    	"data": "ps_valor",
						"className": "text-right"
                    },                    
                    { 
                        "data": "ps_created",
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
                            return `<a href="<?php echo site_url('cuenta/deletePago/'); ?>`+row.ins_id+'/'+row.ps_perdesde+`"" class="btn btn-danger btn-sm" title="Eliminar" role="button"><i class="fas fa-trash-alt"></i></a>`;
                        },
                        "width": "8%"                   
                    }
               ]     

        });
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });        
    });
</script>