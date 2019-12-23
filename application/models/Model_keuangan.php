<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_keuangan extends CI_Model
{

    private $periode;


    public function getLaporanSerapanProposal($periode)
    {
        $this->db->select('MONTH(k.tgl_pengajuan_proposal) as bulan, SUM(k.dana_proposal) as dana, l.id_lembaga,l.nama_lembaga');
        $this->db->from('lembaga as l');
        $this->db->join('kegiatan as k', 'k.id_lembaga=l.id_lembaga', 'left');
        $this->db->where('l.id_lembaga !=', 0);
        $this->db->where('YEAR(k.tgl_pengajuan_proposal)', $periode);
        $this->db->group_by('MONTH(k.tgl_pengajuan_proposal), l.id_lembaga');
        return $this->db->get()->result_array();
    }
    public function getLaporanSerapanLpj($periode)
    {
        $this->db->select('MONTH(k.tgl_pengajuan_lpj) as bulan, SUM(k.dana_lpj) as dana, l.id_lembaga,l.nama_lembaga');
        $this->db->from('lembaga as l');
        $this->db->join('kegiatan as k', 'k.id_lembaga=l.id_lembaga', 'left');
        $this->db->where('l.id_lembaga !=', 0);
        $this->db->where('YEAR(k.tgl_pengajuan_lpj)', $periode);
        $this->db->group_by('MONTH(k.tgl_pengajuan_lpj),l.id_lembaga');
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
}
