<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Canada/Pacific');
class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		if($this->auth->is_logged_in() == false)
			redirect(base_url());
	}
	public function index()
	{
		$this->auth->logout();
		$this->session->set_flashdata('message', 'You have been logged out!');
		redirect(base_url());
	}
}
?>