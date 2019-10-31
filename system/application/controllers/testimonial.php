<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Anusha Anand	
	* Created On 			-	April 28, 2010
	* Modified On 			-	April 28, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Testimonial extends Controller
	{
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		
		/**
		 * Schedule constructor
		 */
		
		function Testimonial () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			
			$this->load->model ('admin_schedule_model');
			$this->load->model('admin_testimonial_model');
			
			$this->gen_contents['js'] 			= array('client_login.js','effects.js','popcalendar.js','modalbox.js','custom_element.js');
			$this->gen_contents['title']		= 'Testimonials';
			$this->gen_contents['page_title']	= 'Testimonials';
		}
		/**
		 * function to load the home template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _home_template ($page,$contents){
			$this->load->view("client_home_header_new",$contents);
			$this->load->view('user/testimonial/'.$page, $contents);
			$this->load->view("client_home_footer_new",$contents);
		}
		/**
		 * Index
		 */	
		function index($display_type='normal')
		{
			if('iframe' == $display_type)
			$this->gen_contents['css'] 			= array('style.css','client_style.css','user_calendar_style.css','modalbox.css','inlineifrtestimonial.css');
			else
			$this->gen_contents['css'] 			= array('style.css','client_style.css','user_calendar_style.css','modalbox.css','inlinetestimonial.css');
			
			$this->load->model('admin_sitepage_model');			
			$this->_set_default_values();
			
			$testimonial_count = $this->admin_testimonial_model->qry_count_testimonials();
			$limit 	= 1;
			$offset = 0;
			$direction = '';
			if('' != $this->input->post('hidTestmId')){
				$offset = $this->input->post('hidTestmId');
				$direction = $this->input->post('hidDirection');
				if('next' == $direction){
					if($offset==$testimonial_count){
						$offset =0;
					}
				
				}
				if('prev' == $direction){
					if($offset==-1){
						$offset =$testimonial_count-1;
					}
				
				}
			} 		
			$this->gen_contents['offset'] = $offset;
			$this->gen_contents['direction'] = $direction;
			$this->gen_contents['testimonial'] = $this->admin_testimonial_model->select_testimonial($this->gen_contents['offset'],$limit);
			if('iframe' == $display_type){
				$this->_iframe_template('iframe_testimonial',$this->gen_contents);
			}else{
				$this->_home_template('view_testimonial',$this->gen_contents);
			}
			
		}
		function get_next(){
			$testimonial_count = $this->admin_testimonial_model->qry_count_testimonials();
			$limit = 1;
			$offset = 0;
			$direction = '';
			$hidTestmId = $this->uri->segment(3);
			$hidDirection = $this->uri->segment(4);
			if('' != $hidTestmId){
				$offset = $hidTestmId;
				$direction = $hidDirection;
				if('next' == $direction){
					if($offset==$testimonial_count){
						$offset =0;
					}				
				}
				if('prev' == $direction){
					if($offset==-1){
						$offset =$testimonial_count-1;
					}
				
				}
			}
			//$this->gen_contents['offset'] = $offset;
			//$this->gen_contents['direction'] = $direction;
			$testimonial = array();
			$testimonial = $this->admin_testimonial_model->select_testimonial($offset,$limit);		
			$testimonial[0]['offset'] = $offset;
			$testimonial[0]['direction'] = $direction;
			$jtestimonial = json_encode($testimonial[0]);
			echo $jtestimonial;
		}
		/**
		 * function used to get all the default values
		 */
		function _set_default_values(){
			$this->gen_contents['siteurl']			= $this->admin_sitepage_model->select_sitepages_url();
			$this->gen_contents['image_path'] 		= $this->config->item('image_upload_url').'thumbs/';
			$this->gen_contents["offset_hidden"] 	= 0;
			$this->gen_contents["num_hidden"] 		= 5;
		}

		function iframe(){
			$this->index('iframe');
		}
		/**
		 * function to load the home template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _iframe_template ($page,$contents){
			$this->load->view("iframe_header",$contents);
			$this->load->view('user/testimonial/'.$page, $contents);
			$this->load->view("iframe_footer",$contents);
		}
		
		
	}	
/* End of file schedule.php */
/* Location: ./system/application/controllers/schedule.php */
