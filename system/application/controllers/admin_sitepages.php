<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon	
	* Created On 			-	November 03, 2009
	* Modified On 			-	November 03, 2009
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_sitepages extends Controller
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
		function Admin_sitepages () {
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
			$this->load->model('admin_sitepage_model');
			$this->load->model('Common_model');
			$this->load->helper ('tiny_mce');
			$this->gen_contents['css'] = array('admin_style.css');
			$this->gen_contents['js'] = array('admin_sitepage_js.js');
			$this->gen_contents['title']	=	'Sitepage Management';
			
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/sitepage/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * validating fields in server side
		 *
		 */
		function _init_validation_rules () {
			$this->form_validation->set_rules('txtTitle', 'Title', 'required');
			$this->form_validation->set_rules('txtContent', 'Content', 'required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_sitepage_details (){
			$this->title			=	$this->input->post('txtTitle');	
			$this->content			=	$this->input->post('txtContent');
		}
		/**
		 * Index
		 *
		 * @access	public
		 */	
		function index()
		{
			$this->list_sitepage_details();
		}
		/**
		 * function to list the sitepage details
		 *
		 */
		function list_sitepage_details () {	
			$this->gen_contents['page_title']	=	'Sitepages';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_sitepages/list_sitepage_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["sitepages"]	=	$this->admin_sitepage_model->select_sitepages($config['per_page'],$this->uri->segment(3));
			$config['total_rows']   			= 	$this->admin_sitepage_model->qry_count_sitepages();
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_sitepage_details',$this->gen_contents);
		}
		
		/**
		 * function to show the template and showing the details
		 *
		 */
		function edit_sitepages (){
			
			$this->gen_contents['page_title']	=	'Edit Site Pages';
			$this->gen_contents["sitepagedet"]	=	$this->admin_sitepage_model->select_single_sitepage_det($this->uri->segment(3));
			$this->_template('edit_sitepage_details',$this->gen_contents);
		}
		/**
		 * function to edit the site page
		 *
		 */
		function update_sitepage (){
			
			$this->_init_validation_rules();
			if($this->form_validation->run() == TRUE) {
					
				$this->_init_sitepage_details ();
				
				$this->gen_contents['sitepageid'] 	=	$this->uri->segment(3);
				$this->gen_contents['title']		=	$this->title;		
				$this->gen_contents['content']		=	$this->content;
				$update	=	$this->admin_sitepage_model->update_sitepage_det($this->gen_contents);
				if($update > 0)	{
					$this->session->set_flashdata ('success', 'Sitepage updated successfully');
					redirect('admin_sitepages/edit_sitepages/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
				}
				else {
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_sitepages/edit_sitepages/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
				}
			}
			else {
				$this->edit_sitepages ();
			}
		}
		
		
		/**
		 * function to list the sitepage details
		 *
		 */
		function list_banners () {	
			$this->gen_contents['page_title']	=	'Banners';
			$this->gen_contents['title']		=	'Banner Management';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_sitepages/list_banners/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["banners"]		=	$this->admin_sitepage_model->select_banners($config['per_page'],$this->uri->segment(3));
			$config['total_rows']   			= 	$this->admin_sitepage_model->qry_count_banners();
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_banner_details',$this->gen_contents);
		}
		
		/**
		 * function to show the template and showing the details
		 *
		 */
		function add_banner (){
			if($_POST && !empty($_POST)){
				$this->_save();
			}
			$this->gen_contents['page_title']	=	'Add Banner';
			$this->gen_contents['title']		=	'Banner Management';
			$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
			$already_added 						=	$this->admin_sitepage_model->get_already_used_banners();
			if(is_array($already_added) && count($already_added) > 0 ) {
				$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
			}
			$this->_template('add_banner_details',$this->gen_contents);
		}
		
		function _save(){	
			//$this->form_validation->set_rules('sitepage', 'Select Sitepage', 'trim|required');		
			$this->form_validation->set_rules ('txtTitle','Banner Title', 'trim|required|max_length[25]');			
			$this->form_validation->set_rules ('txtShortDesc','Short Description', 'trim|required|max_length[50]');			
			$this->form_validation->set_rules ('txtContent','Description', 'trim|required');
					
			if (FALSE == $this->form_validation->run()){
				$this->gen_contents['error'] =  validation_errors();
				if(empty($_FILES) || $_FILES['txtImage']['error'] != 0) {
					$this->gen_contents['error'] .=  'The Banner Image field is required.';
				}
				return false;
			} else if(empty($_FILES) || $_FILES['txtImage']['error'] != 0) {
				$this->gen_contents['error'] =  'The Banner Image field is required.';
				return false;
			} else {		
			
				$banner_data								=	array();
				
				$banner_data['banner_title']				=	$this->Common_model->safe_html($this->input->post('txtTitle'));
				$banner_data['banner_short_dec']			=	$this->Common_model->safe_html($this->input->post('txtShortDesc'));				
				$banner_data['banner_created_date']			=	date('Y-m-d H:i:s');
				//$banner_data['sitepage_id']					=	$this->input->post('sitepage');
				$banner_data['banner_long_desc']			=	$this->input->post('txtContent');
				
				$flag = 0;
				if(!empty($_FILES)) {
					if (($_FILES['txtImage']['error']) ==  0) {
						if($this->do_upload()){	
							$banner_data['banner_image'] = $this->gen_contents["file_name"];
						}else{
							$flag = 1;
							return false;
						}
					}
				}
				if($flag == 0) {
					$banner_id									=	$this->admin_sitepage_model->save_banner_details($banner_data);				
					
					if($banner_id) {
						$this->session->set_flashdata('success','Successfully added banner details.');
						redirect('admin_sitepages/list_banners');
					} else {
						$this->session->set_flashdata('error','Error was encountered while adding banner details. Please try again.');
						redirect('admin_sitepages/add_banner');
					}
				}
				
			}
		}
		
		
		/**
		 * function for file upload
		 */
		function do_upload(){
			
			$config['upload_path'] 				= $this->config->item ('banner_image_path');
			$config['allowed_types'] 			= implode('|',$this->config->item ('image_extensions'));
			$config['max_size']					= $this->config->item ('image_max_size');
			$config['max_width']  				= $this->config->item ('image_max_width');
			$config['max_height']  				= $this->config->item ('image_max_height');	
			$config['encrypt_name']				= TRUE;
			$imgname							= $_FILES['txtImage']['name'];
			$config['file_name']  				= $imgname;
			
			//checks if its of the same file extension
			$name_array = explode(".",$_FILES['txtImage']['name']);
			$ext        = $name_array[count($name_array)-1];
			if(!in_array($ext,$this->config->item ('image_extensions'))){
				$this->gen_contents['error'] = 'Incorrect file type';
				return FALSE;
			}
			
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('txtImage')){ 
				
				$this->gen_contents['error'] = $this->upload->display_errors();
				return FALSE;
			}	
			else{
				
				
				$arr_file = $this->upload->data();
				$this->gen_contents["file_name"] 	=  $arr_file['file_name'];
				
				image_resize($this->gen_contents['file_name'],$config['upload_path'],468,209);
				
				return TRUE;
			}
		}
		
		/**
		 * function to show the template and showing the details
		 *
		 */
		function delete_banner (){
			if($_POST && !empty($_POST)){
				$banner_id = $_POST['hidBannerId'];
				$banner_details	=	$this->admin_sitepage_model->select_banners(1,0,$banner_id);
				if($this->admin_sitepage_model->delete_banner($banner_id)){
					@unlink($this->config->item('banner_image_path').$banner_details[0]->banner_image);
					@unlink($this->config->item('banner_image_path').'thumbs/'.$banner_details[0]->banner_image);
					$this->session->set_flashdata('success','Successfully deleted banner details.');
					redirect('admin_sitepages/list_banners');
				} else {
					$this->session->set_flashdata('error','Error was encountered while deleting banner details. Please try again.');
					redirect('admin_sitepages/list_banners');
				}
			} else {
				redirect('admin_sitepages/list_banners');
			}
			
		}
		
		/**
		 * function to show the template and showing the details
		 *
		 */
		function edit_banner (){
			unset($_POST['ajax']);
			$banner_id = (int)$this->uri->segment(3);
			$this->gen_contents['banner_details']	=	$this->admin_sitepage_model->select_banners(1,0,$banner_id);
			if($_POST && !empty($_POST)){
				$this->_update($banner_id);
			}
			$this->gen_contents['page_title']	=	'Edit Banner';
			$this->gen_contents['title']		=	'Banner Management';
			//var_dump($this->gen_contents['banner_details']);
			
			if(is_array($this->gen_contents['banner_details']) && count($this->gen_contents['banner_details']) > 0){
				$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
				$already_added 						=	$this->admin_sitepage_model->get_already_used_banners($this->gen_contents['banner_details'][0]->banner_id);
				if(is_array($already_added) && count($already_added) > 0 ) {
					$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
				}
				$this->_template('edit_banner_details',$this->gen_contents);
			} else {
				redirect('admin_sitepages/list_banners');
			}
		}
		
		function _update($banner_id){	
			//$this->form_validation->set_rules('sitepage', 'Select Sitepage', 'trim|required');		
			$this->form_validation->set_rules ('txtTitle','Banner Title', 'trim|required|max_length[25]');			
			$this->form_validation->set_rules ('txtShortDesc','Short Description', 'trim|required|max_length[50]');		
			$this->form_validation->set_rules ('txtContent','Description', 'trim|required');	
					
			if (FALSE == $this->form_validation->run()){
				$this->gen_contents['error'] =  validation_errors();
				/*if(empty($_FILES) || $_FILES['txtImage']['error'] != 0) {
					$this->gen_contents['error'] .=  'The Banner Image field is required.';
				}*/
				return false;
			} else {		
			
				$banner_data								=	array();
				
				$banner_data['banner_title']				=	$this->Common_model->safe_html($this->input->post('txtTitle'));
				$banner_data['banner_short_dec']			=	$this->Common_model->safe_html($this->input->post('txtShortDesc'));				
				//$banner_data['sitepage_id']					=	$this->input->post('sitepage');
				$banner_data['banner_long_desc']			=	$this->input->post('txtContent');

				$flag = 0;
				if(!empty($_FILES)) {
					if (($_FILES['txtImage']['error']) ==  0) {
						if($this->do_upload()){	
							$banner_data['banner_image'] = $this->gen_contents["file_name"];
							$flag = 2;
						}else{
							$flag = 1;
							return false;
						}
					}
				}
				if($flag != 1) {
					$banner_id									=	$this->admin_sitepage_model->update_banner_details($banner_data,$banner_id);				
					
					if($banner_id) {
						if($flag == 2) {
							@unlink($this->config->item('banner_image_path').$this->gen_contents['banner_details'][0]->banner_image);
							@unlink($this->config->item('banner_image_path').'thumbs/'.$this->gen_contents['banner_details'][0]->banner_image);
						}
						$this->session->set_flashdata('success','Successfully updated banner details.');
						redirect('admin_sitepages/list_banners');
					} else {
						$this->session->set_flashdata('error','Error was encountered while updating banner details. Please try again.');
						redirect('admin_sitepages/edit_banner/'.$banner_id);
					}
				}
				
			}
		}
                /**
		 * function to list the sitepage details
		 *
		 */
		function list_faq () {
			$this->gen_contents['page_title']	=	'FAQ';
			$this->gen_contents['title']		=	'FAQ Management';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_sitepages/list_faq/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["faq"]		=	$this->admin_sitepage_model->select_faq($config['per_page'],$this->uri->segment(3));
			$config['total_rows']   			= 	$this->admin_sitepage_model->qry_count_faq();
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_faq_details',$this->gen_contents);
		}
                /**
		 * validating the faq in server side
		 *
		 */
		function _init_faq_validation_rules () {
			$this->form_validation->set_rules ('txtTitle','FAQ Question', 'trim|required');
			$this->form_validation->set_rules ('txtContent','FAQ Answer', 'trim|required');
		}
		/**
		 * function to show the template and showing the details
		 *
		 */
		function add_faq (){ 
			unset($_POST['ajax']);
			if($_POST && !empty($_POST)){
                              
				$this->_savefaq();
			}
			$this->gen_contents['page_title']	=	'Add FAQ';
			$this->gen_contents['title']		=	'FAQ Management';
			//$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
			//////$already_added 						=	$this->admin_sitepage_model->get_already_used_banners();
			//if(is_array($already_added) && count($already_added) > 0 ) {
				//$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
			//}
			$this->_template('add_faq_details',$this->gen_contents);
		}

		function _savefaq(){
                  //  if($this->input->post('txtTitle')){
                        $this->_init_faq_validation_rules();
			if (FALSE == $this->form_validation->run()){
					$this->gen_contents['error'] =  validation_errors();
					return false;
				} else {

				$faq_data								=	array();

				$faq_data['fq_question']				=	$this->Common_model->safe_html($this->input->post('txtTitle'));
				$faq_data['fq_answer']			=	$this->input->post('txtContent');
				$faq_data['faq_created_date']			=	date('Y-m-d H:i:s');
				$flag = 0;
				if($flag == 0) {
					$faq_id									=	$this->admin_sitepage_model->save_faq_details($faq_data);

					if($faq_id) {
						$this->session->set_flashdata('success','Successfully added faq details.');
						redirect('admin_sitepages/list_faq');
					} else {
						$this->session->set_flashdata('error','Error was encountered while adding faq details. Please try again.');
						redirect('admin_sitepages/add_faq');
					}
				}

			}
                    //}
		}


		/**
		 * function to show the template and showing the details
		 *
		 */
		function delete_faq (){
			if($_POST && !empty($_POST)){
				$faq_id = $_POST['hidfaqId'];
				$faq_details	=	$this->admin_sitepage_model->select_faq(1,0,$faq_id);
				if($this->admin_sitepage_model->delete_faq($faq_id)){
					$this->session->set_flashdata('success','Successfully deleted faq details.');
					redirect('admin_sitepages/list_faq');
				} else {
					$this->session->set_flashdata('error','Error was encountered while deleting faq details. Please try again.');
					redirect('admin_sitepages/list_faq');
				}
			} else {
				redirect('admin_sitepages/list_faq');
			}

		}

		/**
		 * function to show the template and showing the details
		 *
		 */
		function edit_faq (){
			$faq_id = (int)$this->uri->segment(3);
			$this->gen_contents['faq_details']	=	$this->admin_sitepage_model->select_faq(1,0,$faq_id);
			if($_POST && !empty($_POST)){
				$this->_updatefaq($faq_id);
			}
			$this->gen_contents['page_title']	=	'Edit FAQ';
			$this->gen_contents['title']		=	'FAQ Management';
			

			if(is_array($this->gen_contents['faq_details']) && count($this->gen_contents['faq_details']) > 0){
				//$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
				//$already_added 						=	$this->admin_sitepage_model->get_already_used_banners($this->gen_contents['banner_details'][0]->banner_id);
				//if(is_array($already_added) && count($already_added) > 0 ) {
					//$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
				//}
				$this->_template('edit_faq_details',$this->gen_contents);
			} else {
				redirect('admin_sitepages/list_faq');
			}
		}

		function _updatefaq($faq_id){
			//$this->form_validation->set_rules ('txtTitle','FAQ Question', 'trim|required');
			//$this->form_validation->set_rules ('txtContent','FAQ Answer', 'trim|required');
                        if($this->input->post('txtTitle')){
                        $this->_init_faq_validation_rules();
			if (FALSE == $this->form_validation->run()){
				$this->gen_contents['error'] =  validation_errors();
				
				return false;
			} else {

				$faq_data								=	array();
				$faq_data['fq_question']				=	$this->Common_model->safe_html($this->input->post('txtTitle'));
				$faq_data['fq_answer']			=	$this->input->post('txtContent');

				$faq_id									=	$this->admin_sitepage_model->update_faq_details($faq_data,$faq_id);
				if($faq_id) {
        				$this->session->set_flashdata('success','Successfully updated faq details.');
					redirect('admin_sitepages/list_faq');
				} else {
					$this->session->set_flashdata('error','Error was encountered while updating faq details. Please try again.');
					redirect('admin_sitepages/edit_faq/'.$faq_id);
				}
			}
                        }
		}
                /**
		 * function to list the sitepage details
		 *
		 */
		function list_brokerplacement () {
			$this->gen_contents['page_title']	=	'Broker placement';
			$this->gen_contents['title']		=	'Broker placement Management';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_sitepages/list_brokerplacement/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["brokerplacement"]		=	$this->admin_sitepage_model->select_brokerplacement($config['per_page'],$this->uri->segment(3));
			$config['total_rows']   			= 	$this->admin_sitepage_model->qry_count_brokerplacement();
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_brokerplacement_details',$this->gen_contents);
		}

		/**
		 * function to show the template and showing the details
		 *
		 */
		function add_brokerplacement (){
			unset($_POST['ajax']);
			if($_POST && !empty($_POST)){
				$this->_savebrokerplacement();
			}
			$this->gen_contents['page_title']	=	'Add Broker placement';
			$this->gen_contents['title']		=	'Broker placement Management';
			//$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
			//////$already_added 						=	$this->admin_sitepage_model->get_already_used_banners();
			//if(is_array($already_added) && count($already_added) > 0 ) {
				//$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
			//}
			$this->_template('add_brokerplacement_details',$this->gen_contents);
		}

		function _savebrokerplacement(){
			$this->form_validation->set_rules ('txtPostcode','Postcode', 'trim|required');
                        $this->form_validation->set_rules ('txtAddress','Address', 'trim|required');
			$this->form_validation->set_rules ('txtYTVName','YouTube URL', 'trim|required');
                        $this->form_validation->set_rules ('txtHCName','Hiring contact name', 'trim|required');
                        $this->form_validation->set_rules ('txtCName','Company name', 'trim|required');
                        $this->form_validation->set_rules ('txtPhonenumber','Phone number', 'trim|required');
                        $this->form_validation->set_rules ('txtcomDescription','Company Information', 'trim|required');


			if (FALSE == $this->form_validation->run()){
				$this->gen_contents['error'] =  validation_errors();
				return false;
			} else {
                               $search_str	=$this->input->post('txtPostcode');
                               $search_str	=	str_replace(' ','',$search_str);
			       $dataval=GetLatLong($search_str,$this->config->item('google_map_key'));

                               $brokerplacement_data								=	array();

			       $brokerplacement_data['sub_postcode']			=	$this->Common_model->safe_html($this->input->post('txtPostcode'));
                               $brokerplacement_data['address 	']			=	$this->Common_model->safe_html($this->input->post('txtAddress'));
			       $brokerplacement_data['co_lattitude']			=	$dataval['Latitude'];
			       $brokerplacement_data['co_longitude']			=	$dataval['Longitude'];
                               $brokerplacement_data['yt_video']			=	$this->Common_model->safe_html($this->input->post('txtYTVName'));
                               $brokerplacement_data['hiring_contact_name']		=	$this->Common_model->safe_html($this->input->post('txtHCName'));
                               $brokerplacement_data['company_name']			=	$this->Common_model->safe_html($this->input->post('txtCName'));
                               $brokerplacement_data['phone_number']		=	$this->Common_model->safe_html($this->input->post('txtPhonenumber'));
                               $brokerplacement_data['company_information']			=	$this->Common_model->safe_html($this->input->post('txtcomDescription'));
                               $brokerplacement_data['created_date']			=	date('Y-m-d H:i:s');
                               $brokerplacement_data['updated_date']			=	date('Y-m-d H:i:s');
                               if(!empty($_FILES)) {
                                    if (($_FILES['txtImage']['error']) ==  0) {
					if($this->do_upload_bp()){
        					$brokerplacement_data = array_merge($brokerplacement_data,array('image_name'=>$this->gen_contents["file_name"]));
					}else{
						$flag = 1;
					}
	                            }
				}
				$flag = 0;
				if($flag == 0) {
					$brokerplacement_id									=	$this->admin_sitepage_model->save_brokerplacement_details($brokerplacement_data);

					if($brokerplacement_id) {
						$this->session->set_flashdata('success','Successfully added Broker placement details.');
						redirect('admin_sitepages/list_brokerplacement');
					} else {
						$this->session->set_flashdata('error','Error was encountered while adding Broker placement details. Please try again.');
						redirect('admin_sitepages/add_brokerplacement');
					}
				}

			}
		}
                /**
		 * function for file upload
		 */
		function do_upload_bp(){

			$config['upload_path'] 				= $this->config->item ('image_uploadbp_path');
			$config['allowed_types'] 			= implode('|',$this->config->item ('image_extensions'));
			$config['max_size']					= $this->config->item ('image_max_size');
			$config['max_width']  				= $this->config->item ('image_max_width');
			$config['max_height']  				= $this->config->item ('image_max_height');
			$config['encrypt_name']				= FALSE;
			$imgname							= $_FILES['txtImage']['name'];
			$config['file_name']  				= $imgname;

			//checks if its of the same file extension
			$name_array = explode(".",$_FILES['txtImage']['name']);
			$ext        = $name_array[count($name_array)-1];
			if(!in_array($ext,$this->config->item ('image_extensions'))){
				$this->gen_contents['error_region'] = 'Incorrect file type';
				return FALSE;
			}

			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('txtImage')){

				$this->gen_contents['error_region'] = $this->upload->display_errors();
				return FALSE;
			}
			else{


				$arr_file = $this->upload->data();
				$this->gen_contents["file_name"] 	=  $arr_file['file_name'];

				image_resize($this->gen_contents['file_name'],$config['upload_path'],175,100);

				return TRUE;
			}
		}


		/**
		 * function to show the template and showing the details
		 *
		 */
		function delete_brokerplacement (){
			if($_POST && !empty($_POST)){
				$brokerplacement_id = $_POST['hidbrokerplacementId'];
				$brokerplacement_details	=	$this->admin_sitepage_model->select_brokerplacement(1,0,$brokerplacement_id);
				if($this->admin_sitepage_model->delete_brokerplacement($brokerplacement_id)){
					$this->session->set_flashdata('success','Successfully deleted Broker placement details.');
					redirect('admin_sitepages/list_brokerplacement');
				} else {
					$this->session->set_flashdata('error','Error was encountered while deleting Broker placement details. Please try again.');
					redirect('admin_sitepages/list_brokerplacement');
				}
			} else {
				redirect('admin_sitepages/list_brokerplacement');
			}

		}

		/**
		 * function to show the template and showing the details
		 *
		 */
		function edit_brokerplacement (){
			unset($_POST['ajax']);
			$brokerplacement_id = (int)$this->uri->segment(3);
			$this->gen_contents['brokerplacement_details']	=	$this->admin_sitepage_model->select_brokerplacement(1,0,$brokerplacement_id);
                        //print_r($this->gen_contents['brokerplacement_details']);
			if($_POST && !empty($_POST)){
				$this->_updatebrokerplacement($brokerplacement_id);
			}
			$this->gen_contents['page_title']	=	'Edit Broker placement';
			$this->gen_contents['title']		=	'Broker placement Management';


			if(is_array($this->gen_contents['brokerplacement_details']) && count($this->gen_contents['brokerplacement_details']) > 0){
				//$this->gen_contents['sitepages']	= 	$this->Common_model->prepare_select_box_data('adhi_sitepage', 'id,name', '', 'Select');
				//$already_added 						=	$this->admin_sitepage_model->get_already_used_banners($this->gen_contents['banner_details'][0]->banner_id);
				//if(is_array($already_added) && count($already_added) > 0 ) {
					//$this->gen_contents['sitepages']	= array_diff($this->gen_contents['sitepages'],$already_added);
				//}
				$this->_template('edit_brokerplacement_details',$this->gen_contents);
			} else {
				redirect('admin_sitepages/list_brokerplacement');
			}
		}

		function _updatebrokerplacement($brokerplacement_id){
			$this->form_validation->set_rules ('txtPostcode','Postcode', 'trim|required');
                        $this->form_validation->set_rules ('txtAddress','Address', 'trim|required');
			$this->form_validation->set_rules ('txtYTVName','YouTube URL', 'trim|required');
                        $this->form_validation->set_rules ('txtHCName','Hiring contact name', 'trim|required');
                        $this->form_validation->set_rules ('txtCName','Company name', 'trim|required');
                        $this->form_validation->set_rules ('txtPhonenumber','Phone number', 'trim|required');
                        $this->form_validation->set_rules ('txtcomDescription','Company Information', 'trim|required');

			if (FALSE == $this->form_validation->run()){
				$this->gen_contents['error'] =  validation_errors();

				return false;
			} else {
                               $arr_img					 		= $this->admin_sitepage_model->select_brokerplacement(1,0,$brokerplacement_id);
                                if($arr_img){
					//$this->gen_contents['subregion'] 	= $arr_subregion[0];
				}else{
					$this->session->set_flashdata('error','Invalid action');
					redirect('admin_sitepages/list_brokerplacement');
				}
				 $search_str	=$this->input->post('txtPostcode');
                               $search_str	=	str_replace(' ','',$search_str);
			       $dataval=GetLatLong($search_str,$this->config->item('google_map_key'));

                               $brokerplacement_data								=	array();

			       $brokerplacement_data['sub_postcode']			=	$this->Common_model->safe_html($this->input->post('txtPostcode'));
                               $brokerplacement_data['address 	']			=	$this->Common_model->safe_html($this->input->post('txtAddress'));
			       $brokerplacement_data['co_lattitude']			=	$dataval['Latitude'];
			       $brokerplacement_data['co_longitude']			=	$dataval['Longitude'];
                               $brokerplacement_data['yt_video']			=	$this->Common_model->safe_html($this->input->post('txtYTVName'));
                               $brokerplacement_data['hiring_contact_name']		=	$this->Common_model->safe_html($this->input->post('txtHCName'));
                               $brokerplacement_data['company_name']			=	$this->Common_model->safe_html($this->input->post('txtCName'));
                               $brokerplacement_data['phone_number']		=	$this->Common_model->safe_html($this->input->post('txtPhonenumber'));
                               $brokerplacement_data['company_information']			=	$this->Common_model->safe_html($this->input->post('txtcomDescription'));
                               $brokerplacement_data['created_date']			=	date('Y-m-d H:i:s');
                               $brokerplacement_data['updated_date']			=	date('Y-m-d H:i:s');
                              // print_r($_FILES);
                               if(!empty($_FILES)) {
                                        if (($_FILES['txtImage']['error']) ==  0) {

                                                if($this->do_upload_bp()){
                                                        @unlink($this->config->item ('image_uploadbp_path').$arr_img[0]->image_name);
                                                        @unlink($this->config->item ('image_uploadbp_path').'thumbs/'.$arr_img[0]->image_name);
                                                        $brokerplacement_data = array_merge($brokerplacement_data,array('image_name'=>$this->gen_contents["file_name"]));
                                                }
                                        }
                                }
				$brokerplacement_id									=	$this->admin_sitepage_model->update_brokerplacement_details($brokerplacement_data,$brokerplacement_id);
				if($brokerplacement_id) {
        				$this->session->set_flashdata('success','Successfully updated Broker placement details.');
					redirect('admin_sitepages/list_brokerplacement');
				} else {
					$this->session->set_flashdata('error','Error was encountered while updating Broker placement details. Please try again.');
					redirect('admin_sitepages/edit_brokerplacement/'.$brokerplacement_id);
				}
			}
		}
	}	
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */