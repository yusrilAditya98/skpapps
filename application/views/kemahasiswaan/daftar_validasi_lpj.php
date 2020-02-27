<!-- Main Content -->


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Lpj Kegiatan</h4>

                    </div>
                    <div class="card-body" style="margin-bottom: -3rem">
                        <form action="<?= base_url($this->uri->segment(1) . "/" . $this->uri->segment(2)) ?>" method="get">
                            <div class="row">
                                <div class="col-lg-6">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="end_date" type="date" class="form-control">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary">submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form action="<?= base_url('Kemahasiswaan/cetakPengajuanProposal') ?>" method="post" target="_blank">
                        <div class="card-body mb-2">
                            <div class="kategori-filter float-right mb-2">
                                <button type="submit" class="btn btn-icon icon-left btn-warning float-right ml-5"><i class="fas fa-print"></i> Cetak Pengajuan</button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTabelProposal">
                                    <thead>

                                        <th class="text">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nama Pengaju</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Status</th>
                                        <th>BEM</th>
                                        <th>Kmhsn</th>
                                        <th>WD 3</th>
                                        <th>PSIK</th>
                                        <th>Keuangan</th>
                                        <th>Action</th>
                                        <th></th>

                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($kegiatan as $k) : ?>
                                            <tr>
                                                <td>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="hidden" name="checkbox-<?= $k['id_kegiatan'] ?>" value="1">
                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-<?= $k['id_kegiatan'] ?>" name="cek_<?= $k['id_kegiatan'] ?>" value="1">
                                                        <label for="checkbox-<?= $k['id_kegiatan'] ?>" class="custom-control-label">&nbsp;</label>
                                                        <?= $i++ ?>
                                                    </div>
                                                </td>
                                                <td><?= date("d-m-Y", strtotime($k['tgl_pengajuan_lpj'])) ?></td>
                                                <td><?= $k['nama_lembaga'] ?></td>
                                                <td><a href="#" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-target="#i-kegiatan" data-role_id="" data-jenis="lpj"><?= $k['nama_kegiatan'] ?></a>
                                                </td>
                                                <?php if ($k['status_selesai_lpj'] == 0) : ?>
                                                    <td class="text-secondary">
                                                        Belum diproses
                                                    </td>
                                                <?php elseif ($k['status_selesai_lpj'] == 1) : ?>
                                                    <td class="text-primary">
                                                        Sedang Berlangsung
                                                    </td>
                                                <?php elseif ($k['status_selesai_lpj'] == 2) : ?>
                                                    <td class="text-warning">
                                                        Revisi
                                                    </td>
                                                <?php elseif ($k['status_selesai_lpj'] == 3) : ?>
                                                    <td class="text-success">
                                                        Selesai
                                                    </td>
                                                <?php endif; ?>
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
                                                                <a href="<?= base_url('Kemahasiswaan/validasiLpj/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=3" class="btn btn-sm btn-success confirm-validasi"><i class="fas fa-check"> </i>kmhsn</a>
                                                                <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn btn-sm btn-primary d-valid-km-lpj" data-kegiatan="<?= $k['id_kegiatan'] ?>"><i class="fas fa-times"> </i>kmhsn</a>
                                                                <input type="hidden" class="role_id" value="3">
                                                            <?php elseif ($v['status_validasi'] == 0) : ?>
                                                                Belum bisa validasi
                                                            <?php endif; ?>
                                                        <?php elseif ($v['id_kegiatan'] == $k['id_kegiatan'] && ($v['jenis_validasi'] == 4)) : ?>
                                                            <?php if ($v['status_validasi'] == 4 || $v['status_validasi'] == 2) : ?>
                                                                <a href=" <?= base_url('Kemahasiswaan/validasiLpj/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=4" class="btn btn-sm btn-success confirm-validasi"><i class="fas fa-check"> </i>wd 3</a>
                                                                <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn btn-sm btn-primary d-valid-lpj" data-kegiatan="<?= $k['id_kegiatan'] ?>"><i class="fas fa-times"> </i>wd 3</a>
                                                                <input type="hidden" class="role_id" value="4">
                                                            <?php elseif ($v['status_validasi'] == 1) : ?>
                                                                Selesai
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                </td>
                                                <td>
                                                    <a target="_blank" href="<?= base_url('Kemahasiswaan/cetakPengajuanDana/') . $k['id_kegiatan'] ?>?status=lpj" class="btn btn-primary"><i class="text-warning fas fa-file-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <th class="text">
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>