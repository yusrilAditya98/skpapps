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
}
