<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Proposal</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengajuan Proposal Kegiatan</h4>
                    </div>
                    <div class="card-body">
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
                        <div class="kategori-filter float-right mb-2">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTabelKegiatan">
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Tanggal Pengajuan</th>
                                        <th class="align-middle">Nama Kegiatan</th>
                                        <th class="align-middle">Status Proposal</th>
                                        <th class="align-middle">LM</th>
                                        <th class="align-middle">KMHS</th>
                                        <th class="align-middle">WD3</th>
                                        <th class="align-middle">PSIK</th>
                                        <th class="align-middle">Keuangan</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td scope="row"><?= $i++ ?></td>
                                            <td><?= date("d-m-Y", strtotime($k['tgl_pengajuan_proposal']))  ?></td>
                                            <td><a href="" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-jenis="proposal" data-toggle="modal" data-target="#i-kegiatan"><?= $k['nama_kegiatan'] ?></a>
                                            </td>

                                            <?php if ($k['status_selesai_proposal'] == 0) : ?>
                                                <td class="text-secondary">
                                                    Belum diproses
                                                </td>
                                            <?php elseif ($k['status_selesai_proposal'] == 1) : ?>
                                                <td class="text-primary">
                                                    Sedang Berlangsung
                                                </td>
                                            <?php elseif ($k['status_selesai_proposal'] == 2) : ?>
                                                <td class="text-warning">
                                                    Revisi
                                                </td>
                                            <?php elseif ($k['status_selesai_proposal'] == 3) : ?>
                                                <td class="text-success">
                                                    Selesai
                                                </td>
                                            <?php endif; ?>
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
                                                <?php if ($k['status_selesai_proposal'] == 2 || $k['status_selesai_proposal'] == 0) : ?>
                                                    <form action="<?= base_url('Kegiatan/editProposal/') . $k['id_kegiatan'] ?>" method="post">
                                                        <input type="hidden" name="jenis_revisi" value="<?= $jenis_revisi ?>">
                                                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td><b>Keterangan</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class=" text-center"> <i class="fa fa-check text-success" aria-hidden="true"></i></td>
                                        <td> : Telah Divalidasi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <i class="fa fa-circle text-primary" aria-hidden="true"></i></td>
                                        <td> : Proses Validasi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <i class="fa fa-circle text-secondary" aria-hidden="true"></i></td>
                                        <td> : Menunggu Pengajuan</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <span class="btn btn-warning circle-content"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span></td>
                                        <td> : Revisi (Menampilkan Catatan Revisi)</td>
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