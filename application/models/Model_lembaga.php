<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_lembaga extends CI_Model
{
    private $dataRacangan = [];
    public function getTahunRancangan()
    {
        $this->db->select('tahun_kegiatan');
        $this->db->from('daftar_rancangan_kegiatan');
        $this->db->group_by('tahun_kegiatan');
        return $this->db->get()->result_array();
    }
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
    public function updateRancanganKegiatan($data, $id_rancangan)
    {
        $this->db->where('id_daftar_rancangan', $id_rancangan);
        $this->db->update('daftar_rancangan_kegiatan', $data);
    }
    public function updateStatusRancangan($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data, 'id_daftar_rancangan');
    }
    public function updateStatusRencanaKegiatan($id_lembaga, $status)
    {
        $this->db->set('status_rencana_kegiatan', $status);
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->update('lembaga');
    }
    public function updateAnggaranLembaga($anggaran, $id_lembaga, $tahun)
    {
        $this->db->set('anggaran_lembaga', $anggaran);
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('tahun_pengajuan', $tahun);
        $this->db->update('rekapan_kegiatan_lembaga');
    }
    public function insertRekapanKegiatan($data)
    {
        $this->db->insert('rekapan_kegiatan_lembaga', $data);
    }
    public function deleteRancanganKegiatan($id_rancangan)
    {
        $this->db->where('id_daftar_rancangan', $id_rancangan);
        $this->db->delete('daftar_rancangan_kegiatan');
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
    public function getDataRancangan($id_rancangan)
    {
        $this->db->select('drk.*');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.id_daftar_rancangan', $id_rancangan);
        return $this->db->get()->row_array();
    }
    public function getDanaPagu($id_lembaga = null, $tahun_rancangan = null)
    {
        $this->db->select('*');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        if ($id_lembaga != null) {
            $this->db->where('rkl.id_lembaga', $id_lembaga);
        }
        if ($tahun_rancangan != null) {
            $this->db->where('rkl.tahun_pengajuan', $tahun_rancangan);
        }
        return $this->db->get()->row_array();
    }
    public function updateStatusRancanganByPeriode($status_rancangan, $id_lembaga, $tahun)
    {
        $this->db->set('status_rancangan', $status_rancangan);
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('tahun_pengajuan', $tahun);
        $this->db->update('rekapan_kegiatan_lembaga');
    }

    public function getPengajuanProposalLembaga($id_lembaga)
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('status_selesai_proposal !=', 3);
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function getPengajuanLpjLembaga($id_lembaga)
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('status_selesai_proposal', 3);
        $this->db->where('status_selesai_lpj !=', 3);
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function getPeriodeLembaga($id_lembaga)
    {
        $this->db->select('tahun_rancangan, jenis_lembaga');
        $this->db->from('lembaga');
        $this->db->where('id_lembaga', $id_lembaga);
        $data = $this->db->get()->row_array();
        return $data;
    }

    //Rancangan Anggota
    public function insertRancanganAnggota($rancanganAnggota)
    {
        $this->db->set($rancanganAnggota);
        $this->db->insert('pengajuan_anggota_lembaga');
    }
    public function getIdRancanganAnggota($id_lembaga = null, $periode = null)
    {
        $this->db->select('*');
        $this->db->from('pengajuan_anggota_lembaga');
        if ($id_lembaga != null || $periode != null) {
            $this->db->where('periode', $periode);
            $this->db->where('id_lembaga', $id_lembaga);
        }
        return $this->db->get()->row_array();
    }
    public function insertAnggotaLembaga($dataAnggota)
    {
        $this->db->insert_batch('daftar_anggota_lembaga', $dataAnggota);
    }
    public function updateLembaga($data, $id_lembaga)
    {
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->update('lembaga', $data);
    }
}
