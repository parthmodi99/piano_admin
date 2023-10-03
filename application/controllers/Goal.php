<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Goal extends CI_Controller

{


    function __construct()

    {


        parent::__construct();

        $this->load->library('auth');

        if ($this->auth->is_logged_in() == false)

            redirect(base_url());

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->model('Admin_model', 'admin_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        $this->output->set_header('Pragma: no-cache');

        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        date_default_timezone_set('Europe/Paris');

    }


    public function index()
    {
        $this->load->view('goalList');
    }

    function addGoal()

    {

        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('goal', 'Goal', 'trim|required|min_length[2]|max_length[255]|xss_clean|is_unique[tbl_goal.name]');

            if($this->form_validation->run() == false)
            {
                $this->load->view('add_goal',$data);
            }
            else
            {
                $insert_data['name'] = $this->input->post('goal',TRUE);
                $insert_data['is_created_by_admin'] = 1;
                $insert_data['created_at'] = date('Y-m-d H:i:s');

                $result = $this->admin_model->addRecords('tbl_goal',$insert_data);

                if($result)

                {

                    $this->session->set_flashdata('success', 'Goal has been added successfully.');

                    redirect('Goal');

                }

                else

                {

                    $this->session->set_flashdata('error', 'Error while adding Goal.');

                    $this->load->view('add_goal',$data);

                }
            }

        }

        else

        {

            $this->load->view('add_goal',$data);

        }

    }

    function editGoal($id)
    {
        $data['csrf'] = array(

            'name' => $this->security->get_csrf_token_name(),

            'hash' => $this->security->get_csrf_hash()

        );

        $data['goaledit']=$this->admin_model->getSingleRecordById('tbl_goal',array('id' => $id));

        $data['custom_error'] = null;

        if($this->input->post('submit'))
        {
            if($data['goaledit']['name'] != $this->input->post('goal',TRUE))
            {
                $is_unique =  '|is_unique[tbl_goal.name]';
            }
            else{
                $is_unique =  '';
            }
            $this->form_validation->set_rules('goal', 'Goal', 'trim|required|min_length[2]|max_length[255]|xss_clean'.$is_unique);
            if($this->form_validation->run() == false)
            {
                $this->load->view('add_goal',$data);
            }
            else
            {
                $update_data['name'] = $this->input->post('goal',TRUE);
                $update_data['updated_at'] = date('Y-m-d H:i:s');

                $result = $this->admin_model->updateRecords('tbl_goal',$update_data,array('id' => $id));

                if($result)

                {
                    $this->session->set_flashdata('success', 'Goal has been updated successfully.');
                    redirect('Goal');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Error while updating goal.');

                    $this->load->view('add_goal',$data);
                }
            }
        }
        else
        {
            $this->load->view('add_goal',$data);
        }

    }

    public function getAllgoalsData()
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'is_created_by_admin',
            3 => 'action'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->admin_model->getAllgoalajaxcount();
        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $goal = $this->admin_model->getAllgoalajax($limit, $start, $order, $dir);
        } else {

            $search = $this->input->post('search')['value'];

            $goal = $this->admin_model->getAllgoalajaxsearch($limit, $start, $search, $order, $dir);


            $totalFiltered = $this->admin_model->getAllgoalajaxsearchcount($search);
        }

        $data = array();
        if (!empty($goal)) {
            if ($start == 0) {
                $i = $totalFiltered;
            } else {
                $i = $totalFiltered;
            }
            foreach ($goal as $post) {

                $nestedData['id'] = $i;
                $nestedData['name'] = $post->name;
                $nestedData['is_created_by_admin'] = $post->is_created_by_admin == 1 ? '<span class="label label-success">Admin</span>' : '<span class="label label-success">User</span>';

                $nestedData['action'] = '';


                $nestedData['action'] .= '<a href="'. base_url().'Goal/editGoal/'. $post->id .'" title="Delete" class="btn btn-info btn-xs clickuserbtn"><i class="fa fa-edit"></i></a>&nbsp;';

                $nestedData['action'] .= '<a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' . $post->id . ')"><i class="fa fa-times"></i></a>';

                /*if($nestedData['referral_generate_date'] != '')
                {
                        $nestedData['action'] .= '<a class="btn btn-info btn-xs clickuserbtn" title="Refferal Detail" id="myBtn" data-id="'.$post->id.'" onclick="get_refferal_details('.$post->id.')"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
                }
                if($post->is_pro_user == 1)
                  {
                          $nestedData['action'] .= '<a href="javascript:void(0)"  onclick="pro_user('.$post->id.',0,\'' . $post->name . '\');" id="'.$post->id.'" title="Normal User" class="btn btn-xs btn-default"><B style="color:#090;size:40px;">Normal User</B></a>&nbsp;&nbsp;';
                  }
                  else{
                          $nestedData['action'] .= ' <a href="javascript:void(0)" title="Pro User" class="btn btn-xs btn-default" onclick="pro_user('.$post->id.',1,\'' . $post->name . '\');" ><B style="color:#F00;">Pro User</B></a>&nbsp;&nbsp;';
                  }

                $nestedData['action'] .= '<a class="btn btn-info btn-xs clickuserbtn" title="User Profile" id="myBtn" data-id="'.$post->id.'" onclick="get_user_details('.$post->id.')"><i class="fa fa-eye"></i></a>';
                  if($post->is_block == 0)

                  {

                          $nestedData['action'] .= '<a href="javascript:void(0)"  onclick="block('.$post->id.',1);" id="'.$post->id.'" title="Block" class="btn btn-xs btn-default"><B style="color:#090;size:40px;">Block</B></a>';

                  }

                  else
                  {

                          $nestedData['action'] .= ' <a href="javascript:void(0)" title="Unblock" class="btn btn-xs btn-default" onclick="block('.$post->id.',0);" ><B style="color:#F00;">Unblock</B></a>';
                  }


                  $nestedData['action'] .= '<a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure('.$post->id.')"><i class="fa fa-times"></i></a>';

                  $nestedData['action'] .= '<div id="myModal_'.$post->id.'" class="modal">

                                          <!-- Modal content -->
                                          <div class="modal-content">
                                          <div class="modal-header">

                                              <button type="button" class="close '.$post->id.'" data-dismiss="modal">&times;</button>

                                              <h4 class="modal-title">User Detail</h4>

                                            </div>

                                            <div class="modal-body user" id="'.$post->id.'user_pop" style="height: 400px;">



                                            </div>
                                          </div>

                                        </div>';


                            $nestedData['action'] .= '<div id="refferal_'.$post->id.'" class="modal">

                                          <!-- Modal content -->
                                          <div class="modal-content">
                                          <div class="modal-header">

                                              <button type="button" class="close refferal_'.$post->id.'" data-dismiss="modal">&times;</button>

                                              <h4 class="modal-title">Referral Detail</h4>

                                            </div>

                                            <div class="modal-body user" id="'.$post->id.'_referral_pop" style="">



                                            </div>
                                          </div>

                                        </div>';*/
                $data[] = $nestedData;
                $i--;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    function destroy($id)

    {

        $result = $this->admin_model->deleteRecords('tbl_goal', array('id' => $id));

        $this->session->set_flashdata('success', 'Goal has been deleted successfully.');

        redirect('Goal');

    }
}