<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Rancangan Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Rancangan Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) : ?>
                            <form action="<?= base_url('Kegiatan/editRancanganKegiatan/') . $rancangan['id_daftar_rancangan'] ?>" method="post" class="needs-validation" novalidate="">
                                <input type="hidden" name="id_lembaga" value="<?= $rancangan['id_lembaga'] ?>">
                            <?php else : ?>
                                <form action="<?= base_url('Kegiatan/editRancanganKegiatan/') . $rancangan['id_daftar_rancangan'] ?>" method="post" class="needs-validation" novalidate="">
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="tahunKegiatan">Tahun Kegiatan</label>
                                    <input type="text" class="form-control" name="tahunKegiatan" id="tahunKegiatan" value="<?= $rancangan['tahun_kegiatan'] ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="namaKegiatan">Nama Kegiatan</label>
                                    <input type="text" class="form-control" name="namaKegiatan" id="namaKegiatan" required value="<?= $rancangan['nama_proker'] ?>">
                                    <div class="invalid-feedback">
                                        Nama kegiatan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tglPelaksanaan">Tanggal Pelaksanaan</label>
                                    <input type="text" class="form-control datepicker" id="tglPelaksanaan" name="tglPelaksanaan" value="<?= $rancangan['tanggal_mulai_pelaksanaan'] ?>" required>
                                    <div class="invalid-feedback">
                                        Tanggal pelaksanaan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tglSelesaiPelaksanaan">Tanggal Selesai Pelaksanaan</label>
                                    <input type="text" class="form-control datepicker" id="tglSelesaiPelaksanaan" name="tglSelesaiPelaksanaan" value="<?= $rancangan['tanggal_selesai_pelaksanaan'] ?>" required>
                                    <div class="invalid-feedback">
                                        Tanggal selesai pelaksanaan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="danaKegiatan">Dana Anggaran Rp.</label>
                                    <input type="number" class="form-control" id="danaKegiatan" name="danaKegiatan" required value="<?= $rancangan['anggaran_kegiatan'] ?>">
                                    <div class="invalid-feedback">
                                        Dana kegiatan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="danaKegiatan">Kategori Kegiatan</label>
                                    <select name="kategori_kegiatan" id="kategori_kegiatan" class="form-control" required>
                                        <?php if ($rancangan['kategori_kegiatan'] == 'proker') : ?>
                                            <option selected value="proker">proker</option>
                                            <option value="delegasi">delegasi</option>
                                        <?php elseif ($rancangan['kategori_kegiatan'] == 'delegasi') : ?>
                                            <option value="proker">proker</option>
                                            <option selected value="delegasi">delegasi</option>
                                        <?php else : ?>
                                            <option value="">-- pilih kategori --</option>
                                            <option value="proker">proker</option>
                                            <option value="delegasi">delegasi</option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Kategori kegiatan harap diisi
                                    </div>
                                </div>
                                <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                    Edit Rancangan <i class="fas fa-edit"></i></button>
                                <input type="hidden" name="status_rancangan" value="4">

                                <?php if ($this->session->userdata('user_profil_kode') == 4 || $this->session->userdata('user_profil_kode') == 9) : ?>
                                    <a href="<?= base_url('Kemahasiswaan/detailRancanganKegiatan/?id_lembaga=' . $rancangan['id_lembaga'] . '&tahun=' . $rancangan['tahun_kegiatan']) ?>" style="float:right" class="btn btn-icon btn-secondary">
                                        Kembali <i class="fas fa-arrow-left"></i></a>
                                <?php else : ?>
                                    <a href="<?= base_url('Kegiatan/pengajuanRancangan') ?>" style="float:right" class="btn btn-icon btn-secondary">
                                        Kembali <i class="fas fa-arrow-left"></i></a>
                                <?php endif; ?>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>