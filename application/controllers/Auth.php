<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH .  "/vendor/autoload.php";

use Araditama\AuthSIAM\AuthSIAM;

class Auth extends CI_Controller
{
    private $username;
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('user_profil_kode')) {
            redirect(link_dashboard($this->session->userdata('user_profil_kode')));
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'SKP-APPS Login';
            $this->load->view('auth/login', $data);
        } else {
            // validasi success
            $this->_login_siam();
        }
    }

    public function login()
    {
        if ($this->session->userdata('user_profil_kode')) {
            redirect(link_dashboard($this->session->userdata('user_profil_kode')));
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'SKP-APPS Login Staff';
            $this->load->view('auth/login_staff', $data);
        } else {
            // validasi success
            $this->_login();
        }
    }
    // login by non-siam accounts
    private function _login()
    {
        $this->username = $this->input->post('username');
        $this->password = $this->input->post('password');
        // contoh array dari credentials yang akan diproses
        // memanggil method auth dari objek yang telah dibuat dengan method GET
        $user = $this->db->get_where('user', ['username' => $this->username])->row_array();
        if ($user != null) {
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($this->password, $user['password'])) {
                    $data = [
                        'username' => $user['username'],
                        "nama" => $user['nama'],
                        'user_profil_kode' => $user['user_profil_kode']
                    ];

                    $this->session->set_userdata($data);
                    if ($user['user_profil_kode'] == 2 || $user['user_profil_kode'] == 3) {
                        $lembaga = $this->db->get_where('lembaga', ['id_lembaga' => $this->username])->row_array();
                        if ($lembaga) {
                            redirect('Kegiatan');
                        } else {
                            $this->session->unset_userdata('username');
                            $this->session->unset_userdata('nama');
                            $this->session->unset_userdata('user_profil_kode');
                            $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Data lembaga belum terdaftar !</div> ');
                            redirect('Auth/login');
                        }
                    } elseif ($user['user_profil_kode'] == 1) {
                        $mahasiswa = $this->db->get_where('mahasiswa', ['nim' => $this->username])->row_array();
                        if ($mahasiswa) {
                            redirect('Mahasiswa');
                        } else {
                            $this->session->unset_userdata('username');
                            $this->session->unset_userdata('nama');
                            $this->session->unset_userdata('user_profil_kode');
                            $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Data mahasiswa belum terdaftar !</div> ');
                            redirect('Auth/login');
                        }
                    } elseif ($user['user_profil_kode'] == 4) {
                        redirect('Kemahasiswaan');
                    } elseif ($user['user_profil_kode'] == 5) {
                        redirect('Pimpinan');
                    } elseif ($user['user_profil_kode'] == 6) {
                        redirect('Keuangan');
                    } elseif ($user['user_profil_kode'] == 7) {
                        redirect('Publikasi');
                    } elseif ($user['user_profil_kode'] == 8) {
                        redirect('Akademik');
                    } elseif ($user['user_profil_kode'] == 9) {
                        redirect('Admin');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Password salah !</div> ');
                    redirect('Auth/login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Akun belum aktif!</div> ');
                redirect('Auth/login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Data tidak ditemukan !</div> ');
            redirect('Auth/login');
        }
    }
    // login by siam accounts
    private function _login_siam()
    {
        $auth = new AuthSIAM;

        $this->username = $this->input->post('username');
        $this->password = $this->input->post('password');
        // contoh array dari credentials yang akan diproses
        $data = [
            'nim' => $this->username,
            'password' => $this->password
        ];
        // memanggil method auth dari objek yang telah dibuat dengan method GET

        // masuk kesiam 
        $result = $auth->auth($data);

        // masuk secara manual
        // $result = $auth->authManual($data);

        if ($result['msg'] == "true") {
            $mhs = $this->db->get_where('mahasiswa', ['nim' => $result['data']['nim']])->row_array();
            if ($mhs) {
                // data siam
                $data = [
                    "username" => $result['data']['nim'],
                    "nama" => $result['data']['nama'],
                    "user_profil_kode" => $result['data']['status']
                ];

                // data manual
                // $data = [
                //     "username" => $mhs['nim'],
                //     "nama" => $mhs['nama'],
                //     "user_profil_kode" => 1
                // ];
                $this->session->set_userdata($data);
                redirect('Mahasiswa');
            } else {
                $this->session->set_flashdata('message', '<div class="px-5 alert alert-warning text-center" role="alert">Anda belum terdaftar !</div> ');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Data tidak ditemukan !</div> ');
            redirect('Auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('user_profil_kode');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center align-middle mb-3" role="alert"><p>Logout berhasil</p></div>');
        redirect('auth');
    }
    public function blocked()
    {
        $this->load->view('auth/errors-403');
    }

    public function notfound404()
    {
        $this->load->view('auth/errors-404');
    }

    public function phpInfo()
    {
        phpinfo();
    }
}
