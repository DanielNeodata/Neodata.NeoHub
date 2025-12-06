<?php
//log_message("error", "SQL ".$sql);
/*---------------------------------*/

//HTML COMBOS
function comboUsers($obj,$get=array("order"=>"username ASC","pagesize"=>-1)){
    if (!isset($get["id_actual"])){$get["id_actual"]="";}
    $parameters=array(
        "model"=>(MOD_BACKEND."/Users"),
        "table"=>"Users",
        "name"=>"browser_id_user",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>$get["id_actual"],
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}

function comboTypePlans($obj){
    $parameters=array(
        "model"=>(MOD_BACKEND."/Type_plans"),
        "table"=>"type_plans",
        "name"=>"browser_id_type_plan",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboTypeUsers($obj){
    $parameters=array(
        "model"=>(MOD_BACKEND."/Type_users"),
        "table"=>"type_users",
        "name"=>"browser_id_type_user",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
function comboApps($obj,$get=array("order"=>"description ASC","pagesize"=>-1)){
    $parameters=array(
        "model"=>(MOD_BACKEND."/Applications"),
        "table"=>"applications",
        "name"=>"browser_id_app",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>$get,
    );
    return getCombo($parameters,$obj);
}
function comboMasters($obj){
    $parameters=array(
        "model"=>(MOD_BACKEND."/Masters"),
        "table"=>"masters",
        "name"=>"browser_id_master",
        "class"=>"form-control",
        "empty"=>true,
        "id_actual"=>"",
        "id_field"=>"id",
        "description_field"=>"description",
        "get"=>array("order"=>"description ASC","pagesize"=>-1),
    );
    return getCombo($parameters,$obj);
}
