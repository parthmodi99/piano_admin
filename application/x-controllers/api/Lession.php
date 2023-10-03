<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Lession extends CI_Controller

{



    function __construct()

    {



        parent::__construct();

        $this->load->library('auth');

        if($this->auth->is_logged_in() == false)

            redirect(base_url());

        $admin = $this->session->userdata('admin');

        $this->admin_type = $admin['admin_type'];

        $this->admin_id = $admin['id'];

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->model('Admin_model','admin_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        $this->output->set_header('Pragma: no-cache');

        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        //date_default_timezone_set('Europe/Paris');

    }

    public function index()

    {
        
        $data['lession']      = $this->admin_model->getAllLession();

        $this->load->view('lessionList',$data);

    }


    function delete($id)

    {

        $result = $this->admin_model->deleteRecords('tbl_lession',array('id' => $id));

        $this->session->set_flashdata('success', 'Lession deleted successfully.');

        redirect('Lession');

    }

    function addLession()

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['custom_error'] = null;

        $data['course']      = $this->admin_model->getAllRecords('tbl_course');

        if($this->input->post('submit'))
        {            
            $insert_data['name'] = $this->input->post('name',TRUE);

            $insert_data['course_id'] = $this->input->post('course_id',TRUE);

            $result = $this->admin_model->addRecords('tbl_lession',$insert_data);
            if($result)
            {
                
                $this->session->set_flashdata('success', 'Lession been added successfully.');

                redirect('lession');
            }
            else{
                $this->session->set_flashdata('error', 'Error while adding Lession.');

                $this->load->view('add_lession',$data);
            }
        }

        else
        {
            $this->load->view('add_lession',$data);
        }

    }

    function editLession($id)

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['lession']=$this->admin_model->getSingleRecordById('tbl_lession',array('id' => base64_decode($id)));

        $data['custom_error'] = null;

        $data['course']      = $this->admin_model->getAllRecords('tbl_course');

        if($this->input->post('submit'))

        {
            $lession_id = $this->input->post('lession_id',TRUE);
            if($lession_id != '')
            {
                $insert_data['name'] = $this->input->post('name',TRUE);

                $insert_data['course_id'] = $this->input->post('course_id',TRUE);
            
                $upd = $this->admin_model->updateRecords('tbl_lession',$insert_data, array('id' => $lession_id));
                if($upd)
                {
        
                    $this->session->set_flashdata('success', 'lession has been updated successfully...');

                    redirect('lession');
                }
                else{
                    $this->session->set_flashdata('error', 'Error while updating lession.');

                    $this->load->view('add_lession',$data);
                }

            }
            else{
                $this->session->set_flashdata('error', 'Error while updating lession.');

                redirect('lession');
            }
        }

        else

        {

            $this->load->view('add_lession',$data);

        }

    }

}

