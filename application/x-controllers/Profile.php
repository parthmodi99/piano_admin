<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Profile extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->library('auth');

		if($this->auth->is_logged_in_super_admin() == false)

			redirect(base_url());

		$this->load->helper('form');

		$this->load->model('admin_model','admin_model');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	public function index()

	{

		$data['custom_error'] = null;

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['admin'] = $this->admin_model->get_admin_detail();

		if(isset($_REQUEST['submit']))

		{

			//$this->form_validation->set_rules('fname', 'First name', 'required|alpha|xss_clean');

			//$this->form_validation->set_rules('lname', 'Last name', 'required|alpha|xss_clean');

			$this->form_validation->set_rules('email_id', 'Email id', 'required|valid_email|xss_clean');

			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');

			$this->form_validation->set_rules('conpassword', 'Password', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE)

			{

				$this->load->view('profile', $data);

			}

			else

			{

				$pass = md5($this->input->post('password'));

				$conpass = md5($this->input->post('conpassword'));

				if($pass == $conpass)

				{

					$upd = $this->admin_model->update_admin_details();

					if($upd) 

					{

						$this->session->set_flashdata('success', 'Profile has been updated successfully.' );

						redirect('profile');

					} 

					else 

					{

						$this->session->set_flashdata('error', 'Error while updating profile.' );

						redirect('profile');

					}

				}

				else

				{

					$this->session->set_flashdata('error', 'Old password and New password are not match.' );

					redirect('profile');

				}

			}

		}

		else

		{

			$this->load->view('profile', $data);

		}

	}

	

}