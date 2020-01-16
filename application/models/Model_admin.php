<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_admin extends CI_Model
{
    private $id_user;
    private $status_aktif;
    public function getDataUser()
    {
        $this->db->where('username != ', $this->session->userdata('username'));
        $this->db->select('id_user, nama, username, jenis_user, is_active');
        $this->db->from('user');
        $this->db->join('user_profil', 'user.user_profil_kode = user_profil.user_profil_kode');
        return $this->db->get()->result_array();
    }

    public function updateDataUser($data, $username)
    {
        $this->db->set($data);
        $this->db->where('username', $username);
        $this->db->update('user');
    }
    public function updateDataPimpinan($data, $id)
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('list_pimpinan');
    }

    public function deleteDataUser($id)
    {
        $result = "";
        $this->id_user = $id;
        $this->db->where('id_user', intval($this->id_user));
        $this->db->delete('user');
        if ($this->db->error()) {
            $result = 0;
        } else {
            $result = 1;
        }
        return $result;
    }

    public function updateDataMahasiswa($data, $nim)
    {
        $this->db->set($data);
        $this->db->where('nim', $nim);
        $this->db->update('mahasiswa');
    }

    public function updateDataLembaga($data, $id_lembaga)
    {
        $this->db->set($data);
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->update('lembaga');
    }
}
