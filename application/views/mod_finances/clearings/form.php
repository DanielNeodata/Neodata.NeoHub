<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-full">
    <h3><?php echo $title;?></h3>
    <div class="container-full">
        <div class='col-12' style='padding-right:5px;'>
		    <table cellpadding='2' style='width:100%;'>
			   <tr>
                  <td valign='bottom'>
					<span class="badge badge-primary">Año</span> <?php echo $cboYear;?>
				  </td>
				  <td valign='bottom'>
					<span class="badge badge-primary">Mes</span> <?php echo $cboMonth;?>
			      </td>
				  <td valign='bottom'>
					<span class="badge badge-primary">Moneda</span> <?php echo $cboCurrency;?>
			      </td>
				  <td valign='bottom'>
					<button class="btn btn-md btn-get-clearing" type="button" style="color:white;background-color:rgb(255, 0, 153);">consultar</button>
					<button class="btn btn-md btn-close-clearing btn-raised btn-warning d-none float-right" type="button">cerrar liquidación</button>
					<span class="alert alert-primary alert-clearing d-none float-right"><b>Liquidación cerrada</b></span>
				  </td>
			   </tr>
			</table>
        </div>
    </div>
    <div class="resultados p-2"></div>
    <div class="firmas p-2"></div>
</div>
<script>
    $.getScript('<?php echo $prefijo?>./application/views/mod_finances/clearings/form.js', function() {
	    
	});
</script>
