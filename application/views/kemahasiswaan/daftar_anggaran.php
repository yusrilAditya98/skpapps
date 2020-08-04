<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kegiatan Lembaga</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kegiatan Lembaga Tahun - <?= $tahun_saat_ini ?></h4>
                        <div class="card-header-action">

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Kemahasiswaan/lembaga') ?>" method="get">
                            <div class="form-group float-right">
                                <div class="input-group">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option value="" selected="">Tahun...</option>
                                        <?php foreach ($tahun as $t) : ?>
                                            <option value="<?= $t['tahun_kegiatan'] ?>"><?= $t['tahun_kegiatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Tahun Periode</th>
                                        <th class="align-middle">Nama Lembaga</th>
                                        <th class="align-middle">Dana Pagu</th>
                                        <th class="align-middle">Dana Digunakan</th>
                                        <th class="align-middle">Sisa Dana</th>
                                        <th class="align-middle">Jumlah Kegiatan</th>
                                        <th class="align-middle">Kegiatan Terlaksana</th>
                                        <th class="align-middle">Kegiatan Belum Terlaksana</th>
                                        <th class="align-middle">Kegiatan Terlaksana Belum LPJ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1;
                                    foreach ($anggaran as $l) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $l['tahun_kegiatan'] ?></td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td>Rp.<?= number_format($l['anggaran_kemahasiswaan'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php if ($l['dana_kegiatan']) : ?>
                                                    Rp.<?= number_format($l['dana_kegiatan'], 0, ',', '.'); ?>
                                                <?php else : ?>
                                                    Rp.0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                Rp.<?= number_format($l['anggaran_kemahasiswaan'] - $l['dana_kegiatan'], 0, ',', '.');
                                                    ?>
                                            </td>
                                            <td>
                                                <?php if ($l['jumlah_kegiatan']) : ?>
                                                    <a class="d-anggaran" data-toggle="modal" data-target="#daftarKegiatan" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_kegiatan'] ?>" data-status="Jumlah Kegiatan" data-kondisi="jmlh" href=""><?= $l['jumlah_kegiatan'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['terlaksana']) : ?>
                                                    <a class="d-anggaran" data-toggle="modal" data-target="#daftarKegiatan" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_kegiatan'] ?>" data-status="Jumlah  Kegiatan Terlaksana" data-kondisi="terlaksana" href=""> <?= $l['terlaksana'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['blm_terlaksana']) : ?>
                                                    <a class="d-anggaran" data-toggle="modal" data-target="#daftarKegiatan" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_kegiatan'] ?>" data-status="Jumlah  Kegiatan Belum Terlaksana" data-kondisi="blmTerlaksana" href=""> <?= $l['blm_terlaksana'] ?></a>
                                                <?php else : ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($l['blm_lpj']) : ?>
                                                    <a class="d-anggaran" data-toggle="modal" data-target="#daftarKegiatan" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_kegiatan'] ?>" data-status="Jumlah  Kegiatan Terlaksana Belum LPJ" data-kondisi="terlaksana_blm_lpj" href=""> <?= $l['blm_lpj'] ?></a>
                                                <?php else : ?>
                                                    0
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
            <div class="col-lg-6 col-md-12 col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Anggaran Lembaga</h4>
                        <div class="card-header-action">
                            <a href="#" data-toggle="modal" data-target="#tambahAnggaran" data-id="" class="btn btn-icon icon-left btn-success float-right tambahAnggaran"><i class="fas fa-plus"></i>Tambah Anggaran Lembaga</a>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="table-1">
                                <thead>
                                    <tr class="text-center">
                                        <th class="align-middle">Lembaga</th>
                                        <th class="align-middle">Tahun</th>
                                        <th class="align-middle">Anggaran Dana Pagu</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dana_pagu as $d) : ?>
                                        <tr>
                                            <td><?= $d['nama_lembaga'] ?></td>
                                            <td><?= $d['tahun_pengajuan'] ?></td>
                                            <td>Rp.<?= number_format($d['anggaran_kemahasiswaan'], 0, ',', '.');  ?></td>
                                            <td>
                                                <a href="#" class="btn btn-primary edit-anggaran" data-toggle="modal" data-target="#editAnggaran" data-id="<?= $d['id_lembaga'] ?>" data-tahun="<?= $d['tahun_pengajuan'] ?>"><i class="fas fa-edit"></i> </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Periode Pengajuan Rancangan Lembaga</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 10%;">Tahun Periode</th>
                                        <th style="width: 12%;">Nama Lembaga</th>
                                        <th style="width: 10%;">Status Rancangan</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1;
                                    foreach ($lembaga as $l) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><a href="#" class="periode-rancangan" data-toggle="modal" data-target="#periode-rancangan" data-id="<?= $l['id_lembaga'] ?>" data-id="<?= $l['id_lembaga'] ?>" data-tahun="<?= $l['tahun_rancangan'] ?>"><?= $l['tahun_rancangan'] ?></a></td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td>
                                                <?php if ($l['status_rencana_kegiatan'] == 1) : ?>
                                                    <span class="badge badge-success">open</span>
                                                <?php else : ?>
                                                    <span class="badge badge-danger">close</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="<?= base_url('Kemahasiswaan/pembukaanRancanganKegiatan/') . $l['id_lembaga'] . '?status=1' ?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i> </a>

                                                    <a href="<?= base_url('Kemahasiswaan/pembukaanRancanganKegiatan/') . $l['id_lembaga'] . '?status=0' ?>" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> </a>

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
                            <?php $tahun = date('Y') - 2  ?>
                            <?php for ($i = 0; $i < 10; $i++) : ?>
                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                <?php $tahun++; ?>
                            <?php endfor; ?>

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
<!-- modal -->


<!-- edit anggaran -->
<div class="modal fade" tabindex="-1" role="dialog" id="daftarKegiatan">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Daftar </h5> <span class="judul"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-md-12 col-lg-12">
                    <table class="table table-striped" id="table-2">
                        <thead>
                            <tr>
                                <th class="text"> No</th>
                                <th>Nama Proker</th>
                                <th>Dana Pagu </th>
                            </tr>
                        </thead>
                        <tbody class="anggaran-lembaga">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<!-- model edit periode -->
<div class="modal fade" tabindex="-1" role="dialog" id="periode-rancangan">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Ubah tahun rancangan </h5> <span class="judul"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-tahun-rancangan" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-12 col-form-label">Tahun periode</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control tahun-rancangan" name="tahun_rancangan" value="">
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
<!-- akhir modal -->