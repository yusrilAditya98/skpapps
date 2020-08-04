<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');
class Model_kemahasiswaan extends CI_Model
{
    private $id_kegiatan;
    private $jenis_validasi;
    private $kategori;
    private $data;

    // start datatables
    var $column_order = array(null, 'm.nim', 'm.nama', 'j.nama_jurusan', 'p.nama_prodi', 'm.total_poin_skp', null); //set column field database for datatable orderable
    var $column_search = array('nim', 'm.nama'); //set column field database for datatable searchable
    var $column_select = array('j.nama_jurusan', 'p.nama_prodi', 'm.total_poin_skp');
    var $order = array('m.nim' => 'dsc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('m.nim,m.nama,m.total_poin_skp,p.nama_prodi,j.nama_jurusan');
        $this->db->from('mahasiswa as m');
        $this->db->join('prodi as p', 'm.kode_prodi=p.kode_prodi', 'left');
        $this->db->join('jurusan as j', 'j.kode_jurusan=p.kode_jurusan', 'left');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if ($this->input->post('jurusan')) {
            $this->db->like('j.nama_jurusan', $this->input->post('jurusan'));
        };
        if ($this->input->post('prodi')) {
            $this->db->like('p.nama_prodi', $this->input->post('prodi'));
        };
        if ($this->input->post('kategori') == 'dengan pujian') {
            $this->db->where('m.total_poin_skp >', 300);
        } elseif ($this->input->post('kategori') == 'sangat baik') {
            $this->db->where('m.total_poin_skp <=', 300);
            $this->db->where('m.total_poin_skp >=', 201);
        } elseif ($this->input->post('kategori') == 'baik') {
            $this->db->where('m.total_poin_skp <=', 200);
            $this->db->where('m.total_poin_skp >=', 151);
        } elseif ($this->input->post('kategori') == 'cukup') {
            $this->db->where('m.total_poin_skp <=', 150);
            $this->db->where('m.total_poin_skp >=', 100);
        } elseif ($this->input->post('kategori') == 'kurang') {
            $this->db->where('m.total_poin_skp <', 100);
            $this->db->where('m.total_poin_skp >=', 0);
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from('mahasiswa');
        return $this->db->count_all_results();
    }
    // end datatables







    public function getTahunRancangan()
    {
        $this->db->select('tahun_pengajuan as tahun_kegiatan');
        $this->db->from('rekapan_kegiatan_lembaga');
        $this->db->group_by('tahun_pengajuan');
        $this->db->order_by('tahun_pengajuan DESC');
        return $this->db->get()->result_array();
    }
    public function insertPoinSkp($data)
    {
        $this->db->insert_batch('poin_skp', $data);
    }
    public function getNotifValidasi($jenis_validasi, $kategori)
    {
        $this->db->select('*');
        $this->db->from('validasi_kegiatan');
        $this->db->where('jenis_validasi', $jenis_validasi);
        $this->db->where('status_validasi', 4);
        $this->db->where('kategori', $kategori);
        return $this->db->get()->result_array();
    }
    public function getNotifValidasiRancangan()
    {
        $this->db->select('*');
        $this->db->from('rekapan_kegiatan_lembaga');
        $this->db->where('status_rancangan', 3);
        return $this->db->get()->result_array();
    }
    public function getNotifValidasiSkp()
    {
        $this->db->select('*');
        $this->db->from('poin_skp');
        $this->db->where('validasi_prestasi', 0);
        return $this->db->get()->result_array();
    }
    public function getInfoLembaga($status = null)
    {
        $this->db->select('*');
        $this->db->from('lembaga');
        if ($status != null) {
            $this->db->where_not_in('id_lembaga', 0);
        }
        return $this->db->get()->result_array();
    }
    public function updateStatusRencanaKegiatan($data)
    {
        $this->db->update_batch('lembaga', $data, 'id_lembaga');
    }
    public function getRekapRancangan($tahun = null, $lembaga = null, $status = null)
    {
        // jumlah kegiatan
        $this->db->select('count(drk.id_daftar_rancangan) as jumlah_kegiatan,drk.id_lembaga as lbg3,drk.tahun_kegiatan');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->group_by('drk.id_lembaga,drk.tahun_kegiatan');
        $from_clause3 = $this->db->get_compiled_select();

        $this->db->select('l.nama_lembaga,l.status_rencana_kegiatan,rkl.*,jk.jumlah_kegiatan,l.tahun_rancangan');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('lembaga as l', 'l.id_lembaga=rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause3 . ') as jk', 'jk.lbg3 =rkl.id_lembaga and jk.tahun_kegiatan =rkl.tahun_pengajuan', 'left');
        if ($tahun != null) {
            $this->db->where('rkl.tahun_pengajuan', $tahun);
        }
        if ($lembaga != null) {
            $this->db->where('rkl.id_lembaga', $lembaga);
        }
        if ($status != null) {
            $this->db->where('rkl.status_rancangan', $status);
        }
        $this->db->order_by('rkl.status_rancangan ASC');
        return $this->db->get()->result_array();
    }
    public function detailRancangan($id_lembaga, $tahun)
    {
        $this->db->select('drk.*,l.nama_lembaga');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('lembaga as l', 'l.id_lembaga = drk.id_lembaga', 'left');
        $this->db->where('drk.id_lembaga', $id_lembaga);
        $this->db->where('drk.tahun_kegiatan', $tahun);
        return $this->db->get()->result_array();
    }
    // update rancangan
    public function updateStatusProker($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data);
    }
    public function updateRekapKegiatan($id_lembaga, $tahun, $status = null, $anggaran = null)
    {
        if ($status != null) {
            $this->db->set('status_rancangan', $status);
        }
        if ($anggaran != null) {
            $this->db->set('anggaran_kemahasiswaan', $anggaran);
        }
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->where('tahun_pengajuan', $tahun);
        $this->db->update('rekapan_kegiatan_lembaga');
    }
    public function updateDataStatusProker($data)
    {
        $this->db->update_batch('daftar_rancangan_kegiatan', $data, 'id_daftar_rancangan');
    }
    public function insertAnggaranRancangan($data)
    {
        $this->db->insert_batch('rekapan_kegiatan_lembaga', $data);
    }
    // menampilkan anggaran lembaga
    public function getDanaAnggaran($periode = null, $id_lembaga = null)
    {
        //jumlah kegiatan terlaksana
        $this->db->select('count(drk.id_daftar_rancangan) as terlaksana,drk.id_lembaga as lbg1,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.status_rancangan', 5);
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause1 = $this->db->get_compiled_select();

        // // jumlah kegiatan belum terlaksana terlaksana
        $this->db->select('count(drk.id_daftar_rancangan) as blm_terlaksana,drk.id_lembaga as lbg2,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.status_rancangan !=', 5);
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause2 = $this->db->get_compiled_select();
        // // // jumlah kegiatan
        $this->db->select('count(drk.id_daftar_rancangan) as jumlah_kegiatan,drk.id_lembaga as lbg3,');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->group_by('drk.id_lembaga');
        $from_clause3 = $this->db->get_compiled_select();
        // // daftar anggaran yang digunakan
        $this->db->select('sum(dana_kegiatan) as dana_kegiatan,k3.id_lembaga as lbg4');
        $this->db->from('kegiatan as k3');
        $this->db->where('k3.status_selesai_lpj', 3);
        $this->db->where('k3.periode', $periode);
        $this->db->group_by('k3.id_lembaga');
        $from_clause4 = $this->db->get_compiled_select();

        // // daftar anggaran kegiatan terlaksana belum LPJ yang digunakan

        // menampilkan data
        $this->db->select('rkl.id_lembaga,l.nama_lembaga,t.terlaksana, bt.blm_terlaksana,jk.jumlah_kegiatan,da.dana_kegiatan,rkl.anggaran_kemahasiswaan,drk.tahun_kegiatan,l.status_rencana_kegiatan');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('(' . $from_clause1 . ') as t', 't.lbg1 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause2 . ') as bt', 'bt.lbg2 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause3 . ') as jk', 'jk.lbg3 =rkl.id_lembaga', 'left');
        $this->db->join('(' . $from_clause4 . ') as da', 'da.lbg4 =rkl.id_lembaga', 'left');
        $this->db->join('lembaga as l', 'l.id_lembaga =rkl.id_lembaga', 'left');
        $this->db->join('daftar_rancangan_kegiatan as drk', 'rkl.id_lembaga =drk.id_lembaga', 'left');
        $this->db->where('rkl.tahun_pengajuan', $periode);
        $this->db->where('drk.tahun_kegiatan', $periode);
        if ($id_lembaga != null) {
            $this->db->where('l.id_lembaga', $id_lembaga);
        }
        $this->db->group_by('rkl.id_lembaga,rkl.anggaran_kemahasiswaan');
        $data['kegiatan'] = $this->db->get()->result_array();

        $this->db->select('count(id_kegiatan) as kegiatan_blm_lpj,k4.id_lembaga as lbg5');
        $this->db->from('kegiatan as k4');
        $this->db->where('k4.status_selesai_proposal', 3);
        $this->db->where('k4.status_selesai_lpj !=', 3);
        $this->db->where('k4.periode', $periode);
        $this->db->group_by('k4.id_lembaga');
        $data['blm_lpj'] = $this->db->get()->result_array();
        return  $data;
    }
    public function getDataMahasiswa()
    {
        $this->db->select('m.*,p.nama_prodi,j.nama_jurusan');
        $this->db->from('mahasiswa as m');
        $this->db->join('prodi as p', 'm.kode_prodi=p.kode_prodi', 'left');
        $this->db->join('jurusan as j', 'j.kode_jurusan=p.kode_jurusan', 'left');
        return $this->db->get()->result_array();
    }


    public function getDetailAnggaranLembaga($id_lembaga, $periode, $kondisi)
    {
        // // jumlah kegiatan belum terlaksana terlaksana
        $this->db->select('drk.*,l.nama_lembaga');
        $this->db->from('daftar_rancangan_kegiatan as drk');
        $this->db->join('lembaga as l', 'l.id_lembaga=drk.id_lembaga', 'left');
        if ($kondisi == 'blmTerlaksana') {
            $this->db->where('drk.status_rancangan !=', 5);
        } elseif ($kondisi == 'terlaksana') {
            $this->db->where('drk.status_rancangan', 5);
        }
        $this->db->where('drk.tahun_kegiatan', $periode);
        $this->db->where('drk.id_lembaga', $id_lembaga);
        return $this->db->get()->result_array();
    }

    public function getDetailAnggaranBlmLpj($id_lembaga, $periode)
    {
        $this->db->select('k4.nama_kegiatan as nama_proker,k4.dana_kegiatan as anggaran_kegiatan');
        $this->db->from('kegiatan as k4');
        $this->db->where('k4.id_lembaga', $id_lembaga);
        $this->db->where('k4.status_selesai_proposal', 3);
        $this->db->where('k4.status_selesai_lpj !=', 3);
        $this->db->where('k4.periode', $periode);
        return $this->db->get()->result_array();
    }


    public function getBeasiswa($start_date = null, $end_date = null, $validasi = null)
    {

        $this->db->select('b.*,p.*,m.nama');
        $this->db->from('penerima_beasiswa as p');
        $this->db->join('beasiswa as b', 'b.id=p.id_beasiswa', 'left');
        $this->db->join('mahasiswa as m', 'm.nim=p.nim', 'left');
        if ($start_date != null && $end_date != null) {
            $this->db->where('p.tahun_menerima >=', $start_date);
            $this->db->where('p.lama_menerima <=', $end_date);
        }
        if ($validasi != null) {
            $this->db->where('p.validasi_beasiswa', $validasi);
        }

        $this->db->order_by('validasi_beasiswa ASC');
        return $this->db->get()->result_array();
    }
    public function updateStatusBeasiswa($id_penerima, $status)
    {
        $this->db->set('validasi_beasiswa', $status);
        $this->db->where('id_penerima', $id_penerima);
        $this->db->update('penerima_beasiswa');
    }

    public function getRekapanKegiatanLembaga($tahun)
    {
        $this->db->select('rkl.*,l.nama_lembaga');
        $this->db->from('rekapan_kegiatan_lembaga as rkl');
        $this->db->join('lembaga as l', 'l.id_lembaga = rkl.id_lembaga', 'left');
        $this->db->where('rkl.tahun_pengajuan', $tahun);
        return $this->db->get()->result_array();
    }

    // Anggota Lembaga Notifikasi
    public function getNotifValidasiAnggotaLembaga()
    {
        $this->db->select('*');
        $this->db->from('pengajuan_anggota_lembaga');
        $this->db->where('status_validasi', 2);
        return $this->db->get()->result_array();
    }
    public function getNotifValidasiKeaktifanLembaga()
    {
        $this->db->select('*');
        $this->db->from('pengajuan_anggota_lembaga');
        $this->db->where('status_keaktifan', 2);
        return $this->db->get()->result_array();
    }
}
