<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Proposal Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>

                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-icon icon-left btn-warning float-right"><i class="fas fa-print"></i> Cetak Pengajuan</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>

                                    <th class="text">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            No
                                        </div>
                                    </th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Pengaju</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Status</th>
                                    <th>Kmhsn</th>
                                    <th>WD 3</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 20; $i++) : ?>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    1
                                                </div>
                                            </td>
                                            <td>12 Jun 2019</td>
                                            <td>BEM</td>
                                            <td>
                                                <a href="#">Lomba Akutansi Nasional</a>
                                            </td>
                                            <td>
                                                <div class="badge badge-primary">Berlangsung</div>
                                            </td>
                                            <td>
                                                <i class="fas fa-check text-success"></i>
                                            </td>
                                            <td>
                                                <i class="fas fa-check text-success"></i>
                                            </td>
                                            <td><a href="#" class="btn btn-icon btn-success"><i class="fas fa-check"></i></a>
                                                <a href="#" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a></td>
                                        </tr>
                                    <?php endfor; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>