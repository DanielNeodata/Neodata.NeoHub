<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Neo_tools extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function formQR($values){
        try {
            $data["active_api"] = str_replace('_', '', strtolower($values["model"]));
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_api_qr"));
            $data["profile"] = getUserProfile($this,$values["id_user_active"]);
            $html=$this->load->view(MOD_API."/".$values["model"]."/formQR",$data,true);
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
