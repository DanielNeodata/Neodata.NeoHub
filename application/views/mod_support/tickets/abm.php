<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
$new=false;
$closed=false;
$id_type_status=0;

if(!isset($parameters["records"]["data"][0])) {
	$new=true;
} else {
    $id_type_status=(int)$parameters["records"]["data"][0]["id_type_status"];
	$closed=($id_type_status==3);
}
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
$html.=getHtmlResolved($parameters,"controls","id_type_ticket",array("col"=>"col-md-3"));
$html.=getHtmlResolved($parameters,"controls","id_type_application",array("col"=>"col-md-3"));
$html.=getHtmlResolved($parameters,"controls","id_system",array("col"=>"col-md-3"));
$html.=getHtmlResolved($parameters,"controls","id_type_priority",array("col"=>"col-md-3"));
$html.=getHtmlResolved($parameters,"controls","id_user_assigned",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_type_status",array("col"=>"col-md-4"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"description","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";


$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"date_from","type"=>"date","class"=>"form-control date dbase"));
//if (!$new) {
   $html.=getInput($parameters,array("col"=>"col-md-3","name"=>"date_to","type"=>"date","readonly"=>false,"class"=>"form-control date dbase no-z","format"=>"datetime","format"=>"code"));
   $html.=getHtmlResolved($parameters,"controls","id_type_base_work",array("col"=>"col-md-3"));
   $html.=getInput($parameters,array("col"=>"col-md-3","name"=>"hours_work","type"=>"number","class"=>"form-control number dbase no-z"));
   $html.=getInput($parameters,array("custom"=>"step='any' min='0.01' max='100'","col"=>"col-md-3 d-none si-z","name"=>"percent_work","type"=>"number","class"=>"form-control number dbase"));
//}
$html.="</div>";

$html.="<div class='form-row'>";
$html.="   <div class='col-8'><div class='alter alert-primary'>En los <b>Detalles</b>, se requiere detallar de la forma mas clara y completa el incidente y/o requerimiento.</div></div>";
$html.="   <div class='col-4'><div class='alter alert-primary'>En <b>Archivos relacionados</b> pueden adjuntarse capturas de pantalla, pdfs, docs y todo documento que pueda ser relevante para la atención del incidente.</div></div>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"sinopsys","class"=>"form-control text dbase trumbo"));
$ops= array("col"=>"col-md-4 pt-2","module"=>"mod_support","name"=>"tickets","relation"=>"tickets","forcelabel"=>lang('msg_relationed_files'),"accept"=>".pdf,.doc,.docx,.jpg,.jpeg");
$html.=getFile($parameters,$ops,$attached_files["data"]);
$html.="</div>";

if (!$new and !$closed) {
	$html.="<div class='alter alert-danger'>Datos a considerar al cierre del requerimiento, que se almacenarán como <b>Base de conocimiento</b> a futuro.</div>";
	$html.="<div class='form-row'>";
	$html.=getHtmlResolved($parameters,"controls","id_net",array("col"=>"col-md-6"));
	$html.=getHtmlResolved($parameters,"controls","id_server",array("col"=>"col-md-6"));
	$html.="</div>";
	$html.="<div class='form-row'>";
	$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"keywords","type"=>"text","class"=>"form-control text dbase"));
	$html.="</div>";
	$html.="<div class='form-row'>";
	$html.="<div class='alter alert-info mt-2 col-12'>En las <b>Notas para la base de conocimiento</b>, se requiere detallar el procedimiento y/o acciones adecuadas para tratar con el problema o situación planteada en el incidente</div>";
	$html.=getTextArea($parameters,array("col"=>"col-md-12","name"=>"sinopsys_close","class"=>"form-control text dbase trumbo"));
	$html.="</div>";
}
$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
    $('.trumbo').trumbowyg({lang: 'es_ar'});
	$("body").off("change", ".id_type_ticket").on("change", ".id_type_ticket", function () {
		var _id_type_ticket = $(this).val();
		switch(parseInt(_id_type_ticket)){
		   case 8: //z-registro
		      $(".no-z").addClass("d-none");
			  $(".id_system").val("");
			  $(".id_type_priority").val(3);
			  $(".id_type_status").val(2);
			  $(".id_type_base_work").val(4);
			  $(".no-z").each(function () { $("label[for='"+$(this).attr("id")+"']").hide();});
		      $(".si-z").removeClass("d-none");
		      break;
		   default:
			  $(".no-z").removeClass("d-none");
			  $(".si-z").addClass("d-none");
			  $("label[for='percent_work']").hide();
			  $(".percent_work").val(0);
			  $(".hours_work").val(0);
			  $("label").show();
		      break;
		}
	});
	setTimeout(function(){$(".id_type_ticket").change();},0);
</script>
