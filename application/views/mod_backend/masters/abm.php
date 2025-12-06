<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm' >";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"code","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-4","forcelabel"=>lang('p_username_master'),"name"=>"username","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getHtmlResolved($parameters,"controls","id_type_plan",array("col"=>"col-md-5"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"description","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"scheduled","type"=>"date","class"=>"form-control date dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"validto","type"=>"date","class"=>"form-control date dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"keywords_positive","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"keywords_negative","type"=>"text","class"=>"form-control text dbase"));
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

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.multiselect').selectpicker();
</script>
