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
$html.=getHtmlResolved($parameters,"controls","id_parent",array("col"=>"col-md-4",));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"icon","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"priority","type"=>"number","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"running","type"=>"number","class"=>"form-control text dbase"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"data_module","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"data_model","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"data_table","type"=>"text","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"data_action","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"show_brief","type"=>"checkbox","class"=>"form-control text dbase"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"alert_build","type"=>"checkbox","class"=>"form-control text dbase"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"brief","class"=>"form-control text dbase trumbo"));
$ops= array(
        "forcelabel"=>lang('msg_relationed_files'),
        "size"=>"52",
        "name"=>"image",
        "class"=>"dbase d-none",
        "type"=>"base64",
        "format"=>"jpeg",
        "quality"=>0.5,
        "crop"=>"square",
        "multi"=>true,
        "col"=>"col-md-4",
    );
$html.=getImage($parameters,$ops,$attached_files["data"]);
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.trumbo').trumbowyg({lang: 'es_ar'});
</script>
