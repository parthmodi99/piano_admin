<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class SubAdmin extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->library('auth');

		if($this->auth->is_logged_in_super_admin() == false)

			redirect(base_url());

		$this->load->helper('form');

		$this->load->model('Admin_model', 'admin_model');

		//$this->load->model('admin_model','admin_model');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	public function index()

	{

		$this->load->view('dashboard');

	}

	public function list()

	{
		$data['admins'] = $this->admin_model->getAllRecordsById('tbl_admin', array('admin_type' => 0));

		//$data['admins'] = $this->admin_model->getSubAdmins();
		/*echo "<pre>";
		print_r($data['admin'][0]); die;*/
		$this->load->view('adminList', $data);

	}


	public function addAdmin()

	{

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['custom_error'] = null;

		if($this->input->post('submit'))

		{

			$this->form_validation->set_rules('name', 'Name', 'required|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

			$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|is_unique[tbl_admin.email_id]');

			//$this->form_validation->set_rules('description1', 'Safety Procedure Content', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('add_subadmin', $data);
			}
			else
			{
				$name = $this->input->post('name',TRUE);

				$password = $this->input->post('password',TRUE);

				$email_id = $this->input->post('email_id',TRUE);

				$insert_data['name']=$name;

				$insert_data['email_id']=$email_id;

				$insert_data['password']=md5($this->input->post('password'));

				$insert_data['base_password']=base64_encode($this->input->post('password'));

				$insert_data['admin_type']=0;

				$insert_data['created_at']=date('Y-m-d h:i:s');

				//print_r($insert_data); die;

				$result = $this->admin_model->addRecords('tbl_admin',$insert_data);

				if($result)

				{

					$this->session->set_flashdata('success', 'Sub admin created successfully.');

					redirect('subAdmin/list');

				} 

				else 

				{

					$this->session->set_flashdata('error', 'Error while adding sub admin.');

					$this->load->view('add_subadmin',$data);

				}			

			}

		}

		else

		{

			$this->load->view('add_subadmin',$data);

		}

	}

	function editAdmin()

	{

		$cid =$this->uri->segment('3');

		// print_r($cid); die;

		$data['csrf'] = array(

						    'name' => $this->security->get_csrf_token_name(),

						    'hash' => $this->security->get_csrf_hash()

						);

		$data['pageedit']=$this->admin_model->getSingleRecordById('tbl_admin',array('id' => base64_decode($cid)));

		$data['pageedit']['password'] = base64_decode($data['pageedit']['base_password']);

		$checkid = base64_decode($cid);

		//print_r($checkid); die;

		$data['custom_error'] = null;

		if($this->input->post('submit'))

		{

			$this->form_validation->set_rules('name', 'Name', 'required|regex_match[/[A-Za-z ]$/]');

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

			//$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|edit_unique[tbl_admin.email_id.'.$checkid.']');

			if(trim(strtolower($this->input->post('email_id'))) != trim(strtolower($data['pageedit']['email_id']))) {
			   $is_unique =  '|is_unique[tbl_admin.email_id]';
			} else {
			   $is_unique =  '';
			}

			$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|trim|xss_clean'.$is_unique);

			//$this->form_validation->set_rules('description1', 'Content', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{

				$this->load->view('add_subadmin', $data);
			}
			else
			{

				$name = $this->input->post('name',TRUE);

				$password = $this->input->post('password',TRUE);

				$email_id = $this->input->post('email_id',TRUE);

				$insert_data['name']=$name;

				$insert_data['email_id']=$email_id;

				$insert_data['password']=md5($this->input->post('password'));

				$insert_data['base_password']=base64_encode($this->input->post('password'));


				//$result = $this->admin_model->update_page($insert_data,base64_decode($cid));

				$result = $this->admin_model->updateRecords('tbl_admin',$insert_data, array('id' => $checkid));

				if($result)

				{

					$this->session->set_flashdata('success', 'Sub Admin has been Updated successfully.');

					redirect('SubAdmin/list');

				} 

				else 

				{

					$this->session->set_flashdata('error', 'Error while adding sub admin.');

					$this->load->view('add_subadmin',$data);

				}			

			}

		}

		else

		{

			$this->load->view('add_subadmin',$data);

		}

	}

	function admin_block()

    {

        $admin_id = $this->input->post('admin_id', true);

        $status = $this->input->post('status', true);

        //print_r($status); die;

        $upd = $this->admin_model->updateRecords('tbl_admin',array('status' => $status), array('id' => $admin_id));

        if ($upd) {

            echo 1;

        } else {

            echo 0;

        }

    }

    function delete_subadmin($id)

    {

        $result = $this->admin_model->deleteRecords('tbl_admin',array('id' => $id));

        $this->session->set_flashdata('success', 'Sub admin deleted successfully.');

        redirect('subAdmin/list');

    }


    function sendMail($id)
	{
		
		$pwd = $this->admin_model->getSingleRecordById('tbl_admin',array('id' => $id));

		$pwdd = $pwd['base_password'];
		$fullname = $pwd['name'];
		$email = $pwd['email_id'];

		$new_pwd = base64_decode($pwdd);

		$this->load->library('phpmailer_lib');
        // PHPMailer object
    	$mail = $this->phpmailer_lib->load();

    	try {

	      $mail->isSMTP();
	      $mail->SMTPAuth = true;
	      $mail->SMTPSecure = 'tls';
	      $mail->Port = 587;
	      $mail->Host = 'smtp.gmail.com';
	      $mail->Username = 'demo.ebizzinfotech@gmail.com';
	      $mail->Password = 'zixmyvqbkaaejqbd';
	      $mail->setFrom('demo.ebizzinfotech@gmail.com', 'Piano');
	        $mail->addAddress($email);     // Add a recipient

	        $mail->isHTML(true);                                  // Set email format to HTML
	        $mail->Subject = 'Login Detail - Piano Admin';
	        $mail->Body    = "Dear ".$fullname.", <br><br> Here is the personal login information we’ve created for you to add tabs to the Pianohack app.<br><br><b>Email :</b> ".$email." <br><b>Password :</b> ".$new_pwd."<br><b>Link :</b> ".base_url()."<br><br>Please let us know through Upwork if you have any questions.<br><br>Sincerely, <br> The Pianohack Team";	       
	        $mail->SMTPOptions = array(
	          'ssl' => [
	            'verify_peer' => false,
	            'verify_depth' => false,
	            'allow_self_signed' => true,
	          ],
	        );

	        $mail->send();

	        $this->session->set_flashdata('success', 'Mail Send Successfully.');

        	redirect('SubAdmin/list');

	      } catch (Exception $e) {
	      	 $this->session->set_flashdata('error', 'Failed to send mail.');

        	redirect('SubAdmin/list');
	      }
        
	}

	public function getprofile($admin_id)
	{
		$data['admin'] = $this->admin_model->getSingleRecordById('tbl_admin',array('id' => $admin_id));
		$data['track'] = $this->admin_model->getAllTrackBySubadmin($admin_id);

		$data['admin_type'] = 1;

        $this->load->view('admintrackList',$data);
	}

	

}

