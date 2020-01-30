<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="<?= base_url('assets/img/skpapps.png') ?>" alt="" width="200dp" class="mt-2"></a>
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
                    <li><a class="nav-link" href="<?= base_url("Keuangan/daftarPengajuanProposal") ?>">Proposal Keuangan</a></li>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarLpj") ?>">Lpj Kemahasiswaan</a></li>
                    <li><a class="nav-link" href="<?= base_url("Publikasi/daftarLpj") ?>">Lpj Publikasi</a></li>
                    <li><a class="nav-link" href="<?= base_url("Keuangan/daftarPengajuanLpj") ?>">Lpj Keuangan</a></li>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/daftarPoinSkp") ?>">Poin SKP</a></li>
                    <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/beasiswa") ?>">Beasiswa</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/lembaga") ?>"><i class="fas fa-university"></i> <span>Kegiatan Lembaga</span></a></li>
            <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/skpMahasiswa") ?>"><i class="fas fa-rocket"></i> <span>SKP Mahasiswa</span></a></li>
            <li><a class="nav-link" href="<?= base_url("Pimpinan/rekapitulasiSKP") ?>"><i class="fas fa-briefcase"></i> <span>Rekapitulasi SKP</span></a></li>
            <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/laporanSerapan") ?>"><i class="fas fa-file-invoice-dollar"></i> <span>Laporan Keuangan</span></a></li>
            <li><a class="nav-link" href="<?= base_url("Akademik/kegiatan") ?>"><i class="fas fa-calendar-check"></i> <span>Kegiatan</span></a></li>
            <li><a class="nav-link" href="<?= base_url("Kemahasiswaan/kategori") ?>"><i class="fas fa-layer-group"></i> <span>Kategori </span></a></li>
            <li><a class="nav-link" href="<?= base_url("Admin/daftarPimpinan") ?>"><i class="fas fa-users"></i> <span>Daftar Pimpinan </span></a></li>
        </ul>
    </aside>
</div>