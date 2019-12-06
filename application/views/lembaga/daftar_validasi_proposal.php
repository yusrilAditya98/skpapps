<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Proposal Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Proposal Kegiatan</h4>

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
                                    <?php $j = 1;
                                    foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td>

                                                <?= $j++; ?>

                                            </td>
                                            <td><?= $k['tgl_pengajuan_proposal'] ?></td>
                                            <td><?= $k['nama_lembaga'] ?></td>
                                            <td>
                                                <a href="#" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-target="#i-kegiatan" data-jenis="proposal"><?= $k['nama_kegiatan'] ?></a>
                                            </td>
                                            <td>
                                                <?php if ($k['status_selesai_proposal'] == 0) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-primary"></i>Belum diproses</span>
                                                <?php elseif ($k['status_selesai_proposal'] == 1) : ?>
                                                    <span>Sedang Berlangsung</span>
                                                <?php elseif ($k['status_selesai_proposal'] == 2) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-warning"></i>Revisi</span>
                                                <?php elseif ($k['status_selesai_proposal'] == 3) : ?>
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
                                                <?php for ($i = 0; $i < count($validasi); $i++) : ?>
                                                    <?php if ($validasi[$i]['id_kegiatan'] == $k['id_kegiatan'] && $validasi[$i]['jenis_validasi'] == 2) : ?>
                                                        <?php if ($validasi[$i]['status_validasi'] == 3) : ?>
                                                            <span>Tidak bisa validasi</span>
                                                            <?php break; ?>
                                                        <?php elseif ($validasi[$i]['status_validasi'] == 0 || $validasi[$i]['status_validasi'] == 2 || $validasi[$i]['status_validasi'] == 4) : ?>
                                                            <a href="<?= base_url('Kegiatan/validasiProposal/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=2" class="btn btn-icon btn-success"><i class="fas fa-check"> </i></a>
                                                            <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn btn-icon btn-primary d-valid   " data-kegiatan="<?= $k['id_kegiatan'] ?>"><i class="fas fa-times"> </i></a>

                                                        <?php else : ?>
                                                            <span>Selesai</span>
                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                <?php endfor; ?>
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