<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm' >";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"code","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"description","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-6","name"=>"name","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-6","name"=>"surname","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-6","name"=>"email","type"=>"email","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-6","name"=>"phone","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";

$html.="<h4>Servicios complementarios</h4>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"show_map","type"=>"checkbox","class"=>"mx-1 form-control text dbase"));
$html.="</div>";

$html.="<div class='form-row'>";
$ops= array(
        "nolabel"=>true,
        "name"=>"image",
        "class"=>"dbase d-none",
        "type"=>"base64",
        "format"=>"jpeg",
        "quality"=>0.5,
        "crop"=>"square",
        "col"=>"col-md-4",
    );
$html.=getImage($parameters,$ops);
$html.="</div>";

$html.="<h4>Credenciales para conectarse a API Neodata Ecosystem</h4>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"username","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-4","empty"=>true,"name"=>"password","type"=>"password","class"=>"form-control text dbase"));
$html.=getHtmlResolved($parameters,"controls","id_application",array("col"=>"col-md-4 pt-2","forcelabel"=>"Habilitar acceso API Neodata Ecosystem"));
$html.="</div>";
$html.="<span class='p-2 badge badge-dark'>Los valores requeridos para conectarse a la API son: 'username', 'password', 'id'</span>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.multiselect').selectpicker();
</script>
