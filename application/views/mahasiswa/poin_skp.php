<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="section-header">
            <h1>Poin Satuan Kredit Mahasiswa</h1>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tentang Satuan Kredit Prestasi</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div id="mycard-collapse">
                        <div class="card-body mb-2" style="margin-top:-1rem;">
                            <div class="about-skp text-justify mr-5">
                                Penilaian dan validasi dilakukan pada saat mahasiswa yang bersangkutan
                                mengajukan bukti keikutsertaan dalam kegiatan ekstrakurikuler dan non
                                kurikuler pada setiap akhir semester dengan menggunakan formulir yang telah
                                ditentukan, nilai kegiatan kemahasiswaan dinyatakan valid apabila bukti keikutsertaan ditandatangani oleh Pejabat dan atau Pihak yang berwenang.
                                <br>
                                <br>
                                Kriteria predikat pada Transkrip Kegiatan Mahasiswa adalah sebagai berikut:
                            </div>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">Predikat</th>
                                        <th scope="col">Nilai SKP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Dengan Pujian</th>
                                        <td>> 300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sangat Baik</th>
                                        <td>201 - 300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Baik</th>
                                        <td>151 - 200</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Cukup</th>
                                        <td>100 - 150</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Point Satuan Kredit Prestasi</h4>
                    </div>
                    <div class="card-body text-center mb-2" style="margin-top:-1rem;">
                        <h1 class="display-3 mb-4" style="color: black;"><?= $mahasiswa[0]['total_poin_skp'] ?> <span style="font-size: 1rem; margin-left: -1rem;">poin</span>
                        </h1>
                        <a href="<?= base_url('Mahasiswa') ?>/tambahPoinSkp" class="btn btn-icon btn-success" style="width:100%">
                            Tambah Point SKP <i class="fas fa-plus pl-2"></i></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Panduan SKP FEB UB</h4>
                    </div>
                    <div class="card-body mb-2" style="margin-top:-1rem;">
                        <p>Panduan Pelaksanaan SKP FEB UB: </p>
                        <a target="_blank" href="<?= base_url('/assets/pdfjs/web/viewer.html?file=../../../berkas/panduan_skp.pdf') ?>" class="btn btn-icon btn-primary" style="width:100%">
                            Download <i class="fas fa-download pl-2"></i></a>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Riwayat Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <a href="<?= base_url('Mahasiswa/cetakSkp/') ?>" target="_blank" class="btn btn-icon btn-warning mb-3" style="float:right">
                                    Cetak SKP <i class="fas fa-print pl-2"></i></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal Pengajuan</th>
                                        <th scope="col" style="width:17rem;">Nama Kegiatan</th>
                                        <th scope="col">Tingkat</th>
                                        <th scope="col">Nilai Bobot</th>
                                        <th scope="col">Validasi</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($poinskp as $p) : ?>
                                        <tr>
                                            <td scope="row"><?= $i++ ?></td>
                                            <td><?= date("d-m-Y", strtotime($p['tgl_pengajuan'])) ?></td>
                                            <td> <a href="#" data-toggle="modal" data-target="#detailKegiatan" data-id="<?= $p['id_poin_skp'] ?>" class="detailSkp"><?= $p['nama_kegiatan'] ?></a> </td>
                                            <td><?= $p['nama_tingkatan'] ?><br><small><?= $p['nama_prestasi'] ?></small></td>
                                            <td><?= ($p['bobot'] * $p['nilai_bobot']) ?></td>
                                            <td>
                                                <?php if ($p['validasi_prestasi'] == 0) : ?>
                                                    <div class="badge badge-primary">Proses</div>
                                                <?php elseif ($p['validasi_prestasi'] == 1) : ?>
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                <?php elseif ($p['validasi_prestasi'] == 2) : ?>
                                                    <div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi" data-id="<?= $p['id_poin_skp'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <?php if ($p['validasi_prestasi'] == 1) : ?>
                                                        <div class="col-lg-12">
                                                            <span class="text-success">Disetujui</span>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="col-sm-4">
                                                            <a href="<?= base_url('Mahasiswa/editPoinSkp/') . $p['id_poin_skp']  ?>" class="btn btn-icon btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <a href="<?= base_url('Mahasiswa/hapusPoinSkp/') . $p['id_poin_skp'] ?>" class="btn btn-sm btn-icon btn-danger confirm-hapus"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
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
<!-- Modal Detail Poin SKP -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailKegiatan">
    <div class="modal-dialog modal-lg"" role=" document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Poin Skp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="<?= base_url() ?>/assets/img/medal.png" style="width: 100px" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Tingkatan</div>
                                    <div class="profile-widget-item-value"><span class="d-tingkat"></span></div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Partisipasi/jabatan</div>
                                    <div class="profile-widget-item-value"><span class="d-partisipasi"></span></div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Bobot</div>
                                    <div class="profile-widget-item-value"><span class="d-bobot"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name"><span class="d-bidang"></span>
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div> <span class="d-jenis"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-nama" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Mulai Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tgl" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Selesai Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tgl-selesai" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tempat Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control d-tempat" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">File Bukti</label>
                                <div class="col-sm-9">
                                    <a target="_blank" href="" class="d-file btn btn-primary"></a>
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
                                        <textarea readonly name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>