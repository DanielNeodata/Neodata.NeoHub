<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
$new=false;
if(!isset($parameters["records"]["data"][0])) {$new=true;}

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm' >";
$html.="<form style='width:100%;' autocomplete='off'>";

if (!$new) {
	$html.="<div class='form-row'>";
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"code","readonly"=>true,"type"=>"text","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"created","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"verified","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"fum","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.="</div>";
}
$html.="<div class='form-row'>";
$html.="   <div class='col-8'><div class='alter alert-primary'>En los <b>Detalles</b>, se requiere detallar las instrucciones y/o procedimientos involucrados en la entrada de la base de conocimiento.</div></div>";
$html.="   <div class='col-4'><div class='alter alert-primary'>En <b>Archivos relacionados</b> pueden adjuntarse capturas de pantalla, pdfs, docs y todo documento que pueda ser relevante para la entrada en la base de conocimiento.</div></div>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"description","class"=>"form-control text dbase trumbo"));
$ops= array("col"=>"col-md-4 pt-2","module"=>"mod_support","name"=>"knows","relation"=>"knows","forcelabel"=>lang('msg_relationed_files'),"accept"=>".pdf,.doc,.docx,.jpg,.jpeg");
$html.=getFile($parameters,$ops,$attached_files["data"]);
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_user_creator",array("col"=>"col-md-6"));
$html.=getHtmlResolved($parameters,"controls","id_type_application",array("col"=>"col-md-6"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_net",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_server",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_system",array("col"=>"col-md-4"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.trumbo').trumbowyg({lang: 'es_ar'});
</script>
