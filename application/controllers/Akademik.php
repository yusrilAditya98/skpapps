<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akademik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // $this->load->helper('url');
    }

    public function template($data)
    {
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar", $data);
        $this->load->view("template/sidebar", $data);
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['kuliah_tamu'] = $this->db->get('kuliah_tamu')->result_array();
        $data['jumlah_kuliah_tamu'] = count($data['kuliah_tamu']);

        //Update kegiatan terlaksana hari ini
        //Perhitungan H- Kegiatan (dalam hari)
        $tanggal_sekarang = date('Y-m-d');
        for ($i = 0; $i < count($data['kuliah_tamu']); $i++) {
            if ($data['kuliah_tamu'][$i]['tanggal_event'] == $tanggal_sekarang) {
                $this->db->where('id_kuliah_tamu', $data['kuliah_tamu'][$i]['id_kuliah_tamu']);
                $this->db->set('status_terlaksana', 2);
                $this->db->update('kuliah_tamu');
            }
            $awal  = date_create($data['kuliah_tamu'][$i]['tanggal_event']);
            $akhir = date_create(); // waktu sekarang
            $diff  = date_diff($awal, $akhir);
            $beda_hari = $diff->days;
            $data['kuliah_tamu'][$i]['H-'] = $beda_hari;
        }

        //Penentuan kegiatan dengan waktu terdekat (belum terlaksana)
        $kegiatan_terdekat = '';
        for ($i = 0; $i < count($data['kuliah_tamu']); $i++) {
            if ($data['kuliah_tamu'][$i]['status_terlaksana'] == 0) {
                if ($kegiatan_terdekat == '') {
                    $kegiatan_terdekat = $data['kuliah_tamu'][$i];
                } else {
                    if ($kegiatan_terdekat['H-'] > $data['kuliah_tamu'][$i]['H-']) {
                        $kegiatan_terdekat = $data['kuliah_tamu'][$i];
                    }
                }
            }
        }

        $kegiatan_terdekat['tanggal_event'] = $this->tgl_indo($kegiatan_terdekat['tanggal_event']);
        $data['kegiatan_terdekat'] = $kegiatan_terdekat;

        $data['jumlah_peserta_kuliah_tamu_terdekat'] = count($this->db->get_where('peserta_kuliah_tamu', ['id_kuliah_tamu' => $data['kegiatan_terdekat']['id_kuliah_tamu']])->result_array());


        $this->template($data);
        $this->load->view("dashboard/dashboard_akademik", $data);
        $this->load->view("template/footer");
    }
    public function kegiatan()
    {
        $data['title'] = 'Kegiatan';
        $data['kuliah_tamu'] = $this->db->get('kuliah_tamu')->result_array();
        //Update kegiatan terlaksana hari ini
        //Perhitungan H- Kegiatan (dalam hari)
        $tanggal_sekarang = date('Y-m-d');
        for ($i = 0; $i < count($data['kuliah_tamu']); $i++) {
            if ($data['kuliah_tamu'][$i]['tanggal_event'] == $tanggal_sekarang) {
                $this->db->where('id_kuliah_tamu', $data['kuliah_tamu'][$i]['id_kuliah_tamu']);
                $this->db->set('status_terlaksana', 2);
                $this->db->update('kuliah_tamu');
            }
        }
        $this->db->order_by('tanggal_event', 'ASC');
        $data['kegiatan'] = $this->db->get('kuliah_tamu')->result_array();
        $this->template($data);
        $this->load->view("akademik/kegiatan", $data);
        $this->load->view("template/footer");
    }
    public function get_kegiatan($id)
    {
        $this->db->order_by('tanggal_event', 'DESC');
        $this->db->where('id_kuliah_tamu', $id);
        $kegiatan = $this->db->get('kuliah_tamu')->row_array();
        $kegiatan['tanggal_format'] = $kegiatan['tanggal_event'];
        $kegiatan['tanggal_event'] = $this->tgl_indo($kegiatan['tanggal_event']);
        $this->db->where('id_kuliah_tamu', $id);
        $this->db->select('*');
        $this->db->from('peserta_kuliah_tamu');
        $this->db->join('mahasiswa', 'peserta_kuliah_tamu.nim = mahasiswa.nim');
        $this->db->join('prodi', 'mahasiswa.kode_prodi = prodi.kode_prodi');
        $kegiatan['peserta_kegiatan'] = $this->db->get()->result_array();
        echo json_encode($kegiatan);
    }
    function generate_string($input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 5)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    }
    public function tambahKegiatan()
    {
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required|trim', array('required' => 'Nama Kegiatan tidak boleh kosong'));
        $this->form_validation->set_rules('deskripsi_kegiatan', 'Deskripsi Kegiatan', 'required|trim', array('required' => 'Deskripsi Kegiatan tidak boleh kosong'));
        $this->form_validation->set_rules('tanggal_kegiatan', 'Tanggal Kegiatan', 'required|trim', array('required' => 'Tanggal Kegiatan tidak boleh kosong'));
        $this->form_validation->set_rules('pemateri', 'Pemateri Kegiatan', 'required|trim', array('required' => 'Pemateri Kegiatan tidak boleh kosong'));

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Kegiatan';
            $this->template($data);
            $this->load->view("akademik/tambah_kegiatan", $data);
            $this->load->view("template/footer");
        } else {
            // tambahKegiatan Sukses
            $data_kuliah_tamu = [
                'kode_qr' => $this->generate_string(),
                'nama_event' => $this->input->post('nama_kegiatan'),
                'deskripsi' => $this->input->post('deskripsi_kegiatan'),
                'lokasi' => $this->input->post('ruangan'),
                'tanggal_event' => $this->input->post('tanggal_kegiatan'),
                'id_prestasi' => 115,
                'waktu_mulai' => $this->input->post('waktu_kegiatan_mulai'),
                'waktu_selesai' => $this->input->post('waktu_kegiatan_selesai'),
                // 'poster' => $this->input->post('kodeUjian'),
                'pemateri' => $this->input->post('pemateri')
            ];

            // echo "HAI";
            // header('Content-type: application/json');
            // echo json_encode($data_kuliah_tamu);
            // var_dump($data_kuliah_tamu);
            // die;

            // Tambah Penguji dengan dosen pembimbing
            // if ($_FILES['buktiUjian']['name']) {
            //     $dataUjian['bukti_ujian'] = $_FILES['buktiUjian']['name'];
            //     $config['allowed_types'] = 'jpg|png|pdf';
            //     $config['max_size']     = '2048'; //kb
            //     $config['upload_path'] = './assets/ujian/';
            //     $config['file_name'] = time() . '_' . $data['user_login']['nim'] . '_' . $dataUjian['bukti_ujian'];
            //     $this->load->library('upload', $config);
            //     if ($this->upload->do_upload('buktiUjian')) {
            //         $dataUjian['bukti_ujian'] = $this->upload->data('file_name');
            //     } else {
            //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Data ujian gagal di tambah ! </div>');
            //         echo $this->upload->display_errors();
            //     }
            // }

            $this->db->insert('kuliah_tamu', $data_kuliah_tamu);

            $kuliah_tamu = $this->db->get_where('kuliah_tamu', ['kode_qr' => $data_kuliah_tamu['kode_qr']])->row_array();

            $id_kegiatan = $kuliah_tamu['id_kuliah_tamu'];

            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']        = './assets/'; //string, the default is application/cache/
            $config['errorlog']        = './assets/'; //string, the default is application/logs/
            $config['imagedir']        = 'assets/qrcode/'; //direktori penyimpanan qr code
            $config['quality']        = true; //boolean, the default is true
            $config['size']            = '1024'; //interger, the default is 1024
            $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
            $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name = 'kuliah_tamu_' . $data_kuliah_tamu['kode_qr'] . '.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = "http://192.168.42.114/skpapps/API_skp/gabungKegiatan/" . $id_kegiatan; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            // QRcode::png('http://localhost/skpapps/mahasiswa/gabungKegiatan/1');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil ditambahkan</div>');
            redirect('akademik/kegiatan');
        }
    }

    public function editKegiatan($id_kegiatan)
    {
        $data_kuliah_tamu = [
            // 'kode_qr' => $this->generate_string(),
            'nama_event' => $this->input->post('nama_kegiatan'),
            'deskripsi' => $this->input->post('deskripsi_kegiatan'),
            'lokasi' => $this->input->post('ruangan'),
            'tanggal_event' => $this->input->post('tanggal_kegiatan'),
            'waktu_mulai' => $this->input->post('waktu_kegiatan_mulai'),
            'waktu_selesai' => $this->input->post('waktu_kegiatan_selesai'),
            // 'poster' => $this->input->post('kodeUjian'),
            'pemateri' => $this->input->post('pemateri')
        ];

        $this->db->set($data_kuliah_tamu);
        $this->db->where('id_kuliah_tamu', $id_kegiatan);
        $this->db->update('kuliah_tamu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil diperbarui</div>');
        redirect('akademik/kegiatan');
    }

    public function hapusKegiatan($id_kegiatan)
    {

        // Hapus QR
        $kuliah_tamu = $this->db->get_where('kuliah_tamu', ['id_kuliah_tamu' => $id_kegiatan])->row_array();
        $kode_qr = $kuliah_tamu['kode_qr'];
        define('EXT', '.' . pathinfo(__FILE__, PATHINFO_EXTENSION));
        define('PUBPATH', str_replace(SELF, '', FCPATH)); // added
        $image_location = PUBPATH . 'assets/qrcode/kuliah_tamu_' . $kode_qr . '.png';

        unlink($image_location);
        // var_dump($image_location);
        // die;

        $this->db->where('id_kuliah_tamu', intval($id_kegiatan));
        $this->db->delete('peserta_kuliah_tamu');

        $this->db->where('id_kuliah_tamu', intval($id_kegiatan));
        $this->db->delete('kuliah_tamu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil dihapus</div>');
        redirect('akademik/kegiatan');
    }

    public function generate_qr()
    {
        $data_kuliah_tamu = $this->db->get('kuliah_tamu')->result_array();
        for ($i = 0; $i < count($data_kuliah_tamu); $i++) {
            $id_kegiatan = $data_kuliah_tamu[$i]['id_kuliah_tamu'];

            // echo $id_kegiatan;
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']        = './assets/'; //string, the default is application/cache/
            $config['errorlog']        = './assets/'; //string, the default is application/logs/
            $config['imagedir']        = 'assets/qrcode/'; //direktori penyimpanan qr code
            $config['quality']        = true; //boolean, the default is true
            $config['size']            = '1024'; //interger, the default is 1024
            $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
            $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name = 'kuliah_tamu_' . $data_kuliah_tamu[$i]['kode_qr'] . '.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = "http://192.168.42.114/skpapps/API_skp/gabungKegiatan/" . $id_kegiatan; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        }
    }
    public function validasiKegiatan()
    {
        $data = $this->input->post('validasi');
        if ($data == null) {
            echo "HAHA";
        } else {
            // echo json_encode($data[1]);
            // die;
            for ($i = 0; $i < count($data); $i++) {
                $this->db->set('kehadiran', 1);
                $this->db->where('id_peserta_kuliah_tamu', intval($data[$i]));
                $this->db->update('peserta_kuliah_tamu');

                $mahasiswa = $this->db->get_where('peserta_kuliah_tamu', ['id_peserta_kuliah_tamu' => intval($data[$i])])->row_array();
                $data_poin_skp = [
                    'nim' => $mahasiswa['nim'],
                    'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                    'validasi_prestasi' => 1,
                    'tgl_pelaksanaan' => $this->input->post('tgl_pelaksanaan'),
                    'tempat_pelaksanaan' => $this->input->post('tempat_pelaksanaan'),
                    'id_prestasi' => 115
                ];
                // header('Content-type: application/json');
                // echo json_encode($data_poin_skp);
                // die;
                $this->db->insert('poin_skp', $data_poin_skp);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Validasi berhasil</div>');
            redirect('akademik/kegiatan');
        }
    }
}
