<?php
//log_message("error", "SQL ".$sql);
/*---------------------------------*/

//HTML COMBOS
function comboTypeResponsables($obj){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Type_responsables"),
        "table"=>"type_responsables",
        "name"=>"browser_id_type_responsable",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypeAvailabilities($obj){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Type_availabilities"),
        "table"=>"type_availabilities",
        "name"=>"browser_id_type_availability",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypeExposures($obj){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Type_exposures"),
        "table"=>"type_exposures",
        "name"=>"browser_id_type_exposures",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboNets($obj,$gt=array("order"=>"description ASC","pagesize"=>-1)){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Nets"),
        "table"=>"nets",
        "name"=>"browser_id_net",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}
function comboServers($obj){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Servers"),
        "table"=>"servers",
        "name"=>"browser_id_server",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboSystems($obj){
    $parameters=array(
        "model"=>(MOD_INFRASTRUCTURE."/Systems"),
        "table"=>"systems",
        "name"=>"browser_id_system",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
