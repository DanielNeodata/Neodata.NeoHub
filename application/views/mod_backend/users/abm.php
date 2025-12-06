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
$html.=getHtmlResolved($parameters,"controls","id_master",array("col"=>"col-md-6"));
$html.=getHtmlResolved($parameters,"controls","id_type_user",array("col"=>"col-md-6"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"username","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-4","empty"=>true,"name"=>"password","type"=>"password","class"=>"form-control text dbase"));
$html.="</div>";

$html.="<h3>Valores default para generación de códigos QR</h3>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"default_url","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"default_parameter","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"default_code","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";

//$html.="<div class='form-row'>";
//$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"phone","type"=>"text","class"=>"form-control text dbase"));
//$html.="</div>";

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

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_application",array("col"=>"col-md-4 pt-2","forcelabel"=>"Accesos a Neodata Ecosystem"));
$html.=getHtmlResolved($parameters,"controls","id_group",array("col"=>"col-md-4 pt-2"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.multiselect').selectpicker();
</script>
