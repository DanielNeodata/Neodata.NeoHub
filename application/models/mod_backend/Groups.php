<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Groups extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $values["columns"]=array(
                array("field"=>"code","format"=>"code"),
                array("field"=>"description","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["order"]="description ASC";
            $values["records"]=$this->get($values);
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_BACKEND."/groups/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            $parameters_id_function=array(
                "model"=>(MOD_BACKEND."/Functions"),
                "table"=>"functions",
                "name"=>"id_function",
                "children"=>"submenu",
                "class"=>"multiselect dbase",
                "actual"=>array("model"=>(MOD_BACKEND."/Rel_groups_functions"),"table"=>"rel_groups_functions","id_field"=>"id_group","id_value"=>$values["id"]),
                "id_field"=>"id",
                "description_field"=>"description",
                "icon_field"=>"icon",
                "function"=>"menuTreeFull",
                "options"=>null,
            );
            $values["controls"]=array(
                "id_function"=>getMultiSelect($parameters_id_function,$this)
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
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
                );
            }
            $saved=parent::save($values,$fields);
            if($saved["status"]=="OK"){
               $params=array(
                    "module"=>MOD_BACKEND,
                    "model"=>"Rel_groups_functions",
                    "table"=>"rel_groups_functions",
                    "key_field"=>"id_group",
                    "key_value"=>$saved["data"]["id"],
                    "rel_field"=>"id_function",
                    "rel_values"=>(isset($values["id_function"]) ? $values["id_function"] :array())
               );
               parent::saveRelations($params);
            }
            return $saved;
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function delete($values){
        try {
            $deleted=parent::delete($values);
            if($deleted["status"]=="OK"){
               $params=array(
                    "module"=>MOD_BACKEND,
                    "model"=>"Rel_groups_functions",
                    "table"=>"rel_groups_functions",
                    "key_field"=>"id_group",
                    "key_value"=>$values["id"],
               );
               parent::deleteRelations($params);
            }
            return $deleted;
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
}
