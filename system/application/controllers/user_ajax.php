<?php

class User_ajax extends Controller {

		function User_ajax(){
			parent::Controller();			
			$this->load->helper("form");
			$this->load->helper('url');
			
		}
	
			
		function regenerate_captcha ()
        {
            $this->load->model ('user_model');
           /* $from               = $this->input->post("from");
            if(isset($from) && !empty($from))
                $captcha        = $this->common_model->generate_captcha ("",$from);
            else*/
            $captcha        = $this->user_model->generate_captcha ();
			$data['return_value']	=   $captcha['image'];
			$this->load->view ('dsp_show_ajax',  $data);
  
  		}
                
                function regenerate_home_captcha ()
        {
            $this->load->model ('user_model');
           /* $from               = $this->input->post("from");
            if(isset($from) && !empty($from))
                $captcha        = $this->common_model->generate_captcha ("",$from);
            else*/
            $captcha        = $this->user_model->generate_captcha (array(),"",0);
			$data['return_value']	=   $captcha['image'];
			$this->load->view ('dsp_show_ajax',  $data);
  
  		}
  
 }
?>
