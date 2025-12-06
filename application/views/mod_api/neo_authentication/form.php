<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <h4>Accesos autorizados a Neodata Ecosystem</h4>
    <div class="container-full">
        <div class='col-12' style='padding-right:5px;'>
		<?php 
			$html=" <table class='table-browser table table-hover'>";
			$html.="  <tbody>";
			foreach ($profile["api_users"] as $record){
				$html.="<tr class='record-".secureField($record,"id")."'>";
				$html.="   <td><img src='".$record["image"]."' style='width:72px;'/></td>";
				$html.="   <td>El usuario <b>".$record["username"]."</b>,<br/> tiene acceso a los siguientes segmentos<br/> del Neodata Ecosystem</td>";
				$html.="   <td>";
				$html.="      <ul style='list-style-type: none;padding:0;margin:0;'>";
				foreach ($record["api_applications"] as $app){
					$html.="<li>";
					$html.="   <a href='#' data-application='".$app["id"]."' data-username='".$record["username"]."' data-password='".$record["password"]."' class='btnTestAuthentication btn btn-raised btn-sm btn-primary btn-block text-left'>";
					$html.="      <i class='material-icons'>apps</i> Test ".$app["description"];
					$html.="   </a>";
					$html.="</li>";
				}
				$html.="      </ul>";
				$html.="   </td>";
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
    $.getScript('./application/views/mod_api/neo_authentication/form.js', function() { });
</script>
