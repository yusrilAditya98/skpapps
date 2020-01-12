<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Rancangan Kegiatan</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Nama Lembaga</th>
                                        <th>Nama Proker</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Dana Anggaran</th>
                                        <th>Validasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($detail_rancangan as $r) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
                                            <td><?= $r['tahun_kegiatan'] ?></td>
                                            <td><?= $r['nama_lembaga'] ?></td>
                                            <td><?= $r['nama_proker'] ?></td>
                                            <td><?= date("d M Y", strtotime($r['tanggal_mulai_pelaksanaan'])) . ' - ' . date("d M Y", strtotime($r['tanggal_selesai_pelaksanaan']))  ?></td>
                                            <td><?= $r['anggaran_kegiatan'] ?></td>
                                            <td>
                                                <?php if ($r['status_rancangan'] == 1) :  ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($r['status_rancangan'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content detail-revisi-rancangan" data-toggle="modal" data-target="#i-revisi" data-catatan="<?= $r['catatan_revisi'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php elseif ($r['status_rancangan'] == 3) : ?>
                                                    <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                <?php elseif ($r['status_rancangan'] == 0) : ?>
                                                    <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if ($r['status_rancangan'] == 2 || $r['status_rancangan'] == 3) : ?>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <form action="<?= base_url('Kemahasiswaan/validasiRancanganProker/') . $r['id_daftar_rancangan'] ?>" method="post">
                                                                <input type="hidden" name="id_lembaga" value="<?= $this->input->get('id_lembaga'); ?>">
                                                                <input type="hidden" name="tahun" value="<?= $this->input->get('tahun'); ?>">
                                                                <input type="hidden" name="valid" value="1">
                                                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <button type="button" data-toggle="modal" data-target="#revisi-rancangan" data-id="<?= $r['id_daftar_rancangan'] ?>" class="btn btn-primary revisi-rancangan-proker"><i class="fas fa-edit"></i></button>
                                                        </div>
                                                    </div>
                                                <?php elseif ($r['status_rancangan'] == 0) : ?>
                                                    Belum Bisa Validasi
                                                <?php elseif ($r['status_rancangan'] == 1) : ?>
                                                    Sudah Disetujui
                                                <?php elseif ($r['status_rancangan'] == 4) : ?>
                                                    Sedang Berlangsung
                                                <?php elseif ($r['status_rancangan'] == 5) : ?>
                                                    Telah Terlaksana
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

<div class="modal fade" tabindex="-1" role="dialog" id="i-revisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Revisi Rancangan Kegiatan</h5>
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
                                    <textarea readonly name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
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