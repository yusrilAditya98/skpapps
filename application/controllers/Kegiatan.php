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
        if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
        } else {
            is_logged_in();
        }
    }
    // metod mememberikan notif pada sidebar
    private function _notif()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_bem_lpj'] = count($this->kemahasiswaan->getNotifValidasi(2, 'lpj'));
        $this->notif['notif_bem_proposal'] = count($this->kemahasiswaan->getNotifValidasi(2, 'proposal'));
        return $this->notif;
    }

    private function _notifKmhs()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_kmhs_lpj'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
        $this->notif['notif_kmhs_proposal'] = count($this->kemahasiswaan->getNotifValidasi(3, 'proposal'));
        $this->notif['notif_kmhs_rancangan'] = count($this->kemahasiswaan->getNotifValidasiRancangan());
        $this->notif['notif_kmhs_skp'] = count($this->kemahasiswaan->getNotifValidasiSkp());
        $this->notif['notif_kmhs_validasi_anggota_lembaga'] = count($this->kemahasiswaan->getNotifValidasiAnggotaLembaga());
        $this->notif['notif_kmhs_keaktifan_anggota_lembaga'] = count($this->kemahasiswaan->getNotifValidasiKeaktifanLembaga());
        return $this->notif;
    }

    public function index()
    {
        $this->load->model('Model_lembaga', 'lembaga');
        $data['title'] = 'Dashboard';
        $data['notif'] = $this->_notif();
        $data['proposal_kegiatan'] = $this->lembaga->getPengajuanProposalLembaga($this->session->userdata('username'));
        $data['lpj_kegiatan'] = $this->lembaga->getPengajuanLpjLembaga($this->session->userdata('username'));
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

    public function profil()
    {
        $this->load->model('Model_lembaga', 'lembaga');
        $data['title'] = 'Profil Lembaga';
        $data['notif'] = $this->_notif();
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/profil_lembaga", $data);
        $this->load->view("template/footer");
    }

    public function editProfil($id_lembaga)
    {
        $this->load->model('Model_lembaga', 'lembaga');
        $lembaga[0] = [
            'id_lembaga' => $id_lembaga,
            'jenis_lembaga' => $this->input->post('jenis_lembaga'),
            'nama_ketua' => $this->input->post('ketua_lembaga'),
            'jumlah_anggota' => $this->input->post('jumlah_anggota'),
            'no_hp_lembaga' => $this->input->post('no_hp'),
        ];
        $this->db->update_batch('lembaga', $lembaga, 'id_lembaga');
        $this->session->set_flashdata('message', 'Profil lembaga berhasil diperbaharui !');
        redirect('Kegiatan/profil');
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
                $this->session->set_flashdata('failed', 'Anggaran lembaga melebihi dana pagu!');
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
                    'kategori_kegiatan' => $this->input->post('kategori_kegiatan')
                ];
                $this->lembaga->insertRancanganKegiatan($this->rancangan);
                $this->lembaga->updateAnggaranLembaga($jumlah_dana_lembaga, $this->session->userdata('username'), $this->input->post('tahunKegiatan'));
                $this->session->set_flashdata('message', 'Rancangan kegiatan berhasil ditambah!');
                redirect('Kegiatan/pengajuanRancangan');
            }
        }
    }
    // edit rancangan kegiatan 
    // 0 belum setuju; 1 setuju ; 2 revisi ; 3 pengajuan
    public function editRancanganKegiatan($id_rancangan)
    {
        $this->load->model("Model_lembaga", 'lembaga');
        $data['rancangan'] = $this->lembaga->getDataRancangan($id_rancangan);

        if ($data['rancangan']['status_rancangan'] == 2) {
            $status_rancangan = 3;
        } else {
            $status_rancangan = $data['rancangan']['status_rancangan'];
        }

        if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
            $id_lembaga = $this->input->post_get('id_lembaga');
            $data['notif'] = $this->_notifKmhs();
        } else {
            $id_lembaga = $this->session->userdata('username');
            $data['notif'] = $this->_notif();
        }

        $data['title'] = 'Pengajuan';



        $data['lembaga'] = $this->lembaga->getDataLembaga($id_lembaga);
        $dana = $this->lembaga->getDanaPagu($id_lembaga, $data['lembaga']['tahun_rancangan']);
        if ($data['rancangan']['id_lembaga'] != $id_lembaga) {
            if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
                redirect('Kemahasiswaan/detailRancanganKegiatan/?id_lembaga=' . $id_lembaga . '&tahun=' . $this->input->post('tahunKegiatan'));
            } else {
                redirect('Kegiatan/pengajuanRancangan');
            }
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
                $this->session->set_flashdata('failed', 'Anggaran lembaga melebihi dana pagu!');
                if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
                    redirect('Kemahasiswaan/detailRancanganKegiatan/?id_lembaga=' . $id_lembaga . '&tahun=' . $this->input->post('tahunKegiatan'));
                } else {
                    redirect('Kegiatan/pengajuanRancangan');
                }
            } else {
                $this->rancangan = [
                    'nama_proker' => $this->input->post('namaKegiatan'),
                    'tanggal_mulai_pelaksanaan' => $this->input->post('tglPelaksanaan'),
                    'tanggal_selesai_pelaksanaan' => $this->input->post('tglSelesaiPelaksanaan'),
                    'anggaran_kegiatan' => $this->input->post('danaKegiatan'),
                    'id_lembaga' => $id_lembaga,
                    'status_rancangan' => $status_rancangan,
                    'tahun_kegiatan' => $this->input->post('tahunKegiatan'),
                    'kategori_kegiatan' => $this->input->post('kategori_kegiatan')
                ];
                if ($data['rancangan']['status_rancangan'] == 2) {
                    $this->rancangan['status_rancangan'] = 3;
                }
                $this->lembaga->updateRancanganKegiatan($this->rancangan, $id_rancangan);
                $this->lembaga->updateAnggaranLembaga($jumlah_dana_lembaga_baru, $id_lembaga, $this->input->post('tahunKegiatan'));
                $this->session->set_flashdata('message', 'Rancangan kegiatan berhasil diperbaharui!');
                if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
                    redirect('Kemahasiswaan/detailRancanganKegiatan/?id_lembaga=' . $id_lembaga . '&tahun=' . $this->input->post('tahunKegiatan'));
                } else {
                    redirect('Kegiatan/pengajuanRancangan');
                }
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
        $this->session->set_flashdata('message', 'Rancangan kegiatan berhasil dihapus!');
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
        $this->session->set_flashdata('message', 'Rancangan kegiatan berhasil diajukan!');
        redirect('Kegiatan/pengajuanRancangan');
    }
    // melihat daftar pengajuan proposal kegiatan
    public function daftarPengajuanProposal()
    {
        $data['title'] = "Pengajuan";
        $data['notif'] = $this->_notif();
        $this->load->model('Model_kegiatan', 'kegiatan');
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'), null, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'));
        }

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
                'waktu_pengajuan' => time(),
                'tanggal_selesai_kegiatan' => $this->input->post('tglSelesaiPelaksanaan'),
                'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                'url_penyelenggara' => $this->input->post('urlPenyelenggara'),
            ];
            // upload file proposal
            if ($_FILES['fileProposal']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/proposal/';
                $config['file_name'] = $proposal['waktu_pengajuan'] . '_file_proposal_' . $this->session->userdata('username');
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


            $data_anggota = [];
            foreach ($data['mahasiswa'] as $m) {
                if ($this->input->post('nim_' . $m['nim'])) {
                    $data_anggota[$m['nim']] = [
                        'nim' => $this->input->post('nim_' . $m['nim']),
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                        'keaktifan' => 0,
                        'id_prestasi' => $this->input->post('prestasi_' . $m['nim'])
                    ];
                }
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

            if ($data['jenis_revisi'] == 0 || $data['jenis_revisi'] == 2 || $data['jenis_revisi'] == 3 || $data['jenis_revisi'] == 4) {
                if ($jumlahAnggota <= 0) {
                    $this->session->set_flashdata('failed', 'Anggota kegiatan tidak boleh kosong');
                    redirect("Kegiatan/daftarPengajuanProposal");
                }
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
                'nama_penanggung_jawab' => $this->input->post('penanggungJawab'),
                'tanggal_selesai_kegiatan' => $this->input->post('tglSelesaiPelaksanaan'),
                'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                'url_penyelenggara' => $this->input->post('urlPenyelenggara'),
            ];
            if ($this->input->post('jenis_revisi') == 0) {
                $proposal['status_selesai_proposal'] = 0;
            } elseif ($this->input->post('jenis_revisi') == 5) {
                $proposal = [];
                $proposal = [
                    'status_selesai_proposal' => 1,
                    'no_whatsup' => $this->input->post('noTlpn'),
                    'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                    'url_penyelenggara' => $this->input->post('urlPenyelenggara')
                ];
            } elseif ($this->input->post('jenis_revisi') == 6) {
                $proposal = [];
                $proposal = [
                    'nama_penanggung_jawab' => $this->input->post('penanggungJawab'),
                    'no_whatsup' => $this->input->post('noTlpn'),
                    'status_selesai_proposal' => 1,
                    'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                    'url_penyelenggara' => $this->input->post('urlPenyelenggara')
                ];
            }

            if ($this->input->post('jenis_revisi') != 6) {
                // update file proposal
                if ($_FILES['fileProposal']['name']) {
                    $config['allowed_types'] = 'pdf';
                    $config['max_size']     = '2048'; //kb
                    $config['upload_path'] = './file_bukti/proposal/';
                    $config['file_name'] =  time() . '_file_proposal_' . $this->session->userdata('username');
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('fileProposal')) {
                        // unlink(FCPATH . "file_bukti/proposal/" . $data['kegiatan']['proposal_kegiatan']);
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
                    $config2['file_name'] =  time() . '_berita_proposal_' . $this->session->userdata('username');
                    $this->load->library('upload', $config2);
                    $this->upload->initialize($config2);
                    if ($this->upload->do_upload('beritaProposal')) {
                        //  unlink(FCPATH . "file_bukti/berita_proposal/" . $data['kegiatan']['berita_proposal']);
                        $proposal['berita_proposal'] = $this->upload->data('file_name');
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
                    $config3['file_name'] = time() . '_gambar1_proposal_' . $this->session->userdata('username');
                    $this->load->library('upload', $config3);
                    $this->upload->initialize($config3);
                    if ($this->upload->do_upload('gambarKegiatanProposal1')) {
                        // unlink(FCPATH . "file_bukti/foto_proposal/" . $data['dokumentasi']['d_proposal_1']);
                        $gambar['d_proposal_1'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('failed', 'File gambar 1 tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Kegiatan/daftarPengajuanProposal");
                    }
                }

                // update gambar1 kegiatan
                if ($_FILES['gambarKegiatanProposal2']['name']) {
                    $config4['allowed_types'] = 'jpg|jpeg';
                    $config4['max_size']     = '2048'; //kb
                    $config4['upload_path'] = './file_bukti/foto_proposal/';
                    $config4['file_name'] = time() . '_gambar2_proposal_' . $this->session->userdata('username');
                    $this->load->library('upload', $config4);
                    $this->upload->initialize($config4);
                    if ($this->upload->do_upload('gambarKegiatanProposal2')) {
                        // unlink(FCPATH . "file_bukti/foto_proposal/" . $data['dokumentasi']['d_proposal_2']);
                        $gambar['d_proposal_2'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('failed', 'File gambar 2 tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Kegiatan/daftarPengajuanProposal");
                    }
                }
            }
            $this->kegiatan->updateKegiatan($proposal, $id_kegiatan);
            if ($gambar) {
                $this->kegiatan->updateDokumentasiKegiatan($gambar, $id_kegiatan);
            }
            if ($data['jenis_revisi'] == 0 || $data['jenis_revisi'] == 2 || $data['jenis_revisi'] == 3 || $data['jenis_revisi'] == 4) {
                // menambahkan anggota kegiatan
                $data_anggota = [];
                if ($jumlahAnggota) {
                    foreach ($data['mahasiswa'] as $m) {
                        if ($this->input->post('nim_' . $m['nim'])) {
                            $data_anggota[$m['nim']] = [
                                'nim' => $this->input->post('nim_' . $m['nim']),
                                'id_kegiatan' => $id_kegiatan,
                                'keaktifan' => 0,
                                'id_prestasi' => $this->input->post('prestasi_' . $m['nim'])
                            ];
                        }
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

        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'), 3, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'), 3);
        }
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
                $config['file_name'] = time() . '_file_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileLpj')) {
                    $lpj['lpj_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File Lpj tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaLpj']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_lpj/';
                $config2['file_name'] = time() . '_berita_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaLpj')) {
                    $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    $this->session->set_flashdata('failed', 'File berita Lpj tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanLpj1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_lpj/';
                $config3['file_name'] = time() . '_gambar1_lpj_' . $this->session->userdata('username');;
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj1')) {
                    $gambar['d_lpj_1'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    $this->session->set_flashdata('failed', 'Gambar 1 Lpj tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar2 kegiatan
            if ($_FILES['gambarKegiatanLpj2']['name']) {
                $config4['allowed_types'] = 'jpg|jpeg';
                $config4['max_size']     = '2048'; //kb
                $config4['upload_path'] = './file_bukti/foto_lpj/';
                $config4['file_name'] = time() . '_gambar2_lpj_' . $this->session->userdata('username');;
                $this->load->library('upload', $config4);
                $this->upload->initialize($config4);
                if ($this->upload->do_upload('gambarKegiatanLpj2')) {
                    $gambar['d_lpj_2'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    unlink(FCPATH . "file_bukti/foto_lpj/" . $gambar['d_lpj_1']);
                    $this->session->set_flashdata('failed', 'Gambar 2 Lpj tidak sesuai format (.jpg/2mb)');
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
            $this->session->set_flashdata('message', 'Data lpj berhasil perbaharui !');
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
            if ($data['jenis_revisi'] == 5) {
                $lpj = [];
                $lpj['status_selesai_lpj'] = 1;
            }
            // upload file proposal
            if ($_FILES['fileLpj']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/lpj/';
                $config['file_name'] = time() . '_file_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileLpj')) {
                    // unlink(FCPATH . "file_bukti/lpj/" . $data['kegiatan']['lpj_kegiatan']);
                    $lpj['lpj_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File Lpj tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaLpj']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_lpj/';
                $config2['file_name'] = time() . '_berita_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaLpj')) {
                    // unlink(FCPATH . "file_bukti/berita_lpj/" . $data['kegiatan']['berita_pelaporan']);
                    $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File berita tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanLpj1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_lpj/';
                $config3['file_name'] =  time() . '_gambar1_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj1')) {
                    //unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_1']);
                    $gambar['d_lpj_1'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File gambar 1 tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Kegiatan/pengajuanLpj");
                }
            }
            // upload gambar2 kegiatan
            if ($_FILES['gambarKegiatanLpj2']['name']) {
                $config4['allowed_types'] = 'jpg|jpeg';
                $config4['max_size']     = '2048'; //kb
                $config4['upload_path'] = './file_bukti/foto_lpj/';
                $config4['file_name'] = time() . '_gambar1_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config4);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj2')) {
                    //unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_2']);
                    $gambar['d_lpj_2'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File gambar 2 tidak sesuai format (.jpg/2mb)');
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
            $this->session->set_flashdata('message', 'Data lpj berhasil perbaharui !');
            redirect("Kegiatan/pengajuanLpj");
        }
    }
    // menampilkan permintaan daftar proposal
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, null, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        }
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
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        }
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
    public function anggaran()
    {
        $this->load->model('Model_keuangan', 'keuangan');
        $data['title'] = 'Anggaran';
        $data['notif'] = $this->_notif();
        $data['serapan_proposal'] = $this->keuangan->getAnggaranLembagaProposal($this->session->userdata('username'));
        $data['serapan_lpj'] = $this->keuangan->getAnggaranLembagaLpj($this->session->userdata('username'));
        $data['tahun'] = $this->keuangan->getTahun();
        if ($data['tahun']) {
            $tahun = $data['tahun'][0]['tahun'];
        } else {
            $tahun = date('Y');
        }

        if ($this->input->post('tahun')) {
            $tahun = $this->input->post('tahun');
            $data['kegiatan'] = $this->db->get_where('kegiatan', ['id_lembaga' => $this->session->userdata('username'), 'YEAR(kegiatan.tgl_pengajuan_proposal)' => $tahun])->result_array();
        } else {
            $data['kegiatan'] = $this->db->get_where('kegiatan', ['id_lembaga' => $this->session->userdata('username'), 'YEAR(kegiatan.tgl_pengajuan_proposal)' => $tahun])->result_array();
        }
        $data['tahun_anggaran'] = $tahun;
        $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj']);
        $data['total_anggaran'] = $this->db->get_where('rekapan_kegiatan_lembaga', ['id_lembaga' => $this->session->userdata('username'), 'tahun_pengajuan' => $tahun])->row_array();
        $data['total'] = $this->_totalDana($data['laporan']);

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/anggaran", $data);
        $this->load->view("template/footer");
    }

    private function _serapan($proposal, $lpj)
    {
        $id_lembaga = $this->session->userdata('username');
        $kegiatan = $this->db->get_where('kegiatan', ['id_lembaga' => $id_lembaga])->result_array();

        if ($proposal == null) {
            foreach ($kegiatan as $k) {
                $proposal[$k['id_lembaga']] = [
                    'bulan_pengajuan' => 0,
                    'id_kegiatan' => $k['id_kegiatan'],
                    'dana' => 0
                ];
            }
        }

        if ($lpj == null) {
            foreach ($kegiatan as $k) {
                $lpj[$k['id_kegiatan']] = [
                    'bulan_pengajuan' => 0,
                    'id_kegiatan' => $k['id_kegiatan'],
                    'dana' => 0
                ];
            }
        }

        $data = [];
        foreach ($kegiatan as $k) {
            for ($j = 1; $j < 13; $j++) {
                $data[$k['id_kegiatan']][$j] = 0;
            }
            $data[$k['id_kegiatan']]['anggaran_kegiatan'] = $k['dana_kegiatan'];
            $data[$k['id_kegiatan']]['dana_terserap'] = 0;
        }


        $data_lpj = [];
        foreach ($proposal as $p) {
            $data_lpj[$p['id_kegiatan']] = [
                'bulan_pengajuan' => 0,
                'id_kegiatan' => $p['id_kegiatan'],
                'dana' => 0
            ];
        }


        foreach ($lpj as $l) {
            $data_lpj[$l['id_kegiatan']] = [
                'bulan_pengajuan' => $l['bulan_pengajuan'],
                'id_kegiatan' => $l['id_kegiatan'],
                'dana' =>  $l['dana'],
            ];
        }
        $lpj = $data_lpj;

        foreach ($proposal as $p) {
            // data lpj haruslah tidak boleh kosong
            foreach ($lpj as $l) {
                for ($i = 1; $i < 13; $i++) {
                    if ($p['id_kegiatan'] == $l['id_kegiatan'] && $p['bulan_pengajuan'] == $i) {
                        if ($l['bulan_pengajuan'] == $p['bulan_pengajuan']) {
                            $data[$p['id_kegiatan']][$i] = $p['dana'] + $l['dana'];
                        } else {
                            $data[$p['id_kegiatan']][$i] = $p['dana'];
                        }
                    }
                    if ($p['id_kegiatan'] == $l['id_kegiatan'] && $l['bulan_pengajuan'] == $i) {
                        if ($l['bulan_pengajuan'] == $p['bulan_pengajuan']) {
                            $data[$l['id_kegiatan']][$i] = $p['dana'] + $l['dana'];
                        } else {
                            $data[$l['id_kegiatan']][$i] = $l['dana'];
                        }
                    }
                }
            }
        }

        foreach ($kegiatan as $k) {
            for ($j = 1; $j < 13; $j++) {
                $data[$k['id_kegiatan']]['dana_terserap'] += $data[$k['id_kegiatan']][$j];
            }
        }
        return $data;
    }

    private function _totalDana($laporan)
    {
        $id_lembaga = $this->session->userdata('username');
        $kegiatan = $this->db->get_where('kegiatan', ['id_lembaga' => $id_lembaga])->result_array();
        $data['total']['anggaran_kegiatan'] = 0;
        $data['total']['dana_terserap'] = 0;
        $data['total']['persen_terserap'] = 0;
        foreach ($kegiatan as $k) {
            $data['total']['dana_terserap'] += $laporan[$k['id_kegiatan']]['dana_terserap'];
            $data['total']['anggaran_kegiatan'] += $laporan[$k['id_kegiatan']]['anggaran_kegiatan'];
        }
        if ($data['total']['anggaran_kegiatan'] == 0) {
            $data['total']['persen_terserap'] = 0;
        } else {
            $data['total']['persen_terserap'] = $data['total']['dana_terserap'] / $data['total']['anggaran_kegiatan'] * 100;
        }
        return $data;
    }
    public function anggota()
    {
        $data['title'] = 'Anggota';
        $data['notif'] = $this->_notif();
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            // var_dump($data['lembaga']);die;

            $data['tahun'] = intval($this->input->get('tahun'));
        } else {
            // Tambahan seleksi lembaga
            if ($data['lembaga']['tahun_rancangan'] == 0) {
                $data['tahun'] = date('Y');
            } else {
                $data['tahun'] = intval($data['lembaga']['tahun_rancangan']);
            }
        }
        $tahun = $data['tahun'];
        $data['pengajuan'] = $this->db->get_where('pengajuan_anggota_lembaga', ['id_lembaga' => $this->session->userdata('username'), 'periode' => $tahun])->row_array();

        $this->db->where('periode', $tahun);
        $this->db->where('pengajuan_anggota_lembaga.status_validasi', 1);
        $this->db->where('pengajuan_anggota_lembaga.id_lembaga', $this->session->userdata('username'));
        $this->db->from('daftar_anggota_lembaga');
        $this->db->join('mahasiswa', 'daftar_anggota_lembaga.nim = mahasiswa.nim');
        $this->db->join('semua_prestasi', 'daftar_anggota_lembaga.id_sm_prestasi = semua_prestasi.id_semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('pengajuan_anggota_lembaga', 'daftar_anggota_lembaga.id_pengajuan_anggota_lembaga = pengajuan_anggota_lembaga.id');
        $this->db->order_by('id_sm_prestasi ASC');
        $data['anggota'] = $this->db->get()->result_array();

        // Update jumlah anggota
        // $this->db->where('id_lembaga', $this->session->userdata('username'));
        // $this->db->update('lembaga', ['jumlah_anggota' => count($data['anggota'])]);

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/anggota", $data);
        $this->load->view("template/footer");
    }

    public function rancanganAnggota()
    {
        $data['title'] = 'Anggota';
        $data['notif'] = $this->_notif();
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $data['tahun'] = intval($this->input->get('tahun'));
        } else {
            $data['tahun'] = intval($data['lembaga']['tahun_rancangan']);
        };
        $tahun = $data['tahun'];
        $data['pengajuan'] = $this->db->get_where('pengajuan_anggota_lembaga', ['id_lembaga' => $this->session->userdata('username'), 'periode' => $tahun])->row_array();
        $this->db->where('periode', $tahun);
        $this->db->select('mahasiswa.nama, mahasiswa.nim, prestasi.nama_prestasi, semua_prestasi.bobot, pengajuan_anggota_lembaga.status_validasi, pengajuan_anggota_lembaga.status_pembukaan, daftar_anggota_lembaga.id, daftar_anggota_lembaga.id_sm_prestasi,prodi.nama_prodi,jurusan.nama_jurusan');
        $this->db->from('daftar_anggota_lembaga');
        $this->db->join('mahasiswa', 'daftar_anggota_lembaga.nim = mahasiswa.nim');
        $this->db->join('semua_prestasi', 'daftar_anggota_lembaga.id_sm_prestasi = semua_prestasi.id_semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('pengajuan_anggota_lembaga', 'daftar_anggota_lembaga.id_pengajuan_anggota_lembaga = pengajuan_anggota_lembaga.id');
        $this->db->join('prodi', 'prodi.kode_prodi = mahasiswa.kode_prodi', 'left');
        $this->db->join('jurusan', 'prodi.kode_jurusan = jurusan.kode_jurusan', 'left');
        $this->db->where('pengajuan_anggota_lembaga.id_lembaga', $this->session->userdata('username'));
        $this->db->order_by('id_sm_prestasi ASC');
        $data['anggota'] = $this->db->get()->result_array();
        $data['jumlah_anggota'] = count($data['anggota']);

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("lembaga/rancanganAnggota", $data);
        $this->load->view("template/footer");
    }

    public function tambahRancanganAnggota()
    {
        $this->load->model('Model_lembaga', 'lembaga');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['notif'] = $this->_notif();
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $lembaga = $this->lembaga->getPeriodeLembaga($this->session->userdata('username'));
        $data['periode_lembaga'] = intval($lembaga['tahun_rancangan']);
        if ($lembaga['jenis_lembaga'] == "otonom") {
            $data['jenis_lembaga'] = 6;
        } else {
            $data['jenis_lembaga'] = 7;
        }
        $data['dana'] = $this->db->get('sumber_dana')->result_array();
        $gambar = [];
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $data['tahun'] = intval($this->input->get('tahun'));
        } else {
            $data['tahun'] = intval($data['lembaga']['tahun_rancangan']);
        };
        // set rules form validation
        $this->form_validation->set_rules('namaLembaga', 'Nama Lembaga', 'required');
        if ($this->form_validation->run() == false) {
            $data['pengajuan'] = $this->db->get_where('pengajuan_anggota_lembaga', ['id_lembaga' => $this->session->userdata('username'), 'periode' => $data['tahun']])->row_array();
            if ($data['pengajuan']) {
                if ($data['pengajuan']['status_pembukaan'] == 1) {
                    $this->session->set_flashdata('failed', 'Tidak bisa Menambahkan anggota, silahkan buka akses penambahan anggota !!');
                    redirect("Kegiatan/rancanganAnggota?tahun=" . $data['tahun']);
                }
            }

            $this->db->where('periode', $data['tahun']);
            $this->db->from('daftar_anggota_lembaga');
            $this->db->join('mahasiswa', 'daftar_anggota_lembaga.nim = mahasiswa.nim');
            $this->db->join('pengajuan_anggota_lembaga', 'daftar_anggota_lembaga.id_pengajuan_anggota_lembaga = pengajuan_anggota_lembaga.id');
            $this->db->join('semua_prestasi', 'daftar_anggota_lembaga.id_sm_prestasi = semua_prestasi.id_semua_prestasi');
            $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
            $this->db->join('prodi', 'prodi.kode_prodi = mahasiswa.kode_prodi', 'left');
            $this->db->join('jurusan', 'prodi.kode_jurusan = jurusan.kode_jurusan', 'left');
            $this->db->where('pengajuan_anggota_lembaga.id_lembaga', $this->session->userdata('username'));
            $this->db->order_by('id_sm_prestasi ASC');
            $data['anggota'] = $this->db->get()->result_array();
            // Header('Content-type: application/json');
            // echo json_encode($data['anggota']);die;

            $data['title'] = "Anggota";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("lembaga/form_tambah_anggota");
            $this->load->view("template/footer");
        } else {
            $jumlahAnggota = intval($this->input->post('jumlahAnggota'));
            $tahunPeriode = intval($this->input->post('periode'));
            if ($jumlahAnggota <= 0) {
                $this->session->set_flashdata('failed', 'Anggota Lembaga tidak boleh kosong');
                redirect("Kegiatan/tambahRancanganAnggota?tahun=" . $tahunPeriode);
            }

            // get id semua tingkatan
            $sm_tingkatan_id = $this->input->post('jenis_lembaga');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_tingkatan_id])->row_array();
            $id_lembaga = intval($this->input->post('id_lembaga'));
            $periode = intval($this->input->post('periode'));

            // cek ketersediaan rancangan
            $rancanganAnggota = $this->lembaga->getIdRancanganAnggota($id_lembaga, $periode);

            if ($rancanganAnggota == null) {
                $rancanganAnggota = [
                    'id_lembaga' => $id_lembaga,
                    'status_pembukaan' => 0,
                    'periode' => $periode,
                    'status_validasi' => 0,
                    'status_keaktifan' => 0
                ];
                // cek file_bukti
                if ($_FILES['buktiPengajuan']['name']) {
                    $config['allowed_types'] = '*';
                    $config['max_size']     = '2048'; //kb
                    $config['upload_path'] = './file_bukti/sk_lembaga';
                    $config['file_name'] = 'pengajuan_anggota_' . $id_lembaga . '_' . $periode;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('buktiPengajuan')) {
                        $rancanganAnggota['bukti_pengajuan'] = $this->upload->data('file_name');
                    }
                }
                // var_dump($rancanganAnggota);die;
                $this->lembaga->insertRancanganAnggota($rancanganAnggota);
                $rancanganAnggota = $this->lembaga->getIdRancanganAnggota($id_lembaga, $periode);
            }
            // cek file_bukti
            if ($_FILES['buktiPengajuan']['name']) {
                $config['allowed_types'] = '*';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/sk_lembaga';
                $config['file_name'] = 'pengajuan_anggota_' . $id_lembaga . '_' . $periode;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('buktiPengajuan')) {
                    $this->db->where('id', intval($rancanganAnggota['id']));
                    $this->db->update('pengajuan_anggota_lembaga', ['bukti_pengajuan' => $this->upload->data('file_name')]);
                }
            }

            if ($rancanganAnggota['status_validasi'] == 1) {
                $this->session->set_flashdata('failed', 'Anggota Lembaga Periode ' . $periode . ' sudah divalidasi');
                redirect("Kegiatan/tambahRancanganAnggota");
            }

            // Jumlah Anggota Sekarang
            $lembaga = $this->db->get_where('lembaga', ['id_lembaga' => $id_lembaga])->row_array();
            $anggota_temp = intval($lembaga['jumlah_anggota']);

            // insert Anggota Lembaga
            $data_anggota = [];
            $ketua = "";
            foreach ($data['mahasiswa'] as $m) {
                if ($this->input->post('nim_' . $m['nim'])) {
                    if (intval($this->input->post('prestasi_' . $m['nim'])) == 22 || intval($this->input->post('prestasi_' . $m['nim'])) == 27) {
                        $ketua = $m['nama'];
                    }
                    $data_anggota[$m['nim']] = [
                        'nim' => $this->input->post('nim_' . $m['nim']),
                        'status_aktif' => 0,
                        'id_pengajuan_anggota_lembaga' => intval($rancanganAnggota['id']),
                        'id_sm_prestasi' => intval($this->input->post('prestasi_' . $m['nim'])),
                    ];
                }
            }

            // Hapus daftar sementara
            $this->db->where('id_pengajuan_anggota_lembaga', intval($rancanganAnggota['id']));
            $this->db->delete('daftar_anggota_lembaga');

            $this->lembaga->insertAnggotaLembaga($data_anggota);

            // Update jumlah Anggota & Ketua
            if ($ketua != "") {
                $lembaga = [
                    'nama_ketua' => $ketua
                ];
            }
            $this->lembaga->updateLembaga($lembaga, $id_lembaga);

            $this->session->set_flashdata('message', 'Anggota Lembaga berhasil ditambah !');
            redirect("Kegiatan/rancanganAnggota?tahun=" . $tahunPeriode);
        }
    }
    public function hapusRancanganAnggota()
    {
        $id = intval($this->input->get('id'));
        $id_sm_prestasi = intval($this->input->get('id_sm_prestasi'));
        $nim = $this->input->get('nim');
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $tahun = intval($this->input->get('tahun'));
        } else {
            $tahun = intval($data['lembaga']['tahun_rancangan']);
        };
        $this->db->where('id', $id);
        // $this->db->where('nim', $nim);
        // $this->db->where('id_sm_prestasi', $id_sm_prestasi);
        $this->db->delete('daftar_anggota_lembaga');
        $this->session->set_flashdata('message', 'Anggota Lembaga berhasil dihapus !');
        redirect("Kegiatan/rancanganAnggota?tahun=" . $tahun);
    }
    public function ajukanRancanganAnggota($id_pengajuan)
    {
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $tahun = intval($this->input->get('tahun'));
        } else {
            $tahun = intval($data['lembaga']['tahun_rancangan']);
        };
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_pembukaan' => 1]);
        $this->session->set_flashdata('message', 'Akses Penambahan Anggota Lembaga berhasil ditutup !');
        redirect("Kegiatan/rancanganAnggota?tahun=" . $tahun);
    }
    public function ajukanValidasiAnggota($id_pengajuan)
    {
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $tahun = intval($this->input->get('tahun'));
        } else {
            $tahun = intval($data['lembaga']['tahun_rancangan']);
        };
        $anggota_lembaga = $this->db->get_where('daftar_anggota_lembaga', ['id_pengajuan_anggota_lembaga' => intval($id_pengajuan)])->result_array();
        $jumlah_anggota = count($anggota_lembaga);
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_validasi' => 2, 'jumlah_anggota_lembaga' => $jumlah_anggota]);

        $this->session->set_flashdata('message', 'Validasi Anggota Lembaga berhasil diajukan !');
        redirect("Kegiatan/rancanganAnggota?tahun=" . $tahun);
    }
    public function bukaRancanganAnggota($id_pengajuan)
    {
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        if ($this->input->get('tahun') != "") {
            $tahun = intval($this->input->get('tahun'));
        } else {
            $tahun = intval($data['lembaga']['tahun_rancangan']);
        };
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_pembukaan' => 0]);
        $this->session->set_flashdata('message', 'Akses Penambahan Anggota Lembaga berhasil dibuka !');
        redirect("Kegiatan/rancanganAnggota?tahun=" . $tahun);
    }
    public function laporanKeaktifanAnggota($id_pengajuan)
    {
        $this->db->where('id_pengajuan_anggota_lembaga', intval($id_pengajuan));
        $anggota_lembaga = $this->db->get('daftar_anggota_lembaga')->result_array();

        $anggota_status_aktif = [];
        for ($i = 0; $i < count($anggota_lembaga); $i++) {
            $nama = 'keaktifan_' . $anggota_lembaga[$i]['nim'];
            $data = [
                'id' => intval($anggota_lembaga[$i]['id']),
                'status_aktif' => $this->input->post($nama)
            ];
            array_push($anggota_status_aktif, $data);
        }
        $this->db->update_batch('daftar_anggota_lembaga', $anggota_status_aktif, 'id');

        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_keaktifan' => 2]);
        // var_dump($anggota_status_aktif);die;
        $this->session->set_flashdata('message', 'Laporan Keaktifan Anggota Lembaga berhasil diajukan !');
        redirect("Kegiatan/anggota");
    }
    public function hapusAnggotaApi()
    {
        $nim = $this->input->get('nim');
        $id_lembaga = $this->input->get('id_lembaga');
        $periode = $this->input->get('periode');

        $pengajuan = $this->db->get_where('pengajuan_anggota_lembaga', ['id_lembaga' => $id_lembaga, 'periode' => $periode])->row_array();

        $this->db->where('nim', $nim);
        $this->db->where('id_pengajuan_anggota_lembaga', $pengajuan['id']);
        $this->db->delete('daftar_anggota_lembaga');

        $data_anggota = $this->db->where('id_pengajuan_anggota_lembaga', $pengajuan['id'])->order_by('id_sm_prestasi ASC')->get('daftar_anggota_lembaga')->result_array();
        echo json_encode($data_anggota);
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
