<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'third_party/mpdf60/mpdf.php';
class M_pdf {
    public $pdf;
    public function __construct()
    {
        $this->pdf = new mPDF("en-GB-x","A4","","",10,10,10,10,6,3);
    }
}
