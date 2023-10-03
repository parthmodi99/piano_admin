<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Notification extends CI_Controller 

{



	function __construct()

	{



		parent::__construct();

		$this->load->library('auth');

		if($this->auth->is_logged_in() == false)

			redirect(base_url());

		 $this->load->helper('form');

		$this->load->helper('url');

		$this->load->model('Admin_model','admin_model');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	public function index()

	{

		//echo "hii"; die;

		$data['user']		= $this->admin_model->noti_user_list();

		$this->load->view('notification',$data);

	}

	public function notificationsend()
	{
		$title = $_POST['title'];
		$message = $_POST['message'];
		if($_POST['usertype'] == 'specific')
		{
			if(empty($_POST['user_id']))
			{
				$this->session->set_flashdata('error', 'Select User.');

				redirect('Notification');
			}
			else
			{
				foreach ($_POST['user_id'] as $value) 
				{
					# code...
					$const_user_data = $this->admin_model->getSingleRecordById("tbl_user",array("id" => $value));
					if(!empty($const_user_data))
					{
						if($const_user_data['device_token']!='')
						{
							$device_token = $const_user_data['device_token'];
							$send_noti = $this->admin_model->sendIOSnotification($device_token,$title,$message);
						}
					}
				}

				$this->session->set_flashdata('success', 'Notification Send successfully.');

				redirect('Notification');
			}
		}
		else
		{
			$user = $this->admin_model->user_list();
			foreach ($user as $value) 
			{
				# code...
				$const_user_data = $this->admin_model->getSingleRecordById("tbl_user",array("id" => $value['id']));
				if(!empty($const_user_data))
				{
					if($const_user_data['device_token']!='')
					{
						$device_token = $const_user_data['device_token'];
						$send_noti = $this->admin_model->sendIOSnotification($device_token,$title,$message);
					}
				}
			}
			$this->session->set_flashdata('success', 'Notification Send successfully.');

			redirect('Notification');

		}


	}




}

