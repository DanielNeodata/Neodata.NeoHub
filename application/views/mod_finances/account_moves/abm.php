<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"created","type"=>"date","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"invoice_number","type"=>"text","class"=>"form-control text dbase"));
$html.=getHtmlResolved($parameters,"controls","id_application",array("col"=>"col-md-6"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_user_invoice",array("col"=>"col-md-6"));
$html.=getHtmlResolved($parameters,"controls","id_user_discount",array("col"=>"col-md-6"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getHtmlResolved($parameters,"controls","id_type_currency",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_type_invoice",array("col"=>"col-md-4"));
$html.=getHtmlResolved($parameters,"controls","id_type_iva",array("col"=>"col-md-4"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("custom"=>"step='any'","col"=>"col-md-4","name"=>"amount","type"=>"number","class"=>"form-control amount number dbase validate"));
$html.=getInput($parameters,array("custom"=>"step='any'","col"=>"col-md-4","name"=>"iva","type"=>"number","class"=>"form-control number dbase iva"));
$html.=getInput($parameters,array("custom"=>"step='any'","col"=>"col-md-4","name"=>"total","type"=>"number","class"=>"form-control number dbase total"));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-12","name"=>"details","class"=>"form-control text dbase"));
$html.="</div>";

if($parameters["contracts"]["data"][0]["link_doc"]!=null && $parameters["contracts"]["data"][0]["link_doc"]!='') {
   $html.="<h4 class='p-0 m-0 pt-2'>Link a propuesta en contrato</h4>";
   $html.="<a href='".$parameters["contracts"]["data"][0]["link_doc"]."' target='_blank'>".$parameters["contracts"]["data"][0]["link_doc"]."</a>";
}

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
<script>
	$(".iva").attr("disabled",true);
	$(".total").attr("disabled",true);
	$("body").off("keyup", ".amount").on("keyup", ".amount", function () {
	    totalizeAccountMove();
	});
	$("body").off("blur", ".form-control").on("blur", ".form-control", function () {
	    totalizeAccountMove();
	});
	$("body").off("change", ".id_type_iva").on("change", ".id_type_iva", function () {
	    totalizeAccountMove();
	});
	function totalizeAccountMove(){
   	   $(".iva").attr("disabled",false);
	   $(".total").attr("disabled",false);
	   var _amount=$(".amount").val();
	   if(_amount=="-" || _amount==""){
		   $(".iva").val(0);
		   $(".total").val(0);
		   return false;
	   }
	   var _iva=(parseFloat(_amount)*(parseFloat($("#id_type_iva option:selected").attr('data-record'))/100));
	   $(".iva").val(_iva.toFixed(2));
	   var _total=(parseFloat(_amount)+_iva);
	   $(".total").val(_total.toFixed(2));
	   $(".iva").attr("disabled",true);
	   $(".total").attr("disabled",true);
	};
</script>
