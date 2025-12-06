<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Dolars extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $values["order"]="dolar_year DESC, dolar_month DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"dolar_year","format"=>"code"),
                array("field"=>"dolar_month","format"=>"code"),
                array("field"=>"amount","format"=>"money"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","amount")),
                array("name"=>"browser_month", "operator"=>"=","fields"=>array("dolar_month")),
                array("name"=>"browser_year", "operator"=>"=","fields"=>array("dolar_year")),
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
            $values["interface"]=(MOD_FINANCES."/dolars/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            $values["controls"]=array(
                "dolar_month"=>getComboMonths("dolar_month","form-control dbase validate",$values["records"]["data"][0]["dolar_month"]),
                "dolar_year"=>getComboYears("dolar_year","form-control dbase validate","-10 year","+1 year",$values["records"]["data"][0]["dolar_year"]),
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
		    $dolar=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"dolar_year=".$values["dolar_year"]." AND dolar_month=".$values["dolar_year"]));
            if($id==0){
				if((int)$dolar["totalrecords"]!=0){throw new Exception(lang("error_6001"),6001);}
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
					'created' => $this->now,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
                    'amount' => $values["amount"],
                    'dolar_year' => $values["dolar_year"],
                    'dolar_month' => $values["dolar_month"],
                );
            } else {
				if((int)$dolar["totalrecords"]!=0 and $dolar["data"][0]["id"]!=$id){throw new Exception(lang("error_6001"),6001);}
                $fields = array(
                    'fum' => $this->now,
                    'amount' => $values["amount"],
                    'dolar_year' => $values["dolar_year"],
                    'dolar_month' => $values["dolar_month"],
                );
			}
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
