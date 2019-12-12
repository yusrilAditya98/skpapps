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
                            <?= $notif['notif_kmhs_rancangan'] ?>
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
                            <?= $notif['notif_kmhs_proposal'] ?>
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
                            <?= $notif['notif_kmhs_lpj'] ?>
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
                            <?= $notif['notif_kmhs_skp'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Penyebaran Poin skp</h4>
                    </div>
                    <div class="card-body chart mb-5 mt-5">
                        <canvas id="sebaran-skp" style="width: 100%; height: 25rem;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4>Jumlah Kegiatan</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-danger btn-icon icon-right">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>