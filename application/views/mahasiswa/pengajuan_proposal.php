<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Proposal</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengajuan Proposal Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('Mahasiswa/tambahProposal') ?>" style="float:right" class="btn btn-icon btn-success mb-3">
                            Pengajuan Proposal <i class="fas fa-plus pl-2"></i></a>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col" rowspan="2">No</th>
                                        <th scope="col" rowspan="2">Tanggal Pengajuan</th>
                                        <th scope="col" rowspan="2">Nama Kegiatan</th>
                                        <th scope="col" rowspan="2">Status Proposal</th>
                                        <th scope="col" colspan="5" class="text-center">Validasi</th>
                                        <th scope="col" rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <th>BEM</th>
                                        <th>Kmhs</th>
                                        <th>WD3</th>
                                        <th>PSIK</th>
                                        <th>Keuangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <th scope="row"><?= $index++ ?></th>
                                            <td><?= $k['tgl_pengajuan_proposal'] ?></td>
                                            <td><a href="" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-jenis="proposal" data-target="#i-kegiatan"><?= $k['nama_kegiatan'] ?></a>
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
                                            <?php $jenis_revisi = 0; ?>
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
                                                <?php if ($k['status_selesai_proposal'] == 0) : ?>
                                                    <a href="<?= base_url('Mahasiswa/editProposal/') . $k['id_kegiatan'] ?>?jenis_revisi=<?= $jenis_revisi ?>" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('Mahasiswa/hapusKegiatan/') . $k['id_kegiatan']; ?>" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                                                <?php elseif ($k['status_selesai_proposal'] == 2) : ?>
                                                    <a href="<?= base_url('Mahasiswa/editProposal/') . $k['id_kegiatan'] ?>?jenis_revisi=<?= $jenis_revisi ?>" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tr>
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