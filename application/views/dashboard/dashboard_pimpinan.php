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
        </div>
    </section>
</div>