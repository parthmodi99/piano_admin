<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Login extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->library('auth');

		$this->load->library('user_agent');

	}

	function index()

	{

		$redirect = $this->auth->is_logged_in();

		$data['page_title']	= 'Login';

		$data['email']='';

		$data['csrf'] = array(

			        	'name' => $this->security->get_csrf_token_name(),

			        	'hash' => $this->security->get_csrf_hash()

					);

		

		if($redirect)

		{

			redirect($this->config->item('admin_folder').'/dashboard');

		}

		

		if(isset($_REQUEST['submit']))

		{	

			

			$admin_name	= $this->input->post('admin_name',TRUE);

			$admin_password	= $this->input->post('admin_password',TRUE);

			$data['email'] = $admin_name;



			$login = $this->auth->login_admin($admin_name, $admin_password);

			

			if($login)

			{

				
				if($this->auth->is_logged_in_super_admin())
				{

					$redirect = $this->config->item('admin_folder').'/dashboard';
				}
				else{
					$redirect = $this->config->item('admin_folder').'/Track';
				}

				redirect($redirect);

				

			}

			else

			{

				$this->session->set_flashdata('error', '<div>Incorrect Email id/Password.</div>');

				redirect($this->config->item('admin_folder').'/login');

			}

		}

		else

		{

			$this->load->view('login');



		}

	}

	

	

}