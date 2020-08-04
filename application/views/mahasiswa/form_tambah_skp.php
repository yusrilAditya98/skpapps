            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Form Tambah SKP</h1>
                    </div>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Tambah Poin SKP</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-tambah-skp">
                                                <form action="<?= base_url("Mahasiswa") ?>/tambahPoinSkp" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="namaKegiatan">Nama Lembaga/Kegiatan</label>
                                                        <input type="text" class="form-control namaKegiatan" id="namaKegiatan" name="namaKegiatan" placeholder="Nama kegiatan..." required>
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="bidangKegiatan">Bidang Kegiatan</label>
                                                        <select class="custom-select bidangKegiatan" id="bidangKegiatan" name="bidangKegiatan" name="bidangKegiatan" required>
                                                            <option value="">-- Pilih Bidang Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Bidang kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenisKegiatan">Jenis Kegiatan</label>
                                                        <select class="custom-select jenisKegiatan" id="jenisKegiatan" name="jenisKegiatan" required>
                                                            <option value="">-- Pilih Jenis Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Jenis kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tingkatKegiatan">Tingkat Kegiatan</label>
                                                        <select class="custom-select tingkatKegiatan" id="tingkatKegiatan" name="tingkatKegiatan" required>
                                                            <option value="">-- Pilih Tingkat Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Tingkat kegiatan harap dipilih
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="partisipasiKegiatan">Partisipasi/Jabatan</label>
                                                        <select class="custom-select partisipasiKegiatan" name="partisipasiKegiatan" id="partisipasiKegiatan" required>
                                                            <option value="">-- Pilih Partisipasi/Jabatan Kegiatan --</option>
                                                        </select>
                                                        <div class=" invalid-feedback">
                                                            Partisipasi/jabatan kegiatan harap dipilih
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bobotKegiatan">Bobot SKP</label>
                                                        <input class="form-control bobotKegiatan" name="bobotKegiatan" id="bobotKegiatan" readonly value="0">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tempatKegiatan">Tempat Pelaksanaan</label>
                                                        <input type="text" class="form-control" id="tempatKegiatan" name="tempatKegiatan" placeholder="Tempat pelaksanaan..." required>
                                                        <div class=" invalid-feedback">
                                                            Tempat pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggalKegiatan">Tanggal Mulai Pelaksanaan</label>
                                                        <input type="text" class="form-control datepicker" name="tanggalKegiatan" id="tanggalKegiatan" required>
                                                        <div class=" invalid-feedback">
                                                            Tanggal pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggalKegiatan">Tanggal Selesai Pelaksanaan</label>
                                                        <input type="text" class="form-control datepicker" name="tanggalSelesaiKegiatan" id="tanggalSelesaiKegiatan" required>
                                                        <div class=" invalid-feedback">
                                                            Tanggal selesai pelaksanaan kegiatan harap diisi
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="uploadBukti">Upload Bukti</label>
                                                        <input type="file" class="form-control-file btn" id="uploadBukti" name="uploadBukti" required>
                                                        <div class=" invalid-feedback">
                                                            Bukti kegiatan harap diisi
                                                        </div>
                                                        <small>file upload berformat .pdf, .jpg, .png dengan maksimal 2048Kb</small>

                                                    </div>

                                                    <div class="action-button">
                                                        <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">Submit <i class="fas fa-plus"></i></button>
                                                        <a href="<?= base_url('Mahasiswa') ?>/poinSkp" style="float:right" class="btn btn-icon btn-secondary">
                                                            Kembali <i class="fas fa-arrow-left"></i></a>
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