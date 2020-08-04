<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori Kegiatan</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message');  ?>
            </div>
        </div>

        <div class="row">
            <!-- Bidang Kegiatan -->
            <div class="col-lg-12 col-md-12 col-12 col-sm-12" id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="d-flex align-items-center"> <i class="fas fa-award mr-4" style="font-size: 30px;"></i> Bidang Kegiatan</h4>
                        <div class="card-header-action">
                            <a data-collapse="#collapseOne" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="float-right btn btn-primary mb-2 tambahBidang" data-toggle="modal" data-target=".modalTambahBidang">Tambah Bidang</button>
                                </div>
                            </div>
                            <div class="table-responsive">

                                <table class="table table-striped table-kategori table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Bidang Kegiatan</th>
                                            <th>Status Bidang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($bidang as $b) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $b['nama_bidang'] ?></td>
                                                <td class="text-center" id="bidang_<?= $b['id_bidang'] ?>"><?php if ($b['status_bidang'] == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $b['status_bidang'] ?>" id="status_bidang<?= $b['id_bidang'] ?>">
                                                        <button class="btn btn-success edit-bidang text-wrap" data-toggle="modal" data-target=".modalEditBidang" data-id="<?= $b['id_bidang'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-bidang text-wrap" data-id="<?= $b['id_bidang'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $b['id_bidang'] ?>,'bidang')">Ubah Status</button>
                                                    </div>
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
            <!-- Jenis Kegiatan -->
            <div class="col-lg-12 col-md-12 col-12 col-sm-12" id="accordion">
                <div class="card">
                    <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="d-flex align-items-center"> <i class="fas fa-medal mr-4" style="font-size: 30px;"></i> Jenis Kegiatan</h4>
                        <div class="card-header-action">
                            <a data-collapse="#collapseTwo" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="float-right btn btn-primary mb-2 tambahJenis" data-toggle="modal" data-target=".modalTambahJenis">Tambah Jenis</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped text-wrap table-kategori table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Jenis Kegiatan</th>
                                            <th>Bidang Kegiatan</th>
                                            <th>Status Jenis</th>
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
                                                <td class="text-center" id="jenis_<?= $j['id_jenis_kegiatan'] ?>"><?php if ($j['status_jenis']  == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $j['status_jenis'] ?>" id="status_jenis<?= $j['id_jenis_kegiatan'] ?>">
                                                        <button class="btn btn-success edit-jenis" data-toggle="modal" data-target=".modalEditJenis" data-id="<?= $j['id_jenis_kegiatan'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-jenis" data-id="<?= $j['id_jenis_kegiatan'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $j['id_jenis_kegiatan'] ?>,'jenis')">Ubah Status</button>
                                                    </div>
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
        </div>

        <div class="row">
            <!-- Tingkatan Kegiatan -->
            <div class="col-lg-12 col-md-12 col-12 col-sm-12" id="accordion">
                <div class="card">
                    <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="d-flex align-items-center"> <i class="fas fa-trophy mr-4" style="font-size: 30px;"></i> Tingkat Kegiatan</h4>
                        <div class="card-header-action">
                            <a data-collapse="#collapseThree" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="float-right btn btn-success mb-2 ml-2 detail-tingkatan" data-toggle="modal" data-target=".modalDetailTingkatan">Detail Tingkatan</button>
                                    <button class="float-right btn btn-primary mb-2 tambahTingkatan" data-toggle="modal" data-target=".modalTambahTingkatan">Tambah Tingkatan</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-kategori table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Tingkatan Kegiatan</th>
                                            <th>Status Tingkatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($tingkatan as $t) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $t['nama_tingkatan'] ?></td>
                                                <td class="text-center" id="tingkatan_<?= $t['id_tingkatan'] ?>">
                                                    <?php if ($t['status_tingkatan']  == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $t['status_tingkatan'] ?>" id="status_tingkatan<?= $t['id_tingkatan'] ?>">
                                                        <button class="btn btn-success edit-tingkatan" data-toggle="modal" data-target=".modalEditTingkatan" data-id="<?= $t['id_tingkatan'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-tingkatan" data-id="<?= $t['id_tingkatan'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button type="button" class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $t['id_tingkatan'] ?>,'tingkatan')">Ubah Status</button>
                                                    </div>
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
            <!-- Prestasi Kegiatan -->
            <div class="col-lg-12 col-md-12 col-12 col-sm-12" id="accordion">
                <div class="card">
                    <div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <h4 class="d-flex align-items-center"> <i class="fas fa-crown mr-4" style="font-size: 30px;"></i> Prestasi Kegiatan</h4>
                        <div class="card-header-action">
                            <a data-collapse="#collapseFour" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="float-right btn btn-info mb-2 ml-2 tambah-dasar" data-toggle="modal" data-target=".modalDasarPenilaian">Dasar Penilaian</button>
                                    <button class="float-right btn btn-success mb-2 ml-2 detail-prestasi" data-toggle="modal" data-target=".modalDetailPrestasi">Detail Prestasi</button>
                                    <button class="float-right btn btn-primary mb-2 tambahPrestasi" data-toggle="modal" data-target=".modalTambahPrestasi">Tambah Prestasi</button>
                                </div>
                            </div>
                            <div class="table-responsive">

                                <table class="table table-striped text-wrap table-kategori table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Prestasi Kegiatan</th>
                                            <th>Status Prestasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($prestasi as $p) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $p['nama_prestasi'] ?></td>
                                                <td class="text-center" id="prestasi_<?= $p['id_prestasi'] ?>">
                                                    <?php if ($p['status_prestasi']  == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $p['status_prestasi'] ?>" id="status_prestasi<?= $p['id_prestasi'] ?>">
                                                        <button class="btn btn-success edit-prestasi" data-toggle="modal" data-target=".modalEditPrestasi" data-id="<?= $p['id_prestasi'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-prestasi" data-id="<?= $p['id_prestasi'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button type="button" class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $p['id_prestasi'] ?>,'prestasi')">Ubah Status</button>
                                                    </div>

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
        </div>
    </section>
</div>


<!-- Awal Modal Detail Penilaian -->
<div class="modal fade bd-example-modal-lg modalDasarPenilaian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Dasar Penilaian</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="float-right btn btn-info mb-2 ml-2 tambah-dasar-penilaian" data-toggle="modal" data-target=".modalTambahDasarPenilaian">Tambah Dasar Penilaian</button>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-lg-12 tabel-semua-tingkatan">
                            <div class="table-responsive">
                                <table class="table table-striped table-kategori">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Dasar Penilaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-tabel">
                                        <?php $i = 1;
                                        foreach ($dasar_penilaian as $dp) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $dp['nama_dasar_penilaian'] ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-success edit-dasar-penilaian text-wrap" data-toggle="modal" data-target=".modalEditDasarPenilaian" data-id="<?= $dp['id_dasar_penilaian'] ?>"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-danger hapus-dasar-penilaian text-wrap" data-id="<?= $dp['id_dasar_penilaian'] ?>"><i class="fas fa-trash"></i></button>
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
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Penilaian -->

<!-- Awal Modal Tambah Dasar Penilaian -->
<div class="modal fade bd-example-modal-lg modalTambahDasarPenilaian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Dasar Penilaian Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahDasarPenilaian') ?>" method="post">
                                <div class="form-group">
                                    <label for="dasar_penilaian">Dasar Penilaian</label>
                                    <input type="text" class="form-control" id="dasar_penilaian" name="dasar_penilaian" placeholder="Masukkan nama dasar penilaian">
                                    <?= form_error('dasar_penilaian', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah Dasar Penilaian</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Dasar Penilaian -->

<!-- Awal Modal Edit Dasar Penilaian -->
<div class="modal fade bd-example-modal-lg modalEditDasarPenilaian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Dasar Penilaian Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editDasarPenilaian') ?>" method="post">
                                <div class="form-group">
                                    <label for="dasar_penilaian_edit">Dasar Penilaian</label>
                                    <input type="text" class="form-control" id="dasar_penilaian_edit" name="dasar_penilaian" placeholder="Masukkan nama dasar penilaian">
                                    <?= form_error('dasar_penilaian_edit', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Dasar Penilaian</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Edit Dasar Penilaian -->

<!-- Awal Modal Detail Tingkatan -->
<div class="modal fade bd-example-modal-lg modalDetailTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Semua Tingkatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="float-right btn btn-warning mb-2 ml-2 tambah-detail-tingkatan" data-toggle="modal" data-target=".modalTambahDetailTingkatan">Tambah Detail Tingkatan</button>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-lg-12 tabel-semua-tingkatan">
                            <div class="table-responsive">
                                <table class="table table-striped table-kategori">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Tingkatan</th>
                                            <th>Jenis Kegiatan</th>
                                            <th>Bidang Kegiatan</th>
                                            <th>Staus Tingkatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-tabel">
                                        <?php $i = 1;
                                        foreach ($semua_tingkatan as $st) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $st['nama_tingkatan'] ?></td>
                                                <td><?= $st['jenis_kegiatan'] ?></td>
                                                <td><?= $st['nama_bidang'] ?></td>
                                                <td class="text-center" id="semua_tingkatan_<?= $st['id_semua_tingkatan'] ?>">
                                                    <?php if ($st['status_st']  == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $st['status_st'] ?>" id="status_semua_tingkatan<?= $st['id_semua_tingkatan'] ?>">
                                                        <button class="btn btn-success edit-detail-tingkatan text-wrap" data-toggle="modal" data-target=".modalEditDetailTingkatan" data-id="<?= $st['id_semua_tingkatan'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-detail-tingkatan text-wrap" data-id="<?= $st['id_semua_tingkatan'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button type="button" class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $st['id_semua_tingkatan'] ?>,'semua tingkatan')">Ubah Status</button>
                                                    </div>
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
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Tingkatan -->

<!-- Awal Modal Edit Detail Tingkatan -->
<div class="modal fade bd-example-modal-lg modalEditDetailTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Detail Tingkatan Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editDetailTingkatan') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_detailT_edit" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control bidang_detailT_edit" id="bidang_detailT_edit" name="bidang">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_detailT_edit" class="col-form-label">Jenis Kegiatan</label>
                                    <select class="form-control jenis_detailT_edit" id="jenis_detailT_edit" name="jenis">
                                        <option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tingkatan_detailT_edit" class="col-form-label">Tingkatan Kegiatan</label>
                                    <select class="form-control tingkatan_detailT_edit" id="tingkatan_detailT_edit" name="tingkatan">
                                        <option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Detail Tingkatan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Edit Detail Tingkatan -->

<!-- Awal Modal Tambah Detail Tingkatan -->
<div class="modal fade bd-example-modal-lg modalTambahDetailTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Detail Tingkatan Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahDetailTingkatan') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_tambah" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control bidang_tambah" id=" bidang_tambah" name="bidang">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_tambah" class="col-form-label">Jenis Kegiatan</label>
                                    <select class="form-control jenis_tambah" id="jenis_tambah" name="jenis">
                                        <option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tingkatan_tambah" class="col-form-label">Tingkatan Kegiatan</label>
                                    <select class="form-control tingkatan_tambah" id="tingkatan_tambah" name="tingkatan">
                                        <option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah Detail Tingkatan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Detail Tingkatan -->

<!-- Awal Modal Detail Prestasi -->
<div class="modal fade bd-example-modal-lg modalDetailPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Semua Prestasi</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row">
                        <div class="col-lg-12">

                            <button class="float-right btn btn-warning mb-2 ml-2 tambah-detail-prestasi" data-toggle="modal" data-target=".modalTambahDetailPrestasi">Tambah Detail Prestasi</button>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-lg-12 tabel-semua-prestasi">
                            <div class="table-responsive">
                                <table class="table table-striped table-kategori">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Bidang</th>
                                            <th>Jenis</th>
                                            <th>Tingkatan</th>
                                            <th>Prestasi</th>
                                            <th>Bobot</th>
                                            <th>Dasar Penilaian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-tabel">
                                        <?php $i = 1;
                                        foreach ($semua_prestasi as $sp) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i; ?></td>
                                                <td><?= $sp['nama_bidang'] ?></td>
                                                <td><?= $sp['jenis_kegiatan'] ?></td>
                                                <td><?= $sp['nama_tingkatan'] ?></td>
                                                <td><?= $sp['nama_prestasi'] ?></td>
                                                <td><?= $sp['bobot'] ?></td>
                                                <td><?= $sp['nama_dasar_penilaian'] ?></td>
                                                <td class="text-center" id="semua_prestasi_<?= $sp['id_semua_prestasi'] ?>">
                                                    <?php if ($sp['status_sp']  == 1) : ?>
                                                        Aktif
                                                    <?php else : ?>
                                                        Tidak Aktif
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <input type="hidden" value="<?= $sp['status_sp'] ?>" id="status_semua_prestasi<?= $sp['id_semua_prestasi'] ?>">
                                                        <button class="btn btn-success edit-detail-prestasi text-wrap" data-toggle="modal" data-target=".modalEditDetailPrestasi" data-id="<?= $sp['id_semua_prestasi'] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger hapus-detail-prestasi text-wrap" data-id="<?= $sp['id_semua_prestasi'] ?>"><i class="fas fa-trash"></i></button>
                                                        <button type="button" class="btn btn-warning text-wrap" onclick="ubahStatus(<?= $sp['id_semua_prestasi'] ?>,'semua prestasi')">Ubah Status</button>
                                                    </div>
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
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Prestasi -->

<!-- Awal Modal Edit Detail Prestasi -->
<div class="modal fade bd-example-modal-lg modalEditDetailPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Detail Prestasi Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editDetailPrestasi') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_detailP_edit" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control bidang_detailP_edit" id="bidang_detailP_edit" name="bidang">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_detailP_edit" class="col-form-label">Jenis Kegiatan</label>
                                    <select class="form-control jenis_detailP_edit" id="jenis_detailP_edit" name="jenis">
                                        <option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tingkatan_detailP_edit" class="col-form-label">Tingkatan Kegiatan</label>
                                    <select class="form-control tingkatan_detailP_edit" id="tingkatan_detailP_edit" name="tingkatan">
                                        <option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="prestasi_detailP_edit" class="col-form-label">Prestasi</label>
                                    <select class="form-control prestasi_detailP_edit" id="prestasi_detailP_edit" name="prestasi">
                                        <option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dasar_detailP_edit" class="col-form-label">Dasar Penilaian</label>
                                    <select class="form-control dasar_detailP_edit" id="dasar_detailP_edit" name="dasar">
                                        <option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bobot_detailP_edit" class="col-form-label">Bobot</label>
                                    <input type="number" class="form-control bobot_detailP_edit" id="bobot_detailP_edit" name="bobot">
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Detail Prestasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Edit Detail Prestasi -->

<!-- Awal Modal Tambah Detail Prestasi -->
<div class="modal fade bd-example-modal-lg modalTambahDetailPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah Detail Prestasi Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/tambahDetailPrestasi') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_tambah" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control bidang_tambah_prestasi" id="bidang_tambah" name="bidang">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_tambah" class="col-form-label">Jenis Kegiatan</label>
                                    <select class="form-control jenis_tambah_prestasi" id="jenis_tambah" name="jenis">
                                        <option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tingkatan_tambah" class="col-form-label">Tingkatan Kegiatan</label>
                                    <select class="form-control tingkatan_tambah_prestasi" id="tingkatan_tambah" name="tingkatan">
                                        <option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="prestasi_tambah" class="col-form-label">Prestasi</label>
                                    <select class="form-control prestasi_tambah_prestasi" id="prestasi_tambah" name="prestasi">
                                        <option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dasar_tambah" class="col-form-label">Dasar Penilaian</label>
                                    <select class="form-control dasar_tambah_prestasi" id="dasar_tambah" name="dasar">
                                        <option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bobot_tambah" class="col-form-label">Bobot</label>
                                    <input type="number" class="form-control bobot_tambah_prestasi" id="bobot_tambah" name="bobot">
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah Detail Prestasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Tambah Detail Prestasi -->



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

<!-- Awal Modal Edit Bidang -->
<div class="modal fade bd-example-modal-lg modalEditBidang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Bidang</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editBidang') ?>" method="post">
                                <div class="form-group">
                                    <label for="bidang_kegiatan_edit">Bidang Kegiatan</label>
                                    <input type="text" class="form-control" id="bidang_kegiatan_edit" name="bidang_kegiatan" placeholder="Masukkan nama bidang kegiatan">
                                    <?= form_error('bidang_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Bidang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Edit Bidang -->


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
                                    <select class="form-control" id="bidang_kegiatan_tambah" name="bidang_kegiatan" placeholder="bidang_kegiatan">
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

<!-- Awal Modal Edit Jenis -->
<div class="modal fade bd-example-modal-lg modalEditJenis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Bidang</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editJenis') ?>" method="post">
                                <div class="form-group">
                                    <label for="jenis_kegiatan_edit">Jenis Kegiatan</label>
                                    <textarea class="form-control" id="jenis_kegiatan_edit" name="jenis_kegiatan" placeholder="Masukkan jenis kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                    <?= form_error('jenis_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="bidang_kegiatan" class="col-form-label">Bidang Kegiatan</label>
                                    <select class="form-control" id="bidang_kegiatan_jenis" name="bidang_kegiatan" placeholder="bidang_kegiatan">
                                        <option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>
                                        <!-- <option value="A">A</option>
                                        <option value="B">B</option> -->
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Jenis</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Edit Jenis -->


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

<!-- Awal Modal Edit Tingkatan -->
<div class="modal fade bd-example-modal-lg modalEditTingkatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Tingkatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editTingkatan') ?>" method="post">
                                <div class="form-group">
                                    <label for="tingkatan_kegiatan_edit">Tingkatan Kegiatan</label>
                                    <input type="text" class="form-control" id="tingkatan_kegiatan_edit" name="tingkatan" placeholder="Masukkan tingkatan kegiatan">
                                    <?= form_error('tingkatan_kegiatan_edit', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Tingkatan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Edit Tingkatan -->


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

<!-- Awal Modal Edit Prestasi -->
<div class="modal fade bd-example-modal-lg modalEditPrestasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Prestasi</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('kemahasiswaan/editPrestasi') ?>" method="post">
                                <div class="form-group">
                                    <label for="prestasi_kegiatan_edit">Prestasi Kegiatan</label>
                                    <input type="text" class="form-control" id="prestasi_kegiatan_edit" name="prestasi" placeholder="Masukkan nama Prestasi kegiatan">
                                    <?= form_error('prestasi_kegiatan_edit', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit Prestasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Edit Prestasi -->