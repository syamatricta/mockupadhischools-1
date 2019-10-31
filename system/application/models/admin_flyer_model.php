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

class Admin_flyer_model extends Model{
	function Admin_flyer_model ()
	{
		parent::Model ();
		//$this->output->enable_profiler();
	}  
	
        function getAllFlyers($search_params, $type = 'count', $num = 0, $offset = 0){
            $this->db->from('adhi_flyers');
            if('' != $search_params['search_title']){
	    	$this->db->like('title', $search_params['search_title'], 'both');
            }
	    if('' != $search_params['search_date']){
	    	$this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') = '".date('Y-m-d', strtotime($search_params['search_date']))."'", NULL, FALSE);
            }
            if('count' == $type){
                $query	= $this->db->get();                
                return $query->num_rows();
            }else{                
                $this->db->orderby('created_at','DESC');
                if( 'list' == $type){
                    $this->db->limit($num, $offset);
                }
                $query	= $this->db->get();
                return $query->result();
            }
            
        }
        
        function getAllFlyerImages(){
            $query	= $this->db->get('adhi_flyer_head_images');
            return $query->result();
        }
        
        
        function titleExists($title, $except_id = ''){
            $this->db->where("LOWER(title) = '".strtolower(mysql_real_escape_string($title))."'", NULL, FALSE);
            if('' != $except_id){
                $this->db->where('id<>' ,  $except_id, FALSE);
            }
            $result = $this->db->get('adhi_flyers');
            return $result->row();
        }
        
        function save($data){
            $this->db->set($data);
            $result = $this->db->insert('adhi_flyers');
            return ($result) ? $this->db->insert_id() : FALSE;
        }
        
        function getFlyer($id){
            $this->db->where('flyer.id', $id);
            $this->db->join ('adhi_flyer_head_images img','img.id = flyer.head_image');
            $result = $this->db->get('adhi_flyers flyer');
            return $result->row();
        }
        
        function update($id, $data){
            $this->db->set($data);
            $this->db->where('id', $id);
            $result = $this->db->update('adhi_flyers');
            return ($result) ? TRUE : FALSE;
        }
        
        function delete($id){
            $this->db->where('id', $id);
            $result = $this->db->delete('adhi_flyers');
            return ($result) ? TRUE : FALSE;
        }
        
}