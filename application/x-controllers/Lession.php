<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Lession extends CI_Controller
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
        $data['lession']      = $this->admin_model->getAllLession();

        usort($data['lession'], function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $this->admin_model->deleteRecords('tbl_patterns', array('lession_id' => 0));

        $this->admin_model->deleteRecords('tbl_lession_details', array('media' => null));

        $this->load->view('lessionList', $data);
    }


    public function delete($id)
    {
        $result = $this->db->get_where('tbl_lession_details', array('lession_id' => $id, 'type' => 'media'))->result_array();

        foreach ($result as $val) {
            // @unlink('../APIs/uploads/chapter/' . $val['media']); //Live
            @unlink('upload/chapter/' . $val['media']); //Local
        }

        // $delete_bpm = $this->admin_model->deleteRecords('tbl_bpm', array('lession_id' => $id));

        // $delete_speed_training_favorites = $this->admin_model->deleteRecords('tbl_speed_training_favorites', array('lession_id' => $id));

        $delete_speed_training = $this->admin_model->deleteRecords('tbl_patterns', array('lession_id' => $id));
        
        $delete_lession_details = $this->deleteLessiondetail($id);

        $result = $this->admin_model->deleteRecords('tbl_lession', array('id' => $id));

        $this->session->set_flashdata('success', 'Lession deleted successfully.');

        redirect('Lession');
    }

    // public function getData($lession_id){
    //     // echo "lession_id is=>" . $lession_id;
    //     // die;

    // 	// $data = $this->testModel->getData();
    //     $data = $this->db->get_where('tbl_patterns', array('lession_id' => $lession_id))->result_array();
    // 	echo json_encode($data);
    // }

    public function add_speed_tranining()
    {
        $st_data['lession_id'] = $this->input->post('lession_id', true);

        if ($st_data['lession_id'] == '') {
            $st_data['lession_id'] = '0';
        }
        $st_data['title'] = ucwords(strtolower($this->input->post('st_title', true)));
        $st_data['category'] = $this->input->post('st_category', true);
        

        if (isset($_FILES['st_image']) && $_FILES['st_image'] != '') {
            $config = array(
                // 'upload_path' => "../APIs/uploads/chapter/", //live
                'upload_path' => "upload/chapter/", //local
                'allowed_types' => "gif|jpg|png|jpeg|pdf|mp4|mp3|mov|m4v|avi",
                'overwrite' => true,
                'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('st_image')) {
                $data = $this->upload->data();
                $st_data['image'] = $data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return false;
            }
        }

        if (isset($_FILES['st_audio']) && $_FILES['st_audio'] != '') {
            $config = array(
                // 'upload_path' => "../APIs/uploads/chapter/", //live
                'upload_path' => "upload/chapter/", //local
                'allowed_types' => "mp4|mp3|mov|m4v|avi",
                'overwrite' => true,
                'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('st_audio')) {
                $data = $this->upload->data();
                $st_data['audio'] = $data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return false;
            }
        }
        $result = $this->admin_model->addRecords('tbl_patterns', $st_data);
        
        $result_details = $this->admin_model->getSingleRecordById('tbl_patterns', array('id' => $result));

        $dataArray = array(
            'result' => $result,
            'result_details' => $result_details
        );

        echo json_encode($dataArray);
    }

    public function training_details($id)
    {
        $details_record = $this->admin_model->getSingleRecordById('tbl_patterns', array('id' => $id));
        echo json_encode($details_record);
    }

    public function editspeedTraining()
    {
        $training_id = $this->input->post('training_id', true);
        // $abc = $_FILES['edit_st_audio']['name'];
        // echo json_encode($abc);
        // die;

        // if ($training_id != '') {
        $edit_st_data['title'] = ucwords(strtolower($this->input->post('edit_st_title', true)));
        $edit_st_data['category'] = $this->input->post('edit_st_category', true);
        $edit_st_data['lession_id'] = $this->input->post('lession_id', true);

        if ($edit_st_data['lession_id'] == '') {
            $edit_st_data['lession_id'] = '0';
        }

        if ($_FILES['edit_st_image'] ['name'] != '') {
            $config = array(
                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                    'upload_path' => "upload/chapter/", //local
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|mp4|mp3|mov|m4v|avi",
                    'overwrite' => true,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('edit_st_image')) {
                $data = $this->upload->data();
                $edit_st_data['image'] = $data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return false;
            }
        } else {
            $edit_st_data['image'] = $this->input->post('old_img', true);
        }
    
        if ($_FILES['edit_st_audio'] ['name'] != '') {
            $config = array(
                    // 'upload_path' => "../APIs/uploads/chapter/", //live
                    'upload_path' => "upload/chapter/", //local
                    'allowed_types' => "mp4|mp3|mov|m4v|avi",
                    'overwrite' => true,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('edit_st_audio')) {
                $data = $this->upload->data();
                $edit_st_data['audio'] = $data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return false;
            }
        } else {
            $edit_st_data['audio'] = $this->input->post('old_audio', true);
        }

        $upd = $this->admin_model->updateRecords('tbl_patterns', $edit_st_data, array('id' => $training_id));
            
        $result_details = $this->admin_model->getSingleRecordById('tbl_patterns', array('id' => $training_id));

        echo json_encode($result_details);
            
        // }
    }

    public function speedtrainingview($id)
    {
        $data = array();
        $data['training'] = $this->admin_model->getSingleRecordById('tbl_patterns', array('id' => $id));
        echo json_encode($data);
    }

    public function deletespeedtraining($id)
    {
        // echo "id is=>" . $id;
        $delete_bpm = $this->admin_model->deleteRecords('tbl_bpm', array('patterns_id' => $id));

        $delete_speed_training_favorites = $this->admin_model->deleteRecords('tbl_speed_training_favorites', array('patterns_id' => $id));

        // $delete_result_details = $this->admin_model->getSingleRecordById('tbl_patterns', array('id' => $id));

        $delete_training = $this->admin_model->deleteRecords('tbl_patterns', array('id' => $id));

        $dataArray = array(
            'result' => $delete_training,
            // 'delete_result' => $delete_result_details
        );

        echo json_encode($dataArray);
    }

    public function add_section()
    {
        $count = preg_replace('/[^0-9]/', '', $this->input->post('divid', true)) + 1;
        $type = $this->input->post('type');
        $unlimited = $this->input->post('unlimited');
        $reco = $this->input->post('reco');
        
        $this->load->view('add_chapter_section', array('count' => $count, 'type' => $type, 'unlimited' => $unlimited, 'reco' => $reco));
    }

    public function addLession()
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['custom_error'] = null;
        $data['course']      = $this->admin_model->getAllRecords('tbl_course');
        $data['patterns']     = $this->admin_model->getAllRecords('tbl_patterns');

        if ($this->input->post('submit')) {

            // $insert_data['ear_training'] = $this->input->post('free_for_all', true) ;
            // echo $insert_data['ear_training'];
            // die;
            // $test = $this->input->post('speed_training');
            // echo $test;
            // // print_r($insert_data['speed_training']);
            // die;

            $insert_data['name'] = $this->input->post('name', true);

            // $insert_data['coming_soon'] = $this->input->post('coming_soon', true):0;
            $insert_data['speed_training'] = $this->input->post('speed_training', true) ? $this->input->post('speed_training', true) : '0';
            $insert_data['unlimited_key_training'] = $this->input->post('unlimited_key_training', true) ? $this->input->post('unlimited_key_training', true) : '0';
            $insert_data['ear_training'] = $this->input->post('ear_training', true) ? $this->input->post('ear_training', true) : '0';
            $insert_data['recognizing'] = $this->input->post('recognizing', true) ? $this->input->post('recognizing', true) : '0';
            $insert_data['free_for_all'] = $this->input->post('free_for_all', true) ;
            $insert_data['course_id'] = $this->input->post('course_id', true);

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

            $result = $this->admin_model->addRecords('tbl_lession', $insert_data);

            if ($insert_data['speed_training'] == 1) {
                $patterns_id = $this->input->post('patterns_id', true);
                $str_arr = explode(",", $patterns_id);
                $cnt = count($str_arr);
                $st_data['lession_id '] = $result;
    
                for ($i=0;$i<=$cnt;$i++) {
                    $upd = $this->admin_model->updateRecords('tbl_patterns', $st_data, array('id' => $str_arr[$i]));
                }
                    
                if ($result) {
                    $button = array(
                        'lession_id' => $result,
                        'media' =>  $this->input->post('button', true),
                        'note' =>  $this->input->post('note', true),
                        'type' => 'button'
                    );
    
                    $button_at = $this->input->post('button_at', true);
    
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
    
                        $target_file =  basename($_FILES["media"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                        $this->upload->initialize($this->set_upload_options());
                        
                        if ($_FILES['media']['name'] != '') {
                            if (!$this->upload->do_upload('media')) {
                                // echo $this->upload->display_errors();
                                // die;
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }
                        }
                        
    
    
                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');
    
    
                        if (in_array($imageFileType, $image)) {
                            $insert_arr[] = array(
                                'lession_id' => $result,
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
                                'lession_id' => $result,
                                'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                'type' => 'video'
                            );
                        }
                    }
                    
                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                        if (($button_at - 1) == $i) {
                            $this->db->insert('tbl_lession_details ', $button);
                        }
    
                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                        }
                    }
    
                    $this->session->set_flashdata('success', 'Lession been added successfully.');
    
                    
    
                    redirect('lession');
                } else {
                    $this->session->set_flashdata('error', 'Error while adding Lession.');
    
                    $this->load->view('add_lession', $data);
                }
            }else if ($insert_data['unlimited_key_training'] == 1) {                    
                if ($result) {
                    $button = array(
                        'lession_id' => $result,
                        'media' =>  $this->input->post('button', true),
                        'note' =>  $this->input->post('note', true),
                        'type' => 'button'
                    );
    
                    $button_at = $this->input->post('button_at', true);
    
                    $this->load->library('upload');
                    $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['key_media']['name']);

                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['key_media']['name'] = $files['key_media']['name'][$i];
                        $_FILES['key_media']['type'] = $files['key_media']['type'][$i];
                        $_FILES['key_media']['tmp_name'] = $files['key_media']['tmp_name'][$i];
                        $_FILES['key_media']['error'] = $files['key_media']['error'][$i];
                        $_FILES['key_media']['size'] = $files['key_media']['size'][$i];
    
                        $target_file =  basename($_FILES["key_media"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                        $this->upload->initialize($this->set_upload_options());
                        
                        if ($_FILES['key_media']['name'] != '') {
                            if (!$this->upload->do_upload('key_media')) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }
                        }
    
                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        // $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');

                        $image_type = $this->input->post('image_type', true)[$i];
                        
    
                        if (in_array($imageFileType, $image)) {
                            $insert_arr[] = array(
                                'lession_id' => $result,
                                'media' => $dataInfo['file_name'],
                                'type' => 'image',
                                'image_type' => $image_type
                            );
                        } 
                        // elseif (in_array($imageFileType, $video)) {
                        //     $source =  $dataInfo['full_path'];
                        //     $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                        //     $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                        //     exec($cmd);
    
                        //     $insert_arr[] = array(
                        //         'lession_id' => $result,
                        //         'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                        //         'type' => 'video',
                        //         'image_type' => $image_type
                        //     );
                        // }
                    }

                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                        if (($button_at - 1) == $i) {
                            $this->db->insert('tbl_lession_details ', $button);
                        }
    
                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                        }
                    }
    
                    $this->session->set_flashdata('success', 'Lession been added successfully.');
                    redirect('lession');
                } else {
                    $this->session->set_flashdata('error', 'Error while adding Lession.');
    
                    $this->load->view('add_lession', $data);
                }
            }else if ($insert_data['recognizing'] == 1) {                    
                if ($result) {    
                    $this->load->library('upload');
                    $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['reco_media']['name']);

                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['reco_media']['name'] = $files['reco_media']['name'][$i];
                        $_FILES['reco_media']['type'] = $files['reco_media']['type'][$i];
                        $_FILES['reco_media']['tmp_name'] = $files['reco_media']['tmp_name'][$i];
                        $_FILES['reco_media']['error'] = $files['reco_media']['error'][$i];
                        $_FILES['reco_media']['size'] = $files['reco_media']['size'][$i];
    
                        $target_file =  basename($_FILES["reco_media"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                        $this->upload->initialize($this->set_upload_options());
                        
                        if ($_FILES['reco_media']['name'] != '') {
                            if (!$this->upload->do_upload('reco_media')) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }
                        }
    
                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');
                        
    
                        if (in_array($imageFileType, $image)) {
                            $insert_arr[] = array(
                                'lession_id' => $result,
                                'media' => $dataInfo['file_name'],
                                'type' => 'image'
                            );
                        }elseif (in_array($imageFileType, $video)) {
                            $source =  $dataInfo['full_path'];
                            $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                            $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                            exec($cmd);
    
                            $insert_arr[] = array(
                                'lession_id' => $result,
                                'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                'type' => 'video',
                            );
                        }
                    }

                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                        }
                    }
    
                    $this->session->set_flashdata('success', 'Lession been added successfully.');
                    redirect('lession');
                } else {
                    $this->session->set_flashdata('error', 'Error while adding Lession.');
    
                    $this->load->view('add_lession', $data);
                }
            } else {
                $this->session->set_flashdata('success', 'Lession been added successfully.');

                redirect('lession');
            }
        } else {
            $this->load->view('add_lession', $data);
        }
    }

    public function editLession($id)
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $lession_id = $this->input->post('lession_id', true);
        $old_media = $this->input->post('old_media');
        $old_key_media = $this->input->post('old_key_media');
        $old_reco_media = $this->input->post('old_reco_media');
        // print_r($old_media);
        // die;

        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');

        $data['lession']        =$this->admin_model->getSingleRecordById('tbl_lession', array('id' => base64_decode($id)));
        $data['custom_error']   = null;
        $data['course']         = $this->admin_model->getAllRecords('tbl_course');
        $data['lession_detail'] = $this->db->get_where('tbl_lession_details', array('lession_id' => $data['lession']['id']))->result_array();
        $data['patterns']       = $this->db->get_where('tbl_patterns', array('lession_id' => $data['lession']['id']))->result_array();
        $data['chapter_url']    = $this->chapter_url;
        // print_r($data['lession']['unlimited_key_training']);
        // die;


        if ($this->input->post('submit')) {
            $lession_id = $this->input->post('lession_id', true);
            if ($lession_id != '') {
                $insert_data['name'] = $this->input->post('name', true);
                // $insert_data['coming_soon'] = $this->input->post('coming_soon', true);
                $insert_data['course_id'] = $this->input->post('course_id', true);
                $insert_data['speed_training'] = $this->input->post('speed_training', true);
                $insert_data['unlimited_key_training'] = $this->input->post('unlimited_key_training', true);
                $insert_data['ear_training'] = $this->input->post('ear_training', true);
                $insert_data['recognizing'] = $this->input->post('recognizing', true);
                $insert_data['free_for_all'] = $this->input->post('free_for_all', true);

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
            
                $upd = $this->admin_model->updateRecords('tbl_lession', $insert_data, array('id' => $lession_id));
                
                
                if ($insert_data['speed_training'] == 1) {
                    $this->deleteLessiondetail($lession_id);
                    if ($upd) {
                        $button = array(
                        'lession_id' => $lession_id,
                        'media' =>  $this->input->post('button', true),
                        'note' =>  $this->input->post('note', true),
                        'type' => 'button'
                    );

                        $button_at = $this->input->post('button_at', true);
                        $this->load->library('upload');
                        $dataInfo = array();
                        $files = $_FILES;
                        $cpt = count($_FILES['media']['name']);

                        for ($i = 0; $i < $cpt; $i++) {
                            if (empty($files['media']['name'][$i])) {
                                $imageFileType = strtolower(pathinfo(basename($old_media[$i]), PATHINFO_EXTENSION));

                                $insert_arr[] = array(
                                    'lession_id' => $lession_id,
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

                                // echo $this->upload->display_errors();
                                // die;
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }


                            if (in_array($imageFileType, $image)) {
                                $insert_arr[] = array(
                                'lession_id' => $lession_id,
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
                                'lession_id' => $lession_id,
                                'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                'type' => 'video'
                            );
                            }
                        }

                        for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                            if (($button_at - 1) == $i) {
                                $this->db->insert('tbl_lession_details', $button);
                            }

                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                            }
                        }

                        $this->session->set_flashdata('success', 'lession has been updated successfully...');

                        redirect('lession');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating lession.');

                        $this->load->view('add_lession', $data);
                    }
                }else if ($insert_data['unlimited_key_training'] == 1) {
                    $this->deleteLessiondetail($lession_id);
                    if ($upd) {
                        $button = array(
                        'lession_id' => $lession_id,
                        'media' =>  $this->input->post('button', true),
                        'note' =>  $this->input->post('note', true),
                        'type' => 'button'
                    );

                        $button_at = $this->input->post('button_at', true);
                        $this->load->library('upload');
                        $dataInfo = array();
                        $files = $_FILES;
                        $cpt = count($_FILES['key_media']['name']);
                        // echo $cpt;
                        // die;

                        for ($i = 0; $i < $cpt; $i++) {
                            $image_type = $this->input->post('image_type', true)[$i];

                            if (empty($files['key_media']['name'][$i])) {
                                $imageFileType = strtolower(pathinfo(basename($old_key_media[$i]), PATHINFO_EXTENSION));

                                $insert_arr[] = array(
                                'lession_id' => $lession_id,
                                'media' => $old_key_media[$i],
                                'type' => in_array($imageFileType, $image) ? 'image' : 'video',
                                'image_type' => $image_type
                                );
                                continue;
                            }

                            $_FILES['key_media']['name'] = $files['key_media']['name'][$i];
                            $_FILES['key_media']['type'] = $files['key_media']['type'][$i];
                            $_FILES['key_media']['tmp_name'] = $files['key_media']['tmp_name'][$i];
                            $_FILES['key_media']['error'] = $files['key_media']['error'][$i];
                            $_FILES['key_media']['size'] = $files['key_media']['size'][$i];

                            $target_file =  basename($_FILES["key_media"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $this->upload->initialize($this->set_upload_options());

                            if (!$this->upload->do_upload('key_media')) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }

                            if (in_array($imageFileType, $image)) {
                                $insert_arr[] = array(
                                    'lession_id' => $lession_id,
                                    'media' => $dataInfo['file_name'],
                                    'type' => 'image',
                                    'image_type' => $image_type
                                );
                            } 
                            // elseif (in_array($imageFileType, $video)) {
                            //     $source =  $dataInfo['full_path'];
                            //     $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                            //     // $cmd = "ffmpeg -i $source -vcodec h264 -acodec mp2 $destination";
                            //     $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                            //     exec($cmd);

                            //     $insert_arr[] = array(
                            //         'lession_id' => $lession_id,
                            //         'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                            //         'type' => 'video',
                            //         'image_type' => $image_type
                            //     );
                            // }
                        }
                        
                        // print_r($image_type);
                        // die;

                        for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                            if (($button_at - 1) == $i) {
                                $this->db->insert('tbl_lession_details', $button);
                            }

                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                            }
                        }

                        $this->session->set_flashdata('success', 'lession has been updated successfully...');

                        redirect('lession');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating lession.');

                        $this->load->view('add_lession', $data);
                    }
                }else if ($insert_data['recognizing'] == 1) {
                    $this->deleteLessiondetail($lession_id);
                    if ($upd) {
                        $this->load->library('upload');
                        $dataInfo = array();
                        $files = $_FILES;
                        $cpt = count($_FILES['reco_media']['name']);

                        for ($i = 0; $i < $cpt; $i++) {

                            if (empty($files['reco_media']['name'][$i])) {
                                $imageFileType = strtolower(pathinfo(basename($old_reco_media[$i]), PATHINFO_EXTENSION));

                                $insert_arr[] = array(
                                'lession_id' => $lession_id,
                                'media' => $old_reco_media[$i],
                                'type' => in_array($imageFileType, $image) ? 'image' : 'video'
                                );
                                continue;
                            }

                            $_FILES['reco_media']['name'] = $files['reco_media']['name'][$i];
                            $_FILES['reco_media']['type'] = $files['reco_media']['type'][$i];
                            $_FILES['reco_media']['tmp_name'] = $files['reco_media']['tmp_name'][$i];
                            $_FILES['reco_media']['error'] = $files['reco_media']['error'][$i];
                            $_FILES['reco_media']['size'] = $files['reco_media']['size'][$i];

                            $target_file =  basename($_FILES["reco_media"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $this->upload->initialize($this->set_upload_options());

                            if (!$this->upload->do_upload('reco_media')) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                return redirect('lession');
                            } else {
                                $dataInfo = $this->upload->data();
                            }

                            if (in_array($imageFileType, $image)) {
                                $insert_arr[] = array(
                                    'lession_id' => $lession_id,
                                    'media' => $dataInfo['file_name'],
                                    'type' => 'image'
                                );
                            }elseif (in_array($imageFileType, $video)) {
                                $source =  $dataInfo['full_path'];
                                $destination = '/var/www/html/piano_test/APIs/uploads/chapter/convert_' . $dataInfo['raw_name'] . '.mp4';
                                // $cmd = "ffmpeg -i $source -vcodec h264 -acodec mp2 $destination";
                                $cmd = "ffmpeg -i $source -vcodec copy -acodec copy $destination";
                                exec($cmd);

                                $insert_arr[] = array(
                                    'lession_id' => $lession_id,
                                    'media' => 'convert_' . $dataInfo['raw_name'] . '.mp4',
                                    'type' => 'video'
                                );
                            }
                        }

                        for ($i = 0; $i < count($insert_arr) + 1; $i++) {
                            if (!empty($insert_arr[$i])) {
                                $this->db->insert('tbl_lession_details', $insert_arr[$i]);
                            }
                        }

                        $this->session->set_flashdata('success', 'lession has been updated successfully...');

                        redirect('lession');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating lession.');

                        $this->load->view('add_lession', $data);
                    }
                } else {
                    $this->session->set_flashdata('success', 'lession has been updated successfully...');

                    redirect('lession');
                }
            } else {
                $this->session->set_flashdata('error', 'Error while updating lession.');

                redirect('lession');
            }
        } else {
            $this->load->view('add_lession', $data);
        }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        // $config['upload_path'] = '../APIs/uploads/chapter/'; //live
        $config['upload_path'] = 'upload/chapter/'; //local
        $config['allowed_types'] = 'gif|jpeg|svg|png|jpg|bmp|webm|mp4|mp3|mov|m4v|avi';
        $config['max_size']      = '0';
        $config['overwrite']     = false;
        $config['encrypt_name']  = true;


        return $config;
    }

    private function deleteLessiondetail($lession_id)
    {
        return $this->db->delete('tbl_lession_details', array('lession_id' => $lession_id));
    }

    public function updatePosition()
    {
        if ($_POST['data']) {
            foreach ($_POST['data'] as $key => $value) {
                $this->db->update('tbl_lession', array('position' => $value['position']), array('id' => $value['id']), 1);
            }

            echo json_encode(array('status' => true));
        }
    }
}
