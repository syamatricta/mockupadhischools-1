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

class Admin_schedule_model extends Model{
	function Admin_schedule_model ()
	{
		parent::Model ();
		//$this->output->enable_profiler();
	}  
	
	/**
	 * function to select the order details
	 */
	function dbSelectAllSubRegions () {
		
		$this->db->select ("subregion_name AS sub_name,sub.id AS id,region.region_name AS region,region.id AS regionid");
		$this->db->from ('adhi_subregion AS sub');
		$this->db->join ('adhi_region AS region','region.id=sub.region_id');
	    $this->db->orderby ('region.region_name','ASC');
		$query	= $this->db->get();
		return($query->result());
	}
	
	/**
	 * function to select the order details
	 */
	function dbSelectAllRegions () {
		
		$this->db->select ("*");
		$this->db->from('adhi_region');
	    $this->db->orderby('region_name','ASC');
		$query	=	$this->db->get();
		return($query->result());
	}
	
	
	/**
	 * get single sub region
	 */
	function dbSelectSingleSubRegion($id){
		
		$this->db->select ("subregion_name AS sub_name,sub.id AS id,region.region_name AS region,region.id AS regionid");
		$this->db->select ("subregion_description,image_name,subregion_address");
		$this->db->where ('sub.id', $id);
		$this->db->from('adhi_subregion AS sub');
		$this->db->join ('adhi_region AS region','region.id=sub.region_id');
		$query	=	$this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function dbInsertEventMaster($arr_value,$arr_sub_value){
		$this->db->set($arr_value);
		$this->db->insert('adhi_events_master'); 
		$master_id 	= $this->db->insert_id();
		if($master_id){
			
			foreach($arr_sub_value['arr_date'] as $val){
				$start 	= $val.' '.$arr_value['time_start'];
				$end	= $val.' '.$arr_value['time_end'];
				$this->db->set('events_master_id',$master_id);
				$this->db->set('start',$start);
				$this->db->set('end',$end);
				$this->db->insert('adhi_events'); 
				$sub_id 	= $this->db->insert_id();
				
				if(!$sub_id)
					return false;
			}
			
		}else{
			return FALSE;
		}
		return TRUE;
	}
	
	function dbGetMonthlyEventDetails($first_day,$last_day,$region_id=0,$subregion_id=0){
		$this->db->select ("subregion_name  AS subregion, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
		
		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);
		
		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
			
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		
		$query	= $this->db->get();
		$result = $query->result();
		
		if($query->num_rows()>0){
			
			$arr_day = array();
			foreach($result as $val){
				
				$arr_day[trim(sprintf('%2d',$val->day_no))] = $val;
			}
			
			return $arr_day;
			
		}else{
			
			return false;
		}
	}
        function dbGetMonthlyEventDetailsUser($first_day,$last_day,$region_id=0,$subregion_id=0,$course_id=0){
		$this->db->select ("subregion_name  AS subregion, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);

		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);

		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
                if($course_id && $course_id!=0)
			$this->db->where ("master.course_id", $course_id);

		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
		$result = $query->result();

		if($query->num_rows()>0){

			$arr_day = array();
			foreach($result as $val){

				$arr_day[trim(sprintf('%2d',$val->day_no))] = $val;
			}

			return $arr_day;

		}else{

			return false;
		}
	}
         function dbGetMonthlyEventDetailsUserclr($first_day,$last_day,$region_id=0,$subregion_id=0,$course_id=0){
                $evn_clr_list=array();
		$this->db->select ("course_id, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);

		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);

		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
                if($course_id && $course_id!=0)
			$this->db->where ("master.course_id", $course_id);

		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
		$result = $query->result();
                //echo $this->db->last_query();

		if($query->num_rows()>0){

			$arr_day = array();
                        foreach($result as $val){
                            $arr_day[trim(sprintf('%2d',$val->day_no))]='';
                        }
			foreach($result as $val){

				$arr_day[trim(sprintf('%2d',$val->day_no))] .= ($arr_day[trim(sprintf('%2d',$val->day_no))])?',':'';
                                $arr_day[trim(sprintf('%2d',$val->day_no))] .= ($val->course_id)?$val->course_id:'';
			}

			return $arr_day;

		}else{

			return false;
		}
	}
	
	function dbGetEventListWithSearch($post_val){
		
		$this->db->select ("sub.id as sub_id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, sub.events_master_id AS master_id, DATE_FORMAT(master.time_start,'%h:%i') AS time_start");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, DATE_FORMAT(master.time_end,'%h:%i') AS time_end");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($post_val['datecurrent'])));
		
		if($post_val['subregion_id'])
			$this->db->where ("subregion_id ", $post_val['subregion_id']);
		
		if($post_val['region_id'])
			$this->db->where ("region_id ", $post_val['region_id']);
			
		$this->db->from ("adhi_events AS sub");	
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		
		$query	= $this->db->get();
		$result = $query->result();
		return $result;
	}
	function dbGetEventListWithSearchUser($post_val,$chp_list=array()){

		$this->db->select ("sub.id as sub_id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, sub.events_master_id AS master_id, DATE_FORMAT(master.time_start,'%h:%i') AS time_start");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, DATE_FORMAT(master.time_end,'%h:%i') AS time_end");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($post_val['datecurrent'])));

		if($post_val['subregion_id'])
			$this->db->where ("subregion_id ", $post_val['subregion_id']);

		if($post_val['region_id'])
			$this->db->where ("region_id ", $post_val['region_id']);
                if($post_val['course'])
			$this->db->where ("course_id ", $post_val['course']);
                if($post_val['course']==5){
                    if($post_val['chp']){
                        $chp=$chp_list[$post_val['chp']];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
                //echo $this->db->last_query();
		$result = $query->result();
		return $result;
	}
        function dbGetEventListWithSearchUsercal(){

		$this->db->select ("sub.id as sub_id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, sub.events_master_id AS master_id, DATE_FORMAT(master.time_start,'%h:%i') AS time_start");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, DATE_FORMAT(master.time_end,'%h:%i') AS time_end");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($post_val['datecurrent'])));

		if($post_val['subregion_id'])
			$this->db->where ("subregion_id ", $post_val['subregion_id']);

		if($post_val['region_id'])
			$this->db->where ("region_id ", $post_val['region_id']);
                if($post_val['course'])
			$this->db->where ("course_id ", $post_val['course']);
                if($post_val['course']==5){
                    if($post_val['chp']){
                        $chp=$chp_list[$post_val['chp']];echo $chp;
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
                //echo $this->db->last_query();
		$result = $query->result();
		return $result;
	}
	function dbGetSingleEventDetails($master_id){
		$this->db->select ("master.id,master.course_id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, DATE_FORMAT(master.time_start,'%h') AS start_hr");
		$this->db->select ("DATE_FORMAT(master.time_start,'%i') AS start_mts, DATE_FORMAT(master.time_end,'%h') AS end_hr,DATE_FORMAT(master.time_end,'%i') AS end_mts");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, chapter_description AS descp");
		$this->db->select ("region_id,subregion_id,image_name,subregion_description,subregion_address");
		$this->db->select ("(SELECT course_name FROM adhi_courses WHERE adhi_courses.id=master.course_id ) as crsname");
                $this->db->where ("master.id ", $master_id);
		$this->db->from ("adhi_events_master AS master");	
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$query	= $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function dbDeleteEventDetails($master_id){
		$this->db->where('id', $master_id);
		if($this->db->delete('adhi_events_master')){
			$this->db->where('events_master_id', $master_id);
			if($this->db->delete('adhi_events'))
				return TRUE;
		}else 	
			return FALSE;
	}
	
	/* user home page image display*/
	
	function dbGetTonitesClasslist($date,$num = 5,$offset = 0){
		
		$this->db->select ("region_id ,subregion_id, subregion.subregion_name AS subregion, region.region_name AS region");
		$this->db->select ("subregion.image_name AS image");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$this->db->distinct();
		$this->db->limit($num,$offset);
		$query	= $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	
	function dbGetCountTonitesClasslist ($date) {
		$this->db->select ("subregion_id,region_id , subregion.subregion_name AS subregion, region.region_name AS region");
		$this->db->select ("subregion.image_name AS image");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$this->db->distinct();
		$query	= $this->db->get();
		return $query->num_rows();
	}
	
	function dbGetClassDetailsForSubregion($subregion,$dated){
		$this->db->select ("master.id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, DATE_FORMAT(master.time_start,'%h') AS start_hr",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%i') AS start_mts, DATE_FORMAT(master.time_end,'%h') AS end_hr,DATE_FORMAT(master.time_end,'%i') AS end_mts");
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, chapter_description AS descp");
		if(isset($subregion))
			$this->db->where ("subregion_id",$subregion);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($dated)));
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$query		= $this->db->get();
		$result 	= $query->result();
		return $result;
	}
        /**
	 * function to select the course
	 */
	function dbSelectAllCourses () {

		$this->db->select ("*");
		$this->db->from('adhi_courses');
	        $this->db->orderby('id','ASC');
		$query	=	$this->db->get();
		return($query->result());
	}
         /**
	 * function to select the course
	 */
	function dbSelectSelcCoursesDetails ($courseid) {

		$this->db->select ("*");
                $this->db->where ("id", $courseid);
		$this->db->from('adhi_courses');
	        $this->db->orderby('id','ASC');
		$query	=	$this->db->get();
		$res=$query->row();
                return $res;
	}

}