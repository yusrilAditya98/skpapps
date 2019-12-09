<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Beasiswa Mahasiwa</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Jenis Beasiswa</th>
                                        <th>Tahun Menerima</th>
                                        <th>Lama Menerima</th>
                                        <th>Nominal</th>
                                        <th>Bukti</th>
                                        <th>Lampiran</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($beasiswa as $b) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
                                            <td><?= $b['nim'] ?></td>
                                            <td><?= $b['nama'] ?></td>
                                            <td><?= $b['jenis_beasiswa'] ?></td>
                                            <td><?= $b['tahun_menerima'] ?></td>
                                            <td><?= $b['lama_menerima'] ?></td>
                                            <td><?= $b['nominal'] ?></td>
                                            <td><a href="<?= base_url() ?>assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $b['bukti']  ?>">lihat</a></td>
                                            <td><a href="<?= base_url() ?>/assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $b['lampiran']  ?>">lihat</a></td>
                                            <th><?php if ($b['validasi_beasiswa'] == 0) : ?>
                                                    <div class="badge badge-primary"> Proses</div>
                                                <?php elseif ($b['validasi_beasiswa'] == 1) : ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($b['validasi_beasiswa'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php endif; ?></th>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <a href="<?= base_url('Kemahasiswaan/validasiBeasiswa/') . $b['id_penerima'] ?>?status=1" class="btn btn-success"><i class="fas fa-check"></i></a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="<?= base_url('Kemahasiswaan/validasiBeasiswa/') . $b['id_penerima'] ?>?status=2" class="btn btn-danger"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>