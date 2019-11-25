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
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Nama Lembaga</th>
                                        <th>Jumlah Kegiatan</th>
                                        <th>Total Anggaran</th>
                                        <th>Validasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rancangan as $r) : ?>
                                        <tr>
                                            <td>1</td>
                                            <td><?= $r['tahun_pengajuan'] ?></td>
                                            <td><?= $r['nama_lembaga'] ?></td>
                                            <td>15</td>
                                            <td><?= $r['total_anggaran'] ?></td>
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


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>