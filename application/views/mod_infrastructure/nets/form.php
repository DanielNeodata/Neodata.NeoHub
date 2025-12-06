<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-full">
    <div class="badge badge-danger mt-2 p-2" style="display:block;"><?php echo $title;?></div>
	<?php 
	    $i=0;
	    $last_app="";
	    $html="";
        foreach ($nets["data"] as $net){
		    if ($net["application"]!=$last_app) {
			   $last_app=$net["application"];
			   if ($i!=0){$html.="</div>";}
			   $html.="<div class='badge badge-primary'>".$last_app."</div><br/>";

               foreach ($byResponsable as $item){
   			      $html.="<span class='badge m-1 p-2' style='background-color:".$item["type_responsable_color"].";'>";
			      $html.="Servidores bajo el control de ".$item["type_responsable"].": ".$item["total"];
   			      $html.="</span>";
  			   }
			   $html.="<br/>";
               foreach ($byExposure as $item){
			      if ((int)$item["id_application"]==(int)$net["id_application"]) {
   					  $html.="<span class='badge m-1 p-2' style='background-color:".$item["type_exposure_color"].";'>";
					  $html.="Sistemas con acceso ".$item["type_exposure"].": ".$item["total"];
   					  $html.="</span>";
				  }
			   }

       	       $html.="<div id='accordion".$last_app."'>";
			}
			$html.="<div class='card'>";
			$html.="   <div class='card-header'>";
			$html.="      <a class='card-link badge p-2' data-toggle='collapse' href='#net".$net["id"]."' style='background-color:".$net["color"].";'>".$net["description"]."</a>";
			$html.="   </div>";
			$html.="   <div id='net".$net["id"]."' class='collapse' data-parent='#accordion".$last_app."'>";
			$html.="      <div class='card-body'>";
            foreach ($net["servers"] as $server){
			    $responsable="<span class='p-1 shadow badge' style='font-size:12px;background-color:".$server["type_responsable_color"].";'>".$server["type_responsable"]."</span>";
				$html.="      <div class='shadow' style='display:inline;vertical-align: top;'>";
 				$html.="         <span class='my-1 p-2 shadow badge' style='font-size:12px;background-color:".$server["color"].";'>";
				$html.=$server["description"]." ".$responsable."</br>";
				$html.=$server["ip"]."</br>";
                foreach ($server["systems"] as $system){
				   $html.="<span class='mt-2 p-1 badge' style='background-color:".$system["type_availability_color"].";font-size:12px;'>".$system["code_availability"]." / ".$system["description"]."</span></br>";
				}
				$html.="         </span>";
				$html.="      </div>";
			}
			$html.="      </div>";
			$html.="   </div>";
			$html.="</div>";
			$i+=1;
        }
	    if ($i!=0){$html.="</div>";}
	    $html.="</div>";
    	echo $html;
	?>



</div>
<script>
    $.getScript('<?php echo $prefijo?>./application/views/mod_infrastructure/nets/form.js', function() {
        var currentTime = new Date();
        var year = currentTime.getFullYear();
        var yearTop = (year + 10);
    });
</script>
