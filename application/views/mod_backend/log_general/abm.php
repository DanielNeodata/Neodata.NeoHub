<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm' >";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"code","type"=>"text","readonly"=>true,"format"=>"code"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"description","type"=>"text","readonly"=>true,"format"=>"text"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"username","type"=>"text","readonly"=>true,"format"=>"email"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"created","type"=>"text","readonly"=>true,"format"=>"datetime"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"verified","type"=>"text","readonly"=>true,"format"=>"datetime"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"fum","type"=>"text","readonly"=>true,"format"=>"datetime"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"id_rel","type"=>"text","readonly"=>true,"format"=>"code"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"table_rel","type"=>"text","readonly"=>true,"format"=>"code"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"action","type"=>"text","readonly"=>true,"format"=>"code"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
