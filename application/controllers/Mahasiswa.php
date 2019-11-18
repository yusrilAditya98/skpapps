<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        if ($this->session->userdata('id_kegiatan')) {
            $this->gabungKegiatan($this->session->userdata('id_kegiatan'));
        } else {
            $data['title'] = "Dashboard";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("dashboard/dashboard_mhs");
            $this->load->view("template/footer");
        }
    }
    public function poin_skp()
    {
        $data['title'] = "Poin Skp";
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("mahasiswa/poin_skp");
        $this->load->view("template/footer");
    }
    public function gabungKegiatan($id_kegiatan)
    {
        $this->session->set_userdata('id_kegiatan', intval($id_kegiatan));
        if (!$this->session->userdata('username')) {
            redirect('auth');
        } else {
            $data_peserta_kuliah_tamu = [
                'nim' => $this->session->userdata('username'),
                'id_kuliah_tamu' => intval($id_kegiatan)
            ];
            $this->db->insert('peserta_kuliah_tamu', $data_peserta_kuliah_tamu);
            $this->session->unset_userdata('id_kegiatan');
            $this->session->set_flashdata('message', 'Pendaftaran kuliah tamu berhasil');
            redirect(base_url('Mahasiswa'));
        }
    }
}
