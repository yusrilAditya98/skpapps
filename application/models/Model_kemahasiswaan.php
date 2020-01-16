<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_kemahasiswaan extends CI_Model
{
    private $id_kegiatan;
    private $jenis_validasi;
    private $kategori;
    private $data;

    public function getTahunRancangan()
    {
        $this->db->select('tahun_kegiatan');
        $this->db->from('daftar_rancangan_kegiatan');
        $this->db->group_by('tahun_kegiatan');
        $this->db->order_by('tahun_kegiatan DESC');
        return $this->db->get()->result_array();
    }
    public function insertPoinSkp($data)
    {
        $this->db->insert_batch('poin_skp', $data);
    }
    public function getNotifValidasi($jenis_validasi, $kategori)
    {
        $this->db->select('*');
        $this->db->from('validasi_kegiatan');
        $this->db->where('jenis_validasi', $jenis_validasi);
        $this->db->where('status_validasi', 4);
        $this->db->where('kategori', $kategori);
        return $this->db->get()->result_array();
    }
    public function getNotifValidasiRancangan()
    {
        $this->db->select('*');
        $this->db->from('rekapan_kegiatan_lembaga');
        $this->db->where('status_rancangan', 3);
        return $this->db->get()->result_array();
    }
    public function getNotifValidasiSkp()
    {
        $this->db->select('*');
        $this->db->from('poin_skp');
        $this->db->where('validasi_prestasi', 0);
        return $this->db->get()->result_array();
    }
    public function getInfoLembaga($status = null)
    {
        $this->db->select('*');
        $this->db->from('lembaga');
        if ($status != null) {
            $this->db->where_not_in('id_lembaga', 0);
        }
        return $this->db->get()->result_array();
    }
    public function updateStatusRencanaKegiatan($data)
    {
        $this->db->update_batch('lembaga', $data, 'id_lembaga');
    }
    public function getRekapRancangan($tahun = null, $lembaga = null, $status = null)
    {
        // jumlah kegiatan
        $this->db->select('count(drk.id_daftar_rancangan) as jumlah_kegiatan,drk.id_lembaga as lbg3,drk.tahun_kegiatan');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->group_by('drk.id_lembaga,drk.tahun_kegiatan');
        $from_clause3 = $this->db->get_compiled_select();

        $this->db->select('l.nama_lembaga,l.status_rencana_kegiatan,rkl.*,jk.jumlah_kegiatan,l.tahun_rancangan');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('lembaga as l', 'l.id_lembaga=rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause3 . ') as jk', 'jk.lbg3 =rkl.id_lembaga and jk.tahun_kegiatan =rkl.tahun_pengajuan', 'left');
        if ($tahun != null) {
            $this->db->where('rkl.tahun_pengajuan', $tahun);
        }
        if ($lembaga != null) {
            $this->db->where('rkl.id_lembaga', $lembaga);
        }
        if ($status != null) {
            $this->db->where('rkl.status_rancangan', $status);
        }
        $this->db->order_by('rkl.status_rancangan ASC');
        return $this->db->get()->result_array();
    }
    public function detailRancangan($id_lembaga, $tahun)
    {
        $this->db->select('drk.*,l.nama_lembaga');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('lembaga as l', 'l.id_lembaga = drk.id_lembaga', 'left');
        $this->db->where('drk.id_lembaga', $id_lembaga);
        $this->db->where('drk.tahun_kegiatan', $tahun);
        return $this->db->get()->result_array();
    }
    // update rancangan
    public function updateStatusProker($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data);
    }
    public function updateRekapKegiatan($id_lembaga, $tahun, $status = null, $anggaran = null)
    {
        if ($status != null) {
            $this->db->set('status_rancangan', $status);
        }
        if ($anggaran != null) {
            $this->db->set('anggaran_kemahasiswaan', $anggaran);
        }
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('tahun_pengajuan', $tahun);
        $this->db->update('rekapan_kegiatan_lembaga');
    }
    public function updateDataStatusProker($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data, 'id_daftar_rancangan');
    }
    public function insertAnggaranRancangan($data)
    {
        $this->db->insert_batch('rekapan_kegiatan_lembaga', $data);
    }
    // menampilkan anggaran lembaga
    public function getDanaAnggaran($periode = null, $id_lembaga = null)
    {
        //jumlah kegiatan terlaksana
        $this->db->select('count(drk.id_daftar_rancangan) as terlaksana,drk.id_lembaga as lbg1,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.status_rancangan', 5);
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause1 = $this->db->get_compiled_select();

        // // jumlah kegiatan belum terlaksana terlaksana
        $this->db->select('count(drk.id_daftar_rancangan) as blm_terlaksana,drk.id_lembaga as lbg2,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.status_rancangan !=', 5);
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause2 = $this->db->get_compiled_select();
        // // // jumlah kegiatan
        $this->db->select('count(drk.id_daftar_rancangan) as jumlah_kegiatan,drk.id_lembaga as lbg3,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause3 = $this->db->get_compiled_select();
        // // daftar anggaran yang digunakan
        $this->db->select('sum(dana_kegiatan) as dana_kegiatan,k3.id_lembaga as lbg4');
        $this->db->from('kegiatan as k3');
        $this->db->where('k3.status_selesai_lpj', 3);
        $this->db->where('k3.periode', $periode);
        $this->db->group_by('k3.id_lembaga');
        $from_clause4 = $this->db->get_compiled_select();
        // menampilkan data
        $this->db->select('drk.id_lembaga,l.nama_lembaga,t.terlaksana, bt.blm_terlaksana,jk.jumlah_kegiatan,da.dana_kegiatan,rkl.anggaran_kemahasiswaan,drk.tahun_kegiatan,l.status_rencana_kegiatan');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('(' . $from_clause1 . ') as t', 't.lbg1 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause2 . ') as bt', 'bt.lbg2 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause3 . ') as jk', 'jk.lbg3 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause4 . ') as da', 'da.lbg4 =rkl.id_lembaga', 'left');
        $this->db->join('lembaga as l', 'l.id_lembaga =rkl.id_lembaga', 'left');
        $this->db->join('daftar_rancangan_kegiatan as drk', 'rkl.id_lembaga =drk.id_lembaga', 'left');
        $this->db->where('rkl.tahun_pengajuan', $periode);
        $this->db->where('drk.tahun_kegiatan', $periode);
        if ($id_lembaga != null) {
            $this->db->where('l.id_lembaga', $id_lembaga);
        }
        $this->db->group_by('drk.id_lembaga');
        return $this->db->get()->result_array();
    }
    public function getDataMahasiswa()
    {
        $this->db->select('m.*,p.nama_prodi,j.nama_jurusan');
        $this->db->from('mahasiswa as m');
        $this->db->join('prodi as p', 'm.kode_prodi=p.kode_prodi', 'left');
        $this->db->join('jurusan as j', 'j.kode_jurusan=p.kode_jurusan', 'left');
        return $this->db->get()->result_array();
    }
    public function getDetailAnggaranLembaga($id_lembaga, $periode, $kondisi)
    {
        // // jumlah kegiatan belum terlaksana terlaksana
        $this->db->select('drk.*,l.nama_lembaga');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('lembaga as l', 'l.id_lembaga=drk.id_lembaga', 'left');
        if ($kondisi == 'blmTerlaksana') {
            $this->db->where('drk.status_rancangan !=', 5);
        } elseif ($kondisi == 'terlaksana') {
            $this->db->where('drk.status_rancangan', 5);
        }
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->where('drk.id_lembaga', $id_lembaga);
        return $this->db->get()->result_array();
    }
    public function getBeasiswa($start_date = null, $end_date = null, $validasi = null)
    {

        $this->db->select('b.*,p.*,m.nama');
        $this->db->from('penerima_beasiswa as p');
        $this->db->join('beasiswa as b', 'b.id=p.id_beasiswa', 'left');
        $this->db->join('mahasiswa as m', 'm.nim=p.nim', 'left');
        if ($start_date != null && $end_date != null) {
            $this->db->where('p.tahun_menerima >=', $start_date);
            $this->db->where('p.lama_menerima <=', $end_date);
        }
        if ($validasi != null) {
            $this->db->where('p.validasi_beasiswa', $validasi);
        }

        $this->db->order_by('validasi_beasiswa ASC');
        return $this->db->get()->result_array();
    }
    public function updateStatusBeasiswa($id_penerima, $status)
    {
        $this->db->set('validasi_beasiswa', $status);
        $this->db->where('id_penerima', $id_penerima);
        $this->db->update('penerima_beasiswa');
    }

    public function getRekapanKegiatanLembaga($tahun)
    {
        $this->db->select('rkl.*,l.nama_lembaga');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('lembaga as l', 'l.id_lembaga = rkl.id_lembaga', 'left');
        $this->db->where('rkl.tahun_pengajuan', $tahun);
        return $this->db->get()->result_array();
    }
}
