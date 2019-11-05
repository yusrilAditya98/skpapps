<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->load->view("template/header");
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar");
        $this->load->view("dashboard/dashboard_mhs");
        $this->load->view("template/footer");
    }
}
