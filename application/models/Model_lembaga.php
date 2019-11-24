<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_lembaga extends CI_Model
{

    private $dataRacangan = [];
    public function getDataLembaga($id_lembaga)
    {
        $this->db->select('*');
        $this->db->from('lembaga');
        $this->db->where('id_lembaga', $id_lembaga);
        return $this->db->get()->row_array();
    }

    public function insertRancanganKegiatan($data)
    {
        $this->dataRacangan = $data;
        $this->db->insert('daftar_rancangan_kegiatan', $this->dataRacangan);
    }

    public function getRancanganKegiatan($id_lembaga = null, $tahun_rancangan = null)
    {
        $this->db->select('*');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('lembaga as l', 'drk.id_lembaga=l.id_lembaga', 'left');
        if ($id_lembaga != null) {
            $this->db->where('drk.id_lembaga', $id_lembaga);
        }
        if ($tahun_rancangan != null) {
            $this->db->where('drk.tahun_kegiatan', $tahun_rancangan);
        }
        return $this->db->get()->result_array();
    }
}
