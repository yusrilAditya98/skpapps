<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_poinskp extends CI_Model
{
    private $jenisKegiatan;
    private $semuaTingkat;
    public function getTingkatSkp($idJenisKegiatan)
    {
        $this->jenisKegiatan = $idJenisKegiatan;
        $this->db->select('st.*,t.nama_tingkatan');
        $this->db->from('semua_tingkatan as st');
        $this->db->join('jenis_kegiatan as jk', 'st.id_jenis_kegiatan=jk.id_jenis_kegiatan', 'left');
        $this->db->join('tingkatan as t', 't.id_tingkatan=st.id_tingkatan', 'left');
        $this->db->where('st.id_jenis_kegiatan', $this->jenisKegiatan);
        return $this->db->get()->result_array();
    }

    public function getSemuaTingkatan()
    {
        $this->db->select('id_semua_tingkatan, nama_tingkatan, jenis_kegiatan, nama_bidang');
        $this->db->from('semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['semua_tingkatan'] = $this->db->get()->result_array();
        return $data['semua_tingkatan'];
    }
    public function getSemuaTingkatanJenis($id)
    {
        $this->db->where('semua_tingkatan.id_jenis_kegiatan', $id);
        $this->db->select('*');
        $this->db->from('semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $data['semua_tingkatan'] = $this->db->get()->result_array();
        return $data['semua_tingkatan'];
    }

    public function getSemuaPrestasi()
    {
        $this->db->select('id_semua_prestasi, nama_prestasi, bobot, nama_tingkatan, jenis_kegiatan, nama_bidang, nama_dasar_penilaian');
        $this->db->from('semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('dasar_penilaian', 'semua_prestasi.id_dasar_penilaian = dasar_penilaian.id_dasar_penilaian');
        $this->db->join('semua_tingkatan', 'semua_prestasi.id_semua_tingkatan = semua_tingkatan.id_semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['semua_tingkatan'] = $this->db->get()->result_array();
        return $data['semua_tingkatan'];
    }

    public function getPrestasi($idSemuaTingkat)
    {
        $this->semuaTingkat = $idSemuaTingkat;
        $this->db->select('sp.*,p.nama_prestasi');
        $this->db->from('semua_prestasi as sp');
        $this->db->join('prestasi as p', 'p.id_prestasi = sp.id_prestasi', 'left');
        $this->db->where('sp.id_semua_tingkatan', $this->semuaTingkat);
        return $this->db->get()->result_array();
    }

    public function insertPoinSkp($data)
    {
        $this->db->set($data);
        $this->db->insert('poin_skp');
    }

    public function getPoinSkp($username = null, $id_poin_skp = null)
    {
        $this->db->select('sp.bobot,ps.*,t.*,p.*,jk.*,bk.*,st.id_semua_tingkatan,m.nama');
        $this->db->from('poin_skp as ps');
        $this->db->join('semua_prestasi as sp', 'ps.id_prestasi=sp.id_semua_prestasi', 'left');
        $this->db->join('semua_tingkatan as st', 'st.id_semua_tingkatan=sp.id_semua_tingkatan', 'left');
        $this->db->join('jenis_kegiatan as jk', 'st.id_jenis_kegiatan=jk.id_jenis_kegiatan', 'left');
        $this->db->join('bidang_kegiatan as bk', 'bk.id_bidang=jk.id_bidang', 'left');
        $this->db->join('tingkatan as t', 't.id_tingkatan=st.id_tingkatan', 'left');
        $this->db->join('prestasi as p', 'p.id_prestasi=sp.id_prestasi', 'left');
        $this->db->join('mahasiswa as m', 'm.nim = ps.nim', 'left');
        if ($username != null) {
            $this->db->where('ps.nim', $username);
        }
        if ($id_poin_skp != null) {
            $this->db->where('ps.id_poin_skp', $id_poin_skp);
        }
        $this->db->order_by('ps.validasi_prestasi', 'ASC');
        return $this->db->get()->result_array();
    }

    public function deletePoinSkp($id_poinskp)
    {
        $this->db->where('id_poin_skp', $id_poinskp);
        $this->db->delete('poin_skp');
    }

    public function updatePoinSkp($id_poinskp, $data)
    {
        $this->db->where('id_poin_skp', $id_poinskp);
        $this->db->update('poin_skp', $data);
    }

    public function updateTotalPoinSkp($nim)
    {
        $this->db->select_sum("sp.bobot");
        $this->db->from("poin_skp as ps");
        $this->db->join('semua_prestasi as sp', 'sp.id_semua_prestasi = ps.id_prestasi', 'left');
        $this->db->where('ps.nim', $nim);
        $this->db->where('ps.validasi_prestasi', 1);
        return $this->db->get()->row_array();
    }
}
