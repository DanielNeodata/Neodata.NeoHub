<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Servers extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_servers";
            $values["order"]="code ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>true,
            );
            $values["columns"]=array(
                array("field"=>"code","format"=>"code"),
                array("field"=>"description","format"=>"text"),
                array("field"=>"application","format"=>"danger"),
                array("field"=>"net","format"=>"type"),
                array("field"=>"type_responsable","format"=>"type"),
                array("field"=>"type_exposure","format"=>"type"),
                array("field"=>"color","format"=>"color","forcedlabel"=>""),
                array("field"=>"net_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_responsable_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_exposure_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","created")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_type_responsable", "operator"=>"=","fields"=>array("id_type_responsable")),
                array("name"=>"browser_id_type_exposure", "operator"=>"=","fields"=>array("id_type_exposure")),
                array("name"=>"browser_id_net", "operator"=>"=","fields"=>array("id_net")),
            );
            $values["controls"]=array(
                "<span class='badge badge-info'>Aplicación</span>".comboApps($this),
                "<span class='badge badge-info'>Exposición</span>".comboTypeExposures($this),
                "<span class='badge badge-info'>Responsable</span>".comboTypeResponsables($this),
                "<span class='badge badge-info'>Red</span>".comboNets($this,array("where"=>"1=2","order"=>"description ASC","pagesize"=>-1)),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_INFRASTRUCTURE."/servers/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            $parameters_id_application=array(
                "model"=>(MOD_BACKEND."/applications"),
                "table"=>"applications",
                "name"=>"id_type_application",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_application"),
                "id_field"=>"id",
                "description_field"=>"description"
            );
            $parameters_id_net=array(
                "model"=>(MOD_INFRASTRUCTURE."/nets"),
                "table"=>"nets",
                "name"=>"id_net",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_net"),
                "id_field"=>"id",
                "description_field"=>"description"
            );
            $parameters_id_type_responsable=array(
                "model"=>(MOD_INFRASTRUCTURE."/type_responsables"),
                "table"=>"type_responsables",
                "name"=>"id_type_responsable",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_responsable"),
                "id_field"=>"id",
                "description_field"=>"description"
            );
            $values["controls"]=array(
                "id_type_application"=>getCombo($parameters_id_application,$this),
                "id_type_responsable"=>getCombo($parameters_id_type_responsable,$this),
                "id_net"=>getCombo($parameters_id_net,$this),
            );

            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        try {
            $id=(int)$values["id"];
            if($id==0){
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'created' => $this->now,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
					'id_net' => secureEmptyNull($values,"id_net"),
                    'ip' => $values["ip"],
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_type_responsable' => secureEmptyNull($values,"id_type_responsable"),
                    'color' => $values["color"],
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
					'id_net' => secureEmptyNull($values,"id_net"),
                    'ip' => $values["ip"],
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_type_responsable' => secureEmptyNull($values,"id_type_responsable"),
                    'color' => $values["color"],
                );
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

}
