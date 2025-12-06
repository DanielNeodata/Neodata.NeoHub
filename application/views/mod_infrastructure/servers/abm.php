<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"code","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"description","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_net",array("col"=>"col-md-4"));
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"ip","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_type_application",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_type_responsable",array("col"=>"col-md-4"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"color","type"=>"color","class"=>"form-control text dbase"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
