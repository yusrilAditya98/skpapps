<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pimpinan extends CI_Controller
{
    private $tahun;
    private $lpj;
    private $proposal;
    private $data;
    private $nim;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 5 || $this->session->userdata('user_profil_kode') == 9) {
        } else {
            redirect('Auth/blocked');
        }
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

    public function template($data)
    {
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar", $data);
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
    }

    public function index()
    {
        $this->load->model('Model_keuangan', 'keuangan');
        $data['title'] = 'Dashboard';
        $data['jumlah_mahasiswa'] = count($this->db->get('mahasiswa')->result_array());
        $data['jumlah_lembaga'] = count($this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array());
        $data['jumlah_kegiatan_mahasiswa'] = count($this->db->get_where('kegiatan', ['acc_rancangan' => 1])->result_array());

        $this->db->where('total_poin_skp >=', 100);
        $data_mahasiswa_cukup_skp = $this->db->get('mahasiswa')->result_array();
        $data['tahun'] = $this->keuangan->getTahun();
        if ($data['tahun']) {
            $tahun = $data['tahun'][0]['tahun'];
            $data['tahun_saat_ini'] = $tahun;
        } else {
            $tahun = date('Y');
            $data['tahun_saat_ini'] = $tahun;
            $data['tahun'][0]['tahun'] = $tahun;
        }

        $data['jumlah_mahasiswa_cukup_skp'] = count($data_mahasiswa_cukup_skp);
        $this->template($data);
        $this->load->view("dashboard/dashboard_pimpinan", $data);
        $this->load->view("template/footer");
    }
    public function poinSkp()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['mahasiswa'] = $this->kemahasiswaan->getDataMahasiswa();
        $data['title'] = 'Poin Skp';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/poin_skp_mhs");
        $this->load->view("template/footer");
    }
    public function get_detail_mahasiswa($nim)
    {
        $this->db->where('mahasiswa.nim', $nim);
        $this->db->select('nim, nama, nama_prodi');
        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'mahasiswa.kode_prodi = prodi.kode_prodi');
        $detail_mahasiswa = $this->db->get()->row_array();
        header('Content-type: application/json');
        echo json_encode($detail_mahasiswa);
    }

    public function get_detail_skp($nim)
    {
        $this->db->where('poin_skp.nim', $nim);
        // $this->db->select('*');
        $this->db->select('id_poin_skp, bobot, nama_prestasi, nama_tingkatan, jenis_kegiatan, nama_bidang, tgl_pelaksanaan, nama_dasar_penilaian');
        $this->db->from('poin_skp');
        $this->db->join('semua_prestasi', 'poin_skp.id_prestasi = semua_prestasi.id_semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('dasar_penilaian', 'semua_prestasi.id_dasar_penilaian = dasar_penilaian.id_dasar_penilaian');
        $this->db->join('semua_tingkatan', 'semua_prestasi.id_semua_tingkatan = semua_tingkatan.id_semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');

        $detail_skp = $this->db->get()->result_array();
        header('Content-type: application/json');
        echo json_encode($detail_skp);
    }

    public function laporanSerapan()
    {
        $this->load->model('Model_keuangan', 'keuangan');
        $data['title'] = 'Laporan Serapan Kegiatan';
        $data['tahun'] = $this->keuangan->getTahun();
        if ($data['tahun']) {
            $tahun = $data['tahun'][0]['tahun'];
            $data['tahun_saat_ini'] = $tahun;
        } else {
            $tahun = date('Y');
            $data['tahun_saat_ini'] = $tahun;
            $data['tahun'][0]['tahun'] = $tahun;
        }
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();

        if ($this->input->post('tahun')) {
            $tahun = $this->input->post('tahun');
            $data['serapan_proposal'] = $this->keuangan->getLaporanSerapanProposal($tahun);
            $data['serapan_lpj'] = $this->keuangan->getLaporanSerapanLpj($tahun);
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
            $data['tahun_saat_ini'] = $this->input->post('tahun');
        } else {
            $data['serapan_proposal'] = $this->keuangan->getLaporanSerapanProposal($tahun);
            $data['serapan_lpj'] = $this->keuangan->getLaporanSerapanLpj($tahun);
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
        }
        $data['total'] = $this->_totalDana($data['laporan']);


        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("keuangan/laporan_serapan", $data);
        $this->load->view("template/footer");
    }

    private function _serapan($proposal, $lpj, $tahun)
    {

        $lembaga = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();

        if ($proposal == null) {
            foreach ($lembaga as $l) {
                $proposal[$l['id_lembaga']] = [
                    'bulan' => 0,
                    'dana' => 0,
                    'id_lembaga' => $l['id_lembaga'],
                    'nama_lembaga' => $l['nama_lembaga']
                ];
            }
        }
        if ($lpj == null) {
            foreach ($lembaga as $l) {
                $lpj[$l['id_lembaga']] = [
                    'bulan' => 0,
                    'dana' => 0,
                    'id_lembaga' => $l['id_lembaga'],
                    'nama_lembaga' => $l['nama_lembaga']
                ];
            }
        }
        // cek data proposal
        $data_lpj = [];
        foreach ($proposal as $p) {
            $data_lpj[$p['id_lembaga']] = [
                'bulan' => 0,
                'dana' => 0,
                'id_lembaga' => $p['id_lembaga'],
                'nama_lembaga' => $p['nama_lembaga']
            ];
        }


        foreach ($lpj as $l) {
            $data_lpj[$l['id_lembaga']] = [
                'bulan' => $l['bulan'],
                'dana' => $l['dana'],
                'id_lembaga' => $l['id_lembaga'],
                'nama_lembaga' => $l['nama_lembaga']
            ];
        }

        $lpj = $data_lpj;

        $data = [];
        foreach ($lembaga as $l) {
            for ($j = 1; $j < 13; $j++) {
                $data[$l['id_lembaga']][$j] = 0;
            }
            $data[$l['id_lembaga']]['nama_lembaga'] = $l['nama_lembaga'];
            $dana = $this->db->select('anggaran_kemahasiswaan')->get_where('rekapan_kegiatan_lembaga', ['id_lembaga' => $l['id_lembaga'], 'tahun_pengajuan' => $tahun])->row_array();

            if ($dana['anggaran_kemahasiswaan'] == null) {
                $data[$l['id_lembaga']]['dana_pagu'] = 0;
            } else {
                $data[$l['id_lembaga']]['dana_pagu'] = $dana['anggaran_kemahasiswaan'];
            }
            $data[$l['id_lembaga']]['dana_terserap'] = 0;
        }

        foreach ($proposal as $p) {
            foreach ($lpj as $l) {
                for ($i = 1; $i < 13; $i++) {
                    if ($p['id_lembaga'] == $l['id_lembaga'] && $p['bulan'] == $i) {
                        if ($l['bulan'] == $p['bulan']) {
                            $data[$p['id_lembaga']][$i] = $p['dana'] + $l['dana'];
                        } else {
                            $data[$p['id_lembaga']][$i] = $p['dana'];
                        }
                    }
                    if ($p['id_lembaga'] == $l['id_lembaga'] && $l['bulan'] == $i) {
                        if ($l['bulan'] == $p['bulan']) {
                            $data[$l['id_lembaga']][$i] = $p['dana'] + $l['dana'];
                        } else {
                            $data[$l['id_lembaga']][$i] = $l['dana'];
                        }
                    }
                }
            }
        }
        foreach ($lembaga as $l) {
            $data[$l['id_lembaga']]['id_lembaga'] = $l['id_lembaga'];
            for ($j = 1; $j < 13; $j++) {
                $data[$l['id_lembaga']]['dana_terserap'] += $data[$l['id_lembaga']][$j];
            }

            if ($data[$l['id_lembaga']]['dana_pagu'] == 0) {
                $data[$l['id_lembaga']]['terserap_persen'] = 0;
            } else {
                $data[$l['id_lembaga']]['terserap_persen'] = $data[$l['id_lembaga']]['dana_terserap'] / $data[$l['id_lembaga']]['dana_pagu'] * 100;
            }

            $data[$l['id_lembaga']]['dana_sisa'] = $data[$l['id_lembaga']]['dana_pagu'] - $data[$l['id_lembaga']]['dana_terserap'];


            if ($data[$l['id_lembaga']]['dana_pagu'] == 0) {
                $data[$l['id_lembaga']]['sisa_terserap'] = 0;
            } else {
                $data[$l['id_lembaga']]['sisa_terserap'] = $data[$l['id_lembaga']]['dana_sisa'] / $data[$l['id_lembaga']]['dana_pagu'] * 100;
            }
        }
        return $data;
    }
    private function _totalDana($laporan)
    {

        $lembaga = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();
        $data['total']['dana_sisa'] = 0;
        $data['total']['dana_terserap'] = 0;
        $data['total']['dana_pagu'] = 0;
        $data['total']['persen_terserap'] = 0;
        $data['total']['persen_sisa'] = 0;
        foreach ($lembaga as $l) {
            $data['total']['dana_sisa'] += $laporan[$l['id_lembaga']]['dana_sisa'];
            $data['total']['dana_terserap'] += $laporan[$l['id_lembaga']]['dana_terserap'];
            $data['total']['dana_pagu'] += $laporan[$l['id_lembaga']]['dana_pagu'];
        }
        if ($data['total']['dana_pagu'] == 0) {
            $data['total']['persen_terserap'] = 0;
            $data['total']['persen_sisa'] = 0;
        } else {
            $data['total']['persen_terserap'] = $data['total']['dana_terserap'] / $data['total']['dana_pagu'] * 100;
            $data['total']['persen_sisa'] = $data['total']['dana_sisa'] / $data['total']['dana_pagu'] * 100;
        }

        return $data;
    }
    public function rekapitulasiSKP()
    {
        $data['title'] = 'Rekapitulasi SKP';
        $data['notif'] = $this->_notifKmhs();
        $data['prestasi'] = $this->db->get('prestasi')->result_array();

        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->model('Model_poinskp', 'poinskp');

        // mengambil data tingkatan
        $data['tahun_filter'] = $this->kemahasiswaan->getTahunRancangan();
        $tahun = "";
        if ($this->input->get('tahun')) {
            $tahun = $this->input->get('tahun');
        }

        $data['tahun'] = $tahun;
        $data['tingkatan'] = $this->poinskp->getDataTingkatan($tahun);

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['prestasi'] = [];
        $prestasi = $this->db->get('prestasi')->result_array();
        for ($i = 0; $i < count($prestasi); $i++) {
            $data['prestasi'][$i] = [
                'id_prestasi' => $prestasi[$i]['id_prestasi'],
                'nama_prestasi' => $prestasi[$i]['nama_prestasi'],
                'jumlah' => 0
            ];
        }
        if ($start_date != "" && $end_date != "") {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        } else {
            $data['start_date'] = "";
            $data['end_date'] = "";
        }

        $gPrestasi = $this->poinskp->getSemuaPrestasByRange($start_date, $end_date);

        foreach ($gPrestasi as $p) {
            for ($i = 0; $i < count($data['prestasi']); $i++) {
                if ($data['prestasi'][$i]['id_prestasi'] == $p['id_prestasi']) {
                    $data['prestasi'][$i] = [
                        'id_prestasi' => $p['id_prestasi'],
                        'nama_prestasi' => $p['nama_prestasi'],
                        'jumlah' => $p['jumlah']

                    ];
                }
            }
        }


        $this->template($data);
        $this->load->view("pimpinan/rekapitulasi_skp", $data);
        $this->load->view("template/footer");
    }
    public function rekapitulasiSKPApi()
    {

        $this->load->model('Model_poinskp', 'poinskp');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $this->db->select('*');
        $this->db->from('prestasi');
        $this->db->where('id_prestasi', 7);
        $this->db->or_where('id_prestasi', 8);
        $this->db->or_where('id_prestasi', 9);
        $prestasi = $this->db->get()->result_array();
        for ($i = 0; $i < count($prestasi); $i++) {
            $data['prestasi'][$i] = [
                'id_prestasi' => $prestasi[$i]['id_prestasi'],
                'nama_prestasi' => $prestasi[$i]['nama_prestasi'],
                'jumlah' => 0
            ];
        }
        if ($start_date != "" && $end_date != "") {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        } else {
            $data['start_date'] = "";
            $data['end_date'] = "";
        }

        $gPrestasi = $this->poinskp->getSemuaPrestasByRange($start_date, $end_date);

        foreach ($gPrestasi as $p) {
            for ($i = 0; $i < count($data['prestasi']); $i++) {
                if ($data['prestasi'][$i]['id_prestasi'] == $p['id_prestasi']) {
                    $data['prestasi'][$i] = [
                        'id_prestasi' => $p['id_prestasi'],
                        'nama_prestasi' => $p['nama_prestasi'],
                        'jumlah' => intval($p['jumlah'])

                    ];
                }
            }
        }

        header('Content-type: application/json');
        echo json_encode($data['prestasi']);
    }

    public function getRekapitulasiSKP()
    {
        $id_prestasi = $this->input->get('id_prestasi');
        $start_date = "";
        $end_date = "";
        if ($this->input->get('start_date') != "" && $this->input->get("end_date") != "") {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
        }

        $semua_prestasi = $this->db->get_where('semua_prestasi', ['id_prestasi' => intval($id_prestasi)])->result_array();
        $data['prestasi'] = $this->db->get_where('prestasi', ['id_prestasi' => intval($id_prestasi)])->row_array();
        $id_semua_prestasi_arr = [];
        for ($j = 0; $j < count($semua_prestasi); $j++) {
            $id_semua_prestasi = intval($semua_prestasi[$j]['id_semua_prestasi']);
            array_push($id_semua_prestasi_arr, $id_semua_prestasi);
        }

        $this->db->select('poin_skp.id_poin_skp, YEAR(poin_skp.tgl_pelaksanaan) as tahun, mahasiswa.nim, mahasiswa.nama, poin_skp.nama_kegiatan,prodi.nama_prodi,jurusan.nama_jurusan');
        $this->db->from('poin_skp');
        $this->db->join('mahasiswa', 'poin_skp.nim = mahasiswa.nim', 'left');
        $this->db->join('prodi', 'mahasiswa.kode_prodi = prodi.kode_prodi', 'left');
        $this->db->join('jurusan', 'prodi.kode_jurusan = jurusan.kode_jurusan', 'left');
        $this->db->where_in('prestasiid_prestasi', $id_semua_prestasi_arr);
        $this->db->where('poin_skp.validasi_prestasi', 1);
        if ($start_date != "" && $end_date != "") {
            $this->db->where('poin_skp.tgl_pelaksanaan >=', $start_date);
            $this->db->where('poin_skp.tgl_pelaksanaan <=', $end_date);
        }
        $mahasiswa = $this->db->get()->result_array();

        $data['mahasiswa'] = $mahasiswa;
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getRekapTingkatanSKP()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $tahun = $this->input->get_post('tahun');
        $id_tingkat = $this->input->get_post('id');
        $data = $this->poinskp->rekapTingkatan($id_tingkat, $tahun);
        echo json_encode($data);
    }
    public function daftarFileDownload()
    {
        $data['title'] = 'File Download';
        $data['file_download'] = $this->db->get('file_download')->result_array();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_file_download");
        $this->load->view("template/footer");
    }
}
