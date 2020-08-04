<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_keuangan extends CI_Model
{

    private $periode;

    public function getLaporanSerapanProposal($periode)
    {
        $this->db->select('MONTH(vk.tanggal_validasi) as bulan, SUM(k.dana_proposal) as dana, l.id_lembaga,l.nama_lembaga');
        $this->db->from('lembaga as l');
        $this->db->join('kegiatan as k', 'k.id_lembaga=l.id_lembaga', 'left');
        $this->db->join('validasi_kegiatan as vk', 'k.id_kegiatan=vk.id_kegiatan', 'left');
        $this->db->where('vk.jenis_validasi', 6);
        $this->db->where('vk.kategori', 'proposal');
        $this->db->where('k.status_selesai_proposal', 3);
        $this->db->where('l.id_lembaga !=', 0);
        $this->db->where('YEAR(vk.tanggal_validasi)', $periode);
        $this->db->group_by('MONTH(vk.tanggal_validasi), l.id_lembaga');
        return $this->db->get()->result_array();
    }
    public function getLaporanSerapanLpj($periode)
    {
        $this->db->select('MONTH(vk.tanggal_validasi) as bulan, SUM(k.dana_lpj) as dana, l.id_lembaga,l.nama_lembaga');
        $this->db->from('lembaga as l');
        $this->db->join('kegiatan as k', 'k.id_lembaga=l.id_lembaga', 'left');
        $this->db->join('validasi_kegiatan as vk', 'k.id_kegiatan=vk.id_kegiatan', 'left');
        $this->db->where('vk.jenis_validasi', 6);
        $this->db->where('vk.kategori', 'lpj');
        $this->db->where('k.status_selesai_lpj', 3);
        $this->db->where('YEAR(vk.tanggal_validasi)', $periode);
        $this->db->where('l.id_lembaga !=', 0);
        $this->db->group_by('MONTH(vk.tanggal_validasi),l.id_lembaga');
        return $this->db->get()->result_array();
    }

    public function getTahun()
    {
        $this->db->select('YEAR(k.tanggal_kegiatan) as tahun');
        $this->db->from('kegiatan as k');
        $this->db->group_by('YEAR(k.tanggal_kegiatan)');
        $this->db->order_by('YEAR(k.tanggal_kegiatan) DESC');
        return $this->db->get()->result_array();
    }


    public function getAnggaranLembagaProposal($id_lembaga)
    {
        $this->db->select('MONTH(vk.tanggal_validasi) as bulan_pengajuan,k.id_kegiatan,k.dana_proposal as dana');
        $this->db->from('kegiatan as k');
        $this->db->join('validasi_kegiatan as vk', 'k.id_kegiatan=vk.id_kegiatan', 'left');
        $this->db->where('vk.jenis_validasi', 6);
        $this->db->where('vk.status_validasi', 1);
        $this->db->where('vk.kategori', 'proposal');
        $this->db->where('k.status_selesai_proposal', 3);

        $this->db->where('id_lembaga', $id_lembaga);

        return $this->db->get()->result_array();
    }
    public function getAnggaranLembagaLpj($id_lembaga)
    {
        $this->db->select('MONTH(vk.tanggal_validasi) as bulan_pengajuan,k.id_kegiatan,k.dana_lpj as dana');
        $this->db->from('kegiatan as k');
        $this->db->join('validasi_kegiatan as vk', 'k.id_kegiatan=vk.id_kegiatan', 'left');
        $this->db->where('vk.jenis_validasi', 6);
        $this->db->where('vk.kategori', 'lpj');
        $this->db->where('k.status_selesai_lpj', 3);
        $this->db->where('id_lembaga', $id_lembaga);
        return $this->db->get()->result_array();
    }
}
