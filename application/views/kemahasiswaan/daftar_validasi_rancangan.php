<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Rancangan Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Nama Lembaga</th>
                                        <th>Jumlah Kegiatan</th>
                                        <th>Validasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 10; $i++) : ?>
                                        <tr>
                                            <td>1</td>
                                            <td>20 Agu 2019</td>
                                            <td>BEM</td>
                                            <td>15</td>
                                            <td>
                                                <i class="circle fas fa-check text-success"></i>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-icon btn-success"><i class="fas fa-check"></i></a>
                                                <a href="#" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a>
                                            </td>
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