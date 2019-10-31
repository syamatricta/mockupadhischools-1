<?php
class User_migrate_forum extends Model
{
	private $obj;

	function User_migrate_forum()
	{
        parent::Model();
       //$this->output->enable_profiler();
	}
	/*
	 *
	 */
	function dbSelectAdhiusers (){
		$this->db 	= $this->load->database('default', TRUE);
		$query= $this->db->query("SELECT firstname,lastname,forum_alias, emailid,
		password FROM adhi_user");
				return $query->result_array();
	}
       

	function dbSelectForumUsers(){
		$this->db1 	= $this->load->database('db1', TRUE);
		$query		= $this->db1->query("SELECT email FROM user");
		return $query->result_array();
	}

}
?>