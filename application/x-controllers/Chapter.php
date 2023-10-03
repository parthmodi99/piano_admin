<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Chapter extends CI_Controller
{
    // public $chapter_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //live
    public $chapter_url = 'http://localhost/piano_admin/upload/chapter/'; //local

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

        //date_default_timezone_set('Europe/Paris');
    }

    public function index()
    {
        $data['chapter']      = $this->admin_model->getAllChapter();

        usort($data['chapter'], function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $this->load->view('chapterList', $data);
    }


    public function delete($id)
    {
        $result = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $id, 'type' => 'media'))->result_array();

        foreach ($result as $val) {
            // @unlink('../APIs/uploads/chapter/' . $val['media']); //Live
            @unlink('upload/chapter/' . $val['media']); //Local
        }

        $delete_chapter_details = $this->deleteChapterdetail($id);

        $this->admin_model->deleteRecords('tbl_chapter', array('id' => $id));

        $this->session->set_flashdata('success', 'Chapter deleted successfully.');
        redirect('Chapter');
    }

    public function add_section()
    {
        // $count = $this->input->post('count', true) + 1;

        // $divid = $this->input->post('divid', true);
        // $int = (int) filter_var($divid, FILTER_SANITIZE_NUMBER_INT);
        // $count = $int + 1;
        $count = preg_replace('/[^0-9]/', '', $this->input->post('divid', true)) + 1;
        // $count =$this->input->post('cnt_div', true) + 1;
        $type = $this->input->post('type');
        $unlimited = $this->input->post('unlimited');
        $this->load->view('add_chapter_section', array('count' => $count, 'type' => $type, 'unlimited' => $unlimited, 'reco' => 'no'));
    }



    public function addChapter()
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['custom_error'] = null;
        $data['lession']     = $this->admin_model->getAllRecords('tbl_lession');


        if ($this->input->post('submit')) {
            $insert_data['lession_id'] = $this->input->post('lession_id', true);

            $data = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $insert_data['lession_id']));

            if ($data['ear_training'] == 1) {
                $insert_data['title'] = $this->input->post('letter_name', true);
            }else{
                $insert_data['title'] = $this->input->post('title', true);
            }           

            $result = $this->admin_model->addRecords('tbl_chapter', $insert_data);

            if ($result) {
                if ($data['ear_training'] == 1) {  
                    $files = $_FILES; 
                    if (isset($_FILES['letter_image']) && $_FILES['letter_image']['name'] != '') {
                        $this->load->library('upload');
                        // $files = $_FILES; 
                        $dataInfo1 = array();                        

                        $_FILES['letter_image']['name'] = $files['letter_image']['name'];
                        $_FILES['letter_image']['type'] = $files['letter_image']['type'];
                        $_FILES['letter_image']['tmp_name'] = $files['letter_image']['tmp_name'];
                        $_FILES['letter_image']['error'] = $files['letter_image']['error'];
                        $_FILES['letter_image']['size'] = $files['letter_image']['size'];
                        
                        // echo $_FILES["letter_image"]["name"]."<br>";

                        $target_file =  basename($_FILES["letter_image"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $this->upload->initialize($this->set_upload_options());
                        
                        if ($_FILES['letter_image']['name'] != '') {
                            if (!$this->upload->do_upload('letter_image')) {
                                // echo $this->upload->display_errors();
                                // die;
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('chapter');
                            } else {
                                $dataInfo1 = $this->upload->data();
                            }
                        }

                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');

                        if (in_array($imageFileType, $image)) {
                            $insert_arr1[] = array(
                                'chapter_id' => $result,
                                'media' => $dataInfo1['file_name'],
                                'type' => 'image'
                            );
                        } elseif (in_array($imageFileType, $video)) {
                            $source =  $dataInfo1['full_path'];
                            $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo1['raw_name'] . '.mp4';
                            // echo $cmd = "ffmpeg -i $source -vcodec h264 -acodec aac -strict -2 $destination";
                            // ffmpeg -i {input}.mov -vcodec h264 -acodec aac -strict -2 {output}.mp4
                            $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                            exec($cmd);


                            $insert_arr1[] = array(
                                'chapter_id' => $result,
                                'media' => 'convert_' . $dataInfo1['raw_name'] . '.mp4',
                                'type' => 'video'
                            );
                        }

                        for ($i = 0; $i < count($insert_arr1) + 1; $i++) {    
                            if (!empty($insert_arr1[$i])) {
                                $this->db->insert('tbl_chapter_detail', $insert_arr1[$i]);
                            }
                        }

                    }

                    $dataInfo = array();
                    // $files = $_FILES;
                    $cnt = count($_FILES['audio']['name']);
                    // die;

                    // $letter_name = $this->input->post('letter_name', true);
                    $image_type = $this->input->post('image_type', true);

                    for ($i = 0; $i < $cnt; $i++) {
                        $_FILES['audio']['name'] = $files['audio']['name'][$i];
                        $_FILES['audio']['type'] = $files['audio']['type'][$i];
                        $_FILES['audio']['tmp_name'] = $files['audio']['tmp_name'][$i];
                        $_FILES['audio']['error'] = $files['audio']['error'][$i];
                        $_FILES['audio']['size'] = $files['audio']['size'][$i];

                        // echo $_FILES['audio']['name'];

                        $key_name = '';

                        if ($i == 0) {
                            $key_name = 'all_slow';
                        } elseif ($i == 1) {
                            $key_name = 'all_medium';
                        } elseif ($i == 2) {
                            $key_name = 'all_fast';
                        } elseif ($i == 3) {
                            $key_name = 'all_extreme';
                        } elseif ($i == 4) {
                            $key_name = 'four_slow';
                        } elseif ($i == 5) {
                            $key_name = 'four_medium';
                        } elseif ($i == 6) {
                            $key_name = 'four_fast';
                        } elseif ($i == 7) {
                            $key_name = 'four_extreme';
                        } elseif ($i == 8) {
                            if($image_type == "minor"){
                                $key_name = '6.5-';
                            }else{
                                $key_name = '5.5-';
                            }
                        } elseif ($i == 9) {
                            if($image_type == "minor"){
                                $key_name = '7.5-';
                            }else{
                                $key_name = '6.5-';
                            }
                        } elseif ($i == 10) {
                            $key_name = '1.5';
                        } elseif ($i == 11) {
                            if($image_type == "minor"){
                                $key_name = '3.5';
                            }else{
                                $key_name = '2.5';
                            }
                        } elseif ($i == 12) {
                            $key_name = '4.5';
                        } elseif ($i == 13) {
                            if($image_type == "minor"){
                                $key_name = '6.5';
                            }else{
                                $key_name = '5.5';
                            }
                        } elseif ($i == 14) {
                            if($image_type == "minor"){
                                $key_name = '7.5';
                            }else{
                                $key_name = '6.5';
                            }
                        } elseif ($i == 15) {
                            $key_name = '1.5+';
                        } elseif ($i == 16) {
                            if($image_type == "minor"){
                                $key_name = '3.5+';
                            }else{
                                $key_name = '2.5+';
                            }
                        } elseif ($i == 17) {
                            $key_name = '5-';
                        } elseif ($i == 18) {
                            $key_name = '6-';
                        } elseif ($i == 19) {
                            $key_name = '7-';
                        } elseif ($i == 20) {
                            $key_name = '1';
                        } elseif ($i == 21) {
                            $key_name = '2';
                        } elseif ($i == 22) {
                            $key_name = '3';
                        } elseif ($i == 23) {
                            $key_name = '4';
                        } elseif ($i == 24) {
                            $key_name = '5';
                        } elseif ($i == 25) {
                            $key_name = '6';
                        } elseif ($i == 26) {
                            $key_name = '7';
                        } elseif ($i == 27) {
                            $key_name = '1+';
                        } elseif ($i == 28) {
                            $key_name = '2+';
                        } elseif ($i == 29) {
                            $key_name = '3+';
                        } elseif ($i == 30) {
                            $key_name = '4+';
                        }

                        // $this->upload->initialize($this->set_upload_options());

                        // if ($_FILES['audio']['name'] != '') {
                        //     if (!$this->upload->do_upload('audio')) {
                        //         $this->session->set_flashdata('error', $this->upload->display_errors());
                        //         return redirect('chapter');
                        //     } else {
                        //         $dataInfo = $this->upload->data();
                        //     }
                        // }

                        if ($_FILES['audio']['name'] != '') {
                            $config = array(
                                // 'upload_path' => "../APIs/uploads/chapter/", //live
                                'upload_path' => "upload/chapter/", //local
                                'allowed_types' => "3gp|mp3|wav|m4a|m3u|ogg",
                                'overwrite' => true,
                                'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                                );
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('audio')) {
                                // $data = $this->upload->data();
                                // $st_data['audio'] = $data['file_name'];
                                $dataInfo = $this->upload->data();
                            } else {
                                echo $this->upload->display_errors();
                                return false;
                            }
                        }

                        $insert_arr[] = array(
                            'chapter_id' => $result,
                            // 'letter_name' => $letter_name,
                            'image_type' => $image_type,
                            'key_name' => $key_name,
                            'audio' => $dataInfo['file_name']
                        );
                    }

                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_chapter_ear_tarining', $insert_arr[$i]);
                        }
                    }
                }else if ($data['recognizing'] == 1) {  
                    $files = $_FILES;
                    $dataInfo = array();

                    $data['reco_letter_name']   =   $this->input->post('reco_letter_name', true);
                    $data['audio_type']  =   $this->input->post('audio_type', true);
                    
                    // echo "<pre>";
                    // print_r($data['audio_type']);
                    // die;

                    
                    for ($i = 0; $i < 24; $i++) {
                        $key_name = '';

                        if ($i == 0 || $i == 1) {
                            $key_name = 'audio_1';
                        } elseif ($i == 2 || $i == 3) {
                            $key_name = 'audio_2';
                        } elseif ($i == 4 || $i == 5) {
                            $key_name = 'audio_3';
                        } elseif ($i == 6 || $i == 7) {
                            $key_name = 'audio_4';
                        } elseif ($i == 8 || $i == 9) {
                            $key_name = 'audio_5';
                        } elseif ($i == 10 || $i == 11) {
                            $key_name = 'audio_6';
                        } elseif ($i == 12 || $i == 13) {
                            $key_name = 'audio_7';
                        } elseif ($i == 14 || $i == 15) {
                            $key_name = 'audio_8';
                        } elseif ($i == 16 || $i == 17) {
                            $key_name = 'audio_9';
                        } elseif ($i == 18 || $i == 19) {
                            $key_name = 'audio_10';
                        } elseif ($i == 20 || $i == 21) {
                            $key_name = 'audio_11';
                        } elseif ($i == 22 || $i == 23) {
                            $key_name = 'audio_12';
                        }

                        $_FILES['reco_audio_file']['name'] = $files['reco_audio_file']['name'][$i];                        
                        $_FILES['reco_audio_file']['type'] = $files['reco_audio_file']['type'][$i];
                        $_FILES['reco_audio_file']['tmp_name'] = $files['reco_audio_file']['tmp_name'][$i];
                        $_FILES['reco_audio_file']['error'] = $files['reco_audio_file']['error'][$i];
                        $_FILES['reco_audio_file']['size'] = $files['reco_audio_file']['size'][$i];

                        if ($_FILES['reco_audio_file']['name'] != '') {
                            $config = array(
                                // 'upload_path' => "../APIs/uploads/chapter/", //live
                                'upload_path' => "upload/chapter/", //local
                                'allowed_types' => "3gp|mp3|wav|m4a|m3u|ogg",
                                'overwrite' => true,
                                'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                                );
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('reco_audio_file')) {
                                $dataInfo = $this->upload->data();
                            } else {
                                echo $this->upload->display_errors();
                                return false;
                            }
                        }
                        if ($data['reco_letter_name'] != '') {
                            $insert_reco['reco_letter_name'] = $data['reco_letter_name'][$i];
                        }

                        if ($data['audio_type'] != '') {
                            $insert_reco['audio_type'] = $data['audio_type'][$i];
                            // echo $insert_reco['audio_type']."<br>";
                        }

                        $insert_arr[] = array(
                            'chapter_id' => $result,
                            'letter_name' => $insert_reco['reco_letter_name'],
                            'key_name' => $key_name,
                            'audio_type' => $insert_reco['audio_type'],
                            'audio' => $dataInfo['file_name']
                        );
                    }
                    // count($insert_arr);
                    // die;

                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_chapter_recognizing', $insert_arr[$i]);
                        }
                    }
                } else {
                    $button = array(
                        'chapter_id' => $result,
                        'media' =>  $this->input->post('button', true),
                        'note' =>  $this->input->post('note', true),
                        'type' => 'button'
                    );
                    $button_at = $this->input->post('button_at', true);

                    $metronome = array(
                        'chapter_id' => $result,
                        // 'media' =>  $this->input->post('metronome', true),
                        'media' =>  'Metronome inside',
                        'type' => 'metronome'
                    );
                    $metronome_at = $this->input->post('metronome_at', true);

                    /*if question is available */
                    $question = array(
                        'chapter_id' => $result,
                        'media' =>  'Question inside',
                        'type' => 'lession_question'
                    );
                    $question_at = $this->input->post('question_at', true);

                    $this->load->library('upload');
                    $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['media']['name']);

                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['media']['name'] = $files['media']['name'][$i];
                        $_FILES['media']['type'] = $files['media']['type'][$i];
                        $_FILES['media']['tmp_name'] = $files['media']['tmp_name'][$i];
                        $_FILES['media']['error'] = $files['media']['error'][$i];
                        $_FILES['media']['size'] = $files['media']['size'][$i];

                        // echo $_FILES['media']['name'] ;
                        // // die;
                        $target_file =  basename($_FILES["media"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        $this->upload->initialize($this->set_upload_options());

                        if (!$this->upload->do_upload('media')) {
                            // echo $this->upload->display_errors();
                            // die;

                            $this->session->set_flashdata('error', $this->upload->display_errors());
                            return redirect('chapter');
                        } else {
                            $dataInfo = $this->upload->data();
                        }

                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');

                        if (in_array($imageFileType, $image)) {
                            $insert_arr[] = array(
                                'chapter_id' => $result,
                                'media' => $dataInfo['file_name'],
                                'type' => 'image'
                            );
                        } elseif (in_array($imageFileType, $video)) {
                            $source =  $dataInfo['full_path'];
                            $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                            // echo $cmd = "ffmpeg -i $source -vcodec h264 -acodec aac -strict -2 $destination";
                            // ffmpeg -i {input}.mov -vcodec h264 -acodec aac -strict -2 {output}.mp4
                            $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                            exec($cmd);


                            $insert_arr[] = array(
                                'chapter_id' => $result,
                                'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                'type' => 'video'
                            );
                        }
                    }

                    for ($i = 0; $i < count($insert_arr) + 2; $i++) {
                        if (($button_at - 1) == $i) {
                            $this->db->insert('tbl_chapter_detail ', $button);
                        }

                        if (($metronome_at - 1) == $i) {
                            $this->db->insert('tbl_chapter_detail ', $metronome);
                        }

                        if (($question_at - 1) == $i) {
                            $this->db->insert('tbl_chapter_detail ', $question);
                        }

                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_chapter_detail', $insert_arr[$i]);
                        }
                    }
                }


                $this->session->set_flashdata('success', 'Chapter been added successfully.');
                return redirect('chapter');
            } else {
                $this->session->set_flashdata('error', 'Error while adding Chapter.');
                $this->load->view('add_chapter', $data);
            }
        } else {
            $this->load->view('add_chapter', $data);
        }
    }

    /*

        // private function create_thumbnail($video, $target_path)
        // {
        //     echo $video;
        //     $ffmpeg = 'ffmpeg_new/ffmpeg';

        //     $video = $video;

        //     $image_name = md5(date("Y-m-d h:i:s")) . '.jpg';

        //     //where to save the image
        //     $image = '../APIs/uploads/chapter/thumb/' . md5(date("Y-m-d h:i:s")) . '.jpg';

        //     //time to take screenshot at
        //     $interval = 1;

        //     //screenshot size
        //     $size = '1080x1080';

        //     //ffmpeg command
        //     $cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $image 2>&1";
        //     $cmd = "$ffmpeg -i '$video' -deinterlace -an -ss  00:00:00 -r 1 -y -vcodec mjpeg -f mjpeg '$image' 2>&1";

        //     $return = `$cmd`;

        //     $source_image =  "http://" . $_SERVER['SERVER_NAME'] . "/APIs/" . $image;

        //     // return $image;
        //     $data = array();

        //     $data['image_name'] = $image_name;

        //     $data['image'] = $image;

        //     return $data;
        // }



    */



    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        // $config['upload_path'] = '../APIs/uploads/chapter/'; //live
        $config['upload_path'] = 'upload/chapter/'; //local
        $config['allowed_types'] = 'gif|jpeg|svg|png|jpg|bmp|webm|mp4|mov|m4v|avi3gp|mp3|wav|m4a|m3u|ogg';
        $config['max_size']      = '0';
        $config['overwrite']     = false;
        $config['encrypt_name']  = true;


        return $config;
    }

    public function editChapter($id)
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $chapter_id = $this->input->post('chapter_id', true);
        $old_media = $this->input->post('old_media');
        $old_audio = $this->input->post('old_audio');
        $old_reco_audio_file = $this->input->post('old_reco_audio_file');
        $old_letter_image = $this->input->post('old_letter_image');
        // echo $old_letter_image;
        // die;

        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');


        $data['chapter'] = $this->admin_model->getSingleRecordById('tbl_chapter', array('id' => base64_decode($id)));
        // echo $data['chapter']['lession_id'];
        // die;
        $data['custom_error'] = null;
        $data['lession']      = $this->admin_model->getAllRecords('tbl_lession');
        $data['chapter_detail']      = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $data['chapter']['id']))->result_array();
        $data['ear_chapter_detail']      = $this->db->get_where('tbl_chapter_ear_tarining', array('chapter_id' => $data['chapter']['id']))->result_array();
        $data['recognizing_detail']      = $this->db->get_where('tbl_chapter_recognizing', array('chapter_id' => $data['chapter']['id']))->result_array();
        $data['chapter_url']  = $this->chapter_url;
        $data['chk_lession'] = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $data['chapter']['lession_id']));
        $data['is_ear_chapter'] = $data['chk_lession']['ear_training'];
        $data['is_recognizing'] = $data['chk_lession']['recognizing'];

        if ($this->input->post('submit')) {
            if ($chapter_id != '') {
                $insert_data['lession_id'] = $this->input->post('lession_id', true);

                $lession_details = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $insert_data['lession_id']));

                if ($lession_details['ear_training'] == 1) {
                    $insert_data['title'] = $this->input->post('letter_name', true);
                }else{
                    $insert_data['title'] = $this->input->post('title', true);
                }

                $upd = $this->admin_model->updateRecords('tbl_chapter', $insert_data, array('id' => $chapter_id));

                if ($upd) {
                    if ($lession_details['ear_training'] == 1) {
                        $files = $_FILES; 

                        $this->delete_earChapter_detail($chapter_id);

                        if (isset($_FILES['letter_image']) && $_FILES['letter_image']['name'] != '') {
                            $this->deleteChapterdetail($chapter_id);

                            $this->load->library('upload');
                            // $files = $_FILES; 
                            $dataInfo1 = array();                        

                            $_FILES['letter_image']['name'] = $files['letter_image']['name'];
                            $_FILES['letter_image']['type'] = $files['letter_image']['type'];
                            $_FILES['letter_image']['tmp_name'] = $files['letter_image']['tmp_name'];
                            $_FILES['letter_image']['error'] = $files['letter_image']['error'];
                            $_FILES['letter_image']['size'] = $files['letter_image']['size'];
                            
                            // echo $_FILES["letter_image"]["name"]."<br>";

                            $target_file =  basename($_FILES["letter_image"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $this->upload->initialize($this->set_upload_options());
                            
                            if ($_FILES['letter_image']['name'] != '') {
                                if (!$this->upload->do_upload('letter_image')) {
                                    // echo $this->upload->display_errors();
                                    // die;
                                    $this->session->set_flashdata('error', $this->upload->display_errors());
                                    return redirect('chapter');
                                } else {
                                    $dataInfo1 = $this->upload->data();
                                }
                            }

                            $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                            $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');

                            if (in_array($imageFileType, $image)) {
                                $insert_arr1[] = array(
                                    'chapter_id' => $chapter_id,
                                    'media' => $dataInfo1['file_name'],
                                    'type' => 'image'
                                );
                            } elseif (in_array($imageFileType, $video)) {
                                $source =  $dataInfo1['full_path'];
                                $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo1['raw_name'] . '.mp4';
                                // echo $cmd = "ffmpeg -i $source -vcodec h264 -acodec aac -strict -2 $destination";
                                // ffmpeg -i {input}.mov -vcodec h264 -acodec aac -strict -2 {output}.mp4
                                $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                                exec($cmd);


                                $insert_arr1[] = array(
                                    'chapter_id' => $chapter_id,
                                    'media' => 'convert_' . $dataInfo1['raw_name'] . '.mp4',
                                    'type' => 'video'
                                );
                            }

                            for ($i = 0; $i < count($insert_arr1) + 1; $i++) {    
                                if (!empty($insert_arr1[$i])) {
                                    $this->db->insert('tbl_chapter_detail', $insert_arr1[$i]);
                                }
                            }

                        }

                        $dataInfo = array();
                        // $files = $_FILES;
                        $cnt = count($_FILES['audio']['name']);

                        // $letter_name = $this->input->post('letter_name', true);
                        $image_type = $this->input->post('image_type', true);

                        for ($i = 0; $i < $cnt; $i++) {
                            $key_name = '';

                            if ($i == 0) {
                                $key_name = 'all_slow';
                            } elseif ($i == 1) {
                                $key_name = 'all_medium';
                            } elseif ($i == 2) {
                                $key_name = 'all_fast';
                            } elseif ($i == 3) {
                                $key_name = 'all_extreme';
                            } elseif ($i == 4) {
                                $key_name = 'four_slow';
                            } elseif ($i == 5) {
                                $key_name = 'four_medium';
                            } elseif ($i == 6) {
                                $key_name = 'four_fast';
                            } elseif ($i == 7) {
                                $key_name = 'four_extreme';
                            } elseif ($i == 8) {
                                if($image_type == "minor"){
                                    $key_name = '6.5-';
                                }else{
                                    $key_name = '5.5-';
                                }
                            } elseif ($i == 9) {
                                if($image_type == "minor"){
                                    $key_name = '7.5-';
                                }else{
                                    $key_name = '6.5-';
                                }
                            } elseif ($i == 10) {
                                $key_name = '1.5';
                            } elseif ($i == 11) {
                                if($image_type == "minor"){
                                    $key_name = '3.5';
                                }else{
                                    $key_name = '2.5';
                                }
                            } elseif ($i == 12) {
                                $key_name = '4.5';
                            } elseif ($i == 13) {
                                if($image_type == "minor"){
                                    $key_name = '6.5';
                                }else{
                                    $key_name = '5.5';
                                }
                            } elseif ($i == 14) {
                                if($image_type == "minor"){
                                    $key_name = '7.5';
                                }else{
                                    $key_name = '6.5';
                                }
                            } elseif ($i == 15) {
                                $key_name = '1.5+';
                            } elseif ($i == 16) {
                                if($image_type == "minor"){
                                    $key_name = '3.5+';
                                }else{
                                    $key_name = '2.5+';
                                }
                            } elseif ($i == 17) {
                                $key_name = '5-';
                            } elseif ($i == 18) {
                                $key_name = '6-';
                            } elseif ($i == 19) {
                                $key_name = '7-';
                            } elseif ($i == 20) {
                                $key_name = '1';
                            } elseif ($i == 21) {
                                $key_name = '2';
                            } elseif ($i == 22) {
                                $key_name = '3';
                            } elseif ($i == 23) {
                                $key_name = '4';
                            } elseif ($i == 24) {
                                $key_name = '5';
                            } elseif ($i == 25) {
                                $key_name = '6';
                            } elseif ($i == 26) {
                                $key_name = '7';
                            } elseif ($i == 27) {
                                $key_name = '1+';
                            } elseif ($i == 28) {
                                $key_name = '2+';
                            } elseif ($i == 29) {
                                $key_name = '3+';
                            } elseif ($i == 30) {
                                $key_name = '4+';
                            }

                            if (empty($files['audio']['name'][$i])) {
                                // echo "in";
                                // die;

                                $imageFileType = strtolower(pathinfo(basename($old_audio[$i]), PATHINFO_EXTENSION));

                                $insert_arr[] = array(
                                    'chapter_id' => $chapter_id,
                                    // 'letter_name' => $letter_name,
                                    'image_type' => $image_type,
                                    'key_name' => $key_name,
                                    'audio' => $old_audio[$i]
                                );
                                continue;
                            }

                            $_FILES['audio']['name'] = $files['audio']['name'][$i];
                            $_FILES['audio']['type'] = $files['audio']['type'][$i];
                            $_FILES['audio']['tmp_name'] = $files['audio']['tmp_name'][$i];
                            $_FILES['audio']['error'] = $files['audio']['error'][$i];
                            $_FILES['audio']['size'] = $files['audio']['size'][$i];

                            if ($_FILES['audio']['name'] != '') {
                                $config = array(
                                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                                    'upload_path' => "upload/chapter/", //local
                                    'allowed_types' => "3gp|mp3|wav|m4a|m3u|ogg",
                                    'overwrite' => true,
                                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                                    );
                                $this->load->library('upload', $config);
                                if ($this->upload->do_upload('audio')) {
                                    $dataInfo = $this->upload->data();
                                } else {
                                    echo $this->upload->display_errors();
                                    return false;
                                }
                            }

                            $insert_arr[] = array(
                                'chapter_id' => $chapter_id,
                                // 'letter_name' => $letter_name,
                                'image_type' => $image_type,
                                'key_name' => $key_name,
                                'audio' => $dataInfo['file_name']
                            );
                        }

                        for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_chapter_ear_tarining', $insert_arr[$i]);
                            }
                        }
                    }else if ($lession_details['recognizing'] == 1) {  
                        $this->delete_recognizChapter_detail($chapter_id);

                        $files = $_FILES;
                        $dataInfo = array();
                        // $audio_type = $this->input->post('audio_type', true);
    
                        $data['reco_letter_name']   =   $this->input->post('reco_letter_name', true);
                        $data['audio_type']  =   $this->input->post('audio_type', true);
                        
                        // echo "<pre>";
                        // print_r($data['audio_type']);
                        // die;
    
                        
                        for ($i = 0; $i < 24; $i++) {
                            $key_name = '';
    
                            if ($i == 0 || $i == 1) {
                                $key_name = 'audio_1';
                            } elseif ($i == 2 || $i == 3) {
                                $key_name = 'audio_2';
                            } elseif ($i == 4 || $i == 5) {
                                $key_name = 'audio_3';
                            } elseif ($i == 6 || $i == 7) {
                                $key_name = 'audio_4';
                            } elseif ($i == 8 || $i == 9) {
                                $key_name = 'audio_5';
                            } elseif ($i == 10 || $i == 11) {
                                $key_name = 'audio_6';
                            } elseif ($i == 12 || $i == 13) {
                                $key_name = 'audio_7';
                            } elseif ($i == 14 || $i == 15) {
                                $key_name = 'audio_8';
                            } elseif ($i == 16 || $i == 17) {
                                $key_name = 'audio_9';
                            } elseif ($i == 18 || $i == 19) {
                                $key_name = 'audio_10';
                            } elseif ($i == 20 || $i == 21) {
                                $key_name = 'audio_11';
                            } elseif ($i == 22 || $i == 23) {
                                $key_name = 'audio_12';
                            }
                            
                            if ($data['reco_letter_name'] != '') {
                                $insert_reco['reco_letter_name'] = $data['reco_letter_name'][$i];
                            }
    
                            if ($data['audio_type'] != '') {
                                $insert_reco['audio_type'] = $data['audio_type'][$i];
                                // echo $insert_reco['audio_type']."<br>";
                            }

                            if (empty($files['reco_audio_file']['name'][$i])) {
                                $imageFileType = strtolower(pathinfo(basename($old_reco_audio_file[$i]), PATHINFO_EXTENSION));

                                $insert_arr[] = array(
                                    'chapter_id' => $chapter_id,
                                    'letter_name' => $insert_reco['reco_letter_name'],
                                    'key_name' => $key_name,
                                    'audio_type' => $insert_reco['audio_type'],
                                    'audio' => $old_reco_audio_file[$i]                                    
                                );
                                continue;
                            }

                            $_FILES['reco_audio_file']['name'] = $files['reco_audio_file']['name'][$i];                        
                            $_FILES['reco_audio_file']['type'] = $files['reco_audio_file']['type'][$i];
                            $_FILES['reco_audio_file']['tmp_name'] = $files['reco_audio_file']['tmp_name'][$i];
                            $_FILES['reco_audio_file']['error'] = $files['reco_audio_file']['error'][$i];
                            $_FILES['reco_audio_file']['size'] = $files['reco_audio_file']['size'][$i];
    
                            if ($_FILES['reco_audio_file']['name'] != '') {
                                $config = array(
                                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                                    'upload_path' => "upload/chapter/", //local
                                    'allowed_types' => "3gp|mp3|wav|m4a|m3u|ogg",
                                    'overwrite' => true,
                                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                                    );
                                $this->load->library('upload', $config);
                                if ($this->upload->do_upload('reco_audio_file')) {
                                    $dataInfo = $this->upload->data();
                                } else {
                                    echo $this->upload->display_errors();
                                    return false;
                                }
                            }
    
                            $insert_arr[] = array(
                                'chapter_id' => $chapter_id,
                                'letter_name' => $insert_reco['reco_letter_name'],
                                'key_name' => $key_name,
                                'audio_type' => $insert_reco['audio_type'],
                                'audio' => $dataInfo['file_name']
                            );
                        }
    
                        for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_chapter_recognizing', $insert_arr[$i]);
                            }
                        }
                    }else{
                        $this->deleteChapterdetail($chapter_id);

                        $button = array(
                            'chapter_id' => $chapter_id,
                            'media' =>  $this->input->post('button', true),
                            'note' =>  $this->input->post('note', true),
                            'type' => 'button'
                        );
                        $button_at = $this->input->post('button_at', true);
    
                        $metronome = array(
                            'chapter_id' => $chapter_id,
                            // 'media' =>  $this->input->post('metronome', true),
                            'media' =>  'Metronome inside',
                            'type' => 'metronome'
                        );
                        $metronome_at = $this->input->post('metronome_at', true);
    
                        /*if question is available */
                        $question = array(
                            'chapter_id' => $chapter_id,
                            'media' =>  'Question inside',
                            'type' => 'lession_question'
                        );
                        $question_at = $this->input->post('question_at', true);
    
                        $this->load->library('upload');
                        $dataInfo = array();
                        $files = $_FILES;
                        $cpt = count($_FILES['media']['name']);
                        // echo $cpt;
                        // die;
    
                        for ($i = 0; $i < $cpt; $i++) {
                            if (empty($files['media']['name'][$i])) {
                                $imageFileType = strtolower(pathinfo(basename($old_media[$i]), PATHINFO_EXTENSION));
    
                                $insert_arr[] = array(
                                    'chapter_id' => $chapter_id,
                                    'media' => $old_media[$i],
                                    'type' => in_array($imageFileType, $image) ? 'image' : 'video'
                                );
                                continue;
                            }
    
                            $_FILES['media']['name'] = $files['media']['name'][$i];
                            $_FILES['media']['type'] = $files['media']['type'][$i];
                            $_FILES['media']['tmp_name'] = $files['media']['tmp_name'][$i];
                            $_FILES['media']['error'] = $files['media']['error'][$i];
                            $_FILES['media']['size'] = $files['media']['size'][$i];
    
                            $target_file =  basename($_FILES["media"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $this->upload->initialize($this->set_upload_options());
    
                            if (!$this->upload->do_upload('media')) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('chapter');
                            } else {
                                $dataInfo = $this->upload->data();
                            }
    
    
                            if (in_array($imageFileType, $image)) {
                                $insert_arr[] = array(
                                    'chapter_id' => $chapter_id,
                                    'media' => $dataInfo['file_name'],
                                    'type' => 'image'
                                );
                            } elseif (in_array($imageFileType, $video)) {
                                $source =  $dataInfo['full_path'];
                                $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                                // $cmd = "ffmpeg -i $source -vcodec h264 -acodec mp2 $destination";
                                $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                                exec($cmd);
    
                                $insert_arr[] = array(
                                    'chapter_id' => $chapter_id,
                                    'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                    'type' => 'video'
                                );
                            }
                        }
    
                        for ($i = 0; $i < count($insert_arr) + 2; $i++) {
                            if (($button_at - 1) == $i) {
                                $this->db->insert('tbl_chapter_detail', $button);
                            }
    
                            if (($metronome_at - 1) == $i) {
                                $this->db->insert('tbl_chapter_detail', $metronome);
                            }
    
                            if (($question_at - 1) == $i) {
                                $this->db->insert('tbl_chapter_detail ', $question);
                            }
    
                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_chapter_detail', $insert_arr[$i]);
                            }
                        }
                    }

                    $this->session->set_flashdata('success', 'chapter has been updated successfully...');
                    return redirect('chapter');
                    
                } else {
                    $this->session->set_flashdata('error', 'Error while updating chapter.');
                    return redirect('chapter');
                    //  $this->load->view('add_chapter', $data);
                }
            }



            $this->session->set_flashdata('error', 'Error while updating chapter.');
            return redirect('chapter');
        }

        $this->load->view('add_chapter', $data);
    }


    public function chapterview($id)
    {
        $data = array();
        $data['chapter'] = $this->admin_model->getSingleRecordById('tbl_chapter', array('id' => $id));
        $data['lession'] = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $data['chapter']['lession_id']));
        $data['chapter_detail']      = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $data['chapter']['id']))->result_array();
        echo json_encode($data);
    }




    public function updatePosition()
    {
        if ($_POST['data']) {
            foreach ($_POST['data'] as $key => $value) {
                $this->db->update('tbl_chapter', array('position' => $value['position']), array('id' => $value['id']), 1);
            }

            echo json_encode(array('status' => true));
        }
    }


    private function deleteChapterdetail($chapter_id)
    {
        return $this->db->delete('tbl_chapter_detail', array('chapter_id' => $chapter_id));
    }

    private function delete_earChapter_detail($chapter_id)
    {
        return $this->db->delete('tbl_chapter_ear_tarining', array('chapter_id' => $chapter_id));
    }

    private function delete_recognizChapter_detail($chapter_id)
    {
        return $this->db->delete('tbl_chapter_recognizing', array('chapter_id' => $chapter_id));
    }

    public function ear_chapter_view($id)
    {
        $data = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $id));
        echo json_encode($data);
    }
}
