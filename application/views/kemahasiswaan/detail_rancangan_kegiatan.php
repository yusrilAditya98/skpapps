<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Rancangan Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Kemahasiswaan/validasiRancanganProker') ?>" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Nama Lembaga</th>
                                            <th>Nama Proker</th>
                                            <th>Tanggal Pelaksanaan</th>
                                            <th>Validasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detail_rancangan as $r) : ?>
                                            <tr>
                                                <td>1</td>
                                                <td><?= $r['tahun_kegiatan'] ?></td>
                                                <td><?= $r['nama_lembaga'] ?></td>
                                                <td><?= $r['nama_proker'] ?></td>
                                                <td><?= date("d M Y", strtotime($r['tanggal_mulai_pelaksanaan'])) . ' - ' . date("d M Y", strtotime($r['tanggal_selesai_pelaksanaan']))  ?></td>
                                                <td>
                                                    <?php if ($r['status_rancangan'] == 1) :  ?>
                                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                    <?php elseif ($r['status_rancangan'] == 2) : ?>
                                                        <div class="btn btn-warning circle-content detail-revisi" data-toggle="modal" data-target="#i-revisi" data-id=""><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                    <?php elseif ($r['status_rancangan'] == 3) : ?>
                                                        <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                    <?php elseif ($r['status_rancangan'] == 0) : ?>
                                                        <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadioInline<?= $r['id_daftar_rancangan'] ?>" name="valid_<?= $r['id_daftar_rancangan'] ?>" class="custom-control-input" value="1">
                                                        <label class="custom-control-label" for="customRadioInline<?= $r['id_daftar_rancangan'] ?>">Setuju</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input checked type="radio" id="customRadioInline2_<?= $r['id_daftar_rancangan'] ?>" name="valid_<?= $r['id_daftar_rancangan'] ?>" class="custom-control-input" value="2">
                                                        <label class="custom-control-label" for="customRadioInline2_<?= $r['id_daftar_rancangan'] ?>">Revisi</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>

                                <div class="alert alert-warning mb-3" role="alert" style="opacity: 1; color:black; background-color:rgba(35, 182, 246, 0.4)">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 mt-2">
                                            <span class="font-weight-bold">Perhatian!</span> Pastikan kegiatan telah diperiksa
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="hidden" name="id_lembaga" value="<?= $this->input->get('id_lembaga'); ?>">
                                            <input type="hidden" name="tahun" value="<?= $this->input->get('tahun'); ?>">
                                            <button type="submit" class="btn btn-success" name="valid" value="1">Menyetujui Rancangan</button>
                                            <button type="submit" class="btn btn-danger" name="valid" value="2">Revisi Rancangan</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>