<?php
class Error extends Controller {
    var $gen_contents = array();
    function error_404()
    {
        $this->load->helper('form_helper');
            $this->output->set_status_header('404');
            //$this->template->set_template('user');
            $this->gen_contents['content']= $this->load->view('reskin/errors/error_404', '', TRUE);
            echo $this->load->view('reskin/errors/template', $this->gen_contents, TRUE);
            
            //$this->template->write_view('content', 'reskin/errors/error_404', $this->gen_contents);
            //$this->template->render();
    }
}