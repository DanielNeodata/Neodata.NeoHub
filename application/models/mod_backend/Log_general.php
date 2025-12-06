<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Log_general extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_log_general";
            $values["order"]="created DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>false,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"created","format"=>"datetime"),
                array("field"=>"id_rel","format"=>"code"),
                array("field"=>"table_rel","format"=>"code"),
                array("field"=>"action","format"=>"code"),
                array("field"=>"username","format"=>"email"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("created","username","table_rel","action")),
                array("name"=>"browser_date_from", "operator"=>">=","fields"=>array("created")),
                array("name"=>"browser_date_to", "operator"=>"<=","fields"=>array("created")),
            );
            $values["controls"]=array(
                lang('p_date_from')." <input id='browser_date_from' name='browser_date_from' type='date' class='form-control'/>",
                lang('p_date_to')." <input id='browser_date_to' name='browser_date_to' type='date' class='form-control'/>",
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $this->view="vw_log_general";
            $values["interface"]=(MOD_BACKEND."/log_general/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            $values["readonly"]=true;
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function save($values,$fields=null){
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
               return parent::save($values,$fields);
            } else {
               throw new Exception(lang('error_9999'),9999);
            }
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
