<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_rancangan extends CI_Model
{
    private $id_rancangan;
    private $tahun_rancangan;
    public function insertRancanganKegiatan($data)
    {
        $this->dataRacangan = $data;
        $this->db->insert('daftar_rancangan_kegiatan', $this->dataRacangan);
    }
    public function getDatarancangan()
    {
        $this->db->select('*');
        $this->db->from('daftar_rancangan_kegiatan');
        return $this->db->get()->result_array();
    }
    public function getRancanganByTahun($tahun)
    {
        $this->tahun_rancangan = $tahun;
        $this->db->select('*');
        $this->db->from('daftar_rancangan_kegiatan');
        $this->db->where('tahun', $this->tahun_rancangan);
        return $this->db->get()->result_array();
    }
}
