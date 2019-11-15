<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }
    public $bidangKegiatan = [];
    private $jenisKegiatan = [];
    private $tingkatKegiatan = [];
    private $partisipasiKegiatan = [];
    private $bobotKegiatan = [];
    private $dataPoinSkp = [];
    private $proposal = [];

    // tampilan dashboard
    public function index()
    {
        $data['title'] = "Dashboard";
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_mhs");
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
            $this->load->model('Model_poinskp', 'poinskp');
            $this->dataPoinSkp = [
                'nim' => $this->session->userdata('username'),
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'validasi_prestasi' => 0,
                'tgl_pelaksanaan' => $this->input->post('tanggalKegiatan'),
                'file_bukti' => $_FILES['uploadBukti']['name'],
                'tempat_pelaksanaan' => $this->input->post('tempatKegiatan'),
                'prestasiid_prestasi' => $this->input->post('partisipasiKegiatan'),
                'tgl_pengajuan' => date("Y-m-d")
            ];
            if ($_FILES['uploadBukti']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/poinskp/';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('uploadBukti')) {
                    $this->poinskp->insertPoinSkp($this->dataPoinSkp);
                } else {
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
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
        unlink(FCPATH . "file_bukti/poinskp/" . $nama_file['file_bukti']);
        $this->poinskp->deletePoinSkp($id_poinSkp);
        redirect('Mahasiswa/poinSkp');
    }

    // Function melakukan edit/ubah poin skp
    public function editPoinSkp($id_kegiatan)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->dataPoinSkp = $this->poinskp->getPoinSkp($this->session->userdata('username'), $id_kegiatan);

        // set rules form validation
        $this->form_validation->set_rules('namaKegiatan', 'Nama Kegiatan', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Poin Skp";
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
                'prestasiid_prestasi' => $this->input->post('partisipasiKegiatan'),
                'tgl_pengajuan' => date("Y-m-d")
            ];
            if ($_FILES['uploadBukti']['name']) {

                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/poinskp/';
                $this->load->library('upload', $config);

                unlink(FCPATH . "file_bukti/poinskp/" . $this->dataPoinSkp[0]['file_bukti']);
                if ($this->upload->do_upload('uploadBukti')) {
                    $data['file_bukti'] = $_FILES['uploadBukti']['name'];
                } else {
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                }
            }
            $this->poinskp->updatePoinSkp($this->dataPoinSkp[0]['id_poin_skp'], $data);
            redirect("Mahasiswa/poinSkp");
        }
    }

    // Pengajuan Proposal kegiatan
    public function pengajuanProposal()
    {
        $data['title'] = "Pengajuan";
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan($this->session->userdata('username'));
        $data['validasi'] = $this->kegiatan->getDataValidasi();

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("mahasiswa/pengajuan_proposal", $data);
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
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengajuan";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("mahasiswa/form_tambah_proposal");
            $this->load->view("template/footer");
        } else {
            // get id tingkatan
            $sm_id = $this->input->post('tingkatKegiatan');
            $idTingkatan = $this->db->get_where('semua_tingkatan', ['id_semua_tingkatan' => $sm_id])->row_array();


            $proposal = [
                'nama_kegiatan' => $this->input->post('namaKegiatan'),
                'status_selesai_proposal' => 0,
                'status_selesai_lpj' => 0,
                'dana_kegiatan' => $this->input->post('danaKegiatan'),
                'dana_cair' => $this->input->post('danaKegiatanDiterima'),
                'id_lembaga' => 0,
                'tanggal_kegiatan' => $this->input->post('tglPelaksanaan'),
                'lokasi_kegiatan' => $this->input->post('tempatPelaksanaan'),
                'periode' => date("Y"),
                'acc_rancangan' => 1,
                'deskripsi_kegiatan' => $this->input->post('deskripsiKegiatan'),
                'tgl_pengajuan_proposal' => date("Y-m-d"),
                'id_penanggung_jawab' => $this->input->post('nim'),
                'no_whatsup' => $this->input->post('noTlpn'),
                'id_tingkatan' => $idTingkatan['id_tingkatan'],
                'waktu_pengajuan' => time()
            ];


            // upload file proposal
            if ($_FILES['fileProposal']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/proposal/';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileProposal')) {
                    $proposal['proposal_kegiatan'] = $_FILES['fileProposal']['name'];
                } else {
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }

            // upload berita proposal
            if ($_FILES['beritaProposal']['name']) {

                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/berita_proposal/';
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('beritaProposal')) {
                    $proposal['berita_proposal'] = $_FILES['beritaProposal']['name'];
                } else {
                    unlink(FCPATH . "file_bukti/proposal/" . $_FILES['fileProposal']['name']);
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
                }
            }
            // upload gambar kegiatan
            if ($_FILES['gambarKegiatanProposal1']['name'] && ($_FILES['gambarKegiatanProposal2']['name'])) {
                $config3['allowed_types'] = 'jpg|jpeg';
                $config3['max_size']     = '2048'; //kb
                $config3['upload_path'] = './file_bukti/foto_proposal/';
                $this->load->library('upload', $config3);
                $this->upload->initialize($config3);
                if ($this->upload->do_upload('gambarKegiatanProposal1') && $this->upload->do_upload('gambarKegiatanProposal2')) {
                    $gambar['d_proposal_1'] = $_FILES['gambarKegiatanProposal1']['name'];
                    $gambar['d_proposal_2'] = $_FILES['gambarKegiatanProposal2']['name'];
                } else {
                    unlink(FCPATH . "file_bukti/berita_proposal/" . $_FILES['beritaProposal']['name']);
                    unlink(FCPATH . "file_bukti/proposal/" . $_FILES['fileProposal']['name']);
                    echo 'data gagal ditambah';
                    echo $this->upload->display_errors();
                    redirect("Mahasiswa/pengajuanProposal");
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
            $jumlahAnggota = $this->input->post('jumlahAnggota');
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
            for ($i = 3; $i <= 6; $i++) {
                $data_validasi[$i] = [
                    'kategori' => 'proposal',
                    'jenis_validasi' => $i,
                    'status_validasi' => 0,
                    'id_user' => 8,
                    'id_kegiatan' => $kegiatan['id_kegiatan'],
                ];
            }
            $this->kegiatan->insertDataValidasi($data_validasi);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <div class="alert-title">Success</div>
              Data proposal berhasil ditambah !
            </div>
          </div>');
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
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <div class="alert-title">Success</div>
              Data proposal berhasil dihapus !
            </div>
          </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <div class="alert-title">Success</div>
              Data proposal gagal dihapus !
            </div>
          </div>');
        }
        redirect("Mahasiswa/pengajuanProposal");
    }


    public function daftarMahasiswa()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        echo json_encode($data['mahasiswa']);
    }

    public function bidangKegiatan()
    {
        $this->bidangKegiatan = $this->db->get('bidang_kegiatan')->result_array();
        echo json_encode($this->bidangKegiatan);
    }
    public function jenisKegiatan($id_bidang)
    {
        $this->jenisKegiatan = $this->db->get_where('jenis_kegiatan', ['id_bidang' => $id_bidang])->result_array();
        echo json_encode($this->jenisKegiatan);
    }
    public function tingkatKegiatan($id_jenis)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->tingkatKegiatan = $this->poinskp->getTingkatSkp($id_jenis);
        echo json_encode($this->tingkatKegiatan);
    }
    public function partisipasiKegiatan($id_sm_tingkat)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->partisipasiKegiatan = $this->poinskp->getPrestasi($id_sm_tingkat);
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
}
