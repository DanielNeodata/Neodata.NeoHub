<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Neo_authentication extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
	public function get($values){
	   $values["view"]=MOD_API."_vw_neo_authentication_dbo_mod_backend_users";
	   return parent::get($values);
	}

    public function usage($values){
        try {
            $profile=getUserProfile($this,$values["id_user_active"]);
            $data["active_api"] = str_replace('_', '', strtolower($values["model"]));
            $data["profile"] = $profile;
            $data["parameters"] = $values;
			$yLimit=((int)date("Y")-1);
			$data["yLimit"] = $yLimit;
			$where=(" year_usage>=".$yLimit);
			$sql="SELECT * FROM ".MOD_API."_vw_neo_authentication_usage WHERE ".$where." ORDER BY api ASC, profile ASC, year_usage DESC, month_usage DESC";
            $usage=$this->getRecordsAdHoc($sql);
            $data["usage"] = $usage;

            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view(MOD_API."/neo_authentication/usage",$data,true);

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
    public function form($values){
        try {
            $profile=getUserProfile($this,$values["id_user_active"]);
            $data["active_api"] = str_replace('_', '', strtolower($values["model"]));
            $data["profile"] = $profile;
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view(MOD_API."/neo_authentication/form",$data,true);
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
    public function settings($values){
        try {
            $profile=getUserProfile($this,$values["id_user_active"]);
			$sql="SELECT * FROM ".MOD_API."_vw_neo_authentication_dbo_mod_backend_applications ORDER BY description ASC";
            $apps=$this->getRecordsAdHoc($sql);

            $data["active_api"] = str_replace('_', '', strtolower($values["model"]));
            $data["profile"] = $profile;
            $data["apps"] = $apps;
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view(MOD_API."/neo_authentication/settings",$data,true);
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
    public function brow($values){
        try {
            $values["order"]="username ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>false,
                "offline"=>true,
            );
            $values["columns"]=array(
                //array("field"=>"id","format"=>"number"),
                array("field"=>"image","format"=>"image"),
                array("field"=>"username","format"=>"text"),
                array("field"=>"name","format"=>"text"),
                array("field"=>"surname","format"=>"text"),
                array("field"=>"email","format"=>"email"),
                array("field"=>"phone","format"=>"email"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("username")),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_API."/neo_authentication/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters_id_application=array(
                "model"=>(MOD_API."/mod_api_vw_neo_authentication_dbo_mod_backend_applications"),
                "table"=>"mod_api_vw_neo_authentication_dbo_mod_backend_applications",
                "name"=>"id_application",
                "class"=>"multiselect dbase",
                "actual"=>array("model"=>(MOD_API."/mod_api_vw_neo_authentication_dbo_mod_backend_rel_users_applications"),"table"=>"mod_api_vw_neo_authentication_dbo_mod_backend_rel_users_applications","id_field"=>"id_user","id_value"=>$values["id"]),
                "id_field"=>"id",
                "description_field"=>"resolved",
                "options"=>array("order"=>"resolved ASC","pagesize"=>-1),
                "function"=>"get",
            );
            $values["controls"]=array(
                "id_application"=>getMultiSelect($parameters_id_application,$this),
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
            if (!isset($values["show_map"])){$values["show_map"]=0;}

			log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));

			if ($values["password"]!=""){$values["password"]=md5($values["password"]);}
            $id=(int)$values["id"];

			$sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_users_insert_update ";
			$sql.=$id.",";
			$sql.="'".$values["code"]."','".$values["description"]."',";
			$sql.="'".$values["username"]."','".$values["password"]."',";
			$sql.="'".$values["name"]."','".$values["surname"]."',";
			$sql.="'".$values["email"]."','".$values["phone"]."',";
			$sql.="'".$values["image"]."',".$values["show_map"];
		    $this->executeAdHoc($sql);

			/*relations!*/
			$sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_rel_users_applications_delete ".$id.",null";
		    $this->executeAdHoc($sql);
			foreach ($values["id_application"] as $app){
				$sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_rel_users_applications_insert ".$id.",".$app["id"];
				$this->executeAdHoc($sql);
			}

            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>false
            );
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function offline($values){
        try {
            $id=(int)$values["id"];
			$sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_users_offline_online ".$id.",'".$this->now."'";
		    $this->executeAdHoc($sql);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>false
            );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function online($values){
        try {
            $id=(int)$values["id"];
			$sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_users_offline_online ".$id.",null";
		    $this->executeAdHoc($sql);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>false
            );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
	public function stateLinkAPI($values){
        try {
			switch($values["state"]) {
			   case "link":
				  $sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_rel_users_applications_insert ".$values["user"].",".$values["application"];
			      break;
			   case "unlink":
				  $sql="EXEC dbo.mod_api_neo_authentication_dbo_mod_backend_rel_users_applications_delete ".$values["user"].",".$values["application"];
			      break;
			}
		    $this->executeAdHoc($sql);

            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
	}
}

