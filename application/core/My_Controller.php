<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class MY_Controller extends CI_Controller {
    public $legacy = false;

    public $ready = false;
    public $status = null;
    public $language = DEFAULT_LANGUAGE;
    public $parameters = array();
    public $psession=null;
    public $profile=null;

    public function __construct() {
        parent::__construct();
    }

    public function init($lang=null){
        try {
            if ($lang!=null){$this->language=$lang;}
            $this->ready = true;
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                );
        }
        catch(Exception $e) {
            $this->ready = false;
            return logError($e,__METHOD__ );
        }
    }
    public function createModel($module,$model,$table) {
        try {
            $this->load->model($module."/".$model,$model, true);
            $this->{$model}->status=$this->{$model}->init($module."/".$model,$table,$this->language);
            if ($this->{$model}->status["status"]!="OK"){throw new Exception($this->{$model}->status["message"],(int)$this->{$model}->status["code"]);}
            return $this->{$model};
        }
        catch(Exception $e) {
            return null;
        }
    }
    
    public function neocommand($forced=false){
        try {
            //$this->load->library("session");
            //$this->psession=$this->session->userdata;

            if ($this->legacy) {throw new Exception(lang("error_legacy"),-1);}
            if(!$forced){
                $raw=$this->rawInput();
                if ($raw!=null)  {throw new Exception($raw);}
                $this->status=$this->init();
            }
			if (!isset($_POST["function"])) {throw new Exception(lang("error_5100"),5100);}
            if (!isset($_POST["module"])) {throw new Exception(lang("error_5101"),5101);}
            if (!isset($_POST["table"])) {throw new Exception(lang("error_5102"),5102);}
            if (!isset($_POST["model"])) {throw new Exception(lang("error_5103"),5103);}
            if (!isset($_POST["exit"])) {$_POST["exit"]="output";}
            $_POST["check_token"]=true;
            switch($_POST["model"]){
                case "api_specs": //Exception model NOT uses authentication
                case "external": //Exception model NOT uses authentication
                   $_POST["check_token"]=false;
                   break;
                default:
                   if (isset($_POST["mode"])) {
                       if ($_POST["mode"]==bin2hex(getEncryptionKey())) {$_POST["check_token"]=false;}
                   }
                   break;
            }
            /*-----------------------------------
             | Break point for $_POST manipulation
             -----------------------------------*/
            $this->parameters=$_POST;
            /*-----------------------------------*/
            if ($_POST["check_token"]) {
                if (!isset($_POST["id_user_active"]) or $_POST["id_user_active"]=="") {throw new Exception(lang("error_5107"),5107);}
                if (!isset($_POST["token_authentication"]) or $_POST["token_authentication"]=="") {throw new Exception(lang("error_5109"),5109);}
                $USERS=$this->createModel(MOD_BACKEND,"Users","Users");
                $verify=$USERS->verifyTokenAuthentication($this->parameters);
                if($verify["status"]!="OK"){throw new Exception($verify["message"],(int)$verify["code"]);}
            }
            $return=$this->InnerResolver();
            $this->{$_POST["exit"]}($return);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }

    public function rawInput(){
        try {
            $str=trim(file_get_contents("php://input"));
            parse_str($str, $parsed);
            $str=json_encode($parsed);
            if (!$_POST) {$_POST = json_decode($str,true);}
            return null;
        }
        catch(Exception $e) {
            return $e;
        }
    }
    public function InnerResolver(){
        try {
            $ACTIVE=$this->createModel($this->parameters["module"],$this->parameters["model"],$this->parameters["model"]);
            return $ACTIVE->{$this->parameters["function"]}($this->parameters);
        }
        catch(Exception $e){
            return logError($e,__METHOD__." model: ".$this->parameters["model"]);
        }
    }
    public function output($return){
        $this->output
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method')
            ->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE')
            ->set_content_type('application/json','utf-8')
            ->set_output(json_encode($return));
    }
    public function download($return){
        $this->load->helper('download');
        $this->load->helper('file');
        $raw=file_get_contents($return["message"]);
        switch($return["mode"]) {
           case "view":
              $this->output
                  ->set_status_header(200)
                  ->set_content_type(get_mime_by_extension($return["message"]))
                  ->set_output($raw)
                  ->_display();
                  break;
           case "download":
              force_download(basename($return["message"]), $raw);
              break;
        }
    }

        /*Authentication*/
    public function authenticate(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            if (!isset($_POST["username"])) {throw new Exception(lang("error_5104"),5104);}
            if (!isset($_POST["password"])) {throw new Exception(lang("error_5105"),5105);}
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'authenticate';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    public function reAuthenticate(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            if (!isset($_POST["id_user_active"]) or $_POST["id_user_active"]=="") {throw new Exception(lang("error_5107"),5107);}
            if (!isset($_POST["token_authentication"]) or $_POST["token_authentication"]=="") {throw new Exception(lang("error_5109"),5109);}
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'reAuthenticate';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
}
