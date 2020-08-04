<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi Rancangan</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Kemahasiswaan/daftarRancangan?status=2') ?>"><?= $notif['notif_kmhs_rancangan'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi Proposal</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Kemahasiswaan/daftarProposal?status=2') ?>"> <?= $notif['notif_kmhs_proposal'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi LPJ</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Kemahasiswaan/daftarLpj?status=2') ?>"> <?= $notif['notif_kmhs_lpj'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi Poin Skp</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Kemahasiswaan/daftarPoinSkp?validasi=0') ?>"> <?= $notif['notif_kmhs_skp'] ?></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4>Daftar Kegiatan Sedang Berlangsung</h4>
                    </div>
                    <div class="card-body">


                        <div class="card">
                            <div class="card-header bg-whitesmoke">
                                <h4 class="text-dark">Proposal Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <?php foreach ($proposal_kegiatan as $k) : ?>
                                    <div class="col-lg-12">
                                        <h6>Status Proposal :
                                            <?php if ($k['status_selesai_proposal'] == 0) : ?>
                                                <span class=" badge btn-sm badge-secondary">
                                                    Belum diproses
                                                </span>
                                            <?php elseif ($k['status_selesai_proposal'] == 1) : ?>
                                                <span class=" badge badge-primary">
                                                    Sedang Berlangsung
                                                </span>
                                            <?php elseif ($k['status_selesai_proposal'] == 2) : ?>
                                                <span class=" badge badge-warning">
                                                    Revisi
                                                </span>
                                            <?php endif; ?>
                                        </h6>
                                        <h3><a href="<?= base_url('Kemahasiswaan/daftarProposal') ?>"><?= $k['nama_kegiatan'] ?></a> </h3>
                                        <span> Penanggung Jawab : <?= $k['nama_penanggung_jawab'] ?></span>
                                        <span><i class="fas fa-calendar"></i> Pengajuan Proposal <?= date("d-m-Y", strtotime($k['tgl_pengajuan_proposal']))    ?></span>
                                        <span><i class="fas fa-home"></i><?= $k['lokasi_kegiatan'] ?></span>

                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-whitesmoke">
                                <h4 class="text-dark">Lpj Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <?php foreach ($lpj_kegiatan as $k) : ?>
                                    <div class="col-lg-12">
                                        <h6>Status Lpj :
                                            <?php if ($k['status_selesai_lpj'] == 0) : ?>
                                                <span class=" badge btn-sm badge-secondary">
                                                    Belum diproses
                                                </span>
                                            <?php elseif ($k['status_selesai_lpj'] == 1) : ?>
                                                <span class=" badge badge-primary">
                                                    Sedang Berlangsung
                                                </span>
                                            <?php elseif ($k['status_selesai_lpj'] == 2) : ?>
                                                <span class=" badge badge-warning">
                                                    Revisi
                                                </span>
                                            <?php endif; ?>
                                        </h6>

                                        <h3><a href="<?= base_url('Kemahasiswaan/daftarLpj') ?>"><?= $k['nama_kegiatan'] ?></a> </h3>
                                        <span>Penanggung Jawab : <?= $k['nama_penanggung_jawab'] ?></span>
                                        <span><i class="fas fa-calendar"></i> Pengajuan Lpj <?= date("d-m-Y", strtotime($k['tgl_pengajuan_lpj'])) ?></span> <span><i class="fas fa-home"></i><?= $k['lokasi_kegiatan'] ?></span>
                                        <hr>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>