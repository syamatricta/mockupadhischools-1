<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	function forum_pwd()
		{
			$this->load->model('user_model','um');
			$this->um->vb_update_password();
		}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */