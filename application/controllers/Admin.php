<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    private $id_user;
    private $data_user;

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Model_admin', 'admin');
        $this->load->library('form_validation');
    }


    public function template($data)
    {
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar", $data);
        $this->load->view("template/sidebar_admin", $data);
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['jumlah_mahasiswa'] = count($this->db->get('mahasiswa')->result_array());
        $this->db->where_in('user_profil_kode', [2, 3]);
        $data['jumlah_lembaga'] = count($this->db->get('user')->result_array());
        $this->template($data);
        $this->load->view("dashboard/dashboard_admin");
        $this->load->view("template/footer");
    }

    public function ManagementUser()
    {
        $data['title'] = "Manajemen User";
        $data['user'] = $this->admin->getDataUser();
        $this->template($data);
        $this->load->view("admin/manajemen_user");
        $this->load->view("template/footer");
    }
    public function statusAktif($data)
    {
        if ($data == 1) {
            return "Aktif";
        } else {
            return "Tidak Aktif";
        }
    }
    public function tambahUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username sudah digunakan!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password tidak sesuai!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Tambah User";
            $data['status_user'] =  $this->db->get('user_profil')->result_array();
            $this->template($data);
            $this->load->view("admin/tambah_user");
            $this->load->view("template/footer");
        } else {

            $data_user = [
                'username' => $this->input->post('username'),
                'nama' => $this->input->post('nama'),
                'user_profil_kode' => intval($this->input->post('status_user')),
                'is_active' => intval($this->input->post('status_aktif')),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT)
            ];

            $temp = $this->db->get_where('user', ['username' => $data_user['username']])->data_seek();
            if (!$temp) {
                if ($data_user['user_profil_kode'] == 1) {
                    $data_mahasiswa = [
                        'nim' => $this->input->post('username'),
                        'nama' => $this->input->post('nama'),
                        'kode_prodi' => intval($this->input->post('prodi'))
                    ];
                    $this->db->insert('mahasiswa', $data_mahasiswa);

                    $this->session->set_flashdata('message', 'User Mahasiswa berhasil ditambahkan');
                    redirect('admin/ManagementUser');
                } elseif ($data_user['user_profil_kode'] == 2 || $data_user['user_profil_kode'] == 3) {
                    $data_lembaga = [
                        'id_lembaga' => $this->input->post('username'),
                        'jenis_lembaga' => $this->input->post('jenis_lembaga'),
                        'nama_lembaga' => $this->input->post('nama'),
                        'nama_ketua' => $this->input->post('ketua_lembaga'),
                        'no_hp_lembaga' => $this->input->post('no_hp'),
                    ];
                    $this->db->insert('lembaga', $data_lembaga);
                }

                $this->db->insert('user', $data_user);
                $this->session->set_flashdata('message', 'User berhasil ditambahkan');
                redirect('admin/ManagementUser');
            } else {
                $this->session->set_flashdata('failed', 'Tidak bisa menambahkan, Username sudah ada');
                redirect('admin/ManagementUser');
            }
        }
    }

    public function editUser($username)
    {
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password tidak sesuai!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit User";
            $data['status_user'] =  $this->db->get('user_profil')->result_array();
            $data['user'] = $this->db->get_where('user', ['username' => $username])->row_array();
            if ($data['user']['user_profil_kode'] == 1) {
                $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['nim' => $username])->row_array();
                $data['prodi'] = $this->db->get('prodi')->result_array();
            } else if ($data['user']['user_profil_kode'] == 2 || $data['user']['user_profil_kode'] == 3) {
                $data['lembaga'] = $this->db->get_where('lembaga', ['id_lembaga' => $username])->row_array();
            }
            $this->template($data);
            $this->load->view("admin/edit_user");
            $this->load->view("template/footer");
        } else {

            $data_user = [
                'nama' => $this->input->post('nama'),
                'user_profil_kode' => intval($this->input->post('status_user')),
                'is_active' => intval($this->input->post('status_aktif')),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT)
            ];

            $temp = $this->db->get_where('user', ['username' => $data_user['username']])->data_seek();
            if (!$temp) {
                if ($data_user['user_profil_kode'] == 1) {
                    $data_mahasiswa = [
                        'nim' => $this->input->post('username'),
                        'nama' => $this->input->post('nama'),
                        'kode_prodi' => intval($this->input->post('prodi')),
                        'alamat_kos' => $this->input->post('alamat_kos'),
                        'alamat_rumah' => $this->input->post('alamat_rumah'),
                        'email' => $this->input->post('email'),
                        'nomor_hp' => $this->input->post('no_hp')
                    ];
                    $this->admin->updateDataMahasiswa($data_mahasiswa, $username);
                } elseif ($data_user['user_profil_kode'] == 2 || $data_user['user_profil_kode'] == 3) {
                    $data_lembaga = [
                        'id_lembaga' => $this->input->post('username'),
                        'jenis_lembaga' => $this->input->post('jenis_lembaga'),
                        'nama_lembaga' => $this->input->post('nama'),
                        'nama_ketua' => $this->input->post('ketua_lembaga'),
                        'no_hp_lembaga' => $this->input->post('no_hp'),
                    ];
                    $this->admin->updateDataLembaga($data_lembaga, $username);
                }

                $this->admin->updateDataUser($data_user, $username);
                $this->session->set_flashdata('message', 'User berhasil diperbaharui');
                redirect('admin/ManagementUser');
            } else {
                $this->session->set_flashdata('failed', 'Tidak bisa diperbaharui, Username sudah ada');
                redirect('admin/ManagementUser');
            }
        }
    }

    public function hapusUser($id)
    {
        $user = $this->db->get_where('user', ['id_user' => $id])->row_array();
        if ($user['user_profil_kode'] == 1) {
            $this->db->where('nim', $user['username']);
            $this->db->delete('mahasiswa');
        } else if ($user['user_profil_kode'] == 2 || $user['user_profil_kode'] == 3) {
            $this->db->where('id_lembaga', $user['username']);
            $this->db->delete('lembaga');
        }
        $cek = $this->admin->deleteDataUser($id);
        if ($cek == 1) {
            $this->session->set_flashdata('message',  'User Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('failed',  'User memiliki foregin key pada tabel validasi!');
        }
        redirect('admin/ManagementUser');
    }

    public function getStatusUser()
    {
        $data = $this->db->get('user_profil')->result_array();
        echo json_encode($data);
    }
    public function getUser($id)
    {
        $this->db->where('id_user', intval($id));
        $this->db->select('id_user, nama, username, user.user_profil_kode, jenis_user, is_active');
        $this->db->from('user');
        $this->db->join('user_profil', 'user.user_profil_kode = user_profil.user_profil_kode');
        $data['user'] = $this->db->get()->row_array();
        $data['status_user'] = $this->db->get('user_profil')->result_array();
        header('Content-type:application/json');
        echo json_encode($data);
    }

    public function getProdi()
    {
        $data = $this->db->get('prodi')->result_array();
        header('Content-type:application/json');
        echo json_encode($data);
    }
    public function getMahasiswa()
    {
        $data = $this->db->get('mahasiswa')->result_array();
        header('Content-type:application/json');
        echo json_encode($data);
    }

    public function getProfilUser()
    {
        $data = $this->db->get('user_profil')->result_array();
        header('Content-type:application/json');
        echo json_encode($data);
    }
    public function importData()
    {
        // upload file xls
        $target = basename($_FILES['import-data']['name']);
        if ($_FILES['import-data']['name']) {
            $config['allowed_types'] = 'xls';
            $config['max_size']     = '2048'; //kb
            $config['upload_path'] = './berkas/';
            $config['overwrite'] = true;
            $config['file_name'] = $_FILES['import-data']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('import-data');
        };

        // beri permisi agar file xls dapat di baca
        chmod('./berkas/' .  $target, 0777);
        // mengambil isi file xls
        $path = './berkas/' .  $target;
        $data = new Spreadsheet_Excel_Reader($path, false);
        // menghitung jumlah baris data yang ada
        $jumlah_baris = $data->rowcount($sheet_index = 0);
        $input_data = [];
        for ($i = 3; $i < $jumlah_baris; $i++) {
            // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
            $result = [
                "nim" => str_replace("\0", "", $data->val($i, 2)),
                "nama" => str_replace("\0", "", $data->val($i, 3)),
                "total_poin_skp" => intval(str_replace("\0", "", $data->val($i, 4))),
                "alamat_kos" => str_replace("\0", "", $data->val($i, 5)),
                "alamat_rumah" => str_replace("\0", "", $data->val($i, 6)),
                "email" => str_replace("\0", "", $data->val($i, 7)),
                "kode_prodi" => intval($data->val($i, 8)),
                "nomor_hp" => str_replace("\0", "", $data->val($i, 9)),
            ];
            array_push($input_data, $result);
        };
        $this->db->insert_batch('mahasiswa', $input_data);
        // hapus kembali file .xls yang di upload tadi
        unlink($path);
        // alihkan halaman ke index.php
        $this->session->set_flashdata('message', 'Impor data Mahasiswa berhasil');
        redirect('Admin/ManagementUser');
    }

    // pimpinan FEB
    public function daftarPimpinan()
    {
        $data['pimpinan'] = $this->db->get('list_pimpinan')->result_array();
        $data['title'] = "Daftar Pimpinan";
        $this->template($data);
        $this->load->view("admin/daftar_pimpinan");
        $this->load->view("template/footer");
    }

    public function editPimpinan($id)
    {
        $this->form_validation->set_rules('nip', 'Nip', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Pimpinan";
            $data['pimpinan'] = $this->db->get_where('list_pimpinan', ['id' => $id])->row_array();
            $this->template($data);
            $this->load->view("admin/edit_pimpinan");
            $this->load->view("template/footer");
        } else {

            $data_pimpinan = [
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
            ];
            $this->admin->updateDataPimpinan($data_pimpinan, $id);
            $this->session->set_flashdata('message', 'Data Pimpinan berhasil diperbaharui');
            redirect('admin/daftarPimpinan');
        }
    }
}
