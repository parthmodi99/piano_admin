<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        //date_default_timezone_set('Europe/Paris');

    }

    public function index()
    {

        $count = $this->db->count_all('tbl_course');

        $page = ($this->input->get('page')) ? ($this->input->get('page')) : 0;
        $limit = ($this->input->get('limit')) ? ($this->input->get('limit')) : 10;


        $this->db->limit($limit, $page);
        $result = $this->db->get('tbl_course')->result();

        $marks = array("Peter" => 65, "Harry" => 80, "John" => 78, "Clark" => 90);

        echo json_encode($marks);
        // $result = $this->admin_model->deleteRecords('tbl_course',array('id' => $id));

    }
}
