<?php
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

//ERROR BEHAVIOUR
function getServer(){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host=$_SERVER['SERVER_NAME'];
    $port=$_SERVER['SERVER_PORT'];
    return ($protocol.$host.":".$port);
}

function logError($e,$function){
    log_message("error", (ERROR_GENERAL." ".TITLE_PAGE." [".$function."] ".$e->getCode()." ".$e->getMessage()));
    return array(
        "code"=>$e->getCode(),
        "status"=>"ERROR",
        "message"=>$e->getMessage(),
        "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? $function :ENVIRONMENT),
        );
}
function logGeneral($obj,$values,$method,$custom_trace=null){
    try {
        if(!isset($values["id_user_active"]) or $obj->table=="log_general"){throw new Exception(lang('error_9999'),9999);}
        if(!isset($values["id"])){$values["id"]=null;}
        if(is_array($values["id"])){$values["id"]=implode(",",$values["id"]);}
        $LOG_GENERAL=$obj->createModel(MOD_BACKEND,"Log_general","Log_general");
        $resolvedTableView=($obj->module."_".$obj->table);
        $trace=array(
                "line"=>__LINE__,
                "file"=>__FILE__,
                "dir"=>__DIR__,
                "function"=>__FUNCTION__,
                "class"=>__CLASS__,
                "trait"=>__TRAIT__,
                "method"=>__METHOD__,
                "namespace"=>__NAMESPACE__,
        );
        if($custom_trace!=null) {$trace["custom"]=json_encode($custom_trace);}
        $fields = array(
            'code' => opensslRandom(16),
            'description' => lang('msg_log_general'),
            'created' => $obj->now,
            'verified' => $obj->now,
            'offline' => null,
            'fum' => $obj->now,
            'id_user' => $values["id_user_active"],
            'action' => $method,
            'trace' => json_encode($trace),
            'id_rel' => $values["id"],
            'table_rel' => $resolvedTableView,
        );
        return $LOG_GENERAL->save(array("id"=>0),$fields);
    } catch(Exception $e) {
        if ($e->getCode()!==9999){return logError($e,__METHOD__ );} else {return null;}
    }
}

function logMessagesAttached($obj,$values,$method){
    try {
        if(!isset($values["id_user_active"])){throw new Exception(lang('error_9999'),9999);}
        if(!isset($values["id"])){$values["id"]=null;}
        $MESSAGES_ATTACHED_LOG=$obj->createModel(MOD_BACKEND,"Messages_attached_log","Messages_attached_log");
        $fields = array(
            'code' => opensslRandom(16),
            'description' => lang('msg_log_folder_items'),
            'created' => $obj->now,
            'verified' => $obj->now,
            'offline' => null,
            'fum' => $obj->now,
            'id_user' => $values["id_user_active"],
            'id_message_attached' => $values["id"],
            'processed' => $obj->now,
            'tag_processed' => $method,
        );
        return $MESSAGES_ATTACHED_LOG->save(array("id"=>0),$fields);
    } catch(Exception $e) {
        if ($e->getCode()!==9999){return logError($e,__METHOD__ );} else {return null;}
    }
}

//CRIPTOGRAPHY
function opensslRandom($len){
    $bytes = openssl_random_pseudo_bytes($len);
    return bin2hex($bytes);
}
function getEncryptionKey(){
    $myconfig=&get_config();
    return $myconfig['encryption_key'];
}
function getSecureRandomize($min, $max)
{
    $ver = (float)phpversion();
    if ($ver >= 7.0) {
        $ret=random_int($min,$max);
    } elseif ($ver >= 5.6) {
        $ret=((unpack("N", openssl_random_pseudo_bytes(4)) % ($max - $min)) + $min);
    } else {
        $ret=rand($min,$max);
    }
    return $ret;
}

//FORMATING
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}
function objectToArrayRecusive($object,$assoc=1,$empty='')
{
    $out_arr = array();
    $assoc = (!empty($assoc)) ? TRUE : FALSE;
    if (!empty($object)) {
        $arrObj = is_object($object) ? get_object_vars($object) : $object;
        $i=0;
        foreach ($arrObj as $key => $val) {
            $akey = ($assoc !== FALSE) ? $key : $i;
            if (is_array($val) || is_object($val)) {
                $out_arr[$key] = (empty($val)) ? $empty : object_to_array_recusive($val);
            }
            else {
                $out_arr[$key] = (empty($val)) ? $empty : (string)$val;
            }
            $i++;
        }
    }
    return $out_arr;
}
function avoidNull($data){
   if ($data==null){return "";}else{return $data;};
}
function toUtf8($d) {
    if (is_array($d))
        foreach ($d as $k => $v) $d[$k] = toUtf8($v);
    else if(is_object($d))
        foreach ($d as $k => $v) $d->$k = toUtf8($v);
    else
        return utf8_encode($d);
    return $d;
}
function getMimeType($filename) {
    $idx = explode( '.', $filename );
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);

    $mimet = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',


        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (isset( $mimet[$idx] )) {
        return $mimet[$idx];
    } else {
        return 'application/octet-stream';
    }
}
function imapUtf8Fix($string) {
    $string=iconv_mime_decode($string,2,"UTF-8");
    return $string;
}
function isBase64Encoded($str) 
{
    try
    {
        $str=str_replace(' ','+',$str);
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $str);
    }
    catch(Exception $e)
    {
        return false;
    }
}
function html2text($Document) {
    $Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&(reg|#174);@i',
                    '@&#(d+);@e'
             );
    $Replace = array ('',
                      '',
                      '',
                      '',
                      '&',
                      '<',
                      '>',
                      ' ',
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      chr(174),
                      'chr()'
                );
    //return preg_replace($Rules, $Replace, $Document);
    return strip_tags($Document);
}
function IsInArray($records,$key,$value){
    $ret=0;
    foreach($records as $item) {
        if (strpos($item[$key],$value)!==FALSE) {
            $ret=true;
            break;
        }
    }
    return $ret;
}
function getEmailArrayFromString($sString = '')
{
    $sPattern = '/[\._\p{L}\p{M}\p{N}-]+@[\._\p{L}\p{M}\p{N}-]+/u';
    preg_match_all($sPattern, $sString, $aMatch);
    $aMatch = array_keys(array_flip(current($aMatch)));
    return $aMatch;
}

function validateDateTime($format,$dateStr)
{
    $date = DateTime::createFromFormat($format, $dateStr);
    return $date && $date->format($format) === $dateStr;
}

function monthsBetween($startDate, $endDate) {
    $retval = "";
    $splitStart = explode('-', $startDate);
    $splitEnd = explode('-', $endDate);
    if (is_array($splitStart) && is_array($splitEnd)) {
        $difYears = $splitEnd[0] - $splitStart[0];
        $difMonths = $splitEnd[1] - $splitStart[1];
        $difDays = $splitEnd[2] - $splitStart[2];

        $retval = ($difDays > 0) ? $difMonths : $difMonths - 1;
        $retval += $difYears * 12;
    }
    return $retval;
}

//FILES I/O and COMPRESSION
function saveBase64ToFile($values){
    if (!file_exists($values["path"])) {mkdir($values["path"], 0777, true);}
    $mime=explode(',',$values["data"]);
    $encoded=$mime[1];
    $encoded=str_replace(' ','+',$encoded);
    $data=base64_decode($encoded);
    return file_put_contents($values["fullPath"],$data,FILE_USE_INCLUDE_PATH);
}
function saveBinToFile($values){
    if (!file_exists($values["path"])) {mkdir($values["path"], 0777, true);}
    return file_put_contents($values["fullPath"],$values["data"], FILE_USE_INCLUDE_PATH);
}
function compress($obj,$data) {
    $obj->load->library('zip');
    $obj->zip->compression_level = 9;
    $obj->zip->add_data("compressed.tmp", $data);
    return base64_encode($obj->zip->get_zip());
}

//USER VERIFICATION
function getUserProfile($obj,$id,$active_api=null){
    try {
        $USERS=$obj->createModel(MOD_BACKEND,"Users","Users");
        $user=$USERS->get(array("where"=>"id='".$id."'"));
        $GROUPS=$obj->createModel(MOD_BACKEND,"Groups","Groups");
        $group=$GROUPS->get(array("where"=>"id IN (SELECT id_group FROM mod_backend_rel_users_groups WHERE id_user=".$id.")"));
        $user["groups"]=$group["data"];
        $sql="SELECT * FROM ".MOD_API."_vw_neo_authentication_dbo_mod_backend_users WHERE id IN (SELECT id_application FROM mod_backend_rel_users_applications WHERE id_user=".$id.")";
		$user["api_users"]=$obj->getRecordsAdHoc($sql);
		$i=0;
		foreach ($user["api_users"] as $record){
			$id_user=$record["id"];
			$sql="SELECT * FROM ".MOD_API."_vw_neo_authentication_dbo_mod_backend_applications WHERE ";
			if($active_api!=null and $active_api!="") {$sql.= "code='".$active_api."' AND ";}
			$sql.="id IN (SELECT id_application FROM ".MOD_API."_vw_neo_authentication_dbo_mod_backend_rel_users_applications WHERE id_user=".$id_user.")";
			$sql.=" ORDER BY description ASC";
            $apps=$obj->getRecordsAdHoc($sql);
			$x=0;
			foreach ($apps as $a){
			   $prof=null;
			   $sql=$a["profile"];
			   if ($sql!="") {
			      $sql=str_replace('[ID_USER_AUTH]',$id_user,$sql);
                  $prof=$obj->getRecordsAdHoc($sql);
			   }
			   $y=0;
			   foreach ($prof as $p){
				  $sql="SELECT * FROM ".MOD_API."_vw_neo_transactions_dbo_mod_transactions_type_transactions WHERE id_profile=".$p["id"];
                  $types_transactions=$obj->getRecordsAdHoc($sql);
			      $prof[$y]["api_types_transactions"]=$types_transactions;
		          $y=($y+1);
			   }
			   $apps[$x]["api_profiles"]=$prof;
		       $x=($x+1);
			}
			$user["api_users"][$i]["api_applications"]=$apps;
			$i=($i+1);
		}
        return $user;
    } catch(Exception $e) {
        if ($e->getCode()!==9999){return logError($e,__METHOD__ );} else {return null;}
    }
}
function getCredentialsAPI($active_api,$profile){
	$ret=array();
	foreach ($profile["api_users"] as $api){
		$username=$api["username"];
		$password=$api["password"];
		$id_application=0;
		foreach ($api["api_applications"] as $record){
			if($active_api==strtolower($record["code"])){
				$id_application=(int)$record["id"];
			}
		}
		array_push($ret,array("username"=>$username,"password"=>$password,"id_application"=>$id_application));
	}

	$username=$profile["api_users"][0]["username"];
	$password=$profile["api_users"][0]["password"];
	$id_application=0;
	foreach ($profile["api_users"][0]["api_applications"] as $record){
		if($active_api==strtolower($record["code"])){
			$id_application=(int)$record["id"];
		}
	}
	$ret["username"]=$username;
	$ret["password"]=$password;
	$ret["id_application"]=$id_application;

	foreach ($ret as $item){
	    log_message("error", "RELATED ".json_encode($item,JSON_PRETTY_PRINT));
	}

	return $ret;

	//return array("username"=>$username,"password"=>$password,"id_application"=>$id_application);
}

/*CURL*/
function cUrl($url,$fields=null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    if ($fields!=null) {curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);}
    $jsonResponse = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err=curl_error($ch);
    curl_close($ch);
    $response = json_decode($jsonResponse, true);
    return $response;
}

/*User DETECTION*/
function getOrigin() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return null;
}

