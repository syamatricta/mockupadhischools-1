<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Admin_sitepage_model extends Model{
	function Admin_sitepage_model ()
	{
		parent::Model ();
	}  
	/**
	 * function to select the sitepage details
	 *
	 * @return sitedetails
	 */
	function select_sitepages ($num,$offset = 0) {
		
		$this->db->select ("*");
		$this->db->from('adhi_sitepage');
	    $this->db->limit($num,$offset);
	    $query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of sitepage details
	 *
	 * @return count of sitepages
	 */
	function qry_count_sitepages (){
		$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_sitepage");
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
	function select_single_sitepage_det($sitepageid) {
		$this->db->where('id',$sitepageid);
		$this->db->select ("*");
		$this->db->from('adhi_sitepage');
	    $query	=	$this->db->get();
		return($query->row());
	}
	function update_sitepage_det($details){
		$this->db->where('id', $details['sitepageid']);
		$details	=	  array('title' 	=>	$details['title'],
								'content' 	=>	$details['content'],
								'updated_on'=>	date('Y-m-d h:i:s')
								);
		$updates	=	$this->db->update('adhi_sitepage', $details);
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	function select_single_sitepage_details($siteurl) {
		$this->db->where('name',$siteurl);
		$this->db->select ("*");
		$this->db->from('adhi_sitepage');
	    $query	=	$this->db->get();
		return($query->row());
	}
	function select_sitepages_url(){
		$this->db->select ("*");
		$this->db->from('adhi_sitepage');
	    $query	=	$this->db->get();
		return($query->result());
	}
	
	/**
	 * function to select the sitepage details
	 *
	 * @return sitedetails
	 */
	function select_banners ($num,$offset = 0,$banner_id = '') {
		
		$this->db->select ("*");
		$this->db->from('adhi_banner_sitepages');
		if($banner_id != '')
			$this->db->where('banner_id',$banner_id);
	    $this->db->limit($num,$offset);
	    $query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of sitepage details
	 *
	 * @return count of sitepages
	 */
	function qry_count_banners (){
		$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_banner_sitepages");
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
	
	function get_sitepages () {
		$this->db->select('id,title');
		$this->db->from('adhi_sitepage');
		$query	=	$this->db->get();
		if($query->num_rows() > 0)
			return($query->result_array());
		return array();
		
	}
	
	function save_banner_details ($banner_data) {
		$this->db->set($banner_data);		
		if ($this->db->insert('adhi_banner_sitepages')){
			return $this->db->insert_id();		
		}		
		return false;
	}
	
	function get_banners () {
		$this->db->select('banner_id,banner_title,banner_short_dec,banner_image,banner_created_date,sitepage_id,banner_long_desc');
		$this->db->from('adhi_banner_sitepages');
		$this->db->order_by('banner_created_date','DESC');
		$this->db->limit(5,0);
		$query	=	$this->db->get();
		if($query->num_rows() > 0)
			return($query->result_array());
		return array();			
	}
	
	function get_already_used_banners ($banner_id = 0){
		$this->db->select('sit.id,sit.name');
		$this->db->where('bs.banner_id != ',$banner_id);
		$this->db->from('adhi_banner_sitepages bs');
		$this->db->join('adhi_sitepage sit','sit.id = bs.sitepage_id');
		$query = $this->db->get();
		$select_box_array = array();
		$records = $query->result_array();
		for($i = 0; $i < count($records); $i++){
		 	$select_box_array[$records[$i]['id']] = $records[$i]['name'];
		}
		return $select_box_array;
	}
	
	function delete_banner ($banner_id) {
		if((int)$banner_id > 0) {
			$this->db->where('banner_id',$banner_id);
			if($this->db->delete('adhi_banner_sitepages')) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function update_banner_details ($banner_data,$banner_id) {
		$this->db->set($banner_data);		
		$this->db->where('banner_id',$banner_id);
		if ($this->db->update('adhi_banner_sitepages')){
			return $banner_id;
		}		
		return false;
	}
	function select_single_sitepage_details_from_id($sitepage_id) {
		$this->db->where('id',$sitepage_id);
		$this->db->select ("*");
		$this->db->from('adhi_sitepage');
	    $query	=	$this->db->get();
		return($query->row());
	}
        /**
	 * Function to get Latitude and Longitude of a postcode
	 * @param string $search_str
	 * @return array()
	 */
	function getPostcodeLatitudeLongitude($search_str=''){
		$this->db->limit(1);
		$this->db->order_by('id','asc');
		$this->db->select('co_lattitude,co_longitude');
		/*if(strlen($search_str) >= 3 ){
			$this->db->like('co_postcode',$search_str,'after');
		}else{
			$this->db->where('co_postcode',$search_str);
		}*/
		$query	=	$this->db->get('adhi_broker_placement');
		return ($query->num_rows()) ? $query->row() : array();
	}
        /**
	 * Function to get shortest Garage details with Latitude and Longitude
	 * @param double $latitude
	 * @param double $longitude
	 * @return array();
	 */
	function getPostcodeSearchData($latitude='',$longitude='',$filter_car_manufacture='',$filter_online_booking='',$filter_service_offered='',$offset ='', $limit =''){
		if($latitude && $longitude){
			$this->db->select('id,sub_postcode,co_lattitude,co_longitude');
                        $this->db->where('sub_postcode !=','');
                        $query	=	$this->db->get('adhi_broker_placement');
			//return $query->result();
                        return ($query->num_rows()) ? $query->result(): array();
		}

	}
        function getcntdetails($search_str=''){
		$this->db->limit(1);
		$this->db->order_by('id');
		$this->db->select('*');
		/*if(strlen($search_str) >= 3 ){
			$this->db->like('subregion_address',$search_str,'after');
		}else{*/
			$this->db->like('sub_postcode',$search_str,'both');
		//}
		$query	=	$this->db->get('adhi_broker_placement');
		return ($query->num_rows()) ? $query->row() : array();
	}

        function select_faq ($num,$offset = 0,$fq_id = '') {

		$this->db->select ("*");
                $this->db->order_by('fq_id','DESC');
		$this->db->from('adhi_faq_sitepages');
		if($fq_id != '')
			$this->db->where('fq_id',$fq_id);
	    $this->db->limit($num,$offset);
	    $query	=	$this->db->get();
		return($query->result());
	}
        function select_faq_det ($search_faq = "") {

		$this->db->select ("*");
                $this->db->order_by('fq_id');
		$this->db->from('adhi_faq_sitepages');
                
                if($search_faq != '') {
					$this->db->like('fq_question',$search_faq);
					$this->db->or_like('fq_answer',$search_faq);
                }
                    
		$query	=	$this->db->get();
		return($query->result());
	}
        function qry_count_faq (){
		$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_faq_sitepages");
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
        function save_faq_details ($faq_data) {
		$this->db->set($faq_data);
		if ($this->db->insert('adhi_faq_sitepages')){
			return $this->db->insert_id();
		}
		return false;
	}
        function update_faq_details ($faq_data,$faq_id) {
		$this->db->set($faq_data);
		$this->db->where('fq_id',$faq_id);
		if ($this->db->update('adhi_faq_sitepages')){
			return $faq_id;
		}
		return false;
	}
        function delete_faq ($faq_id) {
		if((int)$faq_id > 0) {
			$this->db->where('fq_id',$faq_id);
			if($this->db->delete('adhi_faq_sitepages')) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
        function select_brokerplacement ($num,$offset = 0,$brokerplacement_id = '') {

		$this->db->select ("*");
                $this->db->order_by('id');
		$this->db->from('adhi_broker_placement');
		if($brokerplacement_id != '')
			$this->db->where('id',$brokerplacement_id);
	    $this->db->limit($num,$offset);
	    $query	=	$this->db->get();
		return($query->result());
	}
        function qry_count_brokerplacement (){
		$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_broker_placement");
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
         function save_brokerplacement_details ($brokerplacement_data) {
		$this->db->set($brokerplacement_data);
		if ($this->db->insert('adhi_broker_placement')){
			return $this->db->insert_id();
		}
		return false;
	}
        function update_brokerplacement_details ($brokerplacement_data,$brokerplacement_id) {
		$this->db->set($brokerplacement_data);
		$this->db->where('id',$brokerplacement_id);
		if ($this->db->update('adhi_broker_placement')){
			return $brokerplacement_id;
		}
		return false;
	}
        function delete_brokerplacement ($brokerplacement_id) {
		if((int)$brokerplacement_id > 0) {
			$this->db->where('id',$brokerplacement_id);
			if($this->db->delete('adhi_broker_placement')) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
        function update_twitter_data($details){
               	$this->db->set($details);
                $this->db->where('tw_id','1');
		if ($this->db->update('adhi_twitter_data')){
			return $this->db->insert_id();
		}
		return false;
	}
        function get_twitter_data(){
		$this->db->select ("*");
               	$this->db->from('adhi_twitter_data');
		$query	=	$this->db->get();
		$result=$query->result_array();
		if(!empty($result)){
                  
		$twdata=$result[0]['twitter_data'];
		return 	$twdata;
		}else{
			return false;
		}
	}
        
        /*
        function test_enroll_check(){

            $this->db->select('auc.userid,asd.firstname,asd.lastname,asd.emailid,auc.courseid,auc.enrolled_date,auc.delivered_date,ac.course_name');
            $this->db->where('auc.delivered_date != ','0000-00-00');
            //$this->db->where('auc.delivered_date <','auc.enrolled_date');
            //$this->db->where('asd.firstname !=', 'Syama');
            $this->db->from('adhi_user_course auc');
            $this->db->join('adhi_user asd','asd.id = auc.userid');
            $this->db->join('adhi_courses ac','ac.id = auc.courseid');
            $result = $this->db->get();
            $res = $result->result_array();
            
            if(!empty($res)){
                foreach($res as $key => $r){
                    if(strtotime($r['delivered_date']) >= strtotime($r['enrolled_date'])){
                        unset($res[$key]);
                    }
                    if($r['firstname'] == 'smruthy' || $r['firstname'] == 'Saji' || $r['firstname'] == 'Sam' || $r['firstname'] == 'soumya' || $r['firstname'] == 'manu'){
                        unset($res[$key]);
                    }
                    
                    if($r['emailid'] == 'sam027@gmail.com'){
                        unset($res[$key]);
                    }
                }
            }
            
            print '<pre>';
            echo '<b> There are '.count($res).' records where enrolled date is above the delivered date.</b> <br/> <br/>';
            $i = 1;
             if(!empty($res)){ ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name </td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Course Name</td>
                    <td colspan="2"> Enrolled Date </td>
                    <td colspan="2"> Delivered Date </td>
                </tr>
                <?php foreach($res as $key => $r){ ?>
                <tr> 
                    <td colspan="2"> <?php echo $i; ?> </td>
                    <td colspan="2"> <?php echo $r['firstname'].' '.$r['lastname']; ?> </td>
                    <td colspan="2"> <?php echo $r['emailid']; ?> </td>
                    <td colspan="2"> <?php echo $r['course_name']; ?> </td>
                    <td colspan="2"> <?php echo $r['enrolled_date']; ?> </td>
                    <td colspan="2"> <?php echo $r['delivered_date']; ?> </td>
                </tr>   
                <?php $i++; }?>
                </table> <?php
             }
            exit;
        }
         * 
         */
}
