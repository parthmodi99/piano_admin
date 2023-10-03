<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Page extends CI_Controller {



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

		$data['page'] = $this->admin_model->Page_list();

		$this->load->view('page_list',$data);

	}

	

	public function addPage()

	{

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['page']=$this->admin_model->Page_list();

		$data['custom_error'] = null;

		if($this->input->post('submit'))

		{

			$this->form_validation->set_rules('qtitle', 'Question Answer title', 'required|callback_PverifyCategoryName|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('stitle', 'Safety procedure title', 'required|callback_PverifyCategoryName|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('description', 'Question Answer Content', 'required');

			//$this->form_validation->set_rules('description1', 'Safety Procedure Content', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE)

			{

				$this->load->view('add_page', $data);

			}

			

			else

			{

				$name = $this->input->post('qtitle',TRUE);

				$name1 = $this->input->post('stitle',TRUE);

				$insert_data['page_title']=$name;

				$insert_data['page_slug']=$name1;

				$insert_data['content']=$this->input->post('description');

				$insert_data['created_at']=date('Y-m-d h:i:s');

				//print_r($insert_data); die;

				$result = $this->admin_model->Aad_page($insert_data);

				if($result)

				{

					$this->session->set_flashdata('success', 'Cms Page has been added successfully.');

					redirect('page');

				} 

				else 

				{

					$this->session->set_flashdata('error', 'Error while adding page.');

					$this->load->view('add_page',$data);

				}			

			}

		}

		else

		{

			$this->load->view('add_page',$data);

		}

		

	}

	//Verify category name is already exists or not

	function PverifyCategoryName($name)

	{

		$result = $this->admin_model->PverifyCategoryName($name);

		if($result)

		{

			$this->form_validation->set_message('PverifyCategoryName', 'english page name already exists.');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	function PverifyCategoryName1($name)

	{

		$result = $this->admin_model->PverifyCategoryName1($name);

		if($result)

		{

			$this->form_validation->set_message('PverifyCategoryName1', 'arabic page name already exists.');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	function editPage()

	{

		$data['page']=$this->admin_model->Page_list();

		$cid =$this->uri->segment('3');

		// print_r($cid); die;

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['pageedit']=$this->admin_model->Page_list_id(base64_decode($cid));

		$checkid = base64_decode($cid);

		//print_r($checkid); die;

		$data['custom_error'] = null;

		if($this->input->post('submit'))

		{

			$this->form_validation->set_rules('qtitle', 'title', 'required|callback_PverifyCategoryNameEdit['.$checkid.']|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('stitle', 'title', 'required|callback_PverifyCategoryNameEdit['.$checkid.']|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('description', 'Content', 'required');

			//$this->form_validation->set_rules('description1', 'Content', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE)

			{

				$this->load->view('add_page', $data);

			}

			else

			{

				$name = $this->input->post('qtitle',TRUE);

				$name1 = $this->input->post('stitle',TRUE);

				$insert_data['page_title']=$name;

				$insert_data['page_slug']=$name1;

				$insert_data['content']=$this->input->post('description');

				$insert_data['updated_at']=date('Y-m-d h:i:s');



				$result = $this->admin_model->update_page($insert_data,base64_decode($cid));

				if($result)

				{

					$this->session->set_flashdata('success', 'Cms Page has been Updated successfully.');

					redirect('page');

				} 

				else 

				{

					$this->session->set_flashdata('error', 'Error while adding page.');

					$this->load->view('add_page',$data);

				}			

			}

		}

		else

		{

			$this->load->view('add_page',$data);

		}

	}

	function PverifyCategoryNameEdit($name,$id)

	{

		$result = $this->admin_model->PverifyCategoryNameEdit($name,$id);

		if($result)

		{

			$this->form_validation->set_message('PverifyCategoryNameEdit', 'english page name already exists.');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	function PverifyCategoryNameEdit1($name,$id)

	{

		$result = $this->admin_model->PverifyCategoryNameEdit1($name,$id);

		if($result)

		{

			$this->form_validation->set_message('PverifyCategoryNameEdit1', 'arabic page name already exists.');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	function delete_page()

	{

		$page_id = $this->uri->segment('3');

		$result = $this->admin_model->delete_page($page_id);

		$this->session->set_flashdata('success', 'Cms Page has been Deleted successfully.');

		if($result)

		{

			redirect('page');

		} 

		else 

		{

			redirect('page');

		}		

	}

	function update_page_status()

	{

		$cms_id = $this->input->post('cms_id',TRUE);

		$status = $this->input->post('status',TRUE);

		$statusCode = (strtolower($status) == "active")?'1':'0';

		$upd = $this->admin_model->update_page_status($cms_id,$statusCode);

		if($upd)

		{

			echo 1;

		}

		else

		{

			echo 0;

		}

	}

	 function contentview()

	{

		$id = $this->uri->segment('3');

		$cms = $this->admin_model->view_content($id);

		

        if(!empty($cms))

		{

            

            $this->load->view('content_popup',array('cms'=>$cms));

		}

		else

			echo false;

	}

}

