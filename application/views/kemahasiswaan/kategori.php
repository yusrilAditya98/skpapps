<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori Kegiatan</h1>
        </div>
        <div class="row">
            <!-- Bidang Kegiatan -->
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bidang Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="float-right btn btn-primary mb-2" data-toggle="modal" data-target=".modalTambahBidang">Tambah Bidang</button>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped table-kategori">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Bidang Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($bidang as $b) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i; ?></td>
                                            <td><?= $b['nama_bidang'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success edit-bidang text-wrap" data-toggle="modal" data-target=".modalEditKegiatan" data-id="">Edit</button>
                                                <button class="btn btn-danger hapus-bidang text-wrap" value=" <?= $b['id_bidang'] ?>">Hapus</button>
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
            <!-- Jenis Kegiatan -->
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jenis Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="float-right btn btn-primary mb-2 tambahJenis" data-toggle="modal" data-target=".modalTambahJenis">Tambah Jenis</button>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped text-wrap table-kategori">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Bidang Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($jenis as $j) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i; ?></td>
                                            <td><?= $j['jenis_kegiatan'] ?></td>
                                            <td><?= $j['nama_bidang'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success edit-jenis" data-toggle="modal" data-target=".modalEditKegiatan" data-id="">Edit</button>
                                                <button class="btn btn-danger hapus-jenis" value=" <?= $j['id_jenis_kegiatan'] ?>">Hapus</button>
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
            <!-- Tingkatan Kegiatan -->
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tingkatan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="float-right btn btn-success mb-2" data-toggle="modal" data-target=".modalDetailTingkatan">Detail Tingkatan</button>
                                <button class="float-right btn btn-primary mb-2" data-toggle="modal" data-target=".modalTambahTingkatan">Tambah Tingkatan</button>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped table-kategori">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tingkatan Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($tingkatan as $t) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i; ?></td>
                                            <td><?= $t['nama_tingkatan'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success edit-tingkatan" data-toggle="modal" data-target=".modalEditKegiatan" data-id="">Edit</button>
                                                <button class="btn btn-danger hapus-tingkatan" value=" <?= $t['id_tingkatan'] ?>">Hapus</button>
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
            <!-- Prestasi Kegiatan -->
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Prestasi Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="float-right btn btn-success mb-2" data-toggle="modal" data-target=".modalDetailPrestasi">Detail Prestasi</button>
                                <button class="float-right btn btn-primary mb-2" data-toggle="modal" data-target=".modalTambahPrestasi">Tambah Prestasi</button>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped text-wrap table-kategori">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Prestasi Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($prestasi as $p) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i; ?></td>
                                            <td><?= $p['nama_prestasi'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success edit-prestasi" data-toggle="modal" data-target=".modalEditKegiatan" data-id="">Edit</button>
                                                <button class="btn btn-danger hapus-prestasi" value=" <?= $p['id_prestasi'] ?>">Hapus</button>
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

<!-- Awal Modal Detail Tingkatan -->
<div class="modal fade bd-example-modal-lg modalDetailTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Semua Tingkatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12 tabel-semua-tingkatan">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Tingkatan -->


<!-- Awal Modal Detail Prestasi -->
<div class="modal fade bd-example-modal-lg modalDetailPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Semua Prestasi</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12 tabel-semua-prestasi">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Prestasi -->


<!-- Modal Tambah Bidang -->
<div class="modal fade bd-example-modal-lg modalTambahBidang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Bidang Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahBidang') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_kegiatan">Bidang Kegiatan</label>
                                    <input type="text" class="form-control" id="bidang_kegiatan" name="bidang_kegiatan" placeholder="Masukkan nama bidang kegiatan">
                                    <?= form_error('bidang_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah Bidang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Bidang -->


<!-- Awal Modal Tambah Jenis -->
<div class="modal fade bd-example-modal-lg modalTambahJenis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Jenis Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahJenis') ?>" method="post">
                                <div class="form-group">
                                    <label for="jenis_kegiatan">Jenis Kegiatan</label>
                                    <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan" placeholder="Masukkan jenis kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                    <?= form_error('jenis_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="bidang_kegiatan" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control" id="bidang_kegiatan" name="bidang_kegiatan" placeholder="bidang_kegiatan">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                        <!-- <option value="A">A</option>
                                        <option value="B">B</option> -->
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah Jenis</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Jenis -->


<!-- Awal Modal Tambah Tingkatan -->
<div class="modal fade bd-example-modal-lg modalTambahTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Tingkatan Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahTingkatan') ?>" method="post">
                                <div class="form-group">
                                    <label for="tingkatan">Tingkatan Kegiatan</label>
                                    <textarea class="form-control" id="tingkatan" name="tingkatan" placeholder="Masukkan Tingkatan kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                    <?= form_error('tingkatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="bidang_kegiatan" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control" id="bidang_kegiatan" name="bidang_kegiatan" placeholder="bidang_kegiatan">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                </div> -->
                                <button type="submit" class="btn btn-primary float-right">Tambah Tingkatan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Tingkatan -->


<!-- Awal Modal Tambah Prestasi -->
<div class="modal fade bd-example-modal-lg modalTambahPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Prestasi Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahPrestasi') ?>" method="post">
                                <div class="form-group">
                                    <label for="prestasi">Prestasi Kegiatan</label>
                                    <textarea class="form-control" id="prestasi" name="prestasi" placeholder="Masukkan Prestasi kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                    <?= form_error('prestasi', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <!-- <div class="form-group">
                                        <label for="bidang_kegiatan" class="col-form-label">Bidang Kegiatan</label>
                                        <select class="form-control" id="bidang_kegiatan" name="bidang_kegiatan" placeholder="bidang_kegiatan">
                                            <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                    </div> -->
                                <button type="submit" class="btn btn-primary float-right">Tambah Prestasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Prestasi -->