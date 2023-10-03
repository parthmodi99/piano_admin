<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Course extends CI_Controller

{
    // public $course_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //live
    public $course_url = 'http://localhost/piano_admin/upload/chapter/'; //local

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
        $data['course']      = $this->admin_model->getAllRecords('tbl_course');
        $data['course_title']      = $this->admin_model->getAllRecords('tbl_course_title');

        usort($data['course'], function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $this->load->view('courseList',$data);
    }


    function delete($id)

    {

        $result = $this->admin_model->deleteRecords('tbl_course',array('id' => $id));

        $this->session->set_flashdata('success', 'Course deleted successfully.');

        redirect('Course');

    }

    function addCoursetitle()

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {            
            $insert_data['title'] = $this->input->post('title',TRUE);
            $insert_data['description'] = $this->input->post('description',TRUE);

            $result = $this->admin_model->addRecords('tbl_course_title',$insert_data);
            if($result)
            {
                
                $this->session->set_flashdata('success', 'Course title been added successfully.');

                redirect('course');
            }
            else{
                $this->session->set_flashdata('error', 'Error while adding Course.');

                $this->load->view('add_course',$data);
            }
        }

        else
        {
            $this->load->view('add_course',$data);
        }

    }
    function updateCoursetitle()
    {
        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['course_title']=$this->admin_model->getSingleRecordById('tbl_course_title',array('id' => "1"));

        $data['custom_error'] = null;

        if($this->input->post('submit'))

        {
            $insert_data['title'] = $this->input->post('title',TRUE);
            $insert_data['description'] = $this->input->post('description',TRUE);
        
            $upd = $this->admin_model->updateRecords('tbl_course_title',$insert_data, array('id' => "1"));
            if($upd)
            {
    
                $this->session->set_flashdata('success', 'course title has been updated successfully...');

                redirect('course');
            }
            else{
                $this->session->set_flashdata('error', 'Error while updating course title.');

                $this->load->view('add_course',$data);
            }
        }

        else

        {

            $this->load->view('add_course',$data);

        }

    }

    function addCourse()

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {            
            $insert_data['name'] = $this->input->post('name',TRUE);
            $insert_data['coming_soon'] = $this->input->post('coming_soon', true);

            if (isset($_FILES['image']) && $_FILES['image'] != '') {
                $config = array(
                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                    'upload_path' => "upload/chapter/", //local
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => true,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $insert_data['image'] = $data['file_name'];
                }
            }

            if (isset($_FILES['image_free']) && $_FILES['image_free'] != '') {
                $config = array(
                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                    'upload_path' => "upload/chapter/", //local
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => true,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image_free')) {
                    $data = $this->upload->data();
                    $insert_data['image_free'] = $data['file_name'];
                }
            }

            if (isset($_FILES['course_icon']) && $_FILES['course_icon'] != '') {
                $config = array(
                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                    'upload_path' => "upload/chapter/", //local
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => true,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('course_icon')) {
                    $data = $this->upload->data();
                    $insert_data['course_icon'] = $data['file_name'];
                }
            }

            $result = $this->admin_model->addRecords('tbl_course',$insert_data);
            if($result)
            {
                
                $this->session->set_flashdata('success', 'Course been added successfully.');

                redirect('course');
            }
            else{
                $this->session->set_flashdata('error', 'Error while adding Course.');

                $this->load->view('add_course',$data);
            }
        }

        else
        {
            $this->load->view('add_course',$data);
        }

    }

    function editCourse($id)

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['course']=$this->admin_model->getSingleRecordById('tbl_course',array('id' => base64_decode($id)));
        $data['course_url']    = $this->course_url;
        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {
            $course_id = $this->input->post('course_id',TRUE);
            if($course_id != '')
            {
                $insert_data['name'] = $this->input->post('name',TRUE);
                $insert_data['coming_soon'] = $this->input->post('coming_soon', true);

                if (isset($_FILES['image']) && $_FILES['image'] != '') {
                    $config = array(
                        // 'upload_path' => "../APIs/uploads/chapter/", //live
                        'upload_path' => "upload/chapter/", //local
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => true,
                        'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        );
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image')) {
                        $data = $this->upload->data();
                        $insert_data['image'] = $data['file_name'];
                    }
                }

                if (isset($_FILES['image_free']) && $_FILES['image_free'] != '') {
                    $config = array(
                        // 'upload_path' => "../APIs/uploads/chapter/", //live
                        'upload_path' => "upload/chapter/", //local
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => true,
                        'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        );
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image_free')) {
                        $data = $this->upload->data();
                        $insert_data['image_free'] = $data['file_name'];
                    }
                }
                
                if (isset($_FILES['course_icon']) && $_FILES['course_icon'] != '') {
                    $config = array(
                        // 'upload_path' => "../APIs/uploads/chapter/", //live
                        'upload_path' => "upload/chapter/", //local
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => true,
                        'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        );
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('course_icon')) {
                        $data = $this->upload->data();
                        $insert_data['course_icon'] = $data['file_name'];
                    }
                }

                $upd = $this->admin_model->updateRecords('tbl_course',$insert_data, array('id' => $course_id));
                if($upd)
                {
        
                    $this->session->set_flashdata('success', 'course has been updated successfully...');

                    redirect('course');
                }
                else{
                    $this->session->set_flashdata('error', 'Error while updating course.');

                    $this->load->view('add_course',$data);
                }

            }
            else{
                $this->session->set_flashdata('error', 'Error while updating course.');

                redirect('course');
            }
        }

        else

        {

            $this->load->view('add_course',$data);

        }

    }

    public function updatePosition()
    {
        if ($_POST['data']) {
            foreach ($_POST['data'] as $key => $value) {
                $this->db->update('tbl_course', array('position' => $value['position']), array('id' => $value['id']), 1);
            }

            echo json_encode(array('status' => true));
        }
    }

}

