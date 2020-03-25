<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Poin Skp Mahasiswa</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url("Kemahasiswaan/exportSkp") ?>" class="btn btn-success float-right text-white mb-2"> <i class="fas fa-file-excel mr-2 "></i> Export to excel </a>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="dataTabelPoinSkp">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Prodi</th>
                                        <th>Poin SKP</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1;
                                    foreach ($mahasiswa as $m) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $m['nim'] ?></td>
                                            <td><?= $m['nama'] ?></td>
                                            <td><?= $m['nama_jurusan'] ?></td>
                                            <td><?= $m['nama_prodi'] ?></td>
                                            <td>
                                                <?= $m['total_poin_skp'] ?>
                                            </td>
                                            <?php if ($m['total_poin_skp'] >= 100 && $m['total_poin_skp'] <= 150) : ?>
                                                <td> Cukup</td>
                                            <?php elseif ($m['total_poin_skp'] >= 151 && $m['total_poin_skp'] <= 200) : ?>
                                                <td>Baik</td>
                                            <?php elseif ($m['total_poin_skp'] >= 201 && $m['total_poin_skp'] <= 300) : ?>
                                                <td> Sangat Baik</td>
                                            <?php elseif ($m['total_poin_skp'] > 300) : ?>
                                                <td> Dengan Pujian</td>
                                            <?php else : ?>
                                                <td> Kurang</td>
                                            <?php endif; ?>
                                            <td>
                                                <button class="btn btn-primary detail-SKP" data-toggle="modal" data-target=".modalDetailSKP" data-id="<?= $m['nim'] ?>"><i class="fas fa-eye"></i></button>

                                                <a href="<?= base_url('Kemahasiswaan/cetakSkp?nim=') . $m['nim'] ?>" target="_blank" class="btn btn-icon btn-warning mb-3"><i class="fas fa-print"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Prodi</th>
                                        <th>Poin SKP</th>
                                        <th>Kategori</th>
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

<!-- Awal Modal Detail Profil -->
<div class="modal fade bd-example-modal-lg modalDetailSKP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                <h6 class="card-title nama_mahasiswa"></h6>
                                <h6 class="card-title nim_mahasiswa"></h6>
                                <h6 class="card-title prodi_mahasiswa"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Prestasi</th>
                                                <th>Tingkatan</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Bidang</th>
                                                <th>Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-skp">
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
<!-- Akhir Modeal Detail Profil -->

<!-- modal revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="infoRevisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-revisi" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-description">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Catatan Revisi</label>
                                    <div class="col-sm-9">
                                        <textarea readonly name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>