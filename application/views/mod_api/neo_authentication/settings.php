<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <h4>Usuarios y perfiles de Neodata Ecosystem</h4>
    <div class="container-full">
        <div class='col-12' style='padding-right:5px;'>
		<?php 
			$html=" <table class='table-browser table table-hover'>";
			$html.="  <tbody>";
			foreach ($profile["api_users"] as $record){
				$html.="<tr class='record-".secureField($record,"id")."'>";
				$html.="   <td><img src='".$record["image"]."' style='width:72px;'/></td>";
				$html.="   <td>El usuario <b>".$record["username"]."</b>,<br/> tiene acceso a los siguientes segmentos<br/> del Neodata Ecosystem</td>";
				$html.="   <td class='p-0 m-0'>";
				foreach ($apps as $item){
					$bok=false;
					$api_profiles=null;
				    $html.="    <table class='table table-borderless p-0 m-0' style='width:100%;background-color:transparent;border:solid 0px silver !important'>";
				    $html.="     <tr>";
				    $html.="      <td class='p-1 m-0' style='width:100%;'>";
   				    $html.="       <b>".$item["description"]."</b>";
				    $html.="      </td>";
					foreach ($record["api_applications"] as $app){
						if ($item["code"]==$app["code"]){
							$api_profiles=$app["api_profiles"];
							$bok=true;
							break;
						}
					}
					if ($bok) {
					    $html.="<td class='p-1 m-0' align='right'>";
						$html.="   <a href='#' data-application='".$item["id"]."' data-username='".$record["username"]."' data-password='".$record["password"]."' class='btnTestAuthentication btn btn-raised btn-sm btn-primary text-left'>";
						$html.="      <i class='material-icons'>apps</i> Test";
						$html.="   </a>";
						$html.="</td>";
					    $html.="<td class='p-1 m-0' align='right'>";
						$html.="   <a href='#' data-application='".$item["id"]."' data-user='".$record["id"]."' data-state='unlink' class='btnStateLinkAPI btn btn-raised btn-sm btn-warning btn-block'>";
						$html.="      <i class='material-icons'>cancel</i> Desconectar";
						$html.="   </a>";
						$html.="</td>";
						$html.="<td class='p-1 m-0' align='right'>";
						$recordProfile=base64_encode(json_encode($api_profiles));
						//$html.=json_encode($api_profiles,JSON_PRETTY_PRINT);
						if ($api_profiles==null){
							if ($recordProfile=="bnVsbA==") {
								$html.="<a href='#' data-record='".$recordProfile."' data-application='".$item["id"]."' data-user='".$record["id"]."' class='btnTestProfile btn btn-raised btn-sm btn-dark text-left'>";
								$html.="   <i class='material-icons'>cancel</i> No requiere perfil";
								$html.="</a>";
							} else {
								$html.="<a href='#' data-record='".$recordProfile."' data-application='".$item["id"]."' data-user='".$record["id"]."' class='btnTestProfile btn btn-raised btn-sm btn-success text-left'>";
								$html.="   <i class='material-icons'>add</i> Crear perfil";
								$html.="</a>";
							}
						} else {
							$html.="<a href='#' data-record='".$recordProfile."' data-application='".$item["id"]."' data-user='".$record["id"]."' class='btnTestProfile btn btn-raised btn-sm btn-info text-left'>";
							$html.="   <i class='material-icons'>handshake</i> Ver perfil";
							$html.="</a>";
						}
						$html.="</td>";
					} else {
					    $html.="<td class='p-1 m-0' colspan='3' align='right'>";
						$html.="   <a href='#' data-application='".$item["id"]."' data-user='".$record["id"]."' data-state='link' class='btnStateLinkAPI btn btn-raised btn-sm btn-info btn-block'>";
						$html.="      <i class='material-icons'>add_circle</i> Conectar";
						$html.="   </a>";
						$html.="</td>";
					}
				    $html.="     </tr>";
				    $html.="    </table>";
				}
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
    $.getScript('./application/views/mod_api/neo_authentication/settings.js', function() { });
</script>
