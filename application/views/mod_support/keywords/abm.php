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
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"code","readonly"=>true,"type"=>"text","class"=>"form-control text dbase validate","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"created","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"verified","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"fum","readonly"=>true,"format"=>"datetime","format"=>"code"));
	$html.="</div>";
}
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"description","forcelabel"=>lang('p_keyword'),"type"=>"text","class"=>"form-control text dbase validate"));
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
