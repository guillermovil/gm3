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
<h6>Datos adicionales</h6>
<p>Actividad:  <?php echo $act_nombre; ?></p>
<p>Modalidad:  <?php echo $mod_tipo; ?></p>
<p>Precio Act: <?php echo $mod_precio; ?></p>
    <table id="pagos_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="thead-dark">  
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
        $('#inscripciones_table').DataTable({
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
                        "width": "5%" 
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
                    {"data": "ps_nrorecibo"},
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
                    {"data": "ps_valor"},                    
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
                        "width": "15%"                   
                    }
               ]     

        });
        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });        
    });
</script>