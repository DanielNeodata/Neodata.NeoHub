<?php
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
defined('BASEPATH') OR exit('No direct script access allowed');
/*---------------------------------*/

class Backend extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        $this->status=$this->init();
		$page="";
		if($_SERVER['SERVER_NAME']=="trace.gruponeodata.com"){
			$data["title"] = TITLE_TRACE;
			$data["title_page"] = TITLE_PAGE_TRACE;
			$page="trace";
		} else {
			$data["title"] = TITLE_GENERAL;
			$data["title_page"] = TITLE_PAGE;
			$page="login";
		}
        $data["status"] = $this->status;
        $data["language"] = $this->language;
        $data["header"] = $this->load->view('common/_header',$data, true);
        $data["footer"] = $this->load->view('common/_footer',$data, true);
        try {
            if (!$this->ready){throw new Exception(lang("error_5002"),5002);}
            $this->load->view($page,$data);
        }
        catch (Exception $e){
            $data["code"]=$e->getCode();
            $data["message"]=$e->getMessage();
            $data["title"] = $e->getCode();
            $this->load->view('common/_error',$data);
        }
	}
    public function trace()
	{
        $this->status=$this->init();
        $data["title"] = TITLE_TRACE;
        $data["title_page"] = TITLE_PAGE_TRACE;
        $data["status"] = $this->status;
        $data["language"] = $this->language;
        $data["header"] = $this->load->view('common/_header',$data, true);
        $data["footer"] = $this->load->view('common/_footer',$data, true);
        try {
            if (!$this->ready){throw new Exception(lang("error_5002"),5002);}
            $this->load->view('trace',$data);
        }
        catch (Exception $e){
            $data["code"]=$e->getCode();
            $data["message"]=$e->getMessage();
            $data["title"] = $e->getCode();
            $this->load->view('common/_error',$data);
        }
	}

    public function profile(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'profile';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    public function stateLinkAPI(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'stateLinkAPI';
            $_POST['module'] = MOD_API;
            $_POST['model'] = 'neo_authentication';
            $_POST['table'] = 'neo_authentication';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    public function Facturar(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'Facturar';
            $_POST['module'] = MOD_FINANCES;
            $_POST['model'] = 'Account_moves';
            $_POST['table'] = 'Account_moves';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }

	
    public function logout(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $this->status=$this->init();
            $_POST['mode'] = bin2hex(getEncryptionKey()); /*Avoid authentication check*/
            $_POST['function'] = 'logout';
            $_POST['module'] = MOD_BACKEND;
            $_POST['model'] = 'users';
            $_POST['table'] = 'users';
            $this->neocommand(true);
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    public function logged(){
        try {
            $raw=$this->rawInput();
            if ($raw!=null)  {throw new Exception($raw);}
            $FUNCTIONS=$this->createModel(MOD_BACKEND,"Functions","Functions");
            $menu=$FUNCTIONS->menuTree($_POST);
			if($_SERVER['SERVER_NAME']=="trace.gruponeodata.com"){
	            $data["title"] = TITLE_GENERAL_TRACE;
			} else {
	            $data["title"] = TITLE_GENERAL;
			}
            $data["language"] = $this->language;
            $data["menu"] = $menu["data"];
            $html=$this->load->view("logged",$data,true);
            $return=array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
            $this->output($return);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data
            );
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
