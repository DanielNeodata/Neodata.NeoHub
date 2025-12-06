<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Tickets extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function brow($values){
        try {
            $this->view="vw_tickets";
			if($values["where"]==""){$values["where"]="id_user_assigned=".$values["id_user_active"];}
			$pos=strpos($values["where"], "((id_user_assigned");
	        if($pos===true or $pos===0){
			    $id_user_active=$values["id_user_active"];
			} else {
				$pos=strpos($values["where"], "id_user_assigned=");
		        if($pos===false){
					$id_user_active="";
				} else {
				    $id_user_active=$values["id_user_active"];
				}
			}

            if ($values["where"]!=""){$values["where"].=" AND ";}
	        $pos=strpos($values["where"], "((id_type_status = '3'))");
			if($pos===false){$pos=strpos($values["where"], "((id_type_status = '8'))");}
	        if($pos===false){$values["where"].="id_type_status not in (3,8)";}else{$values["where"].="1=1";}

            if ($values["where"]!=""){$values["where"].=" AND ";}
	        $pos=(strpos($values["where"], "((id_type_ticket = '7'))"));
			if ($pos===false){$pos=(strpos($values["where"], "((id_type_ticket = '8'))"));}
			if ($pos===false){$pos=(strpos($values["where"], "((id_type_ticket = '9'))"));}
	        if($pos===false){$values["where"].="id_type_ticket not in (7,8,9)";}else{$values["where"].="1=1";}

            $values["order"]="id_type_priority ASC, description ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>true,
            );
            $values["columns"]=array(
                //array("field"=>"id","format"=>"number"),
                array("field"=>"priority","format"=>"code"),
                array("field"=>"description","format"=>"text"),
                array("field"=>"application","format"=>"danger"),
                array("field"=>"system","format"=>"warning"),
                array("field"=>"type_ticket","format"=>"type"),
                array("field"=>"type_status","format"=>"type"),
                array("field"=>"username_assigned","format"=>"email"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("code","description","created")),
                array("name"=>"browser_id_type_priority", "operator"=>"=","fields"=>array("id_type_priority")),
                array("name"=>"browser_id_user", "operator"=>"=","fields"=>array("id_user_assigned")),
                array("name"=>"browser_id_app", "operator"=>"=","fields"=>array("id_application")),
                array("name"=>"browser_id_system", "operator"=>"=","fields"=>array("id_system")),
                array("name"=>"browser_id_type_ticket", "operator"=>"=","fields"=>array("id_type_ticket")),
                array("name"=>"browser_id_type_status", "operator"=>"=","fields"=>array("id_type_status")),
            );
            $values["controls"]=array(
                "<span class='badge badge-warning'>Prioridad</span>".comboTypePriority($this),
                "<span class='badge badge-info'>Usuario</span>".comboUsers($this,array("order"=>"username ASC","pagesize"=>-1,"id_actual"=>$id_user_active)),
                "<span class='badge badge-info'>Aplicación</span>".comboApps($this),
                "<span class='badge badge-info'>Sistemas</span>".comboSystems($this),
                "<span class='badge badge-info'>Tipo</span>".comboTypeTickets($this),
                "<span class='badge badge-info'>Status</span>".comboTypeTicketsStatus($this),
                "<span class='badge badge-info'>Base de trabajo</span>".comboTypeBaseWorks($this),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function edit($values){
        try {
            $values["interface"]=(MOD_SUPPORT."/tickets/abm");
            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            $parameters_id_user_assigned=array(
                "model"=>(MOD_BACKEND."/users"),
                "table"=>"users",
                "name"=>"id_user_assigned",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_user_assigned"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_application=array(
                "model"=>(MOD_BACKEND."/applications"),
                "table"=>"applications",
                "name"=>"id_type_application",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_application"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_priority=array(
                "model"=>(MOD_SUPPORT."/type_priority"),
                "table"=>"type_priority",
                "name"=>"id_type_priority",
                "class"=>"form-control dbase validate no-z",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_priority"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_status=array(
                "model"=>(MOD_SUPPORT."/type_status"),
                "table"=>"type_status",
                "name"=>"id_type_status",
                "class"=>"form-control dbase validate no-z",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_status"),
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_ticket=array(
                "model"=>(MOD_SUPPORT."/type_tickets"),
                "table"=>"type_tickets",
                "name"=>"id_type_ticket",
                "class"=>"form-control dbase validate",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_ticket"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_base_work=array(
                "model"=>(MOD_SUPPORT."/type_base_works"),
                "table"=>"type_base_works",
                "name"=>"id_type_base_work",
                "class"=>"form-control dbase no-z",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_type_base_work"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_net=array(
                "model"=>(MOD_INFRASTRUCTURE."/nets"),
                "table"=>"nets",
                "name"=>"id_net",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_net"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_server=array(
                "model"=>(MOD_INFRASTRUCTURE."/servers"),
                "table"=>"servers",
                "name"=>"id_server",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_server"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_system=array(
                "model"=>(MOD_INFRASTRUCTURE."/systems"),
                "table"=>"systems",
                "name"=>"id_system",
                "class"=>"form-control dbase no-z",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_system"),
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );

            $values["controls"]=array(
                "id_user_assigned"=>getCombo($parameters_id_user_assigned,$this),
                "id_type_priority"=>getCombo($parameters_id_type_priority,$this),
                "id_type_application"=>getCombo($parameters_id_application,$this),
                "id_type_status"=>getCombo($parameters_id_type_status,$this),
                "id_type_ticket"=>getCombo($parameters_id_type_ticket,$this),
                "id_type_base_work"=>getCombo($parameters_id_type_base_work,$this),
                "id_net"=>getCombo($parameters_id_net,$this),
                "id_server"=>getCombo($parameters_id_server,$this),
                "id_system"=>getCombo($parameters_id_system,$this),
            );
            $opts=array(
                "module"=>MOD_BACKEND,
                "model"=>"files_attached",
                "view"=>"files_attached",
                "where"=>"table_rel='".MOD_SUPPORT."_tickets' AND id_rel=".$values["id"]
            );
			$values["attached_files"] = parent::getAttachments($values,$opts);
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        try {
		    $new=false;
		    $close=false;
            $id=(int)$values["id"];
			$id_type_status=(int)secureEmptyNull($values,"id_type_status");
			$id_type_priority=secureEmptyNull($values,"id_type_priority");
			$id_type_ticket=secureEmptyNull($values,"id_type_ticket");
			$id_type_base_work=secureEmptyNull($values,"id_type_base_work");
            $hours_work=$values["hours_work"];
            $percent_work=$values["percent_work"];

			switch ((int)$id_type_ticket) {
				case 8: //z-registro
				    $hours_work=0;
					$id_type_status=2;
				    $id_type_priority=3;
					$id_type_base_work=4;
					break;
				default:
				    $percent_work=0;
					break;
			}

            if($id==0){
			    $new=true;
                $fields = array(
                    'code' => opensslRandom(16),
                    'description' => $values["description"],
                    'created' => $this->now,
                    'verified' => $this->now,
                    'fum' => $this->now,
                    'sinopsys' => $values["sinopsys"],
                    'hours_work' => secureEmptyNull($values,"hours_work"),
                    'percent_work' => secureEmptyNull($values,"percent_work"),
					'id_type_base_work' => $id_type_base_work,
					'id_type_ticket' => $id_type_ticket,
					'id_type_status' => $id_type_status,
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_user_creator' => secureEmptyNull($values,"id_user_active"),
					'id_user_assigned' => secureEmptyNull($values,"id_user_assigned"),
					'date_from' => secureEmptyNull($values,"date_from"),
					'date_to' => secureEmptyNull($values,"date_to"),
					'id_system' => secureEmptyNull($values,"id_system"),
					'id_type_priority' => $id_type_priority,
                );
            } else {
			    $last_id_type_status=(int)$this->getField("id_type_status",$id);
				if ((int)$last_id_type_status!=(int)$id_type_status) {
					switch ((int)$id_type_status) {
					   case 3://cerrado
						  $date_to=$this->now;
						  $close=true;
						  break;
					    default:
						  $date_to=null;
						  break;
					}
				} else {
					$date_to=secureEmptyNull($values,"date_to");
				}
                $fields = array(
                    'description' => $values["description"],
                    'fum' => $this->now,
                    'sinopsys' => $values["sinopsys"],
					'id_type_ticket' => secureEmptyNull($values,"id_type_ticket"),
					'id_type_status' => $id_type_status,
					'id_application' => secureEmptyNull($values,"id_type_application"),
					'id_user_creator' => secureEmptyNull($values,"id_user_active"),
					'id_user_assigned' => secureEmptyNull($values,"id_user_assigned"),
					'date_from' => secureEmptyNull($values,"date_from"),
					'date_to' => $date_to,
					'id_type_base_work' => $id_type_base_work,
                    'hours_work' => secureEmptyNull($values,"hours_work"),
                    'percent_work' => secureEmptyNull($values,"percent_work"),
                    'keywords' => $values["keywords"],
					'id_net' => secureEmptyNull($values,"id_net"),
					'id_server' => secureEmptyNull($values,"id_server"),
					'id_system' => secureEmptyNull($values,"id_system"),
				    'sinopsys_close'=>$values["sinopsys_close"],
					'id_type_priority' => $id_type_priority,
                );
            }
            $saved=parent::save($values,$fields);
            if($saved["status"]=="OK"){
               $inner=array(
                    "code"=>null,
                    "description"=>null,
                    "created"=>$this->now,
                    "verified"=>$this->now,
                    "fum"=>$this->now,
                    "id_ticket"=>$saved["data"]["id"],
                    "id_user"=>$values["id_user_active"],
                    "keywords"=>"=",
                    "mime"=>null,
                    "data"=>null,
                    "basename"=>null,
                );
               $opts=array("new"=>"new-ticket-items","inner"=>$inner);
               parent::saveAttachments($values,$saved["data"]["id"],$opts);
			   if ($close and $values["sinopsys_close"]!="") {
					$KEYWORDS=$this->createModel(MOD_SUPPORT,"Keywords","Keywords");
					$KNOWS=$this->createModel(MOD_SUPPORT,"Knows","Knows");
					$fields=array(
					  "id"=>0,
					  "code"=>opensslRandom(16),
					  "description"=>$values["sinopsys_close"],
					  "id_ticket"=>$saved["data"]["id"],
	  				  "id_net" => secureEmptyNull($values,"id_net"),
					  "id_server" => secureEmptyNull($values,"id_server"),
					  "id_system" => secureEmptyNull($values,"id_system"),
					  "id_type_application"=>secureEmptyNull($values,"id_type_application"),
					  "id_user_creator"=>secureEmptyNull($values,"id_user_active")
					);
					$saved2=$KNOWS->save($fields);
					$keys=explode(",",$values["keywords"]);
					foreach($keys as $key){$fields["description"]=trim($key);$KEYWORDS->save($fields);}
			   }
			   if ($new){
    			  $saved["proposal"]=array("dirty"=>"0","function"=>null,"knows"=>null);
			      //Evaluate knowledgemnt base and respond with potential solutions or procedures for the saved ticket!
				  $segmentT=" SELECT id FROM "; 
				  $segmentT.=" (";
				  $segmentT.="  SELECT T.id FROM ".MOD_SUPPORT."_tickets as T ";
				  $segmentT.="    INNER JOIN FREETEXTTABLE (MOD_SUPPORT_tickets, [description], '".$fields["description"]."') as K ON T.id = K.[KEY]";
				  $segmentT.="    WHERE id_type_status=3 and id_application=".$fields["id_application"];
				  $segmentT.="   UNION ALL ";
				  $segmentT.="   SELECT T.id FROM ".MOD_SUPPORT."_tickets as T ";
				  $segmentT.="    INNER JOIN FREETEXTTABLE (MOD_SUPPORT_tickets, [sinopsys], '".$fields["description"]."') as K ON T.id = K.[KEY]";
				  $segmentT.="    WHERE id_type_status=3 and id_application=".$fields["id_application"];
				  $segmentT.=" ) as [data] ";

				  $strWords="";
				  $sql="SELECT * FROM ".MOD_SUPPORT."_keywords WHERE id_ticket IN (".$segmentT.")";
				  $words=$this->getRecordsAdHoc($sql);
				  foreach($words as $word){
					 if($word["description"]!="") {
				        if ($strWords!=""){$strWords.=(" OR ".$strWords);}
				        $strWords.=("\"".$word["description"]."\"");
					 }
				  }
				  $sql="SELECT * FROM ".MOD_SUPPORT."_knows WHERE id_ticket IN (".$segmentT.")";
				  if ($strWords!="") {
					  $sql.=" UNION ALL ";
  					  $sql.="SELECT * FROM MOD_SUPPORT_knows WHERE id_application=3 AND FREETEXT([description], '".$strWords."')";
   				  }
				  $knows=$this->getRecordsAdHoc($sql);
				  $saved["proposal"]=array("dirty"=>sizeOf($knows),"function"=>"_FUNCTIONS.onPostTickets(_this,data.proposal)","knows"=>$knows);
			   }
            }
            return $saved;
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function form($values){
        try {
            $data["parameters"] = $values;
            $data["title"] = "";

            $parameters_id_application=array(
                "model"=>(MOD_BACKEND."/applications"),
                "table"=>"applications",
                "name"=>"id_application",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_system=array(
                "model"=>(MOD_INFRASTRUCTURE."/systems"),
                "table"=>"systems",
                "name"=>"id_system",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_ticket=array(
                "model"=>(MOD_SUPPORT."/type_tickets"),
                "table"=>"type_tickets",
                "name"=>"id_type_ticket",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_field"=>"id",
                "description_field"=>"description",
                "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );
            $parameters_id_type_status=array(
                "model"=>(MOD_SUPPORT."/type_status"),
                "table"=>"type_status",
                "name"=>"id_type_status",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_field"=>"id",
                "description_field"=>"description",
		        "get"=>array("order"=>"description ASC","pagesize"=>-1),
            );

            $data["controls"]=array(
                "id_system"=>getCombo($parameters_id_system,$this),
                "id_application"=>getCombo($parameters_id_application,$this),
                "id_type_ticket"=>getCombo($parameters_id_type_ticket,$this),
                "id_type_status"=>getCombo($parameters_id_type_status,$this),
				"cboMonth"=>getComboMonths("cboMonth","form-control cboMonth validate-report"),
				"cboYear"=>getComboYears("cboYear","form-control cboYear validate-report","-10 year","+0 year"),
            );

            $html=$this->load->view(MOD_SUPPORT."/tickets/form",$data,true);
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

	public function buildReportTareas($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month) {
	    if ((int)$month<10){$month=("0".$month);}
		$title=("Resumen de estados de requerimientos durante ".$month."/".$year);
	    $logo="data:image/png;base64,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";
		$this->view="vw_tickets";
		if((int)$id_application!=0){$values["where"]="id_application=".$id_application;}
		if ($values["where"]!=""){$values["where"].=" AND ";}
		$values["where"].=" ((id_type_status IN (3,8) AND MONTH(date_from)=".$month." AND YEAR(date_from)=".$year.") OR (id_type_status NOT IN (3,8) AND date_from<='".($year."-".$month."-01 00:00:00")."') )";
		/*
		if((int)$id_system!=0){
			if ($values["where"]!=""){$values["where"].=" AND ";}
			$values["where"]="id_system=".$id_system;
		}
		if((int)$id_type_ticket!=0){
			if ($values["where"]!=""){$values["where"].=" AND ";}
			$values["where"]="id_type_ticket=".$id_type_ticket;
		}
		if((int)$id_type_status!=0){
			if ($values["where"]!=""){$values["where"].=" AND ";}
			$values["where"]="id_type_status=".$id_type_status;
		}
		*/
		$values["order"]="application ASC, system ASC, type_ticket ASC, type_status ASC, created DESC";
		$tickets=$this->get($values);

		$sql="SELECT count(id) as total,type_status FROM ".MOD_SUPPORT."_vw_tickets WHERE ".$values["where"]." GROUP BY type_status";
		$grouped=$this->getRecordsAdHoc($sql);
		
		$open="<!DOCTYPE html><html lang='es-AR'><head>";
		$open.="<meta property='og:url' content='".getServer().$_SERVER[REQUEST_URI]."' />";
		$open.="<meta property='og:type' content='document' />";
		$open.="<meta property='og:title' content='".$title."' />";
		$open.="<meta property='og:description' content='Informe ".$month."/".$year." de atención de solicitudes y requerimientos' />";
		$open.="<meta property='og:image' content='https://neohub.gruponeodata.com/assets/img/small.png'/>";
		$close="</head>";

		$html="";
		$html.="<h3 style='padding:2px;margin:0px;margin-left:10px;background-color:rgb(0,155,219);color:white;width:100%;'>".$title."</h3>";
		$html.="<div style='padding:2px;margin:0px;margin-left:9px;margin-top:5px;border:solid 1px silver;'><table style='display:inline;font-size:12px;'>";
		foreach($grouped as $item){
			$html.="<tr>";
			$html.="    <td valign='middle' align='left'>".$item["type_status"]."</td>";
			$html.="	<td align='right'><b>".$item["total"]."</b></td>";
			$html.="</tr>";
		}
		$html.="</table></div>";

		$last_type_ticket="";
		$last_system="";
		$last_type_ticket="";
		$hours=0;
		foreach($tickets["data"] as $ticket){
		   if ($ticket["application"]==""){$ticket["application"]="Sin aplicación específica";}
		   if ($last_application!=$ticket["application"]){
		      $last_application=$ticket["application"];
			  $last_system="";
			  $last_type_ticket="";
			  $html.="<hr/>";
			  $html.="<table style='width:100%;'>";
			  $html.="   <tr>";
			  $html.="      <td><h2><span style='color:rgb(0,155,219);font-size:1.25em;'>N</span>eodata</h2></td>";
			  $html.="      <td valign='middle' align='right'>";
			  $html.="         <h2>Reporte de asignaciones internas ".$last_application." ".$month."/".$year."</h2>";
			  $html.="      </td>";
			  $html.="   </tr>";
			  $html.="</table>";
			  $html.="<hr/>";
		   };
		   if ($ticket["system"]==""){$ticket["system"]="Sin sistema específico";}
		   if ($last_system!=$ticket["system"]){
		      $last_system=$ticket["system"];
			  $last_type_ticket="";
			  $html.="<h4 style='padding:2px;margin:0px;margin-top:10px;margin-left:10px;margin-bottom:2px;background-color:grey;color:white;width:100%;'>".$last_system."</h4>";
		   };
		   if ($ticket["type_ticket"]==""){$ticket["type_ticket"]="Sin tipo de ticket específico";}
		   if ($last_type_ticket!=$ticket["type_ticket"]){
		      $last_type_ticket=$ticket["type_ticket"];
			  $html.="<h4 style='padding:0px;margin:0px;margin-left:20px;'>".$last_type_ticket."</h4>";
		   };

		   $html.="<p style='padding:0px;margin:0px;margin-left:30px;font-size:12px;'>".date('m/Y', strtotime($ticket["created"]))." - <b>".$ticket["type_status"]."</b> - ".$ticket["description"]."</p>";
		   $hours+=(int)$ticket["hours_work"];
		   //if ($ticket["sinopsys"]!=""){$html.="<div style='margin-left:30px;padding:5px;border:solid 1px silver;'>".$ticket["sinopsys"]."</div>";}
		}
		$footer="<hr/>";
		$footer.="<table style='width:100%;'>";
		$footer.="   <tr>";
		$footer.="      <td valign='middle' align='left'>";
		$footer.="         <p style='font-size:10px;'><i>Tareas desarrolladas en forma directa por el equipo Neodata</i></p>";
		$footer.="         <p style='font-size:9px;'>Reporte generado el ".date(FORMAT_DATE_DMYHMS)."</p>";
		$footer.="      </td>";
		//$footer.="      <td align='right'><img src='".$logo."' height='54' /></td>";
		$footer.="      <td align='right'><h2><span style='color:rgb(0,155,219);font-size:1.25em;'>N</span>eodata</h2></td>";
		$footer.="   </tr>";
		$footer.="</table>";
		
		$html=($open.$html.$footer.$close);
	    return $html;
	}
	public function buildReportAsignaciones($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month) {
	    if ((int)$month<10){$month=("0".$month);}
		$title=("Resumen de asignaciones internas durante ".$month."/".$year);
	    $logo="data:image/png;base64,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";
		$this->view="vw_tickets";
		if((int)$id_application!=0){$values["where"]="id_application=".$id_application;}
		if ($values["where"]!=""){$values["where"].=" AND ";}
		$values["where"].=" id_type_ticket=8 AND id_type_status=2 AND date_from<='".($year."-".$month."-01 00:00:00")."'";
		$values["order"]="application ASC, username_assigned ASC";
		$tickets=$this->get($values);

		$sql="SELECT sum(percent_work) as total,username_assigned FROM ".MOD_SUPPORT."_vw_tickets WHERE ".$values["where"]." GROUP BY username_assigned";
		$grouped=$this->getRecordsAdHoc($sql);
		
		$open="<!DOCTYPE html><html lang='es-AR'><head>";
		$open.="<meta property='og:url' content='".getServer().$_SERVER[REQUEST_URI]."' />";
		$open.="<meta property='og:type' content='document' />";
		$open.="<meta property='og:title' content='".$title."' />";
		$open.="<meta property='og:description' content='Informe ".$month."/".$year." de atención de solicitudes y requerimientos' />";
		$open.="<meta property='og:image' content='https://neohub.gruponeodata.com/assets/img/small.png'/>";
		$close="</head>";

		$html="";
		$html.="<h3 style='padding:2px;margin:0px;margin-left:10px;background-color:rgb(0,155,219);color:white;width:100%;'>".$title."</h3>";
		$html.="<div style='padding:2px;margin:0px;margin-left:9px;margin-top:5px;border:solid 1px silver;'><table style='display:inline;font-size:12px;'>";
		foreach($grouped as $item){
			$html.="<tr>";
			$html.="    <td valign='middle' align='left'>Asignación total de ".ucfirst($item["username_assigned"])."</td>";
			$html.="	<td align='right'><b>".$item["total"]."%</b></td>";
			$html.="</tr>";
		}
		$html.="</table></div>";

		$last_type_ticket="";
		$last_system="";
		$last_type_ticket="";
		$percent=0;
		foreach($tickets["data"] as $ticket){
		   if ($ticket["application"]==""){$ticket["application"]="Sin aplicación específica";}
		   if ($last_application!=$ticket["application"]){
		      $last_application=$ticket["application"];
			  $last_system="";
			  $last_type_ticket="";
			  $html.="<hr/>";
			  $html.="<table style='width:100%;'>";
			  $html.="   <tr>";
			  $html.="      <td><h2><span style='color:rgb(0,155,219);font-size:1.25em;'>N</span>eodata</h2></td>";
			  $html.="      <td valign='middle' align='right'>";
			  $html.="         <h2>Reporte de asignaciones internas ".$last_application." ".$month."/".$year."</h2>";
			  $html.="      </td>";
			  $html.="   </tr>";
			  $html.="</table>";
			  $html.="<hr/>";
		   };
		   if ($ticket["system"]==""){$ticket["system"]="Sin sistema específico";}
		   if ($last_system!=$ticket["system"]){
		      $last_system=$ticket["system"];
			  $last_type_ticket="";
			  $html.="<h4 style='padding:2px;margin:0px;margin-top:10px;margin-left:10px;margin-bottom:2px;background-color:grey;color:white;width:100%;'>".$last_system."</h4>";
		   };
		   if ($ticket["type_ticket"]==""){$ticket["type_ticket"]="Sin tipo de ticket específico";}
		   if ($last_type_ticket!=$ticket["type_ticket"]){
		      $last_type_ticket=$ticket["type_ticket"];
			  $html.="<h4 style='padding:0px;margin:0px;margin-left:20px;'>".$last_type_ticket."</h4>";
		   };
		   $html.="<p style='padding:0px;margin:0px;margin-left:30px;font-size:12px;'><b>".ucfirst($ticket["username_assigned"])."</b> - ".$ticket["percent_work"]."% - ".$ticket["description"]."</p>";
		   $percent+=(int)$ticket["percent_work"];
		}
		$footer="<hr/>";
		$footer.="<table style='width:100%;'>";
		$footer.="   <tr>";
		$footer.="      <td valign='middle' align='left'>";
		$footer.="         <p style='font-size:10px;'><i>Asignaciones internas del equipo Neodata</i></p>";
		$footer.="         <p style='font-size:9px;'>Reporte generado el ".date(FORMAT_DATE_DMYHMS)."</p>";
		$footer.="      </td>";
		$footer.="      <td align='right'><h2><span style='color:rgb(0,155,219);font-size:1.25em;'>N</span>eodata</h2></td>";
		$footer.="   </tr>";
		$footer.="</table>";
		
		$html=($open.$html.$footer.$close);
	    return $html;
	}
	public function knowHelp($values){
	    $this->save(array("id"=>$values["id_ticket"]),array("id_type_status"=>3,"json"=>'{"autoclose":true,"id_know":'.$values["id_know"].'}'));
		$sql="UPDATE ".MOD_SUPPORT."_knows SET weight=(weight+1) WHERE id=".$values["id_know"];
		$this->executeAdHoc($sql);
	}
}
