<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('user_profil_kode');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'user_profil_kode' => $role_id,
            'menu_id' => $menu_id
        ]);
        // var_dump($userAccess->num_rows());
        // die;

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function link_dashboard($user_profil_kode)
{
    if ($user_profil_kode == 1) {
        return "Mahasiswa";
    } else if ($user_profil_kode == 2) {
        return "Kegiatan";
    } else if ($user_profil_kode == 3) {
        return "";
    } else if ($user_profil_kode == 4) {
        return "Kemahasiswaan";
    } else if ($user_profil_kode == 5) {
        return "Pimpinan";
    } else if ($user_profil_kode == 6) {
        return "Keuangan";
    } else if ($user_profil_kode == 7) {
        return "Publikasi";
    } else if ($user_profil_kode == 8) {
        return "Akademik";
    } else if ($user_profil_kode == 9) {
        return "Admin";
    }
}
