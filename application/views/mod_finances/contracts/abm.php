<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_application",array("col"=>"col-md-6"));
$html.=getHtmlResolved($parameters,"controls","id_user_invoice",array("col"=>"col-md-6"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_type_invoice",array("col"=>"col-md-6"));
$html.=getHtmlResolved($parameters,"controls","id_type_iva",array("col"=>"col-md-6"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"date_from","type"=>"date","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"date_to","type"=>"date","class"=>"form-control text dbase validate"));
$html.=getHtmlResolved($parameters,"controls","id_type_currency",array("col"=>"col-md-3"));
$html.=getInput($parameters,array("custom"=>"step='any'","col"=>"col-md-5","name"=>"monthly","type"=>"number","class"=>"form-control monthly number dbase validate"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-12","name"=>"details","class"=>"form-control text dbase"));
$html.=getTextArea($parameters,array("col"=>"col-md-12","name"=>"link_doc","class"=>"form-control text dbase"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
