<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon
	* Created On 			-	October 23, 2009
	* Modified On 			-	October 23, 2009
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------
	class Admin_flyer extends Controller
	{

            /**
             * General contents
             *
             * @var Array
             */
            var $gen_contents	=	array();

            /**
             * Admin constructor
             *
             */
            function Admin_flyer () {
                    parent::Controller();
                    $this->load->library('authentication');
                    $this->load->helper(array('form', 'file'));
                    if (!$this->authentication->logged_in ("admin"))
                    {
                            redirect("admin");
                    }
                    else if($this->authentication->logged_in ("admin") === "sub") 
                    {
                        $this->session->set_flashdata('success', $this->session->flashdata("success"));
                        redirect("admin/noaccess");
                        exit;
                    }
                    $this->load->library(array('form_validation'));
                    $this->load->model(array('common_model', 'admin_flyer_model'));
                    $this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
                    $this->gen_contents['js'] = array('admin_user_js.js','popcalendar.js', 'admin_flyer.js');
                    $this->gen_contents['title']	=	'Flyer Management';

            }
            /**
             * function to load the template (header, body and footer)
             *
             * @param string $page
             * @param array $contents
             */
            function _template ($page,$contents, $admin_folder='admin/flyer/'){
                    $this->load->helper('form');
                    $this->load->view("admin_header",$contents);
                    $this->load->view($admin_folder.$page, $contents);
                    $this->load->view("admin_footer");
            }
            
            
            function list_flyers (){
            
                    $this->gen_contents['page_title']   = 'Flyers';
                    $this->load->library('pagination');
                    $config['base_url']                 = base_url().'admin_flyer/list_flyers/';
                    $config['per_page'] 		= '10';
                    $config['uri_segment']  		= 3;

                    $this->gen_contents["search_title"] = '';
                    $this->gen_contents["search_date"]  = '';

                    if(!empty($_POST)) {
                        $this->gen_contents["search_title"] = $this->common_model->safe_html($this->input->post('txtSrchTitle'));
                        $this->gen_contents["search_date"]  = $this->common_model->safe_html($this->input->post('txtSrchDate'));
                    }else {
                        $this->gen_contents["search_title"] = ($this->session->flashdata('search_title'))?$this->session->flashdata('search_title'):$this->gen_contents["search_title"];
                        $this->gen_contents["search_date"]  = ($this->session->flashdata('search_date'))?$this->session->flashdata('search_date'):$this->gen_contents["search_date"];                        
                    }

                    $this->session->set_flashdata('search_title',$this->gen_contents["search_title"]);
                    $this->session->set_flashdata('search_date', $this->gen_contents["search_date"]);


                    $this->gen_contents["flyers"]       = $this->admin_flyer_model->getAllFlyers($this->gen_contents, 'list', $config['per_page'],$this->uri->segment(3));
                    $config['total_rows']   		= $this->admin_flyer_model->getAllFlyers($this->gen_contents, 'count');
                    
                    $this->pagination->initialize($config);
                    $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
                    $this->_template('list_flyers', $this->gen_contents);
            }
            
            function add_flyer(){
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->load->library(array('form_validation'));
                    $this->form_validation->set_rules('title', 'File Title', 'trim|required|max_length[128]');
                    $this->form_validation->set_rules('heading', 'Heading', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('sub_heading', 'Sub Heading', 'trim|required|max_length[180]');
                    $this->form_validation->set_rules('date', 'Date', 'trim|required');

                    if($this->form_validation->run() == TRUE) {
                        $this->gen_contents['msg']  = '';
                        $check_title = $this->admin_flyer_model->titleExists($this->common_model->safe_html($this->input->post('title')));
                        
                        if($check_title){
                            $this->gen_contents['msg']   = 'Title already exists';
                        }
                        if('' == $this->gen_contents['msg']){
                            $time       = $this->_getFormattedTime($_POST['hr'], $_POST['min'], $_POST['ap']);
                            $date_time  = date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$time));
                            /* Registration in process save mail starts */
                            $save_data = array(
                                'title'             => $this->common_model->safe_html($this->input->post('title')),
                                'head_image'        => $this->common_model->safe_html($this->input->post('head_image')),
                                'heading'           => $this->common_model->safe_html($this->input->post('heading')),
                                'sub_heading'       => $this->common_model->safe_html($this->input->post('sub_heading')),
                                'date_time'         => $date_time,
                                'created_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                'created_by'        => $this->session->userdata('USERID')
                            );
                            if($this->admin_flyer_model->save($save_data)){                                
                                $this->session->set_flashdata ('success', 'Flyer created successfully');
                            }else{
                                $this->session->set_flashdata ('error', 'Failed to create Flyer');
                            }
                            redirect('admin_flyer/list_flyers');
                        }
                    }else{
                        $this->gen_contents['errors']   = validation_errors();
                    }
                }
                $this->load->helper("form");

                $this->gen_contents['head']     = "Add Flyer";
                $this->gen_contents['flyer_heading_images'] = $this->admin_flyer_model->getAllFlyerImages();
                $this->gen_contents['btn']      = "Add";
                $this->gen_contents['is_edit']  =  0;

                $this->gen_contents['flyer']    = array();
                $this->_template('add_flyer', $this->gen_contents);                
	    
            }
            
            function edit_flyer(){
                $this->gen_contents['flyer_id']     = $this->uri->segment(3);
                if(!($this->gen_contents['flyer_id'] > 0) || !($flyer = $this->admin_flyer_model->getFlyer($this->gen_contents['flyer_id']))){
                    redirect('admin_flyer/list_flyer');
                }
                
                $this->gen_contents['flyer']    = (array) $flyer;
                
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->load->library(array('form_validation'));
                    $this->form_validation->set_rules('title', 'File Title', 'trim|required|max_length[128]');
                    $this->form_validation->set_rules('heading', 'Heading', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('sub_heading', 'Sub Heading', 'trim|required|max_length[180]');
                    $this->form_validation->set_rules('date', 'Date', 'trim|required');

                    if($this->form_validation->run() == TRUE) {
                        $this->gen_contents['msg']  = '';
                        $check_title = $this->admin_flyer_model->titleExists($this->common_model->safe_html($this->input->post('title')), $this->gen_contents['flyer_id']);
                        
                        if($check_title){
                            $this->gen_contents['msg']   = 'Title already exists';
                        }
                        if('' == $this->gen_contents['msg']){
                           $time       = $this->_getFormattedTime($_POST['hr'], $_POST['min'], $_POST['ap']);
                           $date_time  = date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$time));
                            //print  $date_time;exit;
                            //echo $date_time;exit;
                            /* Registration in process save mail starts */
                            $update_data = array(
                                'title'             => $this->common_model->safe_html($this->input->post('title')),
                                'head_image'        => $this->common_model->safe_html($this->input->post('head_image')),
                                'heading'           => $this->common_model->safe_html($this->input->post('heading')),
                                'sub_heading'       => $this->common_model->safe_html($this->input->post('sub_heading')),
                                'date_time'         => $date_time,
                                'created_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                'created_by'        => $this->session->userdata('USERID')
                            );
                            if($this->admin_flyer_model->update($this->gen_contents['flyer_id'], $update_data)){                                
                                $this->session->set_flashdata ('success', 'Flyer updated successfully');
                            }else{
                                $this->session->set_flashdata ('error', 'Failed to update Flyer');
                            }
                            redirect('admin_flyer/list_flyers');
                        }
                    }else{
                        $this->gen_contents['errors']   = validation_errors();
                    }
                }
                $this->load->helper("form");

                $this->gen_contents['head']     = "Edit Flyer";
                $this->gen_contents['flyer_heading_images'] = $this->admin_flyer_model->getAllFlyerImages();
                $this->gen_contents['btn']      = "Update";
                $this->gen_contents['is_edit']  =  1;

                
                $this->_template('add_flyer', $this->gen_contents);        
            }
            
            function export_flyer(){
                $id = $this->uri->segment(3);
                $flyer  = $this->admin_flyer_model->getFlyer($id);
                if($flyer){
                    $this->_export_pdf($flyer);
                }else{
                     $this->session->set_flashdata ('error', 'Invalid request');
                }
            }
            function _getFormattedTime($hour, $minute, $type){
                if($type=='PM'){
                        $meridiem = 'pm';
                }else{
                        $meridiem = 'am';
                }

                $set_time = sprintf('%02d',$hour).':'.sprintf('%02d',$minute).' '.$meridiem;

                $formattedTime = date("H:i:s", strtotime($set_time));
                return $formattedTime;
            }
            
            function delete_flyer(){
                $id = $this->uri->segment(3);
                $flyer  = $this->admin_flyer_model->getFlyer($id);
                if($flyer){
                    if($this->admin_flyer_model->delete($id)){                                
                        $this->session->set_flashdata ('success', 'Flyer deleted successfully');
                    }else{
                        $this->session->set_flashdata ('error', 'Failed to delete Flyer');
                    }
                    redirect('admin_flyer/list_flyers');
                }else{
                     $this->session->set_flashdata ('error', 'Invalid request');
                }
            }
            function _export_pdf($flyer){
                $this->load->library('fpdf_ext');
                define('FPDF_FONTPATH',$this->config->item('fonts_path'));
                $this->fpdf_ext->AddPage('P','mm','A4');
                $this->fpdf_ext->Image($this->config->item('images').'reskin/pdf/head/'.$flyer->file_name, 0, 0, 210, 0,'');
                
                $this->fpdf_ext->AddFont('OpenSansExtraBold','B', 'OpenSans-ExtraBold.php');
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','29');
                $this->fpdf_ext->setXY(15, 128);
                $this->fpdf_ext->SetTextColor(72, 97, 183);
                $this->fpdf_ext->MultiCell(180, 11, $flyer->heading,0,'C');                
                $next_row_top   = $this->fpdf_ext->GetY()+5;
                
                $this->fpdf_ext->AddFont('OpenSansRegular','', 'OpenSans-Regular.php');
                $this->fpdf_ext->SetFont('OpenSansRegular','','14');
                $this->fpdf_ext->setXY(25, $next_row_top);
                $this->fpdf_ext->SetTextColor(55, 51, 52);
                $this->fpdf_ext->MultiCell(165, 6, $flyer->sub_heading,0,'C');
                $is_subheading_bottom_pos_max = ($this->fpdf_ext->GetY() > 183) ? TRUE : FALSE;
                $next_row_top   = (TRUE === $is_subheading_bottom_pos_max) ?  $this->fpdf_ext->GetY()+10: $this->fpdf_ext->GetY()+16;
                
                $this->fpdf_ext->AddFont('OpenSansSemibold','', 'OpenSans-Semibold.php');
                $this->fpdf_ext->SetFont('OpenSansSemibold','','23');
                $this->fpdf_ext->setXY(25, $next_row_top);
                $this->fpdf_ext->SetTextColor(238, 29, 35);
                $this->fpdf_ext->MultiCell(165, 6, strtoupper(date('l', strtotime($flyer->date_time))),0,'C');
                $next_row_top   = $this->fpdf_ext->GetY()+7;
                
                
                                
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','45');
                $date_string        = strtoupper(date('F j', strtotime($flyer->date_time)));
                $date_string_w      = round($this->fpdf_ext->GetStringWidth($date_string));
                
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','25');
                $suffix_string      = strtoupper(date('S', strtotime($flyer->date_time)));
                $suffix_string_w    = round($this->fpdf_ext->GetStringWidth($suffix_string));
                
                $this->fpdf_ext->SetFont('OpenSansSemibold','','25');
                $time_string        = strtoupper(date('\A\T g:i A', strtotime($flyer->date_time)));
                $time_string_w      = round($this->fpdf_ext->GetStringWidth($time_string));
                
                $total_string_w     = $date_string_w + $suffix_string_w + $time_string_w + 6;
                
                $page_width         = round($this->fpdf_ext->w);
                $pos_x              = round(($page_width - $total_string_w) / 2);
                
                //$pos_x          = ($date_string_w > 90) ? round(($date_string_w - 92) / 2) : 5; 
                
                $this->fpdf_ext->setXY($pos_x, $next_row_top);
                $this->fpdf_ext->SetTextColor(238, 29, 35);
                
                ////$this->fpdf_ext->Multicell(165, 6, strtoupper(date('F j \@ g A', strtotime($flyer->date_time))), 0, 'C');
                ////$next_row_top   = $this->fpdf_ext->GetY()+14;
                
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','45');
                $this->fpdf_ext->SetTextColor(238, 29, 35);
                $this->fpdf_ext->Multicell($date_string_w+3, 6, $date_string, 0, 'L');
                $pos_x=$pos_x+$date_string_w;
                
                
                
                $this->fpdf_ext->setXY($pos_x, $next_row_top);
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','25');
                $this->fpdf_ext->Multicell($suffix_string_w+3, 0, $suffix_string, 0, 'LT');
                $pos_x=$pos_x+$suffix_string_w;
                
                
                $this->fpdf_ext->setXY($pos_x+3, $next_row_top);
                $this->fpdf_ext->SetFont('OpenSansSemibold','','25');
                $this->fpdf_ext->Multicell($time_string_w+3, 10, $time_string, 0, 'L');
                
                
                $next_row_top   = $this->fpdf_ext->GetY()+10;
                
                
                
                $this->fpdf_ext->Image($this->config->item('images').'reskin/pdf/adhi-logo.jpg', 92, $next_row_top, 30, 0,'');
                $next_row_top   = $this->fpdf_ext->GetY()+40;
                
                $this->fpdf_ext->SetFont('OpenSansRegular','','12');
                $this->fpdf_ext->setXY(25, $next_row_top);
                $this->fpdf_ext->SetTextColor(85, 85, 85);
                $this->fpdf_ext->MultiCell(165, 6, "For more information and registration, visit:", 0, 'C');
                $next_row_top   = $this->fpdf_ext->GetY();
                
                $this->fpdf_ext->SetFont('OpenSansSemibold','','15');
                $this->fpdf_ext->setXY(25, $next_row_top);
                $this->fpdf_ext->SetTextColor(52, 125, 185);
                $this->fpdf_ext->MultiCell(165, 6, "www.adhischools.com",0,'C');
                $next_row_top   = $this->fpdf_ext->GetY()+1;
                
                $this->fpdf_ext->SetFont('OpenSansSemibold','','17');
                $this->fpdf_ext->setXY(25, $next_row_top);
                $this->fpdf_ext->SetTextColor(85, 86, 88);                
                $this->fpdf_ext->MultiCell(165, 6, "(888) 768-5285",0,'C');                
                
                $this->fpdf_ext->Ln(5);
                
                $this->fpdf_ext->Output();
            }
            
            function create_pdf(){
                $this->load->library('fpdf_ext');
                define('FPDF_FONTPATH',$this->config->item('fonts_path'));
                $this->fpdf_ext->AddPage('P','mm','A4');
                $this->fpdf_ext->Image($this->config->item('images').'reskin/pdf/head-bg.jpg', 0, 0, 210, 0,'');
                
                $this->fpdf_ext->AddFont('OpenSansExtraBold','B', 'OpenSans-ExtraBold.php');
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','29');
                $this->fpdf_ext->setXY(15, 130);
                $this->fpdf_ext->SetTextColor(72, 97, 183);
                $this->fpdf_ext->MultiCell(180, 11, "ADHI Schools, LLC is hosting a Career Event soon at KW Arcadia!",0,'C');
                
                
                $this->fpdf_ext->AddFont('OpenSansRegular','', 'OpenSans-Regular.php');
                $this->fpdf_ext->SetFont('OpenSansRegular','','14');
                $this->fpdf_ext->setXY(25, 157);
                $this->fpdf_ext->SetTextColor(55, 51, 52);
                $this->fpdf_ext->MultiCell(165, 6, "Invite your interested friends, family members, and even customers who may have an interest in becoming a real estate agent!",0,'C');
                
                $this->fpdf_ext->AddFont('OpenSansSemibold','', 'OpenSans-Semibold.php');
                $this->fpdf_ext->SetFont('OpenSansSemibold','','23');
                $this->fpdf_ext->setXY(25, 184);
                $this->fpdf_ext->SetTextColor(238, 29, 35);
                $this->fpdf_ext->MultiCell(165, 6, "WEDNESDAY",0,'C');
                
                $this->fpdf_ext->SetFont('OpenSansExtraBold','B','45');
                $this->fpdf_ext->setXY(25, 198);
                $this->fpdf_ext->SetTextColor(238, 29, 35);
                
                $this->fpdf_ext->WriteHTML('JULY 13, AT 1 PM', $parsed );
                $this->fpdf_ext->Multicell(165, 6, $parsed, 0, 'C');
                
                
                $this->fpdf_ext->Image($this->config->item('images').'reskin/pdf/adhi-logo.jpg', 90, 220, 30, 0,'');
                
                
                $this->fpdf_ext->SetFont('OpenSansRegular','','12');
                $this->fpdf_ext->setXY(25, 250);
                $this->fpdf_ext->SetTextColor(85, 85, 85);
                $this->fpdf_ext->MultiCell(165, 6, "For more information and registration, visit:", 0, 'C');
                
                
                $this->fpdf_ext->SetFont('OpenSansSemibold','','15');
                $this->fpdf_ext->setXY(25, 256);
                $this->fpdf_ext->SetTextColor(52, 125, 185);
                $this->fpdf_ext->MultiCell(165, 6, "www.adhischools.com",0,'C');
                
                $this->fpdf_ext->SetFont('OpenSansSemibold','','17');
                $this->fpdf_ext->setXY(25, 263);
                $this->fpdf_ext->SetTextColor(85, 86, 88);
                $this->fpdf_ext->MultiCell(165, 6, "(888) 768-5285",0,'C');
                
                //$this->fpdf_ext->MultiCell(165, 6, "JULY 13",0,'C');
                //$this->fpdf_ext->subWrite(10, 'TH', '', 30, 10);
                
                $this->fpdf_ext->Ln(5);
                
                
                
                $this->fpdf_ext->Output();
            }

    }
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */