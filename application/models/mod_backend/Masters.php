<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Masters extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_masters";
            $values["order"]="username ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"id","format"=>"number"),
                array("field"=>"image","format"=>"image"),
                array("field"=>"username","format"=>"email"),
                array("field"=>"type_plan","format"=>"type"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("username","type_plan")),
                array("name"=>"browser_id_type_plan", "operator"=>"=","fields"=>array("id_type_plan")),
            );
            $values["controls"]=array(comboTypePlans($this));
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_BACKEND."/masters/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters_id_type_plan=array(
                "model"=>(MOD_BACKEND."/Type_plans"),
                "table"=>"type_plans",
                "name"=>"id_type_plan",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_plan"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );

            $values["controls"]=array(
                "id_type_plan"=>getCombo($parameters_id_type_plan,$this),
            );

            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            if (!isset($values["image"])){$values["image"]=null;}
            if (!isset($values["phone"])){$values["phone"]=null;}
            $id=(int)$values["id"];
            $fields=null;
            if($id==0){
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'created' => $this->now,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
                    'id_type_plan' => secureEmptyNull($values,"id_type_plan"),
                    'username' => $values["username"],
                    'image' => $values["image"],
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
                    'id_type_plan' => secureEmptyNull($values,"id_type_plan"),
                    'username' => $values["username"],
                    'image' => $values["image"],
                );
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}

