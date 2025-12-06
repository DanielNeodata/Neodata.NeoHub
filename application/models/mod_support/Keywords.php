<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Keywords extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_keywords";
            $values["order"]="created DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"id","format"=>"number"),
                array("field"=>"description","format"=>"text"),
                array("field"=>"application","format"=>"danger"),
                array("field"=>"net","format"=>"type"),
                array("field"=>"server","format"=>"type"),
                array("field"=>"username_creator","format"=>"warning"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("description")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_net", "operator"=>"=","fields"=>array("id_net")),
                array("name"=>"browser_id_server", "operator"=>"=","fields"=>array("id_server")),
                array("name"=>"browser_id_system", "operator"=>"=","fields"=>array("id_system")),
            );
            $values["controls"]=array(
                "<span class='badge badge-info'>Aplicación</span>".comboApps($this),
                "<span class='badge badge-info'>Red</span>".comboNets($this),
                "<span class='badge badge-info'>Servidor</span>".comboServers($this),
                "<span class='badge badge-info'>Sistema</span>".comboSystems($this),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_SUPPORT."/keywords/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters_id_user_creator=array(
                "model"=>(MOD_BACKEND."/users"),
                "table"=>"users",
                "name"=>"id_user_creator",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_user_creator"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_application=array(
                "model"=>(MOD_BACKEND."/applications"),
                "table"=>"applications",
                "name"=>"id_type_application",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_application"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_net=array(
                "model"=>(MOD_INFRASTRUCTURE."/nets"),
                "table"=>"nets",
                "name"=>"id_net",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_net"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_server=array(
                "model"=>(MOD_INFRASTRUCTURE."/servers"),
                "table"=>"servers",
                "name"=>"id_server",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_server"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_system=array(
                "model"=>(MOD_INFRASTRUCTURE."/systems"),
                "table"=>"systems",
                "name"=>"id_system",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_system"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );

            $values["controls"]=array(
                "id_user_creator"=>getCombo($parameters_id_user_creator,$this),
                "id_type_application"=>getCombo($parameters_id_application,$this),
                "id_net"=>getCombo($parameters_id_net,$this),
                "id_server"=>getCombo($parameters_id_server,$this),
                "id_system"=>getCombo($parameters_id_system,$this),
            );
            $opts=array(
                "module"=>MOD_BACKEND,
                "model"=>"files_attached",
                "view"=>"files_attached",
                "where"=>"table_rel='".MOD_SUPPORT."_knows' AND id_rel=".$values["id"]
            );
			$values["attached_files"] = parent::getAttachments($values,$opts);
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
			    if ($fields==null) {
					$fields = array(
						'code' => $values["code"],
						'description' => $values["description"],
						'created' => $this->now,
						'verified' => $this->now,
						'offline' => null,
						'fum' => $this->now,
						'id_ticket' => secureEmptyNull($values,"id_ticket"),
						'id_net' => secureEmptyNull($values,"id_net"),
						'id_server' => secureEmptyNull($values,"id_server"),
						'id_system' => secureEmptyNull($values,"id_system"),
						'id_application' => secureEmptyNull($values,"id_type_application"),
						'id_user_creator' => secureEmptyNull($values,"id_user_creator"),
					);
				}
            } else {
			    if ($fields==null) {
					$fields = array(
						'code' => $values["code"],
						'description' => $values["description"],
						'fum' => $this->now,
						'id_ticket' => secureEmptyNull($values,"id_ticket"),
						'id_net' => secureEmptyNull($values,"id_net"),
						'id_server' => secureEmptyNull($values,"id_server"),
						'id_system' => secureEmptyNull($values,"id_system"),
						'id_application' => secureEmptyNull($values,"id_type_application"),
						'id_user_creator' => secureEmptyNull($values,"id_user_creator"),
					);
				}
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
