<?php
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
class Export extends MY_Controller {
    function __contruct(){
        parent::__construct();
    }
    function reporttareas($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month){
        try {
			$TICKETS=$this->createModel(MOD_SUPPORT,"tickets","tickets");
            $html=$TICKETS->buildReportTareas($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month);
			$this->load->library("m_pdf_l");
			$this->m_pdf_l->showImageErrors = false;
			$this->m_pdf_l->pdf->WriteHTML($html, 2);
			ob_end_clean();
			$this->m_pdf_l->pdf->Output(FILE_ATTACHED."report-Tickets", "I");
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
    function reportasignaciones($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month){
        try {
			$TICKETS=$this->createModel(MOD_SUPPORT,"tickets","tickets");
            $html=$TICKETS->buildReportAsignaciones($id_application,$id_system,$id_type_ticket,$id_type_status,$year,$month);
			$this->load->library("m_pdf_l");
			$this->m_pdf_l->showImageErrors = false;
			$this->m_pdf_l->pdf->WriteHTML($html, 2);
			ob_end_clean();
			$this->m_pdf_l->pdf->Output(FILE_ATTACHED."report-Tickets", "I");
        }
        catch (Exception $e){
            $this->output(logError($e,__METHOD__ ));
        }
    }
}
