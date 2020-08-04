<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Rancangan Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>
                    </div>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
                    <div class="card-body">
                        <form action="<?= base_url('Kemahasiswaan/daftarRancangan') ?>" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCity">Tahun</label>
                                    <select id="inputState" name="tahun" class="form-control">
                                        <option value="" selected="">tahun rancangan...</option>
                                        <?php foreach ($filter['tahun'] as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Nama Lembaga</label>
                                    <select id="inputState" name="lembaga" class="form-control">
                                        <option value="" selected="">nama lembaga...</option>
                                        <?php foreach ($lembaga as $l) : ?>
                                            <option value="<?= $l['id_lembaga'] ?>"><?= $l['nama_lembaga'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputZip">Status Validasi</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" selected="">jenis validasi...</option>
                                        <?php foreach ($filter['status'] as $s) : ?>
                                            <?php if ($s['status_rancangan'] == 0) : ?>
                                                <option value="<?= $s['status_rancangan'] ?>">Belum Mengajukan</option>
                                            <?php elseif ($s['status_rancangan'] == 1) : ?>
                                                <option value="<?= $s['status_rancangan'] ?>">Valid</option>
                                            <?php elseif ($s['status_rancangan'] == 2) : ?>
                                                <option value="<?= $s['status_rancangan'] ?>">Revisi</option>
                                            <?php elseif ($s['status_rancangan'] == 3) : ?>
                                                <option value="<?= $s['status_rancangan'] ?>">Proses</option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputState">tombol</label>
                                    <button type="submit" class="form-control btn btn-primary">cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <form class="m-t-20" action="<?= base_url('Export/exportRancanganKegiatan') ?>" method="get">
                                <div class="row">
                                    <div class="col-lg-4 input-group mb-3">
                                        <select id="inputState" name="tahun" class="form-control">
                                            <option value="" selected="">tahun rancangan...</option>
                                            <?php foreach ($filter['tahun'] as $t) : ?>
                                                <option value="<?=
                                                                    $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-bordered" id="table-1">
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Tahun</th>
                                        <th class="align-middle">Nama Lembaga</th>
                                        <th class="align-middle">Jumlah Kegiatan</th>
                                        <th class="align-middle">Total Anggaran</th>
                                        <th class="align-middle">Anggaran Diajukan</th>
                                        <th class="align-middle">Validasi</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($rancangan as $r) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $r['tahun_pengajuan'] ?></td>
                                            <td><?= $r['nama_lembaga'] ?></td>
                                            <?php if ($r['jumlah_kegiatan']) : ?>
                                                <td><?= $r['jumlah_kegiatan'] ?></td>
                                            <?php else : ?>
                                                <td>0</td>
                                            <?php endif; ?>
                                            <td>Rp. <?= number_format($r['anggaran_kemahasiswaan'], 0, ',', '.')  ?></td>
                                            <td>Rp. <?= number_format($r['anggaran_lembaga'], 0, ',', '.')   ?></td>
                                            <td>
                                                <?php if ($r['status_rancangan'] == 1) :  ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($r['status_rancangan'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content detail-revisi" data-toggle="modal" data-target="#i-revisi" data-id=""><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php elseif ($r['status_rancangan'] == 3) : ?>
                                                    <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                <?php elseif ($r['status_rancangan'] == 0) : ?>
                                                    <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('Kemahasiswaan/detailRancanganKegiatan/?id_lembaga=') . $r['id_lembaga'] . '&tahun=' . $r['tahun_pengajuan'] ?>" class="btn btn-icon btn-info"><i class="fas fa-info"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td><b>Keterangan</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class=" text-center"> <i class="fa fa-check text-success" aria-hidden="true"></i></td>
                                        <td> : Telah Divalidasi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <i class="fa fa-circle text-primary" aria-hidden="true"></i></td>
                                        <td> : Proses Validasi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <i class="fa fa-circle text-secondary" aria-hidden="true"></i></td>
                                        <td> : Menunggu Pengajuan</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <span class="btn btn-warning circle-content"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span></td>
                                        <td> : Revisi (Menampilkan Catatan Revisi)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>