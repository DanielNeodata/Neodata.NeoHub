<?php
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
defined('BASEPATH') OR exit('No direct script access allowed');
/*---------------------------------*/

class Api extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    /*Authentication*/
    public function authenticateFirebase(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            if (!isset($_POST["username"])) {throw new Exception(lang("error_5104"),5104);}
            if (!isset($_POST["uid_firebase"])) {throw new Exception(lang("error_5111"),5111);}
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'authenticateFirebase';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }

    /*Public information endpoints*/
    public function getExposed(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            if (!isset($_POST["id_app"])) {throw new Exception(lang("error_5110"),5110);}
            if (!isset($_POST["model"])) {throw new Exception(lang("error_5103"),5103);}
            $_POST['function'] = 'getExposed';
            switch($_POST["model"]) {
               case "applications":
                  $_POST['module'] = MOD_BACKEND;
                  break;
               case "currencies":
                  $_POST['module'] = MOD_BACKEND;
                  break;
               default:
                  throw new Exception(lang("error_5103"),5103);
            }
            $_POST['model'] = $_POST["model"];
            $_POST['table'] = $_POST["model"];
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
   
    /*Token generator functions*/
    public function generateTokenTransaction(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init("es-ar");
            $_POST['function'] = 'generateTokenTransaction';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    public function generateTokenPush(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            $_POST['function'] = 'generateTokenPush';
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
