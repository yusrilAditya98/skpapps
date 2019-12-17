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
        is_logged_in();
    }

    public function template($data)
    {
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar", $data);
        $this->load->view("template/sidebar", $data);
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['jumlah_mahasiswa'] = count($this->db->get('mahasiswa')->result_array());
        $data['jumlah_lembaga'] = count($this->db->get('lembaga')->result_array());
        $data['jumlah_kegiatan_mahasiswa'] = count($this->db->get_where('kegiatan', ['acc_rancangan' => 1])->result_array());
        $this->db->where('total_poin_skp >=', 100);
        $data_mahasiswa_cukup_skp = $this->db->get('mahasiswa')->result_array();
        $data['jumlah_mahasiswa_cukup_skp'] = count($data_mahasiswa_cukup_skp);
        $this->template($data);
        $this->load->view("dashboard/dashboard_pimpinan", $data);
        $this->load->view("template/footer");
    }
    public function poin_skp()
    {
        $data['title'] = 'Poin SKP';
        $data['mahasiswa'] = $this->db->get('mahasiswa')->result_array();
        for ($i = 0; $i < count($data['mahasiswa']); $i++) {
            $total_poin_skp = $data['mahasiswa'][$i]['total_poin_skp'];
            if ($total_poin_skp > 300) {
                $data['mahasiswa'][$i]['predikat_poin_skp'] = "Dengan Pujian";
                $data['mahasiswa'][$i]['p_poin_skp'] = 4;
            } else if ($total_poin_skp >= 201 && $total_poin_skp <= 300) {
                $data['mahasiswa'][$i]['predikat_poin_skp'] = "Sangat Baik";
                $data['mahasiswa'][$i]['p_poin_skp'] = 3;
            } else if ($total_poin_skp >= 151 && $total_poin_skp <= 200) {
                $data['mahasiswa'][$i]['predikat_poin_skp'] = "Baik";
                $data['mahasiswa'][$i]['p_poin_skp'] = 2;
            } else if ($total_poin_skp >= 100 && $total_poin_skp <= 150) {
                $data['mahasiswa'][$i]['predikat_poin_skp'] = "Cukup";
                $data['mahasiswa'][$i]['p_poin_skp'] = 1;
            } else {
                $data['mahasiswa'][$i]['predikat_poin_skp'] = "Kurang";
                $data['mahasiswa'][$i]['p_poin_skp'] = 0;
            }
        }
        $this->template($data);
        $this->load->view("pimpinan/poin_skp", $data);
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
        $data['title'] = 'Dashboard';
        $data['notif'] = $this->_notif();
        $data['serapan_proposal'] = $this->keuangan->getLaporanSerapanProposal(2019);
        $data['serapan_lpj'] = $this->keuangan->getLaporanSerapanLpj(2019);
        $data['lembaga'] = $this->db->get('lembaga')->result_array();

        $data['tahun'] = $this->keuangan->getTahun();
        $tahun = $data['tahun'][0]['tahun'];
        if ($this->input->post('tahun')) {
            $tahun = $this->input->post('tahun');
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
        } else {
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
        }
        $data['total'] = $this->_totalDana($data['laporan']);
        //       var_dump($serapan);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("keuangan/laporan_serapan", $data);
        $this->load->view("template/footer");
    }

    private function _serapan($proposal, $lpj, $tahun)
    {

        $lembaga = $this->db->get('lembaga')->result_array();

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
                $data[$l['id_lembaga']]['dana_pagu']  = $dana['anggaran_kemahasiswaan'];
            }
            $data[$l['id_lembaga']]['dana_terserap'] = 0;
        }

        foreach ($proposal as $p) {
            foreach ($lpj as $l) {
                for ($i = 1; $i < 13; $i++) {
                    if ($p['id_lembaga'] == $l['id_lembaga'] && $p['bulan'] == $i) {
                        if ($l['bulan'] == $p['bulan']) {
                            $data[$p['id_lembaga']][$i] = $p['dana'] + $l['bulan'];
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
            for ($j = 1; $j < 13; $j++) {
                $data[$l['id_lembaga']]['dana_terserap'] += $data[$l['id_lembaga']][$j];
            }

            if ($data[$l['id_lembaga']]['dana_terserap'] == 0) {
                $data[$l['id_lembaga']]['terserap_persen'] =  '-';
            } else {
                $data[$l['id_lembaga']]['terserap_persen'] = $data[$l['id_lembaga']]['dana_terserap'] / $data[$l['id_lembaga']]['dana_pagu']  * 100;
            }

            $data[$l['id_lembaga']]['dana_sisa'] = $data[$l['id_lembaga']]['dana_pagu'] - $data[$l['id_lembaga']]['dana_terserap'];


            if ($data[$l['id_lembaga']]['dana_sisa'] == 0) {
                $data[$l['id_lembaga']]['sisa_terserap'] = '-';
            } else {
                $data[$l['id_lembaga']]['sisa_terserap'] = $data[$l['id_lembaga']]['dana_sisa'] / $data[$l['id_lembaga']]['dana_pagu']  * 100;
            }
        }
        return $data;
    }
    private function _totalDana($laporan)
    {

        $lembaga = $this->db->get('lembaga')->result_array();
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
        $data['total']['persen_terserap'] = $data['total']['dana_terserap'] / $data['total']['dana_pagu'] * 100;
        $data['total']['persen_sisa'] = $data['total']['dana_sisa'] / $data['total']['dana_pagu'] * 100;

        return $data;
    }
}
