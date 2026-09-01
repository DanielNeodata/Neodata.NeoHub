<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Account_moves extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_account_moves";
			if($values["where"]==""){$values["where"]="move_year=".date("Y")." AND move_month=".date("m")." AND id_user_invoice=".$values["id_user_active"];}
			$pos=strpos($values["where"], "((id_user_invoice");
	        if($pos===true or $pos===0){
			    $id_user_active=$values["id_user_active"];
			} else {
				$pos=strpos($values["where"], "id_user_invoice=");
		        if($pos===false){
					$id_user_active="";
				} else {
				    $id_user_active=$values["id_user_active"];
				}
			}
            $values["order"]="created DESC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>array(
                    "conditions"=>array(
                           array("field"=>"id_clearing","operator"=>"==","value"=>""),
                        )
                    ),
                "delete"=>array(
                    "conditions"=>array(
                           array("field"=>"id_clearing","operator"=>"==","value"=>""),
                        )
                    ),
                "offline"=>false,
            );
			$closed="<span class='material-icons' style='color:darkred;'>lock</span>";
            $values["columns"]=array(
                array("field"=>"clearing","format"=>"text"),
                array("field"=>"month_to_end","format"=>"html"),
                array("field"=>"created","format"=>"date"),
                //array("field"=>"invoice_description","format"=>"type"),
                array("field"=>"cuit","format"=>"code"),
                array("field"=>"application_description","format"=>"type"),
                array("field"=>"user_invoice_description","format"=>"code"),
                array("field"=>"currency_iso","format"=>"warning"),
                array("field"=>"amount","format"=>"money"),
                //array("field"=>"iva","format"=>"money"),
                array("field"=>"total","format"=>"money"),
                array("field"=>"details","format"=>"more"),
                array("field"=>"","format"=>null),
				array("field"=>"btnFacturar","format"=>"html"),

            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("amount","iva","total")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_user", "operator"=>"=","fields"=>array("id_user_invoice")),
                array("name"=>"browser_id_type_currency", "operator"=>"=","fields"=>array("id_type_currency")),
                array("name"=>"browser_id_type_invoice", "operator"=>"=","fields"=>array("id_type_invoice")),
                array("name"=>"browser_id_type_iva", "operator"=>"=","fields"=>array("id_type_iva")),
                array("name"=>"browser_month", "operator"=>"=","fields"=>array("move_month")),
                array("name"=>"browser_year", "operator"=>"=","fields"=>array("move_year")),
            );
			
			$cboMonth=getComboMonths("browser_month","form-control",date("m"));
			$cboYear=getComboYears("browser_year","form-control","-10 year","+1 year",date("Y"));

            $values["controls"]=array(
                "<span class='badge badge-primary'>Año</span>".$cboYear,
                "<span class='badge badge-primary'>Mes</span>".$cboMonth,
                "<span class='badge badge-info'>Facturado por</span>".comboUsers($this,array("order"=>"username ASC","pagesize"=>-1,"where"=>"id_type_user=77", "id_actual"=>$id_user_active)),
                "<span class='badge badge-info'>Cliente</span>".comboApps($this),
                "<span class='badge badge-info'>Moneda</span>".comboTypeCurrencies($this),
                "<span class='badge badge-info'>Tipo</span>".comboTypeInvoices($this),
                "<span class='badge badge-info'>IVA</span>".comboTypeIvas($this,array("order"=>"amount ASC,description DESC","pagesize"=>-1))
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
			if(!isset($values["id"])){$values["id"]=0;}
		
		    $values["interface"]=(MOD_FINANCES."/account_moves/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
			$values["contracts"]=null;
			if ((int)$values["id"]!=0) {
				$CONTRACTS=$this->createModel(MOD_FINANCES,"Contracts","Contracts");
				$id_contract=secureComboPosition($values["records"],"id_contract");
				$values["contracts"]=$CONTRACTS->get(array("pagesize"=>-1,"where"=>"id=".$id_contract));
			}

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
            $parameters_id_user_discount=array(
                "model"=>(MOD_BACKEND."/users"),
                "table"=>"users",
                "name"=>"id_user_discount",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_user_discount"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
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
                "id_user_discount"=>getCombo($parameters_id_user_discount,$this),
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
            $id=(int)$values["id"];
			$id_type_currency=secureEmptyNull($values,"id_type_currency");
			if(!isset($values["description"])){$values["description"]="Movimiento de cuenta corriente normal";}
	        $CLEARINGS=$this->createModel(MOD_FINANCES,"Clearings","Clearings");
			$clearing=$CLEARINGS->get(array("order"=>"description ASC","pagesize"=>-1,"where"=>"id_type_currency=".$id_type_currency." AND clearing_year=".(int)$segments[0]." AND clearing_month=".(int)$segments[1]));
            if($id==0){
			    $created=secureEmptyNull($values,"created");
				$segments=explode("-", $created);
				if((int)$clearing["totalrecords"]!=0){throw new Exception(lang("error_6000"),6000);}
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
					'created' => $created,
                    'verified' => $this->now,
                    'offline' => null,
                    'fum' => $this->now,
					'id_application' => secureEmptyNull($values,"id_application"),
					'id_type_currency' => $id_type_currency,
					'id_type_invoice' => secureEmptyNull($values,"id_type_invoice"),
					'id_type_iva' => secureEmptyNull($values,"id_type_iva"),
                    'amount' => $values["amount"],
                    'iva' => $values["iva"],
                    'total' => $values["total"],
					'id_user_invoice' => secureEmptyNull($values,"id_user_invoice"),
					'id_user_discount' => secureEmptyNull($values,"id_user_discount"),
                    'invoice_number' => $values["invoice_number"],
                    'details' => $values["details"],
					'id_clearing' => null,
					'id_contract' => secureEmptyNull($values,"id_contract"),
                );
            } else {
				if((int)$clearing["totalrecords"]!=0 and $clearing["data"][0]["id"]!=$id){throw new Exception(lang("error_6000"),6000);}
                $fields = array(
                    'fum' => $this->now,
					'id_application' => secureEmptyNull($values,"id_application"),
					'id_type_currency' => secureEmptyNull($values,"id_type_currency"),
					'id_type_invoice' => secureEmptyNull($values,"id_type_invoice"),
					'id_type_iva' => secureEmptyNull($values,"id_type_iva"),
                    'amount' => $values["amount"],
                    'iva' => $values["iva"],
                    'total' => $values["total"],
					'id_user_invoice' => secureEmptyNull($values,"id_user_invoice"),
					'id_user_discount' => secureEmptyNull($values,"id_user_discount"),
                    'invoice_number' => $values["invoice_number"],
                    'details' => $values["details"],
                );
			}
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function form($values){
        try {
            $SERVERS=$this->createModel(MOD_INFRASTRUCTURE,"Servers","Servers");
            $SYSTEMS=$this->createModel(MOD_INFRASTRUCTURE,"Systems","Systems");
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $this->view="vw_nets";
            $values["order"]="application ASC, code ASC";
            $nets=$this->get($values);
			$i=0;
  			$x=0;
			foreach($nets["data"] as $net){
                $SERVERS->view="vw_servers";
                $servers=$SERVERS->get(array("fields"=>"*","where"=>"id_net=".$net["id"]));
    			$x=0;
                foreach($servers["data"] as $server){
	               $SYSTEMS->view="vw_systems";
                   $systems=$SYSTEMS->get(array("where"=>"id IN (SELECT id_system FROM ".MOD_INFRASTRUCTURE."_rel_systems_servers WHERE id_server=".$server["id"].")"));
				   $servers["data"][$x]["systems"]=$systems["data"];
		 		   $x+=1;
				}
				$nets["data"][$i]["servers"]=$servers["data"];
			    $i+=1;
            }
			$data["nets"]=$nets;
			
			$sql="SELECT count(id) as total, id_type_responsable,type_responsable,type_responsable_color FROM ".MOD_INFRASTRUCTURE."_vw_servers GROUP BY id_type_responsable,type_responsable,type_responsable_color";
			$byResponsable=$this->getRecordsAdHoc($sql);
			$data["byResponsable"]=$byResponsable;

			$sql="SELECT count(id) as total, id_type_exposure,type_exposure,type_exposure_color,id_type_responsable,type_responsable,id_application,application FROM ".MOD_INFRASTRUCTURE."_vw_systems GROUP BY id_type_exposure,type_exposure,type_exposure_color,id_type_responsable,type_responsable,id_application,application ORDER by application ASC, type_exposure";
			$byExposure=$this->getRecordsAdHoc($sql);
			$data["byExposure"]=$byExposure;

            $html=$this->load->view(MOD_INFRASTRUCTURE."/nets/form",$data,true);
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
	public function Facturar($values){
		$fields["facturado"]=date(FORMAT_DATE_DMY);
	    return parent::save($values,$fields);
	}
}
