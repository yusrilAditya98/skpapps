<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="<?= base_url('assets/img/white_logo.png') ?>" alt="" width="200dp" class="mt-2"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SKP</a>
        </div>
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

    </aside>
</div>