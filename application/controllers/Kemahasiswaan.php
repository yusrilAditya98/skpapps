<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kemahasiswaan extends CI_Controller
{

    private $dataPengajuanSkp = [];
    private $dataskp = [];
    private $totalPoinSKp;
    private $proposalKegiatan = [];
    private $lembaga = [];
    private $rancangan = [];
    private $notif = [];
    private $id_lembaga;
    private $tahun;
    private $anggaran;

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    private function _notifKmhs()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_kmhs_lpj'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
        $this->notif['notif_kmhs_proposal'] = count($this->kemahasiswaan->getNotifValidasi(3, 'proposal'));
        $this->notif['notif_kmhs_rancangan'] = count($this->kemahasiswaan->getNotifValidasiRancangan());
        $this->notif['notif_kmhs_skp'] = count($this->kemahasiswaan->getNotifValidasiSkp());
        return $this->notif;
    }

    public function index()
    {
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Dashboard';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_kmhsn");
        $this->load->view("template/footer");
    }

    // update pebukaan rancangan kegiatan lembaga
    public function pembukaanRancanganKegiatan($id_lembaga)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $index = 0;
        $this->lembaga[$index++] = [
            'id_lembaga' => $id_lembaga,
            'status_rencana_kegiatan' => $this->input->get('status'),
        ];
        $this->kemahasiswaan->updateStatusRencanaKegiatan($this->lembaga);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-times"></i></div>
            <div class="alert-body">
            <div class="alert-title">Rancangan kegiatan berhasil di perbaharui ! </div>
            Update !
            </div>
        </div>');
        redirect('Kemahasiswaan/anggaran');
    }

    // Berfungsi untuk melakukan validasi rancangan kegiatan mahasiswa
    public function daftarRancangan()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga();
        $data['filter'] = $this->kegiatan->getDataFilterRancangan();
        $data['notif'] = $this->_notifKmhs();
        if ($this->input->get('tahun') != null || $this->input->get('lembaga') != null || $this->input->get('status') != null) {
            $tahun = $this->input->get('tahun');
            $lembaga = $this->input->get('lembaga');
            $status =  $this->input->get('status');
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan($tahun, $lembaga, $status);
        } else {
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan();
        }
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar");
        $this->load->view("kemahasiswaan/daftar_validasi_rancangan");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk menampilkan detail rancangan kegiatan pada tahun tertentu
    public function detailRancanganKegiatan()
    {

        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $id_lembaga = $this->input->get('id_lembaga');
        $tahun_pengajuan = $this->input->get('tahun');
        $data['detail_rancangan'] = $this->kemahasiswaan->detailRancangan($id_lembaga, $tahun_pengajuan);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar");
        $this->load->view("kemahasiswaan/detail_rancangan_kegiatan");
        $this->load->view("modal/modal_revisi");
        $this->load->view("template/footer");
    }

    // validasi rancangan proker lembaga
    public function validasiRancanganProker()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $id_lembaga = $this->input->post('id_lembaga');
        $tahun_pengajuan = $this->input->post('tahun');
        $data['detail_rancangan'] = $this->kemahasiswaan->detailRancangan($id_lembaga, $tahun_pengajuan);
        $proker = [];

        $index = 0;
        foreach ($data['detail_rancangan'] as $r) {
            $proker[$index++] = [
                'id_daftar_rancangan' => $r['id_daftar_rancangan'],
                'status_rancangan' => $this->input->post('valid_' . $r['id_daftar_rancangan']),
            ];
        }

        $this->kemahasiswaan->updateDataStatusProker($proker);

        $status_rancangan = $this->input->post('valid');
        // update rekapan kegiatan
        $this->kemahasiswaan->updateRekapKegiatan($id_lembaga, $tahun_pengajuan, $status_rancangan);
        redirect('Kemahasiswaan/daftarRancangan');
    }

    // Berfungsi untuk melakukan validasi Proposal kegiatan mahasiswa dan lembaga
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();

        $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_validasi_proposal");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi LPJ kegiatan mahasiswa dan lembaga
    public function daftarLpj()
    {

        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_validasi_lpj");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi poin skp mahasiswa
    public function daftarPoinSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $this->dataPengajuanSkp['poinskp'] = $this->poinskp->getPoinSkp();
        $data['title'] = 'Validasi';
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

    // lihat daftar lembaga di FEB
    public function lembaga()
    {
        $data['title'] = 'Lembaga';

        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/lembaga");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
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



    public function validasiKegiatan($id)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['validasi'] = $this->kegiatan->getInfoValidasi($id);
        echo json_encode($data['validasi']);
    }


    public function anggaran()
    {
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Anggaran';;
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['lembaga'] = $this->kemahasiswaan->getRekapRancangan();
        $data['anggaran'] = $this->kemahasiswaan->getDanaAnggaran(2020);

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_anggaran");
        $this->load->view("template/footer");
    }

    public function editAnggaranRancangan()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->anggaran = $this->input->post('nominal');
        $this->tahun = $this->input->post('tahun');
        $this->id_lembaga = $this->input->post('id_lembaga');

        $this->kemahasiswaan->updateRekapKegiatan($this->id_lembaga, $this->tahun, null, $this->anggaran);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-times"></i></div>
            <div class="alert-body">
            <div class="alert-title">Dana kegiatan berhasil di perbaharui ! </div>
            Update !
            </div>
        </div>');
        redirect('Kemahasiswaan/anggaran');
    }


    public function tambahAnggaranKegiatan()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga();

        $index = 0;
        foreach ($data['lembaga'] as $l) {
            $this->lembaga[$index] = [
                'id_lembaga' => $l['id_lembaga'],
                'tahun_pengajuan' => $this->input->post('tahun_rancangan'),
                'anggaran_kemahasiswaan' => $this->input->post('lembaga_' . $l['id_lembaga']),
                'anggaran_lembaga' => 0,
                'status_rancangan' => 0
            ];
            $this->rancangan[$index++] = [
                'id_lembaga' => $l['id_lembaga'],
                'status_rencana_kegiatan' => 1,
                'tahun_rancangan' => $this->input->post('tahun_rancangan')
            ];
        }

        $this->kemahasiswaan->updateStatusRencanaKegiatan($this->rancangan);
        $this->kemahasiswaan->insertAnggaranRancangan($this->lembaga);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
          <div class="alert-title">Success</div>
          Dana pagu lembaga berhasil ditambahkan !
        </div>
      </div>');
        redirect('Kemahasiswaan/anggaran');
    }




    public function cetakPengajuanProposal()
    {
        $data['kegiatan'] = [];
        $kegiatan = $this->db->get('kegiatan')->result_array();
        $index = 0;
        foreach ($kegiatan as $k) {
            if ($this->input->post('cek_' . $k['id_kegiatan'])) {
                $data['kegiatan'][$index] = [
                    'nama_kegiatan' => $k['nama_kegiatan'],
                    'tanggal_kegiatan' => $k['tanggal_kegiatan'],
                    'deskripsi_kegiatan' => $k['deskripsi_kegiatan'],
                    'dana_kegiatan' => $k['dana_kegiatan']
                ];
            }
            $index++;
        }
        $this->load->view('kemahasiswaan/tampilan2', $data);
    }
    public function cetakPengajuanLpj()
    {
        $data['kegiatan'] = [];
        $kegiatan = $this->db->get('kegiatan')->result_array();
        $index = 0;
        foreach ($kegiatan as $k) {
            if ($this->input->post('cek_' . $k['id_kegiatan'])) {
                $data['kegiatan'][$index] = [
                    'nama_kegiatan' => $k['nama_kegiatan'],
                    'tanggal_kegiatan' => $k['tanggal_kegiatan'],
                    'deskripsi_kegiatan' => $k['deskripsi_kegiatan'],
                    'dana_kegiatan' => $k['dana_kegiatan']
                ];
            }
            $index++;
        }
        $this->load->view('kemahasiswaan/tampilan2', $data);
    }

    // menampilkan daftar poin skp keseluruhan mahasiswa
    public function skpMahasiswa()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['mahasiswa'] = $this->kemahasiswaan->getDataMahasiswa();
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Poin Skp';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/poin_skp_mhs");
        $this->load->view("template/footer");
    }
}
