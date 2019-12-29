<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan LPJ</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengajuan LPJ Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('kegiatan/pengajuanLpj') ?>" method="post">
                            <div class="row  float-right">
                                <div class="form-group col-6">
                                    <label>Mulai Tanggal Pengajuan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input name="start_date" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Akhir Tanggal Pengajuan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input name="end_date" type="date" class="form-control">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTabelKegiatan">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Status Proposal</th>
                                        <th>BEM</th>
                                        <th>Kmhs</th>
                                        <th>WD3</th>
                                        <th>PSIK</th>
                                        <th>Keuangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <?php if ($k['tgl_pengajuan_lpj'] == '0000-00-00') : ?>
                                                <td>Belum Mengajukan LPJ</td>
                                            <?php else : ?>
                                                <td><?= $k['tgl_pengajuan_lpj'] ?></td>
                                            <?php endif; ?>
                                            <td><a href="#" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-target="#i-kegiatan" data-jenis="lpj"><?= $k['nama_kegiatan'] ?></a>
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
                                                            <?php $jenis_revisi = $v['jenis_validasi']; ?>
                                                        <?php elseif ($v['status_validasi'] == 0) : ?>
                                                            <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 4) : ?>
                                                            <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 3) : ?>
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <td>
                                                <?php if ($k['status_selesai_lpj'] == 0) : ?>
                                                    <a href="<?= base_url('Kegiatan/tambahLpj/') . $k['id_kegiatan'] ?>" class="btn btn-icon btn-outline-success"><i class="fas fa-edit"></i>Lpj</a>
                                                <?php elseif ($k['status_selesai_lpj'] == 2) : ?>
                                                    <form action="<?= base_url('Kegiatan/editLpj/') . $k['id_kegiatan'] ?>" method="post">
                                                        <input type="hidden" name="jenis_revisi" value="<?= $jenis_revisi ?>">
                                                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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

<!-- Info revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="infoRevisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Catatan Revisi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control d-catatan" style="height:200px" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>