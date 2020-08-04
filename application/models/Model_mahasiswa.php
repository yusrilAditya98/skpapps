<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_mahasiswa extends CI_Model
{
    private $nim;
    private $dataMahasiswa;

    public function getDataMahasiswa($nim = null)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa as m');
        $this->db->join('prodi as p', 'p.kode_prodi = m.kode_prodi', 'left');
        $this->db->join('jurusan as j', 'p.kode_jurusan = j.kode_jurusan', 'left');
        if ($nim != null) {
            $this->db->where('m.nim', $nim);
        }
        return $this->db->get()->result_array();
    }
    public function updateBeasiswa($data, $id)
    {
        $this->db->where('id_penerima', $id);
        $this->db->update('penerima_beasiswa', $data);
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
    public function getAnggotaKegiatan($id_kegiatan)
    {
        return $this->db->get_where('anggota_kegiatan', ['id_kegiatan' => $id_kegiatan])->result_array();
    }
    public function getBukanAnggotaKegiatan($id_kegiatan)
    {

        $this->db->select('ak.nim ');
        $this->db->from('anggota_kegiatan as ak');
        $this->db->where('ak.id_kegiatan', $id_kegiatan);
        $from_cluses = $this->db->get_compiled_select();

        $this->db->select('m.*,p.nama_prodi,j.nama_jurusan');
        $this->db->from('mahasiswa as m');
        $this->db->join('(' . $from_cluses . ') as bkn_ak', 'm.nim = bkn_ak.nim', 'left');
        $this->db->join('prodi as p', 'p.kode_prodi = m.kode_prodi', 'left');
        $this->db->join('jurusan as j', 'p.kode_jurusan = j.kode_jurusan', 'left');
        $this->db->where('bkn_ak.nim', null);
        return $this->db->get()->result_array();
    }
}
