<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kemahasiswaan extends CI_Controller
{
    private $dataPengajuanSkp = [];
    private $dataskp = [];
    private $totalPoinSKp;
    private $proposalKegiatan = [];
    private $lembaga = [];
    private $rancangan = [];
    private $notif = [];
    private $id_lembaga;
    private $tahun;
    private $anggaran;

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    function get_ajax()
    {
        $kategori = '';
        $this->load->model('Model_kemahasiswaan', 'kmhs_m');
        $list = $this->kmhs_m->get_datatables();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->nim;
            $row[] = $item->nama;
            $row[] = $item->nama_jurusan;
            $row[] = $item->nama_prodi;
            $row[] = $item->total_poin_skp;
            if ($item->total_poin_skp >= 100 && $item->total_poin_skp <= 150) {
                $kategori = ' Cukup';
            } elseif ($item->total_poin_skp >= 151 && $item->total_poin_skp <= 200) {
                $kategori = 'Baik';
            } elseif ($item->total_poin_skp >= 201 && $item->total_poin_skp <= 300) {
                $kategori = ' Sangat Baik';
            } elseif ($item->total_poin_skp > 300) {
                $kategori = ' Dengan Pujian';
            } else {
                $kategori = ' Kurang';
            }
            $row[] = $kategori;

            // add html for action
            $row[] = '<div class="btn-group"><button class="btn btn-icon btn-primary detail-SKP" data-toggle="modal" onclick="detailSKP(' . $item->nim . ')" data-target=".modalDetailSKP" data-id="' . $item->nim . '"><i class="fas fa-eye"></i></button><a href="' . site_url('Kemahasiswaan/cetakSkp?nim=') . $item->nim . '" target="_blank" class="btn btn-icon btn-warning"><i class="fas fa-print"></i></a></div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->kmhs_m->count_all(),
            "recordsFiltered" => $this->kmhs_m->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    private function _notifKmhs()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->notif['notif_kmhs_lpj'] = count($this->kemahasiswaan->getNotifValidasi(3, 'lpj'));
        $this->notif['notif_kmhs_proposal'] = count($this->kemahasiswaan->getNotifValidasi(3, 'proposal'));
        $this->notif['notif_kmhs_rancangan'] = count($this->kemahasiswaan->getNotifValidasiRancangan());
        $this->notif['notif_kmhs_skp'] = count($this->kemahasiswaan->getNotifValidasiSkp());
        $this->notif['notif_kmhs_validasi_anggota_lembaga'] = count($this->kemahasiswaan->getNotifValidasiAnggotaLembaga());
        $this->notif['notif_kmhs_keaktifan_anggota_lembaga'] = count($this->kemahasiswaan->getNotifValidasiKeaktifanLembaga());
        return $this->notif;
    }

    public function index()
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Dashboard';
        $data['proposal_kegiatan'] = $this->kegiatan->getDaftarProposalKegiatan();
        $data['lpj_kegiatan'] = $this->kegiatan->getDaftarLpjKegiatan();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("dashboard/dashboard_kmhsn");
        $this->load->view("template/footer");
    }

    // update pebukaan rancangan kegiatan lembaga
    public function pembukaanRancanganKegiatan($id_lembaga)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $index = 0;
        $this->lembaga[$index++] = [
            'id_lembaga' => $id_lembaga,
            'status_rencana_kegiatan' => $this->input->get('status'),
        ];
        $this->kemahasiswaan->updateStatusRencanaKegiatan($this->lembaga);
        $this->session->set_flashdata('message', 'Status rancangan kegiatan berhasil di perbaharui ! ');
        redirect('Kemahasiswaan/lembaga');
    }

    // Berfungsi untuk melakukan validasi rancangan kegiatan mahasiswa
    public function daftarRancangan()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga();
        $data['filter'] = $this->kegiatan->getDataFilterRancangan();
        $data['notif'] = $this->_notifKmhs();
        if ($this->input->get('tahun') != null || $this->input->get('lembaga') != null || $this->input->get('status') != null) {
            $tahun = $this->input->get('tahun');
            $lembaga = $this->input->get('lembaga');
            $status =  $this->input->get('status');
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan($tahun, $lembaga, $status);
        } else {
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan();
        }

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_validasi_rancangan");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk menampilkan detail rancangan kegiatan pada tahun tertentu
    public function detailRancanganKegiatan()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $id_lembaga = $this->input->get('id_lembaga');
        $tahun_pengajuan = $this->input->get('tahun');
        $data['detail_rancangan'] = $this->kemahasiswaan->detailRancangan($id_lembaga, $tahun_pengajuan);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/detail_rancangan_kegiatan");
        $this->load->view("modal/modal_revisi");
        $this->load->view("template/footer");
    }

    // validasi rancangan proker lembaga
    public function validasiRancanganProker($id_daftar_rancangan)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $id_lembaga = $this->input->post('id_lembaga');
        $tahun_pengajuan = $this->input->post('tahun');

        $status_rancangan = $this->input->post('valid');
        $proker[0] = [
            'id_daftar_rancangan' => $id_daftar_rancangan,
            'status_rancangan' => $status_rancangan,
        ];

        if ($status_rancangan == 2) {
            $proker[0]['catatan_revisi'] = $this->input->post('catatan');
            $this->session->set_flashdata('message', 'Rancangan berhasil direvisi!');
        } else {
            $this->session->set_flashdata('message', 'Rancangan berhasil divalidasi!');
        }

        $this->kemahasiswaan->updateDataStatusProker($proker);

        $data['detail_rancangan'] = $this->kemahasiswaan->detailRancangan($id_lembaga, $tahun_pengajuan);
        $cek_status = true;

        foreach ($data['detail_rancangan'] as $d) {
            if ($d['status_rancangan'] == 2 || $d['status_rancangan'] == 0 || $d['status_rancangan'] == 3) {
                $cek_status = false;
            }
        }
        if ($cek_status) {
            $this->kemahasiswaan->updateRekapKegiatan($id_lembaga, $tahun_pengajuan, 1);
        } else {
            $this->kemahasiswaan->updateRekapKegiatan($id_lembaga, $tahun_pengajuan, 3);
        }

        redirect('Kemahasiswaan/detailRancanganKegiatan?id_lembaga=' . $id_lembaga . '&tahun=' . $tahun_pengajuan);
    }

    // Berfungsi untuk melakukan validasi Proposal kegiatan mahasiswa dan lembaga
    public function daftarProposal()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $data['filter'] = $this->kegiatan->getDaftarTahunKegiatan();
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, null, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan();
        }
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'proposal');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_validasi_proposal");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi LPJ kegiatan mahasiswa dan lembaga
    public function daftarLpj()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $data['filter'] = $this->kegiatan->getDaftarTahunKegiatan();
        if ($this->input->get('start_date') && $this->input->get('end_date')) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3, $start_date, $end_date);
        } else {
            $data['kegiatan'] = $this->kegiatan->getDataKegiatan(null, 3);
        }
        $data['validasi'] = $this->kegiatan->getDataValidasi(null, null, 'lpj');
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_validasi_lpj");
        $this->load->view("modal/modal");
        $this->load->view("template/footer");
    }

    // Berfungsi untuk melakukan validasi poin skp mahasiswa
    public function daftarPoinSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        if ($this->input->get('start_date')  || $this->input->get('end_date')  || $this->input->get('validasi') != null) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $validasi = $this->input->get('validasi');
            $this->dataPengajuanSkp['poinskp'] = $this->poinskp->getPoinSkp(null, null, $start_date, $end_date, $validasi);
        } else {
            $this->dataPengajuanSkp['poinskp'] = $this->poinskp->getPoinSkp();
        }


        $data['title'] = 'Validasi';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_validasi_poin_skp", $this->dataPengajuanSkp);
        $this->load->view("template/footer");
    }

    // validasi poin skp
    public function validasiSkp($id_kegiatan)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $mahasiswa = $this->db->select('nim')->get_where('poin_skp', ['id_poin_skp' => $id_kegiatan])->row_array();
        $this->dataskp = [
            'validasi_prestasi' => $this->input->post('valid'),
            'catatan' => $this->input->post('catatan'),
        ];
        $this->poinskp->updatePoinSkp($id_kegiatan, $this->dataskp);
        $this->_update($mahasiswa['nim']);
        $this->session->set_flashdata('message', 'Skp berhasil divalidasi!');
        redirect('Kemahasiswaan/daftarPoinSkp');
    }

    // Validasi proposal kegiatan
    public function validasiProposal($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $id = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $jenis_validasi = $this->input->get('jenis_validasi');
        $status_proposal = 1;
        $data = [
            'status_validasi' => $this->input->get('valid'),
            'tanggal_validasi' => date("Y-m-d"),
            'id_user' => $id['id_user'],
            'catatan_revisi' => '-'
        ];
        $this->kegiatan->updateStatusProposal($id_kegiatan, $status_proposal);
        $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'proposal');
        // update validasi
        if ($this->input->get('valid') == 1 && $this->session->userdata('user_profil_kode') != 6) {
            $val_selanjutnya = [
                'status_validasi' => 4,
                'id_user' => 8,
            ];
            $jenis_validasi = 1 + $this->input->get('jenis_validasi');
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($val_selanjutnya, $jenis_validasi, $id_kegiatan, 'proposal');
            $this->session->set_flashdata('message', 'Proposal berhasil divalidasi!');
        }
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_proposal = 2;
            $this->kegiatan->updateStatusProposal($id_kegiatan, $status_proposal);
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'proposal');
            $this->session->set_flashdata('message', 'Proposal berhasil direvisi!');
        }
        redirect('Kemahasiswaan/daftarProposal');
    }

    // Validasi proposal kegiatan
    public function validasiLpj($id_kegiatan)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $id = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $jenis_validasi = $this->input->get('jenis_validasi');
        $status_lpj = 1;
        $data = [
            'status_validasi' => $this->input->get('valid'),
            'tanggal_validasi' => date("Y-m-d"),
            'id_user' => $id['id_user'],
            'catatan_revisi' => '-'
        ];
        $this->kegiatan->updateStatusLpj($id_kegiatan, $status_lpj);
        $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'lpj');
        // update validasi
        if ($this->input->get('valid') == 1 && $this->session->userdata('user_profil_kode') != 6) {
            $val_selanjutnya = [
                'status_validasi' => 4,
                'id_user' => 8,
            ];
            $jenis_validasi = 1 + $this->input->get('jenis_validasi');
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($val_selanjutnya, $jenis_validasi, $id_kegiatan, 'lpj');
            $this->session->set_flashdata('message', 'Lpj berhasil divalidasi!');
        }
        if ($this->input->post('revisi')) {
            $data['status_validasi'] = $this->input->post('valid');
            $data['catatan_revisi'] = $this->input->post('catatan');
            $jenis_validasi = $this->input->post('jenis_validasi');
            $status_lpj = 2;
            $this->kegiatan->updateStatusLpj($id_kegiatan, $status_lpj);
            $this->proposalKegiatan = $this->kegiatan->updateValidasi($data, $jenis_validasi, $id_kegiatan, 'lpj');
            $this->session->set_flashdata('message', 'Lpj berhasil direvisi!');
        }
        redirect('Kemahasiswaan/daftarLpj');
    }

    // lihat daftar lembaga di FEB
    public function lembaga()
    {
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Lembaga';;
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['tahun'] = $this->kemahasiswaan->getTahunRancangan();
        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();
        if ($data['tahun']) {
            $data['tahun_saat_ini'] = $data['tahun'][0]['tahun_kegiatan'];
        } else {
            $data['tahun_saat_ini'] = date('Y');
            $data['tahun'][0]['tahun_kegiatan'] = date('Y');
        }
        if ($this->input->get('tahun') != null) {
            $tahun = $this->input->get('tahun');
            $data['anggaran'] = $this->kemahasiswaan->getDanaAnggaran($tahun);
            $data['dana_pagu'] = $this->kemahasiswaan->getRekapanKegiatanLembaga($tahun);
            $data['tahun_saat_ini'] = $tahun;
        } elseif ($data['tahun'] != null) {
            $data['anggaran'] = $this->kemahasiswaan->getDanaAnggaran($data['tahun'][0]['tahun_kegiatan']);
            $data['dana_pagu'] = $this->kemahasiswaan->getRekapanKegiatanLembaga($data['tahun'][0]['tahun_kegiatan']);
        } else {
            $data['anggaran'] = $this->kemahasiswaan->getDanaAnggaran($data['tahun_saat_ini']);
            $data['dana_pagu'] = $this->kemahasiswaan->getRekapanKegiatanLembaga($data['tahun_saat_ini']);
        }
        $data['anggaran'] = $this->_insertKegiatanBlmLpj($data['anggaran'],   $data['tahun_saat_ini']);
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_anggaran");
        $this->load->view("template/footer");
    }
    private function _serapanLembaga($proposal, $lpj, $id_lembaga)
    {
        $kegiatan = $this->db->get_where('kegiatan', ['id_lembaga' => $id_lembaga])->result_array();

        if ($proposal == null) {
            foreach ($kegiatan as $k) {
                $proposal[$k['id_lembaga']] = [
                    'bulan_pengajuan' => 0,
                    'id_kegiatan' => $k['id_kegiatan'],
                    'dana' => 0
                ];
            }
        }

        if ($lpj == null) {
            foreach ($kegiatan as $k) {
                $lpj[$k['id_kegiatan']] = [
                    'bulan_pengajuan' => 0,
                    'id_kegiatan' => $k['id_kegiatan'],
                    'dana' => 0
                ];
            }
        }

        $data = [];
        foreach ($kegiatan as $k) {
            for ($j = 1; $j < 13; $j++) {
                $data[$k['id_kegiatan']][$j] = 0;
            }
            $data[$k['id_kegiatan']]['anggaran_kegiatan'] = $k['dana_kegiatan'];
            $data[$k['id_kegiatan']]['dana_terserap'] = 0;
        }


        $data_lpj = [];
        foreach ($proposal as $p) {
            $data_lpj[$p['id_kegiatan']] = [
                'bulan_pengajuan' => 0,
                'id_kegiatan' => $p['id_kegiatan'],
                'dana' => 0
            ];
        }


        foreach ($lpj as $l) {
            $data_lpj[$l['id_kegiatan']] = [
                'bulan_pengajuan' => $l['bulan_pengajuan'],
                'id_kegiatan' => $l['id_kegiatan'],
                'dana' =>  $l['dana'],
            ];
        }
        $lpj = $data_lpj;

        foreach ($proposal as $p) {
            // data lpj haruslah tidak boleh kosong
            foreach ($lpj as $l) {
                for ($i = 1; $i < 13; $i++) {
                    if ($p['id_kegiatan'] == $l['id_kegiatan'] && $p['bulan_pengajuan'] == $i) {
                        if ($l['bulan_pengajuan'] == $p['bulan_pengajuan']) {
                            $data[$p['id_kegiatan']][$i] = $p['dana'] + $l['bulan_pengajuan'];
                        } else {
                            $data[$p['id_kegiatan']][$i] = $p['dana'];
                        }
                    }
                    if ($p['id_kegiatan'] == $l['id_kegiatan'] && $l['bulan_pengajuan'] == $i) {
                        if ($l['bulan_pengajuan'] == $p['bulan_pengajuan']) {
                            $data[$l['id_kegiatan']][$i] = $p['dana'] + $l['dana'];
                        } else {
                            $data[$l['id_kegiatan']][$i] = $l['dana'];
                        }
                    }
                }
            }
        }

        foreach ($kegiatan as $k) {
            for ($j = 1; $j < 13; $j++) {
                $data[$k['id_kegiatan']]['dana_terserap'] += $data[$k['id_kegiatan']][$j];
            }
        }
        return $data;
    }
    private function _totalDanaLembaga($laporan, $id_lembaga)
    {
        $kegiatan = $this->db->get_where('kegiatan', ['id_lembaga' => $id_lembaga])->result_array();
        $data['total']['dana_terserap'] = 0;
        foreach ($kegiatan as $k) {
            $data['total']['dana_terserap'] += $laporan[$k['id_kegiatan']]['dana_terserap'];
        }
        return $data;
    }
    private function _danaTerserap($id_lembaga)
    {
        $this->load->model('Model_keuangan', 'keuangan');
        $data['serapan_proposal'] = $this->keuangan->getAnggaranLembagaProposal($id_lembaga);
        $data['serapan_lpj'] = $this->keuangan->getAnggaranLembagaLpj($id_lembaga);
        $data['laporan'] = $this->_serapanLembaga($data['serapan_proposal'], $data['serapan_lpj'], $id_lembaga);
        $dana_terserap = $this->_totalDanaLembaga($data['laporan'], $id_lembaga);

        return $dana_terserap['total']['dana_terserap'];
    }
    public function _insertKegiatanBlmLpj($blm_lpj, $tahun)
    {

        $data = [];
        $i = 0;
        foreach ($blm_lpj['kegiatan'] as $b) {
            $data[$i] = [
                "id_lembaga" => $b['id_lembaga'],
                "nama_lembaga" => $b['nama_lembaga'],
                "terlaksana" => $b['terlaksana'],
                "blm_terlaksana" => $b['blm_terlaksana'],
                "jumlah_kegiatan" => $b['jumlah_kegiatan'],
                "anggaran_kemahasiswaan" => $b['anggaran_kemahasiswaan'],
                "tahun_kegiatan" => $b['tahun_kegiatan'],
                "blm_lpj" => 0
            ];
            foreach ($blm_lpj['blm_lpj'] as $bm) {
                if ($bm['lbg5'] ==  $b['id_lembaga']) {
                    $data[$i]['blm_lpj'] =  $bm['kegiatan_blm_lpj'];
                }
            }
            $data[$i]["dana_kegiatan"] = $this->_danaTerserap($data[$i]['id_lembaga']);
            $i++;
        }
        return $data;
    }

    public function editRancanganTahun($id_lembaga)
    {
        $tahun = $this->input->post('tahun_rancangan');
        $this->db->set('tahun_rancangan', $tahun);
        $this->db->where('id_lembaga', $id_lembaga);
        $this->db->update('lembaga');
        $this->session->set_flashdata('message', 'Tahun rancangan berhasil diubah');
        redirect('Kemahasiswaan/lembaga');
    }

    public function hapusPoinSkp($id_poinSkp)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $skp = $this->db->get_where('poin_skp', ['id_poin_skp' => $id_poinSkp])->row_array();
        $this->poinskp->deletePoinSkp($id_poinSkp);


        $this->_update($skp['nim']);
        $this->session->set_flashdata('message', 'Skp Berhasil dihapus!');
        redirect('Kemahasiswaan/daftarPoinSkp');
    }

    // detail kegiatan skp
    public function detailKegiatan($id_kegiatan = null)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        echo json_encode($this->poinskp->getPoinSkp(null, $id_kegiatan));
    }
    public function detailProposalKegiatan($id_kegiatan = null)
    {
        $data = $this->db->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->result_array();
        echo json_encode($data);
    }

    private function _update($nim)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->totalPoinSKp = $this->poinskp->updateTotalPoinSkp($nim);

        $this->db->set('total_poin_skp', $this->totalPoinSKp);
        $this->db->where('nim', $nim);
        $this->db->update('mahasiswa');
    }
    public function validasiKegiatan($id)
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['validasi'] = $this->kegiatan->getInfoValidasi($id);
        echo json_encode($data['validasi']);
    }


    public function laporanSerapan()
    {
        $this->load->model('Model_keuangan', 'keuangan');
        $data['title'] = 'Anggaran';
        $data['notif'] = $this->_notifKmhs();
        $data['tahun'] = $this->keuangan->getTahun();
        if ($data['tahun']) {
            $tahun = $data['tahun'][0]['tahun'];
            $data['tahun_saat_ini'] = $tahun;
        } else {
            $tahun = date('Y');
            $data['tahun_saat_ini'] = $tahun;
            $data['tahun'][0]['tahun'] = $tahun;
        }

        $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();

        if ($this->input->post('tahun')) {
            $tahun = $this->input->post('tahun');
            $data['serapan_proposal'] = $this->keuangan->getLaporanSerapanProposal($tahun);
            $data['serapan_lpj'] = $this->keuangan->getLaporanSerapanLpj($tahun);
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
            $data['tahun_saat_ini'] = $this->input->post('tahun');
        } else {
            $data['serapan_proposal'] = $this->keuangan->getLaporanSerapanProposal($tahun);
            $data['serapan_lpj'] = $this->keuangan->getLaporanSerapanLpj($tahun);
            $data['laporan'] = $this->_serapan($data['serapan_proposal'], $data['serapan_lpj'], $tahun);
        }

        $data['total'] = $this->_totalDana($data['laporan']);

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("keuangan/laporan_serapan", $data);
        $this->load->view("template/footer");
    }

    private function _serapan($proposal, $lpj, $tahun)
    {

        $lembaga = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();

        if ($proposal == null) {
            foreach ($lembaga as $l) {
                $proposal[$l['id_lembaga']] = [
                    'bulan' => 0,
                    'dana' => 0,
                    'id_lembaga' => $l['id_lembaga'],
                    'nama_lembaga' => $l['nama_lembaga']
                ];
            }
        }
        if ($lpj == null) {
            foreach ($lembaga as $l) {
                $lpj[$l['id_lembaga']] = [
                    'bulan' => 0,
                    'dana' => 0,
                    'id_lembaga' => $l['id_lembaga'],
                    'nama_lembaga' => $l['nama_lembaga']
                ];
            }
        }
        // inisialisasi data lpj
        $data_lpj = [];
        $index1 = 0;
        foreach ($proposal as $p) {
            $data_lpj[$index1++] = [
                'bulan' => 0,
                'dana' => 0,
                'id_lembaga' => $p['id_lembaga'],
                'nama_lembaga' => $p['nama_lembaga']
            ];
        }
        // mengisikan nilai array LPJ
        $index2 = 0;
        foreach ($lpj as $l) {
            $data_lpj[$index2++] = [
                'bulan' => $l['bulan'],
                'dana' => $l['dana'],
                'id_lembaga' => $l['id_lembaga'],
                'nama_lembaga' => $l['nama_lembaga']
            ];
        }
        $lpj = $data_lpj;
        $data = [];
        foreach ($lembaga as $l) {
            for ($j = 1; $j < 13; $j++) {
                $data[$l['id_lembaga']][$j] = 0;
            }
            $data[$l['id_lembaga']]['nama_lembaga'] = $l['nama_lembaga'];
            $dana = $this->db->select('anggaran_kemahasiswaan')->get_where('rekapan_kegiatan_lembaga', ['id_lembaga' => $l['id_lembaga'],  'tahun_pengajuan' => $tahun])->row_array();

            if ($dana['anggaran_kemahasiswaan'] == null) {
                $data[$l['id_lembaga']]['dana_pagu'] = 0;
            } else {
                $data[$l['id_lembaga']]['dana_pagu']  = $dana['anggaran_kemahasiswaan'];
            }
            $data[$l['id_lembaga']]['dana_terserap'] = 0;
        }
        foreach ($proposal as $p) {
            if ($p['bulan'] == "1") {
                $data[$p['id_lembaga']][1] += $p['dana'];
            } elseif ($p['bulan'] == "2") {
                $data[$p['id_lembaga']][2] += $p['dana'];
            } elseif ($p['bulan'] == "3") {
                $data[$p['id_lembaga']][3] += $p['dana'];
            } elseif ($p['bulan'] == "4") {
                $data[$p['id_lembaga']][4] += $p['dana'];
            } elseif ($p['bulan'] == "5") {
                $data[$p['id_lembaga']][5] += $p['dana'];
            } elseif ($p['bulan'] == "6") {
                $data[$p['id_lembaga']][6] += $p['dana'];
            } elseif ($p['bulan'] == "7") {
                $data[$p['id_lembaga']][7] += $p['dana'];
            } elseif ($p['bulan'] == "8") {
                $data[$p['id_lembaga']][8] += $p['dana'];
            } elseif ($p['bulan'] == "9") {
                $data[$p['id_lembaga']][9] += $p['dana'];
            } elseif ($p['bulan'] == "10") {
                $data[$p['id_lembaga']][10] += $p['dana'];
            } elseif ($p['bulan'] == "11") {
                $data[$p['id_lembaga']][11] += $p['dana'];
            } elseif ($p['bulan'] == "12") {
                $data[$p['id_lembaga']][12] += $p['dana'];
            }
        }
        foreach ($lpj as $l) {
            if ($l['bulan'] == "1") {
                $data[$l['id_lembaga']][1] += $l['dana'];
            } elseif ($l['bulan'] == "2") {
                $data[$l['id_lembaga']][2] += $l['dana'];
            } elseif ($l['bulan'] == "3") {
                $data[$l['id_lembaga']][3] += $l['dana'];
            } elseif ($l['bulan'] == "4") {
                $data[$l['id_lembaga']][4] += $l['dana'];
            } elseif ($l['bulan'] == "5") {
                $data[$l['id_lembaga']][5] += $l['dana'];
            } elseif ($l['bulan'] == "6") {
                $data[$l['id_lembaga']][6] += $l['dana'];
            } elseif ($l['bulan'] == "7") {
                $data[$l['id_lembaga']][7] += $l['dana'];
            } elseif ($l['bulan'] == "8") {
                $data[$l['id_lembaga']][8] += $l['dana'];
            } elseif ($l['bulan'] == "9") {
                $data[$l['id_lembaga']][9] += $l['dana'];
            } elseif ($l['bulan'] == "10") {
                $data[$l['id_lembaga']][10] += $l['dana'];
            } elseif ($l['bulan'] == "11") {
                $data[$l['id_lembaga']][11] += $l['dana'];
            } elseif ($l['bulan'] == "12") {
                $data[$l['id_lembaga']][12] += $l['dana'];
            }
        }
        foreach ($lembaga as $l) {
            $data[$l['id_lembaga']]['id_lembaga'] = $l['id_lembaga'];
            for ($j = 1; $j < 13; $j++) {
                $data[$l['id_lembaga']]['dana_terserap'] += $data[$l['id_lembaga']][$j];
            }
            if ($data[$l['id_lembaga']]['dana_pagu'] == 0) {
                $data[$l['id_lembaga']]['terserap_persen'] =  0;
            } else {
                $data[$l['id_lembaga']]['terserap_persen'] = $data[$l['id_lembaga']]['dana_terserap'] / $data[$l['id_lembaga']]['dana_pagu']  * 100;
            }
            $data[$l['id_lembaga']]['dana_sisa'] = $data[$l['id_lembaga']]['dana_pagu'] - $data[$l['id_lembaga']]['dana_terserap'];
            if ($data[$l['id_lembaga']]['dana_pagu'] == 0) {
                $data[$l['id_lembaga']]['sisa_terserap'] = 0;
            } else {
                $data[$l['id_lembaga']]['sisa_terserap'] = $data[$l['id_lembaga']]['dana_sisa'] / $data[$l['id_lembaga']]['dana_pagu']  * 100;
            }
        }
        return $data;
    }
    private function _totalDana($laporan)
    {

        $lembaga = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();
        $data['total']['dana_sisa'] = 0;
        $data['total']['dana_terserap'] = 0;
        $data['total']['dana_pagu'] = 0;
        $data['total']['persen_terserap'] = 0;
        $data['total']['persen_sisa'] = 0;
        foreach ($lembaga as $l) {
            $data['total']['dana_sisa'] += $laporan[$l['id_lembaga']]['dana_sisa'];
            $data['total']['dana_terserap'] += $laporan[$l['id_lembaga']]['dana_terserap'];
            $data['total']['dana_pagu'] += $laporan[$l['id_lembaga']]['dana_pagu'];
        }
        if ($data['total']['dana_pagu'] == 0) {
            $data['total']['persen_terserap'] = 0;
            $data['total']['persen_sisa'] = 0;
        } else {
            $data['total']['persen_terserap'] = $data['total']['dana_terserap'] / $data['total']['dana_pagu'] * 100;
            $data['total']['persen_sisa'] = $data['total']['dana_sisa'] / $data['total']['dana_pagu'] * 100;
        }

        return $data;
    }
    public function editAnggaranRancangan()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->anggaran = $this->input->post('nominal');
        $this->tahun = $this->input->post('tahun');
        $this->id_lembaga = $this->input->post('id_lembaga');
        $this->kemahasiswaan->updateRekapKegiatan($this->id_lembaga, $this->tahun, null, $this->anggaran);
        $this->session->set_flashdata('message', 'Dana kegiatan berhasil di perbaharui ! ');
        redirect('Kemahasiswaan/lembaga');
    }
    public function tambahAnggaranKegiatan()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga('lembaga');
        $index = 0;
        $this->tahun = $this->input->post('tahun_rancangan');

        // cek apakah sudah pernah mengajukan pada tanggal yang sama
        $cek_tahun = $this->db->get_where('rekapan_kegiatan_lembaga', ['tahun_pengajuan' => $this->tahun])->data_seek();
        if ($cek_tahun) {
            $this->session->set_flashdata('failed', 'Tahun anggaran sudah pernah diajukan !');
            redirect('Kemahasiswaan/lembaga');
        }

        foreach ($data['lembaga'] as $l) {

            if ($l['id_lembaga'] == 0) {
                $this->lembaga[$index] = [
                    'id_lembaga' => $l['id_lembaga'],
                    'tahun_pengajuan' => $this->tahun,
                    'anggaran_kemahasiswaan' => $this->input->post('lembaga_' . $l['id_lembaga']),
                    'anggaran_lembaga' => 0,
                    'status_rancangan' => 1
                ];
            } else {
                $this->lembaga[$index] = [
                    'id_lembaga' => $l['id_lembaga'],
                    'tahun_pengajuan' => $this->tahun,
                    'anggaran_kemahasiswaan' => $this->input->post('lembaga_' . $l['id_lembaga']),
                    'anggaran_lembaga' => 0,
                    'status_rancangan' => 0
                ];
            }
            $this->rancangan[$index++] = [
                'id_lembaga' => $l['id_lembaga'],
                'status_rencana_kegiatan' => 1,
                'tahun_rancangan' => $this->tahun
            ];
        }
        $this->kemahasiswaan->updateStatusRencanaKegiatan($this->rancangan);
        $this->kemahasiswaan->insertAnggaranRancangan($this->lembaga);
        $this->session->set_flashdata('message', 'Dana pagu lembaga berhasil ditambahkan !');
        redirect('Kemahasiswaan/lembaga');
    }
    public function cetakPengajuanProposal()
    {
        $data['kegiatan'] = [];
        $kegiatan = $this->db->get('kegiatan')->result_array();
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();

        $index = 0;
        foreach ($kegiatan as $k) {
            if ($this->input->post('cek_' . $k['id_kegiatan'])) {
                $data['kegiatan'][$index] = [
                    'nama_kegiatan' => $k['nama_kegiatan'],
                    'tanggal_kegiatan' => $k['tanggal_kegiatan'],
                    'deskripsi_kegiatan' => $k['deskripsi_kegiatan'],
                    'dana_kegiatan' => $k['dana_kegiatan']
                ];
            }
            $index++;
        }
        $this->load->view('kemahasiswaan/tampilan_table', $data);
    }
    public function cetakPengajuanLpj()
    {
        $data['kegiatan'] = [];
        $kegiatan = $this->db->get('kegiatan')->result_array();
        $index = 0;
        foreach ($kegiatan as $k) {
            if ($this->input->post('cek_' . $k['id_kegiatan'])) {
                $data['kegiatan'][$index] = [
                    'nama_kegiatan' => $k['nama_kegiatan'],
                    'tanggal_kegiatan' => $k['tanggal_kegiatan'],
                    'deskripsi_kegiatan' => $k['deskripsi_kegiatan'],
                    'dana_kegiatan' => $k['dana_kegiatan']
                ];
            }
            $index++;
        }
        $this->load->view('kemahasiswaan/tampilan_table', $data);
    }
    public function cetakPengajuanDana($id_kegiatan)
    {
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();
        $status = $this->input->get('status');
        if ($status == 'lpj') {
            $data['kegiatan'] = $this->db->select('nama_kegiatan,nama_penanggung_jawab,dana_lpj as dana,periode')->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->row_array();
        } else {
            $data['kegiatan'] = $this->db->select('nama_kegiatan,nama_penanggung_jawab,dana_proposal as dana,periode')->get_where('kegiatan', ['id_kegiatan' => $id_kegiatan])->row_array();
        }
        $this->load->view('kemahasiswaan/bukti_pengajuan', $data);
    }

    // menampilkan daftar poin skp keseluruhan mahasiswa
    public function skpMahasiswa()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['mahasiswa'] = $this->kemahasiswaan->getDataMahasiswa();
        $data['notif'] = $this->_notifKmhs();

        foreach ($data['mahasiswa'] as $element) {
            $result['jurusan'][$element['nama_jurusan']] = $element['nama_jurusan'];
            $result['prodi'][$element['nama_prodi']] = $element['nama_prodi'];
        }

        $data['filter_skp'] = $result;
        $data['title'] = 'Poin Skp';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/poin_skp_mhs");
        $this->load->view("template/footer");
    }

    // menampilkan beasiswa
    public function beasiswa()
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        if ($this->input->get('start_date')  || $this->input->get('end_date')  || $this->input->get('validasi') != null) {
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $validasi = $this->input->get('validasi');
            $data['beasiswa'] = $this->kemahasiswaan->getBeasiswa($start_date, $end_date, $validasi);
        } else {
            $data['beasiswa'] = $this->kemahasiswaan->getBeasiswa();
        }
        $data['kategori_beasiswa'] = $this->db->get('beasiswa')->result_array();
        $data['notif'] = $this->_notifKmhs();
        $data['title'] = 'Beasiswa';
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_beasiswa");
        $this->load->view("template/footer");
    }
    // validasi beasiswa
    public function validasiBeasiswa($id_penerima)
    {
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $status = $this->input->get('status');
        $this->kemahasiswaan->updateStatusBeasiswa($id_penerima, $status);
        $this->session->set_flashdata('message', 'Status Beasiswa berhasil di perbaharui ! ');
        redirect('Kemahasiswaan/beasiswa');
    }

    /** Methode Kharis */

    public function kategori()
    {
        $data['title'] = 'Kategori';
        $data['bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $this->db->select('id_jenis_kegiatan, jenis_kegiatan, nama_bidang,status_jenis');
        $this->db->from('jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $data['jenis'] = $this->db->get()->result_array();
        $data['tingkatan'] = $this->db->get('tingkatan')->result_array();
        $data['prestasi'] = $this->db->get('prestasi')->result_array();
        $data['dasar_penilaian'] = $this->db->get('dasar_penilaian')->result_array();
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $data['notif'] = $this->_notifKmhs();
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');

        $this->load->model('Model_poinskp', 'poinskp');
        $this->semuaTingkatanKegiatan = $this->poinskp->getSemuaTingkatan();
        $data['semua_tingkatan'] = $this->semuaTingkatanKegiatan;
        $this->semuaPrestasiKegiatan = $this->poinskp->getSemuaPrestasi();
        $data['semua_prestasi'] = $this->semuaPrestasiKegiatan;
        // header('Content-type: application/json');
        // echo json_encode($data['semua_tingkatan']);
        // die;

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/kategori");
        $this->load->view("template/footer");
    }
    public function tambahBidang()
    {
        $bidang = $this->input->post('bidang_kegiatan');
        $data_bidang = [
            'nama_bidang' => $bidang
        ];
        $temp = $this->db->get_where('bidang_kegiatan', ['nama_bidang' => $bidang])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('bidang_kegiatan', $data_bidang);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Bidang sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }
    public function editBidang($id)
    {
        $bidang = $this->input->post('bidang_kegiatan');
        $data_bidang = [
            'nama_bidang' => $bidang
        ];
        $this->db->set($data_bidang);
        $this->db->where('id_bidang', $id);
        $this->db->update('bidang_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusBidang($id)
    {

        $jenis_kegiatan = $this->db->get_where('jenis_kegiatan', ['id_bidang' => intval($id)])->result_array();

        for ($i = 0; $i < count($jenis_kegiatan); $i++) {
            $id_jenis_kegiatan = $jenis_kegiatan[$i]['id_jenis_kegiatan'];
            $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_jenis_kegiatan' => intval($id_jenis_kegiatan)])->result_array();
            for ($j = 0; $j < count($semua_tingkatan); $j++) {
                $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
                $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
                $this->db->delete('semua_prestasi');
            }
            $this->db->where('id_jenis_kegiatan', intval($id_jenis_kegiatan));
            $this->db->delete('semua_tingkatan');
        }
        $this->db->where('id_bidang', intval($id));
        $this->db->delete('jenis_kegiatan');

        $this->db->where('id_bidang', intval($id));
        $this->db->delete('bidang_kegiatan');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bidang berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function tambahJenis()
    {
        $jenis = $this->input->post('jenis_kegiatan');
        $bidang = $this->input->post('bidang_kegiatan');
        $data_jenis = [
            'jenis_kegiatan' => $jenis,
            'id_bidang' => intval($bidang)
        ];
        $temp = $this->db->get_where('jenis_kegiatan', ['jenis_kegiatan' => $jenis, 'id_bidang' => $bidang])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('jenis_kegiatan', $data_jenis);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Jenis sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }
    public function editJenis($id)
    {
        $jenis = $this->input->post('jenis_kegiatan');
        $bidang = $this->input->post('bidang_kegiatan');
        $data_jenis = [
            'jenis_kegiatan' => $jenis,
            'id_bidang' => intval($bidang)
        ];
        $this->db->set($data_jenis);
        $this->db->where('id_jenis_kegiatan', $id);
        $this->db->update('jenis_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusJenis($id)
    {
        $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_jenis_kegiatan' => intval($id)])->result_array();
        for ($j = 0; $j < count($semua_tingkatan); $j++) {
            $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
            $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
            $this->db->delete('semua_prestasi');
        }
        $this->db->where('id_jenis_kegiatan', intval($id));
        $this->db->delete('semua_tingkatan');

        $this->db->where('id_jenis_kegiatan', intval($id));
        $this->db->delete('jenis_kegiatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function tambahTingkatan()
    {
        $tingkatan = $this->input->post('tingkatan');
        $data_tingkatan = [
            'nama_tingkatan' => $tingkatan
        ];
        $temp = $this->db->get_where('tingkatan', ['nama_tingkatan' => $tingkatan])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('tingkatan', $data_tingkatan);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Tingkatan sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }

    public function editTingkatan($id)
    {
        $tingkatan = $this->input->post('tingkatan');
        $data_tingkatan = [
            'nama_tingkatan' => $tingkatan
        ];
        $this->db->set($data_tingkatan);
        $this->db->where('id_tingkatan', $id);
        $this->db->update('tingkatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusTingkatan($id)
    {
        $semua_tingkatan = $this->db->get_where('semua_tingkatan', ['id_tingkatan' => intval($id)])->result_array();
        for ($j = 0; $j < count($semua_tingkatan); $j++) {
            $id_semua_tingkatan = $semua_tingkatan[$j]['id_semua_tingkatan'];
            $this->db->where('id_semua_tingkatan', intval($id_semua_tingkatan));
            $this->db->delete('semua_prestasi');
        }
        $this->db->where('id_tingkatan', intval($id));
        $this->db->delete('semua_tingkatan');

        $this->db->where('id_tingkatan', intval($id));
        $this->db->delete('tingkatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tingkatan berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }

    public function tambahDetailTingkatan()
    {
        $bidang = $this->input->post('bidang');
        $tingkatan = $this->input->post('tingkatan');
        $jenis = $this->input->post('jenis');
        $data_semua_tingkatan = [
            'id_tingkatan' => intval($tingkatan),
            'id_jenis_kegiatan' => intval($jenis)
        ];
        $temp = $this->db->get_where('semua_tingkatan', ['id_tingkatan' => $tingkatan, 'id_jenis_kegiatan' => $jenis])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('semua_tingkatan', $data_semua_tingkatan);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Tingkatan berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Detail Tingkatan sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }
    public function editDetailTingkatan($id)
    {
        $bidang = $this->input->post('bidang');
        $tingkatan = $this->input->post('tingkatan');
        $jenis = $this->input->post('jenis');
        $data_semua_tingkatan = [
            'id_tingkatan' => intval($tingkatan),
            'id_jenis_kegiatan' => intval($jenis)
        ];
        $this->db->set($data_semua_tingkatan);
        $this->db->where('id_semua_tingkatan', $id);
        $this->db->update('semua_tingkatan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Tingkatan berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusDetailTingkatan($id)
    {

        $this->db->where('id_semua_tingkatan', intval($id));
        $this->db->delete('semua_prestasi');

        $this->db->where('id_semua_tingkatan', intval($id));
        $this->db->delete('semua_tingkatan');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Tingkatan berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }

    public function tambahPrestasi()
    {
        $prestasi = $this->input->post('prestasi');
        $data_prestasi = [
            'nama_prestasi' => $prestasi
        ];
        $temp = $this->db->get_where('prestasi', ['nama_prestasi' => $prestasi])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('prestasi', $data_prestasi);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestasi berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Prestasi sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }

    public function editPrestasi($id)
    {
        $prestasi = $this->input->post('prestasi');
        $data_prestasi = [
            'nama_prestasi' => $prestasi
        ];
        $this->db->set($data_prestasi);
        $this->db->where('id_prestasi', $id);
        $this->db->update('prestasi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestaso berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusPrestasi($id)
    {
        $this->db->where('id_prestasi', intval($id));
        $this->db->delete('semua_prestasi');

        $this->db->where('id_prestasi', intval($id));
        $this->db->delete('prestasi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Prestasi berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }

    public function tambahDetailPrestasi()
    {
        $bidang = $this->input->post('bidang');
        $tingkatan = $this->input->post('tingkatan');
        $jenis = $this->input->post('jenis');
        $prestasi = $this->input->post('prestasi');
        $dasar = $this->input->post('dasar');
        $bobot = $this->input->post('bobot');
        $data_semua_prestasi = [
            'bobot' => intval($bobot),
            'id_semua_tingkatan' => intval($tingkatan),
            'id_prestasi' => intval($prestasi),
            'id_dasar_penilaian' => intval($dasar),
        ];
        $temp = $this->db->get_where('semua_prestasi', ['id_semua_tingkatan' => $tingkatan, 'id_prestasi' => $prestasi])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('semua_prestasi', $data_semua_prestasi);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Prestasi berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Detail Tingkatan sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }

    public function editDetailPrestasi($id)
    {
        $bidang = $this->input->post('bidang');
        $tingkatan = $this->input->post('tingkatan');
        $jenis = $this->input->post('jenis');
        $prestasi = $this->input->post('prestasi');
        $dasar = $this->input->post('dasar');
        $bobot = $this->input->post('bobot');
        $data_semua_prestasi = [
            'bobot' => intval($bobot),
            'id_semua_tingkatan' => intval($tingkatan),
            'id_prestasi' => intval($prestasi),
            'id_dasar_penilaian' => intval($dasar),
        ];
        // header('Content-type: application/json');
        // echo json_encode($data_semua_prestasi);
        // die;
        $this->db->set($data_semua_prestasi);
        $this->db->where('id_semua_prestasi', $id);
        $this->db->update('semua_prestasi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Prestasi berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }
    public function hapusDetailPrestasi($id)
    {
        $this->db->where('id_semua_prestasi', intval($id));
        $this->db->delete('semua_prestasi');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Detail Prestasi berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }

    public function tambahDasarPenilaian()
    {
        $dasar = $this->input->post('dasar_penilaian');
        $data_dasar = [
            'nama_dasar_penilaian' => $dasar
        ];
        $temp = $this->db->get_where('dasar_penilaian', ['nama_dasar_penilaian' => $dasar])->result_array();
        if (count($temp) == 0) {
            $this->db->insert('dasar_penilaian', $data_dasar);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Dasar penilaian berhasil ditambahkan</div>');
            redirect('kemahasiswaan/kategori');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Dasar penilaian sudah ada</div>');
            redirect('kemahasiswaan/kategori');
        }
    }
    public function editDasarPenilaian($id)
    {
        $dasar = $this->input->post('dasar_penilaian');
        $data_dasar = [
            'nama_dasar_penilaian' => $dasar
        ];
        $this->db->set($data_dasar);
        $this->db->where('id_dasar_penilaian', $id);
        $this->db->update('dasar_penilaian');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Dasar penilaian berhasil diperbarui</div>');
        redirect('kemahasiswaan/kategori');
    }

    public function hapusDasarPenilaian($id)
    {
        $this->db->where('id_dasar_penilaian', intval($id));
        $this->db->delete('semua_prestasi');

        $this->db->where('id_dasar_penilaian', intval($id));
        $this->db->delete('dasar_penilaian');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Dasar penilaian berhasil dihapus</div>');
        redirect('kemahasiswaan/kategori');
    }
    /**Akhir method kahris */

    public function exportBeasiswa()
    {
        $this->load->model("Model_kemahasiswaan", "kemahasiswaan");
        $data['beasiswa'] = $this->kemahasiswaan->getBeasiswa();
        $data['title'] = 'Beasiswa';
        $this->load->view("kemahasiswaan/export_beasiswa", $data);
    }

    public function tambahBeasiswa()
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['beasiswa'] = $this->db->get('beasiswa')->result_array();
        $data['notif'] = $this->_notifKmhs();
        // set rules form validation
        $this->form_validation->set_rules('nimMahasiswa', 'Nim Beasiswa', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Beasiswa";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("kemahasiswaan/tambah_beasiswa");
            $this->load->view("template/footer");
        } else {
            $mahasiswa = $this->db->get_where('Mahasiswa', ['nim' => $this->input->post('nimMahasiswa')])->data_seek();
            if (!$mahasiswa) {
                $this->session->set_flashdata('failed', 'Beasiswa gagal ditambahkan, Nim Mahasiswa Salah!');
                redirect("Kemahasiswaan/tambahBeasiswa");
            }

            $beasiswa = [
                "id_beasiswa" => $this->input->post('jenisBeasiswa'),
                "nim" => $this->input->post('nimMahasiswa'),
                "tahun_menerima" => $this->input->post('tahunMenerima'),
                "lama_menerima" => $this->input->post('lamaMenerima'),
                "nama_instansi" => $this->input->post('namaInstansi'),
                "nominal" => $this->input->post('nominalBeasiswa'),
                "validasi_beasiswa" => 0
            ];
            // upload file proposal
            if ($_FILES['lampiran']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/beasiswa/';
                $config['file_name'] = time() . '_lampiran_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('lampiran')) {
                    $beasiswa['lampiran'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'Beasiswa gagal ditambahkan !');
                    redirect("Kemahasiwaan/beasiswa");
                }
            }

            // upload file proposal
            if ($_FILES['uploadBukti']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/beasiswa/';
                $config2['file_name'] = time() . '_bukti_penerimaan_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('uploadBukti')) {
                    $beasiswa['bukti'] = $this->upload->data('file_name');
                } else {
                    unlink(FCPATH . "file_bukti/beasiswa/" .  $beasiswa['lampiran']);
                    $this->session->set_flashdata('failed', 'Beasiswa gagal ditambahkan !');
                    redirect("Kemahasiswaan/beasiswa");
                }
            }
            $this->session->set_flashdata('message', 'Beasiswa berhasil ditambah !');
            $this->mahasiswa->insertBeasiswa($beasiswa);
            redirect('Kemahasiswaan/beasiswa');
        }
    }

    public function editBeasiswa($id)
    {
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $data['beasiswa'] = $this->db->get('beasiswa')->result_array();
        $data['penerima'] = $this->db->get_where('penerima_beasiswa', ['id_penerima' => $id])->row_array();
        $data['notif'] = $this->_notifKmhs();
        // set rules form validation
        $this->form_validation->set_rules('nimMahasiswa', 'Nim Beasiswa', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Beasiswa";
            $this->load->view("template/header", $data);
            $this->load->view("template/navbar");
            $this->load->view("template/sidebar", $data);
            $this->load->view("kemahasiswaan/edit_beasiswa");
            $this->load->view("template/footer");
        } else {
            $mahasiswa = $this->db->get_where('Mahasiswa', ['nim' => $this->input->post('nimMahasiswa')])->data_seek();
            if (!$mahasiswa) {
                $this->session->set_flashdata('failed', 'Beasiswa gagal diperbaharui, Nim Mahasiswa Salah!');
                redirect("Kemahasiswaan/tambahBeasiswa");
            }

            $beasiswa = [
                "id_beasiswa" => $this->input->post('jenisBeasiswa'),
                "nim" => $this->input->post('nimMahasiswa'),
                "tahun_menerima" => $this->input->post('tahunMenerima'),
                "lama_menerima" => $this->input->post('lamaMenerima'),
                "nama_instansi" => $this->input->post('namaInstansi'),
                "nominal" => $this->input->post('nominalBeasiswa')
            ];
            // upload file proposal
            if ($_FILES['lampiran']['name']) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '2048'; //kb
                $config['upload_path'] = './file_bukti/beasiswa/';
                $config['file_name'] = time() . '_lampiran_' . $this->session->userdata('username');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('lampiran')) {
                    unlink(FCPATH . "file_bukti/beasiswa/" .   $data['penerima']['lampiran']);
                    $beasiswa['lampiran'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'Beasiswa gagal diperbaharui !');
                    redirect("Kemahasiwaan/beasiswa");
                }
            }

            // upload file proposal
            if ($_FILES['uploadBukti']['name']) {
                $config2['allowed_types'] = 'pdf';
                $config2['max_size']     = '2048'; //kb
                $config2['upload_path'] = './file_bukti/beasiswa/';
                $config2['file_name'] = time() . '_bukti_penerimaan_' . $this->session->userdata('username');
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);
                if ($this->upload->do_upload('uploadBukti')) {
                    unlink(FCPATH . "file_bukti/beasiswa/" .   $data['penerima']['bukti']);
                    $beasiswa['bukti'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('failed', 'Beasiswa gagal diperbaharui !');
                    redirect("Kemahasiswaan/beasiswa");
                }
            }
            $this->session->set_flashdata('message', 'Beasiswa berhasil diperbaharui !');
            $this->mahasiswa->updateBeasiswa($beasiswa, $id);
            redirect('Kemahasiswaan/beasiswa');
        }
    }

    // Validasi Rancangan Anggota Lembaga
    public function daftarLembaga()
    {
        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['lembaga'] = $this->kemahasiswaan->getInfoLembaga(1);
        // $data['filter'] = $this->kegiatan->getDataFilterRancangan();
        $data['filter'] = [];
        $this->db->select('periode');
        $this->db->from('pengajuan_anggota_lembaga');
        $this->db->group_by('periode');
        $data['filter']['tahun'] = $this->db->get()->result_array();
        // var_dump($data['filter']);
        // die;
        // $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $this->session->userdata('username')])->row_array();
        $data['notif'] = $this->_notifKmhs();
        if ($this->input->get('tahun') != null || $this->input->get('lembaga') != null || $this->input->get('status') != null || $this->input->get('aktif') != null) {
            $tahun = $this->input->get('tahun');
            $lembaga = $this->input->get('lembaga');
            $valid =  $this->input->get('status');
            $aktif =  $this->input->get('aktif');
            // $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan($tahun, $lembaga, $status);
            if ($this->input->get('tahun') != null) {
                $this->db->where('periode', $tahun);
            }
            if ($this->input->get('lembaga') != null) {
                $this->db->where('lembaga.id_lembaga', intval($lembaga));
            }
            if ($this->input->get('status') != null) {
                $this->db->where('status_validasi', $valid);
            }
            if ($this->input->get('aktif') != null) {
                $this->db->where('status_keaktifan', $aktif);
            }
            $this->db->from('pengajuan_anggota_lembaga');
            $this->db->join('lembaga', 'pengajuan_anggota_lembaga.id_lembaga = lembaga.id_lembaga');
            $data['pengajuan'] = $this->db->get()->result_array();
        } else {
            // $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan();
            $this->db->where('periode', 2020);
            $this->db->from('pengajuan_anggota_lembaga');
            $this->db->join('lembaga', 'pengajuan_anggota_lembaga.id_lembaga = lembaga.id_lembaga');
            $data['pengajuan'] = $this->db->get()->result_array();
        }

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        if ($this->session->userdata('user_profil_kode') == 9) {
            $this->load->view("template/sidebar_admin", $data);
        } else {
            $this->load->view("template/sidebar", $data);
        }
        $this->load->view("kemahasiswaan/daftar_lembaga");
        $this->load->view("template/footer");
    }

    public function validasiAnggotaLembaga($id_pengajuan)
    {
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_validasi' => 1, 'tanggal_validasi' => date('Y-m-d')]);

        $this->session->set_flashdata('message', 'Anggota Lembaga berhasil divalidasi !');
        redirect("Kemahasiswaan/daftarLembaga");
    }
    public function unvalidasiAnggotaLembaga($id_pengajuan)
    {
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_validasi' => 0]);

        $this->session->set_flashdata('message', 'Anggota Lembaga berhasil divalidasi !');
        redirect("Kemahasiswaan/daftarLembaga");
    }


    public function validasiKeaktifanAnggota($id_pengajuan)
    {
        $this->db->where('id', intval($id_pengajuan));
        $this->db->update('pengajuan_anggota_lembaga', ['status_keaktifan' => 1]);

        $pengajuan = $this->db->get_where('pengajuan_anggota_lembaga', ['id' => intval($id_pengajuan)])->row_array();

        $tahun_temp = $pengajuan['periode'] . "-02-01";

        // Tambahkan SKP ke masing" anggota
        $this->db->where('id_pengajuan_anggota_lembaga', intval($id_pengajuan));
        $this->db->from('daftar_anggota_lembaga');
        $this->db->join('semua_prestasi', 'daftar_anggota_lembaga.id_sm_prestasi = semua_prestasi.id_semua_prestasi');
        $anggota_lembaga = $this->db->get()->result_array();
        $tgl_selesai = $pengajuan['periode'] . "-11-30";
        $anggota_status_aktif = [];
        $mahasiswa = [];
        for ($i = 0; $i < count($anggota_lembaga); $i++) {
            $data = [
                'nim' => $anggota_lembaga[$i]['nim'],
                'nama_kegiatan' => 'Keanggotaan Lembaga',
                'tgl_pengajuan' => date('Y-m-d'),
                'tgl_pelaksanaan' => $tahun_temp,
                'tgl_selesai_pelaksanaan' => $tgl_selesai,
                'file_bukti' => 'sk_lembaga/' . $pengajuan['bukti_pengajuan'],
                'tempat_pelaksanaan' => 'FEB UB',
                'validasi_prestasi' => 1,
                'prestasiid_prestasi' => intval($anggota_lembaga[$i]['id_sm_prestasi']),
                'nilai_bobot' => $anggota_lembaga[$i]['status_aktif']
            ];
            $this->db->where('nim', $anggota_lembaga[$i]['nim']);
            $mahasiswa_temp = $this->db->get('mahasiswa')->row_array();
            $poin_skp_sementara = intval($mahasiswa_temp['total_poin_skp']);
            $poin_tambahan = intval($anggota_lembaga[$i]['bobot']) * floatval($anggota_lembaga[$i]['status_aktif']);

            $data2 = [
                'nim' => $anggota_lembaga[$i]['nim'],
                'total_poin_skp' => $poin_skp_sementara + $poin_tambahan
            ];
            array_push($mahasiswa, $data2);
            array_push($anggota_status_aktif, $data);
        }
        // Header('Content-type: application/json');
        // echo json_encode($anggota_status_aktif);
        // die;
        // Update total SKP
        $this->db->update_batch('mahasiswa', $mahasiswa, 'nim');

        $this->db->insert_batch('poin_skp', $anggota_status_aktif);

        $this->session->set_flashdata('message', 'Keaktifan Anggota Lembaga berhasil divalidasi !');
        redirect("Kemahasiswaan/daftarLembaga");
    }

    public function tambahJenisBeasiswa()
    {
        $this->db->set('jenis_beasiswa', $this->input->post('jenis_beasiswa'));
        $this->db->insert('beasiswa');
        $this->session->set_flashdata('message', 'Jenis Beasiswa Berhasil Ditambah');
        redirect("Kemahasiswaan/beasiswa");
    }

    public function hapusJenisBeasiswa($id)
    {
        $this->db->delete('beasiswa', ['id' => $id]);
        $this->session->set_flashdata('message', 'Jenis Beasiswa Berhasil Dihapus');
        redirect("Kemahasiswaan/beasiswa");
    }

    public function editJenisBeasiswa($id)
    {
        $this->db->set('jenis_beasiswa', $this->input->post('jenis_beasiswa'));
        $this->db->where('id', $id);
        $this->db->update('beasiswa');
        $this->session->set_flashdata('message', 'Jenis Beasiswa Berhasil Diubah');
        redirect("Kemahasiswaan/beasiswa");
    }

    // cetak poin skp
    public function cetakSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $nim = $this->input->get("nim");
        $data['bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa($nim);
        $data['poinskp'] = $this->poinskp->getPoinSkp($nim);
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        // QR Code
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']        = './assets/'; //string, the default is application/cache/
        $config['errorlog']        = './assets/'; //string, the default is application/logs/
        $config['imagedir']        = 'assets/qrcode/'; //direktori penyimpanan qr code
        $config['quality']        = true; //boolean, the default is true
        $config['size']            = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = 'bukti_skp_' . $nim . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = base_url("API_skp/cetakSkp?nim=" . $nim); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $this->load->view('mahasiswa/tampilan_transkrip_poin', $data);
    }

    // export skp to excel
    public function exportSkp()
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $this->load->model('Model_mahasiswa', 'mahasiswa');
        $nim = $this->input->get("nim");
        $data['bidang'] = $this->db->get('bidang_kegiatan')->result_array();
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();
        $data['mahasiswa'] = $this->mahasiswa->getDataMahasiswa();
        $data['poinskp'] = $this->poinskp->getPoinSkp();

        $result = array();
        foreach ($data['poinskp'] as $element) {
            $result[$element['nim']][] = $element;
        }
        $data['kegiatan'] = $result;
        $this->load->view('kemahasiswaan/export_skp', $data);
    }


    // menampilkan pengaturan file download
    public function daftarFileDownload()
    {
        $data['title'] = 'Pengaturan File Download';
        $data['notif'] = $this->_notifKmhs();
        $data['file_download'] = $this->db->get('file_download')->result_array();
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/manage_file_download");
        $this->load->view("template/footer");
    }


    public function tambahFileDownload()
    {
        $data = [
            'nama_file' => $this->input->post('nama_file'),
            'status_file' => $this->input->post('status_file'),
            'dilihat_oleh' => $this->input->post('dilihat_oleh')
        ];

        if ($_FILES['dir_file']['name']) {
            $config['allowed_types'] = 'pdf|png|jpg|jpeg|doc|docx';
            $config['max_size']     = '9048'; //kb
            $config['upload_path'] = './file_bukti/file_download/';
            $config['file_name'] = time() . '_download';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('dir_file')) {
                $data['dir_file'] = $this->upload->data('file_name');
                $this->db->insert('file_download', $data);
                $this->session->set_flashdata('message', 'File Download berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('failed', 'File Download gagal ditambahkan!');
                redirect("Kemahasiswaan/daftarFileDownload");
            }
            redirect("Kemahasiswaan/daftarFileDownload");
        }
    }

    public function hapusFileDownload($id)
    {
        $nama_file = $this->input->get('nama_file');
        $this->load->library('upload');
        unlink(FCPATH . "file_bukti/file_download/" . $nama_file);
        $this->db->delete('file_download', ['id_file' => $id]);
        $this->session->set_flashdata('message', 'File Download berhasil dihapus!');
        redirect("Kemahasiswaan/daftarFileDownload");
    }

    public function editFileDownload()
    {
        $data[0] = [
            'id_file' => $this->input->post('id_file'),
            'nama_file' => $this->input->post('nama_file'),
            'status_file' => $this->input->post('status_file'),
            'dilihat_oleh' => $this->input->post('dilihat_oleh')
        ];


        if ($_FILES['dir_file']['name']) {
            $config['allowed_types'] = 'pdf|png|jpg|jpeg|doc|docx';
            $config['max_size']     = '9048'; //kb
            $config['upload_path'] = './file_bukti/file_download/';
            $config['file_name'] = time() . '_download';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('dir_file')) {
                $data[0]['dir_file'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('failed', 'File Download gagal diubah!');
                redirect("Kemahasiswaan/daftarFileDownload");
            }
            unlink(FCPATH . "file_bukti/file_download/" . $this->input->post('dir_lama'));
        } else {
            $data[0]['dir_file'] = $this->input->post('dir_lama');
        }
        $this->db->update_batch('file_download', $data, 'id_file');
        $this->session->set_flashdata('message', 'File Download berhasil diubah!');
        redirect("Kemahasiswaan/daftarFileDownload");
    }

    public function daftarFileExport()
    {
        $this->load->model('Model_kegiatan', 'kegiatan');
        $data['title'] = 'Daftar File Export';
        $data['notif'] = $this->_notifKmhs();
        $temp = $this->kegiatan->getDataFilterRancangan();
        $data['filter'] = $temp['tahun'];

        $this->load->view("template/header", $data);
        $this->load->view("template/navbar");
        $this->load->view("template/sidebar", $data);
        $this->load->view("kemahasiswaan/daftar_file_export");
        $this->load->view("template/footer");
    }

    public function uploadKop()
    {
        $dir = "assets/img/kop";

        // Sort in ascending order - this is default
        $file = scandir($dir, 1);

        if ($_FILES['kop']['name']) {
            $config['allowed_types'] = 'png';
            $config['max_size']     = '1024'; //kb
            $config['upload_path'] = './assets/img/kop/';
            $config['file_name'] = 'kop.png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('kop')) {
                foreach ($file as $f) {
                    if ($f != ".." || $f != ".") {
                        unlink(FCPATH . "assets/img/kop/" . $f);
                    }
                }
                $this->upload->do_upload('kop');
                $this->session->set_flashdata('message', 'KOP berhasil diubah!');
            } else {
                $this->session->set_flashdata('failed', 'KOP gagal diubah!');
            }
        } else {
            $this->session->set_flashdata('failed', 'KOP tidak ditemukan!');
        }
        redirect("Kemahasiswaan/daftarFileDownload");
    }
}
