<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <?= form_open_multipart('akademik/tambahKegiatan/'); ?>
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
                        <button type="submit" class="btn btn-primary">Tambah Kegiatan</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>