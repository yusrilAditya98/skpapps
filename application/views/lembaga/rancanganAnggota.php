<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Anggota</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Rancangan Anggota Lembaga</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <?php if ($pengajuan == null) { ?>
                                    <a href="<?= base_url('Kegiatan/tambahRancanganAnggota?tahun=' . $tahun) ?>" class="btn btn-icon btn-success float-right">
                                        Tambah Anggota</a>
                                <?php } else { ?>
                                    <?php if ($pengajuan['status_validasi'] == 0 && $pengajuan['status_pembukaan'] == 0) : ?>
                                        <a href="<?= base_url('Kegiatan/tambahRancanganAnggota?tahun=' . $tahun) ?>" class="btn btn-icon btn-success float-right">
                                            Tambah Anggota</a>
                                        <?php if ($jumlah_anggota != 0) : ?>
                                            <a href="<?= base_url('Kegiatan/ajukanRancanganAnggota/' . $pengajuan['id'] . '?tahun=' . $tahun) ?>" class="btn btn-icon btn-primary float-right mr-3">
                                                Tutup Akses Penambahan Anggota</a>
                                        <?php endif; ?>
                                    <?php elseif ($pengajuan['status_validasi'] == 0 && $pengajuan['status_pembukaan'] == 1) : ?>
                                        <a href="<?= base_url('Kegiatan/ajukanValidasiAnggota/' . $pengajuan['id'] . '?tahun=' . $tahun) ?>" class="btn btn-icon btn-success float-right">
                                            Ajukan Validasi</a>
                                        <a href="<?= base_url('Kegiatan/bukaRancanganAnggota/' . $pengajuan['id'] . '?tahun=' . $tahun) ?>" class="btn btn-icon btn-primary float-right mr-3">
                                            Buka Akses Penambahan Anggota</a>
                                    <?php endif; ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <?php if ($pengajuan == null) { ?>
                                    <div class="alert alert-light" role="alert">
                                        Anggota Periode Lembaga <?= $tahun ?> Belum diajukan, Silahkan Tambah Anggota dan tutup akses penambahan anggota untuk mengajukan validasi
                                    </div>
                                <?php } else { ?>
                                    <?php if ($pengajuan['status_validasi'] == 0 && $pengajuan['status_pembukaan'] == 0) : ?>
                                        <div class="alert alert-light" role="alert">
                                            Anggota Periode Lembaga <?= $tahun ?> Belum diajukan, Silahkan Tambah Anggota dan tutup akses penambahan anggota untuk mengajukan validasi
                                        </div>
                                    <?php elseif ($pengajuan['status_validasi'] == 0 && $pengajuan['status_pembukaan'] == 1) : ?>
                                        <div class="alert alert-light" role="alert">
                                            Akses Penambahan Anggota Periode Lembaga <?= $tahun ?> Sudah ditutup, Silahkan Validasi
                                        </div>
                                    <?php elseif ($pengajuan['status_validasi'] == 2 && $pengajuan['status_pembukaan'] == 1) : ?>
                                        <div class="alert alert-light" role="alert">
                                            Anggota Lembaga Periode <?= $tahun ?> sedang dalam proses validasi
                                        </div>
                                    <?php else : ?>
                                        <div class="alert alert-light" role="alert">
                                            Anggota Lembaga Periode <?= $tahun ?> sudah di validasi
                                        </div>
                                    <?php endif; ?>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4">
                                <form action="<?= base_url('Kegiatan/rancanganAnggota') ?>" method="get">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                                <option value="" selected>Tahun...</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="submit">cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Posisi</th>
                                        <th>Bobot</th>
                                        <?php if ($pengajuan != null) { ?>
                                            <?php if ($pengajuan['status_validasi'] == 1 || $pengajuan['status_pembukaan'] == 1) : ?>
                                                <th>Status</th>
                                            <?php endif; ?>
                                            <?php if ($pengajuan['status_pembukaan'] == 0) : ?>
                                                <th>Action</th>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($anggota != null) : ?>
                                        <?php $index = 1; ?>
                                        <?php foreach ($anggota as $a) : ?>
                                            <tr>
                                                <td><?= $index++; ?></td>
                                                <td><?= $a['nama'] ?></td>
                                                <td><?= $a['nim'] ?></td>
                                                <td><?= $a['nama_prestasi'] ?></td>
                                                <td><?= $a['bobot'] ?></td>
                                                <?php if ($a['status_validasi'] == 2 && $a['status_pembukaan'] == 1) : ?>
                                                    <td class="text-primary">Proses</td>
                                                <?php elseif ($a['status_validasi'] == 1 && $a['status_pembukaan'] == 1) : ?>
                                                    <td class="text-success">Valid</td>
                                                <?php elseif ($a['status_validasi'] == 0 && $a['status_pembukaan'] == 1) : ?>
                                                    <td class="text-danger">Belum Valid</td>
                                                <?php else : ?>
                                                <?php endif; ?>
                                                <?php if ($a['status_pembukaan'] == 0) : ?>
                                                    <td><a href="<?= base_url('Kegiatan/hapusRancanganAnggota?id=' . $a['id'] . '&nim=' . $a['nim'] . '&id_sm_prestasi=' . $a['id_sm_prestasi'] . '&tahun=' . $tahun) ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Belum ada anggota</h4>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <a href="<?= base_url('Kegiatan/anggota') ?>" class="btn btn-icon btn-secondary float-right">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>