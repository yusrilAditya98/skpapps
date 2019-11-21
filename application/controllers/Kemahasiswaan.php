<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kemahasiswaan extends CI_Controller
{

    private $dataPengajuanSkp = [];
    private $dataskp = [];
    private $totalPoinSKp;
    private $proposalKegiatan = [];

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
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

    // Berfungsi untuk melakukan validasi rancangan kegiatan mahasiswa
    public function validasi_rancangan()
    {
        $this->load->view("template/header");
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar");
        $this->load->view("kemahasiswaan/daftar_validasi_rancangan");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi Proposal kegiatan mahasiswa dan lembaga
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_validasi_proposal");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi LPJ kegiatan mahasiswa dan lembaga
    public function daftarLpj()
    {

        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_validasi_lpj");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi poin skp mahasiswa
    public function daftarPoinSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->dataPengajuanSkp['poinskp'] = $this->poinskp->getPoinSkp();
        $data['title'] = 'Poin Skp';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_validasi_poin_skp", $this->dataPengajuanSkp);
        $this->load->view("template/footer");
    }

    // validasi poin skp
    public function validasiSkp($id_kegiatan)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $mahasiswa = $this->db->select('nim')->get_where('poin_skp', ['id_poin_skp' => $id_kegiatan])->row_array();
        $this->dataskp = [
            'validasi_prestasi' => $this->input->post('valid'),
            'catatan' => $this->input->post('catatan'),
        ];
        $this->poinskp->updatePoinSkp($id_kegiatan, $this->dataskp);
        $this->_update($mahasiswa['nim']);
        redirect('Kemahasiswaan/daftarPoinSkp');
    }

    // Validasi proposal kegiatan
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
        }
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_proposal = 2;
            $this->kegiatan->updateStatusProposal($id_kegiatan, $status_proposal);
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'proposal');
        }

        redirect('Kemahasiswaan/daftarProposal');
    }

    // Validasi proposal kegiatan
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
        }
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_lpj = 2;
            $this->kegiatan->updateStatusLpj($id_kegiatan, $status_lpj);
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'lpj');
        }

        redirect('Kemahasiswaan/daftarLpj');
    }


    // detail kegiatan skp
    public function detailKegiatan($id_kegiatan = null)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        echo json_encode($this->poinskp->getPoinSkp(null, $id_kegiatan));
    }

    public function detailProposalKegiatan($id_kegiatan = null)
    {
        $data = $this->db->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->result_array();
        echo json_encode($data);
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
}
