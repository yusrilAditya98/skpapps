<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function template($data)
    {
        $this->load->view("template/header", $data);
        $this->load->view("template/navbar", $data);
        $this->load->view("template/sidebar", $data);
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['jumlah_mahasiswa'] = count($this->db->get('mahasiswa')->result_array());
        $data['jumlah_lembaga'] = count($this->db->get_where('user', ['user_profil_kode' => 2])->result_array());
        $this->template($data);
        $this->load->view("dashboard/dashboard_admin");
        $this->load->view("template/footer");
    }

    public function ManagementUser()
    {
        $data['title'] = "Manajemen User";
        $this->db->where('username != ', $this->session->userdata('username'));
        $this->db->select('id_user, nama, username, jenis_user, is_active');
        $this->db->from('user');
        $this->db->join('user_profil', 'user.user_profil_kode = user_profil.user_profil_kode');
        $data['user'] = $this->db->get()->result_array();
        // header('Content-type:application/json');
        // echo json_encode($data['user']);
        // die;
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
        $data_user = [
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'user_profil_kode' => intval($this->input->post('status_user')),
            'is_active' => intval($this->input->post('status_aktif'))
        ];
        $temp = $this->db->get_where('user', ['username' => $data_user['username']])->result_array();
        if (count($temp) == 0) {
            if ($data_user['user_profil_kode'] == 1) {
                $data_mahasiswa = [
                    'nim' => $this->input->post('username'),
                    'nama' => $this->input->post('nama'),
                    'kode_prodi' => intval($this->input->post('prodi'))
                ];
                $this->db->insert('mahasiswa', $data_mahasiswa);
            }
            $this->db->insert('user', $data_user);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil ditambahkan</div>');
            redirect('admin/ManagementUser');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Username sudah ada</div>');
            redirect('admin/ManagementUser');
        }
    }

    public function editUser($id)
    {
        $data_user = [
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'user_profil_kode' => intval($this->input->post('status_user')),
            'is_active' => intval($this->input->post('status_aktif'))
        ];

        $temp = $this->db->get_where('user', ['username' => $data_user['username']])->result_array();
        if (count($temp) == 0) {
            $this->db->set($data_user);
            $this->db->where('id_user', $id);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil diperbarui</div>');
            redirect('admin/ManagementUser');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak bisa menambahkan, Username sudah ada</div>');
            redirect('admin/ManagementUser');
        }
    }

    public function hapusUser($id)
    {
        $this->db->where('id_user', intval($id));
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil dihapus</div>');
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
    public function getProfilUser()
    {
        $data = $this->db->get('user_profil')->result_array();
        header('Content-type:application/json');
        echo json_encode($data);
    }
}
