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

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Grafik Rekapitulasi SKP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <input type="hidden" id="tahun_temp" value="<?= $tahun ?>">
                            <?php if ($tahun != "") : ?>
                                <h3>Tahun <?= $tahun ?></h3>
                            <?php else : ?>
                                <h3>Semua Tahun</h3>
                            <?php endif ?>
                            <div class="card-body chart">
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
                        <h4>Rekapitulasi SKP Mahasiswa</h4>
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
                        <form action="<?= base_url('Export/exportRekapitulasiSKP') ?>" method="get">
                            <div class="form-group  float-right mr-2">
                                <div class="input-group">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option value="" selected="">Tahun...</option>
                                        <?php foreach ($tahun_filter as $tf) : ?>
                                            <option value="<?= $tf['tahun_kegiatan'] ?>"><?= $tf['tahun_kegiatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped text-center tabel-rekap" id="table-2">
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
                                                <button class="btn btn-primary detail-rekap-skp" data-toggle="modal" data-target=".modalDetailRekapSKP" data-id="<?= $p['id_prestasi'] ?>">Detail</button>
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