<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Adjusts extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $values["order"]="adjust_year DESC, adjust_month DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"adjust_year","format"=>"code"),
                array("field"=>"adjust_month","format"=>"code"),
                array("forcedlabel"=>"ipc","field"=>"amount","format"=>"percent"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","amount")),
                array("name"=>"browser_month", "operator"=>"=","fields"=>array("adjust_month")),
                array("name"=>"browser_year", "operator"=>"=","fields"=>array("adjust_year")),
            );
			
			$cboMonth=getComboMonths("browser_month","form-control");
			$cboYear=getComboYears("browser_year","form-control","-10 year","+1 year");

            $values["controls"]=array(
                "<span class='badge badge-primary'>Año</span>".$cboYear,
                "<span class='badge badge-primary'>Mes</span>".$cboMonth,
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_FINANCES."/adjusts/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            $values["controls"]=array(
                "adjust_month"=>getComboMonths("adjust_month","form-control dbase validate",$values["records"]["data"][0]["adjust_month"]),
                "adjust_year"=>getComboYears("adjust_year","form-control dbase validate","-10 year","+1 year",$values["records"]["data"][0]["adjust_year"]),
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
			if(!isset($values["description"])){$values["description"]="Ajuste mensual IPC";}
		    $adjust=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"adjust_year=".$values["adjust_year"]." AND adjust_month=".$values["adjust_year"]));
            if($id==0){
				if((int)$adjust["totalrecords"]!=0){throw new Exception(lang("error_6001"),6001);}
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
					'created' => $this->now,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
                    'amount' => $values["amount"],
                    'adjust_year' => $values["adjust_year"],
                    'adjust_month' => $values["adjust_month"],
                );
            } else {
				if((int)$adjust["totalrecords"]!=0 and $adjust["data"][0]["id"]!=$id){throw new Exception(lang("error_6001"),6001);}
                $fields = array(
                    'fum' => $this->now,
                    'amount' => $values["amount"],
                    'adjust_year' => $values["adjust_year"],
                    'adjust_month' => $values["adjust_month"],
                );
			}
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
