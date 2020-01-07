<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Anggaran</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengeluaran Anggaran Kegiatan Lembaga</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="alert alert-light" role="alert">
                                    Total Anggaran Tahun <?= $tahun_anggaran ?>: <span class="font-weight-bold">Rp. <?= number_format($total_anggaran['anggaran_lembaga'], 2, ',', '.'); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <form action="<?= base_url('Kegiatan/anggaran') ?>" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <select name="tahun" class="browser-default custom-select">
                                                <option selected>Tahun</option>
                                                <?php foreach ($tahun as $t) : ?>
                                                    <option value="<?= $t['tahun'] ?>"><?= $t['tahun'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <th scope="row"><?= $index++ ?></th>
                                            <td><?= $k['nama_kegiatan'] ?></td>
                                            <?php for ($i = 1; $i < 13; $i++) : ?>
                                                <td><?= number_format($laporan[$k['id_kegiatan']][$i], 2, ',', '.');  ?></td>
                                            <?php endfor; ?>
                                            <td><?= number_format($laporan[$k['id_kegiatan']]['anggaran_kegiatan'], 2, ',', '.');  ?></td>
                                            <td><?= number_format($laporan[$k['id_kegiatan']]['dana_terserap'], 2, ',', '.');  ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="14" class="text-center">Total</td>
                                        <td><?= number_format($total['total']['anggaran_kegiatan'], 2, ',', '.'); ?></td>
                                        <td><?= number_format($total['total']['dana_terserap'], 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>