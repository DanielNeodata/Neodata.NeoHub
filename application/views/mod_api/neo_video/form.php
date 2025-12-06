<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <div class="container-full no-operativo d-none"><?php echo buildDrawFailStateAPI();?></div>
    <div class="container-full operativo"><?php echo buildDrawStateAPI("");?></div>
    <div class="resultados p-2 operativo"></div>
</div>
<script>
    $.getScript('./application/views/mod_api/neo_video/form.js', function() {
		_FUNCTIONS.onPopulateUserAPI("<?php echo $active_api;?>");
	});
</script>
