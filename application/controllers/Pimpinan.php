<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pimpinan extends CI_Controller
{

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

    public function rekapitulasiSKP()
    {
        $data['title'] = 'Rekapitulasi SKP';
        // $this->db->where('id_prestasi', 7);
        // $this->db->or_where('id_prestasi', 8);
        // $this->db->or_where('id_prestasi', 9);
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        for ($i = 0; $i < count($data['prestasi']); $i++) {
            $id_prestasi = intval($data['prestasi'][$i]['id_prestasi']);
            $count = 0;
            $semua_prestasi = $this->db->get_where('semua_prestasi', ['id_prestasi' => $id_prestasi])->result_array();
            for ($j = 0; $j < count($semua_prestasi); $j++) {
                $id_semua_prestasi = intval($semua_prestasi[$j]['id_semua_prestasi']);
                $mahasiswa = $this->db->get_where('poin_skp', ['id_prestasi' => $id_semua_prestasi])->result_array();
                $count += count($mahasiswa);
            }
            $data['prestasi'][$i]['jumlah'] = $count;
        }

        $this->template($data);
        $this->load->view("pimpinan/rekapitulasi_skp", $data);
        $this->load->view("template/footer");
    }

    public function rekapitulasiSKPApi()
    {
        $this->db->where('id_prestasi', 7);
        $this->db->or_where('id_prestasi', 8);
        $this->db->or_where('id_prestasi', 9);
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        for ($i = 0; $i < count($data['prestasi']); $i++) {
            $id_prestasi = intval($data['prestasi'][$i]['id_prestasi']);
            $count = 0;
            $semua_prestasi = $this->db->get_where('semua_prestasi', ['id_prestasi' => $id_prestasi])->result_array();
            for ($j = 0; $j < count($semua_prestasi); $j++) {
                $id_semua_prestasi = intval($semua_prestasi[$j]['id_semua_prestasi']);
                $mahasiswa = $this->db->get_where('poin_skp', ['id_prestasi' => $id_semua_prestasi])->result_array();
                $count += count($mahasiswa);
            }
            $data['prestasi'][$i]['jumlah'] = $count;
        }
        header('Content-type: application/json');
        echo json_encode($data['prestasi']);
    }

    public function getRekapitulasiSKP($id_prestasi)
    {
        $semua_prestasi = $this->db->get_where('semua_prestasi', ['id_prestasi' => intval($id_prestasi)])->result_array();
        $data['prestasi'] = $this->db->get_where('prestasi', ['id_prestasi' => intval($id_prestasi)])->row_array();
        $id_semua_prestasi_arr = [];
        for ($j = 0; $j < count($semua_prestasi); $j++) {
            $id_semua_prestasi = intval($semua_prestasi[$j]['id_semua_prestasi']);
            array_push($id_semua_prestasi_arr, $id_semua_prestasi);
        }
        $this->db->where_in('id_prestasi', $id_semua_prestasi_arr);
        $this->db->from('poin_skp');
        $this->db->join('mahasiswa', 'poin_skp.nim = mahasiswa.nim');
        $this->db->join('prodi', 'mahasiswa.kode_prodi = prodi.kode_prodi');
        $data['mahasiswa'] = $this->db->get()->result_array();
        // array_push($data['prestasi'], $mahasiswa);

        header('Content-type: application/json');
        // echo json_encode($id_semua_prestasi_arr);
        echo json_encode($data);
        // die;
    }
}
