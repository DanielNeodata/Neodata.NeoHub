<?php
//log_message("error", "SQL ".$sql);
/*---------------------------------*/

//HTML COMBOS
function comboTypeCurrencies($obj,$get=array("order"=>"description ASC","pagesize"=>-1)){
    $parameters=array(
        "model"=>(MOD_FINANCES."/Type_currencies"),
        "table"=>"Type_currencies",
        "name"=>"browser_id_type_currency",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}
function comboTypeInvoices($obj,$get=array("order"=>"description ASC","pagesize"=>-1)){
    $parameters=array(
        "model"=>(MOD_FINANCES."/Type_invoices"),
        "table"=>"Type_invoices",
        "name"=>"browser_id_type_invoice",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}
function comboTypeIvas($obj,$get=array("order"=>"description ASC","pagesize"=>-1)){
    $parameters=array(
        "model"=>(MOD_FINANCES."/Type_ivas"),
        "table"=>"Type_ivas",
        "name"=>"browser_id_type_ivas",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}
