<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*date_default_timezone_set('Canada/Pacific');*/

class Admin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_admin_detail()
    {
        $this->db->where('id', '1');
        $result = $this->db->get('tbl_admin');
        $result = $result->row_array();
        return $result;
    }

    function get_chapter_detail($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tbl_chapter');
        $result = $result->row_array();
        return $result;
    }


    function UserDetail($id)
    {
        $res = $this->db->query("SELECT * FROM tbl_user where id='$id'");
        return $res->result_array();
    }
    function view_user($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tbl_user');
        $data = $result->row_array();

        return $data;
    }

    function view_content($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tbl_cms');
        $data = $result->row_array();

        return $data;
    }

    function getAllUser()
    {
        $this->db->select('*');
        $this->db->from("tbl_user");
        $result = $this->db->get();
        return $count = $result->num_rows();
    }

    function getAllPost()
    {
        $this->db->select('*');
        $this->db->from("tbl_post");
        $result = $this->db->get();
        return $count = $result->num_rows();
    }

    function update_admin_details()
    {
        // $data['first_name'] = $this->input->post('fname', TRUE);
        //$data['last_name'] = $this->input->post('lname', TRUE);
        $data['email_id'] = $this->input->post('email_id', TRUE);
        $data['password'] = md5($this->input->post('password', TRUE));
        $this->db->where('id', 1);
        $upd = $this->db->update('tbl_admin', $data);
        if ($upd)
            return true;
        else
            return false;
    }

    function PverifyCategoryName($name)
    {
        $this->db->where('page_title', $name);
        $this->db->get('tbl_cms');
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function PverifyCategoryNameEdit($name, $id)
    {
        $this->db->where('page_title', $name);
        $this->db->where('id != ', $id);
        $this->db->get('tbl_cms');
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    //cms
    function Aad_page($data)
    {
        $this->db->insert('tbl_cms', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_page($data, $id)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('tbl_cms', $data);
        return ($res) ? TRUE : FALSE;
    }

    function Page_list()
    {
        $result = $this->db->get('tbl_cms');
        $data = $result->result_array();
        return $data;
    }

    function Page_list_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tbl_cms');
        $data = $result->row_array();
        return $data;
    }

    function delete_page($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_cms');
        return true;
    }

    function update_page_status($cms_id, $status)
    {
        $this->db->where('id', $cms_id);
        $this->db->update('tbl_cms', array('status' => $status));
        //echo $this->db->last_query();die;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function user_list()
    {

        $result = $this->db->get('tbl_user');
        $data = $result->result_array();
        return $data;
    }

    function getAlluserajaxcount()
    {

        $result = $this->db->get('tbl_user');
        $data = $result->num_rows();
        return $data;
    }

    function getAllgoalajaxcount()
    {

        $result = $this->db->get('tbl_goal');
        $data = $result->num_rows();
        return $data;
    }

    function getAlluserajax($limit, $start, $order, $dir)
    {

        $sel = $this->db->query("SELECT * FROM tbl_user ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");
        if ($sel->num_rows() > 0) {
            return $sel->result();
        } else {
            return array();
        }
    }

    function getAllgoalajax($limit, $start, $order, $dir)
    {

        $sel = $this->db->query("SELECT * FROM tbl_goal ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");
        if ($sel->num_rows() > 0) {
            return $sel->result();
        } else {
            return array();
        }
    }

    function getAlluserajaxsearch($limit, $start, $search, $order, $dir)
    {

        if (strtolower($search) == 'pro' || strtolower($search) == 'pro user') {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE is_pro_user=1 ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");
        } elseif (strtolower($search) == 'normal' || strtolower($search) == 'normal user') {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE is_pro_user=0 ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");
        } else {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE name LIKE '%" . $search . "%' OR is_pro_user LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");
        }

        if ($sel->num_rows() > 0) {
            return $sel->result();
        } else {
            return array();
        }
    }

    function getAllgoalajaxsearch($limit, $start, $search, $order, $dir)
    {


        $sel = $this->db->query("SELECT * FROM tbl_goal WHERE name LIKE '%" . $search . "%' ORDER BY " . $order . " " . $dir . " LIMIT " . $start . "," . $limit . " ");

        if ($sel->num_rows() > 0) {
            return $sel->result();
        } else {
            return array();
        }
    }

    function getAlluserajaxsearchcount($search)
    {

        if (strtolower($search) == 'pro' || strtolower($search) == 'pro user') {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE is_pro_user=1");
        } elseif (strtolower($search) == 'normal' || strtolower($search) == 'normal user') {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE is_pro_user=0");
        } else {
            $sel = $this->db->query("SELECT * FROM tbl_user WHERE name LIKE '%" . $search . "%' OR is_pro_user LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%'");
        }


        if ($sel->num_rows() > 0) {
            return $sel->num_rows();
        } else {
            return 0;
        }
    }

    function getAllgoalajaxsearchcount($search)
    {


        $sel = $this->db->query("SELECT * FROM tbl_goal WHERE name LIKE '%" . $search . "%' ");

        if ($sel->num_rows() > 0) {
            return $sel->num_rows();
        } else {
            return 0;
        }
    }

    function noti_user_list()
    {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('tbl_user');
        $data = $result->result_array();
        return $data;
    }



    function delete_client($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_user');
        return true;
    }



    function encryptIt($q)
    {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));

        return ($qEncoded);
    }

    function decryptIt($q)
    {
        //echo $q;die;
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        // echo $qDecoded;die;
        return ($qDecoded);
    }


    function update_user_status($user_id, $status)
    {
        $this->db->where('id', $user_id);
        $this->db->update('tbl_user', array('verify' => $status, 'updated_at' => date('y-m-d h:i:s')));
        //echo $this->db->last_query();die;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function user_block($user_id, $status)
    {
        $this->db->where('id', $user_id);
        $this->db->update('tbl_user', array('is_block' => $status, 'updated_at' => date('y-m-d h:i:s')));
        //echo $this->db->last_query();die;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function user_pro($user_id, $status)
    {
        if ($status == 1) {
            $this->db->where('id', $user_id);
            $this->db->update('tbl_user', array('is_pro_user' => $status, 'is_pro_by_admin' => 1,'pro_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')));
        } else {
            $this->db->where('id', $user_id);
            $this->db->update('tbl_user', array('is_pro_user' => $status, 'is_pro_by_admin' => 0, 'updated_at' => date('Y-m-d h:i:s')));
        }

        //echo $this->db->last_query();die;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getSingleRecordById($table, $conditions)
    {
        $query = $this->db->get_where($table, $conditions);
        return $query->row_array();
    }

    public function getAllRecordsById($table, $conditions)

    {

        $query = $this->db->get_where($table, $conditions);

        return $query->result_array();
    }

    public function getAllRecordscountById($table, $conditions)

    {

        $query = $this->db->get_where($table, $conditions);

        return $query->num_rows();
    }

    public function getlast7dayworkout($user_id, $timezone)
    {
        if ($timezone != '') {
            date_default_timezone_set($timezone);
        }
        /* $stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s') . ' +1 day'));
        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 7 days'));
        $end_date = date('Y-m-d 23:59:00');*/
        $stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date . ' - 7 days'));
        $end_date = date('Y-m-d 00:00:01');
        $sel = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='$user_id' AND  exercise_date_time BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");
        if ($sel->num_rows() > 0) {
            $d = $sel->row_array();
            //$dd = $d['total_workout'];
            $dd = $sel->num_rows();

            if ($dd == '') {
                $dd = 0;
            }

            return $dd;
        } else {
            return 0;
        }
    }

    public function getallworkout($user_id)
    {

        $sel = $this->db->query("SELECT count(id) as total_workout,DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='$user_id' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly");

        if ($sel->num_rows() > 0) {

            $d = $sel->row_array();
            $dd = $d['total_workout'];

            if ($dd == '') {
                $dd = 0;
            }
            /* $data['all'] = $dd;
            $data['sminute'] = $worked;*/

            //return $dd;
            return $sel->num_rows();
        } else {

            return 0;
        }
    }

    public function gettodayworkoutdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");
                if ($check->num_rows() == 1) {
                    $value['new_user'] = 1;
                } else {
                    $value['new_user'] = 0;
                }
                $arr[] = $value;
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function gettodayworkoutdashboarddata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' AND exercise_date_time NOT BETWEEN '" . $start_date . "' AND '" . $end_date . "' and exercise_date_time < '" . $end_date . "' GROUP BY DateOnly ORDER BY id DESC");

                if ($check->num_rows() == 0) {
                    $value1['new_user'] = 1;
                } else {
                    $value1['new_user'] = 0;
                }
                $arr[] = $value1;
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function gettodayworkoutnewuserdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,tu.`created_at` as reg_date,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                /*$check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='".$value['user_id']."' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");*/
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' AND exercise_date_time NOT BETWEEN '" . $start_date . "' AND '" . $end_date . "' and exercise_date_time < '" . $end_date . "' GROUP BY DateOnly ORDER BY id DESC");
                if ($check->num_rows() == 0) {

                    $value['new_user'] = 1;
                    $arr[] = $value;
                } else {
                    $value['new_user'] = 0;
                }
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function gettodayworkoutolduserdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,tu.`created_at` as reg_date,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                /* $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='".$value['user_id']."' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");*/
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' AND exercise_date_time NOT BETWEEN '" . $start_date . "' AND '" . $end_date . "' and exercise_date_time < '" . $end_date . "' GROUP BY DateOnly ORDER BY id DESC");
                if ($check->num_rows() == 0) {
                    $value['new_user'] = 1;
                } else {
                    $value['new_user'] = 0;
                    $arr[] = $value;
                }
                //$arr[] = $value;
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function getweekworkoutdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");
        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_date_time BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");

                $value['total_workouts'] = $check->num_rows();

                $check_new_old = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");
                if ($check_new_old->num_rows() == 1) {
                    $value['new_user'] = 1;
                } else {
                    $value['new_user'] = 0;
                }
                $arr[] = $value;
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function getweekworkoutnewuserdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,tu.`created_at` as reg_date,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");
        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_date_time BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");

                $value['total_workouts'] = $check->num_rows();

                $check_new_old = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' AND exercise_date_time NOT BETWEEN '" . $start_date . "' AND '" . $end_date . "' and exercise_date_time < '" . $end_date . "' GROUP BY DateOnly ORDER BY id DESC");
                if ($check_new_old->num_rows() == 0) {
                    $value['new_user'] = 1;
                    $arr[] = $value;
                } else {
                    $value['new_user'] = 0;
                }
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function getweekworkoutolduserdata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tu.*,tu.`created_at` as reg_date,te.* FROM tbl_exercise as te,tbl_user as tu WHERE te.`exercise_date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND te.`exercise_total_time`>= '00:05:00' AND te.`user_id` = tu.`id` GROUP BY te.`user_id` ORDER BY te.`id` DESC");
        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            $arr = array();
            foreach ($d as $value) {
                $check = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_date_time BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND exercise_total_time>= '00:05:00' GROUP BY DateOnly ORDER BY id DESC");

                $value['total_workouts'] = $check->num_rows();

                $check_new_old = $this->db->query("SELECT count(id) as total_workout, DATE(exercise_date_time) DateOnly FROM tbl_exercise WHERE user_id='" . $value['user_id'] . "' AND exercise_total_time>= '00:05:00' AND exercise_date_time NOT BETWEEN '" . $start_date . "' AND '" . $end_date . "' and exercise_date_time < '" . $end_date . "' GROUP BY DateOnly ORDER BY id DESC");
                //print_r($this->db->last_query()); die;
                if ($check_new_old->num_rows() == 0) {
                    $value['new_user'] = 1;
                } else {
                    $value['new_user'] = 0;
                    $arr[] = $value;
                }
                //$arr[] = $value;
            }
            return $arr;
        } else {
            return array();
        }
    }

    public function sendIOSnotification($device_token, $title, $message)
    {
        /*$url = 'https://gateway.sandbox.push.apple.com:2195';
        $cert = base_url() . 'upload/GymTimer_Push_Distribution.pem';

        $gcm_ids = array($device_token);
        $passphrase = "passphrase";
        $message = 'nbad_notification';
        $aps = array('alert' => $message, 'sound' => 'default');
        $fields = array('device_tokens' => $gcm_ids, 'data' => $message, 'aps' => $aps);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, 'upload/GymTimer_Push_Distribution.pem');
        //curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $passphrase);
        curl_setopt($ch, CURLOPT_SSLKEY, $cert);
        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $passphrase);
        curl_setopt($ch, CURLOPT_CERTINFO, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        echo json_encode($result);
        die;*/
        /*------------------------------------------------------------*/
        $apnsServer = 'ssl://gateway.push.apple.com:2195';
        //'ssl://gateway.sandbox.push.apple.com:2195';
        //ssl://gateway.push.apple.com:2195
        $privateKeyPassword = '1';
        $message = $message;
        $deviceToken = trim(strtolower($device_token));
        $pushCertAndKeyPemFile = 'upload/pushcert.pem';

        $stream = stream_context_create();
        stream_context_set_option($stream, 'ssl', 'passphrase', $privateKeyPassword);
        stream_context_set_option($stream, 'ssl', 'local_cert', $pushCertAndKeyPemFile);
        $connectionTimeout = 20;
        $connectionType = STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT;
        $connection = stream_socket_client($apnsServer, $errorNumber, $errorString, $connectionTimeout, $connectionType, $stream);
        if (!$connection) {
            //echo "Failed to connect to the APNS server. Error no = $errorNumber<br/>";
            exit;
        } else {
            //echo "Successfully connected to the APNS. Processing...</br>";
        }

        $messageBody['aps'] = array(
            'message' => 'success',
            'sound' => 'default',
            'title' => $title,
            //'alert' => $message,
            'alert' => array(
                'title' => $title,
                'body' => $message
            ),
            'type' => '3',
            'badge' => +1,
            'user_id' => ''
        );

        $payload = json_encode($messageBody);
        $notification = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));
        if (!$wroteSuccessfully) {
            //echo "Could not send the message<br/>";
            $result = 'False';
        } else {
            $result = 'True';
            //echo "Successfully sent the message<br/>";
        }
        //$result = true;
        fclose($connection);
        return $result;
    }

    function addRecords($table, $post_data)

    {

        $this->db->insert($table, $post_data);

        return $this->db->insert_id();
    }

    function getAllRecords($table)

    {

        $query = $this->db->get($table);

        return $query->result_array();
    }

    public function deleteRecords($table, $where_condition)
    {
        $this->db->where($where_condition);
        $res = $this->db->delete($table);
        return $res;
    }

    function updateRecords($table, $post_data, $where_condition)

    {

        $this->db->where($where_condition);

        return $this->db->update($table, $post_data);

        // echo $this->db->last_query(); die(); 

    }

    function getreferreduser($user_id)
    {
        $sel = $this->db->query("SELECT tr.`id`,tr.`other_user_id`,tu.* FROM tbl_referral as tr,tbl_user as tu WHERE tr.`other_user_id` = '" . $user_id . "' AND tr.`user_id` = tu.`id`");
        if ($sel->num_rows() > 0) {
            return $sel->result_array();
        } else {
            return array();
        }
    }


    public function gettodayrefferalgenerateddashboarddata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT * FROM tbl_user WHERE referral_generate_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }


    public function gettodayrefferaluseddashboarddata($start_date, $end_date)
    {
        $sel = $this->db->query("SELECT tr.`id`,tu.* FROM tbl_user as tu,tbl_referral as tr WHERE tu.`id` = tr.`user_id` AND  tr.`created_at` BETWEEN '" . $start_date . "' AND '" . $end_date . "'");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }

    public function gettotalrefferalgenerateddashboarddata()
    {
        $sel = $this->db->query("SELECT * FROM tbl_user WHERE referral_generate_date IS NOT NULL");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }


    public function gettotalrefferaluseddashboarddata()
    {
        $sel = $this->db->query("SELECT tr.`id`,tu.* FROM tbl_user as tu,tbl_referral as tr WHERE tu.`id` = tr.`user_id` AND  tr.`created_at`");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }


    public function getAllUserwhogeneratecode()
    {
        $sel = $this->db->query("SELECT id FROM tbl_user WHERE referral_generate_date IS NOT NULL");

        return $sel->num_rows();
    }


    public function getAllUserwhousecode()
    {
        $sel = $this->db->query("SELECT tr.`id`,tu.* FROM tbl_user as tu,tbl_referral as tr WHERE tu.`id` = tr.`user_id`");

        return $sel->num_rows();
    }

    function getAllRecordsbyorder($table, $order)
    {

        $this->db->order_by("id", $order);
        $query = $this->db->get($table);
        return $query->result_array();
    }


    function getAllTrack()
    {
        //$sel = $this->db->query("SELECT track.*,admin.`id` as admin_id,admin.`name` FROM tbl_track as track LEFT JOIN tbl_admin as admin ON track.`sub_admin_id` = admin.`id` ORDER BY track.`id` DESC ");

        $sel = $this->db->query("SELECT track.*,admin.`id` as admin_id,admin.`name`,count(mistake.`id`) as total_mistake FROM tbl_track as track LEFT JOIN tbl_mistake_track as mistake ON track.`id` =  mistake.`track_id` LEFT JOIN tbl_admin as admin ON track.`sub_admin_id` = admin.`id` GROUP BY track.`id` ORDER BY track.`id` DESC");

        if ($sel->num_rows() > 0) {
            return $sel->result_array();
        } else {
            return array();
        }
    }

    /*Track request*/
    function getAllTrack_Request()
    {
        $sel = $this->db->query("SELECT track_request.*,user.`name`,user.`device_type` FROM tbl_track_request as track_request LEFT JOIN tbl_user as user ON track_request.`user_id` = user.`id` ORDER BY track_request.`id` DESC");

        if ($sel->num_rows() > 0) {
            return $sel->result_array();
        } else {
            return array();
        }
    }

    function get_specify_Track_Request($id)
    {
       $sel = $this->db->query("SELECT track_request.*,user.`name`,user.`device_type`,user.`device_token` FROM tbl_track_request as track_request LEFT JOIN tbl_user as user ON track_request.`user_id` = user.`id` WHERE track_request.id = '". $id ."'  ORDER BY track_request.`id` DESC");

       return $sel->row_array();
    }

    function check_Track_Request_ready($request_name)
    {
       $sel = $this->db->query("SELECT track.* FROM tbl_track  as track LEFT JOIN tbl_track_request as track_request ON track.`title` = track_request.`track_title` WHERE track.title = '". $request_name . "'");

       return $sel->row_array();
    }

    function getAllTrackBySubadmin($admin_id)
    {
        //$sel = $this->db->query("SELECT track.*,admin.`id` as admin_id,admin.`name`,count(mistake.`id`) as total_mistake FROM tbl_track as track,tbl_admin as admin WHERE track.`sub_admin_id` = '".$admin_id."' AND track.`sub_admin_id` = admin.`id` ORDER BY track.`id` DESC ");

        $sel = $this->db->query("SELECT track.*,admin.`id` as admin_id,admin.`name`,count(mistake.`id`) as total_mistake FROM tbl_track as track RIGHT JOIN tbl_admin as admin ON track.`sub_admin_id` = admin.`id` LEFT JOIN tbl_mistake_track as mistake ON track.`id` =  mistake.`track_id`  WHERE track.`sub_admin_id` = '" . $admin_id . "' GROUP BY track.id ORDER BY track.`id` DESC;");

        if ($sel->num_rows() > 0) {
            return $sel->result_array();
        } else {
            return array();
        }
    }

    public function getSubAdmins()
    {
        $sel = $this->db->query("SELECT admin.*,COUNT(track.`id`) as total_track FROM `tbl_admin` as admin LEFT JOIN tbl_track as track ON track.`sub_admin_id` = admin.`id` WHERE admin.`admin_type` = 0");

        if ($sel->num_rows() > 0) {
            return $sel->result_array();
        } else {
            return array();
        }
    }

    public function getAllLession()
    {
        $sel = $this->db->query("SELECT tc.`name` as course_name,tl.* FROM tbl_lession as tl,tbl_course as tc WHERE tl.`course_id` = tc.`id` ORDER BY `tc`.`name` ASC");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }

    public function getAllChapter()
    {
        $sel = $this->db->query("SELECT tl.`name` as lession_name,tc.* FROM tbl_lession as tl,tbl_chapter as tc WHERE tc.`lession_id` = tl.`id`");

        if ($sel->num_rows() > 0) {
            $d = $sel->result_array();
            return $d;
        } else {
            return array();
        }
    }

    // public function getAllspeedtraining()
    // {
    //     // $data = $this->db->get("SELECT * FROM tbl_patterns WHERE chapter_id = 0");
    //     $sel = $this->db->query("SELECT * FROM tbl_patterns WHERE chapter_id = 0");
	// 	if ($sel->num_rows() > 0) {
    //         $d = $sel->result_array();
    //         return $d;
    //     } else {
    //         return array();
    //     }
    // }
}
