<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Chat extends CI_Controller
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

    public function index(){
        $data['users']      = $this->admin_model->getAllChatList();
        /*echo "<pre>";
        print_r($data); die;*/

        $this->load->view('chatList',$data);
    }

    public function delete($user_id)
    {
        $result = $this->admin_model->deleteRecords('tbl_chat',array('from_id' => $user_id,'to_id' => 1));
        $result = $this->admin_model->deleteRecords('tbl_chat',array('to_id' => $user_id,'from_id' => 1));
        $this->session->set_flashdata('success', 'Chat deleted successfully.');
        redirect('Chat');
    }

    public function conversation($user_id){
        $user_id = base64_decode($user_id);
        $data['messages']      = $this->admin_model->getAllConversationList($user_id);

        $data['user']      = $this->admin_model->getSingleRecordById('tbl_user',array('id' => $user_id));

        if($data['user']){
            $this->admin_model->updateRecords('tbl_chat',array('is_read_by_admin' => 1),array('from_id' => $user_id,'to_id' => 1));
            $this->load->view('conversation',$data);
        }else{
            $this->session->set_flashdata('error', 'Chat User not found.');
            redirect('Chat');
        }
    }

    public function sendmsg(){
        $user_id= $this->input->get('user_id',TRUE);
        $msg= $this->input->get('msg',TRUE);

        if($user_id!='' && $msg!='')
        {
            $add = $this->admin_model->addRecords("tbl_chat",array('from_id' => 1,'to_id' => $user_id,'sent_by' => 2,'message' => $msg,'is_read' => 0,'is_read_by_admin' => 1));
            return true;
        }else{
            return false;
        }
    }

    public function getnewmsg($user_id){
        $messages = $this->admin_model->getAllRecordsById('tbl_chat',array('from_id' => $user_id,'to_id' => 1,'is_read_by_admin' => 0));
        $user = $this->admin_model->getSingleRecordById('tbl_user',array('id' => $user_id));
        if(!empty($messages)){
            $html = '';
            foreach ($messages as $value) {
                $html .= '<li class="left clearfix">
                            <div class="chat-body clearfix">
                                <div class="header" style="padding:15px;">
                                    <strong class="primary-font">'.$user['name'].'</strong>
                                    <small class="pull-right text-muted">
                                        '.$value['created_at'].'</small>
                                </div>
                                <p>
                                    '.$value['message'].'
                                </p>
                            </div>
                        </li>
                        <hr/>';
            }
            $this->admin_model->updateRecords('tbl_chat',array('is_read_by_admin' => 1),array('from_id' => $user_id,'to_id' => 1));
            echo $html;
        }else{
            echo 0;
        }
    }
}