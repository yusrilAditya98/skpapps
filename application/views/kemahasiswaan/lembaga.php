<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Lembaga Fakultas Ekonomi dan Bisnis Universitas Brawijaya</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-lg-8">
                            <h4>Daftar Lembaga</h4>
                        </div>
                        <div class="col-lg-4">


                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="alert alert-warning " role="alert" style="opacity: 1; color:black; background-color:rgba(35, 182, 246, 0.4)">
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <span class="font-weight-bold">Perhatian!</span> Pastikan anda memeriksa
                                        kembali rencana kegiatan yang akan dibuat
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <form action="<?= base_url('Kemahasiswaan/pembukaanRancanganKegiatan') ?>" method="post" class="needs-validation" novalidate="">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <select class="custom-select" id="tahun" name="tahun_rancangan" required>
                                                        <option value="">Choose...</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="submit" class=" float-right btn btn-primary">Aktifkan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Periode</th>
                                        <th>Nama Lembaga</th>
                                        <th>Jumlah Kegiatan</th>
                                        <th>Kegiatan Terlaksana</th>
                                        <th>Kegiatan Belum Terlaksana</th>
                                        <th>Status Pengajuan Rancangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($lembaga as $l) : ?>
                                        <tr>
                                            <td><?= $i++;  ?></td>
                                            <td>2019</td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td>10</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>
                                                <?php if ($l['status_rencana_kegiatan'] == 0) : ?>
                                                    <span class="badge badge-secondary">disable</span>
                                                <?php else : ?>
                                                    <span class="badge badge-success">enable</span>
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