<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Kegiatan Berlangsung</h4>
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
                                        <h3><a href="<?= base_url('Kegiatan/daftarPengajuanProposal') ?>"><?= $k['nama_kegiatan'] ?></a> </h3>
                                        <span> Penanggung Jawab : <?= $k['nama_penanggung_jawab'] ?></span>
                                        <span><i class="fas fa-calendar"></i> Pengajuan Proposal <?= date("d-m-Y", strtotime($k['tgl_pengajuan_proposal'])) ?></span>
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

                                        <h3><a href="<?= base_url('Kegiatan/pengajuanLpj') ?>"><?= $k['nama_kegiatan'] ?></a> </h3>
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
        </div>
    </section>
</div>