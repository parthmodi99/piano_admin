<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Chapter extends CI_Controller
{

    public  $chapter_url = 'http://18.235.99.234/piano/APIs/uploads/chapter/';

    function __construct()
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
        $this->load->view('chapterList', $data);
    }


    function delete($id)
    {

        $result = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $id, 'type' => 'media'))->result_array();

        foreach ($result as $val) {
            @unlink('../APIs/uploads/chapter/' . $val['media']);
        }

        $this->admin_model->deleteRecords('tbl_chapter', array('id' => $id));

        $this->deleteChapterdetail($id);
        $this->session->set_flashdata('success', 'Chapter deleted successfully.');
        redirect('Chapter');
    }

    function add_section()
    {
        $count = $this->input->post('count', TRUE) + 1;
        $type = $this->input->post('type');
        $this->load->view('add_chapter_section', array('count' => $count, 'type' => $type));
    }

    function addChapter()
    {


        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['custom_error'] = null;
        $data['lession']     = $this->admin_model->getAllRecords('tbl_lession');

        if ($this->input->post('submit')) {


            $insert_data['title'] = $this->input->post('title', TRUE);
            $insert_data['lession_id'] = $this->input->post('lession_id', TRUE);

            $result = $this->admin_model->addRecords('tbl_chapter', $insert_data);

            if ($result) {

                $button = array(
                    'chapter_id' => $result,
                    'media' =>  $this->input->post('button', TRUE),
                    'note' =>  $this->input->post('note', TRUE),
                    'type' => 'button'
                );

                $button_at = $this->input->post('button_at', TRUE);

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

                    if (!$this->upload->do_upload('media')) {
                        // echo $this->upload->display_errors();
                        $this->session->set_flashdata('error',  $this->upload->display_errors());
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
                            'type' => 'media'
                        );
                    } else if (in_array($imageFileType, $video)) {

                        $insert_arr[] = array(
                            'chapter_id' => $result,
                            'media' => $dataInfo['file_name'],
                            'type' => 'media'
                        );
                    }
                }

                for ($i = 0; $i < count($insert_arr) + 1; $i++) {

                    if (($button_at - 1) == $i) {
                        $this->db->insert('tbl_chapter_detail', $button);
                    }

                    if (!empty($insert_arr[$i])) {
                        $this->db->insert('tbl_chapter_detail', $insert_arr[$i]);
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



    private function create_thumbnail($video, $target_path)
    {
        echo $video;
        $ffmpeg = 'ffmpeg_new/ffmpeg';

        $video = $video;

        $image_name = md5(date("Y-m-d h:i:s")) . '.jpg';

        //where to save the image
        $image = '../APIs/uploads/chapter/thumb/' . md5(date("Y-m-d h:i:s")) . '.jpg';

        //time to take screenshot at
        $interval = 1;

        //screenshot size
        $size = '1080x1080';

        //ffmpeg command
        /*$cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $image 2>&1";*/
        $cmd = "$ffmpeg -i '$video' -deinterlace -an -ss  00:00:00 -r 1 -y -vcodec mjpeg -f mjpeg '$image' 2>&1";

        $return = `$cmd`;

        $source_image =  "http://" . $_SERVER['SERVER_NAME'] . "/APIs/" . $image;

        // return $image;
        $data = array();

        $data['image_name'] = $image_name;

        $data['image'] = $image;

        return $data;
    }


    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = '../APIs/uploads/chapter/';
        $config['allowed_types'] = 'gif|jpeg|svg|png|jpg|bmp|webm|mp4|mp3|mov|m4v|avi';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;

        return $config;
    }

    function editChapter($id)
    {

        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['chapter'] = $this->admin_model->getSingleRecordById('tbl_chapter', array('id' => base64_decode($id)));
        $data['custom_error'] = null;
        $data['lession']      = $this->admin_model->getAllRecords('tbl_lession');
        $old_media = $this->input->post('old_media');

        $data['chapter_detail']      = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $data['chapter']['id']))->result_array();
        $data['chapter_url']  = $this->chapter_url;

        if ($this->input->post('submit')) {


            $chapter_id = $this->input->post('chapter_id', TRUE);
            if ($chapter_id != '') {

                $insert_data['title'] = $this->input->post('title', TRUE);
                $insert_data['lession_id'] = $this->input->post('lession_id', TRUE);

                $upd = $this->admin_model->updateRecords('tbl_chapter', $insert_data, array('id' => $chapter_id));

                $this->deleteChapterdetail($chapter_id);

                if ($upd) {

                    $button = array(
                        'chapter_id' => $chapter_id,
                        'media' =>  $this->input->post('button', TRUE),
                        'note' =>  $this->input->post('note', TRUE),
                        'type' => 'button'
                    );

                    $button_at = $this->input->post('button_at', TRUE);
                    $this->load->library('upload');
                    $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['media']['name']);


                    for ($i = 0; $i < $cpt; $i++) {

                        if (empty($files['media']['name'][$i])) {
                            $insert_arr[] = array(
                                'chapter_id' => $chapter_id,
                                'media' => $old_media[$i],
                                'type' => 'media'
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
                            $this->session->set_flashdata('error',  $this->upload->display_errors());
                            return redirect('chapter');
                        } else {
                            $dataInfo = $this->upload->data();
                        }


                        $image = array('gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm');
                        $video = array('mp4', 'mp3', 'mov', 'm4v', 'avi');


                        if (in_array($imageFileType, $image)) {

                            $insert_arr[] = array(
                                'chapter_id' => $chapter_id,
                                'media' => $dataInfo['file_name'],
                                'type' => 'media'
                            );
                        } else if (in_array($imageFileType, $video)) {

                            $insert_arr[] = array(
                                'chapter_id' => $chapter_id,
                                'media' => $dataInfo['file_name'],
                                'type' => 'media'
                            );
                        }
                    }

                    for ($i = 0; $i < count($insert_arr) + 1; $i++) {

                        if (($button_at - 1) == $i) {
                            $this->db->insert('tbl_chapter_detail', $button);
                        }

                        if (!empty($insert_arr[$i])) {
                            $this->db->insert('tbl_chapter_detail', $insert_arr[$i]);
                        }
                    }


                    $this->session->set_flashdata('success', 'chapter has been updated successfully...');

                    redirect('chapter');
                } else {
                    $this->session->set_flashdata('error', 'Error while updating chapter.');

                    $this->load->view('add_chapter', $data);
                }
            } else {
                $this->session->set_flashdata('error', 'Error while updating chapter.');

                redirect('chapter');
            }
        } else {
            $this->load->view('add_chapter', $data);
        }
    }


    function chapterview($id)
    {
        $data = array();
        $data['chapter'] = $this->admin_model->getSingleRecordById('tbl_chapter', array('id' => $id));
        $data['lession'] = $this->admin_model->getSingleRecordById('tbl_lession', array('id' => $data['chapter']['lession_id']));
        $data['chapter_detail']      = $this->db->get_where('tbl_chapter_detail', array('chapter_id' => $data['chapter']['id']))->result_array();
        echo json_encode($data);
    }

    private function deleteChapterdetail($chapter_id)
    {
        return $this->db->delete('tbl_chapter_detail', array('chapter_id' => $chapter_id));
    }
}
