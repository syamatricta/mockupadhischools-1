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
	class Admin_orders extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $orderid 		=	''; 		/*Id of the selected order*/
		var $datefrom		=	'';		
		var $dateto			=	'';	
		
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_orders () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'url', 'file'));
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
			$this->load->model('admin_order_model');
			$this->load->model('admin_user_model');
			$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] = array('admin_order_js.js','popcalendar.js');
			$this->gen_contents['title']	=	'Order Management';
			
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/order/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * Index
		 *
		 * @access	public
		 */	
		function index()
		{
			$this->list_order_details();
		}
		/**
		 * function to list the course details
		 *
		 */
		function list_order_details ()
		{	
			if(isset($_POST['date_from']) && '' != $_POST['date_from']){
				$this->gen_contents['datefrom'] = formatDate_search($this->input->post('date_from'));	
			}
			else if('' != $this->uri->segment(3))
			{
				$this->gen_contents['datefrom'] =$this->uri->segment(3);	
				
			}
			else if('' != $this->uri->segment(3) && 0 == $this->uri->segment(3))
			{
				$this->gen_contents['datefrom'] ='';	
			}
			else
			{
				$this->gen_contents['datefrom'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			}
			if(isset($_POST['date_to'])&& '' != $_POST['date_to']){
				$this->gen_contents['dateto'] = formatDate_search($this->input->post('date_to'));	
			}
			else if('' != $this->uri->segment(4))
			{
				$this->gen_contents['dateto'] =$this->uri->segment(4);
			}
			else
			{
				$this->gen_contents['dateto'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			}
			//print_r($this->gen_contents);die();
			$this->gen_contents['page_title']	=	'Orders';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_orders/list_order_details/'.$this->gen_contents['datefrom'].'/'.$this->gen_contents['dateto'];
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	5;
			$this->gen_contents["orders"]		=	$this->admin_order_model->select_orders($config['per_page'],$this->uri->segment(5),$this->gen_contents);
			$config['total_rows']   			= 	$this->admin_order_model->qry_count_orderdetails($this->gen_contents);
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_order_details',$this->gen_contents);
		}
		
		/**
		 * function to edit the course details
		 *
		 */
		function view_orders (){
			$this->orderid 	=	$this->uri->segment(3);
			$this->gen_contents['page_title']	=	'View Order Details';
			$this->gen_contents["orderdet"]		=	$this->admin_order_model->select_single_order_det($this->uri->segment(3));
//echo '<pre>';
//print_r($this->gen_contents["orderdet"]);
			$this->gen_contents["s_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["orderdet"]->s_state);
			$this->gen_contents["user"]		=	$this->admin_order_model->select_user_name($this->gen_contents["orderdet"]->userid);
			$this->_template('view_orders',$this->gen_contents);
		}
		/**
		 * function to get the course selected by a user
		 *
		 */
		function courses_in_order() {
			$this->gen_contents['page_title']	=	'Courses in an Order';
			$this->orderid 						= 	$this->uri->segment(3);
			$this->gen_contents["coursedetails"]=	$this->admin_order_model->select_single_order_course_details($this->orderid);
			$this->gen_contents["username"]		= 	$this->admin_user_model->select_single_userdetails($this->gen_contents["coursedetails"][0]->userid);
			$this->_template('order_course_details',$this->gen_contents);
		}
		
		function label_print(){
		
			 $id = $this->uri->segment(3);
			 $this->gen_contents["orderdet"]		=	$this->admin_order_model->select_single_order_det($this->uri->segment(3));
			 //print_r();
			$this->gen_contents["img"]				=   $this->gen_contents["orderdet"]->label_path;
			if($this->gen_contents["orderdet"]->label_path !=''){
			$this->load->view('admin/order/view_label', $this->gen_contents);
			}else{
			  $this->load->view('admin/order/label_error', $this->gen_contents);
			}
		
	  }
					
	}	
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */