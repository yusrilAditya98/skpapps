<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Lpj Kegiatan</h4>

                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-icon icon-left btn-warning float-right"><i class="fas fa-print"></i> Cetak Pengajuan</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>

                                    <th class="text">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            No
                                        </div>
                                    </th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Pengaju</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Status</th>
                                    <th class="text-center">BEM</th>
                                    <th class="text-center">Kmhsn</th>
                                    <th class="text-center">WD 3</th>
                                    <th class="text-center">PSIK</th>
                                    <th class="text-center">Keuangan</th>
                                    <th class="text-center">Action</th>

                                </thead>
                                <tbody>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    1
                                                </div>
                                            </td>
                                            <td><?= $k['tgl_pengajuan_lpj'] ?></td>
                                            <td><?= $k['nama_lembaga'] ?></td>
                                            <td>
                                                <a href="#" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-target="#i-kegiatan" data-jenis="lpj"><?= $k['nama_kegiatan'] ?></a>
                                            </td>
                                            <td>
                                                <?php if ($k['status_selesai_lpj'] == 0) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-primary"></i>Belum diproses</span>
                                                <?php elseif ($k['status_selesai_lpj'] == 1) : ?>
                                                    <span>Sedang Berlangsung</span>
                                                <?php elseif ($k['status_selesai_lpj'] == 2) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-warning"></i>Revisi</span>
                                                <?php elseif ($k['status_selesai_lpj'] == 3) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-success"></i>Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php foreach ($validasi as $v) : ?>
                                                <?php if ($v['id_kegiatan'] == $k['id_kegiatan']) : ?>
                                                    <td class="text-center">
                                                        <?php if ($v['status_validasi'] == 1) :  ?>
                                                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 2) : ?>
                                                            <div class="btn btn-warning circle-content detail-revisi" data-toggle="modal" data-target="#i-revisi" data-id="<?= $v['id'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                        <?php elseif ($v['status_validasi'] == 4) : ?>
                                                            <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 0) : ?>
                                                            <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 3) : ?>
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <td class="text-center">
                                                <?php foreach ($validasi as $v) : ?>
                                                    <?php if ($v['id_kegiatan'] == $k['id_kegiatan'] && ($v['jenis_validasi'] == 3)) : ?>
                                                        <?php if ($v['status_validasi'] == 4 || $v['status_validasi'] == 2) : ?>
                                                            <a href="<?= base_url('Kemahasiswaan/validasiLpj/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=3" class="btn btn-icon btn-success"><i class="fas fa-check"> </i>kmhsn</a>
                                                            <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn btn-icon btn-primary d-valid-km-lpj" data-kegiatan="<?= $k['id_kegiatan'] ?>"><i class="fas fa-times"> </i>kmhsn</a>

                                                        <?php endif; ?>
                                                    <?php elseif ($v['id_kegiatan'] == $k['id_kegiatan'] && ($v['jenis_validasi'] == 4)) : ?>
                                                        <?php if ($v['status_validasi'] == 4 || $v['status_validasi'] == 2) : ?>
                                                            <a href=" <?= base_url('Kemahasiswaan/validasiLpj/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=4" class="btn btn-icon btn-success"><i class="fas fa-check"> </i>wd 3</a>
                                                            <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn btn-icon btn-primary d-valid-lpj" data-kegiatan="<?= $k['id_kegiatan'] ?>"><i class="fas fa-times"> </i>wd 3</a>
                                                        <?php elseif ($v['status_validasi'] == 1) : ?>
                                                            Selesai
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
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
                                    <input type="hidden" name="revisi" value="2">
                                    <input type="hidden" name="jenis_validasi" class="jenis_validasi">
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