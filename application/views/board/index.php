<div class="container">	<div>
<pre id="data.csv" style="display: none">
	<?php echo $caja_stack; ?>	
</pre>	
  <div class="row">	
      <div class="col">	
          <div id="grafico2"></div>	
      </div>	
  </div>	
  <br><br>	
  <div class="row">	
    <div class="col">	

    	<h5><a href="#" id="act_vencimientos"><span class="text-warning"><i class="fas fa-redo-alt"></i></span></a> Vencidos o próximos a vencer (2 días)</h5>	
		<table id="board_vencimientos" class="table table-sm table-hover table-bordered" style="width:100%; font-size: 12px;">	
		    <thead class="thead-light">  	
		        <tr>	
		            <th>Socio</th>	
		            <th>Actividad</th>	
		            <th>hasta</th>	
		            <th>Días</th>	
		            <th>Ult.Asist.</th>	
		        </tr>	
		    </thead>	
		</table>      	
    </div>	
    <div class="col">	
      <h5><a href="#" id="act_movimientos"><span class="text-warning"><i class="fas fa-redo-alt"></i></span></a> Movimientos de caja:</h5>	
		<table id="board_movimientos" class="table table-sm table-hover table-bordered" style="width:100%; font-size: 12px;">	
		    <thead class="thead-light">  	
		        <tr>	
		            <th>Concepto</th>	
		            <th>Socio</th>	
		            <th>Actividad</th>	
		            <th>Valor</th>	
		        </tr>	
		    </thead>	
		</table> 	
    </div>	
  </div>	
  <div class="row">	
    <div class="col">	
      <h5><a href="#" id="act_cumples"><span class="text-warning"><i class="fas fa-redo-alt"></i></span></a> Cumpleaños!</h5>	

		<table id="board_cumples" class="table table-sm table-hover table-bordered" style="width:100%; font-size: 12px;">	
		    <thead class="thead-light">  	
		        <tr>	
		            <th>Socio</th>	
		            <th>Nacimiento</th>	
		        </tr>	
		    </thead>	
		</table> 	

    </div>	
    <div class="col">	
      <h5><a href="#" id="act_superan"><span class="text-warning"><i class="fas fa-redo-alt"></i></span></a> Superan la frecuencia semanal</h5>	

        <table id="board_superan" class="table table-sm table-hover table-bordered" style="width:100%; font-size: 12px;">	
            <thead class="thead-light">  	
                <tr>	
                    <th>Socio</th>	
                    <th>Actividad</th>	
                    <th>Semana</th>	
                    <th>Asist.</th>	
                </tr>	
            </thead>	
        </table>         	
    </div>	
  </div>
  
<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>	
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>	

<script src="https://code.highcharts.com/highcharts.js"></script>	
<script src="https://code.highcharts.com/modules/data.js"></script>	

<script type="text/javascript">	
    $(document).ready(function () {	
        var chart2 = new Highcharts.Chart({	
			chart: {	
				renderTo: 'grafico2',	
				type: 'column'	
			},	
			tooltip: {	
				formatter: function () {	
					return '<b>'+this.series.name + ': ' + this.y + '</b><br/>' +	
					'Total: ' + this.point.stackTotal;	
				}	
			},				
			plotOptions: {	
			    column: {stacking: 'normal'}	
			},	
            title: {text: 'Historial de cajas'},	
		    yAxis: {	
		        title: {text: '$ de recaudación'},	
		        stackLabels: {enabled: true}		        	
		    },	

		    legend: {	
		        itemStyle: {	
					color: '#555',	
					fontWeight: 'normal'	
		        }	
		    },		    	
			//data: {csv: document.getElementById('data.csv').innerHTML}	
            data: {	
                csvURL: "<?php echo site_url('board/csv/7');?>",	
                enablePolling: true,	
                dataRefreshRate: 60	
            },	


        });	

        var var_vencim = $('#board_vencimientos').DataTable({	
            "processing": true,	
            "paging": true,	
            "searching": false,	
            "info": false,	
            "serverSide": false,	
            "lengthChange": false,	
            "pageLength": 7,	
            "pagingType": "simple",	
            "ajax":{	
                "url": "<?php echo base_url('board/tabla_vencimientos'); ?>",	
                "dataType": "json",	
                "type": "POST",	
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }	
            },	
            "columns": [	
                    {	
                        "data": "soc_apellido",	
                        "render": function ( data, type, row ) {	
                            return data +', '+ row.soc_nombre;	
                        }	
                    },	
                    {	
                        "data": "act_nombre",	
                        "render": function ( data, type, row ) {	
                            return data +' '+ row.mod_descrip;	
                        }	

                    },	
                    { 	
                        "data": "hasta",	
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
                       "data": "dias_vencer",	
                        "render": function ( data, type, row ) {	
                        	if (data >= 0 ){	
                        		return "<span class='badge badge-info'>"+data+"</span>";	
                        	}else{	
                        		if (data > -3 && data < 0){	
                        			return "<span class='badge badge-warning'>"+data+"</span>";	
                        		}else{	
                        			return "<span class='badge badge-danger'>"+data+"</span>";	
                        		}	
                        	}	
                            return data +' '+ row.mod_tipo;	
                        },                      	
                        "width": "7%" 	
                    },	
                    { 	
                        "data": "ult_asistencia",	
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
                    }	
               ]     	

        });     	


        var var_movim=$('#board_movimientos').DataTable({	
            "processing": true,	
            "paging": true,	
            "searching": false,	
            "info": false,	
            "serverSide": false,	
            "lengthChange": false,	
            "pageLength": 7,	
            "pagingType": "simple",	
            "ajax":{	
                "url": "<?php echo base_url('board/tabla_caja'); ?>",	
                "dataType": "json",	
                "type": "POST",	
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }	
            },	
            "columns": [	
                    {	
                    	"data": "concepto_caja",	
                        "width": "5%" 	
                    },	
                    {	"data": "socio" },	
                    {	"data": "actividad" },	
                    {	"data": "ps_valor" }	
               ]     	

        });	

        var var_superan=$('#board_superan').DataTable({	
            "processing": true,	
            "paging": true,	
            "searching": false,	
            "info": false,	
            "serverSide": false,	
            "lengthChange": false,	
            "pageLength": 7,	
            "pagingType": "simple",	
            "ajax":{	
                "url": "<?php echo base_url('board/tabla_superan'); ?>",	
                "dataType": "json",	
                "type": "POST",	
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }	
            },	
            "columns": [	
                    {	
                        "data": "soc_apellido",	
                        "render": function ( data, type, row ) {	
                            return data +', '+ row.soc_nombre;	
                        }	
                    },	
                    {	
                        "data": "act_nombre",	
                        "render": function ( data, type, row ) {	
                            return data +' '+ row.mod_descrip;	
                        }	

                    },	
                    {	"data": "semana" },	
                    {	"data": "asistencias" }	
               ]     	

        });	


        var var_cumples = $('#board_cumples').DataTable({	
            "processing": true,	
            "paging": true,	
            "searching": false,	
            "info": false,	
            "serverSide": false,	
            "lengthChange": false,	
            "pageLength": 5,	
            "pagingType": "simple",	
            "order": [[ 1, "asc" ]],	
            "ajax":{	
                "url": "<?php echo base_url('board/tabla_cumples'); ?>",	
                "dataType": "json",	
                "type": "POST",	
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }	
            },	
            "columns": [	
                    {	
                        "data": "soc_apellido",	
                        "render": function ( data, type, row ) {	
                            return data +', '+ row.soc_nombre;	
                        }	
                    },	
                    { 	
                        "data": "soc_nacimiento",	
                        render: function(data, type, row){	
                            if(type === "sort" || type === "type"){	
                            	if (type === "sort"){	
                            		return row.dif;	
                            	}	
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
                    }	

               ]     	

        });	


        $("#act_vencimientos").click( function(){	
             var_vencim.ajax.reload();	
           }	
        );	
        $("#act_cumples").click( function(){	
             var_cumples.ajax.reload();	
           }	
        ); 	
        $("#act_movimientos").click( function(){	
             var_movim.ajax.reload();	
           }	
        );              	
        $("#act_superan").click( function(){	
             var_superan.ajax.reload();	
           }	
        );	


    });	

</script>	
