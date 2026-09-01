<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Contracts extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
		    $id_user_active=$values["id_user_active"];
            $this->view="vw_contracts";
			if (!isset($values["where"])){$values["where"]="";}
			if($values["where"]!=""){$values["where"].=" AND ";}
			$values["where"].=" visible=1 ";
            $values["order"]="date_from DESC, date_to DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"month_to_end","format"=>"html"),
                array("field"=>"description","format"=>"text"),
                array("field"=>"date_from","format"=>"date"),
                array("field"=>"date_to","format"=>"date"),
                array("field"=>"user_invoice_description","format"=>"type"),
                array("field"=>"cuit","format"=>"code"),
                array("field"=>"application_description","format"=>"type"),
                array("field"=>"currency_iso","format"=>"text"),
                array("field"=>"monthly","format"=>"money"),
                array("field"=>"details","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","amount")),
                array("name"=>"browser_date_from", "operator"=>">=","fields"=>array("date_from")),
                array("name"=>"browser_date_to", "operator"=>"<=","fields"=>array("date_to")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_user", "operator"=>"=","fields"=>array("id_user_invoice")),
            );
            $values["controls"]=array(
                "<span class='badge badge-info'>Facturado por</span>".comboUsers($this,array("order"=>"username ASC","pagesize"=>-1,"where"=>"id_type_user=77", "id_actual"=>$id_user_active)),
                "<span class='badge badge-info'>Cliente</span>".comboApps($this),
                  "<span class='badge badge-info'>".lang('p_date_from')."</span> <input id='browser_date_from' name='browser_date_from' type='date' class='form-control'/>",
                  "<span class='badge badge-info'>".lang('p_date_to')."</span> <input id='browser_date_to' name='browser_date_to' type='date' class='form-control'/>",
            );
            $values["conditionalBackground"]=array(
                array("field"=>"revisarMes","value"=>"1","color"=>"orange"),
            );

            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_FINANCES."/contracts/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters_id_application=array(
                "model"=>(MOD_BACKEND."/applications"),
                "table"=>"applications",
                "name"=>"id_application",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_application"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_user_invoice=array(
                "model"=>(MOD_BACKEND."/users"),
                "table"=>"users",
                "name"=>"id_user_invoice",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_user_invoice"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_user=77"),
            );
            $parameters_id_type_currency=array(
                "model"=>(MOD_FINANCES."/Type_currencies"),
                "table"=>"Type_currencies",
                "name"=>"id_type_currency",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_currency"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_invoice=array(
                "model"=>(MOD_FINANCES."/Type_invoices"),
                "table"=>"Type_invoices",
                "name"=>"id_type_invoice",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_invoice"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_iva=array(
                "model"=>(MOD_FINANCES."/Type_ivas"),
                "table"=>"Type_ivas",
                "name"=>"id_type_iva",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_iva"),
                "id_field"=>"id",
                "description_field"=>"description",
				"data"=>"amount",
		        "get"=>array("order"=>"amount ASC,description DESC","pagesize"=>-1),
            );

            $values["controls"]=array(
                "id_application"=>getCombo($parameters_id_application,$this),
                "id_user_invoice"=>getCombo($parameters_id_user_invoice,$this),
                "id_type_currency"=>getCombo($parameters_id_type_currency,$this),
                "id_type_invoice"=>getCombo($parameters_id_type_invoice,$this),
                "id_type_iva"=>getCombo($parameters_id_type_iva,$this),
            );

            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function save($values,$fields=null){
        try {
		    $bNew=false;
            $id=(int)$values["id"];
			$monthly=(float)$values["monthly"];
			$id_type_iva=secureEmptyNull($values,"id_type_iva");
			$id_application=secureEmptyNull($values,"id_application");
			$id_user_invoice=secureEmptyNull($values,"id_user_invoice");
			$id_type_currency=secureEmptyNull($values,"id_type_currency");
			$id_type_invoice=secureEmptyNull($values,"id_type_invoice");
			$date_from=secureEmptyNull($values,"date_from");
            $date_to=secureEmptyNull($values,"date_to");
			$details=$values["details"];
            if($id==0){
				$bNew=true;
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
					'created' => $this->now,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
					'id_application' => $id_application,
					'id_user_invoice' => $id_user_invoice,
					'id_type_currency' => $id_type_currency,
					'id_type_invoice' => $id_type_invoice,
					'id_type_iva' => $id_type_iva,
					'details' => $details,
                    'monthly' => $monthly,
					'link_doc' => $values["link_doc"],
					'revisarMes' => $values["revisarMes"]
                );
			} else {
                $fields = array(
                    'description' => $values["description"],
                    'fum' => $this->now,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
					'id_application' => $id_application,
					'id_user_invoice' => $id_user_invoice,
					'id_type_currency' => $id_type_currency,
					'id_type_invoice' => $id_type_invoice,
					'id_type_iva' => $id_type_iva,
					'details' => $details,
                    'monthly' => $monthly,
					'link_doc' => $values["link_doc"],
					'revisarMes' => $values["revisarMes"]
                );
			}
            $saved=parent::save($values,$fields);
            if($saved["status"]=="OK"){
				$id=$saved["data"]["id"];
				$TYPE_IVAS=$this->createModel(MOD_FINANCES,"Type_ivas","Type_ivas");
				$ACCOUNT_MOVES=$this->createModel(MOD_FINANCES,"Account_moves","Account_moves");
				$CLEARINGS=$this->createModel(MOD_FINANCES,"Clearings","Clearings");

				$type_ivas=$TYPE_IVAS->get(array("where"=>"id=".$id_type_iva));
				$iva=($monthly*((float)$type_ivas["data"][0]["amount"]/100));
				$total=($monthly+$iva);
				$ACCOUNT_MOVES->deleteByWhere("id_contract=".$id." AND id_clearing IS null");
				//if ($bNew) {$ACCOUNT_MOVES->deleteByWhere("id_application=".$id_application." AND id_user_invoice=".$id_user_invoice." AND id_type_currency=".$id_type_currency." AND id_type_invoice=".$id_type_invoice." AND id_clearing IS null");}
				$params = array(
                    'id' => 0,
                    'description' => 'Movimiento de cuenta corriente automático por contrato',
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
					'id_application' => $id_application,
					'id_type_currency' => $id_type_currency,
					'id_type_invoice' => $id_type_invoice,
					'id_type_iva' => $id_type_iva,
                    'amount' => $monthly,
                    'iva' => $iva,
                    'total' => $total,
					'id_user_invoice' => $id_user_invoice,
                    'details' => $details,
					'id_clearing' => null,
					'id_contract' => $id,
                );
				/*N saves! 1 by month!*/
				$items=monthsBetween($date_from,$date_to);
				$vFrom = explode('-', $date_from);
				$year=(int)$vFrom[0];
				$month=(int)$vFrom[1];
				for($i=0;$i<=$items;$i++){
				    if ($i>0){$month=((int)$month+1);}
					if ($month>12){$month=1;$year=($year+1);}
					if($month<10){$month=("0".(string)$month);}
					$created=($year."-".$month."-01");
					$params["created"]=$created;
					$ret=$CLEARINGS->get(array("where"=>"clearing_year=".$year." AND clearing_month=".$month));
					if ((int)$ret["totalrecords"]==0) {$ACCOUNT_MOVES->save($params,null);}
				}
			}
			return $saved;
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function delete($values){
        try {
		    $id=$values["id"];
            $deleted=parent::delete($values);
            if($deleted["status"]=="OK"){
				$ACCOUNT_MOVES=$this->createModel(MOD_FINANCES,"Account_moves","Account_moves");
				$ACCOUNT_MOVES->deleteByWhere("id_contract=".$id." AND id_clearing IS null");
				$ACCOUNT_MOVES->save(array("id"=>$id),array("id_contract"=>null));
            }
            return $deleted;
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
}
