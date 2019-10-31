<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Manu	
	* Created On 			-	Auguest 31, 2010
	* Modified On 			-	Auguest 31, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_meta extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $sitepageid 	=	''; 		/*Id of the selected sitepage*/
		var $title			=	'';		
		var $content		=	'';	
		
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_meta () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'file'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
                        else if($this->authentication->logged_in ("admin") === "sub") 
                        {
                            redirect("admin/noaccess");
                            exit;
                        }
			$this->load->library(array('form_validation'));
			
			$this->load->helper ('tiny_mce');
			$this->gen_contents['css'] = array('admin_style.css');
			$this->gen_contents['js'] = array('admin_settings.js');
			$this->gen_contents['title']	=	'Meta Administration';
			$this->load->model('admin_meta_data_model');
		}
		
		/**
		 * function used to validate the URI
		 *
		 * @return unknown
		 */
		function _validate_segments() {
		    if($this->uri->segment(3) === FALSE)
                return FALSE;
                
	        if (!is_numeric($this->uri->segment(3)) ||  intval($this->uri->segment(3)) < 0) {
		        return FALSE;
		    }
		    
		    $this->gen_contents['offset'] = intval($this->uri->segment(3));
		    return TRUE;
		    
		}		
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/meta/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		
		function index() {
			$this->list_items();
		}
		
		
		function list_items() {
		/*	//$this->output->enable_profiler(TRUE);
			$this->gen_contents['page_title']	=	'Meta Tag';
			if(!$this->authentication->logged_in("admin"))
				redirect("admin/login");	
			
			//$this->gen_contents['js']       = array_merge($this->gen_contents['js'],array('admin_settings.js'));			
			
			//$this->load->helper ('form');									
			$this->load->library('pagination');
			
			//For Pagination Library
			$config['base_url'] 	= base_url().'admin_meta/list_items';
			$config['per_page'] 	= 10;
			$config['uri_segment'] 	= 3;
			if($this->_validate_segments()){
				$this->gen_contents['offset']	= $this->uri->segment(3);
			}
			else{
				$this->gen_contents['offset']	= 0;
			}
			
			$config['total_rows'] 				=	$this->admin_meta_data_model->getAllMetaData('count', $this->gen_contents['offset'], $config['per_page']);			
			$this->gen_contents['meta_data'] 	=	$this->admin_meta_data_model->getAllMetaData('', $this->gen_contents['offset'], $config['per_page']);			
						
			$this->gen_contents['title']  		=	'Meta Administration';	
			$config								= 	array_merge($config,$this->config->item('pagination_standard') );
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']		=	$this->pagination->create_links();
	   		$this->admin_contents['content']	=	$this->load->view ('admin/meta/list',$this->gen_contents,true);
	  		
	   		$this->_template("list",$this->gen_contents);*/
		
			$this->gen_contents['page_title']	=	'Meta Tag';
			$this->gen_contents['title']  		=	'Meta Administration';	
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_meta/list_items/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			if($this->_validate_segments()){
				$this->gen_contents['offset']	= $this->uri->segment(3);
			}
			else{
				$this->gen_contents['offset']	= 0;
			}
			$config['total_rows'] 				=	$this->admin_meta_data_model->getAllMetaData('count', $this->gen_contents['offset'], $config['per_page']);			
			$this->gen_contents['meta_data'] 	=	$this->admin_meta_data_model->getAllMetaData('', $this->gen_contents['offset'], $config['per_page']);			
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list',$this->gen_contents);
		}
		
		
		function add() {
			unset($_POST['ajax']);
			$this->gen_contents['page_title']	=	'Add Meta Tag';
			$this->gen_contents['err_message']='';			
			$this->load->library ('form_validation');					
			$this->load->helper ('form');			
					
			if (isset ($_POST))
		    {	
				//Form validation
				$this->form_validation->set_rules ('txt_meta_name',"Meta Name", 'trim|required|max_length[250]|xss_clean');
				$this->form_validation->set_rules ('txt_meta_title',"Meta Title", 'trim|required|xss_clean');
    			$this->form_validation->set_rules ('txt_meta_keyword',"Meta Keyword",'trim|required|xss_clean');
    			$this->form_validation->set_rules ('txt_meta_description',"Meta Description",'trim|required|xss_clean');					
    			
				if ((TRUE == $this->form_validation->run())) {	

						$post_data['meta_page_name']	= trim($this->input->post ('txt_meta_name'));
						$post_data['meta_page_title']	= trim($this->input->post ('txt_meta_title'));
				    	$post_data['meta_keyword']		= trim($this->input->post ('txt_meta_keyword'));
				    	$post_data['meta_description']	= trim($this->input->post ('txt_meta_description'));

				    	if($this->admin_meta_data_model->getMetaByTitle($post_data['meta_page_name'])) {
						   	$this->gen_contents['error'] =  "Meta page name already exists";
				    	} else {
				    	
					    	if($this->admin_meta_data_model->insertMeta($post_data)) {
							   	$this->session->set_flashdata('success', "Meta data inserted successfully");
			    		   		redirect ('admin_meta/list_items');						   	
					    	} else {
					    		$this->session->set_flashdata('error', "Failed to insert the meta data");
			    		   		redirect ('admin_meta/list_items');
					    	}
				    	}
				}
			    				    	
			}
			$this->_template('add',$this->gen_contents);				   		
		}
		
		
		
		function edit() {
			unset($_POST['ajax']);
	    	$this->gen_contents['page_title']	=	'Edit Meta Tag';	
	
		    if(!$this->_validate_segments()) {
                redirect("admin_meta/list_items");
			}
			
			$this->load->library ('form_validation');			
			$this->gen_contents['meta_id'] = $this->uri->segment(3);    		
			
			$this->gen_contents['meta'] = $this->admin_meta_data_model->getMetaData($this->gen_contents['meta_id']);
			if($this->gen_contents['meta'] === FALSE) {
				$this->session->set_flashdata("error","Invalid meta data id.");
                redirect("admin_meta/list_items");
			}
			
			if (isset ($_POST)) {
				
				//Form validation
				$this->form_validation->set_rules ('txt_meta_name',"Meta Name", 'trim|required|max_length[250]|xss_clean');				
				$this->form_validation->set_rules ('txt_meta_title',"Meta Title", 'trim|required|xss_clean');
    			$this->form_validation->set_rules ('txt_meta_keyword',"Meta Keyword",'trim|required|xss_clean');
    			$this->form_validation->set_rules ('txt_meta_description',"Meta Description",'trim|required|xss_clean');					
    			
				if ((TRUE == $this->form_validation->run())) {	

						$post_data['meta_page_name']	= trim($this->input->post ('txt_meta_name'));					
						$post_data['meta_page_title']	= trim($this->input->post ('txt_meta_title'));
				    	$post_data['meta_keyword']		= trim($this->input->post ('txt_meta_keyword'));
				    	$post_data['meta_description']	= trim($this->input->post ('txt_meta_description'));
				    	
						if($this->admin_meta_data_model->getMetaByTitle($post_data['meta_page_name']) && 
																$this->gen_contents['meta']->meta_page_name != $post_data['meta_page_name']) {
							$this->gen_contents['error'] =  "Meta page name already exists";
				    	} else {				    	
				    	
					    	if($this->admin_meta_data_model->updateMeta($this->gen_contents['meta_id'] ,$post_data)) {
							   	$this->session->set_flashdata('success', "Meta data updated successfully");
			    		   		redirect ('admin_meta/list_items');						   	
					    	} else {
					    		$this->session->set_flashdata('error', "Failed to update the meta data");
			    		   		redirect ('admin_meta/list_items');
					    	}
				    	}
				}
				$this->_template('edit',$this->gen_contents);	
			}
    	}
    	
    	
    	function view() {
    		$this->gen_contents['page_title']	=	'Edit Meta Tag';
				
		    if(!$this->_validate_segments()) {
				$this->session->set_flashdata("error","Invalid meta data id.");						    	
                redirect("admin_meta/list_items");
			}
			
			$meta_id = $this->uri->segment(3);
			$this->gen_contents['meta'] = $this->admin_meta_data_model->getMetaData($meta_id);
			if($this->gen_contents['meta'] === FALSE) {
				$this->session->set_flashdata("error","Invalid meta data id.");				
                redirect("admin_meta/list_items");
			}
			
			$this->_template('view',$this->gen_contents);			
		}
		
		function delete() {
		    if(!$this->_validate_segments()) {
                redirect("admin_meta/list_items");
			}
			
			$this->gen_contents['meta_id']	= $this->uri->segment(3);
			
			$res = $this->admin_meta_data_model->deleteMetaData($this->gen_contents['meta_id']);
			if($res)
				$this->session->set_flashdata("success","Successfully deleted the meta data ");
			else
				$this->session->set_flashdata("error","Failed to delete the meta data ");
				
			redirect("admin_meta/list_items");
		}
	}