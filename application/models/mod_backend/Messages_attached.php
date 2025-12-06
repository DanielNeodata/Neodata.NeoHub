<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Messages_attached extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function messageRead($values){
       return logMessagesAttached($this,$values,lang('msg_message_viewed'));
    }

    public function notifications($values){
        $values["where"]="(id_user_target IS null OR id_user_target=".$values["id_user_active"].") AND id NOT IN (SELECT id_message_attached FROM mod_backend_messages_attached_log as ml WHERE mod_backend_messages_attached.id=ml.id_message_attached AND ml.id_user=".$values["id_user_active"].")";
        return $this->get($values);
    }

}
