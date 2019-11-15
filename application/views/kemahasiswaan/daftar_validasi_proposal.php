<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Proposal Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Rancangan Kegiatan</h4>

                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-icon icon-left btn-warning float-right"><i class="fas fa-print"></i> Cetak Pengajuan</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>

                                    <th class="text">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            No
                                        </div>
                                    </th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Pengaju</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Status</th>
                                    <th class="text-center">Kmhsn</th>
                                    <th class="text-center">WD 3</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    1
                                                </div>
                                            </td>
                                            <td><?= $k['tgl_pengajuan_proposal'] ?></td>
                                            <td><?= $k['nama_lembaga'] ?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#detailKegiatan"><?= $k['nama_kegiatan'] ?></a>
                                            </td>
                                            <td>
                                                <?php if ($k['status_selesai_proposal'] == 0) : ?>
                                                    <span><i class="fa fa-dot-circle mr-2 text-primary"></i>Belum diproses</span>
                                                <?php elseif ($k['status_selesai_proposal'] == 1) : ?>
                                                    <span>Sedang Berlangsung</span>
                                                <?php elseif ($k['status_selesai_proposal'] == 2) : ?>
                                                    <span><i class="fa fa-dot-circle"></i>Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php foreach ($validasi as $v) : ?>
                                                <?php if ($v['id_kegiatan'] == $k['id_kegiatan'] && ($v['jenis_validasi'] == 3 || $v['jenis_validasi'] == 4)) : ?>
                                                    <td class="text-center">
                                                        <?php if ($v['status_validasi'] == 1) :  ?>
                                                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 2) : ?>
                                                            <i class="fa fa-check text-danger" aria-hidden="true"></i>
                                                        <?php elseif ($v['status_validasi'] == 0) : ?>
                                                            <i class="fa fa-circle text-primary" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <td><a href="#" class="btn btn-icon btn-success"><i class="fas fa-check"></i></a>
                                                <a href="#" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-outline-success"><i class="fa-whatsapp"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

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
    <div class="modal-dialog modal-xl"" role=" document">
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

                        <div class="profile-widget-description">

                            <div class="bagian-personality">
                                <h5>Informasi Personality</h5>
                                <div class="form-group">
                                    <label for="namaMahasiswa">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="noTlpm">No Telepon / Whatsapp</label>
                                    <input type="number" class="form-control" id="noTlpm" name="noTlpn" required>
                                    <div class="invalid-feedback">
                                        No Telepon / Whatsapp harap diisi
                                    </div>
                                </div>
                            </div>
                            <div class="bagian-dana mt-5">
                                <h5>Informasi Dana</h5>
                                <div class="form-group">
                                    <label for="danaKegiatan">Besar Anggaran</label>
                                    <input type="number" class="form-control" id="danaKegiatan" name="danaKegiatan" required>
                                    <div class="invalid-feedback">
                                        Besar anggaran harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="danaKegiatanDiterima">Anggran Diterima</label>
                                    <input type="text" class="form-control" id="danaKegiatanDiterima" name="danaKegiatanDiterima" readonly>
                                    <small id="anggaranHelp" class="form-text text-muted">Dana
                                        anggaran yang akan diterima 70% dari besar anggaran
                                        pengajuan</small>
                                </div>
                                <div class="sumber-dana-chekboxes mb-3">
                                    <h6>Sumber Dana</h6>

                                    <div class="form-check py-1">

                                    </div>

                                </div>
                            </div>
                            <div class="bagian-acara mt-5">
                                <h5>Informasi Acara</h5>
                                <div class="form-group">
                                    <label for="namaKegiatan">Judul Acara / Kegiatan</label>
                                    <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" required>
                                    <div class="invalid-feedback">
                                        Nama Kegiatan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsiKegiatan">Deskripsi Kegiatan</label>
                                    <textarea class="form-control" id="deskripsiKegiatan" name="deskripsiKegiatan" style="height: 100px" required>
                                                </textarea>
                                    <div class="invalid-feedback">
                                        Nama Kegiatan harap diisi
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label for="bidangKegiatan">Bidang Kegiatan</label>
                                    <select class="custom-select bidangKegiatan select2" id="bidangKegiatan" name="bidangKegiatan" name="bidangKegiatan" required>
                                        <option value="">-- Pilih Bidang Kegiatan --</option>
                                    </select>
                                    <div class=" invalid-feedback">
                                        Bidang kegiatan harap dipilih
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenisKegiatan">Jenis Kegiatan</label>
                                    <select class="custom-select jenisKegiatan select2" id="jenisKegiatan" name="jenisKegiatan" required>
                                        <option value="">-- Pilih Jenis Kegiatan --</option>
                                    </select>
                                    <div class=" invalid-feedback">
                                        Jenis kegiatan harap dipilih
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tingkatKegiatan">Tingkat Kegiatan</label>
                                    <select class="custom-select tingkatKegiatan select2" id="tingkatKegiatan" name="tingkatKegiatan" required>
                                        <option value="">-- Pilih Tingkat Kegiatan --</option>
                                    </select>
                                    <div class=" invalid-feedback">
                                        Tingkat kegiatan harap dipilih
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tglPelaksanaan">Tanggal Pelaksanaan</label>
                                    <input type="date" class="form-control datepicker" id="tglPelaksanaan" name="tglPelaksanaan" required>
                                    <div class="invalid-feedback">
                                        Tanggal pelaksanaan harap diisi
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tempatPelaksanaan">Tempat Pelaksanaan</label>
                                    <input type="text" class="form-control" id="tempatPelaksanaan" name="tempatPelaksanaan" required>
                                    <div class="invalid-feedback">
                                        Tempat pelaksanaan harap diisi
                                    </div>
                                </div>
                            </div>

                            <div class="bagian-acara mt-5">
                                <h5>Anggota Kegiatan</h5>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <a class="btn btn-icon btn-primary mb-3 text-white daftarMahasiswa" style="float:right" data-toggle="modal" data-target="#daftarMahasiswa">
                                            Tambah Anggota <i class="fas fa-plus pl-2 text-white"></i></a>
                                        <input type="hidden" value="0" name="jumlahAnggota" id="jumlahAnggota">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nim</th>
                                                <th>Nama</th>
                                                <th>Posisi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="daftar-mhs">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class=" bagian-upload mt-5">
                                <h5>Informasi Upload</h5>

                                <div class="form-group">
                                    <label for="fileProposal"> File Proposal</label>
                                    <canvas id="file_proposal"></canvas>

                                </div>
                                <div class="form-group">
                                    <label for="beritaProposal">Upload Berita Kegiatan
                                        Proposal</label>
                                    <input type="file" class="form-control-file btn" name="beritaProposal" id="beritaProposal" required>
                                    <div class="invalid-feedback">
                                        Berita kegiatan harap diisi
                                    </div>
                                    <small id="anggaranHelp" class="form-text text-muted">Silahkan
                                        Upload File Dokumen Dalam Bentuk File PDF Maksimal 2
                                        Mega,
                                        File berita acara dalam bahasa
                                        indonesia dan bahasa inggris, Format Nama File :
                                        Tahun_Acara_Nama_yang_upload_acara Contoh
                                        : (2019_Agus_Debat_Nasional). Format Berita Kegiatan
                                        <span><a href="#">Disini</a></span></small>
                                </div>
                                <div class="form-group">
                                    <label for="gambarKegiatanProposal1">Upload Gambar Kegiatan 1 / Acara
                                        Pendukung</label>
                                    <input type="file" class="form-control-file btn" name="gambarKegiatanProposal1" id="gambarKegiatanProposal1" required>
                                    <div class="invalid-feedback">
                                        Gambar kegiatan harap diisi
                                    </div>
                                    <small class="form-text text-muted">
                                        Format Gambar JPG/JPEG Ukuran Maksimal 2 mega
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="gambarKegiatanProposal2">Upload Gambar Kegiatan 2 / Acara
                                        Pendukung</label>
                                    <input type="file" class="form-control-file btn" name="gambarKegiatanProposal2" id="gambarKegiatanProposal2" required>
                                    <small class="form-text text-muted">
                                        Format Gambar JPG/JPEG Ukuran Maksimal 2 mega
                                    </small>
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