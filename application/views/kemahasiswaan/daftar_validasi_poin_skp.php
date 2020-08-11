<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Poin Skp</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Poin Skp</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url($this->uri->segment(1) . "/" . $this->uri->segment(2)) ?>" method="get">
                            <div class="row">
                                <div class="col-lg-4">
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="end_date" type="date" class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Jenis Validasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-feather-alt"></i>
                                                </div>
                                            </div>
                                            <select class="form-control" name="validasi" id="validasi-skp">
                                                <option value="" selected>--Jenis Validasi--</option>
                                                <option value="1">Valid</option>
                                                <option value="0">Proses</option>
                                                <option value="2">Revisi</option>
                                            </select>
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary">submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered" id="table-1">
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Tanggal Pengajuan</th>
                                        <th class="align-middle">Nim</th>
                                        <th class="align-middle">Nama Mahasiswa</th>
                                        <th class="align-middle">Nama Kegiatan</th>
                                        <th class="align-middle">Validasi</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($poinskp as $p) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
                                            <td><?= date("d-m-Y", strtotime($p['tgl_pengajuan']))  ?></td>
                                            <td><?= $p['nim'] ?></td>
                                            <td><?= $p['nama'] ?> </td>
                                            <td><a href="#" data-toggle="modal" data-target="#detailKegiatan" data-id="<?= $p['id_poin_skp'] ?>" onclick="detailValidasiSKP(<?= $p['id_poin_skp'] ?>)" class="detailSkp"><?= $p['nama_kegiatan'] ?></a></td>
                                            <td>
                                                <?php if ($p['validasi_prestasi'] == 0) : ?>
                                                    <div class="badge badge-primary">Proses</div>
                                                <?php elseif ($p['validasi_prestasi'] == 1) : ?>
                                                    <div><i class="fa fa-check text-success" aria-hidden="true"></i></div>
                                                <?php elseif ($p['validasi_prestasi'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi" data-skp="<?= $p['id_poin_skp'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form action="<?= base_url('Kemahasiswaan/validasiSkp/') . $p['id_poin_skp'] ?>" method="post">
                                                    <input type="hidden" value=1 name="valid">
                                                    <input type="hidden" value="-" name="catatan">
                                                    <?php if ($p['validasi_prestasi'] == 0 || $p['validasi_prestasi'] == 2) :
                                                    ?>
                                                        <div class="btn-group">
                                                            <button onclick="return confirm('Apakah anda ingin memvalidasi?')" type="submit" class="btn btn-icon btn-success">valid</i></button>
                                                            <a data-toggle="modal" data-target=".infoRevisi" class="btn btn-icon btn-primary d-revisi text-white" data-skp="<?= $p['id_poin_skp'] ?>">catatan</a>
                                                            <a href="<?= base_url('Mahasiswa/editPoinSkp/') . $p['id_poin_skp']  ?>" class="btn btn-primary">edit</a>
                                                            <a href="<?= base_url('Kemahasiswaan/hapusPoinSkp/') . $p['id_poin_skp']  ?>" class="btn btn-danger confirm-hapus">hapus</a>
                                                        </div>
                                                    <?php else :
                                                    ?> <div class="btn-group">
                                                            <a data-toggle="modal" data-target=".infoRevisi" class="btn btn-icon btn-primary d-revisi text-white" data-skp="<?= $p['id_poin_skp'] ?>">catatan</a>
                                                            <a href="<?= base_url('Mahasiswa/editPoinSkp/') . $p['id_poin_skp']  ?>" class="btn btn-primary">edit</a>
                                                            <a href="<?= base_url('Kemahasiswaan/hapusPoinSkp/') . $p['id_poin_skp']  ?>" class="btn btn-danger confirm-hapus">hapus</a>
                                                        </div>
                                                    <?php endif;
                                                    ?>
                                                </form>
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
<!-- modal detail skp -->
<div class=" modal fade" tabindex="-1" role="dialog" id="detailKegiatan">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail poin skp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="<?= base_url() ?>/assets/img/medal.png" style="width: 100px" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Tingkatan</div>
                                    <div class="profile-widget-item-value"><span class="d-tingkat"></span></div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Partisipasi/jabatan</div>
                                    <div class="profile-widget-item-value"><span class="d-partisipasi"></span></div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Bobot</div>
                                    <div class="profile-widget-item-value"><span class="d-bobot"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name"><span class="d-bidang"></span>
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div> <span class="d-jenis"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-nama" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Mulai Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tgl" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Selesai Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tgl-selesai" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tempat Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tempat" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">File Bukti</label>
                                <div class="col-sm-9">
                                    <a target="_blank" href="" class="d-file btn btn-primary">lihat</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke t-validasi br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal revisi -->
<div class="modal fade infoRevisi" tabindex="-1" role="dialog" id="infoRevisi">
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
                                        <textarea name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>