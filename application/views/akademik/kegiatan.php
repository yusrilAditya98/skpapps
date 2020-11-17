<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kegiatan</h4>
                    </div>
                    <div class="card-body">

                        <form class="m-t-20" action="<?= base_url('Export/exportDaftarKuliahTamu') ?>" method="get">
                            <span>Range Tanggal Kegiatan</span>
                            <div class="row">
                                <div class="col-lg-6 input-group mb-3">
                                    <input type="date" name="tgl_pengajuan_start" id="tgl_pengajuan_start" class="form-control">
                                    <input type="date" name="tgl_pengajuan_end" id="tgl_pengajuan_date" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Export</button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <a href="<?= base_url('Akademik/tambahKegiatan') ?>" class="btn btn-primary float-right pl-3 text-white">
                                        <i class="fas fa-plus"></i><span> Tambah Kegiatan</span></a>
                                </div>
                            </div>
                        </form>


                        <div class="table-responsive">
                            <table class="table table-striped text-wrap table-bordered" id="table-kegiatan">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Nama Pemateri</th>
                                        <th>Ruangan</th>
                                        <th>Status</th>
                                        <th>Keberlangsungan</th>
                                        <th>Validasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $k['tanggal_event'] ?></td>
                                            <td><?= $k['pemateri'] ?></td>
                                            <td><?= $k['lokasi'] ?></td>
                                            <?php
                                            if ($k['status_terlaksana'] == 0) {
                                                echo '<td class="text-danger">Belum Terlaksana</td>';
                                            } else if ($k['status_terlaksana'] == 1) {
                                                echo '<td class="text-success">Sudah Terlaksana</td>';
                                            } else {
                                                echo '<td class="text-info">Sedang Berlangsung</td>';
                                            }
                                            ?>
                                            <td>
                                                <?php
                                                if ($k['status_terlaksana'] == 0) {
                                                    echo '<a href="' . base_url('Akademik/setKegiatanBerlangsung/') . $k['id_kuliah_tamu'] . '" class="btn btn-info"><i class="fas fa-check-square"></i></a>';
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($k['status_terlaksana'] == 2) {
                                                    echo '<button class="btn btn-info validasi-kegiatan-akademik" data-toggle="modal" data-target=".modalValidasiKegiatanAkademik" data-id="' . $k['id_kuliah_tamu'] . '"><i class="fas fa-check-square"></i></button>';
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary detail-kegiatan-info" data-toggle="modal" data-target=".modalDetailKegiatan" data-id="<?= $k['id_kuliah_tamu'] ?>">Detail</button>
                                                <?php// if ($k['status_terlaksana'] == 0) : ?>
                                                <button class="btn btn-success edit-kegiatan" data-toggle="modal" data-target=".modalEditKegiatan" data-id="<?= $k['id_kuliah_tamu'] ?>">Edit</button>
                                                <a href="<?= base_url("akademik/hapusKegiatan/") . $k['id_kuliah_tamu']  ?>" class="btn btn-danger confirm-hapus" ">Hapus</button>
                                                <?php// endif ?>

                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Awal Modal Detail Kegiatan -->
<div class=" modal fade bd-example-modal-lg modalDetailKegiatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-blue">
                                                                <h3 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Kegiatan</span></h5>
                                                                    <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card mb-4">
                                                                    <div class="row no-gutters">
                                                                        <div class="col-lg-4">
                                                                            <img src="" class="card-img kode_qr img-thumbnail mb-2">
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title judul_kegiatan"></h5>
                                                                                <p class="card-text pemateri"></p>
                                                                                <p class="card-text deskripsi"></p>
                                                                                <p class="card-text lokasi"></p>
                                                                                <div class="row">
                                                                                    <p class="col-lg-5"><small class="text-muted tanggal_event"></small></p>
                                                                                    <p class="col-lg-7"><small class="text-muted waktu_kegiatan"></small></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 kategori-filter float-right mb-2">

                                                                        </div>
                                                                        <div class="col-lg-12 tabel-peserta">
                                                                            <div class="table-responsive" id="detail-kuliah-tamu">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                        </div>
                        <!-- Akhir Modeal Detail Kegiatan -->

                        <!-- Awal Modal Edit Kegiatan -->
                        <div class="modal fade bd-example-modal-lg modalEditKegiatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-blue">
                                        <h5 class="modal-title clr-white" id="exampleModalLabel">Edit Kegiatan</span></h5>
                                        <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card mb-4">
                                            <div class="row no-gutters">
                                                <div class="col-lg-12">
                                                    <?= form_open_multipart('akademik/editKegiatan/'); ?>
                                                    <input type="hidden" name="nama_lama" id="nama_kegiatan_lama" value="">
                                                    <input type="hidden" name="tempat_lama" id="tempat_lama" value="">
                                                    <input type="hidden" name="tgl_plksn_lama" id="tgl_plksn_lama" value="">
                                                    <input type="hidden" name="status_terlaksana" id="status_terlaksana" value="">
                                                    <div class="form-group">
                                                        <label for="nama_kegiatan">Nama Kegiatan</label>
                                                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan nama kegiatan">
                                                        <?= form_error('nama_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
                                                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" placeholder="Masukkan deskripsi kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                                        <?= form_error('deskripsi_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pemateri">Pemateri</label>
                                                        <textarea class="form-control" id="pemateri" name="pemateri" placeholder="Masukkan Pemateri kegiatan" style="resize:none; height:100%" rows="5"></textarea>
                                                        <?= form_error('pemateri', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ruangan" class="col-form-label">Ruangan</label>
                                                        <select class="form-control" id="ruangan" name="ruangan" placeholder="Ruangan">
                                                            <option value="0" disabled selected hidden>Pilih Ruangan</option>
                                                            <!-- <option value="UB">UB</option>
                                    <option value="Luar UB">Luar UB</option> -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                                                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan">
                                                        <?= form_error('tanggal_kegiatan', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <div class="row form-group mb-0">
                                                        <div class="form-group col-lg-6">
                                                            <label for="waktu_kegiatan_mulai">Waktu Mulai</label>
                                                            <input type="time" class="form-control" id="waktu_kegiatan_mulai" name="waktu_kegiatan_mulai">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="waktu_kegiatan_selesai" class="col-form-label col-form-label-sm">Waktu Selesai</label>
                                                            <input type="time" class="form-control" id="waktu_kegiatan_selesai" name="waktu_kegiatan_selesai">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group">
                                <label for="File">Poster</label>
                                <input type="file" class="form-control-file" id="File" name="File">
                            </div> -->
                                                    <button type="submit" class="btn btn-primary float-right">Edit Kegiatan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Akhir Modeal Edit Kegiatan -->

                        <!-- Awal Modal Edit Kegiatan -->
                        <div class="modal fade bd-example-modal-lg modalValidasiKegiatanAkademik" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-blue">
                                        <h3 class="modal-title clr-white ml-4" id="exampleModalLabel">Validasi Kegiatan Akademik</span></h5>
                                            <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card mb-4">
                                            <div class="row no-gutters">
                                                <div class="col-lg-4">
                                                    <img src="" class="card-img kode_qr_validasi img-thumbnail">
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="card-body">
                                                        <h4 class="card-title judul_kegiatan_validasi"></h4>
                                                        <p class="card-text pemateri_validasi"></p>
                                                        <p class="card-text deskripsi_validasi"></p>
                                                        <p class="card-text lokasi_validasi"></p>
                                                        <div class="row">
                                                            <p class="col-lg-5"><small class="text-muted tanggal_event_validasi"></small></p>
                                                            <p class="col-lg-7"><small class="text-muted waktu_kegiatan_validasi"></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="col-lg-12 mt-2">
                                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                        Perhatian ! untuk melakukan validasi
                                                        <li>1. Pastikan tabel menampilkan semua data peserta <b>(Show All)</b></li>
                                                        <li>2. Cheklist kehadarian peserta. Kehadiran yang di cheklist menandakan <b>HADIR</b></li>
                                                        <li>3. Klik tombol validasi</li>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <button class="btn btn-info" onclick="eventCheckBox()">Hadir Semua</button>
                                                </div>
                                                <form action="<?= base_url('akademik/validasiKegiatan/'); ?>" method="post">
                                                    <input type="hidden" name="peserta_kt" id="peserta_kt">
                                                    <input type="hidden" name="peserta_nim" id="peserta_nim">
                                                    <input type="hidden" id="id_kuliah_tamu" name="id_kuliah_tamu">
                                                    <input type="hidden" class="nama_kegiatan" id="nm_kgtn" name="nama_kegiatan">
                                                    <input type="hidden" id="tgl_pelaksanaan" name="tgl_pelaksanaan">
                                                    <input type="hidden" id="tempat_pelaksanaan" name="tempat_pelaksanaan">
                                                    <input type="hidden" id="kode_qr" name="kode_qr">

                                                    <div class="col-lg-12 kategori-filter-valid float-right mb-2">

                                                    </div>
                                                    <div class="col-lg-12 tabel-peserta_validasi">
                                                        <div class="table-responsive" id="validasi-kuliah-tamu">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 card-footer">
                                                        <button onclick="cekPeserta();return confirm('Apakah anda yakin akan memvalidasi?')" type="submit" class="btn btn-success float-right">Validasi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Akhir Modeal Edit Kegiatan -->