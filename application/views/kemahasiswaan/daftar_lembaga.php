<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Anggota Lembaga</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengajuan Anggota Lembaga</h4>
                    </div>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
                    <div class="card-body">
                        <form action="<?= base_url('Kemahasiswaan/daftarLembaga') ?>" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCity">Tahun</label>
                                    <select id="inputState" name="tahun" class="form-control">
                                        <option value="" selected="">tahun...</option>
                                        <?php foreach ($filter['tahun'] as $t) : ?>
                                            <option value="<?= $t['periode'] ?>"><?= $t['periode'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Nama Lembaga</label>
                                    <select id="inputState" name="lembaga" class="form-control">
                                        <option value="" selected="">nama lembaga...</option>
                                        <?php foreach ($lembaga as $l) : ?>
                                            <option value="<?= $l['id_lembaga'] ?>"><?= $l['nama_lembaga'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputZip">Validasi Anggota</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" selected="">jenis validasi...</option>
                                        <option value="0">Belum Mengajukan</option>
                                        <option value="2">Proses</option>
                                        <option value="1">Valid</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Validasi Keaktifan</label>
                                    <select id="inputState" name="aktif" class="form-control">
                                        <option value="" selected="">jenis keaktifan...</option>
                                        <option value="0">Belum Mengajukan</option>
                                        <option value="2">Proses</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputState">tombol</label>
                                    <button type="submit" class="form-control btn btn-primary">cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Nama Lembaga</th>
                                        <th>Jumlah Anggota</th>
                                        <th>Validasi Anggota</th>
                                        <th>Validasi Keaktifan</th>
                                        <th>Bukti Pengajuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pengajuan as $p) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $p['periode'] ?></td>
                                            <td><?= $p['nama_lembaga'] ?></td>
                                            <td><?= $p['jumlah_anggota_lembaga'] ?></td>
                                            <td>
                                                <?php if ($p['status_validasi'] == 1) :  ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($p['status_validasi'] == 2) : ?>
                                                    <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                <?php elseif ($p['status_validasi'] == 0) : ?>
                                                    <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($p['status_keaktifan'] == 1) :  ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($p['status_keaktifan'] == 2) : ?>
                                                    <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                <?php elseif ($p['status_keaktifan'] == 0) : ?>
                                                    <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a target="_blank" href="<?= base_url('file_bukti/sk_lembaga/' . $p['bukti_pengajuan']) ?>"><i class="fas fa-file-alt"></i></a>
                                            </td>
                                            <td>
                                                <?php if ($p['status_validasi'] == 2) :  ?>
                                                    <button class="btn btn-icon btn-info validasiAnggota" data-toggle="modal" data-target=".modalDetailValidasiAnggota" data-id="<?= $p['id'] ?>" data-lembaga="<?= $p['id_lembaga'] ?>"><i class="fas fa-info"></i></button>
                                                <?php elseif ($p['status_validasi'] == 1 && $p['status_keaktifan'] == 0) : ?>
                                                    <button class="btn btn-icon btn-info validasiAnggotaFix" data-toggle="modal" data-target=".modalDetailValidasiAnggotaFix" data-id="<?= $p['id'] ?>" data-lembaga="<?= $p['id_lembaga'] ?>"><i class="fas fa-info"></i></button>
                                                <?php elseif ($p['status_validasi'] == 1 && $p['status_keaktifan'] == 2) : ?>
                                                    <button class="btn btn-icon btn-info keaktifanAnggota" data-toggle="modal" data-target=".modalDetailKeaktifanAnggota" data-id="<?= $p['id'] ?>" data-lembaga="<?= $p['id_lembaga'] ?>"><i class="fas fa-info"></i></button>
                                                <?php elseif ($p['status_validasi'] == 1 && $p['status_keaktifan'] == 1) : ?>
                                                    <button class="btn btn-icon btn-info keaktifanAnggotaFix" data-toggle="modal" data-target=".modalDetailKeaktifanAnggotaFix" data-id="<?= $p['id'] ?>" data-lembaga="<?= $p['id_lembaga'] ?>"><i class="fas fa-info"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Awal Modal Detail Validasi -->
<div class="modal fade bd-example-modal-lg modalDetailValidasiAnggota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Validasi Anggota</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_lembaga"></h6>
                                <h6 class="card-title jenis_lembaga"></h6>
                                <h6 class="card-title periode"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-anggota-lembaga">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Posisi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-validasi-anggota">
                                        </tbody>
                                    </table>
                                    <div class="action-button">
                                        <a href="<?= base_url('Kemahasiswaan/validasiAnggota/valid') ?>" style="width:auto; float:right" class="btn btn-icon btn-warning detailValidasiAnggota">
                                            Validasi Anggota <i class="fas fa-check"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Validasi -->

<!-- Awal Modal Detail Validasi Fix -->
<div class="modal fade bd-example-modal-lg modalDetailValidasiAnggotaFix" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Anggota Lembaga</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_lembaga_fix"></h6>
                                <h6 class="card-title jenis_lembaga_fix"></h6>
                                <h6 class="card-title periode_fix"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-anggota-lembaga">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Posisi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-validasi-anggota-fix">
                                        </tbody>
                                    </table>
                                    <div class="action-button">
                                        <a href="<?= base_url('Kemahasiswaan/validasiAnggota/unvalid') ?>" style="width:auto; float:right" class="btn btn-icon btn-danger detailValidasiAnggotaFix">
                                            Unvalidasi Anggota <i class="fas fa-check"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Validasi Fix -->


<!-- Awal Modal Detail Keaktifan -->
<div class="modal fade bd-example-modal-lg modalDetailKeaktifanAnggota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Validasi Keaktifan Anggota</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_lembaga_aktif"></h6>
                                <h6 class="card-title jenis_lembaga_aktif"></h6>
                                <h6 class="card-title periode_aktif"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-anggota-lembaga">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Posisi</th>
                                                <th>Bobot</th>
                                                <th>Keaktifan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-keaktifan-anggota">
                                        </tbody>
                                    </table>
                                    <div class="action-button">
                                        <a href="<?= base_url('Kemahasiswaan/validasiKeaktifanAnggota/valid') ?>" style="width:auto; float:right" class="btn btn-icon btn-warning detailKeaktifanAnggota">
                                            Validasi Keaktifan Anggota <i class="fas fa-check"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Keaktifan -->

<!-- Awal Modal Detail Keaktifan Fix -->
<div class="modal fade bd-example-modal-lg modalDetailKeaktifanAnggotaFix" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Keaktifan Anggota</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_lembaga_aktif_fix"></h6>
                                <h6 class="card-title jenis_lembaga_aktif_fix"></h6>
                                <h6 class="card-title periode_aktif_fix"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-anggota-lembaga">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Posisi</th>
                                                <th>Bobot</th>
                                                <th>Nilai Keaktifan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-keaktifan-anggota-fix">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Keaktifan Fix -->