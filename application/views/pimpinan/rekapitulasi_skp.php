<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekapitulasi SKP Mahasiswa</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message');  ?>
            </div>
        </div>

        <?php
        $start = date_format(date_create($start_date), "d-m-Y");
        $end = date_format(date_create($end_date), "d-m-Y");
        ?>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Grafik Rekapitulasi Prestasi SKP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" id="start_temp" value="<?= $start_date ?>">
                                <input type="hidden" id="end_temp" value="<?= $end_date ?>">
                                <?php if ($start_date != "" && $end_date != "") : ?>
                                    <h4 class="float-right">Tanggal <?= $start ?> hingga <?= $end ?></h4>
                                <?php else : ?>
                                    <h4 class="float-right">Semua</h4>
                                <?php endif ?>
                            </div>
                            <div class="col-lg-12">
                                <canvas id="rekap-skp-chart" style="width: 100%; height: 30rem;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Rekapitulasi Prestasi SKP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <?php if ($start_date != "" && $end_date != "") : ?>
                                    <h4 class="float-right">Tanggal <?= $start ?> hingga <?= $end ?></h4>
                                <?php else : ?>
                                    <h4 class="float-right">Semua</h4>
                                <?php endif ?>
                            </div>
                        </div>
                        <form action="<?= base_url('Pimpinan/rekapitulasiSKP') ?>" method="get">
                            <div class="row float-right">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="start_date" id="start_temp" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="end_date" type="date" id="end_temp" class="form-control">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary">submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="<?= base_url('Export/exportRekapitulasiSKP') ?>" method="get">
                            <div class="row float-right mr-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="start_date" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="end_date" type="date" class="form-control">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-success">Download excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center tabel-rekap" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Prestasi</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($prestasi as $p) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $p['nama_prestasi'] ?></td>
                                            <td><?= $p['jumlah'] ?></td>
                                            <td>
                                                <button class="btn btn-primary detail-rekap-skp" data-toggle="modal" data-target=".modalDetailRekapSKP" data-id="<?= $p['id_prestasi'] ?>" data-start="<?= $start_date ?>" data-end="<?= $end_date ?>">Detail</button>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Rekapitulasi Tingkatan SKP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($tahun != "") : ?>
                            <h3>Tahun <?= $tahun ?></h3>
                        <?php else : ?>
                            <h3>Semua Tahun</h3>
                        <?php endif ?>

                        <form action="<?= base_url('Pimpinan/rekapitulasiSKP') ?>" method="get">
                            <div class="form-group float-right">
                                <div class="input-group">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option value="" selected="">Tahun...</option>
                                        <?php foreach ($tahun_filter as $tf) : ?>
                                            <option value="<?= $tf['tahun_kegiatan'] ?>"><?= $tf['tahun_kegiatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="<?= base_url('Export/exportRekapitulasiTingkatan') ?>" method="get">
                            <div class="form-group  float-right mr-2">
                                <div class="input-group">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option value="" selected="">Tahun...</option>
                                        <?php foreach ($tahun_filter as $tf) : ?>
                                            <option value="<?= $tf['tahun_kegiatan'] ?>"><?= $tf['tahun_kegiatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center tabel-tingkatan" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tingkatan</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($tingkatan as $t) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $t['nama_tingkatan'] ?></td>
                                            <td><?= $t['jumlah'] ?></td>
                                            <td>
                                                <button class="btn btn-primary detail-tingkat-skp" data-toggle="modal" data-target=".modalTingkatSKP" data-id="<?= $t['id_tingkatan'] ?>" data-tahun="<?= $tf['tahun_kegiatan'] ?>">Detail</button>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<!-- Awal Modal Detail Profil -->
<div class="modal fade bd-example-modal-lg modalDetailRekapSKP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Poin SKP</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive" id="rekap-prestasi">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Profil -->


<!-- Modal Tingkatan -->
<div class="modal fade bd-example-modal-lg modalTingkatSKP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Tingkatan Poin SKP</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive" id="rekap-tingkatan">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tingkatan -->