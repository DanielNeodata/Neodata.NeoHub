<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Systems extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_systems";
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
                array("field"=>"server","format"=>"type"),
                array("field"=>"type_responsable","format"=>"type"),
                array("field"=>"type_availability","format"=>"type"),
                array("field"=>"type_exposure","format"=>"type"),
                array("field"=>"color","format"=>"color","forcedlabel"=>""),
                array("field"=>"server_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_responsable_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_availability_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_exposure_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","created")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_type_responsable", "operator"=>"=","fields"=>array("id_type_responsable")),
                array("name"=>"browser_id_type_availability", "operator"=>"=","fields"=>array("id_type_availability")),
                array("name"=>"browser_id_type_exposure", "operator"=>"=","fields"=>array("id_type_exposure")),
            );
            $values["controls"]=array(
                "<span class='badge badge-info'>Aplicación</span>".comboApps($this),
                "<span class='badge badge-info'>Responsable</span>".comboTypeResponsables($this),
                "<span class='badge badge-info'>Disponibilidad</span>".comboTypeAvailabilities($this),
                "<span class='badge badge-info'>Exposición</span>".comboTypeExposures($this),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_INFRASTRUCTURE."/systems/abm");
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
            $parameters_id_type_availability=array(
                "model"=>(MOD_INFRASTRUCTURE."/type_availabilities"),
                "table"=>"type_availabilities",
                "name"=>"id_type_availability",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_availability"),
                "id_field"=>"id",
                "description_field"=>"description"
            );
            $parameters_id_type_exposure=array(
                "model"=>(MOD_INFRASTRUCTURE."/type_exposures"),
                "table"=>"type_exposures",
                "name"=>"id_type_exposure",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_exposure"),
                "id_field"=>"id",
                "description_field"=>"description"
            );
            $parameters_id_server=array(
                "model"=>(MOD_INFRASTRUCTURE."/servers"),
                "table"=>"servers",
                "name"=>"id_server",
                "class"=>"multiselect dbase",
                "actual"=>array("model"=>(MOD_INFRASTRUCTURE."/Rel_systems_servers"),"table"=>"rel_systems_servers","id_field"=>"id_system","id_value"=>$values["id"]),
                "id_field"=>"id",
                "description_field"=>"description",
                "options"=>array("order"=>"description ASC","pagesize"=>-1),
                "function"=>"get",
            );

            $values["controls"]=array(
                "id_type_application"=>getCombo($parameters_id_application,$this),
                "id_type_responsable"=>getCombo($parameters_id_type_responsable,$this),
                "id_type_availability"=>getCombo($parameters_id_type_availability,$this),
                "id_type_exposure"=>getCombo($parameters_id_type_exposure,$this),
                "id_server"=>getMultiSelect($parameters_id_server,$this),
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
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_type_responsable' => secureEmptyNull($values,"id_type_responsable"),
					'id_type_availability' => secureEmptyNull($values,"id_type_availability"),
					'id_type_exposure' => secureEmptyNull($values,"id_type_exposure"),
                    'color' => $values["color"],
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_type_responsable' => secureEmptyNull($values,"id_type_responsable"),
					'id_type_availability' => secureEmptyNull($values,"id_type_availability"),
					'id_type_exposure' => secureEmptyNull($values,"id_type_exposure"),
                    'color' => $values["color"],
                );
            }
            $saved=parent::save($values,$fields);
            if($saved["status"]=="OK"){
               $params_servers=array(
                    "module"=>MOD_INFRASTRUCTURE,
                    "model"=>"Rel_systems_servers",
                    "table"=>"rel_systems_servers",
                    "key_field"=>"id_system",
                    "key_value"=>$saved["data"]["id"],
                    "rel_field"=>"id_server",
                    "rel_values"=>(isset($values["id_server"]) ? $values["id_server"] :array())
               );
               parent::saveRelations($params_servers);
            }
            return $saved;
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
