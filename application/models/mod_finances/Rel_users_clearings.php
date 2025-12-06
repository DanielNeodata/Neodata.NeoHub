<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Rel_users_clearings extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
   public function save($values,$fields=null){
        try {
		log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
            $id=(int)$values["id"];
            if($id==0){
                $fields = array(
                    'id_user' => $values["id_user_active"],
                    'id_clearing' => $fields["id_clearing"],
					'created' => $this->now,
                );
			}
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

}
