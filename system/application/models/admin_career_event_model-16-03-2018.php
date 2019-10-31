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

class Admin_career_event_model extends Model{
	function Admin_career_event_model ()
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
	
	function dbInsertEventMaster($arr_value, $arr_sub_value){
		$this->db->set($arr_value);
		$this->db->insert('adhi_career_events_master'); 
		$master_id 	= $this->db->insert_id();
		if($master_id){
			
			foreach($arr_sub_value['arr_date'] as $val){
				$start 	= $val.' '.$arr_value['time_start'];
				$end	= $val.' '.$arr_value['time_end'];
				$events = array();
				$events['events_master_id'] = $master_id;
				//$events['totalcapacity']    = $arr_sub_value['tot_capacity'];
				$events['start']    = $start;
				$events['end']      = $end;
				//$this->db->set('events_master_id',$master_id);
				//$this->db->set('totalcapacity',$arr_sub_value['tot_capacity']);
				//$this->db->set('start',$start);
				//$this->db->set('end',$end);
				$this->db->set($events);	
				
				$this->db->insert('adhi_career_events');
				$sub_id 	= $this->db->insert_id();
				
				if(!$sub_id)
					return false;
			}
			
		}else{
			return FALSE;
		}
		return array($master_id,$sub_id);
	}
	function dbInsertEventMasterCCO($arr_value,$arr_sub_value){
		 
            $DB2 	= $this->load->database('cco', TRUE);
            $DB2->set($arr_value);
            $DB2->insert('cc_location'); 
            $master_id 	= $DB2->insert_id();
        
            if($master_id){
 return false;
                foreach($arr_sub_value['arr_date'] as $val){
                    $start 	= $val.' '.$arr_value['time_start'];
                    $end	= $val.' '.$arr_value['time_end'];
                    $DB2->set('location_id',$master_id);
                    $DB2->set('totalcapacity',$arr_sub_value['tot_capacity']);
                    $DB2->set('events_id',$arr_sub_value['events_id']);
                    $DB2->set('start',$start);
                    $DB2->set('end',$end);
                    $DB2->insert('cc_location_events');
                    $sub_id 	= $DB2->insert_id();

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
			
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
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
        
        
        function dbGetCoursesByDate($first_day, $last_day, $region_id=0, $sub_region=0) {
            $this->db->select ("master.id , title,  DATE_FORMAT(start, '%Y/%m/%d') as start,  DATE_FORMAT(end, '%Y/%m/%d') as end",FALSE);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    $this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($region_id && $region_id!=0)
            {    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0)
            {
                $this->db->where ("master.subregion_id", $sub_region);
            } 
                
            $this->db->from ("adhi_career_events_master AS master");
            $this->db->join ('adhi_career_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $this->db->distinct();
           // $this->db->groupby("crs.id");
            $query	= $this->db->get();
	    return($query->result());
            //echo $this->db->last_query();
        }
        
	function dbGetCoursesByDateMobile($first_day, $last_day, $region_id=0, $sub_region=0) {
            $this->db->select ("master.id ,master.title,  DATE_FORMAT(start, '%Y/%m/%d') as start,  DATE_FORMAT(end, '%Y/%m/%d') as end",FALSE);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    $this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($region_id && $region_id!=0){    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0){
                $this->db->where ("master.subregion_id", $sub_region);
            } 
            
                
            $this->db->from ('adhi_career_events_master AS master');
            $this->db->join ('adhi_career_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $this->db->distinct();
            $where_clause = $this->db->_compile_select();
            $this->db->_reset_select();
            $sql = "select count(final.ID)  as title ,final.start,final.end from(".$where_clause.") final GROUP BY final.start";
            $query  = $this->db->query($sql,false); 
            $res = $query->result();
            foreach ($res as $key => &$value) {
                $value->title = $value->title== 1 ? $value->title.' Event':$value->title.' Events';
            }
	    return($res);
        }	
        function dbGetCoursesByDateMobile1($first_day,$last_day, $region_id=0, $sub_region=0) {
            $this->db->select ("master.id, master.title,  DATE_FORMAT(start, '%Y/%m/%d') as start,  DATE_FORMAT(end, '%Y/%m/%d') as end",FALSE);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    $this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($region_id && $region_id!=0){    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0){
                $this->db->where ("master.subregion_id", $sub_region);
            }
                
            $this->db->from ("adhi_career_events_master AS master");
            $this->db->join ('adhi_career_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $this->db->groupby("master.id");
            $query	= $this->db->get();
	    return($query->result());
            
        }
        function dbClasslistandlocation($date, $region_id=0, $sub_region=0){
            $this->db->select ("master.id, region_id ,subregion_id, subregion.subregion_name AS subregion, subregion.subregion_address AS subaddress,
                subregion.subregion_description as subregion_description,region.region_name AS region, title, master.description, master.parking_info");
            $this->db->select ("subregion.image_name AS image, description AS descp");
            $this->db->select ("DATE_FORMAT(master.time_start,'%h:%i %p') AS start_time, DATE_FORMAT(master.time_end,'%h:%i %p') AS end_time",false);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
	
	    if($region_id && $region_id!=0){    
	        $this->db->where ("region.id", $region_id);
	    }
	    if($sub_region && $sub_region!=0){
	        $this->db->where ("master.subregion_id", $sub_region);
	    } 
	   
            $this->db->from ("adhi_career_events AS sub");
            $this->db->join ('adhi_career_events_master AS master','master.id 	= sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $query	= $this->db->get();
            $result = $query->result();
            return $result;
	}
        function dbGetMonthlyCourses($first_day, $last_day, $region_id=0, $sub_region=0) {
            $this->db->select ("master.id, master.title");
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    	$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            
            if($region_id && $region_id!=0)
            {    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0)
            {
                $this->db->where ("master.subregion_id", $sub_region);
            } 
                
            $this->db->from ("adhi_career_events_master AS master");
            $this->db->join ('adhi_career_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            
            $this->db->groupby("crs.id");
            $query	= $this->db->get();
	    return($query->result());
            //echo $this->db->last_query();
        }
        
        function dbGetMonthlyEventDetailsUser($first_day,$last_day,$region_id=0,$subregion_id=0){
		$this->db->select ("subregion_name  AS subregion, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);

		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);

		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
                
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
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

        function dbGetMonthlyEventDetailsUserclr($first_day,$last_day,$region_id=0,$subregion_id=0){
                $evn_clr_list=array();
		$this->db->select ("course_id, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);

		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);

		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
                
                $this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
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
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, DATE_FORMAT(master.time_end,'%h:%i') AS time_end,master.title, master.description");
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($post_val['datecurrent'])));
		
		if($post_val['subregion_id'])
			$this->db->where ("subregion_id ", $post_val['subregion_id']);
		
		if($post_val['region_id'])
			$this->db->where ("region_id ", $post_val['region_id']);
                
			
		$this->db->from ("adhi_career_events AS sub");	
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
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
		$this->db->select ("(SELECT course_name FROM adhi_courses WHERE adhi_courses.id=master.course_id ) as crsname");
                $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($post_val['datecurrent'])));

		if($post_val['subregion_id'])
			$this->db->where ("subregion_id ", $post_val['subregion_id']);

		if($post_val['region_id'])
			$this->db->where ("region_id ", $post_val['region_id']);
                if($post_val['course'])
			//$this->db->where ("course_id ", $post_val['course']);
                if($post_val['course']==5){
                    if($post_val['chp']){
                        $chp=$chp_list[$post_val['chp']];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
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
			//$this->db->where ("course_id ", $post_val['course']);
                if($post_val['course']==5){
                    if($post_val['chp']){
                        $chp=$chp_list[$post_val['chp']];echo $chp;
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id = sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
                //echo $this->db->last_query();
		$result = $query->result();
		return $result;
	}






	function dbGetSingleEventDetails($master_id){
		$this->db->select ("master.id,master.title, master.parking_info, DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, DATE_FORMAT(master.time_start,'%h') AS start_hr");
		$this->db->select ("DATE_FORMAT(master.time_start,'%i') AS start_mts, DATE_FORMAT(master.time_end,'%h') AS end_hr,DATE_FORMAT(master.time_end,'%i') AS end_mts");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, description AS descp");
		$this->db->select ("region_id,subregion_id,image_name,subregion_description,subregion_address");
		$this->db->where ("master.id ", $master_id);
		$this->db->from ("adhi_career_events_master AS master");	
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$query	= $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function dbDeleteEventDetails($master_id){
		$this->db->where('id', $master_id);
		if($this->db->delete('adhi_career_events_master')){
			$this->db->where('events_master_id', $master_id);
			if($this->db->delete('adhi_career_events')){
				$this->db->where('events_master_id', $master_id);
				$this->db->where('coo', 0);
				$this->db->delete('adhi_instructor_log');
				return TRUE;
			}
				
		}else 	
			return FALSE;
	}
	function dbDeleteEventDetailsCCO($master_id){
		$DB2 	= $this->load->database('cco', TRUE);        
		$DB2->where('events_master_id', $master_id);
		if($DB2->delete('cc_location')){
			return TRUE;
		}else 	
			return FALSE;
	}
	/* user home page image display*/
	
	function dbGetTonitesClasslist($date,$num = 5,$offset = 0, $view='paginated'){
		
		$this->db->select ("master.id, master.title, master.description as descp, region_id ,subregion_id, subregion.subregion_name AS subregion, subregion.subregion_description as subregion_description, 
                                                subregion.subregion_address AS subaddress,region.region_name AS region ,
                                                subregion.image_name AS image
                                                ");
		$this->db->select ("DATE_FORMAT(master.time_start,'%h:%i %p') AS start_time, DATE_FORMAT(master.time_end,'%h:%i %p') AS end_time", false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		//$this->db->distinct();
		if($view=='paginated')
                    $this->db->limit($num,$offset);

		$query	= $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	
	function dbGetCountTonitesClasslist ($date) {		
		$this->db->select ("subregion_id,region_id , subregion.subregion_name AS subregion, region.region_name AS region");
		$this->db->select ("subregion.image_name AS image");		
		$this->db->where  ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		$this->db->from   ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$this->db->distinct();
		$query	= $this->db->get();
		return $query->num_rows();
	}
	
	function dbGetClassDetailsForSubregion($subregion,$dated){
		$this->db->select ("master.id,master.course_id,(select course_name from adhi_courses where id = master.course_id) as course, DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, DATE_FORMAT(master.time_start,'%h') AS start_hr",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%i') AS start_mts, DATE_FORMAT(master.time_end,'%h') AS end_hr,DATE_FORMAT(master.time_end,'%i') AS end_mts");
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, chapter_description AS descp");
		if(isset($subregion))
			$this->db->where ("subregion_id",$subregion);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($dated)));
		$this->db->from ("adhi_career_events AS sub");
		$this->db->join ('adhi_career_events_master AS master','master.id 	= sub.events_master_id');
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
                $this->db->where ("exam_status",'E');
                $this->db->where("parent_course_id",0);
                $this->db->or_where("parent_course_id",1);
                $this->db->orderby('id','ASC');
		$query	=	$this->db->get();
		return($query->result());
	}
	
	function dbSelectAllInstructors(){
		$this->db->select ("id,name");
		$this->db->from('adhi_meet_staff');
        
		$query	=	$this->db->get();
		return($query->result());
	}
        /**
	 * function to select the course
	 */
	function dbSelectAllCoursesarr () {

		$this->db->select ("*");
                 //$this->db->where ("exam_status",'E');
		$this->db->from('adhi_courses');
	        $this->db->orderby('id','ASC');
		$query	=	$this->db->get();
		return($query->result_array());
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
        
         /**
	 * function to select the crashcouse id
	 */
	function dbSelectSelcCrashCourse () {

		$this->db->select ("id");
                $this->db->where (array('course_name' => 'Crash Course', 'exam_status' => 'E'));
		$this->db->from('adhi_courses');
		$query	=	$this->db->get();
		$res=$query->row();
                return $res;
	}
        
        function saveBooking($data){
            if($this->db->insert('adhi_career_event_bookings', $data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
            
        }
        
        function hasBookedEarly($event_id, $where){
            $this->db->where('event_id', $event_id);
            $this->db->where($where);
            $query  = $this->db->get('adhi_career_event_bookings');
            return $query->row();
	}
        
        function isEventExist($event_id){
            $this->db->select ("master.*, region.region_name, subregion.subregion_name, subregion.subregion_address");
            $this->db->where('master.id', $event_id);
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $query  = $this->db->get('adhi_career_events_master master');
            return $query->row();
        }
        
        function getAllBookings($search_params, $type = 'count', $num = 0, $offset = 0){
            $this->db->select ("bookings.*, ce.title as event_name, ce.date, ");
            $this->db->from('adhi_career_event_bookings bookings');
            $this->db->join('adhi_career_events_master ce', 'bookings.event_id=ce.id');
            $this->db->join('adhi_subregion subregion', 'ce.subregion_id=subregion.id');	    
	    if($search_params['event_id'] > 0){
	    	$this->db->where('bookings.event_id', $search_params['event_id']);
            }
            if('' != $search_params['first_name']){
	    	$this->db->like('bookings.first_name', $search_params['first_name'], 'both');
            }
	    if('' != $search_params['last_name']){
	    	$this->db->like('bookings.last_name', $search_params['last_name'], 'both');
            }
	    if('' != $search_params['email']){
	    	$this->db->like('bookings.email', $search_params['email'], 'both');
            }            
            if('' != $search_params['phone']){
                $this->db->where('bookings.phone', $search_params['phone']);
            }
            if('count' == $type){
                $query	= $this->db->get();                
                return $query->num_rows();
            }else{                
                $this->db->orderby('bookings.created_at','DESC');
                if( 'list' == $type){
                    $this->db->limit($num, $offset);
                }
                $query	= $this->db->get();
                return $query->result();
            }
            
        }
        
        function getAllEvents () {
		$this->db->select ("*");
		$this->db->from('adhi_career_events_master');
                $this->db->where ("status", 1);
                $this->db->orderby('title','ASC');
		$query	=	$this->db->get();
		return($query->result());
	}
	
        
        
}