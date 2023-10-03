<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Setting_model extends CI_Model

{

	function __construct()

    {

         parent::__construct();

    }

	

	function Add_settings($data)

	{

		$this->db->where('setting_id',1);

		$res = $this->db->update('setting_master',$data);

		//echo $this->db->last_query();die;

		if($res){return true;}else{return false;}

	}

	function update_settings($data)

	{

		$res = $this->db->update('setting_master',$data);

		//echo $this->db->last_query();

		if($res){return true;}else{return false;}

	}

	function db_site_name()

	{

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function db_meta_title($name)

	{

		$this->db->where('setting_name',$name);

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function db_site_name1($name)

	{

		$this->db->where('setting_name',$name);

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function ctext($name)

	{

		$this->db->where('setting_name',$name);

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function flink($name)

	{

		$this->db->where('setting_name',$name);

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function tlink($name)

	{

		$this->db->where('setting_name',$name);

		$res = $this->db->get('setting_master')->row_array();

		if($this->db->affected_rows() > 0){return $res;}else{return false;}

	}

	function Get_setting($id)

	{

		$this->db->where('id',$id);

		$result = $this->db->get('mail_setting');

		$data = $result->result_array();

		return $data;

	}

	function update_email_setting($data,$id)

	{

		$this->db->where('id',$id);

		$res = $this->db->update('mail_setting',$data);

		return ($res)?TRUE:FALSE;

	}

	function generalSetting()

	{

		$this->db->where('setting_id',1);

		$result = $this->db->get('setting_master');

		$data = $result->row_array();

		return $data;

	}


	function admin_details()

	{

		$this->db->where('id',1);

		$result = $this->db->get('tbl_admin');

		$data = $result->row_array();

		return $data;

	}

}