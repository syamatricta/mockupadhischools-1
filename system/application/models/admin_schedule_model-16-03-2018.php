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
	
	function dbInsertEventMaster($arr_value,$arr_sub_value, $chapters_with_date = array()){
		
                if(count($chapters_with_date) > 0 && 5 == $arr_value['course_id']){
                    $master_id = '';
                    $group_master_id = 0;
                    foreach ($chapters_with_date as $chapter_date){
                        $arr_value['date']                  = $chapter_date['date'];
                        $arr_value['schedule_chapter_id']   = $chapter_date['schedule_chapter_id'];
                        $arr_value['chapter_description']   = $chapter_date['desc'];
                        $arr_value['group_master_id']   = $group_master_id;
                        $this->db->set($arr_value);
                        $this->db->insert('adhi_events_master'); 
                        $master_id 	= $this->db->insert_id();
                        if(0 == $group_master_id){
                            $group_master_id 	= $master_id;
                            $this->db->set('group_master_id', $group_master_id);
                            $this->db->where('id', $master_id);
                            $this->db->update('adhi_events_master'); 
                        }
                        
                        $arr_sub_value['arr_date'] = array($arr_value['date']);
                        $sub_id = $this->insertEventDates($master_id, $arr_value, $arr_sub_value);
                    }
                }else{
                    $this->db->set($arr_value);
                    $this->db->insert('adhi_events_master'); 
                    $master_id 	= $this->db->insert_id();
                    $sub_id = $this->insertEventDates($master_id, $arr_value, $arr_sub_value );
                }
		
		return array($master_id, $sub_id);
	}
        
        function insertEventDates($master_id, $arr_value, $arr_sub_value ){
            if($master_id){
                    foreach($arr_sub_value['arr_date'] as $key => $val){
                            $start 	= $val.' '.$arr_value['time_start'];
                            $end	= $val.' '.$arr_value['time_end'];
                            $events = array();
                            $events['events_master_id'] =$master_id;
                            $events['totalcapacity'] =$arr_sub_value['tot_capacity'];                            
                            $events['start'] =$start;
                            $events['end'] =$end;
                            //$this->db->set('events_master_id',$master_id);
                            //$this->db->set('totalcapacity',$arr_sub_value['tot_capacity']);
                            //$this->db->set('start',$start);
                            //$this->db->set('end',$end);
                            $this->db->set($events);	

                            $this->db->insert('adhi_events');
                            $sub_id 	= $this->db->insert_id();
                            $events['instructor_id'] =$arr_sub_value['instructor_id'];
                            $events['coo'] =0;
                            $this->db->set($events);
                            $this->db->insert('adhi_instructor_log');


                            if(!$sub_id)
                                    return false;
                    }

            }else{
                    return FALSE;
            }
            return $sub_id;
        }
        
	function dbInsertEventMasterCCO($arr_value,$arr_sub_value){
		 
		$DB2 	= $this->load->database('cco', TRUE);
        $DB2->set($arr_value);
        $DB2->insert('cc_location'); 
        $master_id 	= $DB2->insert_id();
        
        if($master_id){

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
        
        function dbGetCoursesByDate($first_day,$last_day,$course_id=0, $region_id=0, $sub_region=0,$chp_id='',$chp_list=array()) {
            $this->db->select ("crs.id ,course_name as title,  DATE_FORMAT(start, '%Y/%m/%d') as start,  DATE_FORMAT(end, '%Y/%m/%d') as end",FALSE);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    	$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($course_id && $course_id!=0)
            {
                $this->db->where ("master.course_id", $course_id);
            }
            if($region_id && $region_id!=0)
            {    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0)
            {
                $this->db->where ("master.subregion_id", $sub_region);
            } 
            
            if($course_id && $course_id==5){
                    if($chp_id){
                        $chp=$chp_list[$chp_id];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
                
            $this->db->from ("adhi_courses AS crs");
            $this->db->join ('adhi_events_master AS master','master.course_id = crs.id');
            $this->db->join ('adhi_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $this->db->distinct();
           // $this->db->groupby("crs.id");
            $query	= $this->db->get();
	    return($query->result());
            //echo $this->db->last_query();
        }
        
		
		 function dbGetCoursesByDateMobile($first_day,$last_day,$course_id=0, $region_id=0, $sub_region=0,$chp_id='',$chp_list=array()) {
            $this->db->select ("crs.id ,course_name as title,  DATE_FORMAT(start, '%Y/%m/%d') as start,  DATE_FORMAT(end, '%Y/%m/%d') as end",FALSE);
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    	$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($course_id && $course_id!=0)
            {
                $this->db->where ("master.course_id", $course_id);
            }
            if($region_id && $region_id!=0)
            {    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0)
            {
                $this->db->where ("master.subregion_id", $sub_region);
            } 
            
            if($course_id && $course_id==5){
                    if($chp_id){
                        $chp=$chp_list[$chp_id];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
                
            $this->db->from ("adhi_courses AS crs");
            $this->db->join ('adhi_events_master AS master','master.course_id = crs.id');
            $this->db->join ('adhi_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            $this->db->distinct();
           // $this->db->groupby("crs.id");
           // $query	= $this->db->get();
	    	//return($query->result());
		    $where_clause = $this->db->_compile_select();
			$this->db->_reset_select();
			$sql ="select count(final.ID)  as title ,final.start,final.end from(".$where_clause.") final GROUP BY final.start";
            $query	=$this->db->query($sql,false); 
			$res = $query->result();
			foreach ($res as $key => &$value) {
				$value->title = $value->title== 1 ? $value->title.' Course':$value->title.' Courses';
			}

	    	return($res);
        }
        function dbClasslistandlocation($date,$course_id=0, $region_id=0, $sub_region=0,$chp_id='',$chp_list=array()){
		
		$this->db->select ("region_id ,subregion_id, subregion.subregion_name AS subregion, subregion.subregion_address AS subaddress,subregion.subregion_description as subregion_description,region.region_name AS region,ac.course_name as course ,ac.id as course_id");
		$this->db->select ("subregion.image_name AS image, chapter_description AS descp");
		$this->db->select ("DATE_FORMAT(master.time_start,'%h:%i %p') AS start_time, DATE_FORMAT(master.time_end,'%h:%i %p') AS end_time",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		if($course_id && $course_id!=0)
	    {
	        $this->db->where ("master.course_id", $course_id);
	    }
	    if($region_id && $region_id!=0)
	    {    
	        $this->db->where ("region.id", $region_id);
	    }
	    if($sub_region && $sub_region!=0)
	    {
	        $this->db->where ("master.subregion_id", $sub_region);
	    } 
	    
	    if($course_id && $course_id==5){
            if($chp_id){
                $chp=$chp_list[$chp_id];
                $this->db->like("chapter_description",$chp,'both');
            }
        }
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_courses AS ac','ac.id 	= master.course_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		//$this->db->distinct();
		 
		$query	= $this->db->get();
		$result = $query->result();
		/*
			$data = array();
			$sample = array();
			$a =1;
			foreach ($result as $key => $value) {
							
				if (in_array($value->course.'###'.$value->course_id, $sample)) {
				    $data[$value->course.'###'.$value->course_id][$a]['subaddress'] = $value->subaddress;
					$data[$value->course.'###'.$value->course_id][$a]['start_time'] = $value->start_time;
					$data[$value->course.'###'.$value->course_id][$a]['end_time'] = $value->end_time;
					$a++;
				}else{
					$sample[]=$value->course.'###'.$value->course_id;
					$data[$value->course.'###'.$value->course_id][0]['subaddress'] = $value->subaddress;
					$data[$value->course.'###'.$value->course_id][0]['start_time'] = $value->start_time;
					$data[$value->course.'###'.$value->course_id][0]['end_time'] = $value->end_time;
				}
				
			}		 
		 */
		return $result;
	}
        function dbGetMonthlyCourses($first_day,$last_day,$course_id=0, $region_id=0, $sub_region=0,$chp_id='',$chp_list=array()) {
            $this->db->select ("crs.id,course_name");
            $this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
	    	$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);
            
            if($course_id && $course_id!=0)
            {
                $this->db->where ("master.course_id", $course_id);
            }
            if($region_id && $region_id!=0)
            {    
                $this->db->where ("region.id", $region_id);
            }
            if($sub_region && $sub_region!=0)
            {
                $this->db->where ("master.subregion_id", $sub_region);
            } 
            
            if($course_id && $course_id==5){
                    if($chp_id){
                        $chp=$chp_list[$chp_id];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
                
            $this->db->from ("adhi_courses AS crs");
            $this->db->join ('adhi_events_master AS master','master.course_id = crs.id');
            $this->db->join ('adhi_events AS sub','master.id = sub.events_master_id');
            $this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
            $this->db->join ('adhi_region AS region','region.id = subregion.region_id');
            
            $this->db->groupby("crs.id");
            $query	= $this->db->get();
	    return($query->result());
            //echo $this->db->last_query();
        }
        
        function dbGetMonthlyEventDetailsUser($first_day,$last_day,$region_id=0,$subregion_id=0,$course_id=0,$chp_id='',$chp_list=array()){
		$this->db->select ("subregion_name  AS subregion, DATE_FORMAT(start, '%d') AS day_no",false);
		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') >=", $first_day);
		$this->db->where ("DATE_FORMAT(end, '%Y/%m/%d') <=", $last_day);

		if(isset($subregion_id) && $subregion_id!=0)
			$this->db->where ("master.subregion_id", $subregion_id);

		if($region_id && $region_id!=0)
			$this->db->where ("region.id", $region_id);
                if($course_id && $course_id!=0)
			$this->db->where ("master.course_id", $course_id);
                if($course_id && $course_id==5){
                    if($chp_id){
                        $chp=$chp_list[$chp_id];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }

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

        function dbGetMonthlyEventDetailsUserclr($first_day,$last_day,$region_id=0,$subregion_id=0,$course_id=0,$chp_id='',$chp_list=array()){
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
                if($course_id && $course_id==5){
                    if($chp_id){
                        $chp=$chp_list[$chp_id];
                        $this->db->like("chapter_description",$chp,'both');
                    }
                }
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
		
		$this->db->select ("sub.id as sub_id,DATE_FORMAT(master.date,'%m/%d/%Y') AS start_date, sub.events_master_id AS master_id, DATE_FORMAT(master.time_start,'%h:%i') AS time_start, master.group_master_id");
		$this->db->select ("subregion.subregion_name AS subregion, region.region_name AS region, DATE_FORMAT(master.repeat_till,'%m/%d/%Y')  AS repeat_ends,repeat_status",false);
		$this->db->select ("DATE_FORMAT(master.time_start,'%p') AS meridiean_start,DATE_FORMAT(master.time_end,'%p') AS meridiean_end, DATE_FORMAT(master.time_end,'%h:%i') AS time_end,master.course_id");
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
		$this->db->select ("(SELECT course_name FROM adhi_courses WHERE adhi_courses.id=master.course_id ) as crsname");
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
		$this->db->select("ins.instructor_id, instructor.name as instructor_name");
                $this->db->select ("(SELECT course_name FROM adhi_courses WHERE adhi_courses.id=master.course_id ) as crsname");
		$this->db->where ("master.id ", $master_id);
		$this->db->from ("adhi_events_master AS master");	
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');
		$this->db->join ('adhi_instructor_log AS ins','ins.events_master_id = master.id AND ins.coo=0','left');
		$this->db->join ('adhi_meet_staff AS instructor','ins.instructor_id = instructor.id','left');
		$query	= $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function dbDeleteEventDetails($master_id){            
            $this->db->where('id', $master_id);
            if($this->db->delete('adhi_events_master')){
                    $this->db->where('events_master_id', $master_id);
                    if($this->db->delete('adhi_events')){
                            $this->db->where('events_master_id', $master_id);
                            $this->db->where('coo', 0);
                            $this->db->delete('adhi_instructor_log');
                            return TRUE;
                    }
            }else{ 	return FALSE; }
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
		
		$this->db->select ("region_id ,subregion_id, subregion.subregion_name AS subregion,,subregion.subregion_description as subregion_description, subregion.subregion_address AS subaddress,region.region_name AS region,(select course_name from adhi_courses where id = master.course_id) as course,");
		$this->db->select ("subregion.image_name AS image, chapter_description AS descp");
		$this->db->select ("DATE_FORMAT(master.time_start,'%h:%i %p') AS start_time, DATE_FORMAT(master.time_end,'%h:%i %p') AS end_time",false);

		$this->db->where ("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
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
		$this->db->from   ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
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
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$query		= $this->db->get();
		$result 	= $query->result();
		return $result;
	}
        
        function dbGetCurrentClassDetailsForSubregion($subregion_id,$date, $details = 1, $subregion){
		
                if($details){
                    $this->db->select ("region_id ,subregion_id,subregion_meta, subregion.subregion_name AS subregion,,subregion.subregion_description as subregion_description, subregion.subregion_address AS subaddress,region.region_name AS region,(select course_name from adhi_courses where id = master.course_id) as course,");
                    $this->db->select ("subregion.image_name AS image, chapter_description AS descp");
                    $this->db->select ("DATE_FORMAT(master.time_start,'%h:%i %p') AS start_time, DATE_FORMAT(master.time_end,'%h:%i %p') AS end_time",false);
                }else{
                    $this->db->select ("subregion.subregion_name AS subregion,region.region_name AS region");
                }    
		$this->db->where("DATE_FORMAT(start, '%Y/%m/%d') =", date('Y/m/d',strtotime($date)));
                
                if($subregion_id == ""){
                    $this->db->where("subregion_name",$subregion);
                }else{
                    $this->db->where("subregion_id",$subregion_id);
                }
                
		$this->db->from ("adhi_events AS sub");
		$this->db->join ('adhi_events_master AS master','master.id 	= sub.events_master_id');
		$this->db->join ('adhi_subregion AS subregion','subregion.id = master.subregion_id');
		$this->db->join ('adhi_region AS region','region.id = subregion.region_id');

		$query	= $this->db->get();
		$result = $query->result();
		return $result;
	}
        /**
	 * function to select the course
	 */
	function dbSelectAllCourses () {

		$this->db->select ("*");
		$this->db->from('adhi_courses');
        //$this->db->where ("exam_status",'E');
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

        function getAllScheduleChapters($course_id = ''){
            $this->db->from('adhi_schedule_chapters');
            if($course_id > 0){
                $this->db->where ('course_id', $course_id);
            }
            $query  = $this->db->get();
            $res    = $query->result();
            return $res;
        }
        
        function cancelScheduleChapter($master_id){
            if($group_master_id = $this->isWeeklyScheduledChapter($master_id)){
                return $this->postponeScheduledChapter($master_id, $group_master_id);
            }
            return FALSE;
	}
        
        /*
         * Return group master id
         */
        function isWeeklyScheduledChapter($master_id){
            $this->db->where ("id ", $master_id);
            $query  = $this->db->get('adhi_events_master');
            $result = $query->row();
            if($result && $result->group_master_id > 0){
                return $result->group_master_id;
            }
            return FALSE;
        }
        function postponeScheduledChapter($master_id, $group_master_id){
            $this->db->where ("id >=", $master_id, FALSE);
            $this->db->where ("group_master_id ", $group_master_id);
            $query  = $this->db->get('adhi_events_master');
            $result = $query->result();
            foreach($result as $row){
                //Postpone to next week in master table
                $this->db->where ("id", $row->id);
                $this->db->set('date', 'DATE_ADD(`date` , INTERVAL 7 DAY)', FALSE);
                $this->db->update('adhi_events_master');
                
                //Postpone to next week in sub table
                $this->db->where ("events_master_id", $row->id);
                $this->db->set('start', 'DATE_ADD(start , INTERVAL 7 DAY)', FALSE);
                $this->db->set('end', 'DATE_ADD(end , INTERVAL 7 DAY)', FALSE);
                $this->db->update('adhi_events');
            }
            return TRUE;
        }
        
        function updateWeeklyScheduledDetails($id, $data, $instructor_id){
            unset($data['created_date']);//remove created date
            
            $this->db->where ("id", $id);
            $this->db->set($data);
            $this->db->update('adhi_events_master');
            
            //Update events data with date time
            $start 	= $data['date'].' '.$data['time_start'];
            $end	= $data['date'].' '.$data['time_end'];
            $events = array(
                'start' => $start,
                'end'   => $end
            );            
            $this->db->set($events);	
            $this->db->where ("events_master_id", $id);
            $this->db->update('adhi_events');

            
            //update instructor details
            $this->db->where ("events_master_id", $id);
            $log = array(
                'instructor_id' => $instructor_id,
                'start'         => $start,
                'end'           => $end
            );
            $this->db->set($log);
            $this->db->update('adhi_instructor_log');
        }
        
        function deleteSuccessiveChapters($master_id, $group_master_id){  
            $this->db->where ("id", $master_id);
            $query  = $this->db->get('adhi_events_master');            
            $result = $query->row();
            
            //$this->db->where ("id >=", $master_id, FALSE);
            $this->db->where ("date >='".$result->date."'", NULL, FALSE);
            $this->db->where ("group_master_id ", $group_master_id);
            $query  = $this->db->get('adhi_events_master');
            $result = $query->result();
            foreach($result as $row){
                //Postpone to next week in sub table
                $this->db->where ("events_master_id", $row->id);
                $this->db->delete('adhi_events');
                
                //Postpone to next week in master table
                $this->db->where ("id", $row->id);
                $this->db->delete('adhi_events_master');
                
                
            }
            return TRUE;
	}
}