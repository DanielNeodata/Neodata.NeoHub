<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
//log_message("error", "RELATED ".json_encode($controls,JSON_PRETTY_PRINT));
?>
<h1><img title="Credipaz" src="./assets/img/small.png" height="54" style="margin-bottom:15px;" /> Informes de atención</h1>
<div class="row border border-light shadow">
    <div class="col-12">
        <?php
        $html="<div class='search-browser input-group mb-3 float-right'>";
        $html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Aplicación</span> ".$controls["id_application"]."</div>";
        $html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Año</span> ".$controls["cboYear"]."</div>";
        $html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Mes</span> ".$controls["cboMonth"]."</div>";
        //$html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Sistemas</span> ".$controls["id_system"]."</div>";
        //$html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Tipo</span> ".$controls["id_type_ticket"]."</div>";
        //$html.="   <div class='browser_controls' style='padding-right:5px;display:inline;'><span class='badge badge-info'>Status</span> ".$controls["id_type_status"]."</div>";
        $html.="</div>";
        $html.="<div class='mb-2 rpt-tareas d-none'>";
		$html.="   <a href='' target='_blank' class='mb-4 btn btn-raised btn-primary btn-report-tareas' style='display:inline;'>Solicitar informe de tareas</a> <pre style='display:inline;' class='p-1 mt-2 stream link-informe-tareas'></pre>";
		$html.="</div>";
		$html.="<br/>";
        $html.="<div class='mt-2 mb-2 rpt-asignaciones d-none'>";
		$html.="   <a href='' target='_blank' class='mb-4 btn btn-raised btn-primary btn-report-asignaciones' style='display:inline;'>Solicitar informe de asignaciones</a> <pre style='display:inline;' class='p-1 mt-2 stream link-informe-asignaciones'></pre>";
		$html.="</div>";
        echo $html;
        ?>
        
    </div>
</div>

<script>
    $.getScript( './application/views/mod_support/tickets/form.js', function() { });
</script>
