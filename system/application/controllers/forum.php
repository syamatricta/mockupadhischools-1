<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		soumya
 * @link		http://ahischools.com/user/
 */

// ------------------------------------------------------------------------

class Forum extends Controller {

		var $gen_contents = array();
	
		function Forum(){
		parent::Controller();
						
			//$this->load->model('Common_model');
            $this->load->model('user_model');
            require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            // require_once $site_basepath.'system/application/libraries/vbintegration.php';
			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css');
			$this->gen_contents['js'] = array('userdetails.js','popcalendar.js','client_login.js');
			$this->load->model('admin_sitepage_model');
			
		}
	
		function index() {

			//$this->load->model('user_model');
			 
            require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            
			if($this->authentication->logged_in("normal")){
				$f_uname=$this->session->userdata ('EMAIL');
				$this->user_model->vb_login($f_uname);
				//$this->gen_contents['forum']	=	"<script>window.open('http://192.168.0.122/adhischools/trunk/forums/')</script>";
				//echo "<script>window.open('http://192.168.0.122/adhischools/trunk/forums/')</script>";
				//redirect("profile");		
				//redirect($this->config->item('site_baseurl').'forums/','target="_blank"');
				//echo anchor('http://192.168.0.122/adhischools/trunk/forums/','Forum','target=_blank');
			}
			else {
				
				//redirect("forums");
				//echo anchor('http://192.168.0.122/adhischools/trunk/forums/','Forum','target="_blank"');
			}
			
		}
		
	
		
		
}
?>
