<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message');  ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <a href="<?= base_url('akademik/tambahKegiatan') ?>" class="btn btn-primary float-right pl-3 text-white">
                                    <i class="fas fa-plus"></i><span> Tambah Kegiatan</span>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped text-wrap table-kategori">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Nama Pemateri</th>
                                        <th>Ruangan</th>
                                        <th>Status</th>
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
                                            <td>
                                                <?php
                                                    if ($k['status_terlaksana'] == 0) {
                                                        echo '<p class="text-danger">Belum Terlaksana</p>';
                                                    } else {
                                                        echo '<p class="text-success">Sudah Terlaksana</p>';
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary detail-kegiatan-info" data-toggle="modal" data-target=".modalDetailKegiatan" data-id="<?= $k['id_kuliah_tamu'] ?>">Detail</button>
                                                <?php if ($k['status_terlaksana'] == 0) {
                                                        echo '<button class="btn btn-success edit-kegiatan" data-toggle="modal" data-target=".modalEditKegiatan" data-id="' . $k['id_kuliah_tamu'] . '">Edit</button>
                                                              <button class="btn btn-danger hapus-kegiatan" data-id="' . $k['id_kuliah_tamu'] . '">Hapus</button>';
                                                    }
                                                    ?>
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
<div class="modal fade bd-example-modal-lg modalDetailKegiatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Kegiatan</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-4">
                            <img src="" class="card-img kode_qr">
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
                        <div class="col-lg-12 tabel-peserta">
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