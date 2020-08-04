<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_kegiatan extends CI_Model
{

    private $id_kegiatan;
    private $jenis_validasi;
    private $dataKegiatan;
    private $status;

    public function insertKegiatan($dataKegiatan)
    {
        $this->db->set($dataKegiatan);
        $this->db->insert('kegiatan');
    }
    public function getIdKegiatan($penanggung_jawab = null, $nama_kegiatan = null, $waktu_pengajaun = null)
    {
        $this->db->select('id_kegiatan');
        $this->db->from('kegiatan');
        if ($penanggung_jawab != null || $nama_kegiatan != null || $waktu_pengajaun != null) {
            $this->db->where('nama_kegiatan', $nama_kegiatan);
            $this->db->where('id_penanggung_jawab', $penanggung_jawab);
            $this->db->where('waktu_pengajuan', $waktu_pengajaun);
        }
        return $this->db->get()->row_array();
    }
    public function getDataKegiatan($penanggung_jawab = null, $status_proposal = null, $start_date = null, $end_date = null)
    {
        $this->db->select('k.*,l.nama_lembaga');
        $this->db->from('kegiatan as k');
        $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
        if ($penanggung_jawab != null) {
            $this->db->where('k.id_penanggung_jawab', $penanggung_jawab);
        }
        if ($status_proposal != null) {
            $this->db->where('k.status_selesai_proposal', $status_proposal);
        }
        if ($start_date != null && $end_date != null && $status_proposal == null) {
            $this->db->where('k.tgl_pengajuan_proposal >=', $start_date);
            $this->db->where('k.tgl_pengajuan_proposal <=', $end_date);
        } elseif ($start_date != null && $end_date != null && $status_proposal != null) {
            $this->db->where('k.tgl_pengajuan_lpj >=', $start_date);
            $this->db->where('k.tgl_pengajuan_lpj <=', $end_date);
        }
        $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
        return $this->db->get()->result_array();
    }
    public function getInfoKegiatan($id_kegiatan, $penanggung_jawab = null)
    {
        $this->db->select('k.*,l.nama_lembaga');
        $this->db->from('kegiatan as k');
        $this->db->join('lembaga as l', 'l.id_lembaga = k.id_lembaga', 'left');
        $this->db->where('k.id_kegiatan', $id_kegiatan);
        if ($penanggung_jawab != null) {
            $this->db->where('k.id_penanggung_jawab', $penanggung_jawab);
        }
        return $this->db->get()->row_array();
    }
    public function getInfoDana($id_kegiatan)
    {
        $this->db->select('ksd.*,sd.nama_sumber_dana');
        $this->db->from('kegiatan_sumber_dana as ksd');
        $this->db->join('sumber_dana as sd', 'sd.id_sumber_dana=ksd.id_sumber_dana');
        $this->db->where('ksd.id_kegiatan', $id_kegiatan);
        return $this->db->get()->result_array();
    }
    public function getInfoAnggota($id_kegiatan)
    {
        $this->db->select('ak.*,m.nama,p.*,sp.id_semua_prestasi,pro.nama_prodi,jur.nama_jurusan');
        $this->db->from('anggota_kegiatan as ak');
        $this->db->join('mahasiswa as m', 'm.nim=ak.nim', 'left');
        $this->db->join('semua_prestasi as sp', 'ak.id_prestasi=sp.id_semua_prestasi', 'left');
        $this->db->join('prestasi as p', 'sp.id_prestasi =p.id_prestasi', 'left');
        $this->db->join('prodi as pro', 'pro.kode_prodi = m.kode_prodi', 'left');
        $this->db->join('jurusan as jur', 'pro.kode_jurusan = jur.kode_jurusan', 'left');
        $this->db->where('ak.id_kegiatan', $id_kegiatan);
        return $this->db->get()->result_array();
    }
    public function getDokumentasi($id_kegiatan)
    {
        $this->db->select('*');
        $this->db->from('dokumentasi_kegiatan');
        $this->db->where('id_kegiatan', $id_kegiatan);
        return $this->db->get()->row_array();
    }
    public function getInfoTingkat($id_kegiatan)
    {
        $this->db->select('m.nama,ak.*,sp.*,p.*,bk.*,jk.*,t.*,pro.nama_prodi,jur.nama_jurusan');
        $this->db->from('anggota_kegiatan as ak');
        $this->db->join('mahasiswa as m', 'm.nim=ak.nim', 'left');
        $this->db->join('semua_prestasi as sp', 'ak.id_prestasi=sp.id_semua_prestasi', 'left');
        $this->db->join('prestasi as p', 'sp.id_prestasi =p.id_prestasi', 'left');
        $this->db->join('semua_tingkatan as st', 'st.id_semua_tingkatan = sp.id_semua_tingkatan', 'left');
        $this->db->join('jenis_kegiatan as jk', 'jk.id_jenis_kegiatan=st.id_jenis_kegiatan', 'left');
        $this->db->join('tingkatan as t ', 't.id_tingkatan=st.id_tingkatan', 'left');
        $this->db->join('bidang_kegiatan as bk', 'bk.id_bidang=jk.id_bidang', 'left');
        $this->db->join('prodi as pro', 'pro.kode_prodi = m.kode_prodi', 'left');
        $this->db->join('jurusan as jur', 'pro.kode_jurusan = jur.kode_jurusan', 'left');
        $this->db->where('ak.id_kegiatan', $id_kegiatan);
        return $this->db->get()->result_array();
    }
    public function getInfoValidasi($id)
    {
        $this->db->select('u.nama,vk.*');
        $this->db->from('validasi_kegiatan as vk');
        $this->db->join('user as u', 'vk.id_user=u.id_user');
        $this->db->where('vk.id', $id);
        return $this->db->get()->result_array();
    }
    // untuk mendapatkan dana lain - checkbox
    public function getSumberDanaLain($id_kegiatan)
    {
        $this->db->select('*');
        $this->db->from('kegiatan_sumber_dana as sd');
        $this->db->where('id_kegiatan', $id_kegiatan);
        $data_dana = $this->db->get_compiled_select();
        $this->db->select('sd.*');
        $this->db->from('sumber_dana as sd');
        $this->db->join('(' . $data_dana . ') as d', 'sd.id_sumber_dana=d.id_sumber_dana', 'left');
        $this->db->where('d.id_sumber_dana', null);
        return $this->db->get()->result_array();
    }
    public function getDataValidasi($id_kegiatan = null, $jenis_validasi = null, $jenis_pengajuan = null)
    {
        $this->db->select('vk.*');
        $this->db->from('validasi_kegiatan as vk');
        if ($id_kegiatan != null) {
            $this->db->where('id_kegiatan', $id_kegiatan);
        }
        if ($jenis_validasi != null) {
            $this->db->where('jenis_validasi', $jenis_validasi);
        }
        if ($jenis_pengajuan != null) {
            $this->db->where('kategori', $jenis_pengajuan);
        }
        return $this->db->get()->result_array();
    }
    public function updateValidasi($data, $jenis_validasi, $id_kegiatan, $kategori)
    {
        $this->db->where('jenis_validasi', $jenis_validasi);
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->where('kategori', $kategori);
        $this->db->update('validasi_kegiatan', $data);
    }
    public function updateStatusProposal($id_kegiatan, $status)
    {
        $this->db->set('status_selesai_proposal', $status);
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update('kegiatan');
    }
    public function updateStatusLpj($id_kegiatan, $status)
    {
        $this->db->set('status_selesai_lpj', $status);
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update('kegiatan');
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
    public function cekJenisProposal($jenis_validasi, $id_kegiatan)
    {
        $this->db->select('status_validasi');
        $this->db->from('validasi_kegiatan');
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->where('jenis_validasi', $jenis_validasi);
        return $this->db->get()->row_array();
    }
    public function updateKegiatan($data, $id_kegiatan)
    {
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update('kegiatan', $data);
    }
    public function updateAnggotaKegiatan($data)
    {
        $this->db->update_batch('anggota_kegiatan', $data, 'id_anggota_kegiatan');
    }
    public function updateValidasiKegiatan($data)
    {
        $this->db->update_batch('validasi_kegiatan', $data, 'id');
    }
    public function updateDokumentasiKegiatan($data, $id_kegiatan)
    {
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update('dokumentasi_kegiatan', $data);
    }
    public function updateDanaKegiatan($data)
    {
        $this->db->update_batch('kegiatan_sumber_dana', $data, 'id_kegiatan_sumber');
    }
    public function getDataFilterRancangan()
    {
        $this->db->select('tahun_pengajuan');
        $this->db->from('rekapan_kegiatan_lembaga');
        $this->db->group_by('tahun_pengajuan');
        $data['tahun'] = $this->db->get()->result_array();
        $this->db->select('status_rancangan');
        $this->db->from('rekapan_kegiatan_lembaga');
        $this->db->group_by('status_rancangan');
        $data['status'] = $this->db->get()->result_array();
        return $data;
    }

    public function getDaftarTahunKegiatan()
    {
        $this->db->select('periode');
        $this->db->from('kegiatan');
        $this->db->group_by('periode');
        return $this->db->get()->result_array();
    }

    public function getDaftarProposalKegiatan()
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where('status_selesai_proposal !=', 3);
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function getDaftarLpjKegiatan()
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where('status_selesai_proposal', 3);
        $this->db->where('status_selesai_lpj !=', 3);
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function getKegiatanAPI($tahun, $id_lembaga)
    {

        $this->db->select('kegiatan.*,lembaga.nama_lembaga');
        $this->db->from('kegiatan');
        $this->db->join('lembaga', 'lembaga.id_lembaga=kegiatan.id_lembaga', 'left');
        $this->db->where('YEAR(kegiatan.tgl_pengajuan_proposal)', $tahun);
        $this->db->where('kegiatan.id_lembaga', $id_lembaga);
        return $this->db->get()->result_array();
    }
}
