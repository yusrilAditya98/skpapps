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
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kegiatan Berlangsung</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Poin Skp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>Create a mobile app</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                                <div class="progress-bar bg-success" data-width="100%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Poin SKP</h4>
                    </div>
                    <div class="card-body">
                        <h1>100</h1>
                        <h5>20 November 2019</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>