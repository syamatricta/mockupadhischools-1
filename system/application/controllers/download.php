<?php

class Download extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}

        function index()
	{
            $file_path	= $this->config->item('site_basepath')."uploads/SSR_2015_Registration_Form-West_Coast-ADHI_Schools.pdf";            //06_27_14 ADHI_SSR LV_Reg_Form
            if(file_exists($file_path)){
                    $this->load->helper('download');
                    $data = file_get_contents($file_path); // Read the file's contents
                    force_download("SSR_2015_Registration_Form-West_Coast-ADHI_Schools.pdf", $data);                                        //06_27_14 ADHI_SSR LV_Reg_Form
            }
        }
}        