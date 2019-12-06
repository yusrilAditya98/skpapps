<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Lpj Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <a href="#" data-toggle="modal" data-target="#tambahAnggaran" data-id="" class="btn btn-icon icon-left btn-success float-right tambahAnggaran"><i class="fas fa-plus"></i>Tambah Anggaran Lembaga</a>
                        <div class="col-2 float-right">
                            <form action="<?= base_url('Kegiatan/pengajuanRancangan') ?>" method="get">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                            <option value="" selected="">Tahun...</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Periode</th>
                                        <th>Nama Lembaga</th>
                                        <th>Dana Pagu</th>
                                        <th>Sisa Dana</th>
                                        <th>Jumlah Kegiatan</th>
                                        <th>Kegiatan Terlaksana</th>
                                        <th>Kegiatan Belum Terlaksana</th>
                                        <th>Status Rancangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1;
                                    foreach ($anggaran as $l) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $l['tahun_kegiatan'] ?></td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td><?= $l['anggaran_kemahasiswaan'] ?></td>
                                            <td><?= $l['dana_kegiatan'] ?></td>
                                            <td>
                                                <?php if ($l['jumlah_kegiatan']) : ?>
                                                    <a href=""><?= $l['jumlah_kegiatan'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['terlaksana']) : ?>
                                                    <a href=""> <?= $l['terlaksana'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['blm_terlaksana']) : ?>
                                                    <a href=""> <?= $l['blm_terlaksana'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['status_rencana_kegiatan'] == 1) : ?>
                                                    <span class="badge badge-success">open</span>
                                                <?php else : ?>
                                                    <span class="badge badge-danger">close</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <a href="<?= base_url('Kemahasiswaan/pembukaanRancanganKegiatan/') . $l['id_lembaga'] . '?status=1' ?>" class="btn btn-success"><i class="fas fa-check"></i> </a>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <a href="<?= base_url('Kemahasiswaan/pembukaanRancanganKegiatan/') . $l['id_lembaga'] . '?status=1' ?>" class="btn btn-danger"><i class="fas fa-times"></i> </a>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <a href="#" class="btn btn-primary edit-anggaran" data-toggle="modal" data-target="#editAnggaran" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_kegiatan'] ?>"><i class="fas fa-edit"></i> </a>
                                                    </div>
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


<!-- Info revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahAnggaran">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Penambahan Dana Pagu Lembaga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Kemahasiswaan/tambahAnggaranKegiatan') ?>" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="text"> No</th>
                                        <th>Nama Lembaga Pengaju</th>
                                        <th>Dana Pagu </th>
                                    </tr>
                                </thead>
                                <tbody class="data-lembaga">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <div class="input-group">
                        <select class="custom-select" id="tahun" name="tahun_rancangan" required>
                            <option value="">Pilih tahun pengajuan proker...</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit anggaran -->
<div class="modal fade" tabindex="-1" role="dialog" id="editAnggaran">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dana Pagu Lembaga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Kemahasiswaan/editAnggaranRancangan/')  ?>" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="form-group">
                                <label class="col-sm-3 col-form-label">Nama Lembaga</label>
                                <input type="hidden" class="id-lembaga" name="id_lembaga" value="">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control nama-lembaga" readonly value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-form-label">Tahun Anggaran</label>
                                <div class="col-sm-12">
                                    <input type="text" name="tahun" class="form-control tahun-anggaran" readonly value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-form-label">Nominal Anggaran</label>
                                <div class="col-sm-12">
                                    <input type="text" name="nominal" class="form-control nominal-anggaran" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>