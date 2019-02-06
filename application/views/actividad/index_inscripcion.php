<!-- 
ins_id
ins_vencimiento
documento
socio
actividad
ult_vto
ult_asist
-->

<table id="inscripciones_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
    <thead class="thead-dark">  
        <tr>
            <th>Id</th>
            <th>Vencimiento</th>
            <th>Socio</th>
            <th>Documento</th>
            <th>Actividad</th>
            <th>Ult vto</th>
            <th>Ult asist</th>                
        </tr>
    </thead>
</table>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#inscripciones_table').DataTable({
            "processing": true,
            "ajax":{
                "url": "<?php echo base_url('actividad/tabla_inscripciones/').$act_code; ?>",
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

                    {"data": "socio"},
                    {"data": "documento"},
                    {"data": "actividad"},                    
                    { 
                        "data": "ult_vto",
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
                        "data": "ult_asist",
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

               ]     

        });        
    });
</script>