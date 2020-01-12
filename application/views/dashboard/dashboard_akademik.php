<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kegiatan Kuliah Tamu</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_kuliah_tamu; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Peserta Kegiatan Terdekat</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_peserta_kuliah_tamu_terdekat; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Kuliah Tamu Terdekat</h4>
                        </div>
                        <div class="card-body">
                            <?= $kegiatan_terdekat['tanggal_event'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pemateri Kuliah Tamu Terdekat</h4>
                        </div>
                        <div class="card-body">
                            <?= $kegiatan_terdekat['pemateri'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Rekap Kegiatan Akademik</h4>
                    </div>
                    <div class="card-body chart mb-5 mt-5">
                        <div class="row">
                            <canvas id="kegiatan-akademik" style="width: 100%; height: 20rem;" class="col-lg-6"></canvas>
                            <canvas id="peserta-kegiatan-akademik" style="width: 100%; height: 20rem;" class="col-lg-6"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>