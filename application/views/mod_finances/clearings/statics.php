<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <h3>Estadísticas</h3>
    <div class="container-full">
        <div class='col-12' style='padding-right:5px;'>
		    <table cellpadding='2' style='width:100%;'>
			   <tr>
                  <td valign='bottom'><span class="badge badge-primary">Año desde</span> <?php echo $cboYearFrom;?></td>
				  <td valign='bottom'><span class="badge badge-primary">Año hasta</span> <?php echo $cboYearTo;?></td>
				  <td valign='bottom'><span class="badge badge-primary">Cliente</span> <?php echo $cboApplication;?></td>
				  <td valign='bottom'>
					 <div class="dropdown">
					   <button class="btn btn-raised btn-primary btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Consultar
					   </button>
					   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					 	 <a class="dropdown-item btn-get-statics" data-report="facturacion" data-id_currency="1" data-currency="ARS" data-open='S' href="#">Facturación ARS Todo</a>
					 	 <a class="dropdown-item btn-get-statics" data-report="facturacion" data-id_currency="1" data-currency="ARS" data-open='N' href="#">Facturación ARS Cerrada</a>
					 	 <a class="dropdown-item btn-get-statics" data-report="facturacion" data-id_currency="2" data-currency="USD" data-open='S' href="#">Facturación USD Todo</a>
					 	 <a class="dropdown-item btn-get-statics" data-report="facturacion" data-id_currency="2" data-currency="USD" data-open='N' href="#">Facturación USD Cerrada</a>
					   </div>
					 </div>
				  </td>
			   </tr>
			</table>
        </div>
    </div>
    <div class="resultados p-2">
	   <div id="chart" style="width:100%;height:650px;"></div>
	   <div id="chart2" style="width:100%;height:650px;"></div>
	   <div id="chart3" style="width:100%;height:650px;"></div>
	   <div id="totales" style="width:100%;">
	   
	   </div>
	</div>
</div>
<script>
    $.getScript('<?php echo $prefijo?>./application/views/mod_finances/clearings/statics.js', function() { });
</script>
