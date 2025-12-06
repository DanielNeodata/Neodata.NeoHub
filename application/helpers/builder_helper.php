<?php
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

//LOGIN
function buildLogin($mode,$hide,$show,$lblUsername){
	$html="<form class='form-signin'>";
    $html.="	<div class='form-label-group' style='padding-bottom:15px;'>";
    $html.="		<label for='username'>".$lblUsername."</label>";
    $html.="		<input type='text' id='username' name='username' class='form-control dbase validate' placeholder='".$lblUsername."' autofocus />";
    $html.="	</div>";
	$html.="	<div class='form-label-group' style='padding-bottom:15px;'>";
    $html.="		<label for='password'>".lang('p_password')."</label>";
	$html.="		<input type='password' id='password' name='password' class='form-control dbase validate' placeholder='".lang('p_password')."' />";
    $html.="	</div>";
	$html.="	<hr class='my-4' />";
	$html.="	<div data-hide='".$hide."' data-show='".$show."' data-mode='".$mode."' class='btn-login btn btn-md btn-primary btn-raised btn-block text-uppercase'>".lang('b_login')."</div>";
	$html.="</form>";
	return $html;
}
//FLOAT
function buildFloatNotes($params){
	$float="<div id='float_".$params["id"]."' class='float_".$params["id"]."' style='background-color:white;position:fixed;border:solid 1px grey;border-radius:5px;'>";
	$float.="   <table class='table table-sm' style='width:100%;'>";
	$float.="      <tr>";
	$float.="         <td><label><b>".$params["label"]."</b></label><textarea rows='5' class='form-control ".$params["id"]."' id='".$params["id"]."' name='".$params["id"]."'>".$params["value"]."</textarea></td>";
	$float.="      </tr>";
	$float.="   </table>";
	$float.="</div>";
	return $float;
}
// AREAS
function buildDrawStateAPI($htmlStatusSelector){
	$html="<div class='row no-gutters'>";
	$html.="	<div class='col-12 shadow'>";
	$html.="		<span class='badge badge-info api-message'></span>";
	$html.="		<table>";
	$html.="		   <tr>";
	$html.="		      <td><span class='badge badge-success api-connected'>Cliente interno NeodataEcosystem:</span></td>";
	$html.="		      <td><select id='cboApiUsername' name='cboApiUsername' class='form-control cboApiUsername'></select></td>";
	$html.="		   </tr>";
	$html.="		</table>";
	$html.="		<table class='table table-striped pb-0 mb-0' style='width:100%;'>";
	$html.="			<thead class='thead-dark'>";
	$html.="				<tr>";
	$html.="					<th>API</th>";
	$html.="					<th>Versión</th>";
	$html.="					<th>Status</th>";
	$html.="					<th>Timestamp</th>";
	$html.="					<th>Root</th>";
	$html.="				</tr>";
	$html.="			</thead>";
	$html.="			<tbody>";
	$html.="				<tr>";
	$html.="					<td class='api-trace'></td>";
	$html.="					<td class='api-scope'></td>";
	$html.="					<td class='api-status'></td>";
	$html.="					<td class='api-udT0'></td>";
	$html.="					<td class='api-code'></td>";
	$html.="				</tr>";
	$html.="			</tbody>";
	$html.="		</table>";
	$html.="		<table>";
	$html.="			<tr valign='bootom'>";
	$html.=$htmlStatusSelector;
	$html.="			   <td width='15%' valign='bootom'>";
	$html.="			      <label class='p-0 m-0'>Fecha desde</label>";
	$html.="				  <input id='browser_date_from' name='browser_date_from' type='date' class='form-control browser_date_from'/>";
	$html.="			   </td>";
	$html.="			   <td width='15%' valign='bootom'>";
	$html.="			      <label class='p-0 m-0'>Fecha hasta</label>";
	$html.="				  <input id='browser_date_to' name='browser_date_to' type='date' class='form-control browser_date_to'/>";
	$html.="			   </td>";
	$html.="			   <td width='40%' valign='bootom' class='pt-4'>";
	$html.="				   <input id='browser_search' name='browser_search' type='text' class='form-control browser_search api_search' placeholder='Buscar en el registro del segmento de Neodata Ecosystem seleccionado'/>";
	$html.="			   </td>";
	$html.="			   <td width='10%' valign='bootom' class='pt-4'>";
	$html.="			       <a href='#' class='btn btn-raised btn-primary btn-sm btn-api_search' type='button'><i class='material-icons'>search</i> Buscar</a>";
	$html.="			   </td>";
	$html.="			   <td width='10%' valign='bootom' class='pt-4'>";
	$html.="			       <a href='#' class='btn btn-dark btn-sm btn-verMapa btn-Toggle' type='button'><i class='material-icons'>location_on</i> Mapa</a>";
	$html.="			       <a href='#' class='btn btn-dark btn-sm btn-verGrilla btn-Toggle d-none' type='button'><i class='material-icons'>lists</i> lista</a>";
	$html.="			   </td>";
	$html.="			</tr>";
	$html.="		</table>";
	$html.="	</div>";
	$html.="</div>";
    return $html;
}
function buildDrawFailStateAPI(){
	$html="<div class='card shadow'>";
	$html.="  <span class='text-left badge badge-danger api-notconnected p-2' style='font-size:1.7em;'>Sin aceso a esta funcionalidad</span>";
	$html.="</div>";
    return $html;
}

// HOME
function homePanel ($params){
    if (!isset($params["title"])){$params["title"]="Comunicaciones";}
    if (!isset($params["icon"])){$params["icon"]="chat_bubble_outline";}
    if (!isset($params["button"])){$params["button"]="m_folder_items";}
    if (!isset($params["module"])){$params["module"]="mod_folders";}
    if (!isset($params["model"])){$params["model"]="folders_userview";}
    if (!isset($params["table"])){$params["table"]="folders";}
    if (!isset($params["action"])){$params["action"]="brow";}
    if (!isset($params["page"])){$params["page"]="1";}
    if (!isset($params["field"])){$params["field"]="id_type_folder";}
    if (!isset($params["value"])){$params["value"]="2";}
    if (!isset($params["ver-title"])){$params["ver-title"]="Ver por carpeta";}
    if (!isset($params["icon2"])){$params["icon2"]="read_more";}
	
	$html="";
	$html.="<div class='divHome divHome-".$params["value"]." p-0 m-2 mb-4 col-3 col d-none shadow-custom' style='border-radius:5px;'>";
	$html.="<table style='width:100%;background-color:rgb(179,179,179);border-top-left-radius:5px;border-top-right-radius:5px;'>";
	$html.="<tr>";
	$html.="<td valign='middle' style='padding-left:5px;'><h4 style='color:white;'>".$params["title"]."</h4></td>";
	$html.="<td valign='middle' align='right'><span class='material-icons md-64' style='color:rgb(161,161,161);'>".$params["icon"]."</span></td>";
	$html.="</tr>";
	$html.="</table>";
	$html.="<table style='width:100%;background-color:grey;'>";
	$html.="<tr>";
	$html.="<td valign='middle' class='px-2 py-3'>";
	$html.="<a style='cursor:pointer;color:white;font-size:1.2rem;font-weight:50;' class='mb-2 p-2 btn-menu-click btn-".$params["button"]."' data-module='".$params["module"]."' data-model='".$params["model"]."' data-table='".$params["table"]."' data-action='".$params["action"]."' data-page='".$params["page"]."' data-forced-field='".$params["field"]."' data-forced-value='".$params["value"]."'>".$params["ver-title"];
	$html.="<span class='float-right material-icons md-24' style='color:white;'>".$params["icon2"]."</span>";
	$html.="</a>";
	$html.="</td>";
	$html.="<td valign='middle' align='right'></td>";
	$html.="</tr>";
	$html.="</table>";
	$html.="<table style='width:100%;background-color:rgb(240,240,240);border-bottom-left-radius:5px;border-bottom-right-radius:5px;'>";
	$html.="<tr>";
	$html.="<td valign='middle' style='padding-left:5px;'>";
	$html.="<a class='TYPE TYPE-".$params["value"]." mb-2 p-2'>Sin documentos pendientes</a>";
	$html.="</td>";
	$html.="</tr>";
	$html.="</table>";
	$html.="</div>";
	return $html;
}

//ABM
function buildHeaderAbmStd($parameters,$title){
    if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
    if(!isset($parameters["records"]["data"][0])){$parameters["records"]["data"][0]=null;}
    $new=((int)secureField($parameters["records"]["data"][0],"id")===0);
    $html="<div class='bg-default clearfix'>";
    $html.="<h3 class='title-abm float-left'>";
    if ($parameters["readonly"]) {
       $html.="<span class='badge badge-warning'>".lang('msg_view');
    } else{
       if ($new){ $html.="<span class='badge badge-secondary'>".lang('msg_new');}else{$html.="<span class='badge badge-info'>".lang('msg_edit');}
    }
    $html.="</span> ".$title;
    $html.="</h3>";
    $html.="</div>";
    if ($new and isset($parameters["messageNew"])){$html.=$parameters["messageNew"];}
    if (isset($parameters["messageAlert"])){$html.=$parameters["messageAlert"];}
    return $html;
}
function buildFooterAbmStd($parameters){
    if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
    if(!isset($parameters["records"]["data"][0])){$parameters["records"]["data"][0]=null;}
    $record=$parameters["records"]["data"][0];
    $new=((int)secureField($record,"id")===0);    
    $dataSegment=buildDataSegment($parameters);
    if ($new){
       $dataRec=str_replace('|ID|','0',$dataSegment);
    } else {
       $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
    }
    $html="<hr class='shadow-sm'/>";
    $html.="<div class='pt-1 pb-4 mb-4' style='width:100%;'>";
    $html.=" <div class='row justify-content-center' style='width:100%;'>";
    if ($parameters["readonly"]) {
        $html.="  <div class='px-4'><button type='button' class='btn-block btn-raised btn-abm-cancel btn btn-md btn-info' ".$dataRec."><i class='material-icons'>close</i></span>".lang("b_close")."</button></div>";
    } else {
        $html.="  <div class='px-4'><button type='button' class='btn-block btn-raised btn-abm-accept btn btn-md btn-success' ".$dataRec."><i class='material-icons'>done</i></span>".lang("b_accept")."</button></div>";
        if ($parameters["records"]["data"][0]["code"]!="llamada-telefonica") {
            $html.="  <div class='px-4'><button type='button' class='btn-raised btn-abm-cancel btn btn-md btn-danger' ".$dataRec."><i class='material-icons'>not_interested</i></span>".lang("b_cancel")."</button></div>";
        }
    }
    $html.=" </div>";
    $html.="</div>";
    return $html;
}

//BROWSER
function buildHeaderBrowStd($parameters,$title){
    if (!isset($parameters["show_totals"])){$parameters["show_totals"]=false;}
    if (!isset($parameters['subtitle'])){$parameters['subtitle']="";}
    if (!isset($parameters['filters'])){$parameters['filters']=array();}
    if (!isset($parameters['controls'])){$parameters['controls']=array();}
    if (!isset($parameters["getters"]) or !is_array($parameters["getters"])){
        $parameters["getters"]=array(
           "search"=>true,
           "excel"=>false,
           "pdf"=>false,
        );
    }
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|','0',$dataSegment);

	$html="<div class='row'>";
	$html.="   <div class='col-2 mt-1'>";
	if($title[0]!="<"){
       $html.="      <h3 class='title-browser mb-0'>".$title."</h3>";
	} else {
	   $html.=$title;
	}
    $html.="   </div>";
	$html.="   <div class='col-9 mt-1'>";
    $html.="      <input id='browser_search' name='browser_search' type='text' class='search-trigger form-control browser_search' placeholder='".lang('p_search')."' aria-label='".lang('p_search')."' />";
	$html.="   </div>";
	$html.="   <div class='col-1 mt-1'>";
    if($parameters["getters"]["search"]){$html.="<button class='btn btn-secondary btn-sm btn-browser-search' type='button' ".$dataRec." data-mode='brow' data-page='1' data-filters='".json_encode($parameters['filters'])."'><i class='material-icons' style='font-size:22px;vertical-align:middle;'>search</i>".lang('p_search')."</button>";}
	$html.="   </div>";
	$html.="</div>";
	$html.="<div class='row'>";
	$html.="   <div class='col-2 mt-0'>";
	$html.="      <div class='browser-subtitle shadow'>".$parameters['subtitle']."</div>";
	$html.="   </div>";
	$html.="   <div class='col-10 mt-0'>";
	foreach($parameters["controls"] as $control) {
		$html.="<div class='browser_controls' style='padding-right:5px;display:inline-block;'>".$control."</div>";
	}
    if($parameters["getters"]["excel"]){$html.="<button class='btn btn-secondary btn-sm btn-excel-search' type='button' ".$dataRec." data-mode='excel' data-page='1' data-filters='".json_encode($parameters['filters'])."'><i class='material-icons' style='font-size:22px;vertical-align:middle;'>table_rows</i>Excel</button>";}
    if($parameters["getters"]["pdf"]){$html.="<button class='btn btn-secondary btn-sm btn-pdf-search' type='button' ".$dataRec." data-mode='pdf' data-page='1' data-filters='".json_encode($parameters['filters'])."'><i class='material-icons' style='font-size:22px;vertical-align:middle;'>picture_as_pdf</i>PDF</button>";}

	if($parameters["show_totals"]){$html.="<div class='mt-2 pl-1 bg-dark' style='display:block;font-size:16px;color:white;'>Total de registros devueltos por la consulta ".$parameters["records"]["totalrecords"]."</div>";}

	$html.="   </div>";
	$html.="</div>";
    return $html;
}
function buildFooterBrowStd($parameters){
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|','0',$dataSegment);
    $html="<div class='footer-browser d-flex float-right pb-1 mb-2'>";
    $html.=" <nav class='p-2'>";
    $html.="  <ul class='pagination justify-content-end'>";
    $totalpages=(int)$parameters["records"]["totalpages"];
    $page=(int)$parameters["records"]["page"];
    $limit=($page+10);
    if($limit>$totalpages){$limit=$totalpages;}
    if ($totalpages>=1){
        if($page>1){
			$html.="<li class='page-item'><a ".$dataRec." class='page-link btn-browser-search' href='#' tabindex='-1' data-page='1' data-filters='".json_encode($parameters['filters'])."'>".lang('msg_first')."</a></li>";
			$html.="<li class='page-item'><a ".$dataRec." class='page-link btn-browser-search' href='#' tabindex='-1' data-page='".($page-1)."' data-filters='".json_encode($parameters['filters'])."'>".lang('msg_previous')."</a></li>";
		}
		$from=$page;
		$from=($page-5);
		if($from<1){$from=1;}

        for($i=$from;$i<=$limit;$i++){
            $class="";
            if($i==$page){$class="active";}
            $html.="<li class='page-item ".$class."'><a ".$dataRec." data-page='".$i."' class='page-link btn-browser-search' href='#' data-filters='".json_encode($parameters['filters'])."'>".$i."</a></li>";
        }
        if(($limit+1)<=$totalpages){
			$html.="<li class='page-item'><a ".$dataRec." class='page-link btn-browser-search' href='#' data-page='".($limit+1)."' data-filters='".json_encode($parameters['filters'])."'>".lang('msg_next')."</a></li>";
			$html.="<li class='page-item'><a ".$dataRec." class='page-link btn-browser-search' href='#' data-page='".$totalpages."' data-filters='".json_encode($parameters['filters'])."'>".lang('msg_last')."</a></li>";
		}
    } else {
        $html.="<li class='d-none page-item active'><a ".$dataRec." data-page='1' class='page-link btn-browser-search' href='#' data-filters='".json_encode($parameters['filters'])."'>1</a></li>";
    }
    $html.="  </ul>";
    $html.=" </nav>";
    $html.="</div>";
    return $html;
}
function buildBodyHeadBrowStd(&$parameters){
    $html="  <thead style='color:rgba(0,0,0,0.85);'>";
    $html.="   <tr class='header' style='background-color:rgba(0,0,0,0.15);'>";
    $html.=getThCheck($parameters);
    if ($parameters["buttons"]["new"]){$html.=getThNew($parameters);}
    if (!isset($parameters["columns"]) or !is_array($parameters["columns"])){
        $parameters["columns"]=array(
            //array("field"=>"id","format"=>"number"),
            array("field"=>"code","format"=>"code"),
            array("field"=>"description","format"=>"text"),
        );
        if ($parameters["buttons"]["delete"]){array_push($parameters["columns"],array("field"=>"","format"=>null));}
        if ($parameters["buttons"]["offline"]){array_push($parameters["columns"],array("field"=>"","format"=>null));}
    }
    foreach ($parameters["columns"] as $column) {
       if (isset($column["forcedlabel"])){$column["field"]=$column["forcedlabel"];}
       $html.=getThCol("p_".$column["field"],$column["class"]);
    }
    $html.="   </tr>";
    $html.="  </thead>";
    return $html;
}
function buildBodyBrowStd(&$parameters){
    $html="  <thead class='thead-light'>";
    $html.="   <tr class='header'>";
    if ($parameters["buttons"]["new"]){$html.=getThNew($parameters);}
    if (!isset($parameters["columns"]) or !is_array($parameters["columns"])){
        $parameters["columns"]=array(
            //array("field"=>"id","format"=>"number"),
            array("field"=>"code","format"=>"code"),
            array("field"=>"description","format"=>"text"),
        );
        if ($parameters["buttons"]["delete"]){array_push($parameters["columns"],array("field"=>"","format"=>null));}
        if ($parameters["buttons"]["offline"]){array_push($parameters["columns"],array("field"=>"","format"=>null));}
    }
    foreach ($parameters["columns"] as $column) {$html.=getThCol("p_".$column["field"],$column["class"]);}
    $html.="   </tr>";
    $html.="  </thead>";
    return $html;
}

//BROWSER PARTIAL DATA
function getThCheck($parameters){
    if(!secureButtonDisplay($parameters,null,"check")){return "";}
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|','0',$dataSegment);
    $html="<th style='width:24px;'>";
    $html.="<input type='checkbox' value='0' class='btn-record-check ' ".$dataRec."/>";
    $html.="</th>";
    return $html;
}
function getThNew($parameters){
    $size="btn-sm";
    if(!isset($parameters["custom_class_new"])){$parameters["custom_class_new"]="btn-record-edit";}
    if(!secureButtonDisplay($parameters,null,"new")){return "<th></th>";}
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|','0',$dataSegment);
    $html="<th class='p-0 m-0 py-1'>";
    $html.="<button title='Nuevo registro' type='button' class='p-0 pl-1 pr-2 m-0 ".$parameters["custom_class_new"]." btn btn-primary ".$size."'".$dataRec."><i class='material-icons' style='color:grey;'>add_circle_outline</i></button>";
    $html.="</th>";
    return $html;
}
function getThCol($keyLang,$class){
    $html="<th class='p-0 m-0 py-1 ".$class."'></th>";
    if($keyLang!="p_" and $keyLang!="" ){$html="<th class='p-0 m-0 py-1 pl-1 ".$class."' style='font-weight:bold;color:grey;'>".lang($keyLang)."</th>";}
    return $html;
}
function getTdCheck($parameters,$record,$td){
    if(!isset($notd)){$notd=false;}
    if(!secureButtonDisplay($parameters,$record,"check") and $td){
        $alternate="";
        if (isset($parameters["buttons"]["check"]["alternate"])){$alternate=$parameters["buttons"]["check"]["alternate"];}
        return "";
    }
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
    $html="";
    if ($td){$html.="<td valign='middle' align='center' style='width:24px;'>";}
    $html.="<input type='checkbox' value='".secureField($record,"id")."' class='btn-record-check' ".$dataRec."/>";
    if ($td){$html.="</td>";}
    return $html;
}
function getTdEdit($parameters,$record,$td){
    $size="btn-sm";
    if(!isset($notd)){$notd=false;}
    if(!secureButtonDisplay($parameters,$record,"edit") and $td){
        $alternate="";
        if (isset($parameters["buttons"]["edit"]["alternate"])){$alternate=$parameters["buttons"]["edit"]["alternate"];}
        return "<td class='p-0 m-0 pr-2' valign='middle'>".$alternate."</td>";
    }
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
    $html="";
    if ($td){$html.="<td class='p-0 m-0 pr-2' valign='middle'> ";}
    $html.="<button title='Editar el registro' type='button' class='p-0 pl-1 btn btn-record-edit btn-info ".$size."' ".$dataRec."><i class='material-icons' style='color:black;'>mode_edit_outline</i></button>";
    if ($td){$html.="</td>";}
    return $html;
}
function getTdCol($parameters,$record,$column){
    $size="";
    if ($parameters["mobile"]){$size="btn-sm";}
    if(!isset($column["html"])){$column["html"]="";}
    if(!isset($column["whenready"])){$column["whenready"]="";}
    if ($column["field"]==""){
       $dataSegment=buildDataSegment($parameters);
       $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
       $html="";
       switch ($column["format"]) {
           case "button":
              $html.="<td class='p-0 m-0 pr-2' valign='middle'><button type='button' class='".$column["class"]." ".$size."'".$dataRec."><i class='material-icons'>".$column["icon"]."</i></button></td>";
              break;
       }
    } else {
       switch($column["format"]) {
          case "conditional#block":
             $column["html"]=str_replace('|ID|',secureField($record,"id"),$column["html"]);
             $other=false;
             if(secureField($record,"hidden")!=1){$other=true;}
             if (secureField($record,$column["field"])==1){$column["html"]=$column["whenready"];}
             if($other){$value=$column["html"];}else{$value="";}
             break;
          case "html#block":
             $column["html"]=str_replace('|ID|',secureField($record,"id"),$column["html"]);
             $column["html"]=str_replace('|DESCRIPTION|',secureField($record,$column["field"]),$column["html"]);
             if (secureField($record,"offline")!=""){$column["html"]="";}
             $value=$column["html"];
             break;
          case "html#record":
             $column["html"]=str_replace('|ID|',secureField($record,"id"),$column["html"]);
             $column["html"]=str_replace('|DESCRIPTION|',secureField($record,$column["field"]),$column["html"]);
             $serialized=json_encode($record);
             $column["html"]=str_replace('|RECORD|',base64_encode($serialized),$column["html"]);
             $value=$column["html"];
             break;
          default:
             $value=secureField($record,$column["field"]);
             break;
       }
       $OK=true;
       if (isset($column["operator"])) {
          $OK=false;
          switch($column["operator"]) {
             case "=":
                $OK=($record[$column["conditional_field"]]==$column["conditional_value"]);
                break;
            case "!=":
                $OK=($record[$column["conditional_field"]]!=$column["conditional_value"]);
                break;
            case ">=":
                $OK=($record[$column["conditional_field"]]>=$column["conditional_value"]);
                break;
            case "<=":
                $OK=($record[$column["conditional_field"]]<=$column["conditional_value"]);
                break;
            case ">":
                $OK=($record[$column["conditional_field"]]>$column["conditional_value"]);
                break;
            case "<":
                $OK=($record[$column["conditional_field"]]<$column["conditional_value"]);
                break;
          }
       }
       if (!$OK){$value="";}
       $html=" <td valign='middle' class='p-0 m-0 pl-1 pr-2 ".$column["class"]."'>".formatHtmlValue($value,$column["format"])."</td>";
    }
    return $html;
}
function getTdDelete($parameters,$record,$td){
    $size="btn-sm";
    if(!secureButtonDisplay($parameters,$record,"delete") and $td){return "<td></td>";}
    $dataSegment=buildDataSegment($parameters);
    $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
    $html="";
    if ($td){$html.="<td class='p-0 m-0 pr-2' valign='middle'>";}
    $html.="<button title='Borrar este registro' type='button' class='p-0 pl-1 btn btn-sm btn-record-remove btn-danger ".$size."' ".$dataRec."><i class='material-icons' styel='color:red;'>delete_forever</i></button>";
    if ($td){$html.="</td>";}
    return $html;
}
function getTdOffline($parameters,$record,$td){
    $size="btn-sm";
    if(!secureButtonDisplay($parameters,$record,"offline") and $td){return "<td></td>";}
    $dataSegment=buildDataSegment($parameters);
    $offline=secureField($record,"offline");
    $dataRec=str_replace('|ID|',secureField($record,"id"),$dataSegment);
    $html="";
    if ($td){$html.="<td class='p-0 m-0 pr-2' valign='middle'>";}
    if ($offline!="") {
        //$html.="<span class='badge badge-warning'>".lang('msg_offline')." ".date(FORMAT_DATE_DMYHMS, strtotime($offline))."</span>";
        $html.="<button title='Volver a poner online el registro' type='button' class='p-0 pl-1 btn btn-sm btn-record-online' ".$dataRec."><i class='material-icons' style='color:blue;'>settings_backup_restore</i></button>";
    } else {
        $html.="<button title='Poner offline el registro' type='button' class='p-0 pl-1 btn btn-sm btn-record-offline btn-warning ".$size."' ".$dataRec."><i class='material-icons' style='color:darkorange;'>remove_circle_outline</i></button>";
    }
    if ($td){$html.="</td>";}
    return $html;
}
function getNoData(){
   return "<div class='alert alert-warning'><strong>".lang("msg_nodata")."</strong></div>";
}
function getUnInitialized(){
   return "<div class='alert alert-danger'><strong>".lang("msg_uninitialized")."</strong></div>";
}

//RECORD IDENTIFIER DATA-
function buildDataSegment($parameters) {
    $html="data-id='|ID|'";
    $html.="data-module='".$parameters["module"]."'";
    $html.="data-model='".$parameters["model"]."'";
    $html.="data-table='".$parameters["table"]."'";
    return $html;
}

//HTML CONTROLS
function getFromControls($params,$readOnly){
	$control="";
	if(!$readOnly) {
		switch($params["code"]){
			case "TEXTLINE":
			    $value=" ";
			    if($params["possible_values"]!="") {
					$possible_values = json_decode($params["possible_values"], true);
					$value=$possible_values["default"];
					$value=str_replace("[DATE]",date(FORMAT_DATE_DMY),$value);
				}
				$control="<input ".$params["custom"]." ".$params["class"]." data-type='text' type='text' id='".$params["key"]."' name='".$params["key"]."' value='".$value."'/>";
				break;
			case "TEXTAREA":
			    $value=$params["possible_values"];
				if($value==""){$value=" ";}
				$control="<textarea ".$params["custom"]." ".$params["class"]." rows='5' id='".$params["key"]."' name='".$params["key"]."'>".$value."</textarea>";
				break;
			case "RADIOBUTTON":
				$possible_values = json_decode($params["possible_values"], true);
				$control="<table align='left'>";
				$control.="   <tr>";
				foreach ($possible_values as $val){
					$control.="<td>".$val["label"]."</td><td style='width:20px;padding-right:5px;'><input ".$params["custom"]." ".$params["class"]." data-type='radio' type='radio' id='".$params["key"]."' name='".$params["key"]."' value='".$val["value"]."'/></td>";
				}
				$control.="   <tr>";
				$control.="</table>";
				break;
			case "CHECKBOX":
				break;
			case "COMBOFIXED":
				break;
			case "COMBOTABLE":
				break;
			case "DATE":
				$control="<input ".$params["custom"]." ".$params["class"]." type='date' id='".$params["key"]."' name='".$params["key"]."' value=''/>";
				break;
			case "DATETIME":
				$control="<input ".$params["custom"]." ".$params["class"]." type='datetime-local' id='".$params["key"]."' name='".$params["key"]."' value=''/>";
				break;
		}
	} else {
		switch($params["code"]){
			case "TEXTLINE":
				$control="<p style='padding-left:5px;'>".$params["value"]."</p>";
				break;
			case "TEXTAREA":
				$control="<pre style='padding-left:5px;'>".$params["value"]."</pre>";
				break;
			case "RADIOBUTTON":
				$possible_values = json_decode($params["possible_values"], true);
				foreach ($possible_values as $val){
				    if ($params["value"]==$val["value"]){$params["value"]=$val["label"];}
				}
				$control="<p style='padding-left:5px;'>".$params["value"]."</p>";
				break;
			case "CHECKBOX":
				break;
			case "COMBOFIXED":
				break;
			case "COMBOTABLE":
				break;
			case "DATE":
			    if ($params["value"]!=""){$params["value"]=date(FORMAT_DATE_DMY, strtotime($params["value"]));}else{$params["value"]="";}
				$control="<p style='padding-left:5px;'>".$params["value"]."</p>";
				break;
			case "DATETIME":
			    if ($params["value"]!=""){$params["value"]=date(FORMAT_DATE_DMYHMS, strtotime($params["value"]));}else{$params["value"]="";}
				$control="<p style='padding-left:5px;'>".$params["value"]."</p>";
				break;
		}
	}
	return $control;
}


function getFile($parameters,$ops,$list=null){
    if(!isset($ops["allow_delete"])){$ops["allow_delete"]=true;}
    if(!isset($ops["allow_read"])){$ops["allow_read"]=true;}
    if(!isset($ops["module"])){$ops["module"]="mod_folders";}
    if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
    $defaultIcon="./assets/img/image-upload.png";
    $label=lang('p_'.$ops["name"]);
    if($ops["forcelabel"]!=""){$label=$ops["forcelabel"];}
    $rootExternalLink="";
    $rootDirectLink="";
    switch($ops["module"]) {
       case "mod_dbcentral":
          $rootExternalLink="ExternalLink";
          $rootDirectLink="DirectLink";
          break;
       case "mod_folders":
          $rootExternalLink="folderExternalLink";
          $rootDirectLink="folderDirectLink";
          break;
       case "mod_providers":
          $rootExternalLink="providersExternalLink";
          $rootDirectLink="providersDirectLink";
          break;
    }
    $key=("btn-".$ops["relation"]."-files-".$ops["name"]);
    $html="<label for='".$ops["name"]."'>".$label."</label>";
    $html.="<div class='upload pt-3 position-relative'>";
    $html.=" <div class='row'>";
    if(!$parameters["readonly"]){
        $html.="  <div class='col-2'>";
        $html.="   <a href='#' class='btn btn-light btn-sm btn-upload' data-click='.".$key."'>";
        $html.="    <img class='img-".$ops["name"]."' src='".$defaultIcon."' style='width:52px;'/>";
        $html.="   </a>";
        $html.="   <input ";
        $html.="    data-module='".$ops["module"]."' ";
        $html.="    data-input='#".$ops["name"]."' ";
        $html.="    data-target='.ls-".$ops["name"]."' ";
        $html.="    data-click='.".$key."' ";
        $html.="    class='".$key." d-none' type='file' accept='".$ops["accept"]."'/>";
        $html.="   <a href='#' class='btn btn-secondary btn-sm btn-raised btn-external-link' data-target='.ls-".$ops["name"]."' data-click='.".$key."'>".lang('b_external')."</a>";
        $html.="  </div>";
    }
    $html.="  <div class='col-10'>";
    $html.="     <ul class='list-group ls-".$ops["name"]."'>";

    if(is_array($list)) {
        foreach ($list as $record){
            $id=$record["id"];
			$html .= "<li class='list-group-item li-".$id."'>";
            $urlExternal=$parameters["baseserver"].$rootExternalLink."/".base64_encode($record["data"]);
            $url=$parameters["baseserver"].$rootDirectLink."/".base64_encode($record["data"]);
            $html .= "<div class='badge badge-dark text-truncate' style='max-width:100%;'>";
            if(!$parameters["readonly"]){
               $html .= lang('p_priority').": <input class='folder-item-priority-update' data-id='".$id."' id='priority' name='priority' type='number' step='10' min='0' value='".$record["priority"]."' style='width:50px;'/>";
            }
            $html .= "</div>";
            if ($record["mime"]=="no/mime") {
               $html .= "<a target='_blank' href='".$urlExternal."' style='width:40px;' class='btn btn-sm btn-raised btn-default'><i class='material-icons'>link</i></a>";
            } else {
               $html .= "<a target='_blank' href='".$url."' style='width:40px;' class='btn btn-sm btn-raised btn-default'><i class='material-icons'>attach_file</i></a>";
            }
            if($ops["allow_read"]) {
                if(isset($record["viewed"])) {
			        if ((int)$record["viewed"] == 0) {
                        $color="magenta";
                        $status="ready";
			            $menu="<div class='btn-group p-0 m-0 btn-menu-".$record["id"]."'>";
			            $menu.=" <a href='#' class='btn btn-sm btn-default' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='material-icons'>more_vert</i> ".lang('msg_notreaded')."</a>";
			            $menu.="   <div class='dropdown-menu'>";
			            $menu.="      <button data-id='".$record["id"]."' data-status='".$status."' class='".$color." ready-".$record["id"]." btn-status-folder-item dropdown-item' type='button'>".lang("p_".$status)."</button>";
			            $menu.="   </div>";
			            $menu.="</div>";
                        $html.=$menu;
                        $html.="<div class='badge badge-danger mr-3 badge-readed'>".lang('msg_notreaded')."</div>";
                    } else {
                        $html.="<div class='badge badge-success mr-3'>".lang('msg_readed')."</div>";
                    }
                }
            }
			$html .= " <div data-id='".$id."' class='img-".$id." badge badge-secondary text-truncate' style='max-width:100%;' title='".$record["description"]."'>".$record["description"]."</div> ";
            if ($record["mime"]=="no/mime") { 
    			$html .= "<div class='badge badge-primary text-truncate' style='max-width:100%;' title='".lang('b_external')."'>".lang('b_external')."</div> ";
                if(!$parameters["readonly"]) {
                    $html .= "<a href='#' data-id='".$id."' class='btn btn-sm btn-danger float-right btn-link-delete'><i class='material-icons'>delete_forever</i></a>";
                    $html .= "<pre>".$urlExternal."</pre>";
                }
            } else {
    			$html .= "<div class='badge badge-primary text-truncate' style='max-width:100%;' title='".$record["type_folder_item"]."'>".$record["type_folder_item"]."</div> ";
    			$html .= " <div class='badge badge-info text-truncate' style='max-width:100%;' title='".$record["keywords"]."'>".$record["keywords"]."</div> ";
                if(!$parameters["readonly"]) {
                    if($ops["allow_delete"]) {$html .= "<a href='#' data-id='".$id."' class='btn btn-sm btn-danger float-right btn-folders-delete'><i class='material-icons'>delete_forever</i></a>";}
                    $html .= "<pre>".$url."</pre>";
                }
            }
			$html .= "</li>";
        }
    } 
    $html.="     </ul>";
    $html.="  </div>";

    $html.=" </div>";
    $html.="</div>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getImage($parameters,$ops,$list=null){
    $defaultIcon="./assets/img/image-upload.png";
    $html=getInput($parameters,$ops);
    $image="";
    if(isset($parameters["records"]["data"][0])){$image=secureField($parameters["records"]["data"][0],$ops["name"]);}
    if($image==""){$image=$defaultIcon;}

    if(!isset($ops["size"])){$ops["size"]="103";}
    if(!isset($ops["multi"])){$ops["multi"]=false;}
    if(!isset($ops["type"])){$ops["type"]="base64";}
    if(!isset($ops["format"])){$ops["format"]="jpeg";}
    if(!isset($ops["quality"])){$ops["quality"]=0.5;}
    if(!isset($ops["crop"])){$ops["crop"]="square";}

    $html.="<div class='upload pt-1 position-relative'>";

    $html.=" <div class='row'>";
    $html.="  <div class='col-12'>";
    $html.="   <a href='#' class='btn btn-sm btn-light btn-sm btn-upload' data-click='.btn-pick-files-".$ops["name"]."'>";
    $html.="    <img class='img-".$ops["name"]."' src='".$image."' style='width:".$ops["size"]."px;'/>";
    $html.="   </a>";
    $html.="   <input ";
    $html.=" data-input='#".$ops["name"]."' ";
    if (!$ops["multi"]) {
       $html.=" data-target='.img-".$ops["name"]."' ";
    } else {
       $html.=" data-target='.ls-".$ops["name"]."' ";
    }
    $html.=" data-click='.btn-pick-files-".$ops["name"]."' ";
    $html.=" data-type='".$ops["type"]."' ";
    $html.=" data-format='".$ops["format"]."' ";
    $html.=" data-quality='".$ops["quality"]."' ";
    $html.=" data-crop='".$ops["crop"]."' ";
    $html.=" data-multi='".$ops["multi"]."' ";
    $html.=" class='btn-pick-files-".$ops["name"]." d-none' type='file' accept='image/*'/>";
    $html.="   <div class='row'>";
    $html.="    <div class='col-12'>";
    if (!$ops["multi"]) {
        $html.="      <button type='button' class='mr-auto control-image btn btn-info btn-sm btn-upload btn-sm' data-click='.btn-pick-files-".$ops["name"]."'><i class='material-icons'>add</i></button>";
        $html.="      <button type='button' class='ml-5 control-image btn btn-warning btn-sm btn-upload-reset btn-sm' data-input='#".$ops["name"]."' data-default='".$defaultIcon."' data-target='.img-".$ops["name"]."'><i class='material-icons'>clear</i></button>";
    } else {
        $html.="   <ul class='list-group ls-".$ops["name"]."'>";
        if(is_array($list)) {
            foreach ($list as $record){
                $id=$record["id"];
				$html.="<li class='list-group-item li-".$id."'>";
				$html.="<img data-id='".$id."' src='".$record["src"]."' style='width:40px;' class='img-".$id."' data-filename='".$record["description"]."' /> ";
				$html.="<div class='badge badge-primary text-truncate' style='display: inline-block;max-width:100%;' title='".$record["description"]."'>".$record["description"]."</div> ";
				$html.="<a href='#' data-id='".$id."' class='btn btn-sm btn-danger float-right btn-upload-delete'><i class='material-icons'>delete</i></a>";
				$html.="<pre>".$record["src"]."</pre>";
				$html.="</li>";
            }
        } 
        $html.="</ul>";
    }
    $html.="    </div>";
    $html.="   </div>";
    $html.="  </div>";
    $html.=" </div>";
    $html.="</div>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getInputMicro($parameters,$ops){
    $checked="";
    $html="";
    if(!isset($ops["custom"])){$ops["custom"]="";}
    if(!isset($ops["forcelabel"])){$ops["forcelabel"]="";}
    if(!isset($ops["format"])){$ops["format"]="text";}
    if(!isset($ops["readonly"])){$ops["readonly"]=false;}
    if (!$ops["readonly"]) {
       if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
       $ops["readonly"]=$parameters["readonly"];
    }
    if(!isset($ops["nolabel"])){$ops["nolabel"]=false;}
    if(!isset($ops["empty"])){$ops["empty"]=false;}
    if(!isset($parameters["records"]["data"][0])){$parameters["records"]["data"][0]=null;}
    $value=secureField($parameters["records"]["data"][0],$ops["name"]);
    if ($ops["empty"]) {$value="";}
    $label=lang('p_'.$ops["name"]);
    if($ops["forcelabel"]!=""){$label=$ops["forcelabel"];}
    
    $html="<table style='width:100%;'>";
    $html.="<tr>";
    if(!$ops["nolabel"]){$html.="<td>".$label."</td>";}
    if ($ops["readonly"]) {
        switch($value){
           case "0":
           case "1":
              break;
           default:
              return "";
        }
        $valRO=$value;
        switch ($ops["type"]) {
            case "tristate":
                if ($valRO=="-1") {
                   $valRO='SIN ESPECIFICAR';
                } else {
                   if((int)$valRO==1) {$valRO='SI';}else{$valRO='NO';} 
                }
                $html.="<td align='right'>".formatHtmlValue($valRO,$ops["format"])."</td>";
                break;
            case "checkbox":
                if((int)$valRO==1) {$valRO='SI';}else{$valRO='NO';} 
                $html.="<td align='right'>".formatHtmlValue($valRO,$ops["format"])."</td>";
                break;
            default:
                //if($value=="") {return "";}
                $html.="<td align='right'>".formatHtmlValue($valRO,$ops["format"])."</td>";
                break;
        }
    } else {
        $styleWidth="";
        $control="input";
        switch ($ops["type"]) {
            case "tristate":
                $control="radio";
                $styleWidth="style='width:200px;'";
                break;
            case "checkbox":
                if($value==1) {$checked='checked';}else{$checked='';} 
                $styleWidth="style='width:50px;'";
                break;
            case "date":
                $styleWidth="style='width:50%;'";
                if ($value!=""){$value=date(FORMAT_DATE_DB, strtotime($value));}
                break;
            case "textarea":
                $control="textarea";
                $styleWidth="style='width:100%;'";
                break;
       }
       switch($control) {
          case "textarea":
             $html.="</tr><tr><td ".$styleWidth."><textarea style='witdh:100%;' rows='5' autocomplete='nope' class='".$ops["class"]."' type='".$ops["type"]."' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' placeholder='".lang('p_'.$ops["name"])."'>".$value."</textarea></td>";
             break;
          case "input":
             $html.="<td ".$styleWidth."><input style='height:20px;'".$ops["custom"]." data-type='".$ops["type"]."' ".$checked." autocomplete='nope' value='".$value."' class='".$ops["class"]."' type='".$ops["type"]."' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' placeholder='".lang('p_'.$ops["name"])."' /></td>";
             break;
          case "radio":
             $html.="<td ".$styleWidth.">";
             $checked="";
             if($value==1) {$checked='checked';}else{$checked='';} 
             $html.="Si <input ".$checked." style='height:20px;'".$ops["custom"]." data-type='radio' value='1' class='".$ops["class"]."' type='radio' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' />";
             if($value==0) {$checked='checked';}else{$checked='';} 
             $html.=" | No <input ".$checked." style='height:20px;'".$ops["custom"]." data-type='radio' value='0' class='".$ops["class"]."' type='radio' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' />";
             if($value==-1 or $value=="") {$checked='checked';}else{$checked='';} 
             $html.=" | No informa <input ".$checked." style='height:20px;'".$ops["custom"]." data-type='radio' value='-1' class='".$ops["class"]."' type='radio' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' />";
             $html.="</td>";
             break;
       }

    }
    $html.="</tr>";
    $html.="<tr><td colspan='2'><div class='invalid-feedback invalid-".$ops["name"]." d-none'/></td></tr>";
    $html.="</table>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getInput($parameters,$ops){
    $checked="";
    $html="";
    if(!isset($ops["possible_values"])){$ops["possible_values"]="";}
    if(!isset($ops["custom"])){$ops["custom"]="";}
    if(!isset($ops["forcelabel"])){$ops["forcelabel"]="";}
    if(!isset($ops["format"])){$ops["format"]="text";}
    if(!isset($ops["readonly"])){$ops["readonly"]=false;}
    if(!isset($ops["nolabel"])){$ops["nolabel"]=false;}
    if(!isset($ops["empty"])){$ops["empty"]=false;}
    if(!isset($parameters["records"]["data"][0])){$parameters["records"]["data"][0]=null;}
    if (!$ops["readonly"]) {
       if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
       $ops["readonly"]=$parameters["readonly"];
    }
    $value=secureField($parameters["records"]["data"][0],$ops["name"]);
    if ($ops["empty"]) {$value="";}
    if(isset($ops["default"]) and $value==""){$value=$ops["default"];}

    $label=lang('p_'.$ops["name"]);
    if($ops["forcelabel"]!=""){$label=$ops["forcelabel"];}
    if(!$ops["nolabel"]){$html.="<label for='".$ops["name"]."'>".$label."</label>";}
    if ($ops["readonly"]) {
       $html.=formatHtmlValue($value,$ops["format"]);
    } else {
	    $customIface=false;
        switch ($ops["type"]) {
            case "radiobutton":
			    $customIface=true;
				$html.="<table>";
				$html.="   <tr>";
				foreach ($ops["possible_values"] as $val){
					$checked="";
				    if($value==$val["value"]){$checked="checked";}
					$html.="<td>".$val["label"]."</td><td style='width:20px;padding-right:5px;'><input ".$checked." ".$ops["custom"]." class='".$ops["class"]."' data-type='radio' type='radio' id='".$ops["name"]."' name='".$ops["name"]."' value='".$val["value"]."'/></td>";
				}
				$html.="   <tr>";
				$html.="</table>";
            case "checkbox":
                if($value==1) {$checked='checked';}else{$checked='';} 
				$ops["class"] = str_replace("form-control","",$ops["class"]);
				$ops["custom"].="style='width:25px;height:25px;'";
                break;
            case "date":
                if ($value!=""){$value=date(FORMAT_DATE_DB, strtotime($value));}
                break;
            case "datetime-local":
                if ($value!=""){$value=str_replace(" ", "T", $value);}
                break;
        }
       if (!$customIface){$html.="<input ".$ops["custom"]." data-type='".$ops["type"]."' ".$checked." autocomplete='nope' value='".$value."' class='".$ops["class"]."' type='".$ops["type"]."' name='".$ops["name"]."' id='".$ops["name"]."' data-clear-btn='false' placeholder='".lang('p_'.$ops["name"])."' />";}
    }
    $html.="<div class='invalid-feedback invalid-".$ops["name"]." d-none'></div>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getTextArea($parameters,$ops){
    $html="";
    if(!isset($ops["format"])){$ops["format"]="text";}
    if(!isset($ops["readonly"])){$ops["readonly"]=false;}
    if(!isset($ops["nolabel"])){$ops["nolabel"]=false;}
    if(!isset($ops["empty"])){$ops["empty"]=false;}
    if(!isset($ops["rows"])){$ops["rows"]="2";}
    if(!isset($ops["custom"])){$ops["custom"]="";}
    if(!isset($parameters["records"]["data"][0])){$parameters["records"]["data"][0]=null;}
    if (!$ops["readonly"]) {
       if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
       $ops["readonly"]=$parameters["readonly"];
    }
    $value=secureField($parameters["records"]["data"][0],$ops["name"]);
    if ($ops["empty"]) {$value="";}
    if(isset($ops["default"]) and $value==""){$value=$ops["default"];}

    if(!$ops["nolabel"]){$html.="<label for='".$ops["name"]."'>".lang('p_'.$ops["name"])."</label>";}
    if ($ops["readonly"]) {
        $html.="<div class='border'><pre>".$value."</pre></div>";
    } else {
        $html.="<textarea ".$ops["custom"]." class='textarea ".$ops["class"]."' id='".$ops["name"]."' name='".$ops["name"]."' rows='".$ops["rows"]."' style='width:100%;' placeholder='".lang('p_'.$ops["name"])."'>".$value."</textarea>";
    }
    $html.="<div class='invalid-feedback invalid-".$ops["name"]." d-none'></div>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getHtmlResolved($parameters,$type,$field,$ops=null) {
    $html="";
    $label=lang('p_'.$field);
    if(!isset($ops["nolabel"])){$ops["nolabel"]=false;}
    if($ops["forcelabel"]!=""){$label=$ops["forcelabel"];}
    if(!$ops["nolabel"]){$html.="<label for='".$field."'>".$label."</label>";}
    $html.=$parameters[$type][$field];
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getComboMonths($id,$class, $id_selected=null) {
	$cboMonth="<select data-type='select' id='".$id."' name='".$id."' class='".$class."'>";
	if($id_selected==null or $id_selected==''){$selected="selected";}else{$selected="";}
	if ($id_selected==null){$cboMonth.="<option value='' ".$selected.">".lang('p_select_combo')."</option>";}
	if($selected=="" and $id_selected=='1'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='1' ".$selected.">Enero</option>";
	if($selected=="" and $id_selected=='2'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='2' ".$selected.">Febrero</option>";
	if($selected=="" and $id_selected=='3'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='3' ".$selected.">Marzo</option>";
	if($selected=="" and $id_selected=='4'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='4' ".$selected.">Abril</option>";
	if($selected=="" and $id_selected=='5'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='5' ".$selected.">Mayo</option>";
	if($selected=="" and $id_selected=='6'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='6' ".$selected.">Junio</option>";
	if($selected=="" and $id_selected=='7'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='7' ".$selected.">Julio</option>";
	if($selected=="" and $id_selected=='8'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='8' ".$selected.">Agosto</option>";
	if($selected=="" and $id_selected=='9'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='9' ".$selected.">Setiembre</option>";
	if($selected=="" and $id_selected=='10'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='10' ".$selected.">Octubre</option>";
	if($selected=="" and $id_selected=='11'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='11' ".$selected.">Noviembre</option>";
	if($selected=="" and $id_selected=='12'){$selected="selected";}else{$selected="";}
	$cboMonth.="<option value='12' ".$selected.">Diciembre</option>";
	$cboMonth.="</select>";
    return $cboMonth;
}
function getComboYears($id,$class,$back,$forth, $id_selected=null){
	$cboYear="<select data-type='select' id='".$id."' name='".$id."' class='".$class."'>";
	if($id_selected==null or $id_selected==''){$selected="selected";}else{$selected="";}
	if ($id_selected==null){$cboYear.="<option value='' ".$selected.">".lang('p_select_combo')."</option>";}
	$starting_year  =date('Y', strtotime($back));
	$ending_year = date('Y', strtotime($forth));
	$current_year = date('Y');
	for($starting_year; $starting_year <= $ending_year; $starting_year++) {
   	    if($selected=="" and $id_selected==$starting_year){$selected="selected";}else{$selected="";}
		$cboYear.="<option value='".$starting_year."' ".$selected.">".$starting_year."</option>";
	}               
	$cboYear.="</select>";
	return $cboYear;
}
function getCombo($parameters,$obj){
    $parts=explode("/",$parameters["model"]);
    if(!isset($parameters["data"])){$parameters["data"]="";}
    if(!isset($parameters["mode"])){$parameters["mode"]="NORMAL";}
    if(!isset($parameters["readonly"])){$parameters["readonly"]=false;}
    $ACTIVE=$obj->createModel($parts[0],$parts[1],$parts[1]);
    if(isset($parameters["sql"])){
        $records["data"]=$ACTIVE->getRecordsAdHoc($parameters["sql"]);
    } else {
        $records=$ACTIVE->get($parameters["get"]);
    }
    $html="";
    switch($parameters["mode"]) {
       case "NORMAL":
          $html.="<select data-type='select' id='".$parameters["name"]."' name='".$parameters["name"]."' class='".$parameters["name"]." ".$parameters["class"]."'>";
          break;
       case "MULTISELECT":
          $html.="<select data-actions-box='true' id='".$parameters["name"]."' name='".$parameters["name"]."' class='selectpicker ".$parameters["name"]." ".$parameters["class"]."' show-tick multiple data-width='100%' data-size='10' data-live-search='true' style='color:black;'>";
          break;
    }
    try {
        if((int)$parameters["empty"]) {$html.="<option value='' selected>".lang('p_select_combo')."</option>";}
        foreach($records["data"] as $record){
            $selected="";
            $id=secureField($record,$parameters["id_field"]);
            if(($id==$parameters["id_actual"])){$selected="selected";}
			$dataRecord="";
			if($parameters["data"]!=""){$dataRecord="data-record='".$record[$parameters["data"]]."'";}
            $html.="<option ".$dataRecord." ".$selected." value='".$id."'>".$record[$parameters["description_field"]]."</option>";
        };
    } catch(Exception $e){}
    $html.="</select>";
    $html.="<div class='invalid-feedback invalid-".$parameters["name"]." d-none'/>";
    return $html;
}
function getSingleSelect($parameters,$obj){
    $html="";
    try {
        $parts=explode("/",$parameters["actual"]["model"]);
        $parts=explode("/",$parameters["model"]);
        $ACTIVE=$obj->createModel($parts[0],$parts[1],$parts[1]);
        $records=$ACTIVE->get($parameters["get"]);
        $html.="<br/><select data-actions-box='true' id='".$parameters["name"]."' name='".$parameters["name"]."' class='selectpicker ".$parameters["name"]." ".$parameters["class"]."' show-tick data-width='100%' data-size='10' data-live-search='true' style='color:black;'>";
        if((int)$parameters["empty"]) {$html.="<option value='' selected>".lang('p_select_combo')."</option>";}
        foreach($records["data"] as $record){
            $selected="";
            $id=secureField($record,$parameters["id_field"]);
            if(($id==$parameters["id_actual"])){$selected="selected";}
            $html.="<option ".$selected." value='".$id."' style='color:navy;'>".$record[$parameters["description_field"]]."</option>";
        };
        $html.="</select>";
    } catch(Exception $e){

    }
    return $html;
}
function getMultiSelect($parameters,$obj){

log_message("error", "RELATED ".json_encode($parameters,JSON_PRETTY_PRINT));

    $html="";
    try {
        if(!isset($parameters["icon_field"])){$parameters["icon_field"]=null;}
        if(!isset($parameters["options"])){$parameters["options"]=null;}
        if(!isset($parameters["children"])){$parameters["children"]=null;}
        $parts=explode("/",$parameters["actual"]["model"]);
        $RELATED=$obj->createModel($parts[0],$parts[1],$parts[1]);
        $related=$RELATED->get(array("pagesize"=>-1,"where"=>($parameters["actual"]["id_field"]."=".$parameters["actual"]["id_value"])));
        $parts=explode("/",$parameters["model"]);
        $ACTIVE=$obj->createModel($parts[0],$parts[1],$parts[1]);
        $records=$ACTIVE->{$parameters["function"]}($parameters["options"]);
        $html.="<br/><select data-actions-box='true' id='".$parameters["name"]."' name='".$parameters["name"]."' class='selectpicker ".$parameters["name"]." ".$parameters["class"]."' show-tick multiple data-width='100%' data-size='10' data-live-search='true' style='color:black;'>";
        foreach($records["data"] as $record){
            $selected="";
            $id=secureField($record,$parameters["id_field"]);
            foreach($related["data"] as $item){if($item[$parameters["name"]]==$id){$selected="selected";break;}}
            $data_content="";
            if ($parameters["icon_field"]!=null){$data_content="data-content='<i class=\"material-icons\">".$record[$parameters["icon_field"]]."</i> ".$record[$parameters["description_field"]]."'";}
            $html.="<option ".$data_content." ".$selected." value='".$id."' style='color:navy;'>".$record[$parameters["description_field"]]."</option>";
            if($parameters["children"]!=null) {
                if (isset($record[$parameters["children"]])) {
                    foreach($record[$parameters["children"]] as $child){
                        $selected="";
                        $id=secureField($child,$parameters["id_field"]);
                        foreach($related["data"] as $subitem){if($subitem[$parameters["name"]]==$id){$selected="selected";break;}}
                        $data_content="";
                        if ($parameters["icon_field"]!=null){$data_content="data-content='<i class=\"material-icons\">".$child[$parameters["icon_field"]]."</i> ".$child[$parameters["description_field"]]."'";}
                        $html.="<option ".$data_content." ".$selected." value='".$id."' style='margin-left:10px;color:grey;'>".$child[$parameters["description_field"]]."</option>";
                    }
                }
            }
        };
        $html.="</select>";
    } catch(Exception $e){

    }
    return $html;
}
function getProgressBar($parameters,$ops){
    $hide="";
    if(!isset($ops["dyncolor"])){$ops["dyncolor"]=false;}
    if(!isset($ops["min"])){$ops["min"]="0";}
    if(!isset($ops["max"])){$ops["max"]="100";}
    if(!isset($ops["value"])){$ops["value"]="0";}
    if(!isset($ops["class"])){$ops["class"]="progress-bar-striped progress-bar-animated";}
    if ($ops["dyncolor"]) {
       if ((int)$ops["value"]<10) { 
          $ops["class"].=" bg-secondary";
       } elseif ((int)$ops["value"]<25) {
          $ops["class"].=" bg-danger";
       } elseif ((int)$ops["value"]<50) {
          $ops["class"].=" bg-info";
       } elseif ((int)$ops["value"]<80) {
          $ops["class"].=" bg-primary";
       } elseif ((int)$ops["value"]<100) {
          $ops["class"].=" bg-success";
       } elseif ((int)$ops["value"]==100) {
          $ops["class"].=" bg-light";
          $hide="d-none";
       }
    }
    $html="";
    $html.="<div class='progress ".$hide."' style='height:2px;'>";
    $html.="   <div class='progress-bar ".$ops["class"]."' role='progressbar' aria-valuenow='".$ops["value"]."' aria-valuemin='".$ops["min"]."' aria-valuemax='".$ops["max"]."' style='width: ".$ops["value"]."%'></div>";
    $html.="</div>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}
function getButtonRibbon($parameters,$ops){
  if(!isset($parameters["class"])){$parameters["class"]="btn-default";}
  $html="<div class='btn-toolbar' role='toolbar'>";  
  $html.="<div class='btn-group mr-2' role='group'>";
  //$html.=$parameters["name"];
  foreach($ops as $op){
      if(!isset($op["mode"])){$op["mode"]="";}
      if(!isset($op["class"])){$op["class"]="";}
      if(!isset($op["link"])){$op["link"]="#";}
      if(!isset($op["datax"])){$op["datax"]="";}
      if(!isset($op["style"])){$op["style"]="";}
      //if ($parameters["name"]!=$op["name"]) {
        $html.="<button type='button' class='btn btn-sm btn-primary btn-raised ".$op["class"]."' ".$op["datax"]." style='".$op["style"]."'>".$op["name"]."</button>";
      //}
  }
  $html.="</div>";
  $html.="</div>";
  return $html;
}
function getDropdown($parameters,$ops){
  if(!isset($parameters["direction"])){$parameters["direction"]="";}
  if(!isset($parameters["class"])){$parameters["class"]="btn-default";}
  $html="<div class='btn-group p-0 m-0 ".$parameters["direction"]."'>";
  $html.="<button type='button' class='btn btn-sm ".$parameters["class"]." dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
  $html.=$parameters["name"];
  $html.="</button>";
  $html.="<div class='dropdown-menu'>";
  foreach($ops as $op){
      if(!isset($op["mode"])){$op["mode"]="";}
      if(!isset($op["class"])){$op["class"]="";}
      if(!isset($op["link"])){$op["link"]="#";}
      if(!isset($op["datax"])){$op["datax"]="";}
      if(!isset($op["style"])){$op["style"]="";}
      switch($op["mode"]) {
         case "divider":
            $html.="<div class='dropdown-divider'></div>";
            break;
         default:
            $html.="<a ".$op["datax"]." class='dropdown-item ".$op["class"]."' href='".$op["link"]."' style='".$op["style"]."'>".$op["name"]."</a>";
            break;
      }
  }
  $html.="</div>";
  $html.="</div>";
  return $html;
}
function getMessagesList($parameters,$ops,$list=null){
    $body=getTextArea($parameters,array("col"=>"col-md-12","name"=>"message","class"=>"form-control text validate-message trumbo"));
    $body.="<div class='modal-footer font-weight-light'>";
    $body.="<button type='button' class='btn btn-sm btn-primary btn-success-message'>".lang('b_accept')."</button>";
    $body.="</div>";
    $body=base64_encode($body);

    $html="<a href='#' class='btn btn-sm btn-block btn-raised btn-primary btn-message-external' data-list='.ls-".$ops["name"]."' data-body='".$body."' data-title='".lang('b_new_message')."'>".lang('b_new_message')."</a>";
    $html.="<ul class='ls-".$ops["name"]." list-inline'>";
    foreach ($list as $message){
        $html.="<li style='width:100%;' class='list-group-item li-" .$message["id"]. "'>";
        $html.="<table class='table-condensed table-striped' style='width:100%;'>";
        $html.=" <tr><td>".$message["message"]. "</td></tr>";
        $html.=" <tr>";
        $html.="  <td align='right' style='font-size:9px;' class='td-".$message["id"]."'>";
        $html.=$message["created"]. ": <i>" .$message["username"]."</i>";
        if ((int)$message["viewed"]==0){
            $html.=" <a href='#' class='btn btn-sm btn-info btn-message-read btn-raised sp-" .$message["id"]. "' data-id='".$message["id"]."'>".lang('b_mark')."</a>";
        } else {
            $html.=" <span class='badge badge-success' style='font-size:12px;'>".lang('b_checked')."</span>";
        }
        $html.="  </td>";
        $html.=" </tr>";
        $html.="</table>";
        $html.="</li>";
    }
    $html.="</ul>";
    if(isset($ops["col"])){$html="<div class='".$ops["col"]."'>".$html."</div>";}
    return $html;
}

//CUSTOM BUTTONS
function getHelpButton($item,$ops){
   $body=$item[$ops["body"]];
   if ($body!=""){$body=base64_encode($item[$ops["body"]]);}
   $html="<i data-title='".ucfirst(lang($item[$ops["title"]]))."' data-body='".$body."' class='btn-brief material-icons bg-light' style='font-size:20px;position:absolute;top:50%;right:1px;z-index:99999;cursor:help;'>help_outline</i>";
   return $html;
}

//SECURE READ DATA AND POSITIONING
function secureField($record,$field){
    if (!isset($record[$field])) {
        $field=strtoupper($field);
        if (!isset($record[$field])) {
           $record[$field]="";
        }
    }
    return $record[$field];
}
function secureEmptyNull($values,$key){
    if (!isset($values[$key])) {$values[$key]=null;}
    if($values[$key]=="" OR $values[$key]==-1){$values[$key]=null;}
    return $values[$key];
}
function secureFloatNull($values,$key){
    if (!isset($values[$key])) {$values[$key]=null;}
    $values[$key]=str_replace(",",".",$values[$key]);
    $pattern = '/^[-+]?(((\\\\d+)\\\\.?(\\\\d+)?)|\\\\.\\\\d+)([eE]?[+-]?\\\\d+)?$/';
    if (preg_match($pattern, trim($values[$key]))){$values[$key]=null;} 
    if($values[$key]==""){$values[$key]=null;}
    return $values[$key];
}
function secureComboPosition($records,$field){
    try {
        if ($records["status"]=="OK"){
            if (isset($records["data"][0][$field])) {
               return $records["data"][0][$field];
            } else {
                throw new Exception("");
            }
        } else {
            throw new Exception("");
        }
    } catch(Exception $rex) {
       return null;
    }
}
function secureButtonDisplay($parameters,$record,$action){
    try {
        if (!isset($parameters["buttons"]["check"])){$parameters["buttons"]["check"]=false;}
        if (!isset($parameters["buttons"][$action])){return true;}
        if (is_array($parameters["buttons"][$action])) {
            foreach($parameters["buttons"][$action]["conditions"] as $condition) {if(!compareRecordValue($record,$condition)){return false;}}
            return true;
        } else {
            return $parameters["buttons"][$action];
        }
    } catch(Exception $e){
        return true;
    }
}
function compareRecordValue($record,$condition){
    try {
        $rValue=$record[$condition["field"]];
        switch($condition["operator"]) {
            case "=":
            case "==":
            case "===":
                return ($rValue==$condition["value"]);
            case "!=":
                return ($rValue!=$condition["value"]);
            case ">=":
                return ($rValue>=$condition["value"]);
            case "<=":
                return ($rValue<=$condition["value"]);
            default:
                return true;
        }
    } catch(Exception $e){
        return true;
    }
}

//HTML FORMAT VALUES
function formatHtmlValue($value,$format,$ops=null){
    switch($format) {
	    case "yesno":
		    if ((string)$value=="1" or strtoupper((string)$value)=="SI" or strtoupper((string)$value)=="YES"){
	            $value="Si";
	            $value=("<span class='badge badge-primary' style='display:block;font-size:0.80rem;'>".$value."</span>");
			} else {
    		    if ((string)$value=="0" or strtoupper((string)$value)=="NO"){
	               $value="No";
	               $value=("<span class='badge badge-secondary' style='display:block;font-size:0.80rem;'>".$value."</span>");
				} else {
	               $value=("<span class='badge badge-light' style='display:block;font-size:0.80rem;'>--</span>");
				}
			}
			break;
        case "image":
            $value=("<img class='rounded-circle shadow' src='".$value."' style='width:42px;'/>");
            break;
        case "integrity":
            if($value==""){$value="<span class='badge badge-danger' style='font-size:0.80rem;'>".lang('msg_error_integrity')."</span>";}
            if($value==0 or $value==1){$value="<span class='badge badge-warning' style='font-size:0.80rem;'>".lang('msg_alert_integrity')."</span>";}
            if($value==2){$value="<span class='badge badge-success' style='font-size:0.80rem;'>".lang('msg_success_integrity')."</span>";}
            break;
        case "money":
            $value=("<var style='display:block;text-align:right;font-size:0.80rem;'>$ ".$value."</var>");
            break;
        case "percent":
            $value=("<var style='display:block;text-align:right;font-size:0.80rem;'>".$value."%</var>");
            break;
        case "number":
            $value=("<var style='display:block;text-align:right;font-size:0.80rem;'>".$value."</var>");
            break;
        case "date":
            if ($value!=""){$value=date(FORMAT_DATE_DMY, strtotime($value));}else{$value="";}
            $value=("<span class='bd-highlight' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "datetime":
            if ($value!=""){$value=date(FORMAT_DATE_DMYHMS, strtotime($value));}else{$value="";}
            $value=("<span class='bd-highlight' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "code":
            $value=("<kbd style='display:block;font-size:0.80rem;'>".$value."</kbd>");
            break;
        case "email-action":
            if (strpos($value,"@")!==false) {
               $value=getEmailArrayFromString($value);
               $value=("<a href='#' class='btn btn-raised btn-sm btn-info btn-reply-email p-0 m-0' data-email='".$value[0]."' style='display:block;font-size:0.80rem;'><i class='material-icons'>email</i> ".$value[0]."</a>");
            } else{
               $value=("<span class='badge badge-info' style='display:block;font-size:0.80rem;'>".$value."</span>");
            }
            break;
        case "email":
            $class="badge badge-secondary";
            $value=str_replace(">","",$value);
            $value=("<pre class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</pre>");
            break;

        case "reviewed":
            $class="badge badge-success";
            if($value==""){$value="No revisado";$class="badge badge-danger";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;

        case "danger":
            $class="badge badge-danger";
            if($value==""){$value=lang('msg_empty');$class="badge badge-light";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "warning":
            $class="badge badge-warning";
            if($value==""){$value=lang('msg_empty');$class="badge badge-light";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "status":
            $class="badge badge-primary";
            if($value==""){$value=lang('msg_empty');$class="badge badge-light";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "type":
            $class="badge badge-info";
            if($value==""){$value=lang('msg_empty');$class="badge badge-light";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "text":
            $value=("<span class='text-monospace text-break' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "shorten":
            $value="<div class='comment more p-0 m-0' style='background-color:transparent;font-size:0.80rem;'>".$value."</div>";
            break;
        case "fixed":
            $value="<table style='table-layout:fixed;width:100%;font-size:0.80rem;'><tr><td style='word-wrap:break-word;'>".$value."</td></tr></table>";
            break;
        case "json":
            $value=("<pre class='text-break' style='display:block;font-size:0.80rem;'>".json_encode(json_decode($value),JSON_PRETTY_PRINT)."</pre>");
            break;
        case "sign":
            $value=("<pre class='text-break' style='display:block;font-size:0.80rem;'><small>".$value."</small></pre>");
            break;
        case "verify":
            $class="badge badge-success";
            if($value==""){$value=lang('msg_empty');$class="badge badge-warning";}
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        case "check":
            if($value==0){$value="<div><i class='material-icons'>thumb_down_alt</i></div>";}else{$value="<div><i class='material-icons'>thumb_up_alt</i></div>";}
            break;
        case "private":
            $msg=lang('msg_group_assigned');
            if($value==1){$msg=lang('msg_groups_assigned');}
            if($value==0){$value="<div style='font-size:0.80rem;'><i class='material-icons'>lock</i> ".lang('msg_only_creator')."</div>";}else{$value="<div style='font-size:0.80rem;'><i class='material-icons'>people</i> ".$value." ".$msg."</div>";}
            break;
        case "message":
            $value="<div style='font-size:0.80rem;'><i class='material-icons'>email</i> ".$value."</div>";
            break;
        case "auditoria_telefonica":
            $segments=explode("-",$value);
            $strDate=explode(".",$segments[2]);
            $data=explode("-",(string)date("Y-m-d", strtotime($strDate[0])));
            $mp3=(PREFIX_FILEGET.FILES_TELEPHONY_MP3.$data[0].'/'.$data[1].'/'.$data[2].'/'.$value);
            $value="<audio controls style='height:25px;'><source src='".$mp3."' type='audio/mpeg'></audio>";
            //$value.="<a href='https://intranet.credipaz.com".$mp3."' target='_blank'>Link alternativo</a>";
            break;
        case "auditoria_io":
            $class="badge badge-info";
            switch($value){
               case "SALIENTE":
                  $class="badge badge-primary";
                  break;
            }
            $value=("<span class='".$class."' style='display:block;font-size:0.80rem;'>".$value."</span>");
            break;
        default:
            break;
    }
    if(isset($ops["col"])){$value="<div class='".$ops["col"]."'>".$value."</div>";}
    return $value;
}
function callAPI($url, $data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err=curl_error($ch);
    curl_close($ch);
    return $response;
}

function cUrlRestfulGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err=curl_error($ch);
    curl_close($ch);
    return $response;
}
