<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Nets extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_nets";
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
                array("field"=>"type_responsable","format"=>"type"),
                array("field"=>"color","format"=>"color","forcedlabel"=>""),
                array("field"=>"type_responsable_color","format"=>"color","forcedlabel"=>""),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","created")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_type_responsable", "operator"=>"=","fields"=>array("id_type_responsable")),
            );
            $values["controls"]=array(
                "<span class='badge badge-info'>Aplicación</span>".comboApps($this),
                "<span class='badge badge-info'>Responsable</span>".comboTypeResponsables($this),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_INFRASTRUCTURE."/nets/abm");
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

            $values["controls"]=array(
                "id_type_application"=>getCombo($parameters_id_application,$this),
                "id_type_responsable"=>getCombo($parameters_id_type_responsable,$this),
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
                    'color' => $values["color"],
                );
            } else {
                $fields = array(
                    'code' => $values["code"],
                    'description' => $values["description"],
                    'fum' => $this->now,
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
    public function form($values){
        try {
            $SERVERS=$this->createModel(MOD_INFRASTRUCTURE,"Servers","Servers");
            $SYSTEMS=$this->createModel(MOD_INFRASTRUCTURE,"Systems","Systems");
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $this->view="vw_nets";
            $values["order"]="application ASC, code ASC";
            $nets=$this->get($values);
			$i=0;
  			$x=0;
			foreach($nets["data"] as $net){
                $SERVERS->view="vw_servers";
                $servers=$SERVERS->get(array("fields"=>"*","where"=>"id_net=".$net["id"]));
    			$x=0;
                foreach($servers["data"] as $server){
	               $SYSTEMS->view="vw_systems";
                   $systems=$SYSTEMS->get(array("where"=>"id IN (SELECT id_system FROM ".MOD_INFRASTRUCTURE."_rel_systems_servers WHERE id_server=".$server["id"].")"));
				   $servers["data"][$x]["systems"]=$systems["data"];
		 		   $x+=1;
				}
				$nets["data"][$i]["servers"]=$servers["data"];
			    $i+=1;
            }
			$data["nets"]=$nets;
			
			$sql="SELECT count(id) as total, id_type_responsable,type_responsable,type_responsable_color FROM ".MOD_INFRASTRUCTURE."_vw_servers GROUP BY id_type_responsable,type_responsable,type_responsable_color";
			$byResponsable=$this->getRecordsAdHoc($sql);
			$data["byResponsable"]=$byResponsable;

			$sql="SELECT count(id) as total, id_type_exposure,type_exposure,type_exposure_color,id_type_responsable,type_responsable,id_application,application FROM ".MOD_INFRASTRUCTURE."_vw_systems GROUP BY id_type_exposure,type_exposure,type_exposure_color,id_type_responsable,type_responsable,id_application,application ORDER by application ASC, type_exposure";
			$byExposure=$this->getRecordsAdHoc($sql);
			$data["byExposure"]=$byExposure;

            $html=$this->load->view(MOD_INFRASTRUCTURE."/nets/form",$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
