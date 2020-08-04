<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Publikasi Proposal Kegiatan </h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Proposal Kegiatan</h4>
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
                        <div class="kategori-filter float-right mb-2">

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="dataTabelProposal">
                                <thead class="text-center">
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Tanggal Pengajuan</th>
                                    <th class="align-middle">Nama Pengaju</th>
                                    <th class="align-middle">Nama Kegiatan</th>
                                    <th class="align-middle">Status Proposal</th>
                                    <th class="align-middle">LM</th>
                                    <th class="align-middle">KMHS</th>
                                    <th class="align-middle">WD3</th>
                                    <th class="align-middle">PSIK</th>
                                    <th class="align-middle">Keuangan</th>
                                    <th class="align-middle">Aksi</th>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
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
                                                <?php for ($i = 0; $i < count($validasi); $i++) : ?>
                                                    <?php if ($validasi[$i]['id_kegiatan'] == $k['id_kegiatan'] && $validasi[$i]['jenis_validasi'] == 4) : ?>
                                                        <?php if ($validasi[$i]['status_validasi'] != 1) : ?>
                                                            <span>Belum bisa validasi</span>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php elseif ($validasi[$i]['id_kegiatan'] == $k['id_kegiatan'] && $validasi[$i]['jenis_validasi'] == 5) : ?>
                                                        <?php if ($validasi[$i]['status_validasi'] == 0 || $validasi[$i]['status_validasi'] == 2 || $validasi[$i]['status_validasi'] == 4) : ?>
                                                            <a href="<?= base_url('Publikasi/validasiProposal/') . $k['id_kegiatan'] ?>?valid=1&&jenis_validasi=5" class="btn btn-icon btn-success confirm-validasi">valid</a>
                                                            <a href="#" data-toggle="modal" data-target=".infoRevisi" class="btn btn-icon btn-primary d-valid" data-kegiatan="<?= $k['id_kegiatan'] ?>">revisi</a>
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