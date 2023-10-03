<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Quote extends CI_Controller

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

		date_default_timezone_set('Europe/Paris');

	}

	public function index()

	{

	
		$data['quote']		= $this->admin_model->getAllRecords('tbl_quote');
		


		$this->load->view('quoteList',$data);

	}
	function addQuote()

	{

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['custom_error'] = null;

		if($this->input->post('submit'))
		{
			$this->form_validation->set_rules('quote', 'Quote', 'trim|required|min_length[6]|max_length[255]|xss_clean|is_unique[tbl_quote.quote]');
			$this->form_validation->set_rules('author', 'Author', 'trim|required');

			if($this->form_validation->run() == false)
		    {
		        $this->load->view('add_quote',$data);
		    }
		    else
		    {	    	
				$insert_data['quote'] = $this->input->post('quote',TRUE);
				$insert_data['author'] = $this->input->post('author',TRUE);
				$insert_data['created_at'] = date('Y-m-d H:i:s');			


				$result = $this->admin_model->addRecords('tbl_quote',$insert_data);

				if($result)

				{

					$this->session->set_flashdata('success', 'Quote has been added successfully.');

					redirect('quote');

				}

				else

				{

					$this->session->set_flashdata('error', 'Error while adding Client.');

					$this->load->view('add_quote',$data);

				}
			}

		}

		else

		{

			$this->load->view('add_quote',$data);

		}

	}

	function delete_quote($id)

	{

		$result = $this->admin_model->deleteRecords('tbl_quote',array('id' => $id));

		$this->session->set_flashdata('success', 'Quote has been deleted successfully.');

		redirect('Quote');

	}

	function editQuote($id)

	{

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['quoteedit']=$this->admin_model->getSingleRecordById('tbl_quote',array('id' => $id));

		$data['custom_error'] = null;

		if($this->input->post('submit'))

		{
			if($data['quoteedit']['quote'] != $this->input->post('quote',TRUE))
			{
				 $is_unique =  '|is_unique[tbl_quote.quote]';
			}
			else{
				$is_unique =  '';
			}
			$this->form_validation->set_rules('quote', 'Quote', 'trim|required|min_length[6]|max_length[255]|xss_clean'.$is_unique);
			$this->form_validation->set_rules('author', 'Author', 'trim|required');

			if($this->form_validation->run() == false)
		    {
		        $this->load->view('add_quote',$data);
		    }
		    else
		    {

				$update_data['quote'] = $this->input->post('quote',TRUE);

				$update_data['author'] = $this->input->post('author',TRUE);

				$update_data['updated_at'] = date('Y-m-d H:i:s');		


				$result = $this->admin_model->updateRecords('tbl_quote',$update_data,array('id' => $id));

				if($result)

				{

					$this->session->set_flashdata('success', 'Quote has been updated successfully.');
					redirect('Quote');

				}

				else

				{

					$this->session->set_flashdata('error', 'Error while updating quote.');

					$this->load->view('add_quote',$data);

				}
			}

		}

		else

		{

			$this->load->view('add_quote',$data);

		}

	}

}

