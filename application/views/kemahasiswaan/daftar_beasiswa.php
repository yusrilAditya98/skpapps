<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Penerima Beasiswa</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Beasiswa Mahasiswa</h4>
                    </div>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="<?= base_url('Kemahasiswaan/tambahBeasiswa') ?>" class="btn btn-primary float-right ml-2"><i class="fas fa-plus mr-2 "></i>Tambah beasiswa</a>
                                <a href="<?= base_url('Kemahasiswaan/exportBeasiswa') ?>" class="btn btn-success float-right"><i class="fas fa-file-excel mr-2 "></i>Export to excel</a>
                                <a href="#" class="btn btn-info float-right mr-2" data-toggle="modal" data-target="#kategoriBeasiswa"><i class="fas fa-info mr-2"></i>Kategori Beasiswa</a>
                            </div>

                        </div>
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
                            <table class="table table-striped table-bordered" id="table-2">
                                <thead>
                                    <tr class="text-center">
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Nim</th>
                                        <th class="align-middle">Nama Mahasiswa</th>
                                        <th class="align-middle">Jenis Beasiswa</th>
                                        <th class="align-middle">Tahun Menerima</th>
                                        <th class="align-middle">Lama Menerima</th>
                                        <th class="align-middle">Nominal</th>
                                        <th class="align-middle">Bukti</th>
                                        <th class="align-middle">Lampiran</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($beasiswa as $b) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
                                            <td><?= $b['nim'] ?></td>
                                            <td><?= $b['nama'] ?></td>
                                            <td><?= $b['jenis_beasiswa'] . "-" . $b['nama_instansi'] ?> </td>
                                            <td><?= date("d-m-Y", strtotime($b['tahun_menerima'])) ?></td>
                                            <td><?= date("d-m-Y", strtotime($b['lama_menerima'])) ?></td>
                                            <td>Rp.<?= number_format($b['nominal'], 0, ',', '.'); ?></td>
                                            <td><a target="_blank" href="<?= base_url() ?>assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $b['bukti']  ?>">lihat</a></td>
                                            <td><a target="_blank" href="<?= base_url() ?>/assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $b['lampiran']  ?>">lihat</a></td>
                                            <th><?php if ($b['validasi_beasiswa'] == 0) : ?>
                                                    <div class="badge badge-primary"> Proses</div>
                                                <?php elseif ($b['validasi_beasiswa'] == 1) : ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($b['validasi_beasiswa'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php endif; ?></th>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('Kemahasiswaan/validasiBeasiswa/') . $b['id_penerima'] ?>?status=1" class="btn btn-success">valid</a>
                                                    <a href="<?= base_url('Kemahasiswaan/validasiBeasiswa/') . $b['id_penerima'] ?>?status=2" class="btn btn-danger">tolak</a>
                                                    <a href="<?= base_url('Kemahasiswaan/editBeasiswa/') . $b['id_penerima'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                </div>

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

<!-- modal kategori beasiswa -->
<div class="modal fade" id="kategoriBeasiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriBeasiswaLabel">Daftar Beasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Kemahasiswaan/tambahJenisBeasiswa') ?>" method="post">
                    <div class="input-group mb-4">
                        <input type="text" name="jenis_beasiswa" placeholder="tambah jenis beasiswa..." class="form-control">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori Beasiswa</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            <?php foreach ($kategori_beasiswa as $kb) : ?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td>
                                        <form action="<?= base_url('Kemahasiswaan/editJenisBeasiswa/') . $kb['id'] ?>" method="post">
                                            <div class="input-group">
                                                <input type="text" name="jenis_beasiswa" value="<?= $kb['jenis_beasiswa'] ?>" class="form-control">
                                                <div class="input-group-prepend">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-small" href="<?= base_url('Kemahasiswaan/hapusJenisBeasiswa/') . $kb['id'] ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- akhir modal -->