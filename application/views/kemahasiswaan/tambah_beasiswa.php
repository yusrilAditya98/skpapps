<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penerima Beasiswa</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Mahasiswa Penerima Beasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Kemahasiswaan/tambahBeasiswa') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="bagian-personality">
                                            <h5>Informasi Personality</h5>
                                            <div class="form-group">
                                                <label for="nimMahasiswa">NIM</label>
                                                <input type="text" required name="nimMahasiswa" class="form-control" id="nimMahasiswa" value="" required>
                                                <div class="invalid-feedback">
                                                    Nim harap di Isi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bagian-beasiswa mt-5">
                                            <h5>Informasi Beasiswa</h5>
                                            <div class="form-group">
                                                <label for="jenisBeasiswa">Jenis Beasiswa</label>
                                                <select name="jenisBeasiswa" class="form-control" id="id-beasiswa">
                                                    <option value="">-- Pilih Jenis Beasiswa --</option>
                                                    <?php foreach ($beasiswa as $b) : ?>
                                                        <option value="<?= $b['id'] ?>"><?= $b['jenis_beasiswa'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="namaInstansi">Nama Instansi Pemberi
                                                    Beasiswa</label>
                                                <input type="text" required class="form-control" name="namaInstansi" id="namaInstansi">
                                                <div class="invalid-feedback">
                                                    Nama instansi harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tahunMenerima">Tahun Menerima Beasiswa</label>
                                                <input type="date" class="form-control" name="tahunMenerima" id="tahunMenerima" required>
                                                <div class="invalid-feedback">
                                                    Tahun meneriam beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="lamaMenerima">Lama Menerima Beasiswa</label>
                                                <input type="date" class="form-control" name="lamaMenerima" id="lamaMenerima" required>
                                                <div class="invalid-feedback">
                                                    Lama meneriam beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nominalBeasiswa">Nominal Beasiswa</label>
                                                <input type="text" class="form-control" name="nominalBeasiswa" id="nominalBeasiswa" required>
                                                <div class="invalid-feedback">
                                                    Nominal beasiswa di Isi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bagian-upload mt-5">
                                            <h5>Informasi Upload</h5>
                                            <div class="form-group">
                                                <label for="lampiran">Lampiran</label>
                                                <input type="file" name="lampiran" class="form-control-file btn" id="lampiran" required>
                                                <small id="anggaranHelp" class="form-text text-muted">File
                                                    Upload PDF atau JPG Maksimal 2 Mega. Silahkan di isikan
                                                    lampiran Surat Tidak Pernah Menerima Beasiswa dari
                                                    tempat lain/Bermaterai 6000. Format surat
                                                    <span><a href="#">Disini</a></span></small>
                                                <div class="invalid-feedback">
                                                    Lampiran harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="uploadBukti">Bukti Penerima Beasiswa
                                                    Proposal</label>
                                                <input type="file" class="form-control-file btn" name="uploadBukti" id="uploadBukti" required>
                                                <small id="anggaranHelp" class="form-text text-muted">File
                                                    Upload PDF atau JPG Maksimal 2 Mega. </small>
                                                <div class="invalid-feedback">
                                                    bukti harapa harap di Isi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-button">
                                            <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                                Kirim <i class="fab fa-telegram-plane"></i></button>

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