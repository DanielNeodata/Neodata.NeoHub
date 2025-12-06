<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
$admin=((int)$profile["data"][0]["id_type_user"]==77);
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <h4>Consumos sobre Neodata Ecosystem - Incluye años <?php echo $yLimit." y ".date("Y");?></h4>
    <div class="container-full">
        <div class='col-12 p-0 m-0'>
		<?php 
		    $nada="<span class='p-1 badge badge-info'>Nada para facturar</span>";
			$html=" <table>";
			$html.="   <tr>";
			$html.="	  <td><span class='badge badge-success api-connected'>Ver detalles de:</span></td>";
			$html.="	  <td>";
			$html.="	     <select id='cboUsageUsername' name='cboUsageUsername' class='form-control cboUsageUsername'>";
			$iHowMany=0;
			foreach ($profile["api_users"] as $record){
				$html.="        <option selected value='".$record["id"]."'>".$record["username"]."</option>";
				$iHowMany+=1;
			}
			if ($iHowMany>1){$html.="<option selected value='-1'>[Todos]</option>";}
			$html.="	     </select>";
			$html.="	  </td>";
			$html.="   </tr>";
			$html.=" </table>";
			$html.=" <table class='table-browser table table-hover p-0 m-0'>";
			$html.="  <thead class='thead-dark'>";
			$html.="	<tr>";
			$html.="		<th>API</th>";
			$html.="		<th>Perfil</th>";
			$html.="		<th>Año</th>";
			$html.="		<th>Mes</th>";
			$html.="		<td class='px-0' align='right' style='font-weight:bold;'>Realizadas / Libres</td>";
			$html.="		<td class='px-0' align='left'></td>";
			$html.="	</tr>";
			$html.="  </thead>";
			$html.="  <tbody>";
			$last_api="";
			$last_profile="";
			foreach ($usage as $record){
				if ($last_api!=(string)$record["api"]) {
					$last_api=(string)$record["api"];
					$last_profile="";
				    $html.="<tr><td colspan='4' class='p-0 m-0' align='left'><span class='p-1 badge badge-dark'>".$record["api"]."</span></td></tr>";
				}
				$html.="<tr class='tr-user tr-user-".$record["id_user_auth"]."'>";
				$html.="   <td class='p-0 m-0'></td>";

				if ($last_profile!=(string)$record["profile"]) {
					$last_profile=(string)$record["profile"];
				    $html.="<td class='p-0 m-0' align='left'><span class='p-1 badge badge-info'>".$record["profile"]."</span></td>";
				} else {
					$html.="<td class='p-0 m-0'></td>";
				}

				$html.="   <td class='p-0 m-0'><span class='p-1 badge badge-light'>".$record["year_usage"]."</span></td>";
				$html.="   <td class='p-0 m-0'><span class='p-1 badge badge-light'>".$record["month_usage"]."</span></td>";
				$diff=((int)$record["free"]-(int)$record["total"]);
				//$diff=-100;
				$oper=($diff*-1);
			    $html.="   <td class='p-0 m-0' align='right'><span class='p-1 badge badge-primary'>".$record["total"]."</span> / <span class='p-1 badge badge-secondary'>".$record["free"]."</span></td>";

				if((int)$record["year_usage"]==(int)date("Y") && (int)$record["month_usage"]==(int)date("n")) {
				    $html.="<td class='p-0 m-0' align='center'><i class='material-icons' style='color:#4caf50;'>lock_open</i></td>";
				    $html.="<td class='p-0 m-0' align='left'><span class='p-1 badge badge-warning'>Aún no facturable</span></td>";
				} else {
				    $html.="<td class='p-0 m-0' align='center'><i class='material-icons' style='color:#03a9f4;'>done_all</i></td>";
					if ($admin and $diff<0) {
					   $html.="<td class='p-0 m-0' align='left'>";
					   if ((int)$record["free"]!=0) {
						  $html.="   <a href='#' class='btn btn-sm btn-dark btnExcedent' data-client='".$record["profile"]."' data-year='".$record["year_usage"]."' data-month='".$record["month_usage"]."' data-excedent='".$oper."' data-amount='".$record["amount_excedent"]."'>";
						  $html.="      <i class='material-icons'>price_check</i> Facturar";
						  $html.="   </a>";
					   } else {
						  $html.="   <i class='material-icons' title='".$oper." operaciones excedentes pero no facturables' style='color:blue;font-size:1em;cursor:help;'>error</i> ".$nada;
					   }
					   $html.="</td>";
					} else {
  					   $html.="<td class='p-0 m-0'>";
					   if ($diff<0 and (int)$record["free"]!=0) {
						  $html.="   <i class='material-icons' title='".$oper." operaciones excedentes facturables' style='color:darkgreen;font-size:1em;cursor:help;'>warning</i> ".$oper;
					   } else {
						  $html.=$nada;
					   }
					   $html.="</td>";
					}
				}
				$html.="</tr>";
			}
			$html.="  </tbody>";
			$html.="  <tfoot></tfoot>";
			$html.=" </table>";
			echo $html;
		?>
        </div>
    </div>
    <div class="resultados p-2"></div>
</div>
<script>
    $.getScript('./application/views/mod_api/neo_authentication/usage.js', function() { 
	   $(".cboUsageUsername").change();
	});
</script>
