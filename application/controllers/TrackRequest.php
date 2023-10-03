<?php

defined('BASEPATH') or exit('No direct script access allowed');



class TrackRequest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('auth');

        if ($this->auth->is_logged_in() == false) {
            redirect(base_url());
        }

        $admin = $this->session->userdata('admin');

        $this->admin_type = $admin['admin_type'];

        $this->admin_id = $admin['id'];

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->model('Admin_model', 'admin_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        $this->output->set_header('Pragma: no-cache');

        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
    {
        $data['track_request'] = $this->admin_model->getAllTrack_Request();

        $this->load->view('trackRequest', $data);
    }

    public function editRequest($id, $action)
    {
        $data =  $this->admin_model->get_specify_Track_Request($id);

        $check_request =  $this->admin_model->check_Track_Request_ready($data['track_title']);

        if ($action == 1 && $data['device_token'] != '') {
            $type = '3';
            $sound = 'default';
            $title = 'Your tab is ready !';
            $user_id = $data['user_id'];
            $device_token = $data['device_token'];
            $track_id = $check_request['id'];
            $message = $data['track_title'] . ' has been transcribed 🔥';

            $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

            if ($data['device_type'] == 'A') /*android*/
             {
                 $fields = array(
                 'to' => $device_token,
                 'priority' => 'high',
                 'data' => array('title' => $title, 'body' => $message,'sound' => $sound,'userid'=> $user_id , 'type' => $type, 'track_id' => $track_id)
                 );
             } else {
                 $fields = array(
                 'to' => $device_token,
                 'priority' => 'high',
                 'notification' => array('title' => $title, 'body' => $message,'sound' => $sound,'userid'=> $user_id , 'type' => $type, 'track_id' => $track_id)
                 );
             }
            $headers = array(
             'Authorization:key=AAAAnGKm-uw:APA91bHqaFnIhdEbDbO_PhWd_pWI-iqNALzB6MLA99tpK5mn9BuwasGzNeh6k_lpnhAN-VYarNJZYAXJo0gyFhoe4LXMS_Awfl6reZ-Fshq0e4D7e42XLIqRN5tR-wn2kro7Pyy2FtbG',
             'Content-Type:application/json'
             );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);

            // $data = json_encode($fields);

            // print_r($result);
            // die;
        } 
        

        $update_data['status'] = $action;

        $result = $this->admin_model->updateRecords('tbl_track_request', $update_data, array('id' => $id));

        if ($action == 1) {
            $this->session->set_flashdata('success', 'Track request has been Accepted...');
        } else {
            $this->session->set_flashdata('error', 'Track request has been Rejcted.');
        }

        redirect('TrackRequest');
    }
}
