<?php
defined('BASEPATH') or exit('No direct script access allowed');
class API_skp extends CI_Controller
{
    private $kondisi;
    private $tahun;
    private $id_lembaga;
    public function __construct()
    {
        parent::__construct();
    }

    public function gabungKegiatan($id_kegiatan = null)
    {
        if ($id_kegiatan != null) {
            $this->session->set_userdata('id_kegiatan', intval($id_kegiatan));
        } else {
            $id_kegiatan = $this->session->userdata('id_kegiatan');
        }

        if (!$this->session->userdata('username')) {
            redirect('auth');
        } else {
            $data_peserta_kuliah_tamu = [
                'nim' => $this->session->userdata('username'),
                'id_kuliah_tamu' => intval($id_kegiatan)
            ];
            $data = $this->db->get_where('peserta_kuliah_tamu', ['nim' => $data_peserta_kuliah_tamu['nim'], 'id_kuliah_tamu' => $data_peserta_kuliah_tamu['id_kuliah_tamu']])->result_array();
            $this->db->insert('peserta_kuliah_tamu', $data_peserta_kuliah_tamu);
            $this->session->unset_userdata('id_kegiatan');
            $this->session->set_flashdata('message', 'Pendaftaran kuliah tamu berhasil');
            redirect(base_url('Mahasiswa'));
        }
    }

    public function validasiKegiatan($id)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['validasi'] = $this->kegiatan->getInfoValidasi($id);
        echo json_encode($data['validasi']);
    }
    public function daftarMahasiswa()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        echo json_encode($data['mahasiswa']);
    }

    // Filter Kategori Detail Tingkatan
    public function getDataDetail()
    {
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        $data['tingkatan'] = $this->db->get('tingkatan')->result_array();
        $data['jenis_kegiatan'] = $this->db->get('jenis_kegiatan')->result_array();
        $data['bidang_kegiatan'] = $this->db->get('bidang_kegiatan')->result_array();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function bidangKegiatan()
    {
        $this->bidangKegiatan = $this->db->get('bidang_kegiatan')->result_array();
        echo json_encode($this->bidangKegiatan);
    }
    public function getBidangKegiatan($id)
    {
        $this->bidangKegiatan = $this->db->get_where('bidang_kegiatan', ['id_bidang' => $id])->row_array();
        echo json_encode($this->bidangKegiatan);
    }
    public function jenisKegiatan($id_bidang)
    {
        $this->jenisKegiatan = $this->db->get_where('jenis_kegiatan', ['id_bidang' => $id_bidang])->result_array();
        echo json_encode($this->jenisKegiatan);
    }
    public function getJenisKegiatan($id)
    {
        $this->db->where('id_jenis_kegiatan', $id);
        // $this->db->select('id_jenis_kegiatan, jenis_kegiatan, nama_bidang');
        $this->db->from('jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['jenisKegiatan'] = $this->db->get()->row_array();
        $data['semua_bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        header('Content-type: application/json');
        echo json_encode($data);
    }
    public function tingkatKegiatan($id_jenis)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->tingkatKegiatan = $this->poinskp->getTingkatSkp($id_jenis);
        echo json_encode($this->tingkatKegiatan);
    }
    public function getTingkatan($id)
    {
        $data = $this->db->get_where('tingkatan', ['id_tingkatan' => $id])->row_array();
        echo json_encode($data);
    }
    public function getDetailTingkatan($id)
    {
        $this->db->select('id_semua_tingkatan, id_tingkatan, jenis_kegiatan.id_jenis_kegiatan, bidang_kegiatan.id_bidang');
        $this->db->where('semua_tingkatan.id_semua_tingkatan', $id);
        $this->db->from('semua_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['real'] = $this->db->get()->row_array();
        $data['list_bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $data['list_jenis'] = $this->db->get_where('jenis_kegiatan', ['id_bidang' => $data['real']['id_bidang']])->result_array();
        $data['list_tingkatan'] = $this->db->get('tingkatan')->result_array();

        echo json_encode($data);
    }
    public function getDetailPrestasi($id)
    {

        $this->db->where('id_semua_prestasi', intval($id));
        $this->db->from('semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('dasar_penilaian', 'semua_prestasi.id_dasar_penilaian = dasar_penilaian.id_dasar_penilaian');
        $this->db->join('semua_tingkatan', 'semua_prestasi.id_semua_tingkatan = semua_tingkatan.id_semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');

        $data['real'] = $this->db->get()->row_array();
        $data['list_bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $data['list_jenis'] = $this->db->get_where('jenis_kegiatan', ['id_bidang' => $data['real']['id_bidang']])->result_array();
        $this->load->model('Model_poinskp', 'poinskp');
        $this->semuaTingkatanKegiatan = $this->poinskp->getSemuaTingkatanJenis($data['real']['id_jenis_kegiatan']);
        $data['list_tingkatan'] = $this->semuaTingkatanKegiatan;
        $data['list_prestasi'] = $this->db->get('prestasi')->result_array();
        $data['list_dasar'] = $this->db->get('dasar_penilaian')->result_array();
        header('Content-type: application/json');
        echo json_encode($data);
    }
    public function getTingkat()
    {
        $data = $this->db->get('tingkatan')->result_array();
        echo json_encode($data);
    }
    public function getPres()
    {
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        $data['dasar_penilaian'] = $this->db->get('dasar_penilaian')->result_array();
        echo json_encode($data);
    }
    public function getSemuaTingkatanKegiatan()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->semuaTingkatanKegiatan = $this->poinskp->getSemuaTingkatan();
        header('Content-type: application/json');
        echo json_encode($this->semuaTingkatanKegiatan);
    }
    public function getSemuaTingkatanJenis($id)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->semuaTingkatanKegiatan = $this->poinskp->getSemuaTingkatanJenis($id);
        header('Content-type: application/json');
        echo json_encode($this->semuaTingkatanKegiatan);
    }
    public function getSemuaPrestasiKegiatan()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->semuaPrestasiKegiatan = $this->poinskp->getSemuaPrestasi();
        header('Content-type: application/json');
        echo json_encode($this->semuaPrestasiKegiatan);
    }
    public function getPrestasi($id)
    {
        $data = $this->db->get_where('prestasi', ['id_prestasi' => $id])->row_array();
        echo json_encode($data);
    }
    public function getDasarPenilaian($id)
    {
        $data = $this->db->get_where('dasar_penilaian', ['id_dasar_penilaian' => $id])->row_array();
        echo json_encode($data);
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
    public function getTingkatAnggota($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data = $this->kegiatan->getInfoTingkat($id_kegiatan);
        echo json_encode($data);
    }
    public function infoKegiatan($id_kegiatan)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['kegiatan'] = $this->kegiatan->getInfoKegiatan($id_kegiatan);
        $data['dana'] = $this->kegiatan->getInfoDana($id_kegiatan);
        $data['anggota'] = $this->kegiatan->getInfoAnggota($id_kegiatan);
        $data['tingkat'] = $this->kegiatan->getInfoTingkat($id_kegiatan);
        $data['dokumentasi'] = $this->kegiatan->getDokumentasi($id_kegiatan);
        echo json_encode($data);
    }
    public function dataLembaga()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga('lembaga');
        echo json_encode($data['lembaga']);
    }
    public function dataAnggaran($id_lembaga)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['anggaran'] = $this->kemahasiswaan->getDanaAnggaran($this->input->get('tahun'), $id_lembaga);
        echo json_encode($data['anggaran']);
    }
    public function dataJumlahKegiatan($id_lembaga)
    {
        if ($this->session->userdata('user_profil_kode') != 4) {
            redirect('Auth/blocked');
        }
        $this->load->model("Model_kemahasiswaan", 'kemahasiswaan');
        $this->kondisi = $this->input->get('kondisi');
        $this->tahun = $this->input->get('tahun');
        $this->id_lembaga = $id_lembaga;
        $data = $this->kemahasiswaan->getDetailAnggaranLembaga($this->id_lembaga, $this->tahun, $this->kondisi);
        echo json_encode($data);
    }
    public function beasiswa($id_beasiswa)
    {
        $data = $this->db->get_where('beasiswa', ['id' => $id_beasiswa])->row_array();
        echo json_encode($data);
    }
}
