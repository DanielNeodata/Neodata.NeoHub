<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class My_Model extends CI_Model {
    public $ready = false;
    public $status = null;
    public $language = DEFAULT_LANGUAGE;
    public $module = "";
    public $model = "";
    public $table = "";
    public $view = "";
    public $now=null;
    public $psession=null;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set(DEFAULT_TIMEZONE);
        $this->now=date(FORMAT_DATE);
    }
    /*Initialize*/
    public function init($model,$table,$lang=null){
        try {
            if ($lang!=null){$this->language=$lang;}
            $this->module=explode("/",$model)[0];
            $this->model=$model;
            $this->table=$table;
            $this->view=$table;
            $this->ready = true;
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                );
        }
        catch(Exception $e) {
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

    /*Public I/O methods*/
    public function getField($field,$id){
	   $record=$this->get(array("fields"=>$field,"where"=>"id=".$id));
	   $return=null;
	   if ($record["totalrecords"]!=0){$return=$record["data"][0][$field];}
	   return $return;
	}

    public function get($values){
        try {
            if (isset($values["view"])){$this->view=$values["view"];}
            $data=$this->getRecords($values);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"Records",
                "table"=>$this->table,
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data["records"],
                "totalrecords"=>$data["totalrecords"],
                "totalpages"=>$data["totalpages"],
                "page"=>$data["page"]
            );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function getByWhere($params){
        try {
            $ACTIVE=$this->createModel($params["module"],$params["model"],$params["model"]);
            $record=$ACTIVE->get(array("fields"=>$params["field"],"where"=>$params["where"]));
            $data=null;
            if(isset($record["data"][0][$params["field"]])){$data=$record["data"][0][$params["field"]];}
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"Record retrieved",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data,
                );
        } catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        try {
            if(!isset($values["id"]) or $values["id"]==""){$values["id"]=0;}
            $id=(int)$values["id"];
            $message="";
            if($id==0){
                if($fields==null) {
                    $fields = array(
                       'code' => $values["code"],
                       'description' => $values["description"],
                       'created' => $this->now,
                       'verified' => $this->now,
                       'offline' => null,
                       'fum' => $this->now,
                    );
                }
            } else {
                if($fields==null) {
                    $fields = array(
                       'code' => $values["code"],
                       'description' => $values["description"],
                       'fum' => $this->now,
                    );
                }
            }
            $id=$this->setRecord($fields,$id);
            $this->saveAttachments($values,$id,null);
            $this->saveMessages($values,$id,null);

            $data=array("id"=>$id);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>$message,
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data,
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function insertBySelect($values){
        try {
            $sql="INSERT INTO ".($this->module."_".$this->table)." (".$values["fieldList"].") (".$values["selectToInsert"].")";
            //log_message("error", "RELATED ".json_encode($sql,JSON_PRETTY_PRINT));
            $this->db->query($sql);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }

    public function offline($values){
        try {
            $data=array("id"=>$this->setRecord(array('offline' => $this->now,'fum' => $this->now),$values["id"]));
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_offline'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function online($values){
        try {
            $data=array("id"=>$this->setRecord(array('offline' => null,'fum' => $this->now),$values["id"]));
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_online'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function delete($values){
        try {
            $FILES_ATTACHED=$this->createModel(MOD_BACKEND,"Files_attached","Files_attached");
            $file=$FILES_ATTACHED->get(array("where"=>"id_rel=".$values["id"]." AND table_rel='".$this->table."'"));
            foreach($file["data"] as $item){
                unlink($item["src"]);
                $FILES_ATTACHED->delete(array("id"=>$item["id"]));
            }
            $del=$this->delRecord(("id=".$values["id"]));
            if($del!==true){throw $del;};
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_delete'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function deleteByWhere($where){
        try {
        //log_message("error", "WHERE ".json_encode($where,JSON_PRETTY_PRINT));
            $del=$this->delRecord($where);
            if($del!==true){throw $del;};
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function updateByWhere($fields,$where){
        try {
            $resolvedTableView=($this->module."_".$this->table);
            $this->db->where($where);
            $this->db->update($resolvedTableView, $fields);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function info($values){
        try {
            $values["fields"]="max(id) as max_id, count(*) as total";
            $info=$this->get($values);
            if ($info["status"]!="OK"){throw new Exception($info["message"],(int)$info["code"]);};
            if (isset($info["data"][0])) {
                $data=array(
                    "total"=>(int)$info["data"][0]["total"],
                    "max_id"=>(int)$info["data"][0]["max_id"],
                    );
                return array(
                    "code"=>"2000",
                    "status"=>"OK",
                    "message"=>lang('msg_info'),
                    "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                    "data"=>$data,
                    );
            } else {
                throw new Exception(lang("error_5001"),5001);
            }
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function process($values){
        try {
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_process'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
    }
    public function getRecordsAdHoc($sql) {
        try {
            $records=$this->db->query($sql)->result_array();
            if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {$records=toUtf8($records);}
            return $records;
        }
        catch(Exception $e){
            return null;
        }
    }
    public function executeAdHoc($sql) {
        try {
            $this->db->query($sql);
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    /*Public GPI methods*/
    public function form($values){
        try {
            if(!isset($values["interface"])){$values["interface"]=("form");}
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view($values["interface"],$data,true);
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
    public function brow($values){
        try {
            if(!isset($values["interface"])){$values["interface"]=("brow");}
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view($values["interface"],$data,true);
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
    public function edit($values){
        try {
            if(!isset($values["interface"])){$values["interface"]="abm";}
            if(!isset($values["attached_files"])){$data["attached_files"] = $this->getAttachments($values,null);}else{$data["attached_files"]=$values["attached_files"];}
            if(!isset($values["attached_messages"])){$data["attached_messages"] = $this->getMessages($values,null);}else{$data["attached_messages"]=$values["attached_messages"];}
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".$values["model"]));
            $html=$this->load->view($values["interface"],$data,true);
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

    /*Public 1 a N relation methods*/
    public function saveRelations($values) {
        try {
            $ACTIVE=$this->createModel($values["module"],$values["model"],$values["model"]);
            $ACTIVE->deleteByWhere(array($values["key_field"]=>$values["key_value"]));
            foreach ($values["rel_values"] as $item){
                if ($item!=null and $item!="") {$ACTIVE->save(array("id"=>0),array($values["key_field"]=>$values["key_value"],$values["rel_field"]=>$item));}
            }
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                );
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }
    public function deleteRelations($values) {
        try {
            $ACTIVE=$this->createModel($values["module"],$values["model"],$values["model"]);
            $ACTIVE->deleteByWhere(array($values["key_field"]=>$values["key_value"]));
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                );
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }

    /*Public FILE attachment methods*/
    public function saveAttachments($values,$id,$opts=null){
        try {
                if(!isset($opts["module"])){$opts["module"]=MOD_BACKEND;}
                if(!isset($opts["model"])){$opts["model"]="Files_attached";}
                if(!isset($opts["new"])){$opts["new"]="new-files";}
                if(!isset($opts["del"])){$opts["del"]="del-files";}
                if(!isset($opts["id"])){$opts["id"]="id";}
                if(!isset($opts["source"])){$opts["source"]="src";}
                if(!isset($opts["filename"])){$opts["filename"]="filename";}
                $resolvedTableView=($this->module."_".$this->table);
               
                $ACTIVE=$this->createModel($opts["module"],$opts["model"],$opts["model"]);
                //Process new attached files
                $path=(FILE_ATTACHED."/".$this->table);

                if (isset($values[$opts["new"]]) and is_array($values[$opts["new"]])) {
                    foreach ($values[$opts["new"]] as $item){
                        if ($item[$opts["source"]]!=null and $item[$opts["source"]]!="") {
                            $code=opensslRandom(16);
                            $fullpath=($path."/".$code."_".$item[$opts["filename"]]);
                            saveBase64ToFile(array("data"=>$item[$opts["source"]],"path"=>$path,"fullPath"=>$fullpath));
                            if(!isset($opts["inner"])) {
                                $fields=array(
                                        "code"=>$code,
                                        "description"=>$item[$opts["filename"]],
                                        "created"=>$this->now,
                                        "verified"=>$this->now,
                                        "fum"=>$this->now,
                                        "src"=>$fullpath,
                                        "filename"=>basename($fullpath),
                                        "id_rel"=>$id,
                                        "table_rel"=>$resolvedTableView
                                );
                            } else {
                                $fields=$opts["inner"];
                                foreach(array_keys($fields) as $key){
                                    switch($key) {
                                        case "code":
                                            $fields[$key]=$code;
                                            break;
                                        case "description":
                                            $fields[$key]=$item[$opts["filename"]];
                                            break;
                                        case "data":
                                            $fields[$key]=$fullpath;
                                            break;
                                        case "mime":
                                            $fields[$key]=getMimeType($fullpath);
                                            break;
                                        case "basename":
                                            $fields[$key]=basename($fullpath);
                                            break;
                                        default:
                                            if($fields[$key]=="="){$fields[$key]=$item[$key];}
                                            break;
                                    }
                                }
                            }
							$ACTIVE->save(array("id"=>0),$fields);
                        }
                    }
                }
                //Process del attached files
                if (isset($values[$opts["del"]]) and is_array($values[$opts["del"]])) {
                    foreach ($values[$opts["del"]] as $item){
                        $file=$ACTIVE->get(array("where"=>"id=".$item[$opts["id"]]));
                        foreach($file["data"] as $item){
                            unlink($item[$opts["source"]]);
                            $ACTIVE->delete(array("id"=>$item[$opts["id"]]));
                        }
                    }
                }
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                );
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }
    public function getAttachments($values,$opts=null){
        try {
                if(!isset($opts["module"])){$opts["module"]=MOD_BACKEND;}
                if(!isset($opts["model"])){$opts["model"]="Files_attached";}
                if(!isset($opts["where"])){
                    $resolvedTableView=($values["module"]."_".$values["table"]);
                    $opts["where"]=("table_rel='".$resolvedTableView."' AND id_rel=".$values["id"]);
                }
                if(!isset($opts["view"])){$opts["view"]=$opts["model"];}
                $ACTIVE=$this->createModel($opts["module"],$opts["model"],$opts["model"]);
                $ACTIVE->view=$opts["view"];
				return $ACTIVE->get(array("where"=>$opts["where"],"ORDER BY description ASC"));
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }

    /*Public MESSAGES attachment methods*/
    public function saveMessages($values,$id,$opts=null){
        try {
                if(!isset($opts["module"])){$opts["module"]=MOD_BACKEND;}
                if(!isset($opts["model"])){$opts["model"]="Messages_attached";}
                if(!isset($opts["new"])){$opts["new"]="new-messages";}
                if(!isset($opts["del"])){$opts["del"]="del-messages";}
                if(!isset($opts["id"])){$opts["id"]="id";}
                if(!isset($opts["source"])){$opts["source"]="message";}
                $resolvedTableView=($this->module."_".$this->table);
                $ACTIVE=$this->createModel($opts["module"],$opts["model"],$opts["model"]);
                //Process new attached messages
                if (isset($values[$opts["new"]]) and is_array($values[$opts["new"]])) {
                    foreach ($values[$opts["new"]] as $item){
                        if ($item[$opts["source"]]!=null and $item[$opts["source"]]!="") {
                            $code=opensslRandom(16);
                            $fields=array(
                                    "code"=>$code,
                                    "description"=>$code,
                                    "created"=>$this->now,
                                    "verified"=>$this->now,
                                    "fum"=>$this->now,
                                    "message"=>$item[$opts["source"]],
                                    "id_user"=>$values["id_user_active"],
                                    "id_rel"=>$id,
                                    "table_rel"=>$resolvedTableView
                            );
                            $ret=$ACTIVE->save(array("id"=>0),$fields);
                            if ($ret["status"]!="OK"){throw new Exception($ret["message"],(int)$ret["code"]);}
                            if (isset($ret["data"]["id"])) {
                               $values["id"]=$ret["data"]["id"];
                               logMessagesAttached($this,$values,lang('msg_message_viewed'));
                            }
                        }
                    }
                }
                //Process del attached messages
                if (isset($values[$opts["del"]]) and is_array($values[$opts["del"]])) {
                    foreach ($values[$opts["del"]] as $item){
                        $file=$ACTIVE->get(array("where"=>"id=".$item[$opts["id"]]));
                        foreach($file["data"] as $item){
                            $ACTIVE->delete(array("id"=>$item[$opts["id"]]));
                        }
                    }
                }
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"",
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                );
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }
    public function getMessages($values,$opts=null){
        try {
                if(!isset($opts["module"])){$opts["module"]=MOD_BACKEND;}
                if(!isset($opts["model"])){$opts["model"]="Messages_attached";}
                if(!isset($opts["where"])){
                    $resolvedTableView=($this->module."_".$this->table);
                    $opts["where"]=("table_rel='".$resolvedTableView."' AND id_rel=".$values["id"]);
                }
                if(!isset($opts["view"])){$opts["view"]=$opts["model"];}
                $ACTIVE=$this->createModel($opts["module"],$opts["model"],$opts["model"]);
                $ACTIVE->view=$opts["view"];
                return $ACTIVE->get(array("where"=>$opts["where"],"ORDER BY created DESC"));
            }
            catch(Exception $e) {
                return logError($e,__METHOD__ );
            }
    }

    /*Private I/O methods*/
    private function getRecords($values) {
        try {
			if ($this->module==MOD_API) {
	           $resolvedTableView=($this->view);
			} else {
               $resolvedTableView=($this->module."_".$this->view);
			}
            if(!isset($values["page"])){$values["page"]=1;}
            if(!isset($values["pagesize"]) or $values["pagesize"]==""){$values["pagesize"]=25;}
            if(!isset($values["fields"]) or $values["fields"]==""){$values["fields"]="*";}
            //Total records
            $this->db->select("count(*) as total");
            $this->db->from($resolvedTableView);
            if(isset($values["where"]) and $values["where"]!=""){$this->db->where($values["where"]);}
            $sql=$this->db->get_compiled_select();
            $records=$this->db->query($sql)->result_array();
            $totalrecords=$records[0]["total"];
            $totalpages=ceil($totalrecords/$values["pagesize"]);
            //Filtered get
            $this->db->select($values["fields"]);
            $this->db->from($resolvedTableView);
            if(isset($values["where"]) and $values["where"]!=""){$this->db->where($values["where"]);}
            if(isset($values["order"]) and $values["order"]!=""){$this->db->order_by($values["order"]);}
            if((int)$values["pagesize"]>0){
                $from=(int)(($values["page"] - 1) * $values["pagesize"]);
                $size=(int)$values["pagesize"];
                $this->db->limit($size,$from);
            }
            $sql=$this->db->get_compiled_select();
            $records=$this->db->query($sql)->result_array();
            $return=array(
                "records"=>$records,
                "totalrecords"=>$totalrecords,
                "totalpages"=>$totalpages,
                "page"=>$values["page"]
                );
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                return $return;
            } else {
                return toUtf8($return);
            }
        }
        catch(Exception $e){
            return $e;
        }
    }
    private function setRecord($fields,$id) {
        try {
            $resolvedTableView=($this->module."_".$this->table);
            if($id==0) {
                $this->db->insert($resolvedTableView, $fields);
                $id=$this->db->insert_id();
            } else {
                $this->db->where('id',$id);
                $this->db->update($resolvedTableView, $fields);
            }
            return $id;
        }
        catch(Exception $e){
            return $e;
        }
    }
    private function delRecord($where) {
        try {
            $resolvedTableView=($this->module."_".$this->table);
            $this->db->delete($resolvedTableView, $where);
            return true;
        }
        catch(Exception $e){
            return $e;
        }
    }
}
