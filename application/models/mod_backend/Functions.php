<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Functions extends MY_Model {
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
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description")),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_BACKEND."/functions/abm");
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters=array(
                "model"=>(MOD_BACKEND."/Functions"),
                "table"=>"functions",
                "name"=>"id_parent",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_parent"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("where"=>"id_parent IS null","order"=>"description ASC","pagesize"=>-1),
            );
            $values["controls"]=array("id_parent"=>getCombo($parameters,$this));
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
                    'icon' => $values["icon"],
                    'id_parent' => secureEmptyNull($values,"id_parent"),
                    'data_module' => $values["data_module"],
                    'data_model' => $values["data_model"],
                    'data_table' => $values["data_table"],
                    'data_action' => $values["data_action"],
                    'priority' => $values["priority"],
                    'running' => $values["running"],
                    'brief' => $values["brief"],
                    'show_brief' => $values["show_brief"],
                    'alert_build' => $values["alert_build"],
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
                    'icon' => $values["icon"],
                    'id_parent' => secureEmptyNull($values,"id_parent"),
                    'data_module' => $values["data_module"],
                    'data_model' => $values["data_model"],
                    'data_table' => $values["data_table"],
                    'data_action' => $values["data_action"],
                    'priority' => $values["priority"],
                    'running' => $values["running"],
                    'brief' => $values["brief"],
                    'show_brief' => $values["show_brief"],
                    'alert_build' => $values["alert_build"],
                );
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function menuTree($values){
        try {
            $values["where"]=$this->resolveWhereMenu(null,$values["id_user_active"]);
            $values["order"]="priority ASC";
            $values["pagesize"]=-1;
            $menu=$this->get($values);
            $i=0;
            foreach ($menu["data"] as $function){
                $values["where"]=$this->resolveWhereMenu($function["id"],$values["id_user_active"]);
                $submenu=$this->get($values);
                $menu["data"][$i]["submenu"]=$submenu["data"];
                $i+=1;
            }
            return $menu;
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function menuTreeFull(){
        try {
            $values["where"]="id_parent IS null AND offline IS null";
            $values["order"]="priority ASC";
            $values["pagesize"]=-1;
            $menu=$this->get($values);
            $i=0;
            foreach ($menu["data"] as $function){
                $values["where"]="id_parent=".$function["id"]." AND offline IS null";
                $submenu=$this->get($values);
                $menu["data"][$i]["submenu"]=$submenu["data"];
                $i+=1;
            }
            return $menu;
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    private function resolveWhereMenu($nodo,$id_user){
        if($nodo!=null){$nodo=("=".$nodo);} else{$nodo=" IS null";}
        $where="id_parent ".$nodo." AND offline IS null";
        $where.=" AND id IN ";
        $where.=" (";
        $where.="    SELECT id_function FROM ".MOD_BACKEND."_rel_groups_functions WHERE id_group IN ";
        $where.="       (";
        $where.="          SELECT id_group FROM ".MOD_BACKEND."_rel_users_groups WHERE id_user=".$id_user;
        $where.="       )";
        $where.=" )";
        return $where;
    }
}
