            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Form Edit SKP</h1>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Edit Poin SKP</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-tambah-skp">
                                                <form action="<?= base_url("Mahasiswa/editPoinSkp/") . $id_poin_skp ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="namaKegiatan">Nama Lembaga/Kegiatan</label>
                                                        <input type="text" class="form-control namaKegiatan" id="namaKegiatan" name="namaKegiatan" placeholder="Nama kegiatan..." value="<?= $nama_kegiatan ?>">
                                                        <?= form_error('namaKegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="bidangKegiatan">Bidang Kegiatan Sebelumnya <b><?= $nama_bidang ?></b></label>
                                                        <select class="custom-select bidangKegiatan" id="bidangKegiatan" name="bidangKegiatan" name="bidangKegiatan" required>
                                                            <option value="">-- Pilih Bidang Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Bidang kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenisKegiatan">Jenis Kegiatan Sebelumnya <b><?= $jenis_kegiatan ?></b></label>
                                                        <select class="custom-select jenisKegiatan" id="jenisKegiatan" name="jenisKegiatan" required>
                                                            <option value="">-- Pilih Jenis Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Jenis kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tingkatKegiatan">Tingkat Kegiatan Sebelumnya <b><?= $nama_tingkatan ?></b></label>
                                                        <select class="custom-select tingkatKegiatan" id="tingkatKegiatan" name="tingkatKegiatan" required>
                                                            <option value="">-- Pilih Tingkat Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Tingkat kegiatan harap dipilih
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="partisipasiKegiatan">Partisipasi/Jabatan Kegiatan Sebelumnya <b><?= $nama_prestasi ?></b></label>
                                                        <select class="custom-select partisipasiKegiatan" name="partisipasiKegiatan" id="partisipasiKegiatanSkp" required>
                                                            <option value="">-- Pilih Partisipasi/Jabatan Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Partisipasi/jabatan kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bobotKegiatan">Bobot SKP sebelumnya <b><?= $bobot ?></b></label>
                                                        <input class="form-control bobotKegiatan" name="bobotKegiatan" id="bobotKegiatan" readonly value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tempatKegiatan">Tempat Pelaksanaan</label>
                                                        <input type="text" class="form-control" id="tempatKegiatan" name="tempatKegiatan" placeholder="Tempat pelaksanaan..." required value="<?= $tempat_pelaksanaan ?>">
                                                        <div class=" invalid-feedback">
                                                            Tempat pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggalKegiatan">Tanggal Mulai Pelaksanaan</label>
                                                        <input type="date" class="form-control" name="tanggalKegiatan" id="tanggalKegiatan" required value="<?= $tgl_pelaksanaan ?>">
                                                        <div class=" invalid-feedback">
                                                            Tanggal pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggalKegiatan">Tanggal Selesai Pelaksanaan</label>
                                                        <input type="date" class="form-control" name="tanggalSelesaiKegiatan" id="tanggalSelesaiKegiatan" required value="<?= $tgl_selesai_pelaksanaan ?>">
                                                        <div class=" invalid-feedback">
                                                            Tanggal selesai pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $lastThree = substr($file_bukti, -3);
                                                        ?>
                                                        <?php if ($lastThree == 'pdf') : ?>
                                                            <label for="uploadBukti">Upload Bukti - <a target="_blank" class="btn btn-primary" href="<?= base_url('/assets/pdfjs/web/viewer.html?file=../../../file_bukti/') . $file_bukti ?>"><i class="fas fa-file-pdf"></i> Lihat</a></label>
                                                        <?php elseif ($lastThree == 'jpg' || $lastThree == 'png') : ?>
                                                            <label for="uploadBukti">Upload Bukti - <a target="_blank" class="btn btn-primary" href="<?= base_url('file_bukti/') . $file_bukti ?>"><i class="fas fa-file-pdf"></i> Lihat</a></label>
                                                        <?php else : ?>
                                                            <label for="uploadBukti">Upload Bukti - <button type="button" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Tdaik ada file</button></label>
                                                        <?php endif; ?>
                                                        <input type="file" class="form-control-file btn" id="uploadBukti" name="uploadBukti">

                                                        <small>file upload berformat .pdf, .jpg, .png dengan maksimal 2048Kb</small>

                                                    </div>

                                                    <div class="action-button">
                                                        <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">Submit <i class="fas fa-plus"></i></button>

                                                        <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                                                            <a href="<?= base_url('Mahasiswa') ?>/poinSkp" style="float:right" class="btn btn-icon btn-secondary">
                                                                Kembali <i class="fas fa-arrow-left"></i></a>

                                                        <?php else : ?>
                                                            <a href="<?= base_url('Kemahasiswaan') ?>/daftarPoinSkp" style="float:right" class="btn btn-icon btn-secondary">
                                                                Kembali <i class="fas fa-arrow-left"></i></a>
                                                        <?php endif; ?>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>