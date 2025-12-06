<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <div class="container-full no-operativo d-none"><?php echo buildDrawFailStateAPI();?></div>
    <div class="container-full operativo">
	<?php 
		$html ="<td width='15%' valign='bootom' class='tdTypeSelector'>";
		$html.="   <label class='p-0 m-0'>Tipo</label>";
		$html.="   <select id='browser_id_type_transaction' name='browser_id_type_transaction' class='form-control browser_id_type_transaction'></select>";
		$html.="</td>";
		$html.="<td width='15%' valign='bootom' class='tdStatusSelector'>";
		$html.="   <label class='p-0 m-0'>Estado</label>";
		$html.="	<select id='browser_id_type_status' name='browser_id_type_status' class='form-control browser_id_type_status'>";
		$html.="	   <option value='0'>[Todos]</option>";
		$html.="	   <option value='1'>Created</option>";
		$html.="	   <option value='2'>Verified</option>";
		$html.="	   <option value='3'>Extracted</option>";
		$html.="	   <option value='4'>Processed</option>";
		$html.="	   <option value='5'>Frozen</option>";
		$html.="	</select>";
		$html.="</td>";
	echo buildDrawStateAPI($html);?></div>
    <div class="resultados p-2 operativo"></div>
</div>

<script>
    $.getScript('./application/views/mod_api/neo_transactions/form.js', function() {
		_FUNCTIONS.onPopulateUserAPI("<?php echo $active_api;?>");
	});
</script>
