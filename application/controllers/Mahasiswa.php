<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
        } else {
            is_logged_in();
        }
        $this->load->library('form_validation');
    }
    public $bidangKegiatan = [];
    private $jenisKegiatan = [];
    private $tingkatKegiatan = [];
    private $partisipasiKegiatan = [];
    private $bobotKegiatan = [];
    private $dataPoinSkp = [];
    private $proposal = [];
    private $id_kegiatan;


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
    // tampilan dashboard
    public function index()
    {
        if ($this->session->userdata('id_kegiatan')) {
            redirect('API_skp/gabungKegiatan');
        }
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['poinskp'] = $this->poinskp->getPoinSkp($this->session->userdata('username'), null, 5);
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa($this->session->userdata('username'));

        $data['title'] = "Dashboard";
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_mhs");
        $this->load->view("template/footer");
    }

    // Lihat profif mahasiswa
    public function profil()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa($this->session->userdata('username'));

        $data['title'] = "Profil Mahasiswa";
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("mahasiswa/profil_mahasiswa");
        $this->load->view("template/footer");
    }


    // untuk lihat halaman poin skp mahasiswa
    public function poinSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['title'] = "Poin Skp";
        $data['poinskp'] = $this->poinskp->getPoinSkp($this->session->userdata('username'));
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa($this->session->userdata('username'));
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("mahasiswa/poin_skp", $data);
        $this->load->view("template/footer");
    }


    // menunjukan ke halaman tambah poin skp dan proses tambah poin skp
    public function tambahPoinSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Tambah Poin Skp";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_tambah_skp");
            $this->load->view("template/footer");
        } else {
            $this->dataPoinSkp = [
                'nim' => $this->session->userdata('username'),
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'validasi_prestasi' => 0,
                'tgl_pelaksanaan' => $this->input->post('tanggalKegiatan'),
                'tempat_pelaksanaan' => $this->input->post('tempatKegiatan'),
                'prestasiid_prestasi' => $this->input->post('partisipasiKegiatan'),
                'tgl_pengajuan' => date("Y-m-d"),
                'tgl_selesai_pelaksanaan' => $this->input->post('tanggalSelesaiKegiatan')
            ];
            if ($_FILES['uploadBukti']['name']) {
                $config['allowed_types'] = 'pdf|png|jpg|jpeg';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/poinskp/';
                $config['file_name'] = time() . '_poinskp_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('uploadBukti')) {
                    $this->dataPoinSkp['file_bukti'] = 'poinskp/' . $this->upload->data('file_name');
                    $this->poinskp->insertPoinSkp($this->dataPoinSkp);
                    $this->session->set_flashdata('message', 'Skp berhasil ditambahkan!');
                } else {
                    $this->session->set_flashdata('failed', 'Skp gagal ditambahkan! file bukti tidak sesuai format');
                    redirect("Mahasiswa/tambahPoinSkp");
                }
                redirect("Mahasiswa/poinSkp");
            }
        }
    }

    // Fuction melakukan hapus poin skp
    public function hapusPoinSkp($id_poinSkp)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $nama_file = $this->db->get_where('poin_skp', ['id_poin_skp' => $id_poinSkp])->row_array();
        $this->load->library('upload');
        unlink(FCPATH . "file_bukti/" . $nama_file['file_bukti']);
        $this->poinskp->deletePoinSkp($id_poinSkp);
        $this->session->set_flashdata('message', 'Skp Berhasil dihapus!');
        redirect('Mahasiswa/poinSkp');
    }

    // Function melakukan edit/ubah poin skp
    public function editPoinSkp($id_kegiatan)
    {

        if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
            $skp = $this->db->get_where('poin_skp', ['id_poin_skp' => $id_kegiatan])->row_array();
            $nim = $skp['nim'];
            $data['notif'] = $this->_notifKmhs();
        } else {
            $nim = $this->session->userdata('username');
        }

        $this->id_kegiatan = $id_kegiatan;
        $this->load->model('Model_poinskp', 'poinskp');
        $this->dataPoinSkp = $this->poinskp->getPoinSkp($nim, $this->id_kegiatan);
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Poin Skp";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_edit_skp",  $this->dataPoinSkp[0]);
            $this->load->view("template/footer");
        } else {
            $data = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'validasi_prestasi' => 0,
                'tgl_pelaksanaan' => $this->input->post('tanggalKegiatan'),
                'tempat_pelaksanaan' => $this->input->post('tempatKegiatan'),
                'catatan' => $this->input->post('informasiTambahan'),
                'tgl_selesai_pelaksanaan' => $this->input->post('tanggalSelesaiKegiatan'),
                'prestasiid_prestasi' => $this->input->post('partisipasiKegiatan'),
                'tgl_pengajuan' => date("Y-m-d")
            ];

            $this->session->set_flashdata('message', 'Skp berhasil diperbaharui!');
            if ($_FILES['uploadBukti']['name']) {
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/poinskp/';
                $config['file_name'] = time() . '_poinskp_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('uploadBukti')) {
                    unlink(FCPATH . "file_bukti/" . $this->dataPoinSkp[0]['file_bukti']);
                    $data['file_bukti'] = 'poinskp/' . $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'Skp gagal ditambahkan! file bukti tidak sesuai format');
                    echo $this->upload->display_errors();
                }
            }
            if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) {
                $data['validasi_prestasi'] = $this->dataPoinSkp[0]['validasi_prestasi'];
                $this->poinskp->updatePoinSkp($this->dataPoinSkp[0]['id_poin_skp'], $data);
                $this->_update($nim);
                redirect("Kemahasiswaan/daftarPoinSkp");
            } else {
                $this->poinskp->updatePoinSkp($this->dataPoinSkp[0]['id_poin_skp'], $data);
                $this->_update($nim);
                redirect("Mahasiswa/poinSkp");
            }
        }
    }
    private function _update($nim)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->totalPoinSKp = $this->poinskp->updateTotalPoinSkp($nim);

        $this->db->set('total_poin_skp', $this->totalPoinSKp);
        $this->db->where('nim', $nim);
        $this->db->update('mahasiswa');
    }

    // Pengajuan Proposal kegiatan
    public function pengajuanProposal()
    {
        $data['title'] = "Pengajuan";
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
        $this->load->view("mahasiswa/pengajuan_proposal", $data);
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    // Pengajuan tambah proposal kegiatan
    public function tambahProposal()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $data['dana'] = $this->db->get('sumber_dana')->result_array();
        $gambar = [];
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        $this->form_validation->set_rules('jumlahAnggota', 'Jumlah Anggota', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_tambah_proposal");
            $this->load->view("template/footer");
        } else {

            if ($this->input->post('jumlahAnggota') <= 0) {
                $this->session->set_flashdata('failed', 'Anggota kegiatan tidak boleh kosong !');
                redirect("Mahasiswa/pengajuanProposal");
            }

            // get id tingkatan
            $sm_id = $this->input->post('tingkatKegiatan');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_id])->row_array();
            $this->proposal = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'status_selesai_proposal' => 0,
                'status_selesai_lpj' => 0,
                'dana_kegiatan' => $this->input->post('danaKegiatan'),
                'dana_proposal' => $this->input->post('danaKegiatanDiterima'),
                'id_lembaga' => 0,
                'tanggal_kegiatan' => $this->input->post('tglPelaksanaan'),
                'lokasi_kegiatan' => $this->input->post('tempatPelaksanaan'),
                'periode' => date("Y"),
                'acc_rancangan' => 1,
                'deskripsi_kegiatan' => $this->input->post('deskripsiKegiatan'),
                'tgl_pengajuan_proposal' => date("Y-m-d"),
                'id_penanggung_jawab' => $this->input->post('nim'),
                'nama_penanggung_jawab' => $this->input->post('namaMahasiswa'),
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
                $config['file_name'] = time() . '_file_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileProposal')) {
                    $this->proposal['proposal_kegiatan'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'File proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaProposal']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_proposal/';
                $config2['file_name'] =  time() . '_berita_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaProposal')) {
                    $this->proposal['berita_proposal'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/proposal/" . $this->proposal['proposal_kegiatan']);
                    $this->session->set_flashdata('failed', 'File berita proposal tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanProposal1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_proposal/';
                $config3['file_name'] = time() . '_gambar1_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanProposal1')) {
                    $gambar['d_proposal_1'] = $this->upload->data('file_name');;
                } else {
                    unlink(FCPATH . "file_bukti/berita_proposal/" . $this->proposal['berita_proposal']);
                    unlink(FCPATH . "file_bukti/proposal/" . $this->proposal['proposal_kegiatan']);
                    $this->session->set_flashdata('failed', 'gambar proposal tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }
            // upload gambar2 kegiatan
            if ($_FILES['gambarKegiatanProposal2']['name']) {
                $config4['allowed_types'] = 'jpg|jpeg';
                $config4['max_size']     = '2048'; //kb
                $config4['upload_path'] = './file_bukti/foto_proposal/';
                $config4['file_name'] = time() . '_gambar2_proposal_' . $this->session->userdata('username');
                $this->load->library('upload', $config4);
                $this->upload->initialize($config4);
                if ($this->upload->do_upload('gambarKegiatanProposal2')) {
                    $gambar['d_proposal_2'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/foto_lpj/" . $gambar['d_proposal_1']);
                    unlink(FCPATH . "file_bukti/berita_proposal/" . $this->proposal['berita_proposal']);
                    unlink(FCPATH . "file_bukti/proposal/" . $this->proposal['proposal_kegiatan']);
                    $this->session->set_flashdata('failed', 'gambar proposal tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }

            $this->kegiatan->insertKegiatan($this->proposal);
            $kegiatan = $this->kegiatan->getIdKegiatan($this->proposal['id_penanggung_jawab'], $this->proposal['nama_kegiatan'], $this->proposal['waktu_pengajuan']);
            // insert data dokumentasi
            $gambar['id_kegiatan'] = $kegiatan['id_kegiatan'];
            $this->kegiatan->insertDokumentasiKegiatan($gambar);


            // insert anggota kegiatan
            $data_anggota = [];
            $kode_prestasi = 0;
            foreach ($data['mahasiswa'] as $m) {
                if ($this->input->post('nim_' . $m['nim'])) {
                    $data_anggota[$m['nim']] = [
                        'nim' => $this->input->post('nim_' . $m['nim']),
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                        'keaktifan' => 0,
                        'id_prestasi' => $this->input->post('id_semua_prestasi')
                    ];
                    $kode_prestasi = $this->input->post('id_semua_prestasi');
                }
            }
            // apakah mahasiswa pemohon ada pada daftar anggota
            $cek_pemohon = true;
            foreach ($data_anggota as $da) {
                if ($da['nim'] == $this->session->userdata('username')) {
                    $cek_pemohon = false;
                }
            }
            if ($cek_pemohon) {
                $data_anggota[$this->session->userdata('username')] = [
                    'nim' => $this->session->userdata('username'),
                    'id_kegiatan' => $kegiatan['id_kegiatan'],
                    'keaktifan' => 0,
                    'id_prestasi' => $kode_prestasi
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
                        'status_validasi' => 3,
                        'id_user' => 8,
                        'id_kegiatan' => $kegiatan['id_kegiatan'],
                    ];
                } elseif ($i == 3) {
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
            $this->session->set_flashdata('message', 'Data proposal berhasil ditambah !');
            redirect("Mahasiswa/pengajuanProposal");
        }
    }

    public function hapusKegiatan($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');;
        $file_kegiatan = $this->db->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->row_array();
        $dokumentasi_kegiatan = $this->db->get_where('dokumentasi_kegiatan', ['id_kegiatan' => $id_kegiatan])->row_array();
        $this->load->library('upload');
        if (file_exists($file_kegiatan['proposal_kegiatan'] || $file_kegiatan['berita_proposal']) || $dokumentasi_kegiatan['d_proposal_1'] || $dokumentasi_kegiatan['d_proposal_2']) {
            unlink(FCPATH . "file_bukti/proposal/" . $file_kegiatan['proposal_kegiatan']);
            unlink(FCPATH . "file_bukti/berita_proposal/" . $file_kegiatan['berita_proposal']);
            unlink(FCPATH . "file_bukti/foto_proposal/" . $dokumentasi_kegiatan['d_proposal_1']);
            unlink(FCPATH . "file_bukti/foto_proposal/" . $dokumentasi_kegiatan['d_proposal_2']);
            $this->kegiatan->hapusKegiatan($id_kegiatan);
            $this->session->set_flashdata('message', 'Data proposal berhasil dihapus !');
        } else {
            $this->session->set_flashdata('message', 'Data proposal gagal dihapus !');
        }
        redirect("Mahasiswa/pengajuanProposal");
    }

    // Pengajuan tambah proposal kegiatan
    public function editProposal($id_kegiatan)
    {
        // $id_kegiatan = $this->input->post('id_kegiatan');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan, $this->session->userdata('username'));
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $data['dokumentasi'] = $this->kegiatan->getDokumentasi($id_kegiatan);
        $data['dana_kegiatan'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['dana'] = $this->kegiatan->getSumberDanaLain($id_kegiatan);
        $data['validasi'] = $this->kegiatan->getDataValidasi($id_kegiatan, null, 'proposal');
        $data['jenis_revisi'] = $this->input->post_get('jenis_revisi');
        $gambar = [];
        if ($data['kegiatan'] == null || $data['kegiatan']['status_selesai_proposal'] == 3) {
            redirect('Mahasiswa/pengajuanProposal');
        }
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_edit_proposal");
            $this->load->view("template/footer");
        } else {
            $jumlahAnggota = $this->input->post('jumlahAnggota');
            if ($data['jenis_revisi'] == 0 || $data['jenis_revisi'] == 2 || $data['jenis_revisi'] == 3 || $data['jenis_revisi'] == 4) {
                if ($jumlahAnggota <= 0) {
                    $this->session->set_flashdata('failed', 'Anggota kegiatan tidak boleh kosong');
                    redirect("Mahasiswa/daftarPengajuanProposal");
                }
            }

            // get id tingkatan
            $sm_id = $this->input->post('tingkatKegiatan');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_id])->row_array();
            $proposal = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'status_selesai_proposal' => 1,
                'status_selesai_lpj' => 0,
                'dana_kegiatan' => $this->input->post('danaKegiatan'),
                'dana_proposal' => $this->input->post('danaKegiatanDiterima'),
                'tanggal_kegiatan' => $this->input->post('tglPelaksanaan'),
                'lokasi_kegiatan' => $this->input->post('tempatPelaksanaan'),
                'deskripsi_kegiatan' => $this->input->post('deskripsiKegiatan'),
                'tgl_pengajuan_proposal' => date("Y-m-d"),
                'id_penanggung_jawab' => $this->input->post('nim'),
                'no_whatsup' => $this->input->post('noTlpn'),
                'id_tingkatan' => $idTingkatan['id_tingkatan'],
                'waktu_pengajuan' => time(),
                'tanggal_selesai_kegiatan' => $this->input->post('tglSelesaiPelaksanaan'),
                'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                'url_penyelenggara' => $this->input->post('urlPenyelenggara'),
            ];
            if ($this->input->post('jenis_revisi') == 0) {
                $proposal['status_selesai_proposal'] = 0;
            } elseif ($this->input->post('jenis_revisi') == 5) { // jika revisi dari keuangan dan psik
                $proposal = [];
                $proposal = [
                    'nama_kegiatan' => $this->input->post('namaKegiatan'),
                    'status_selesai_proposal' => 1,
                    'no_whatsup' => $this->input->post('noTlpn'),
                    'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                    'url_penyelenggara' => $this->input->post('urlPenyelenggara'),
                ];
            } elseif ($this->input->post('jenis_revisi') == 6) {
                $proposal = [];
                $proposal = [
                    'nama_kegiatan' => $this->input->post('namaKegiatan'),
                    'status_selesai_proposal' => 1,
                    'no_whatsup' => $this->input->post('noTlpn'),
                    'dana_kegiatan' => $this->input->post('danaKegiatan'),
                    'dana_proposal' => $this->input->post('danaKegiatanDiterima'),
                    'nama_penyelenggara' => $this->input->post('namaPenyelenggara'),
                    'url_penyelenggara' => $this->input->post('urlPenyelenggara'),
                ];
            }
            // update file proposal jika buka keuangan
            if ($this->input->post('jenis_revisi') != 6) {
                if ($_FILES['fileProposal']['name']) {
                    $config['allowed_types'] = 'pdf';
                    $config['max_size']     = '2048'; //kb
                    $config['upload_path'] = './file_bukti/proposal/';
                    $config['file_name'] = time() . '_file_proposal_' . $this->session->userdata('username');
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('fileProposal')) {
                        // unlink(FCPATH . "file_bukti/proposal/" . $data['kegiatan']['proposal_kegiatan']);
                        $proposal['proposal_kegiatan'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('failed', 'File proposal tidak sesuai format (.pdf/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanProposal");
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
                        // unlink(FCPATH . "file_bukti/berita_proposal/" . $data['kegiatan']['berita_proposal']);
                        $proposal['berita_proposal'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('failed', 'File berita proposal tidak sesuai format (.pdf/2mb) !');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanProposal");
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
                        $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanProposal");
                    }
                }
                // update gambar2 kegiatan
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
                        $this->session->set_flashdata('failed', 'File gambar tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanProposal");
                    }
                }
            }


            $this->kegiatan->updateKegiatan($proposal, $id_kegiatan);
            if ($gambar) {
                $this->kegiatan->updateDokumentasiKegiatan($gambar, $id_kegiatan);
            }

            if ($data['jenis_revisi'] == 0 || $data['jenis_revisi'] == 2 || $data['jenis_revisi'] == 3 || $data['jenis_revisi'] == 4) {
                $data_anggota = [];
                $kode_prestasi = 0;
                if ($jumlahAnggota) {
                    foreach ($data['mahasiswa'] as $m) {
                        if ($this->input->post('nim_' . $m['nim'])) {
                            $data_anggota[$m['nim']] = [
                                'nim' => $this->input->post('nim_' . $m['nim']),
                                'id_kegiatan' => $id_kegiatan,
                                'keaktifan' => 0,
                                'id_prestasi' => $this->input->post('id_semua_prestasi')
                            ];
                            $kode_prestasi = $this->input->post('id_semua_prestasi');
                        }
                    }
                    // apakah mahasiswa pemohon ada pada daftar anggota
                    $cek_pemohon = true;
                    foreach ($data_anggota as $da) {
                        if ($da['nim'] == $this->session->userdata('username')) {
                            $cek_pemohon = false;
                        }
                    }
                    if ($cek_pemohon) {
                        $data_anggota[$this->session->userdata('username')] = [
                            'nim' => $this->session->userdata('username'),
                            'id_kegiatan' => $id_kegiatan,
                            'keaktifan' => 0,
                            'id_prestasi' => $kode_prestasi
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
            redirect("Mahasiswa/pengajuanProposal");
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

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("mahasiswa/pengajuan_lpj", $data);
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    public function tambahLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_poinskp', 'poinskp');
        $data['title'] = "Pengajuan";
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
            $this->load->view("mahasiswa/form_tambah_lpj");
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
                    echo 'data gagal ditambah';
                    $this->session->set_flashdata('failed', 'File lpj tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanLpj");
                }
            }
            // upload berita proposal
            if ($_FILES['beritaLpj']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_lpj/';
                $config2['file_name'] = time() . '_berita_lpj' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaLpj')) {
                    $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    echo 'data gagal ditambah';
                    $this->session->set_flashdata('failed', 'File berita lpj tidak sesuai format (.pdf/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanLpj");
                }
            }
            // upload gambar1 kegiatan
            if ($_FILES['gambarKegiatanLpj1']['name']) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_lpj/';
                $config3['file_name'] = time() . '_gambar1_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanLpj1')) {
                    $gambar['d_lpj_1'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    echo 'data gagal ditambah';
                    $this->session->set_flashdata('failed', 'File gambar 1 tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanLpj");
                }
            }
            // upload gambar2 kegiatan
            if ($_FILES['gambarKegiatanLpj2']['name']) {
                $config4['allowed_types'] = 'jpg|jpeg';
                $config4['max_size']     = '2048'; //kb
                $config4['upload_path'] = './file_bukti/foto_lpj/';
                $config4['file_name'] = time() . '_gambar2_lpj_' . $this->session->userdata('username');
                $this->load->library('upload', $config4);
                $this->upload->initialize($config4);
                if ($this->upload->do_upload('gambarKegiatanLpj2')) {
                    $gambar['d_lpj_2'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/foto_lpj/" . $gambar['d_lpj_1']);
                    unlink(FCPATH . "file_bukti/berita_lpj/" . $lpj['berita_lpj']);
                    unlink(FCPATH . "file_bukti/lpj/" . $lpj['lpj_kegiatan']);
                    echo 'data gagal ditambah';
                    $this->session->set_flashdata('failed', 'File gambar 2 tidak sesuai format (.jpg/2mb)');
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanLpj");
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
                        'status_validasi' => 3,
                    ];
                } elseif ($v['jenis_validasi'] == 3) {
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
            $this->session->set_flashdata('message', ' Data lpj berhasil ditambahkan !');
            redirect("Mahasiswa/pengajuanLpj");
        }
    }

    // Edit laporan pertanggung jawaban kegiatan mahasiswa
    public function editLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_poinskp', 'poinskp');
        $data['title'] = "Pengajuan";
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan);
        $data['dana'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['anggota'] = $this->kegiatan->getInfoAnggota($id_kegiatan);
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['prestasi'] = $this->poinskp->getPrestasi($data['tingkat'][0]['id_semua_tingkatan']);
        $data['dokumentasi'] = $this->kegiatan->getDokumentasi($id_kegiatan);
        $data['jenis_revisi'] = $this->input->post_get('jenis_revisi');
        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_edit_lpj");
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

            if ($data['jenis_revisi'] != 6) {
                // upload file lpj
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
                        $this->session->set_flashdata('failed', 'File lpj tidak sesuai format (.pdf/(2mb)!');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanLpj");
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
                        //  unlink(FCPATH . "file_bukti/berita_lpj/" . $data['kegiatan']['berita_pelaporan']);
                        $lpj['berita_pelaporan'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('failed', 'Berita lpj tidak sesuai format (.pdf/(2mb)!');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanLpj");
                    }
                }
                // upload gambar kegiatan
                if ($_FILES['gambarKegiatanLpj1']['name']) {
                    $config3['allowed_types'] = 'jpg|jpeg';
                    $config3['max_size']     = '2048'; //kb
                    $config3['upload_path'] = './file_bukti/foto_lpj/';
                    $config3['file_name'] = time() . '_gambar1_lpj_' . $this->session->userdata('username');
                    $this->load->library('upload', $config3);
                    $this->upload->initialize($config3);
                    if ($this->upload->do_upload('gambarKegiatanLpj1')) {
                        // unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_1']);
                        $gambar['d_lpj_1'] = $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('message', 'Gambar 1 tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanLpj");
                    }
                }
                if ($_FILES['gambarKegiatanLpj2']['name']) {
                    $config4['allowed_types'] = 'jpg|jpeg';
                    $config4['max_size']     = '2048'; //kb
                    $config4['upload_path'] = './file_bukti/foto_lpj/';
                    $config4['file_name'] = time() . '_gambar2_lpj_' . $this->session->userdata('username');
                    $this->load->library('upload', $config4);
                    $this->upload->initialize($config4);
                    if ($this->upload->do_upload('gambarKegiatanLpj2')) {
                        // unlink(FCPATH . "file_bukti/foto_lpj/" . $data['dokumentasi']['d_lpj_2']);
                        $gambar['d_lpj_2'] =  $this->upload->data('file_name');
                    } else {
                        $this->session->set_flashdata('message', 'Gambar 2 tidak sesuai format (.jpg/2mb)');
                        echo $this->upload->display_errors();
                        redirect("Mahasiswa/pengajuanLpj");
                    }
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
                //update anggota kegiatan
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
            // update validasi 
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
            $this->session->set_flashdata('message', ' Data lpj berhasil perbaharui !');
            redirect("Mahasiswa/pengajuanLpj");
        }
    }


    // cetak poin skp
    public function cetakSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa($this->session->userdata('username'));
        $data['poinskp'] = $this->poinskp->getPoinSkp($this->session->userdata('username'));

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        // QR Code
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']        = './assets/'; //string, the default is application/cache/
        $config['errorlog']        = './assets/'; //string, the default is application/logs/
        $config['imagedir']        = 'assets/qrcode/'; //direktori penyimpanan qr code
        $config['quality']        = true; //boolean, the default is true
        $config['size']            = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = 'bukti_skp_' . $this->session->userdata('username') . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = base_url("API_skp/cetakSkp?nim=" . $this->session->userdata('username')); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE


        $this->load->view('mahasiswa/tampilan_transkrip_poin', $data);
    }
    // form pengajuan beasiswa 
    public function beasiswa()
    {

        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['beasiswa'] = $this->db->get('beasiswa')->result_array();
        $data['penerima_beasiswa'] = $this->mahasiswa->getBeasiswa($this->session->userdata('username'));
        // set rules form validation
        $this->form_validation->set_rules('namaMahasiswa', 'Nama Mahasiswa', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Beasiswa";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/beasiswa");
            $this->load->view("template/footer");
        } else {
            $beasiswa = [
                "id_beasiswa" => $this->input->post('jenisBeasiswa'),
                "nim" => $this->input->post('nimMahasiswa'),
                "tahun_menerima" => $this->input->post('tahunMenerima'),
                "lama_menerima" => $this->input->post('lamaMenerima'),
                "nominal" => $this->input->post('nominalBeasiswa'),
                "validasi_beasiswa" => 0
            ];

            // upload file proposal
            if ($_FILES['lampiran']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/beasiswa/';
                $config['file_name'] = time() . '_lampiran_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('lampiran')) {
                    $beasiswa['lampiran'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'Beasiswa gagal ditambahkan !');
                    redirect("Mahasiswa/beasiswa");
                }
            }

            // upload file proposal
            if ($_FILES['uploadBukti']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/beasiswa/';
                $config2['file_name'] = time() . '_bukti_penerimaan_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('uploadBukti')) {
                    $beasiswa['bukti'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/beasiswa/" .  $beasiswa['lampiran']);
                    $this->session->set_flashdata('failed', 'Beasiswa gagal ditambahkan !');
                    redirect("Mahasiswa/beasiswa");
                }
            }
            $this->session->set_flashdata('message', 'Beasiswa berhasil ditambah !');
            $this->mahasiswa->insertBeasiswa($beasiswa);
            redirect('Mahasiswa/beasiswa');
        }
    }

    public function daftarMahasiswa()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        echo json_encode($data['mahasiswa']);
    }

    public function bidangKegiatan()
    {
        $this->bidangKegiatan = $this->db->get_where('bidang_kegiatan', ['status_bidang' => 1])->result_array();
        echo json_encode($this->bidangKegiatan);
    }
    public function jenisKegiatan($id_bidang)
    {
        $this->jenisKegiatan = $this->db->get_where('jenis_kegiatan', ['id_bidang' => $id_bidang, 'status_jenis' => 1])->result_array();
        echo json_encode($this->jenisKegiatan);
    }
    public function tingkatKegiatan($id_jenis)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->tingkatKegiatan = $this->poinskp->getTingkatSkp($id_jenis, 1);
        echo json_encode($this->tingkatKegiatan);
    }
    public function partisipasiKegiatan($id_sm_tingkat)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->partisipasiKegiatan = $this->poinskp->getPrestasi($id_sm_tingkat, 1);
        echo json_encode($this->partisipasiKegiatan);
    }

    public function bobotKegiatan($id_sm_prestasi)
    {
        $this->bobotKegiatan = $this->db->get_where('semua_prestasi', ['id_semua_prestasi' => $id_sm_prestasi])->result_array();
        echo json_encode($this->bobotKegiatan);
    }
    public function detailKegiatan($id_kegiatan = null)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        echo json_encode($this->poinskp->getPoinSkp($this->session->userdata('username'), $id_kegiatan));
    }

    public function daftarFileDownload()
    {
        $data['title'] = 'Pengaturan File Download';
        $data['file_download'] = $this->db->get('file_download')->result_array();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_file_download");
        $this->load->view("template/footer");
    }
}
