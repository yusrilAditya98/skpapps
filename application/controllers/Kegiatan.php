<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kegiatan extends CI_Controller
{

    private $rancangan = [];

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_profil_kode') != 2 || $this->session->userdata('user_profil_kode') == 3) {
            redirect('auth/blocked');
        }
    }


    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        if ($this->session->userdata('user_profil_kode') == 2) {
            $this->load->view("dashboard/dashboard_lembaga");
        } else {
            $this->load->view("dashboard/dashboard_bem");
        }
        $this->load->view("template/footer");
    }

    // menampilkan daftar pengajuan rancangan kegiatan
    public function pengajuanRancangan()
    {
        $data['title'] = 'Pengajuan';
        $this->load->model("Model_lembaga", 'lembaga');
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $data['rancangan'] = $this->lembaga->getRancanganKegiatan($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/rancangan");
        $this->load->view("template/footer");
    }

    // tambah rancangan kegiatan
    public function tambahRancanganKegiatan()
    {
        $data['title'] = 'Pengajuan';
        $this->load->model("Model_lembaga", 'lembaga');
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));

        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_tambah_rancangan");
            $this->load->view("template/footer");
        } else {
            $this->rancangan = [
                'nama_proker' => $this->input->post('namaKegiatan'),
                'tanggal_mulai_pelaksanaan' => $this->input->post('tglPelaksanaan'),
                'tanggal_selesai_pelaksanaan' => $this->input->post('tglSelesaiPelaksanaan'),
                'anggaran_kegiatan' => $this->input->post('danaKegiatan'),
                'id_lembaga' => $this->session->userdata('username'),
                'status_rancangan' => 0,
                'tahun_kegiatan' => $this->input->post('tahunKegiatan'),
            ];
            $this->lembaga->insertRancanganKegiatan($this->rancangan);
            redirect('Kegiatan/pengajuanRancangan');
        }
    }
}
