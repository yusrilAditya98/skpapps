<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Publikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_profil_kode') != 7) {
            redirect('auth/blocked');
        }
        // is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_kmhsn");
        $this->load->view("template/footer");
    }

    public function daftarProposal()
    { }
}
