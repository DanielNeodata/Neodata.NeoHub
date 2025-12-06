<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
$html=buildHeaderBrowStd($parameters,$title);
if (!isset($parameters["records"])) {
    $html.=getUnInitialized();
} else {
    $nodata=getNoData();
    $html.="<div class='body-browser d-flex border-light p-2 rounded shadow-sm'>";
    $html.=" <table class='table-browser table table-hover'>";
    $html.=buildBodyHeadBrowStd($parameters);
    $html.="  <tbody>";
    if(is_array($parameters["records"]["data"])) {
        foreach ((array)$parameters["records"]["data"] as $record){
            $nodata="";
            $html.="<tr class='record-".secureField($record,"id")."'>";
            $html.=getTdCheck($parameters,$record,true);
            $html.=getTdEdit($parameters,$record,true);
            foreach ($parameters["columns"] as $column) {$html.=getTdCol($parameters,$record,$column);}
            $html.=getTdDelete($parameters,$record,true);
            $html.=getTdOffline($parameters,$record,true);
            $html.="</tr>";
        }
    } 
    $html.="  </tbody>";
    $html.="  <tfoot></tfoot>";
    $html.=" </table>";
    $html.="</div>";
    $html.=$nodata;
    $html.=buildFooterBrowStd($parameters);
}
echo $html;
?>
<script>$('.browser_controls').each(function() {$(this).find('*').addClass('search-trigger');});</script>
<script>$('.multiselect').selectpicker();</script>
<script>$(".comment").shorten({showChars: 20,});</script>
