<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Dashboard extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->library('auth');

		if($this->auth->is_logged_in_super_admin() == false)

			redirect('Track');

		$this->load->helper('form');

		//$this->load->model('admin_model','admin_model');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	public function index()

	{

		$this->load->view('dashboard');

	}

	

}

