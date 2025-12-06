<?php
//log_message("error", "SQL ".$sql);
/*---------------------------------*/

//HTML COMBOS
function comboTypeTickets($obj){
    $parameters=array(
        "model"=>(MOD_SUPPORT."/Type_tickets"),
        "table"=>"type_tickets",
        "name"=>"browser_id_type_ticket",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypeTicketsStatus($obj){
    $parameters=array(
        "model"=>(MOD_SUPPORT."/Type_status"),
        "table"=>"type_status",
        "name"=>"browser_id_type_status",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypeBaseWorks($obj){
    $parameters=array(
        "model"=>(MOD_SUPPORT."/Type_base_works"),
        "table"=>"type_base_works",
        "name"=>"browser_id_type_base_work",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypePriority($obj){
    $parameters=array(
        "model"=>(MOD_SUPPORT."/Type_priority"),
        "table"=>"type_priority",
        "name"=>"browser_id_type_priority",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
