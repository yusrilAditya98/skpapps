<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->load->view('auth/login');
    }
    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['username' => $username])->row_array();

        // Cek ketersediaan user
        if ($user) {
            // cek password
            if (password_verify($password, $user['password'])) {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('status_user', $user['status_user']);
                if ($user['status_user'] == 0) {
                    redirect('admin');
                } else {
                    redirect('operator');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center align-middle mb-3" role="alert"><p>Password salah !</p></div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center align-middle mb-3" role="alert"><p>Username tidak terdaftar !</p></div>');
            redirect('auth');
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
