<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penerima Beasiswa</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Mahasiswa Penerima Beasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Kemahasiswaan/editBeasiswa/') . $penerima['id_penerima'] ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="bagian-personality">
                                            <h5>Data Pemohon</h5>
                                            <div class="form-group">
                                                <label for="nimMahasiswa">NIM</label>
                                                <input type="text" required name="nimMahasiswa" class="form-control" id="nimMahasiswa" value="<?= $penerima['nim'] ?>" required>
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
                                                    <?php foreach ($beasiswa as $b) : ?>
                                                        <?php if ($penerima['id_beasiswa'] == $b['id']) : ?>
                                                            <option selected value="<?= $b['id'] ?>"><?= $b['jenis_beasiswa'] ?></option>
                                                        <?php else : ?>
                                                            <option value="<?= $b['id'] ?>"><?= $b['jenis_beasiswa'] ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="namaInstansi">Nama Instansi Pemberi
                                                    Beasiswa</label>
                                                <input type="text" required class="form-control" name="namaInstansi" value="<?= $penerima['nama_instansi'] ?>" id="namaInstansi">
                                                <div class="invalid-feedback">
                                                    Nama instansi harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tahunMenerima">Tahun Menerima Beasiswa</label>
                                                <input type="date" class="form-control" name="tahunMenerima" value="<?= $penerima['tahun_menerima'] ?>" id="tahunMenerima" required>
                                                <div class="invalid-feedback">
                                                    Tahun meneriam beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="lamaMenerima">Lama Menerima Beasiswa</label>
                                                <input type="date" class="form-control" name="lamaMenerima" value="<?= $penerima['lama_menerima'] ?>" id="lamaMenerima" required>
                                                <div class="invalid-feedback">
                                                    Lama meneriam beasiswa harap di Isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nominalBeasiswa">Nominal Beasiswa</label>
                                                <input type="text" class="form-control" name="nominalBeasiswa" value="<?= $penerima['nominal'] ?>" id="nominalBeasiswa" required>
                                                <div class="invalid-feedback">
                                                    Nominal beasiswa di Isi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bagian-upload mt-5">
                                            <h5>Informasi Upload</h5>
                                            <div class="form-group">
                                                <label for="lampiran">Lampiran - <a target="_blank" href="<?= base_url() ?>assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $penerima['bukti']  ?>">lihat</a></label>
                                                <input type="file" name="lampiran" class="form-control-file btn" id="lampiran">
                                                <small id="anggaranHelp" class="form-text text-muted">File
                                                    Upload PDF 2 Mega. Silahkan di isikan
                                                    lampiran Surat Tidak Pernah Menerima Beasiswa dari
                                                    tempat lain/Bermaterai 6000. Format surat
                                                    <span><a href="#">Disini</a></span></small>

                                            </div>
                                            <div class="form-group">
                                                <label for="uploadBukti">Bukti Penerima Beasiswa
                                                    Proposal - <a target="_blank" href="<?= base_url() ?>/assets/pdfjs/web/viewer.html?file=../../../file_bukti/beasiswa/<?= $penerima['lampiran']  ?>">lihat</a></label>
                                                <input type="file" class="form-control-file btn" name="uploadBukti" id="uploadBukti">
                                                <small id="anggaranHelp" class="form-text text-muted">File
                                                    Upload PDF Maksimal 2 Mega. </small>

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