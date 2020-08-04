<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Serapan Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Laporan Serapan Kegiatan Lembaga Tahun <?= $tahun_saat_ini ?></h4>
                        <input type="hidden" id="tahun_anggran" value="<?= $tahun_saat_ini ?>">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form action="<?= base_url($this->uri->segment(1) . '/laporanSerapan') ?>" method="post">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <select class="custom-select" name="tahun">
                                                <option selected value="<?= $tahun[0]['tahun'] ?>">Pilih tahun</option>
                                                <?php foreach ($tahun as $t) : ?>
                                                    <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <form action="<?= base_url('Export/exportSerapanKegiatan/') ?>" method="post">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <select class="custom-select" name="tahun">
                                                <option selected value="<?= $tahun[0]['tahun'] ?>">Pilih tahun</option>
                                                <?php foreach ($tahun as $t) : ?>
                                                    <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-success"><i class="fas fa-file-excel mr-2 "></i>Download Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class=" text-center table table-striped table-bordered" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="2">No</th>
                                        <th class="align-middle" rowspan="2">Nama Lembaga</th>
                                        <th colspan="12">Bulan</th>
                                        <th class="align-middle" rowspan="2">Dana Pagu</th>
                                        <th colspan="2">Jumlah Terserap</th>
                                        <th colspan="2">Sisa</th>
                                    </tr>
                                    <tr>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Agu</th>
                                        <th>Sep</th>
                                        <th>Okt</th>
                                        <th>Nov</th>
                                        <th>Des</th>
                                        <th>Rp</th>
                                        <th>%</th>
                                        <th>Rp</th>
                                        <th>%</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($laporan as $l) : ?>

                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><a href="" class="laporan-serapan" data-toggle="modal" data-target=".modal-laporan-serapan" data-tahun="<?= $tahun_saat_ini ?>" data-id="<?= $l['id_lembaga'] ?>"><?= $l['nama_lembaga'] ?></a></td>
                                            <?php for ($i = 1; $i < 13; $i++) : ?>
                                                <td class="text-left"><?= number_format($l[$i], 2, ',', '.'); ?></td>
                                            <?php endfor; ?>
                                            <td><?= number_format($l['dana_pagu'], 2, ',', '.');
                                                ?></td>
                                            <td><?= number_format($l['dana_terserap'], 2, ',', '.');  ?></td>
                                            <td><?= round($l['terserap_persen'], 2) ?></td>
                                            <td><?= number_format($l['dana_sisa'], 2, ',', '.');  ?></td>
                                            <td><?= round($l['sisa_terserap'], 2) ?></td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="14">Total</td>
                                        <td><?= number_format($total['total']['dana_pagu'], 2, ',', '.');  ?></td>
                                        <td><?= number_format($total['total']['dana_terserap'], 2, ',', '.');  ?></td>
                                        <td><?= round($total['total']['persen_terserap'], 2) ?></td>
                                        <td><?= number_format($total['total']['dana_sisa'], 2, ',', '.'); ?></td>
                                        <td><?= round($total['total']['persen_sisa'], 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Laporan Serapan Kegiatan Non Lembaga Tahun <?= $tahun_saat_ini ?></h4>
                        <input type="hidden" id="tahun_anggran" value="<?= $tahun_saat_ini ?>">
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="  table table-striped table-bordered" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="2">No</th>
                                        <th class="align-middle" rowspan="2">Nama Kegiatan</th>
                                        <th colspan="12">Bulan</th>
                                        <th class="align-middle" rowspan="2">Dana Pagu</th>
                                        <th colspan="2">Jumlah Terserap</th>
                                    </tr>
                                    <tr>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Agu</th>
                                        <th>Sep</th>
                                        <th>Okt</th>
                                        <th>Nov</th>
                                        <th>Des</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody class="table-detail-delegasi">

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <tr>
                                        <td colspan="14" class="text-center">Total</td>
                                        <td class="total-anggaran-delegasi"></td>
                                        <td class="total-terserap-delegasi"></td>
                                    </tr>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Grafik Laporan Serapan Kegiatan</h4>

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


<div class="modal fade modal-laporan-serapan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan Serapan Anggaran <span id="nama_lembaga"></span><span class="tahun_anggaran"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2">No</th>
                                <th scope="col" rowspan="2">Nama Kegiatan</th>
                                <th scope="col" class="text-center" colspan="12">Bulan</th>
                                <th rowspan="2">Anggaran Kegiatan</th>
                                <th rowspan="2">Anggaran Terserap</th>
                            </tr>
                            <tr>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>Mei</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Aug</th>
                                <th>Sep</th>
                                <th>Okt</th>
                                <th>Nov</th>
                                <th>Des</th>
                            </tr>
                        </thead>
                        <tbody class="table-detail-serapan">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14" class="text-center">Total</td>
                                <td class="total-anggaran"></td>
                                <td class="total-terserap"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>