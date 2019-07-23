
<?php 
  echo validation_errors();
  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open_multipart(site_url().'venta/addVentaPost',$attributes); 
  echo $vta_nro_aprox;
?>

	<div class="form-row"> 
		<div class="col-1">
			<label for="vta_nro">Venta id:</label>
			<input type="text" class="form-control" id="vta_nro" name="vta_nro" readonly style="color: Grey; opacity: 1;" value="<?php echo $vta_nro_aprox; ?>">
		</div>
		<div class="col-1">
			<label for="vta_comprob">Comprob nro:</label>
			<input type="text" class="form-control" id="vta_comprob" name="vta_comprob" value="<?php echo set_value('vta_comprob'); ?>">
		</div>
		<div class="col-2">
			<label for="vta_fecha">Fecha:</label>
			<input type="date" class="form-control" id="vta_fecha" name="vta_fecha" value="<?php echo set_value('vta_fecha',date('Y-m-d')); ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="col-1">
			<label class="text-muted" for="soc_id">Socio:</label>
			<div class="input-group">
			  <div class="input-group-prepend">
			    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalSocios" accesskey="s"><i class="fas fa-user"></i></button> 
			  </div>
			  <input type="text" class="form-control" id="soc_id" name="soc_id"  placeholder="alt s" readonly style="color: Grey; opacity: 1;" value="<?php echo set_value('soc_id'); ?>">
			</div>
		</div>
		<div class="col-3">
			<label class="text-muted" for="soc_identif">Nombre y apellido:</label>
			<input type="text" class="form-control" id="soc_identif" name="soc_identif"  disabled="true" value="<?php echo set_value('soc_identif'); ?>">
		</div>
	</div>

	<div class="form-row"> 
		<div class="col-4">
			<label for="vta_cliente">Cliente:</label>
			<input type="text" class="form-control" id="vta_cliente" name="vta_cliente" placeholder="Si no es un socio" value="<?php echo set_value('vta_cliente'); ?>">
		</div>
	</div>

	<!-- Los siguientes controles son para los detalles de la venta -->
	<br>
	<hr>
	<h4>Detalles de la venta</h4>
	<div class="form-row">
		<div class="col-1">
			<label class="text-muted" for="prod_code">Código:</label>
			<div class="input-group">
			  <div class="input-group-prepend">
			    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" accesskey="b"><i class="fas fa-search"></i></button>
			  </div>
			  <input type="text" class="form-control" id="prod_code" name="prod_code" disabled="true" placeholder="alt b">
			</div>
		</div>
		<div class="col-2">
			<label for="prod_descrip">Descripción:</label>
			<input type="text" class="form-control" id="prod_descrip" name="prod_descrip" disabled="true">
		</div>
		<div class="col-1">
			<label for="prod_cantidad">Cantidad:</label>
			<input type="number" class="form-control" id="prod_cantidad" name="prod_cantidad">
		</div>
		<div class="col-1">
			<label for="prod_precio">Precio:</label>
			<input type="number" class="form-control" id="prod_precio" name="prod_precio" disabled="true">
		</div>
		<div class="col-1">
			<br>      
			<button type="button" class="btn btn-success btn-block" id="addRow" name="addRow" accesskey="n"><i class="fas fa-cash-register"></i></button>
		</div>
	</div>
	<br>

	<div class="form-row">
		<div class="col-6">
			<table id="detalles_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
				<thead class="custom-blue">
					<tr>
						<th>Código</th>
						<th>Descripción</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Eliminar</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<br>
	<hr>	
	<button type="submit" class="btn btn-primary">Registrar venta</button>
</form>
<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Búsqueda de productos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<table id="productos_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
					<thead class="custom-blue">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Precio</th>
							<th>Stock</th>
							<th>Categoría</th>
							<th>Acciones</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal" id="ModalSocios">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Búsqueda de cliente</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
			    <table id="socios_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
			        <thead class="custom-blue">
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
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>




<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>

<script type="text/javascript">
    $(document).ready(function () {
    	var subtotal = 0.00;

    	//Función para eliminar fila del detalle
	    $('#detalles_table').on('click', 'a.editor_remove', function (e) {
	        e.preventDefault();
			detalles
			    .row( $(this).parents('tr') )
			    .remove()
			    .draw();
	    } );

	    //Tabla de detalles
        var detalles = $('#detalles_table').DataTable({
        	"searching": false,
            "processing": true,
            "serverSide": false,
            "lengthChange": false, 
            "info": false,           
            "paging": false,
            "columns": [
                    { "data":"prod_code", "width": "5%"},
                    { "data":"prod_descrip"},
                    { "data":"prod_cantidad", "width": "10%" },
                    { "data":"prod_precio", "width": "10%"},
                    { "data": "accion", "width": "10%"}
               ]     

        });

    //Función para agregar filas en los detalles

	$('#addRow').on( 'click', function () {
		//verifico que el producto todavía no esté en la grilla
		var existe = false;
		detalles.rows().every(function (value, index) {
			var data = this.data();
			if(data.prod_code == $('#prod_code').val()){
				existe = true;
			    data.prod_cantidad++;	
			    this.data(data).draw(false);				
			}
		});			
		if (!existe){

	        detalles.row.add( {
				"prod_code": $('#prod_code').val(),
				"prod_descrip": $('#prod_descrip').val(),
				"prod_cantidad": $('#prod_cantidad').val(),
				"prod_precio": $('#prod_precio').val(),
				"accion": "<a href='' class='editor_remove btn btn-danger btn-sm'><i class='far fa-trash-alt'></i></a>"
	        } ).draw( false );
	 
	        subtotal += $('#prod_cantidad').val() * $('#prod_precio').val();

		}
	} );
    


	$('#myform').on('submit', function(e){
		var existe = false;
		var form = this;
		detalles.rows().every(function (value, index) {
			var data = this.data();


			$(form).append(
			   $('<input>')
			      .attr('type', 'hidden')
			      .attr('name', 'prod_code1[]')
			      .val(data.prod_code)
			);
			$(form).append(
			   $('<input>')
			      .attr('type', 'hidden')
			      .attr('name', 'prod_cantidad1[]')
			      .val(data.prod_cantidad)
			);

			$(form).append(
			   $('<input>')
			      .attr('type', 'hidden')
			      .attr('name', 'prod_precio1[]')
			      .val(data.prod_precio)
			);
		});			
	} );



    //Tabla de productos para la búsqueda
    $('#productos_table').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false, 
        "info": false,           
        "pageLength": 7,
        "pagingType": "simple",
		"language": {
		    "search": "_INPUT_",
		    "searchPlaceholder": "Buscar..."
		},
		"dom": "<'row'<'col-sm-12 col-md-6 mb-2'f>>" +                    //el mb-2 es una clase especial de bootstrap para margin bottom 2
			"<'row'<'col-sm-12'tr>>" ,            
        "ajax":{
            "url": "<?php echo base_url('producto/tabla') ?>",
            "dataType": "json",
            "type": "POST",
            "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
        },
        "columns": [
                { "data":"prod_code", "width": "5%"},
                { "data":"prod_descrip"},
                { "data":"prod_precio", "width": "10%" },
                { "data":"prod_stock", "width": "10%"},
                { "data":"cat_descrip" },
                {
                    "data": null,
                    render: function ( data, type, row ) {
                        var cadena="'"+row.prod_code+"','"+row.prod_descrip+"',"+row.prod_precio; 
                        return `<a  onclick="carrito(`+cadena+`);" class="btn btn-primary" title="Seleccionar" role="button"><i class="fas fa-shopping-cart"></i></a>`;
                    },
                    "width": "10%"                   
                }
           ]     

	    });

        $('#socios_table').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "lengthChange": false, 
	        "info": false,           
	        "pageLength": 7,
	        "pagingType": "simple",
			"language": {
			    "search": "_INPUT_",
			    "searchPlaceholder": "Buscar..."
			},
			"dom": "<'row'<'col-sm-12 col-md-6 mb-2'f>>" +                    //el mb-2 es una clase especial de bootstrap para margin bottom 2
				"<'row'<'col-sm-12'tr>>" ,
            "ajax":{
                "url": "<?php echo base_url('socio/tabla') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [

                { "data":"soc_id", "width": "5%"},
                { "data":"soc_tipodoc", "width": "8%"},
                { "data":"soc_nrodoc", "width": "10%" },
                { "data":"soc_apellido" },
                { "data":"soc_nombre" },
                { "data":"soc_email" },
                {
                    "data": null,
                    render: function ( data, type, row ) {
                        var cadena=row.soc_id+",'"+row.soc_apellido+"','"+row.soc_nombre+"'"; 
                        return `<a  onclick="addsocio(`+cadena+`);" class="btn btn-primary" title="Seleccionar" role="button"><i class="fas fa-check"></i></a>`;
                    },
                    "width": "10%"                   
                }
           ]     

        });    
    });

    //Función para seleccionar producto y mandarlo a la pantalla parent
    function carrito(prod_code, prod_descrip, prod_precio){
      $('#prod_code').val(prod_code);
      $('#prod_descrip').val(prod_descrip);
      $('#prod_precio').val(prod_precio);
      $('#prod_cantidad').val(1);

      $('#myModal').modal('hide');
    }
    function addsocio(soc_id, soc_apellido, soc_nombre){
      $('#soc_id').val(soc_id);
      $('#soc_identif').val(soc_nombre + ' ' + soc_apellido);

      $('#ModalSocios').modal('hide');
    }    
</script>


