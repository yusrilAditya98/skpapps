<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_mahasiswa extends CI_Model
{
    public function getDataMahasiswa($nim = null)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa as m');
        if ($nim != null) {
            $this->db->where('m.nim', $nim);
        }
        return $this->db->get()->result_array();
    }
}
