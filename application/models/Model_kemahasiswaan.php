<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_kemahasiswaan extends CI_Model
{

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

    public function getInfoLembaga()
    {
        $this->db->select('*');
        $this->db->from('lembaga');
        $this->db->where_not_in('id_lembaga', 0);
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

        $this->db->select('l.nama_lembaga,l.status_rencana_kegiatan,rkl.*,jk.jumlah_kegiatan');
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

    public function updateStatusProker($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data);
    }

    public function updateRekapKegiatan($id_lembaga, $tahun, $status = null, $anggaran = null)
    {
        if ($anggaran != null) {
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
        $this->db->select('count(k1.id_lembaga) as terlaksana,k1.id_lembaga as lbg1,k1.acc_rancangan');
        $this->db->from('kegiatan as k1');
        $this->db->where('k1.status_selesai_lpj', 3);
        $this->db->where('k1.periode', $periode);
        $this->db->group_by('k1.id_lembaga');
        $from_clause1 = $this->db->get_compiled_select();

        // // jumlah kegiatan belum terlaksana terlaksana
        $this->db->select('count(k2.id_lembaga) as blm_terlaksana,k2.id_lembaga as lbg2');
        $this->db->from('kegiatan as k2');
        $this->db->where_not_in('k2.status_selesai_lpj', 3);
        $this->db->where('k2.periode', $periode);
        $this->db->group_by('k2.id_lembaga');
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
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('(' . $from_clause1 . ') as t', 't.lbg1 =drk.id_lembaga', 'left');
        $this->db->join('(' . $from_clause2 . ') as bt', 'bt.lbg2 =drk.id_lembaga', 'left');
        $this->db->join('(' . $from_clause3 . ') as jk', 'jk.lbg3 =drk.id_lembaga', 'left');
        $this->db->join('(' . $from_clause4 . ') as da', 'da.lbg4 =drk.id_lembaga', 'left');
        $this->db->join('lembaga as l', 'l.id_lembaga =drk.id_lembaga', 'left');
        $this->db->join('rekapan_kegiatan_lembaga as rkl', 'rkl.id_lembaga =drk.id_lembaga', 'left');
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
}
