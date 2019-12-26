<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kegiatan extends CI_Controller
{
    private $rancangan = [];
    private $id_rancangan;
    private $id_kegiatan;
    private $proposal = [];
    public function __construct()
    {
        // 1,4,5,6,7
        parent::__construct();
        is_logged_in();
    }
    // metod mememberikan notif pada sidebar
    private function _notif()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_bem_lpj'] = count($this->kemahasiswaan->getNotifValidasi(2, 'lpj'));
        $this->notif['notif_bem_proposal'] = count($this->kemahasiswaan->getNotifValidasi(2, 'proposal'));
        return $this->notif;
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        if ($this->session->userdata('user_profil_kode') == 2) {
            $this->load->view("dashboard/dashboard_lembaga");
        } else {
            $this->load->view("dashboard/dashboard_lembaga");
        }
        $this->load->view("template/footer");
    }
    // menampilkan daftar pengajuan rancangan kegiatan
    public function pengajuanRancangan()
    {
        $data['title'] = 'Pengajuan';
        $data['notif'] = $this->_notif();
        $this->load->model("Model_lembaga", 'lembaga');
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $data['tahun'] = $this->lembaga->getTahunRancangan();
        $tahun = $this->input->get('tahun');
        if ($tahun) {
            $data['rancangan'] = $this->lembaga->getRancanganKegiatan($this->session->userdata('username'), $tahun);
            $data['dana_pagu'] = $this->lembaga->getDanaPagu($this->session->userdata('username'), $tahun);
        } else {
            $data['rancangan'] = $this->lembaga->getRancanganKegiatan($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
            $data['dana_pagu'] = $this->lembaga->getDanaPagu($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        }
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
        $data['notif'] = $this->_notif();
        $this->load->model("Model_lembaga", 'lembaga');
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $dana = $this->lembaga->getDanaPagu($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_tambah_rancangan");
            $this->load->view("template/footer");
        } else {
            $dana_proker = $this->input->post('danaKegiatan');
            $jumlah_dana_lembaga = $dana['anggaran_lembaga'] + $dana_proker;
            if ($jumlah_dana_lembaga > $dana['anggaran_kemahasiswaan']) {
                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Warning</div>
                    Anggaran lembaga melebihi dana pagu!
                </div>
              </div>');
                redirect('Kegiatan/pengajuanRancangan');
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
                $this->lembaga->updateAnggaranLembaga($jumlah_dana_lembaga, $this->session->userdata('username'), $this->input->post('tahunKegiatan'));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Success</div>
                 Rancangan kegiatan berhasil ditambah!
                </div>
              </div>');
                redirect('Kegiatan/pengajuanRancangan');
            }
        }
    }
    // edit rancangan kegiatan 
    // 0 belum setuju; 1 setuju ; 2 revisi ; 3 pengajuan
    public function editRancanganKegiatan($id_rancangan)
    {
        $data['title'] = 'Pengajuan';
        $this->load->model("Model_lembaga", 'lembaga');
        $data['notif'] = $this->_notif();
        $data['rancangan'] = $this->lembaga->getDataRancangan($id_rancangan);
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $dana = $this->lembaga->getDanaPagu($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        if ($data['rancangan']['id_lembaga'] != $this->session->userdata('username')) {
            redirect('Kegiatan/pengajuanRancangan');
        }
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_edit_rancangan");
            $this->load->view("template/footer");
        } else {
            $dana_proker_lama = $data['rancangan']['anggaran_kegiatan'];
            $dana_proker_baru = $this->input->post('danaKegiatan');
            $jumlah_dana_lembaga_lama = $dana['anggaran_lembaga'] - $dana_proker_lama;
            $jumlah_dana_lembaga_baru = $jumlah_dana_lembaga_lama + $dana_proker_baru;
            if ($jumlah_dana_lembaga_baru > $dana['anggaran_kemahasiswaan']) {
                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Warning</div>
                    Anggaran lembaga melebihi dana pagu!
                </div>
              </div>');
                redirect('Kegiatan/pengajuanRancangan');
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
                if ($data['rancangan']['status_rancangan'] == 2) {
                    $this->rancangan['status_rancangan'] = 3;
                }
                $this->lembaga->updateRancanganKegiatan($this->rancangan, $id_rancangan);
                $this->lembaga->updateAnggaranLembaga($jumlah_dana_lembaga_baru, $this->session->userdata('username'), $this->input->post('tahunKegiatan'));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Success</div>
                 Rancangan kegiatan berhasil diperbaharui!
                </div>
              </div>');
                redirect('Kegiatan/pengajuanRancangan');
            }
        }
    }
    // hapus rancangan kegiatan
    public function hapusRancanganKegiatan($id_rancangan)
    {
        $data['title'] = 'Pengajuan';
        $this->load->model("Model_lembaga", 'lembaga');
        $data['rancangan'] = $this->lembaga->getDataRancangan($id_rancangan);
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $dana = $this->lembaga->getDanaPagu($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        if ($data['rancangan']['id_lembaga'] != $this->session->userdata('username')) {
            redirect('Kegiatan/pengajuanRancangan');
        }
        $dana_proker_lama = $data['rancangan']['anggaran_kegiatan'];
        $jumlah_dana_lembaga_baru = $dana['anggaran_lembaga'] - $dana_proker_lama;
        $this->lembaga->updateAnggaranLembaga($jumlah_dana_lembaga_baru, $this->session->userdata('username'), $data['rancangan']['tahun_kegiatan']);
        $this->lembaga->deleteRancanganKegiatan($id_rancangan);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
          <div class="alert-title">Success</div>
         Rancangan kegiatan berhasil dihapus!
        </div>
      </div>');
        redirect('Kegiatan/pengajuanRancangan');
    }
    // pengajuan rancangan kegiatan
    // 0 belum setuju; 1 setuju ; 2 revisi ; 3 pengajuan ; 4 sedang mengajukan
    public function ajukanRancangan()
    {
        $data['title'] = 'Pengajuan';
        $this->load->model("Model_lembaga", 'lembaga');
        $data['lembaga'] = $this->lembaga->getDataLembaga($this->session->userdata('username'));
        $data['rancangan'] = $this->lembaga->getRancanganKegiatan($this->session->userdata('username'), $data['lembaga']['tahun_rancangan']);
        $index = 0;
        foreach ($data['rancangan'] as $r) {
            $this->rancangan[$index++] = [
                'id_daftar_rancangan' => $r['id_daftar_rancangan'],
                'status_rancangan' => 3,
            ];
        }
        // update status rancangan mengubah menjadi nilai ajukan
        $this->lembaga->updateStatusRancangan($this->rancangan);
        // update status rancangan menjadi disable buat mengajukan kegiatan
        $this->lembaga->updateStatusRencanaKegiatan($this->session->userdata('username'), 0);
        // update statues rancangan kegiatan list
        $this->lembaga->updateStatusRancanganByPeriode(3, $this->session->userdata('username'), $this->input->post('tahunPengajuan'));
        redirect('Kegiatan/pengajuanRancangan');
    }
    // melihat daftar pengajuan proposal kegiatan
    public function daftarPengajuanProposal()
    {
        $data['title'] = "Pengajuan";
        $data['notif'] = $this->_notif();
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'));
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/pengajuan_proposal", $data);
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }
    // metod untuk melakukan pengajuan proposal
    public function tambahProposal($id_proker)
    {
        $this->load->model('Model_lembaga', 'lembaga');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['notif'] = $this->_notif();
        $data['proker'] = $this->lembaga->getDataRancangan($id_proker);
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $data['dana'] = $this->db->get('sumber_dana')->result_array();
        $gambar = [];
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_tambah_proposal");
            $this->load->view("template/footer");
        } else {
            $jumlahAnggota = $this->input->post('jumlahAnggota');
            if ($jumlahAnggota <= 0) {
                $this->session->set_flashdata('failed', 'Anggota kegiatan tidak boleh kosong');
                redirect("Kegiatan/daftarPengajuanProposal");
            }

            // get id tingkatan
            $sm_id = $this->input->post('tingkatKegiatan');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_id])->row_array();
            $proposal = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'status_selesai_proposal' => 0,
                'status_selesai_lpj' => 0,
                'dana_kegiatan' => $this->input->post('danaKegiatan'),
                'dana_proposal' => $this->input->post('danaKegiatanDiterima'),
                'id_lembaga' => $this->session->userdata('username'),
                'tanggal_kegiatan' => $this->input->post('tglPelaksanaan'),
                'lokasi_kegiatan' => $this->input->post('tempatPelaksanaan'),
                'periode' => $this->input->post('tahun_kegiatan'),
                'acc_rancangan' => $this->input->post('id_rancangan'),
                'deskripsi_kegiatan' => $this->input->post('deskripsiKegiatan'),
                'tgl_pengajuan_proposal' => date("Y-m-d"),
                'id_penanggung_jawab' => $this->input->post('nim'),
                'nama_penanggung_jawab' => $this->input->post('penanggungJawab'),
                'no_whatsup' => $this->input->post('noTlpn'),
                'id_tingkatan' => $idTingkatan['id_tingkatan'],
                'waktu_pengajuan' => time()
            ];
            // upload file proposal
            if ($_FILES['fileProposal']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/proposal/';
                $config['file_name'] = $proposal['waktu_pengajuan'] . 'file_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileProposal')) {
                    $proposal['proposal_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaProposal']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_proposal/';
                $config2['file_name'] = $proposal['waktu_pengajuan'] . '_berita_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaProposal')) {
                    $proposal['berita_proposal'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/proposal/" . $proposal['proposal_kegiatan']);
                    $this->session->set_flashdata('failed', 'File berita proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanProposal1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_proposal/';
                $config3['file_name'] = $proposal['waktu_pengajuan'] . '_gambar1_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanProposal1')) {
                    $gambar['d_proposal_1'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/berita_proposal/" .  $proposal['proposal_kegiatan']);
                    unlink(FCPATH . "file_bukti/proposal/" . $proposal['berita_proposal']);
                    $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanProposal2']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_proposal/';
                $config3['file_name'] = $proposal['waktu_pengajuan'] . '_gambar2_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanProposal2')) {
                    $gambar['d_proposal_2'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/berita_proposal/" .  $proposal['proposal_kegiatan']);
                    unlink(FCPATH . "file_bukti/proposal/" . $proposal['berita_proposal']);
                    unlink(FCPATH . "file_bukti/foto_proposal/" . $gambar['d_proposal_1']);
                    $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }

            $this->kegiatan->insertKegiatan($proposal);
            $kegiatan = $this->kegiatan->getIdKegiatan($proposal['id_penanggung_jawab'], $proposal['nama_kegiatan'], $proposal['waktu_pengajuan']);
            // insert data dokumentasi
            $gambar['id_kegiatan'] = $kegiatan['id_kegiatan'];
            $this->kegiatan->insertDokumentasiKegiatan($gambar);
            // insert dana kegiatan
            $dana = [
                1 => $this->input->post('dana1'),
                2 => $this->input->post('dana2'),
                3 => $this->input->post('dana3'),
                4 => $this->input->post('dana4'),
                5 => $this->input->post('dana5')
            ];
            $data_dana = [];
            foreach ($dana as $d) {
                if ($d != 0) {
                    $data_dana[$d] = [
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                        'id_sumber_dana' => $d
                    ];
                }
            }
            $this->kegiatan->insertDanaKegiatan($data_dana);
            // insert anggota kegiatan

            $data_anggota = [];
            for ($i = 1; $i <= $jumlahAnggota; $i++) {
                $data_anggota[$i] = [
                    'nim' => $this->input->post('nim_' . $i),
                    'id_kegiatan' => $kegiatan['id_kegiatan'],
                    'keaktifan' => 0,
                    'id_prestasi' => $this->input->post('prestasi_' . $i)
                ];
            }
            $this->kegiatan->insertAnggotaKegiatan($data_anggota);
            // insert validasi 
            $data_validasi = [];
            for ($i = 2; $i <= 6; $i++) {
                if ($i == 2) {
                    $data_validasi[$i] = [
                        'kategori' => 'proposal',
                        'jenis_validasi' => $i,
                        'status_validasi' => 4,
                        'id_user' => 8,
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                    ];
                } else {
                    $data_validasi[$i] = [
                        'kategori' => 'proposal',
                        'jenis_validasi' => $i,
                        'status_validasi' => 0,
                        'id_user' => 8,
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                    ];
                }
            }
            $this->kegiatan->insertDataValidasi($data_validasi);
            $lembaga = [
                'status_rancangan' => 4
            ];
            // update rancangan kegiatan
            $this->lembaga->updateRancanganKegiatan($lembaga, $id_proker);
            $this->session->set_flashdata('message', 'Data proposal berhasil ditambah !');
            redirect("Kegiatan/daftarPengajuanProposal");
        }
    }
    // Pengajuan tambah proposal kegiatan
    public function editProposal($id_kegiatan)
    {
        // $id_kegiatan = $this->input->post('id_kegiatan');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['notif'] = $this->_notif();
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan, $this->session->userdata('username'));
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $data['dokumentasi'] = $this->kegiatan->getDokumentasi($id_kegiatan);
        $data['dana_kegiatan'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['dana'] = $this->kegiatan->getSumberDanaLain($id_kegiatan);
        $data['validasi'] = $this->kegiatan->getDataValidasi($id_kegiatan, null, 'proposal');
        $data['jenis_revisi'] = $this->input->post('jenis_revisi');
        $gambar = [];
        if ($data['kegiatan'] == null || $data['kegiatan']['status_selesai_proposal'] == 3) {
            redirect('kegiatan/daftarPengajuanProposal');
        }
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_edit_proposal");
            $this->load->view("template/footer");
        } else {
            $jumlahAnggota = $this->input->post('jumlahAnggota');
            if ($jumlahAnggota <= 0) {
                $this->session->set_flashdata('failed', 'Anggota kegiatan tidak boleh kosong');
                redirect("Kegiatan/daftarPengajuanProposal");
            }
            // get id tingkatan
            $sm_id = $this->input->post('tingkatKegiatan');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_id])->row_array();
            $proposal = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'status_selesai_proposal' => 1,
                'dana_kegiatan' => $this->input->post('danaKegiatan'),
                'dana_proposal' => $this->input->post('danaKegiatanDiterima'),
                'tanggal_kegiatan' => $this->input->post('tglPelaksanaan'),
                'lokasi_kegiatan' => $this->input->post('tempatPelaksanaan'),
                'deskripsi_kegiatan' => $this->input->post('deskripsiKegiatan'),
                'no_whatsup' => $this->input->post('noTlpn'),
                'id_tingkatan' => $idTingkatan['id_tingkatan'],
                'nama_penanggung_jawab' => $this->input->post('penanggungJawab')
            ];
            if ($this->input->post('jenis_revisi') == 0) {
                $proposal['status_selesai_proposal'] = 0;
            } elseif ($this->input->post('jenis_revisi') == 5 || $this->input->post('jenis_revisi') == 6) {
                $proposal = $this->_cekDataRevisi($this->input->post('jenis_revisi'));
            }
            // update file proposal
            if ($_FILES['fileProposal']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/proposal/';
                $config['file_name'] =  $data['kegiatan']['proposal_kegiatan'];
                $this->load->library('upload', $config);
                unlink(FCPATH . "file_bukti/proposal/" . $data['kegiatan']['proposal_kegiatan']);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileProposal')) {
                    $proposal['proposal_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }
            // update berita proposal
            if ($_FILES['beritaProposal']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_proposal/';
                $config2['file_name'] =  $data['kegiatan']['berita_proposal'];
                $this->load->library('upload', $config2);
                unlink(FCPATH . "file_bukti/berita_proposal/" . $data['kegiatan']['berita_proposal']);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaProposal')) {
                    $proposal['berita_proposal'] = $this->data->upload('file_name');;
                } else {
                    $this->session->set_flashdata('failed', 'File berita proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }
            // update gambar1 kegiatan
            if ($_FILES['gambarKegiatanProposal1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_proposal/';
                $config3['file_name'] = $data['dokumentasi']['d_proposal_1'];
                $this->load->library('upload', $config3);
                unlink(FCPATH . "file_bukti/foto_proposal/" . $data['dokumentasi']['d_proposal_1']);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanProposal1')) {
                    $gambar['d_proposal_1'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }

            // update gambar1 kegiatan
            if ($_FILES['gambarKegiatanProposal2']['name']) {
                $config4['allowed_types'] = 'jpg|jpeg';
                $config4['max_size']     = '2048'; //kb
                $config4['upload_path'] = './file_bukti/foto_proposal/';
                $config4['file_name'] = $data['dokumentasi']['d_proposal_2'];
                $this->load->library('upload', $config4);
                unlink(FCPATH . "file_bukti/foto_proposal/" . $data['dokumentasi']['d_proposal_2']);
                $this->upload->initialize($config4);
                if ($this->upload->do_upload('gambarKegiatanProposal2')) {
                    $gambar['d_proposal_2'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
            }

            $this->kegiatan->updateKegiatan($proposal, $id_kegiatan);
            if ($gambar) {
                $this->kegiatan->updateDokumentasiKegiatan($gambar, $id_kegiatan);
            }
            if ($this->input->post('jenis_revisi') != 5) {
                // insert dana kegiatan
                $dana = [
                    0 => $this->input->post('dana1'),
                    1 => $this->input->post('dana2'),
                    2 => $this->input->post('dana3'),
                    3 => $this->input->post('dana4'),
                    4 => $this->input->post('dana5')
                ];
                $data_dana = [];
                foreach ($dana as $d) {
                    if ($d != 0) {
                        $data_dana[$d] = [
                            'id_kegiatan' => $id_kegiatan,
                            'id_sumber_dana' => $d
                        ];
                    }
                }
                $this->db->delete('kegiatan_sumber_dana', ['id_kegiatan' => $id_kegiatan]);
                $this->kegiatan->insertDanaKegiatan($data_dana);
                // insert anggota kegiatan

                $data_anggota = [];
                if ($jumlahAnggota) {
                    for ($i = 1; $i <= $jumlahAnggota; $i++) {
                        $data_anggota[$i] = [
                            'nim' => $this->input->post('nim_' . $i),
                            'id_kegiatan' => $id_kegiatan,
                            'keaktifan' => 0,
                            'id_prestasi' => $this->input->post('prestasi_' . $i)
                        ];
                    }
                    $this->db->delete('anggota_kegiatan', ['id_kegiatan' => $id_kegiatan]);
                    $this->kegiatan->insertAnggotaKegiatan($data_anggota);
                }
            }
            // insert validasi 
            $data_validasi = [];
            $i = 0;
            foreach ($data['validasi'] as $d) {
                if ($d['status_validasi'] == '2') {
                    $data_validasi[$i] = [
                        'id' => $d['id'],
                        'status_validasi' => 4,
                        'id_user' => 8,
                    ];
                }
            }
            if ($data_validasi) {
                $this->kegiatan->updateValidasiKegiatan($data_validasi);
            }
            $this->session->set_flashdata('message', 'Data proposal berhasil diperbaharui !');
            redirect("Kegiatan/daftarPengajuanProposal");
        }
    }
    // Pengajuan Proposal kegiatan
    public function pengajuanLpj()
    {
        $data['title'] = "Pengajuan";
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'), 3);
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/pengajuan_lpj", $data);
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }
    // metod untuk mengajuan lpj
    public function tambahLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_poinskp', 'poinskp');
        $data['title'] = "Pengajuan";
        $data['notif'] = $this->_notif();
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan, $this->session->userdata('username'));
        $data['dana'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['anggota'] = $this->kegiatan->getInfoAnggota($id_kegiatan);
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['prestasi'] = $this->poinskp->getPrestasi($data['tingkat'][0]['id_semua_tingkatan']);


        if ($data['kegiatan'] == null || $data['kegiatan']['status_selesai_lpj'] == 3) {
            redirect('Mahasiswa/pengajuanLpj');
        }
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_tambah_lpj");
            $this->load->view("template/footer");
        } else {
            $gambar = [];
            $lpj = [
                'status_selesai_lpj' => 1,
                'dana_lpj' => $this->input->post('danaKegiatanDiterima'),
                'tgl_pengajuan_lpj' => date("Y-m-d"),
            ];
            // upload file proposal
            if ($_FILES['fileLpj']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/lpj/';
                $config['file_name'] = time() . '_' . $_FILES['fileLpj']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileLpj')) {
                    $lpj['lpj_kegiatan'] = $this->upload->data('file_name');
                } else {
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaLpj']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_lpj/';
                $config2['file_name'] = time() . '_' . $_FILES['beritaLpj']['name'];
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaLpj')) {
                    $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar kegiatan
            if ($_FILES['gambarKegiatanLpj1']['name'] && ($_FILES['gambarKegiatanLpj2']['name'])) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_lpj/';
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj1') && $this->upload->do_upload('gambarKegiatanLpj2')) {
                    $gambar['d_lpj_1'] = $_FILES['gambarKegiatanLpj1']['name'];
                    $gambar['d_lpj_2'] = $_FILES['gambarKegiatanLpj2']['name'];
                } else {
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            $this->kegiatan->updateKegiatan($lpj, $id_kegiatan);
            // update data dokumentasi
            $this->kegiatan->updateDokumentasiKegiatan($gambar, $id_kegiatan);
            //insert anggota kegiatan
            $anggota = $this->db->get_where('anggota_kegiatan', ['id_kegiatan' => $id_kegiatan])->result_array();
            $data_anggota = [];
            $i = 0;
            foreach ($anggota as $a) {
                $data_anggota[$i++] = [
                    'id_anggota_kegiatan' => $a['id_anggota_kegiatan'],
                    'keaktifan' => $this->input->post('aktif_' . $a['id_anggota_kegiatan']),
                    'id_prestasi' => $this->input->post('prestasi_' . $a['id_anggota_kegiatan'])
                ];
            }
            $this->kegiatan->updateAnggotaKegiatan($data_anggota);
            // insert validasi 
            $validasi = $this->db->get_where('validasi_kegiatan', ['id_kegiatan' => $id_kegiatan, 'kategori' => 'lpj'])->result_array();
            $j = 0;
            $data_validasi = [];
            foreach ($validasi as $v) {
                if ($v['jenis_validasi'] == 2) {
                    $data_validasi[$j++] = [
                        'id' => $v['id'],
                        'status_validasi' => 4,
                    ];
                } else {
                    $data_validasi[$j++] = [
                        'id' => $v['id'],
                        'status_validasi' => 0,
                    ];
                }
            }
            $this->kegiatan->updateValidasiKegiatan($data_validasi);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Success</div>
                  Data lpj berhasil perbaharui !
                </div>
              </div>');
            redirect("Kegiatan/pengajuanLpj");
        }
    }
    // metod untuk edit lpj
    public function editLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_poinskp', 'poinskp');
        $data['title'] = "Pengajuan";
        $data['notif'] = $this->_notif();
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan);
        $data['dana'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['anggota'] = $this->kegiatan->getInfoAnggota($id_kegiatan);
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['prestasi'] = $this->poinskp->getPrestasi($data['tingkat'][0]['id_semua_tingkatan']);
        $data['dokumentasi'] = $this->kegiatan->getDokumentasi($id_kegiatan);
        $data['jenis_revisi'] = $this->input->post('jenis_revisi');
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_edit_lpj");
            $this->load->view("template/footer");
        } else {
            $gambar = [];
            $lpj = [
                'status_selesai_lpj' => 1,
                'dana_lpj' => $this->input->post('danaKegiatanDiterima'),
            ];
            // upload file proposal
            if ($_FILES['fileLpj']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/lpj/';
                $config['file_name'] = $_FILES['fileLpj']['name'];
                $this->load->library('upload', $config);
                //unlink(FCPATH . "file_bukti/lpj/" . $data['kegiatan']['lpj_kegiatan']);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileLpj')) {
                    $lpj['lpj_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                          <div class="alert-title">Field</div>
                          File lpj gagal diperbaharui !
                        </div>
                      </div>');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaLpj']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_lpj/';
                $config2['file_name'] = time() . '_' . $_FILES['beritaLpj']['name'];
                $this->load->library('upload', $config2);
                //unlink(FCPATH . "file_bukti/berita_lpj/" . $data['kegiatan']['berita_pelaporan']);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaLpj')) {
                    $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                          <div class="alert-title">Field</div>
                          File berita gagal diperbaharui !
                        </div>
                      </div>');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar kegiatan
            if ($_FILES['gambarKegiatanLpj1']['name'] && ($_FILES['gambarKegiatanLpj2']['name'])) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_lpj/';
                $this->load->library('upload', $config3);
                unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_1']);
                unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_2']);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj1') && $this->upload->do_upload('gambarKegiatanLpj2')) {
                    $gambar['d_lpj_1'] = $_FILES['gambarKegiatanLpj1']['name'];
                    $gambar['d_lpj_2'] = $_FILES['gambarKegiatanLpj2']['name'];
                } else {
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                          <div class="alert-title">Field</div>
                          File gambar gagal diperbaharui !
                        </div>
                      </div>');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            if ($lpj) {
                $this->kegiatan->updateKegiatan($lpj, $id_kegiatan);
            }
            // update data dokumentasi
            if ($gambar) {
                $this->kegiatan->updateDokumentasiKegiatan($gambar, $id_kegiatan);
            }
            if ($data['jenis_revisi'] == 0 || $data['jenis_revisi'] == 2 || $data['jenis_revisi'] == 3 || $data['jenis_revisi'] == 4) {
                var_dump($data['jenis_revisi']);
                die;
                //insert anggota kegiatan
                $anggota = $this->db->get_where('anggota_kegiatan', ['id_kegiatan' => $id_kegiatan])->result_array();
                $data_anggota = [];
                $i = 0;
                foreach ($anggota as $a) {
                    $data_anggota[$i++] = [
                        'id_anggota_kegiatan' => $a['id_anggota_kegiatan'],
                        'keaktifan' => $this->input->post('aktif_' . $a['id_anggota_kegiatan']),
                        'id_prestasi' => $this->input->post('prestasi_' . $a['id_anggota_kegiatan'])
                    ];
                }
                $this->kegiatan->updateAnggotaKegiatan($data_anggota);
            }
            // insert validasi 
            $validasi = $this->db->get_where('validasi_kegiatan', ['id_kegiatan' => $id_kegiatan, 'kategori' => 'lpj'])->result_array();
            $j = 0;
            $data_validasi = [];
            foreach ($validasi as $v) {
                if ($v['status_validasi'] == 2) {
                    $data_validasi[$j++] = [
                        'id' => $v['id'],
                        'status_validasi' => 4,
                    ];
                }
            }
            $this->kegiatan->updateValidasiKegiatan($data_validasi);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Success</div>
                  Data lpj berhasil perbaharui !
                </div>
              </div>');
            redirect("Kegiatan/pengajuanLpj");
        }
    }
    // menampilkan permintaan daftar proposal
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, null, "0");
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/daftar_validasi_proposal");
        $this->load->view('modal/modal');
        $this->load->view("template/footer");
    }
    // menampilkan permintaan daftar lpj
    public function daftarLpj()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3, "0");
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');
        $data['notif'] = $this->_notif();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/daftar_validasi_lpj");
        $this->load->view('modal/modal');
        $this->load->view("template/footer");
    }
    // metod bem melakukan validasi proposal
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
        redirect('kegiatan/daftarProposal');
    }
    // metode bem melakukan validasi lpj
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
            $this->session->set_flashdata('message', 'Lpj berhasil divalidasi!');
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
            $this->session->set_flashdata('message', 'Lpj berhasil direvisi!');
        }
        redirect('kegiatan/daftarLpj');
    }
    // melakukan pengecekan data revisi
    private function _cekDataRevisi()
    {
        $data = [];
        $data = [
            'nama_kegiatan' => $this->input->post('namaKegiatan'),
            'status_selesai_proposal' => 1,
            'no_whatsup' => $this->input->post('noTlpn'),
        ];
        return $data;
    }
}
