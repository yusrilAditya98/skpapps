<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH .  "/vendor/autoload.php";

use Araditama\AuthSIAM\AuthSIAM;

class Auth extends CI_Controller
{
    private $username = "cek";
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'SKP-APPS Login';
            $this->load->view('auth/login', $data);
        } else {
            // validasi success
            $this->_login();
        }
    }
    private function _login()
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
        $result = $auth->auth($data);
        if ($result['msg']) {
            $data = [
                "username" => $result['data']['nim'],
                "status_user_id" => $result['data']['status']
            ];
            $this->session->set_userdata($data);
            redirect('Mahasiswa');
            var_dump($data);
        } else {

            $user = $this->db->get_where('user', ['username' => $this->username])->row_array();
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($this->password, $user['password'])) {
                    $data = [
                        'username' => $user['username'],
                        'user_profile_kode' => $user['user_profile_kode']
                    ];

                    $this->session->set_userdata($data);
                    if ($user['status_user_id'] == 2) { } elseif ($user['status_user_id'] == 3) { } elseif ($user['status_user_id'] == 4) { } elseif ($user['status_user_id'] == 5) { }
                } else {
                    $this->session->set_flashdata('message', '<div class="px-5 alert alert-danger text-center" role="alert">Wrong Password !</div> ');
                    redirect('auth');
                }
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('username');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center align-middle mb-3" role="alert"><p>Logout berhasil</p></div>');
        redirect('auth');
    }
    public function blocked()
    {
        $this->load->view('error403');
    }
}
