<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Pengajuan Rancangan Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Rancangan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Kegiatan/tambahRancanganKegiatan') ?>" method="post" class="needs-validation" novalidate="">
                            <div class="form-group">
                                <label for="tahunKegiatan">Tahun Kegiatan</label>
                                <input type="text" class="form-control" name="tahunKegiatan" id="tahunKegiatan" value="<?= $lembaga['tahun_rancangan'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="namaKegiatan">Nama Kegiatan</label>
                                <input type="text" class="form-control" name="namaKegiatan" id="namaKegiatan" required>
                                <div class="invalid-feedback">
                                    Nama kegiatan harap diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tglPelaksanaan">Tanggal Mulai Pelaksanaan</label>
                                <input type="date" class="form-control datepicker" id="tglPelaksanaan" name="tglPelaksanaan" required>
                                <div class="invalid-feedback">
                                    Tanggal pelaksanaan harap diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tglSelesaiPelaksanaan">Tanggal Selesai Pelaksanaan</label>
                                <input type="date" class="form-control datepicker" id="tglSelesaiPelaksanaan" name="tglSelesaiPelaksanaan" required>
                                <div class="invalid-feedback">
                                    Tanggal selesai pelaksanaan harap diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="danaKegiatan">Dana Anggaran</label>
                                <input type="number" class="form-control" id="danaKegiatan" name="danaKegiatan" required>
                                <div class="invalid-feedback">
                                    Dana kegiatan harap diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="danaKegiatan">Kategori Kegiatan</label>
                                <select name="kategori_kegiatan" id="kategori_kegiatan" class="form-control" required>
                                    <option value="">-- pilih kategori --</option>
                                    <option value="proker">proker</option>
                                    <option value="delegasi">delegasi</option>
                                </select>
                                <div class="invalid-feedback">
                                    Kategori kegiatan harap diisi
                                </div>
                            </div>
                            <button onclick="return confirm('Apakah anda sudah yakin ?')" type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                Tambah Rancangan <i class="fas fa-plus"></i></button>
                            <a href="<?= base_url('Kegiatan/pengajuanRancangan') ?>" style="float:right" class="btn btn-icon btn-secondary">
                                Kembali <i class="fas fa-arrow-left"></i></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>