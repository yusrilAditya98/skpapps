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

    public function insertBeasiswa($data)
    {
        $this->db->insert('penerima_beasiswa', $data);
    }
    public function getBeasiswa($nim)
    {
        $this->db->select('b.*,p.*');
        $this->db->from('penerima_beasiswa as p');
        $this->db->join('beasiswa as b', 'b.id=p.id_beasiswa', 'left');
        $this->db->where('p.nim', $nim);
        $this->db->order_by('validasi_beasiswa ASC');
        return $this->db->get()->result_array();
    }
}
