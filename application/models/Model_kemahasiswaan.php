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
        $this->db->select('l.nama_lembaga,l.status_rencana_kegiatan,rkl.*');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('lembaga as l', 'l.id_lembaga=rkl.id_lembaga', 'left');
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
    public function updateRekapKegiatan($id_lembaga, $tahun, $status)
    {
        $this->db->set('status_rancangan', $status);
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
}
