<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","adjust_year",array("col"=>"col-md-3"));
$html.=getHtmlResolved($parameters,"controls","adjust_month",array("col"=>"col-md-3"));
$html.=getInput($parameters,array("forcelabel"=>lang("p_ipc"),"custom"=>"step='any'","col"=>"col-md-4","name"=>"amount","type"=>"number","class"=>"form-control amount number dbase validate"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
