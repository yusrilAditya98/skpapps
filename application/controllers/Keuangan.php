<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Keuangan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    private function _notif()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_keuangan_lpj'] = count($this->kemahasiswaan->getNotifValidasi(6, 'lpj'));
        $this->notif['notif_keuangan_proposal'] = count($this->kemahasiswaan->getNotifValidasi(6, 'proposal'));
        return $this->notif;
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_kmhsn");
        $this->load->view("template/footer");
    }

    public function daftarPengajuanKeuangan()
    {
        $data['title'] = 'Validasi';
        $data['notif'] = $this->_notif();
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("keuangan/daftar_validasi_proposal");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    public function daftarPengajuanLpj()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("keuangan/daftar_validasi_lpj");
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
        }
        $this->kegiatan->updateStatusProposal($id_kegiatan, $status_proposal);
        $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'proposal');

        // update validasi
        if ($this->input->get('valid') == 1) {
            $cek_jenis_Proposal = $this->kegiatan->cekJenisProposal(2, $id_kegiatan);
            $data_validasi = [];
            for ($i = 2; $i <= 6; $i++) {
                if ($cek_jenis_Proposal['status_validasi'] == 3) {
                    if ($i == 2) {
                        $data_validasi[$i] = [
                            'kategori' => 'lpj',
                            'jenis_validasi' => $i,
                            'status_validasi' => 3,
                            'id_user' => 8,
                            'id_kegiatan' => $id_kegiatan,
                        ];
                    } else {
                        $data_validasi[$i] = [
                            'kategori' => 'lpj',
                            'jenis_validasi' => $i,
                            'status_validasi' => 0,
                            'id_user' => 8,
                            'id_kegiatan' => $id_kegiatan,
                        ];
                    }
                } else {
                    $data_validasi[$i] = [
                        'kategori' => 'lpj',
                        'jenis_validasi' => $i,
                        'status_validasi' => 0,
                        'id_user' => 8,
                        'id_kegiatan' => $id_kegiatan,
                    ];
                }
            }
            $this->kegiatan->insertDataValidasi($data_validasi);
            $this->db->set('status_selesai_proposal', 3);
            $this->db->where('id_kegiatan', $id_kegiatan);
            $this->db->update('kegiatan');
        }
        redirect('Keuangan/daftarPengajuanKeuangan');
    }

    public function validasiLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $id = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $jenis_validasi = $this->input->get('jenis_validasi');
        $status_lpj = 3;
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
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <div class="alert-title">Success</div>
              Lpj telah direvisi
            </div>
          </div>');
        }
        $this->kegiatan->updateStatusLpj($id_kegiatan, $status_lpj);
        $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'lpj');

        // update validasi
        if ($this->input->get('valid') == 1) {
            $this->_tambahPoinSkpAnggota($id_kegiatan);
            $this->_updateStatusRancangan($id_kegiatan);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <div class="alert-title">Success</div>
              Lpj berhasil divalidasi
            </div>
          </div>');
        }
        redirect('Keuangan/daftarPengajuanLpj');
    }

    private function _update($nim)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->totalPoinSKp = $this->poinskp->updateTotalPoinSkp($nim);
        $this->db->set('total_poin_skp', $this->totalPoinSKp['bobot']);
        $this->db->where('nim', $nim);
        $this->db->update('mahasiswa');
    }

    private function _tambahPoinSkpAnggota($id_kegiatan)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $anggota = $this->db->get_where('anggota_kegiatan', ['id_kegiatan' => $id_kegiatan, 'keaktifan' => 1])->result_array();
        $kegiatan = $this->db->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->row_array();
        $i = 0;
        foreach ($anggota as $a) {
            $this->dataskp[$i++] = [
                'nim' => $a['nim'],
                'nama_kegiatan' => $kegiatan['nama_kegiatan'],
                'validasi_prestasi' => 1,
                'tgl_pengajuan' => $kegiatan['tgl_pengajuan_lpj'],
                'tgl_pelaksanaan' => $kegiatan['tanggal_kegiatan'],
                'file_bukti' => 'lpj/' . $kegiatan['lpj_kegiatan'],
                'tempat_pelaksanaan' => $kegiatan['lokasi_kegiatan'],
                'catatan' => '-',
                'prestasiid_prestasi' => $a['id_prestasi'],
            ];
        }
        $this->kemahasiswaan->insertPoinSkp($this->dataskp);

        foreach ($anggota as $a) {
            $this->_update($a['nim']);
        }
    }

    private function _updateStatusRancangan($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data = $this->kegiatan->getInfoKegiatan($id_kegiatan);
        if ($data['id_lembaga'] != 0) {
            $this->db->set('status_rancangan', 5);
            $this->db->where('id_daftar_rancangan', $data['acc_rancangan']);
            $this->db->update('daftar_rancangan_kegiatan');
        }
    }
}
