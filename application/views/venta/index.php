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
    <table id="ventas_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
        <thead class="custom-blue">
            <tr>
                <th>Id</th>
                <th>Nro</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="dataModalLabel">Detalles de la venta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="venta_detail">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

<script src="<?php echo site_url('resources/datatables/datatables.min.js');?>"> </script>
<script src="<?php echo site_url('resources/datatables/dataTables.bootstrap4.min.js');?>"> </script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#ventas_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo base_url('venta/tabla') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{
                  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
                  "fecha":"2019-08-21"
                 }
            },
            "columns": [

                    { "data":"vta_nro", "width": "5%"},
                    { "data":"vta_comprob", "width": "5%"},

                    { 
                        "data": "vta_fecha", "width": "10%",
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


                    { "data":"cliente" },
                    { "data":"subtotal", "width": "5%" },

                    {
                        "data": null, "width": "5%",
                        render: function ( data, type, row ) {
                            return `
                            <a href="#" title="Detalles"><i class="fas fa-sort-down" onClick="detVentas(`+row.vta_nro+`)" style="color:#ffcc00"></i></a>
                            `;
                        },
                        "width": "5%"                   
                    }
               ]     
        });

        $('.view_data').click(function(){  
        }); 


        $('#aviso').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
    function detVentas(vta_nro){
           $.ajax({  
                url:"<?php echo site_url('venta/detVenta/'); ?>",  
                method:"post",  
                data:{vta_nro:vta_nro},  
                success:function(data){  
                     $('#venta_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
    }
</script>