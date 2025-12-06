<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Applications extends MY_Model {
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
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function getExposed($values){
        try {
            $values["fields"]=("id,code,description");
            $values["where"]=("offline IS null AND id IN (SELECT id_application FROM mod_backend_rel_users_applications WHERE id_user=".$values["id_user_active"].")");
            return parent::get($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
