<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Clearings extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function form($values){
        try {
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $data["cboMonth"]=getComboMonths("browser_month","form-control browser_month");
            $data["cboYear"]=getComboYears("browser_year","form-control browser_year","-10 year","+1 year");
			$data["cboCurrency"]=comboTypeCurrencies($this);
            $html=$this->load->view(MOD_FINANCES."/clearings/form",$data,true);
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
    public function statics($values){
        try {
            $data["parameters"] = $values;
            $data["cboMonthFrom"]=getComboMonths("browser_month_from","form-control browser_month_from");
            $data["cboYearFrom"]=getComboYears("browser_year_from","form-control browser_year_from","-10 year","+1 year");
            $data["cboMonthTo"]=getComboMonths("browser_month_to","form-control browser_month_to");
            $data["cboYearTo"]=getComboYears("browser_year_to","form-control browser_year_to","-10 year","+1 year");
            $data["cboApplication"]=comboApps($this);

            $html=$this->load->view(MOD_FINANCES."/clearings/statics",$data,true);
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
    public function save($values,$fields=null){
        try {
            $id=(int)$values["id"];
            if($id==0){
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
					'created' => secureEmptyNull($values,"created"),
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
                    'clearing_year' => $values["clearing_year"],
                    'clearing_month' => $values["clearing_month"],
					'static'=>json_encode($values["static"]),
					'id_type_currency'=>$values["id_type_currency"],
                );
			}
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function closeClearing($values){
        try {
		    $clearing=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND clearing_year=".$values["clearing_year"]." AND clearing_month=".$values["clearing_month"]));
			if ((int)$clearing["totalrecords"]==0){
			    $values["id"]=0;
			    $values["code"]=opensslRandom(16);
				$values["description"]="Liquidación mensual";
			    $saved=$this->save($values,null);    
			    $clearing=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND clearing_year=".$values["clearing_year"]." AND clearing_month=".$values["clearing_month"]));
			}

            $ACCOUNT_MOVES=$this->createModel(MOD_FINANCES,"Account_moves","Account_moves");
            $fields=array("id_clearing"=>$clearing["data"][0]["id"]);
            $ACCOUNT_MOVES->updateByWhere($fields,"YEAR(created)=".$values["clearing_year"]." AND MONTH(created)=".$values["clearing_month"]);

            $REL_USERS_CLEARINGS_AMOUNTS=$this->createModel(MOD_FINANCES,"Rel_users_clearings_amounts","Rel_users_clearings_amounts");
			
			foreach($values["static"]["amounts"] as $item){
		        $corresponde=((float)$values["static"]["grandAmount"]*((float)$item["sharing"]/100));
				$difference=((float)$item["amount"]-$corresponde);
				$excedente=0;
				$faltante=0;
				if($difference>0){$excedente=$difference;}else{$faltante=$difference;}
				$fields = array(
					'id_user' => $item["id"],
					'id_clearing' => $clearing["data"][0]["id"],
					'sharing' => $item["sharing"],
					'amount' => $item["amount"],
					'iva' => $item["iva"],
					'total' => $item["total"],
					'corresponde' => $corresponde,
					'excedente' => $excedente,
					'faltante' => $faltante,
					'id_type_currency'=>$values["id_type_currency"]
				);
				$REL_USERS_CLEARINGS_AMOUNTS->save(array("id"=>0),$fields);
			}

            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function getClearing($values){
        try {
		    $clearing=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND clearing_year=".$values["year"]." AND clearing_month=".$values["month"]));
            $USERS=$this->createModel(MOD_BACKEND,"Users","Users");
			$images=$USERS->get(array("order"=>"description ASC","pagesize"=>-1,"fields"=>"id, image"));
            $ACCOUNT_MOVES=$this->createModel(MOD_FINANCES,"Account_moves","Account_moves");
			$ACCOUNT_MOVES->view="vw_account_moves";
			$moves=$ACCOUNT_MOVES->get(array("order"=>"user_invoice_description ASC,application_description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND move_year=".$values["year"]." AND move_month=".$values["month"]));

			$sql="SELECT sum(amount) as total FROM ".MOD_FINANCES."_vw_account_moves WHERE id_type_currency=".$values["id_type_currency"]." AND id_user_discount IS null AND move_year=".$values["year"]." AND move_month=".$values["month"];
			$grandAmount=$this->getRecordsAdHoc($sql);

			$sql="SELECT sum(amount) as amount,sum(iva) as iva, sum(total) as total, id_user_invoice as id,user_invoice_sharing as sharing,user_invoice_description as person,id_type_currency FROM ".MOD_FINANCES."_vw_account_moves WHERE id_type_currency=".$values["id_type_currency"]." AND id_user_discount IS null AND move_year=".$values["year"]." AND move_month=".$values["month"]." GROUP BY id_user_invoice, user_invoice_sharing,user_invoice_description, id_type_currency";
			$amounts=$this->getRecordsAdHoc($sql);

			$sql="SELECT sum(amount) as amount, id_user_invoice as id,user_invoice_description, id_user_discount as id_discount,user_discount_description as person,id_type_currency FROM ".MOD_FINANCES."_vw_account_moves WHERE id_type_currency=".$values["id_type_currency"]." AND id_user_discount IS NOT null AND move_year=".$values["year"]." AND move_month=".$values["month"]." GROUP BY id_user_invoice,user_invoice_description, id_user_discount,user_discount_description,id_type_currency";
			$discounts=$this->getRecordsAdHoc($sql);

			$open=1;
			if ((int)$clearing["totalrecords"]!=0){$open=0;}
            return array(
                "code"=>"2000",
				"open"=>$open,
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$moves,
				"amounts"=>$amounts,
				"discounts"=>$discounts,
				"clearing"=>$clearing,
				"grandAmount"=>$grandAmount[0]["total"],
                "images"=>$images,
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function getClearingSigns($values){
        try {
		    $clearing=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND clearing_year=".$values["year"]." AND clearing_month=".$values["month"]));
			$signs=[];
			if ((int)$clearing["totalrecords"]!=0){
				$sql="SELECT * FROM ".MOD_FINANCES."_rel_users_clearings WHERE id_clearing=".$clearing["data"][0]["id"];
				$signs=$this->getRecordsAdHoc($sql);
			}
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$signs,
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function signClearing($values){
        try {
			$values["id"]=0;
		    $clearing=$this->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$values["id_type_currency"]." AND clearing_year=".$values["clearing_year"]." AND clearing_month=".$values["clearing_month"]));
			if ((int)$clearing["totalrecords"]!=0){
                $REL_USERS_CLEARINGS=$this->createModel(MOD_FINANCES,"Rel_users_clearings","Rel_users_clearings");
				$REL_USERS_CLEARINGS->save($values,array("id_clearing"=>$clearing["data"][0]["id"]));
			}
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function getStatics($values){
        try {
		    switch($values["report"]) {
			   case "facturacion":
			      $this->getRecordsAdHoc("EXEC sp_Hours_Estimated 2008,310,0.015;");
			      $this->getRecordsAdHoc("EXEC sp_Dolars_Estimated;");

  				  $sql="SELECT sum(amount_solo_dolar) as amount_solo_dolar,sum(amount_pesos_dolar) as amount_pesos_dolar,sum(amount_dolar) as amount_dolar,[hours],move_month,move_year ";
				  $sql.=" FROM ".MOD_FINANCES."_vw_account_moves WHERE ";
				  $sql.=" id_user_discount IS null AND amount>0 AND move_year>=".$values["year_from"]." AND move_year<=".$values["year_to"];
				  if ($values["open"]!="S"){$sql.=" AND id_clearing IS NOT null";}
				  if ($values["id_application"]!=""){$sql.=" AND id_application=".$values["id_application"];}
				  $sql.=" GROUP BY [hours],move_month,move_year ORDER BY move_year ASC, move_month ASC ";
				  $consolidado=$this->getRecordsAdHoc($sql);

  				  $sql="SELECT sum(amount_solo_dolar) as amount_solo_dolar,sum(amount_solo_pesos) as amount_solo_pesos, sum(amount_pesos) as amount_pesos, sum(amount_dolar) as amount_dolar,sum(amount) as amount,sum(iva) as iva,sum(total) as total,move_month,move_year ";
				  $sql.=" FROM ".MOD_FINANCES."_vw_account_moves WHERE ";
				  $sql.=" id_user_discount IS null AND amount>0 AND move_year>=".$values["year_from"]." AND move_year<=".$values["year_to"];
				  if ($values["open"]!="S"){$sql.=" AND id_clearing IS NOT null";}
				  if ($values["id_application"]!=""){$sql.=" AND id_application=".$values["id_application"];}
				  $sql.=" GROUP BY move_month,move_year ORDER BY move_year ASC, move_month ASC ";
				  $statics=$this->getRecordsAdHoc($sql);

  				  $sql="SELECT sum(amount) as amount, move_month,move_year,id_type_currency ";
				  $sql.=" FROM ".MOD_FINANCES."_vw_account_moves WHERE ";
				  $sql.=" id_type_currency=".$values["id_type_currency"]." AND id_user_discount IS null AND amount<0 AND move_year>=".$values["year_from"]." AND move_year<=".$values["year_to"];
				  if ($values["open"]!="S"){$sql.=" AND id_clearing IS NOT null";}
				  if ($values["id_application"]!=""){$sql.=" AND id_application=".$values["id_application"];}
				  $sql.=" GROUP BY move_month,move_year,id_type_currency ORDER BY move_year ASC, move_month ASC ";
				  $data2=$this->getRecordsAdHoc($sql);

  				  $sql="SELECT amount, adjust_month,adjust_year ";
				  $sql.=" FROM ".MOD_FINANCES."_adjusts WHERE ";
				  $sql.=" adjust_year>=".((int)$values["year_from"]-1)." AND adjust_year<=".((int)$values["year_to"]-1);
				  $sql.=" ORDER BY adjust_year ASC, adjust_month ASC ";
				  $adjusts=$this->getRecordsAdHoc($sql);

  				  $sql="SELECT amount, dolar_month,dolar_year ";
				  $sql.=" FROM ".MOD_FINANCES."_dolars WHERE ";
				  $sql.=" dolar_year>=".$values["year_from"]." AND dolar_year<=".$values["year_to"];
				  $sql.=" ORDER BY dolar_year ASC, dolar_month ASC ";
				  $dolars=$this->getRecordsAdHoc($sql);

				  //$statics["gastos"]=$gastos["data"];
			      break;
			}
			return array(
                "code"=>"2000",
                "status"=>"OK",
				"data"=>$statics,
				"data2"=>$data2,
				"adjusts"=>$adjusts,
				"dolars"=>$dolars,
				"consolidado"=>$consolidado,
				"report"=>$values["report"],
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "compressed"=>false
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

}
