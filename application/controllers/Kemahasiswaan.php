<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kemahasiswaan extends CI_Controller
{
    private $dataPengajuanSkp = [];
    private $dataskp = [];
    private $totalPoinSKp;
    private $proposalKegiatan = [];
    private $lembaga = [];

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_kmhsn");
        $this->load->view("template/footer");
    }
    public function kategori()
    {
        $data['title'] = 'Kategori Kegiatan';
        $data['bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $this->db->select('id_jenis_kegiatan, jenis_kegiatan, nama_bidang');
        $this->db->from('jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['jenis'] = $this->db->get()->result_array();
        $data['tingkatan'] = $this->db->get('tingkatan')->result_array();
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/kategori");
        $this->load->view("template/footer");
    }

    public function getBidangKegiatan()
    {
        $bidang = $this->db->get('bidang_kegiatan')->result_array();
        echo json_encode($bidang);
    }
    public function getJenisKegiatan()
    {
        $jenis = $this->db->get('jenis_kegiatan')->result_array();
        echo json_encode($jenis);
    }
    public function getTingkatanKegiatan()
    {
        $tingkatan = $this->db->get('tingkatan')->result_array();
        echo json_encode($tingkatan);
    }

    public function tambahBidang()
    {
        $bidang = $this->input->post('bidang_kegiatan');
        $data_bidang = [
            'nama_bidang' => $bidang
        ];
        $this->db->insert('bidang_kegiatan', $data_bidang);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil ditambahkan</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function editBidang($id)
    {
        $bidang = $this->input->post('bidang_kegiatan');
        $data_bidang = [
            'nama_bidang' => $bidang
        ];
        $this->db->set($data_bidang);
        $this->db->where('id_bidang', $id);
        $this->db->update('bidang_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusBidang($id)
    {
        $this->db->where('id_bidang', intval($id));
        $this->db->delete('bidang_kegiatan');

        $jenis_kegiatan = $this->db->get_where('jenis_kegiatan', ['id_bidang' => intval($id)])->result_array();

        for ($i = 0; $i < count($jenis_kegiatan); $i++) {
            $id_jenis_kegiatan = $jenis_kegiatan[$i]['id_jenis_kegiatan'];
            $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_jenis_kegiatan' => intval($id_jenis_kegiatan)])->result_array();
            for ($j = 0; $j < count($semua_tingkatan); $j++) {
                $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
                $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
                $this->db->delete('semua_prestasi');
            }
            $this->db->where('id_jenis_kegiatan', intval($id_jenis_kegiatan));
            $this->db->delete('semua_tingkatan');
        }
        $this->db->where('id_bidang', intval($id));
        $this->db->delete('jenis_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil dihapus</div>');
        redirect('akademik/kegiatan');
    }
    public function tambahJenis()
    {
        $jenis = $this->input->post('jenis_kegiatan');
        $bidang = $this->input->post('bidang_kegiatan');
        $data_jenis = [
            'jenis_kegiatan' => $jenis,
            'id_bidang' => intval($bidang)
        ];
        $this->db->insert('jenis_kegiatan', $data_jenis);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil ditambahkan</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function editJenis($id)
    {
        $jenis = $this->input->post('jenis_kegiatan');
        $bidang = $this->input->post('bidang_kegiatan');
        $data_jenis = [
            'jenis_kegiatan' => $jenis,
            'id_bidang' => intval($bidang)
        ];
        $this->db->set($data_jenis);
        $this->db->where('id_jenis_kegiatan', $id);
        $this->db->update('jenis_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusJenis($id)
    {
        $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_jenis_kegiatan' => intval($id)])->result_array();
        for ($j = 0; $j < count($semua_tingkatan); $j++) {
            $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
            $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
            $this->db->delete('semua_prestasi');
        }
        $this->db->where('id_jenis_kegiatan', intval($id));
        $this->db->delete('semua_tingkatan');

        $this->db->where('id_bidang', intval($id));
        $this->db->delete('jenis_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil dihapus</div>');
        redirect('akademik/kegiatan');
    }
    public function tambahTingkatan()
    {
        $tingkatan = $this->input->post('tingkatan');
        $data_tingkatan = [
            'nama_tingkatan' => $tingkatan
        ];
        $this->db->insert('tingkatan', $data_tingkatan);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil ditambahkan</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function editTingkatan($id)
    {
        $tingkatan = $this->input->post('tingkatan');
        $data_tingkatan = [
            'nama_tingkatan' => $tingkatan
        ];
        $this->db->set($data_tingkatan);
        $this->db->where('id_tingkatan', $id);
        $this->db->update('tingkatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusTingkatan($id)
    {
        $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_tingkatan' => intval($id)])->result_array();
        for ($j = 0; $j < count($semua_tingkatan); $j++) {
            $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
            $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
            $this->db->delete('semua_prestasi');
        }
        $this->db->where('id_tingkatan', intval($id));
        $this->db->delete('semua_tingkatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil dihapus</div>');
        redirect('akademik/kegiatan');
    }
    public function tambahPrestasi()
    {
        $prestasi = $this->input->post('prestasi');
        $data_prestasi = [
            'nama_prestasi' => $prestasi
        ];
        $this->db->insert('prestasi', $data_prestasi);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestasi berhasil ditambahkan</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function editPrestasi($id)
    {
        $prestasi = $this->input->post('prestasi');
        $data_prestasi = [
            'nama_prestasi' => $prestasi
        ];
        $this->db->set($data_prestasi);
        $this->db->where('id_prestasi', $id);
        $this->db->update('prestasi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestaso berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusPrestasi($id)
    {
        $this->db->where('id_prestasi', intval($id));
        $this->db->delete('semua_prestasi');

        $this->db->where('id_prestasi', intval($id));
        $this->db->delete('prestasi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestasi berhasil dihapus</div>');
        redirect('akademik/kegiatan');
    }
    // update pebukaan rancangan kegiatan lembaga
    public function pembukaanRancanganKegiatan()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['lembaga'] =  $this->kemahasiswaan->getInfoLembaga();
        $index = 0;
        foreach ($data['lembaga'] as $l) {
            $this->lembaga[$index++] = [
                'id_lembaga' => $l['id_lembaga'],
                'status_rencana_kegiatan' => 1,
                'tahun_rancangan' => $this->input->post('tahun_rancangan')
            ];
        }
        $this->kemahasiswaan->updateStatusRencanaKegiatan($this->lembaga);
        redirect('Kemahasiswaan/lembaga');
    }

    // Berfungsi untuk melakukan validasi rancangan kegiatan mahasiswa
    public function daftarRancangan()
    {
        $data['title'] = 'Pengajuan';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
        $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan();
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
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
        $id_lembaga = $this->input->get('id_lembaga');
        $tahun_pengajuan = $this->input->get('tahun');
        $data['detail_rancangan'] = $this->kemahasiswaan->detailRancangan($id_lembaga, $tahun_pengajuan);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar");
        $this->load->view("kemahasiswaan/detail_rancangan_kegiatan");
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
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
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
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
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
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
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
        $data['notif_kmhs'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
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
}
