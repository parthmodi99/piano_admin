<?php

defined('BASEPATH') or exit('No direct script access allowed');


class User extends CI_Controller

{


    function __construct()

    {


        parent::__construct();

        $this->load->library('auth');

        if ($this->auth->is_logged_in_super_admin() == false)

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

        //echo "hii"; die;
        /*echo date('Y-m-d H:i:s'); die;*/
        if (isset($_GET['filter']) && $_GET['filter'] == 'pro') {
            $data['user'] = $this->admin_model->getAllRecordsById('tbl_user', array('is_pro_user' => 1));
        } else {
            $data['user'] = $this->admin_model->user_list();
        }

        $this->load->view('userList', $data);

    }

    public function userlist()

    {
        //echo "hii"; die;
        /*echo date('Y-m-d H:i:s'); die;*/
        if (isset($_GET['filter']) && $_GET['filter'] == 'pro') {
            $data['user'] = array();
        } else {
            $data['user'] = array();
        }

        $this->load->view('userLists', $data);

    }

    public function getAllusersData()
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'user_type',
            4 => 'created_at',
            5 => 'total_exercise',
            6 => 'pro_at',
            7 => 'action',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->admin_model->getAlluserajaxcount();
        $totalFiltered = $totalData;

        // echo $order;
        // die;
        if (empty($this->input->post('search')['value'])) {
            $user = $this->admin_model->getAlluserajax($limit, $start, $order, $dir);

            /* $messages = $this->admin_model->getAllRecordsById('tbl_user',array('1' =>'1'));
            
            foreach ($messages as $value) {
                $user = $this->admin_model->getAlluserajax($limit, $start, $order, $dir, $value['id']);
            } */
        } else {
            $search = $this->input->post('search')['value'];

            $user = $this->admin_model->getAlluserajaxsearch($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->admin_model->getAlluserajaxsearchcount($search);
        }

        $data = array();
        if (!empty($user)) {
            if ($start == 0) {
                $i = $totalFiltered;
            } else {
                $i = $totalFiltered;
            }
            foreach ($user as $post) {

                $nestedData['id'] = $i;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                if ($post->is_pro_user == 1) {
                    $nestedData['user_type'] = 'Pro User';
                } else {
                    $nestedData['user_type'] = 'Normal User';
                }
                $nestedData['created_at'] = $post->created_at;

                // $nestedData['no_of_exercise'] = $this->admin_model->get_no_of_exercise($post->id);
                $nestedData['no_of_exercise'] = $post->total_exercise;

                if($post->pro_at){
                    $nestedData['pro_at'] = $post->pro_at;
                }else{
                    $nestedData['pro_at'] = '-';
                }
                
                
                $nestedData['action'] = '<a href="'. base_url().'Chat/conversation/'.base64_encode( $post->id ).'" title="Send Message" class="btn btn-xs btn-success"><i class="fa fa-comments"></i></a>';

                if ($post->is_pro_user == 1) {
                    $nestedData['action'] .= '<a href="javascript:void(0)"  onclick="pro_user(' . $post->id . ',0,\'' . $post->name . '\');" id="' . $post->id . '" title="Normal User" class="btn btn-xs btn-default"><B style="color:#090;size:40px;">Normal User</B></a>&nbsp;&nbsp;';
                } else {
                    $nestedData['action'] .= ' <a href="javascript:void(0)" title="Pro User" class="btn btn-xs btn-default" onclick="pro_user(' . $post->id . ',1,\'' . $post->name . '\');" ><B style="color:#F00;">Pro User</B></a>&nbsp;&nbsp;';
                }

                $nestedData['action'] .= '                    
                <a class="btn btn-info btn-xs clickuserbtn" title="User Profile" id="myBtn" data-id="' . $post->id . '" onclick="get_user_details(' . $post->id . ')"><i class="fa fa-eye"></i></a>';
                if ($post->is_block == 0) {

                    $nestedData['action'] .= '<a href="javascript:void(0)"  onclick="block(' . $post->id . ',1);" id="' . $post->id . '" title="Block" class="btn btn-xs btn-default"><B style="color:#090;size:40px;">Block</B></a>';

                } else {

                    $nestedData['action'] .= ' <a href="javascript:void(0)" title="Unblock" class="btn btn-xs btn-default" onclick="block(' . $post->id . ',0);" ><B style="color:#F00;">Unblock</B></a>';
                }


                $nestedData['action'] .= '<a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' . $post->id . ')"><i class="fa fa-times"></i></a>';

                $nestedData['action'] .= '<div id="myModal_' . $post->id . '" class="modal">

									  <!-- Modal content -->
									  <div class="modal-content">
									  <div class="modal-header">

					                      <button type="button" class="close ' . $post->id . '" data-dismiss="modal">&times;</button>

					                      <h4 class="modal-title">User Detail</h4>

					                    </div>
									    
									    <div class="modal-body user" id="' . $post->id . 'user_pop" style="height: 400px;">

                    

                    					</div>
									  </div>

									</div>';


                $nestedData['action'] .= '<div id="refferal_' . $post->id . '" class="modal">

									  <!-- Modal content -->
									  <div class="modal-content">
									  <div class="modal-header">

					                      <button type="button" class="close refferal_' . $post->id . '" data-dismiss="modal">&times;</button>

					                      <h4 class="modal-title">Referral Detail</h4>

					                    </div>
									    
									    <div class="modal-body user" id="' . $post->id . '_referral_pop" style="">

                    

                    					</div>
									  </div>

									</div>';
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

    function pro_user()
    {
        $user_id = $this->input->post('user_id', true);

        $status = $this->input->post('status', true);

        //print_r($status); die;

        $upd = $this->admin_model->user_pro($user_id, $status);

        if ($upd) {

            echo 1;

        } else {

            echo 0;

        }
    }


    function update_user_status()

    {

        $user_id = $this->input->post('user_id', true);

        $status = $this->input->post('status', true);

        //print_r($status); die;

        $upd = $this->admin_model->update_user_status($user_id, $status);

        if ($upd) {

            echo 1;

        } else {

            echo 0;

        }

    }

    function user_block()

    {

        $user_id = $this->input->post('user_id', true);

        $status = $this->input->post('status', true);

        //print_r($status); die;

        $upd = $this->admin_model->user_block($user_id, $status);

        if ($upd) {

            echo 1;

        } else {

            echo 0;

        }

    }

    public function UserDetail()

    {

        $id = $this->input->post('id');

        $data = $this->admin_model->UserDetail($id);

        echo json_encode($data);

        die();

    }

    function userview()

    {

        $user_id = $this->uri->segment('3');

        $user = $this->admin_model->view_user($user_id);


        if (!empty($user)) {


            $this->load->view('user_popup', array('user' => $user));

        } else

            echo false;

    }


    function refferalview()

    {

        $user_id = $this->uri->segment('3');

        //$data['total_customers'] = $this->user->getAllcustomer();
        $user = $this->admin_model->getreferreduser($user_id);
        $result = $this->admin_model->view_user($user_id);
        //print_r($user); die;
        $this->load->view('ref_user_popup', array('userslist' => $user, 'user' => $result));

    }

    function delete_client($id)

    {

        $result = $this->admin_model->delete_client($id);

        redirect('User/userlist');

    }

}

