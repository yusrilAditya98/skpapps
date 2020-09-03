<!-- QUERY MENU -->

<?php
$role_id = $this->session->userdata('user_profil_kode');
$queryMenu = "SELECT `user_menu`.`id`, `menu`
                FROM `user_menu` JOIN `user_access_menu`
                ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                WHERE `user_access_menu`.`user_profil_kode` = $role_id
                ORDER BY `user_access_menu`.`menu_id` ASC
                ";
$menu = $this->db->query($queryMenu)->result_array();
$menuId = [];
$temp = [];
$i = 0;
foreach ($menu as $m) {
    $menuId[$i++] = $m['id'];
}
$j = 0;
foreach ($menuId as $m) {
    $querySubMenu = "SELECT user_sub_menu.* FROM `user_sub_menu` JOIN `user_menu` 
                                ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                            WHERE `user_sub_menu`.`menu_id`= $m
                            ";
    $temp[$j++] = $this->db->query($querySubMenu)->result_array();
}
$k = 0;
foreach ($temp as $t) {
    foreach ($t as $ts) {
        $subMenu[$k++] = $ts;
    }
}
$querySubSubMenu = "SELECT * FROM `user_sub_sub_menu` 
";
$subSubMenu = $this->db->query($querySubSubMenu)->result_array();
?>

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="<?= base_url('assets/img/white_logo.png') ?>" alt="" width="200dp" class="mt-2"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SKP</a>
        </div>
        <?php if ($this->session->userdata("user_profil_kode") != 9) : ?>
            <ul class="sidebar-menu">
                <?php foreach ($menu as $m) : ?>
                    <li class="menu-header mt-2"><?= $m['menu'] ?></li>
                    <?php foreach ($subMenu as $sb) : ?>
                        <?php if ($sb['menu_id'] == $m['id']) : ?>
                            <?php if ($title == $sb['judul']) : ?>
                                <li class="nav-item active dropdown">
                                <?php else : ?>
                                <li class="nav-item dropdown">
                                <?php endif; ?>

                                <?php if ($sb['has_sub'] == 1) : ?>
                                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="<?= $sb['ikon'] ?>"></i><span><?= $sb['judul']  ?></span></a>
                                <?php else : ?>
                                    <a href="<?= base_url() . $sb['url'] ?>" class="nav-link "><i class="<?= $sb['ikon'] ?>"></i><span><?= $sb['judul']  ?></span></a>
                                <?php endif; ?>
                                <ul class="dropdown-menu">
                                    <?php foreach ($subSubMenu as $ssb) : ?>
                                        <?php if ($ssb['id_sub_menu'] == $sb['id']) : ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <a class="nav-link" href="<?= base_url() . $ssb['url'] ?>">
                                                            <?= $ssb['nama'] ?>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4 float-right">

                                                        <?php if ($ssb['id_sub_sub_menu'] == 6 && $notif['notif_bem_proposal'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_bem_proposal'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 7 && $notif['notif_bem_lpj'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_bem_lpj'] ?></span>
                                                        <?php endif; ?>

                                                        <!-- notif rancangan kemahasiswaan-->
                                                        <?php if ($ssb['id_sub_sub_menu'] == 8 && $notif['notif_kmhs_rancangan'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_kmhs_rancangan'] ?></span>
                                                        <?php endif; ?>
                                                        <!-- notif proposal kemahasiswaan-->
                                                        <?php if ($ssb['id_sub_sub_menu'] == 9 && $notif['notif_kmhs_proposal'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_kmhs_proposal'] ?></span>
                                                        <?php endif; ?>
                                                        <!-- notif lpj kemahasiswaan-->
                                                        <?php if ($ssb['id_sub_sub_menu'] == 10 && $notif['notif_kmhs_lpj'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_kmhs_lpj'] ?></span>
                                                        <?php endif; ?>
                                                        <!-- notif skp -->
                                                        <?php if ($ssb['id_sub_sub_menu'] == 11 && $notif['notif_kmhs_skp'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_kmhs_skp'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 12 && $notif['notif_psik_proposal'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_psik_proposal'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 13 && $notif['notif_psik_lpj'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_psik_lpj'] ?></span>
                                                        <?php endif; ?>


                                                        <?php if ($ssb['id_sub_sub_menu'] == 14 && $notif['notif_keuangan_proposal'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_keuangan_proposal'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 15 && $notif['notif_keuangan_lpj'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_keuangan_lpj'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 17 && $notif['notif_kmhs_validasi_anggota_lembaga'] != 0) : ?>
                                                            <span class="badge badge-warning"><?= $notif['notif_kmhs_validasi_anggota_lembaga'] ?></span>
                                                        <?php endif; ?>

                                                        <?php if ($ssb['id_sub_sub_menu'] == 17 && $notif['notif_kmhs_keaktifan_anggota_lembaga'] != 0) : ?>
                                                            <span class="badge badge-success"><?= $notif['notif_kmhs_keaktifan_anggota_lembaga'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                    <li class="menu-header mt-2">Download</li>
                    <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                        <li><a class="nav-link" href="<?= base_url("Mahasiswa/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 2) : ?>
                        <li><a class="nav-link" href="<?= base_url("Kegiatan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 3) : ?>
                        <li><a class="nav-link" href="<?= base_url("Kegiatan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 4) : ?>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Pengaturan File</span></a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileExport") ?>"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 5) : ?>
                        <li><a class="nav-link" href="<?= base_url("Pimpinan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 6) : ?>
                        <li><a class="nav-link" href="<?= base_url("Keuangan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 7) : ?>
                        <li><a class="nav-link" href="<?= base_url("Publikasi/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                    <?php elseif ($this->session->userdata('user_profil_kode') == 8) : ?>
                        <li><a class="nav-link" href="<?= base_url("Akademik/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>

                    <?php endif ?>

            </ul>
        <?php elseif ($this->session->userdata("user_profil_kode") == 9) : ?>
            <ul class="sidebar-menu">
                <li class="menu-header">Admin</li>
                <li><a class="nav-link" href="<?= base_url("admin") ?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Admin/ManagementUser") ?>"><i class="fas fa-pencil-ruler"></i> <span>Managament User</span></a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Validasi</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarRancangan") ?>">Rancangan</a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarProposal") ?>">Proposal Kemahasiswaan</a></li>
                        <li><a class="nav-link" href="<?= base_url("Publikasi/daftarProposal") ?>">Proposal Publikasi</a></li>
                        <li><a class="nav-link" href="<?= base_url("Keuangan/daftarPengajuanKeuangan") ?>">Proposal Keuangan</a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarLpj") ?>">Lpj Kemahasiswaan</a></li>
                        <li><a class="nav-link" href="<?= base_url("Publikasi/daftarLpj") ?>">Lpj Publikasi</a></li>
                        <li><a class="nav-link" href="<?= base_url("Keuangan/daftarPengajuanLpj") ?>">Lpj Keuangan</a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarPoinSkp") ?>">Poin SKP</a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/beasiswa") ?>">Beasiswa</a></li>
                        <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarLembaga") ?>">Anggota</a></li>
                    </ul>
                </li>
                <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/lembaga") ?>"><i class="fas fa-university"></i> <span>Kegiatan Lembaga</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/skpMahasiswa") ?>"><i class="fas fa-rocket"></i> <span>SKP Mahasiswa</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Pimpinan/rekapitulasiSKP") ?>"><i class="fas fa-briefcase"></i> <span>Rekapitulasi SKP</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/laporanSerapan") ?>"><i class="fas fa-file-invoice-dollar"></i> <span>Laporan Keuangan</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Akademik/kegiatan") ?>"><i class="fas fa-calendar-check"></i> <span>Kegiatan</span></a></li>
                <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/kategori") ?>"><i class="fas fa-layer-group"></i> <span>Kategori </span></a></li>
                <li><a class="nav-link" href="<?= base_url("Admin/daftarPimpinan") ?>"><i class="fas fa-users"></i> <span>Daftar Pimpinan </span></a></li>


                <li class="menu-header mt-2">Download</li>
                <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                    <li><a class="nav-link" href="<?= base_url("Mahasiswa/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 2) : ?>
                    <li><a class="nav-link" href="<?= base_url("Kegiatan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 3) : ?>
                    <li><a class="nav-link" href="<?= base_url("Kegiatan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 4) : ?>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Pengaturan File</span></a></li>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileExport") ?>"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 5) : ?>
                    <li><a class="nav-link" href="<?= base_url("Pimpinan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 6) : ?>
                    <li><a class="nav-link" href="<?= base_url("Keuangan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 7) : ?>
                    <li><a class="nav-link" href="<?= base_url("Publikasi/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php elseif ($this->session->userdata('user_profil_kode') == 8) : ?>
                    <li><a class="nav-link" href="<?= base_url("Akademik/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Panduan File</span></a></li>
                <?php else : ?>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileDownload") ?>"><i class="fas fa-cog"></i> <span>Pengaturan File</span></a></li>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarFileExport") ?>"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
                <?php endif ?>
            </ul>
        <?php endif; ?>
    </aside>
</div>