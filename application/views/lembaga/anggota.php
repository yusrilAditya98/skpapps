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
                        <h4>Daftar Anggota Lembaga</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <a href="<?= base_url('Kegiatan/rancanganAnggota') ?>" class="btn btn-icon btn-primary float-right">
                                    Rancangan Anggota</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <?php if ($pengajuan['status_validasi'] == 0 && $pengajuan['status_keaktifan'] == 0) : ?>
                                    <div class="alert alert-light" role="alert">
                                        Anggota Periode Lembaga <?= $tahun ?> Belum ada, Silahkan cek menu Rancangan Anggota
                                    </div>
                                    <?php elseif($pengajuan['status_validasi'] == 1 && $pengajuan['status_keaktifan'] == 0) : ?>
                                        <div class="alert alert-light" role="alert">
                                        Anggota Periode Lembaga <?= $tahun ?> sudah valid, Silahkan melakukan pelaporan keaktifan anggota
                                        </div>
                                    <?php elseif($pengajuan['status_validasi'] == 1 && $pengajuan['status_keaktifan'] == 2) : ?>
                                        <div class="alert alert-light" role="alert">
                                            Anggota Lembaga Periode <?= $tahun ?> sedang dalam proses validasi keaktifan
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-light" role="alert">
                                            Anggota Lembaga Periode <?= $tahun ?>
                                        </div>
                                <?php endif; ?>
                            </div>
                                <div class="col-lg-4">
                                <form action="<?= base_url('Kegiatan/anggota') ?>" method="get">
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
                        <form action="<?= base_url('Kegiatan/laporanKeaktifanAnggota/' . $pengajuan['id']) ?>" method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Posisi</th>
                                        <th>Keaktifan</th>
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
                                            <?php if ($pengajuan['status_keaktifan'] == 0) : ?>
                                                <td>
                                                    <label><input type="radio" name="keaktifan_<?= $a['nim'] ?>" value="1">Aktif</label>
                                                    <label><input type="radio" name="keaktifan_<?= $a['nim'] ?>" value="2">Tidak Aktif</label>
                                                </td>
                                            <?php elseif ($a['status_aktif'] == 1 && $pengajuan['status_keaktifan'] == 1) : ?>
                                                <td class="text-success">Aktif</td>
                                            <?php elseif ($a['status_aktif'] == 2 && $pengajuan['status_keaktifan'] == 1) : ?>
                                                <td class="text-danger">Tidak Aktif</td>
                                            <?php elseif ($pengajuan['status_keaktifan'] == 2) : ?>
                                                <td class="text-primary">Proses</td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center"><h4>Belum ada anggota</h4></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php if ($pengajuan['status_validasi'] == 1 && $pengajuan['status_keaktifan'] == 0) : ?>
                                <button type="submit" class="btn btn-icon btn-success float-right">Ajukan Laporan Keaktifan Anggota</button>
                                    <a href="#" class="btn btn-info float-right mr-3" onclick="aktifSemua()">Aktif Semua</a>
                                    <input type="hidden" value="<?= $pengajuan['id'] ?>" id="pengajuanId">
                            <?php endif; ?>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>