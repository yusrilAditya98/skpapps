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
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Mahasiswa</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_mahasiswa ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Lembaga</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_lembaga ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Rekapitulasi Jumlah User</h4>
                    </div>
                    <div class="card-body chart mb-5 mt-5">
                        <canvas id="rekap-user" style="width: 100%; height: 25rem;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
