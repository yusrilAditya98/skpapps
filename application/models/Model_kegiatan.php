<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_kegiatan extends CI_Model
{

    public function insertKegiatan($dataKegiatan)
    {
        $this->db->set($dataKegiatan);
        $this->db->insert('kegiatan');
    }

    public function getIdKegiatan($penanggung_jawab, $nama_kegiatan, $waktu_pengajaun)
    {
        $this->db->select('id_kegiatan');
        $this->db->from('kegiatan');
        $this->db->where('nama_kegiatan', $nama_kegiatan);
        $this->db->where('id_penanggung_jawab', $penanggung_jawab);
        $this->db->where('waktu_pengajuan', $waktu_pengajaun);
        return $this->db->get()->row_array();
    }

    public function getDataKegiatan($penanggung_jawab = null)
    {
        $this->db->select('k.*,l.nama_lembaga');
        $this->db->from('kegiatan as k');
        $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
        if ($penanggung_jawab != null) {
            $this->db->where('k.id_penanggung_jawab', $penanggung_jawab);
        }
        return $this->db->get()->result_array();
    }
    public function getDataValidasi()
    {
        $this->db->select('vk.*');
        $this->db->from('validasi_kegiatan as vk');
        return $this->db->get()->result_array();
    }

    public function insertDataValidasi($datavalidasi)
    {
        $this->db->insert_batch('validasi_kegiatan', $datavalidasi);
    }

    public function insertDanaKegiatan($dataDana)
    {
        $this->db->insert_batch('kegiatan_sumber_dana', $dataDana);
    }
    public function insertAnggotaKegiatan($dataAnggota)
    {
        $this->db->insert_batch('anggota_kegiatan', $dataAnggota);
    }

    public function insertDokumentasiKegiatan($dataDokumentasi)
    {
        $this->db->set($dataDokumentasi);
        $this->db->insert('dokumentasi_kegiatan');
    }

    public function hapusKegiatan($id_kegiatan)
    {
        $tables = array('validasi_kegiatan', 'dokumentasi_kegiatan', 'anggota_kegiatan', 'kegiatan_sumber_dana', 'kegiatan');
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->delete($tables);
    }
}
