<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Pimpinan</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 py-3">
                    <div class="card-icon bg-warning">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Mahasiswa</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_mahasiswa; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 py-3">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Lembaga</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_lembaga; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 py-3">
                    <div class="card-icon bg-success">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kegiatan Mahasiswa</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_kegiatan_mahasiswa; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 py-3">
                    <div class="card-icon bg-secondary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Mahasiswa Cukup SKP</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_mahasiswa_cukup_skp; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Penyebaran Poin skp</h4>
                        <div class="card-header-action">
                            <a href="<?php // base_url('Pimpinan/poinSkp') 
                                        ?>" class="btn btn-info btn-icon icon-right">View more <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body chart mb-5 mt-5">
                        <canvas id="sebaran-skp" style="width: 100%; height: 20rem;"></canvas>


                    </div>
                </div>
            </div> -->
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