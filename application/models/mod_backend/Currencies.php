<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Currencies extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $values["order"]="code ASC";
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
            $values["where"]=("offline IS null");
            return parent::get($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
