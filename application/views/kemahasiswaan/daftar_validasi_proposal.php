<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Proposal Kegiatan</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>

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

                        <form class="m-t-20" action="<?= base_url('Export/exportProposalKegiatan') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-5 input-group mb-3">
                                    <select class="custom-select" id="kategori" name="kategori">
                                        <option selected value="null">Semua Kategori</option>
                                        <option value="mhs">Non Lembaga</option>
                                        <option value="lbg">Lembaga</option>

                                    </select>
                                    <select class="custom-select" id="tahun" name="tahun">
                                        <option value="kosong">Semua Periode</option>
                                        <?php foreach ($filter as $p) : ?>
                                            <option value="<?= $p['periode'] ?>"><?= $p['periode'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
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
                                <table class="table table-striped table-bordered" id="dataTabelProposal">
                                    <thead>
                                        <th class="text-center align-middle">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                No
                                            </div>
                                        </th>
                                        <th class="text-center align-middle">Tanggal Pengajuan</th>
                                        <th class="text-center align-middle">Nama Pengaju</th>
                                        <th class="text-center align-middle">Nama Kegiatan</th>
                                        <th class="text-center align-middle">Status Proposal</th>
                                        <th class="text-center align-middle">LM</th>
                                        <th class="text-center align-middle">KMHS</th>
                                        <th class="text-center align-middle">WD3</th>
                                        <th class="text-center align-middle">PSIK</th>
                                        <th class="text-center align-middle">KEU</th>
                                        <th class="text-center align-middle">Aksi</th>
                                        <th></th>

                                    </thead>

                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($kegiatan as $k) : ?>
                                            <tr>
                                                <td>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="hidden" name="checkbox-<?= $k['id_kegiatan'] ?>" value="1">
                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-<?= $k['id_kegiatan'] ?>" name="cek_<?= $k['id_kegiatan'] ?>" value="1">
                                                        <label for="checkbox-<?= $k['id_kegiatan'] ?>" class="custom-control-label">&nbsp;</label>
                                                        <?= $i++ ?>
                                                    </div>

                                                </td>
                                                <td><?= date("d-m-Y", strtotime($k['tgl_pengajuan_proposal']))   ?></td>
                                                <td><?= $k['nama_lembaga'] ?></td>
                                                <td>
                                                    <a href="#" class="detail-kegiatan" data-id="<?= $k['id_kegiatan'] ?>" data-toggle="modal" data-target="#i-kegiatan" data-jenis="proposal"><?= $k['nama_kegiatan'] ?></a>
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
                                                                <a href="<?= base_url('Kemahasiswaan/validasiProposal/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=3" class="btn btn-sm btn-success confirm-validasi">valid kmhsn</a>
                                                                <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn  btn-sm btn-primary d-valid-km" data-kegiatan="<?= $k['id_kegiatan'] ?>">revisi kmhsn</a>
                                                                <input type="hidden" class="role_id" value="3">
                                                            <?php elseif ($v['status_validasi'] == 0) : ?>
                                                                Belum bisa validasi
                                                            <?php endif; ?>
                                                        <?php elseif ($v['id_kegiatan'] == $k['id_kegiatan'] && ($v['jenis_validasi'] == 4)) : ?>
                                                            <?php if ($v['status_validasi'] == 4 || $v['status_validasi'] == 2) : ?>
                                                                <a href=" <?= base_url('Kemahasiswaan/validasiProposal/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=4" class="btn  btn-sm btn-success confirm-validasi">valid wd 3</a>
                                                                <a href="#" data-toggle="modal" data-target="#infoRevisi" class="btn  btn-sm btn-primary d-valid" data-kegiatan="<?= $k['id_kegiatan'] ?>">revisi wd 3</a>
                                                                <input type="hidden" class="role_id" value="4">
                                                            <?php elseif ($v['status_validasi'] == 1) : ?>
                                                                Selesai
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                </td>
                                                <td> <a target="_blank" href="<?= base_url('Kemahasiswaan/cetakPengajuanDana/') . $k['id_kegiatan'] ?>?status=proposal" class="btn btn-primary"><i class="text-warning fas fa-file-alt"></i></a></td>
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
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>