<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Publikasi extends CI_Controller
{
    private $id_kegiatan;
    private $proposal;
    private $lpj;
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_profil_kode') == 7 || $this->session->userdata('user_profil_kode') == 9) {
        } else {
            redirect('auth/blocked');
        }
    }
    private function _notif()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_psik_lpj'] = count($this->kemahasiswaan->getNotifValidasi(5, 'lpj'));
        $this->notif['notif_psik_proposal'] = count($this->kemahasiswaan->getNotifValidasi(5, 'proposal'));
        return $this->notif;
    }
    public function index()
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['title'] = 'Dashboard';
        $data['notif'] = $this->_notif();
        $data['proposal_kegiatan'] = $this->kegiatan->getDaftarProposalKegiatan();
        $data['lpj_kegiatan'] = $this->kegiatan->getDaftarLpjKegiatan();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_publikasi");
        $this->load->view("template/footer");
    }
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $data['notif'] = $this->_notif();
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['filter'] = $this->kegiatan->getDaftarTahunKegiatan();
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, null, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        }
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("publikasi/daftar_validasi_proposal");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }
    public function daftarLpj()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['notif'] = $this->_notif();
        $data['filter'] = $this->kegiatan->getDaftarTahunKegiatan();
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        }
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("publikasi/daftar_validasi_lpj");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }
    public function validasiProposal($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $id = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $jenis_validasi = $this->input->get('jenis_validasi');
        $status_proposal = 1;
        $data = [
            'status_validasi' => $this->input->get('valid'),
            'tanggal_validasi' => date("Y-m-d"),
            'id_user' => $id['id_user'],
            'catatan_revisi' => '-'
        ];
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_proposal = 2;
            $this->session->set_flashdata('message', 'Proposal berhasil direvisi!');
        }
        $this->kegiatan->updateStatusProposal($id_kegiatan, $status_proposal);
        $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'proposal');
        // update validasi
        if ($this->input->get('valid') == 1 && $this->session->userdata('user_profil_kode') != 6) {
            $val_selanjutnya = [
                'status_validasi' => 4,
                'id_user' => 8,
            ];
            $jenis_validasi = 1 + $this->input->get('jenis_validasi');
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($val_selanjutnya, $jenis_validasi, $id_kegiatan, 'proposal');
            $this->session->set_flashdata('message', 'Proposal berhasil divalidasi!');
        }
        redirect('Publikasi/daftarProposal');
    }
    public function validasiLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $id = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $jenis_validasi = $this->input->get('jenis_validasi');
        $status_lpj = 1;
        $data = [
            'status_validasi' => $this->input->get('valid'),
            'tanggal_validasi' => date("Y-m-d"),
            'id_user' => $id['id_user'],
            'catatan_revisi' => '-'
        ];
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_lpj = 2;
            $this->session->set_flashdata('message', 'Lpj berhasil direvisi!');
        }
        $this->kegiatan->updateStatusLpj($id_kegiatan, $status_lpj);
        $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'lpj');
        // update validasi
        if ($this->input->get('valid') == 1 && $this->session->userdata('user_profil_kode') != 6) {
            $val_selanjutnya = [
                'status_validasi' => 4,
                'id_user' => 8,
            ];
            $jenis_validasi = 1 + $this->input->get('jenis_validasi');
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($val_selanjutnya, $jenis_validasi, $id_kegiatan, 'lpj');
            $this->session->set_flashdata('message', 'Lpj berhasil divalidasi!');
        }
        redirect('Publikasi/daftarLpj');
    }
    public function daftarFileDownload()
    {
        $data['title'] = 'File Download';
        $data['notif'] = $this->_notif();
        $data['file_download'] = $this->db->get('file_download')->result_array();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_file_download");
        $this->load->view("template/footer");
    }
}
