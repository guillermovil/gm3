<?php 

  // ins_id integer
  // soc_id integer
  // act_code text
  // mod_tipo text
  // ins_vencimiento

  echo validation_errors();

  $attributes = array('role' => 'form', 'id' => 'myform');
  echo form_open(site_url().'inscripcion/addInscripcionPost',$attributes); 
?>
  <div class="form-row"> 
    <input type="hidden" class="form-control" id="soc_id" name="soc_id" value="<?php echo set_value('soc_id',@$soc_id); ?>">
    <div class="col-sm-5">
      <label class="text-muted" for="act_code">Actividad:</label>
      <?php
        $attrib = array('id' => 'act_code', 'class' => 'form-control');
        echo form_dropdown('act_code', $actividades, '',$attrib);
       ?>
    </div>
  </div>
  <div class="form-row"> 
     <div class="col-sm-5">
      <label for="mod_tipo">Modalidad:</label>
      <?php
        $attrib = array('id' => 'mod_tipo', 'class' => 'form-control');
        echo form_dropdown('mod_tipo', '', '',$attrib);
       ?>
    </div>
  </div>
  <div class="form-row"> 
    <div class="col-sm-3">
      <label for="ins_vencimiento">Vencimiento:</label>
      <input type="date" class="form-control" id="ins_vencimiento" name="ins_vencimiento" value="<?php echo set_value('ins_vencimiento'); ?>">
    </div>
  </div>
  <br> 
  <button type="submit" class="btn btn-primary">Inscribir</button>
</form>
<script type="text/javascript">
  $(document).ready(
    $('#act_code').on('change',function(){
		var act_code = $(this).val();
		if (act_code != ''){
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url();?>inscripcion/modalidades",
				data: {act_code: act_code},
				success:function(data){
					$('#mod_tipo').html(data);
				}

			})
		}       
    })
  )

</script>