<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Track extends CI_Controller

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
        $admin = $this->session->userdata('admin');

        if($admin['admin_type'] == 0)
        {
            //sub admin
            $data['track']      = $this->admin_model->getAllTrackBySubadmin($admin['id']);
        }
        else{
            $data['track']      = $this->admin_model->getAllTrack();
        }

        $data['admin_type'] = $admin['admin_type'];

        $this->load->view('trackList',$data);

    }
    function addTrack()

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {
            /*echo "<pre>";
            print_r($_POST); die;*/
            $track_id = $this->input->post('track_id',TRUE);
            if($track_id == '')
            {
                $insert_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
                $insert_data['artist'] = ucwords($this->input->post('artist',TRUE));
                $insert_data['type'] = $this->input->post('type',TRUE);
                $insert_data['original_key'] = $this->input->post('original_key',TRUE);
                $insert_data['created_at'] = date('Y-m-d H:i:s');
                $insert_data['structure'] = strtoupper($this->input->post('structure',TRUE));

                if($this->admin_type == 0)
                {
                    $insert_data['sub_admin_id'] = $this->admin_id;
                }


                $result = $this->admin_model->addRecords('tbl_track',$insert_data);
                if($result)
                {
                    $total_section = $this->input->post('section_count',TRUE);
                    for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
                    {
                        $section_data['track_id'] = $result;
                        $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                        $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                        /*first line*/
                        $fl = array();
                        for ($f = 1;$f<=16;$f++)
                        {
                            //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                            $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                        }

                        /*second line*/
                        $sl = array();
                        for ($s = 1;$s<=64;$s++)
                        {
                            $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                        }
                        $fl = json_encode($fl);
                        $sl = json_encode($sl);
                        /*print_r($fl);
                        print_r($fl); die;*/
                        if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                            $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                        }
                        elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                            $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                        }
                        else{
                            $same_as = '';
                        }
                        $section_data['first_line'] =  $fl;
                        $section_data['second_line'] = $sl;
                        $section_data['same_as'] = $same_as;
                        $section_data['created_at'] = date('Y-m-d H:i:s');

                        $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
                    }
                    $this->session->set_flashdata('success', 'Track has been added successfully.');

                    redirect('track');
                }
                else{
                    $this->session->set_flashdata('error', 'Error while adding Track.');

                    $this->load->view('add_track',$data);
                }
            }
            else{
                $update_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
                $update_data['artist'] = ucwords($this->input->post('artist',TRUE));
                $update_data['type'] = $this->input->post('type',TRUE);
                $update_data['original_key'] = $this->input->post('original_key',TRUE);
                $update_data['status'] = 1;
                $update_data['structure'] = strtoupper($this->input->post('structure',TRUE));
                $update_data['updated_at'] = date('Y-m-d H:i:s');

                if($this->admin_type == 0)
                {
                    $update_data['sub_admin_id'] = $this->admin_id;
                }

                $result = $this->admin_model->updateRecords('tbl_track',$update_data,array('id' => $track_id));

                //delete section
                $delete = $this->admin_model->deleteRecords('tbl_track_section',array('track_id' => $track_id));

                $total_section = $this->input->post('section_count',TRUE);
                for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
                {
                    $section_data['track_id'] = $track_id;
                    $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                    $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                    /*first line*/
                    $fl = array();
                    for ($f = 1;$f<=16;$f++)
                    {
                        //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                        $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                    }

                    /*second line*/
                    $sl = array();
                    for ($s = 1;$s<=64;$s++)
                    {
                        $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                    }
                    $fl = json_encode($fl);
                    $sl = json_encode($sl);
                    /*print_r($fl);
                    print_r($fl); die;*/
                    if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                    }
                    elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                    }
                    else{
                        $same_as = '';
                    }
                    $section_data['first_line'] =  $fl;
                    $section_data['second_line'] = $sl;
                    $section_data['same_as'] = $same_as;
                    $section_data['created_at'] = date('Y-m-d H:i:s');

                    $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
                }
                $this->session->set_flashdata('success', 'Track has been added successfully.');

                redirect('track');
            }
            
        }

        else

        {

            $this->load->view('add_track',$data);

        }

    }

    function save_draft()
    {
        
        $track_id = $this->input->post('track_id',TRUE);
        if($track_id == '')
        {
            $insert_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
            $insert_data['artist'] = ucwords($this->input->post('artist',TRUE));
            $insert_data['type'] = $this->input->post('type',TRUE);
            $insert_data['original_key'] = $this->input->post('original_key',TRUE);
            $insert_data['status'] = 2;
            $insert_data['created_at'] = date('Y-m-d H:i:s');
            $insert_data['structure'] = strtoupper($this->input->post('structure',TRUE));

            if($this->admin_type == 0)
            {
                $insert_data['sub_admin_id'] = $this->admin_id;
            }


            $result = $this->admin_model->addRecords('tbl_track',$insert_data);
            if($result)
            {
                $total_section = $this->input->post('section_count',TRUE);
                for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
                {
                    $section_data['track_id'] = $result;
                    $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                    $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                    /*first line*/
                    $fl = array();
                    for ($f = 1;$f<=16;$f++)
                    {
                        //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                        $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                    }

                    /*second line*/
                    $sl = array();
                    for ($s = 1;$s<=64;$s++)
                    {
                        $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                    }
                    $fl = json_encode($fl);
                    $sl = json_encode($sl);
                    /*print_r($fl);
                    print_r($fl); die;*/
                    if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                    }
                    elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                    }
                    else{
                        $same_as = '';
                    }
                    $section_data['first_line'] =  $fl;
                    $section_data['second_line'] = $sl;
                    $section_data['same_as'] = $same_as;
                    $section_data['created_at'] = date('Y-m-d H:i:s');

                    $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
                }
                print($result);
            }
            else{
                print($result);
            }
        }
        else{
            $update_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
            $update_data['artist'] = ucwords($this->input->post('artist',TRUE));
            $update_data['type'] = $this->input->post('type',TRUE);
            $update_data['original_key'] = $this->input->post('original_key',TRUE);
            $update_data['updated_at'] = date('Y-m-d H:i:s');
            $update_data['status'] = 2;
            $update_data['structure'] = strtoupper($this->input->post('structure',TRUE));

            if($this->admin_type == 0)
            {
                $update_data['sub_admin_id'] = $this->admin_id;
            }

            $result = $this->admin_model->updateRecords('tbl_track',$update_data,array('id' => $track_id));

            //delete section
            $delete = $this->admin_model->deleteRecords('tbl_track_section',array('track_id' => $track_id));

            $total_section = $this->input->post('section_count',TRUE);
            for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
            {
                $section_data['track_id'] = $track_id;
                $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                /*first line*/
                $fl = array();
                for ($f = 1;$f<=16;$f++)
                {
                    //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                    $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                }

                /*second line*/
                $sl = array();
                for ($s = 1;$s<=64;$s++)
                {
                    $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                }
                $fl = json_encode($fl);
                $sl = json_encode($sl);
                /*print_r($fl);
                print_r($fl); die;*/
                if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                    $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                }
                elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                    $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                }
                else{
                    $same_as = '';
                }
                $section_data['first_line'] =  $fl;
                $section_data['second_line'] = $sl;
                $section_data['same_as'] = $same_as;
                $section_data['created_at'] = date('Y-m-d H:i:s');

                $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
            }
            print($track_id);
        }
        
    }

    function add_section()
    {
        $count = $this->input->post('count',TRUE) + 1;
        $this->load->view('add_track_section', array('count' => $count));
    }

    function delete_track($id)

    {

        $result = $this->admin_model->deleteRecords('tbl_track',array('id' => $id));

        $this->session->set_flashdata('success', 'Track has been deleted successfully.');

        redirect('Track');

    }

    function editTrack($id)

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['track']=$this->admin_model->getSingleRecordById('tbl_track',array('id' => $id));
        $data['track_section']=$this->admin_model->getAllRecordsById('tbl_track_section',array('track_id' => $id));

        $data['custom_error'] = null;

        if($this->input->post('submit'))

        {

            /*echo '<pre>';
            print_r($_POST);
            die;*/
        

            $track_id = $this->input->post('track_id',TRUE);
            if($track_id == '')
            {
                $insert_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
                $insert_data['artist'] = ucwords($this->input->post('artist',TRUE));
                $insert_data['type'] = $this->input->post('type',TRUE);
                $insert_data['original_key'] = $this->input->post('original_key',TRUE);
                $insert_data['created_at'] = date('Y-m-d H:i:s');
                $insert_data['structure'] = strtoupper($this->input->post('structure',TRUE));


                $result = $this->admin_model->addRecords('tbl_track',$insert_data);
                if($result)
                {
                    $total_section = $this->input->post('section_count',TRUE);
                    for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
                    {
                        $section_data['track_id'] = $result;
                        $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                        $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                        /*first line*/
                        $fl = array();
                        for ($f = 1;$f<=16;$f++)
                        {
                            //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                            $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                        }

                        /*second line*/
                        $sl = array();
                        for ($s = 1;$s<=64;$s++)
                        {
                            $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                        }
                        $fl = json_encode($fl);
                        $sl = json_encode($sl);
                        /*print_r($fl);
                        print_r($fl); die;*/
                        if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                            $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                        }
                        elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                            $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                        }
                        else{
                            $same_as = '';
                        }
                        $section_data['first_line'] =  $fl;
                        $section_data['second_line'] = $sl;
                        $section_data['same_as'] = $same_as;
                        $section_data['created_at'] = date('Y-m-d H:i:s');

                        $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
                    }
                    $this->session->set_flashdata('success', 'Track has been updated successfully...');

                    redirect('track');
                }
                else{
                    $this->session->set_flashdata('error', 'Error while updating Track.');

                    $this->load->view('edit_track',$data);
                }

            } else {

                $update_data['title'] = ucwords(strtolower($this->input->post('title',TRUE)));
                $update_data['artist'] = ucwords($this->input->post('artist',TRUE));
                $update_data['type'] = $this->input->post('type',TRUE);
                $update_data['original_key'] = $this->input->post('original_key',TRUE);
                $update_data['status'] = 1;
                $update_data['updated_at'] = date('Y-m-d H:i:s');
                $update_data['structure'] = strtoupper($this->input->post('structure',TRUE));

                $result = $this->admin_model->updateRecords('tbl_track',$update_data,array('id' => $track_id));

                //delete section
                $delete = $this->admin_model->deleteRecords('tbl_track_section',array('track_id' => $track_id));

                $total_section = $this->input->post('section_count',TRUE);
                
                $section = $this->input->post('section');
                

                for ($i = 0;$i<count($this->input->post('section',TRUE));$i++)
                {
                    $section_data['track_id'] = $track_id;
                    $section_data['section'] = strtolower($this->input->post('section',TRUE)[$i]);
                    $section_data['repetition'] = $this->input->post('repetition',TRUE)[$i];

                    /*first line*/
                    $fl = array();
                    for ($f = 1;$f<=16;$f++)
                    {
                        //$ss[$f] = $this->input->post('fl'.$f.'_'.$i,TRUE);
                        $fl[$f] = $this->input->post('fl'.$f,TRUE)[$i];
                    }

                    /*second line*/
                    $sl = array();
                    for ($s = 1;$s<=64;$s++)
                    {
                        $sl[$s] = $this->input->post('sl'.$s,TRUE)[$i]!=''?$this->input->post('sl'.$s,TRUE)[$i]:'';
                    }
                    $fl = json_encode($fl);
                    $sl = json_encode($sl);
                    /*print_r($fl);
                    print_r($fl); die;*/
                    if($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) != ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':'.trim($this->input->post('same_as_2',TRUE)[$i]);
                    }
                    elseif($this->input->post('same_as_1',TRUE)[$i] != '' && trim($this->input->post('same_as_2',TRUE)[$i]) == ''){
                        $same_as = $this->input->post('same_as_1',TRUE)[$i].':1-16';
                    }
                    else{
                        $same_as = '';
                    }
                    $section_data['first_line'] =  $fl;
                    $section_data['second_line'] = $sl;
                    $section_data['same_as'] = $same_as;
                    $section_data['created_at'] = date('Y-m-d H:i:s');

                    $result_section = $this->admin_model->addRecords('tbl_track_section',$section_data);
                }
                $this->session->set_flashdata('success', 'Track has been updated successfully.');

                redirect('track');
            }

        }

        else

        {

            $this->load->view('edit_track',$data);

        }

    }

}

