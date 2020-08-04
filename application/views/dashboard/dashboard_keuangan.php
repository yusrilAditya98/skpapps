<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi Proposal</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Keuangan/daftarPengajuanKeuangan?status=2') ?>"><?= $notif['notif_keuangan_proposal'] ?></a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Validasi LPJ</h4>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('Keuangan/daftarPengajuanLpj?status=2') ?>"><?= $notif['notif_keuangan_lpj'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <input type="hidden" id="tahun_anggran" value="<?= $tahun_saat_ini ?>">
                    <div class="card-header">
                        <h4>Grafik Laporan Serapan Kegiatan Tahun <span class="tahun-serapan"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-lg-12">
                                <div class="card-body chart">
                                    <canvas id="laporan-serapan" style="width: 100%; height: 30rem;"></canvas>
                                </div>
                                <div class="col-md-12 mr-2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>