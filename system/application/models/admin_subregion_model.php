<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */
// ------------------------------------------------------------------------

class Admin_subregion_model extends Model {

    function Admin_subregion_model() {
        parent::Model();
        //$this->output->enable_profiler();
    }

    function dbGetTotalSubRegion($search = 0) {
        if ($search != 0) {
            $this->db->like('region_id', $search);
        }
        $this->db->from('adhi_subregion');
        return $this->db->count_all_results();
    }

    /**
     * function to select the sub region details
     */
    function dbSelectAllSubRegion($num, $offset = 0, $search = 0) {
        if ($search != 0) {
            $this->db->where('region_id', $search);
        }
        $this->db->select("subregion_name AS sub_name,sub.id AS id,region.region_name AS region,region_id");
        $this->db->from('adhi_subregion AS sub');
        $this->db->join('adhi_region AS region', 'region.id=sub.region_id');
        $this->db->limit($num, $offset);
        $this->db->orderby('subregion_name', 'ASC');
        $query = $this->db->get();
        return($query->result());
    }

    /**
     * get single sub region
     */
    function dbSelectSingleSubRegion($id) {
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from('adhi_subregion');
        $query = $this->db->get();
        if ($query->result())
            return $query->result();
        else
            return FALSE;
    }

    /**
     * function to delete the sub-region
     *
     */
    function dbDeleteSubRegion($subregion_id) {
        $this->db->where('id', $subregion_id);
        if ($this->db->delete('adhi_subregion')) {
            $this->dbDeleteAllEventDetails($subregion_id);
            return TRUE;
        } else
            return FALSE;
    }

    function dbDeleteAllEventDetails($subregion_id) {

        $sql = "DELETE subregion,master,event 
					FROM adhi_subregion AS subregion 
					LEFT JOIN adhi_events_master AS master ON master.subregion_id = subregion.id
					LEFT JOIN adhi_events AS event ON event.events_master_id = master.id
					WHERE subregion.id =" . $subregion_id;
        $this->db->query($sql);
    }

    function dbUpdateSubRegion($arr_subregion, $subregion_id) {
        if (isset($arr_subregion['file_name'])) {
            $data = array(
                'subregion_name' => $arr_subregion['subregion'],
                'subregion_address' => $arr_subregion['subregion_address'],
                //'sub_postcode' 		=> $arr_subregion['sub_postcode'],
                //'co_lattitude' 		=> $arr_subregion['co_lattitude'],
                //'co_longitude' 		=> $arr_subregion['co_longitude'],
                'subregion_description' => $arr_subregion['subregion_des'],
                'image_name' => $arr_subregion['file_name'],
                //'yt_video'              => $arr_subregion['yt_video'],
                //'hiring_contact_name'	=> $arr_subregion['hiring_contact_name'],
                // 'company_name'		=> $arr_subregion['company_name'],
                //'phone_number'		=> $arr_subregion['phone_number'],
                // 'company_information'	=> $arr_subregion['company_information'],
                'updated_date' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
            );
        } else {
            $data = array(
                'subregion_name' => $arr_subregion['subregion'],
                'subregion_address' => $arr_subregion['subregion_address'],
                //'sub_postcode' 		=> $arr_subregion['sub_postcode'],
                // 'co_lattitude' 		=> $arr_subregion['co_lattitude'],
                //'co_longitude' 		=> $arr_subregion['co_longitude'],
                'subregion_description' => $arr_subregion['subregion_des'],
                // 'yt_video'               => $arr_subregion['yt_video'],
                // 'hiring_contact_name'	=> $arr_subregion['hiring_contact_name'],
                // 'company_name'		=> $arr_subregion['company_name'],
                // 'phone_number'		=> $arr_subregion['phone_number'],
                // 'company_information'	=> $arr_subregion['company_information'],
                'updated_date' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
            );
        }
        $this->db->set($data);
        $this->db->where('id', $subregion_id);
        if ($this->db->update('adhi_subregion'))
            return TRUE;
        else
            return FALSE;
    }

    function location_region($reg_name) {  
        if("" != $reg_name){
            $query = $this->db->select('*')->from('adhi_subregion')->where('subregion_name', $reg_name)->get();
            return $query->row();
        }
    }
}
