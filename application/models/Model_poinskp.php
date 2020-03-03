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

    public function getPoinSkp($username = null, $id_poin_skp = null, $start_date = null, $end_date = null, $validasi = null)
    {
        $this->db->select('sp.bobot,ps.*,t.*,p.*,jk.*,bk.*,st.id_semua_tingkatan,m.nama');
        $this->db->from('poin_skp as ps');
        $this->db->join('semua_prestasi as sp', 'ps.prestasiid_prestasi=sp.id_semua_prestasi', 'left');
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

        if ($start_date != null && $end_date != null) {
            $this->db->where('ps.tgl_pengajuan >=', $start_date);
            $this->db->where('ps.tgl_pengajuan <=', $end_date);
        }

        if ($validasi != null) {
            $this->db->where('ps.validasi_prestasi', $validasi);
        }
        $this->db->order_by('FIELD(ps.validasi_prestasi,0,2,1)');
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
        $this->db->join('semua_prestasi as sp', 'sp.id_semua_prestasi = ps.prestasiid_prestasi', 'left');
        $this->db->where('ps.nim', $nim);
        $this->db->where('ps.validasi_prestasi', 1);
        return $this->db->get()->row_array();
    }
    public function getJumlahKategoriSkp()
    {
        $this->db->select('count(m.nim) as jumlah');
        $this->db->from('mahasiswa as m');
        $this->db->where('m.total_poin_skp >', 300);
        $data['dengan_pujian'] = $this->db->get()->result_array();

        $this->db->select('count(m.nim) as jumlah');
        $this->db->from('mahasiswa as m');
        $this->db->where('m.total_poin_skp <=', 300);
        $this->db->where('m.total_poin_skp >=', 201);
        $data['sangat_baik'] = $this->db->get()->result_array();

        $this->db->select('count(m.nim) as jumlah');
        $this->db->from('mahasiswa as m');
        $this->db->where('m.total_poin_skp <=', 200);
        $this->db->where('m.total_poin_skp >=', 151);
        $data['baik'] = $this->db->get()->result_array();

        $this->db->select('count(m.nim) as jumlah');
        $this->db->from('mahasiswa as m');
        $this->db->where('m.total_poin_skp <=', 150);
        $this->db->where('m.total_poin_skp >=', 100);
        $data['cukup'] = $this->db->get()->result_array();

        $this->db->select('count(m.nim) as jumlah');
        $this->db->from('mahasiswa as m');
        $this->db->where('m.total_poin_skp <', 100);
        $this->db->where('m.total_poin_skp >=', 0);

        $data['kurang'] = $this->db->get()->result_array();
        return $data;
    }
    public function getKegiatanAkademik()
    {
        $this->db->select('count(km.id_kuliah_tamu) as jumlah');
        $this->db->from('kuliah_tamu as km');
        $this->db->where('km.status_terlaksana', 0);
        $data['belum_terlaksana'] = $this->db->get()->result_array();

        $this->db->select('count(km.id_kuliah_tamu) as jumlah');
        $this->db->from('kuliah_tamu as km');
        $this->db->where('km.status_terlaksana', 1);
        $data['sudah_terlaksana'] = $this->db->get()->result_array();

        $this->db->select('count(km.id_kuliah_tamu) as jumlah');
        $this->db->from('kuliah_tamu as km');
        $this->db->where('km.status_terlaksana', 2);
        $data['sedang_terlaksana'] = $this->db->get()->result_array();

        return $data;
    }

    public function getPesertaKegiatanAkademik()
    {
        $this->db->select('count(pkt.id_peserta_kuliah_tamu) as jumlah');
        $this->db->from('peserta_kuliah_tamu as pkt');
        $this->db->where('pkt.kehadiran', 0);
        $data['tidak_hadir'] = $this->db->get()->result_array();

        $this->db->select('count(pkt.id_peserta_kuliah_tamu) as jumlah');
        $this->db->from('peserta_kuliah_tamu as pkt');
        $this->db->where('pkt.kehadiran', 1);
        $data['hadir'] = $this->db->get()->result_array();

        return $data;
    }

    public function getRekapUser()
    {
        $this->db->select('count(u.id_user) as jumlah');
        $this->db->from('user as u');
        $this->db->where('u.user_profil_kode', 1);
        $data['mahasiswa'] = $this->db->get()->result_array();

        $this->db->select('count(u.id_user) as jumlah');
        $this->db->from('user as u');
        $this->db->where_in('u.user_profil_kode', [2, 3]);
        $data['lembaga'] = $this->db->get()->result_array();

        $this->db->select('count(u.id_user) as jumlah');
        $this->db->from('user as u');
        $this->db->where_in('u.user_profil_kode', [4, 6, 7, 8, 9]);
        $data['karyawan'] = $this->db->get()->result_array();

        $this->db->select('count(u.id_user) as jumlah');
        $this->db->from('user as u');
        $this->db->where('u.user_profil_kode', 5);
        $data['pimpinan'] = $this->db->get()->result_array();

        return $data;
    }
}
