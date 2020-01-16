<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Pengajuan Proposal</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Edit Pengajuan Proposal</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Mahasiswa/editProposal/') . $kegiatan['id_kegiatan']  ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <input type="hidden" name="id_kegiatan" value="<?= $kegiatan['id_kegiatan'] ?>">
                                        <div class="bagian-personality">
                                            <h5>Informasi Personality</h5>
                                            <div class="form-group">
                                                <label for="namaMahasiswa">Nama Mahasiswa</label>
                                                <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa" value="<?= $this->session->userdata('nama') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nim">NIM</label>
                                                <input type="text" class="form-control" id="nim" name="nim" value="<?= $this->session->userdata('username') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="noTlpm">No Telepon / Whatsapp</label>
                                                <input type="number" class="form-control" id="noTlpm" name="noTlpn" value="<?= $kegiatan['no_whatsup'] ?>" required>
                                                <div class="invalid-feedback">
                                                    No Telepon / Whatsapp harap diisi
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($jenis_revisi == 0 || $jenis_revisi == 2 || $jenis_revisi == 3 || $jenis_revisi == 4 || $jenis_revisi == 6) : ?>
                                            <div class="bagian-dana mt-5">
                                                <h5>Informasi Dana</h5>
                                                <div class="form-group">
                                                    <label for="danaKegiatan">Besar Anggaran</label>
                                                    <input type="number" class="form-control" id="danaKegiatan" name="danaKegiatan" value="<?= $kegiatan['dana_kegiatan']  ?>" required>
                                                    <div class="invalid-feedback">
                                                        Besar anggaran harap diisi
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="danaKegiatanDiterima">Anggran Diterima</label>
                                                    <input type="text" class="form-control" id="danaKegiatanDiterima" name="danaKegiatanDiterima" value="<?= $kegiatan['dana_proposal'] ?>" readonly>
                                                    <small id="anggaranHelp" class="form-text text-muted">Dana
                                                        anggaran yang akan diterima 70% dari besar anggaran
                                                        pengajuan</small>
                                                </div>

                                            </div>
                                        <?php endif; ?>
                                        <div class="bagian-acara mt-5">
                                            <h5>Informasi Acara</h5>
                                            <div class="form-group">
                                                <label for="namaKegiatan">Judul Acara / Kegiatan</label>
                                                <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" value="<?= $kegiatan['nama_kegiatan']  ?>" required>
                                                <div class="invalid-feedback">
                                                    Nama Kegiatan harap diisi
                                                </div>
                                            </div>
                                            <?php if ($jenis_revisi == 0 || $jenis_revisi == 2 || $jenis_revisi == 3 || $jenis_revisi == 4) : ?>
                                                <div class="form-group">
                                                    <label for="deskripsiKegiatan">Deskripsi Kegiatan</label>
                                                    <textarea class="form-control" id="deskripsiKegiatan" name="deskripsiKegiatan" style="height: 100px;" required><?= $kegiatan['deskripsi_kegiatan']  ?></textarea>
                                                    <div class="invalid-feedback">
                                                        Deskripsi Kegiatan harap diisi
                                                    </div>
                                                </div>
                                                <div class=" form-group">
                                                    <label for="bidangKegiatan">Bidang Kegiatan</label>
                                                    <select class="custom-select bidangKegiatan" id="bidangKegiatan" name="bidangKegiatan" name="bidangKegiatan" required>
                                                        <option value="">-- Pilih Bidang Kegiatan --</option>
                                                    </select>
                                                    <input type="hidden" class="k_bidang" name="k_bidang" value="<?= ($tingkat ? $tingkat[0]['id_bidang'] : 0) ?>">
                                                    <div class=" invalid-feedback">
                                                        Bidang kegiatan harap dipilih
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jenisKegiatan">Jenis Kegiatan</label>
                                                    <select class="custom-select jenisKegiatan" id="jenisKegiatan" name="jenisKegiatan" required>
                                                        <option value="">-- Pilih Jenis Kegiatan --</option>
                                                    </select>
                                                    <input type="hidden" class="k_jenis" name="k_jenis" value="<?= ($tingkat ? $tingkat[0]['id_jenis_kegiatan'] : 0) ?>">
                                                    <div class=" invalid-feedback">
                                                        Jenis kegiatan harap dipilih
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tingkatKegiatan">Tingkat Kegiatan</label>
                                                    <select class="custom-select tingkatKegiatan" id="tingkatKegiatan" name="tingkatKegiatan" required>
                                                        <option value="">-- Pilih Tingkat Kegiatan --</option>
                                                    </select>
                                                    <input type="hidden" class="k_tingkat" name="k_tingkat" value="<?= ($tingkat ? $tingkat[0]['id_semua_tingkatan'] : 0) ?>">
                                                    <input type="hidden" class="k_partisipasi" name="k_partisipasi" value="<?= ($tingkat ? $tingkat[0]['id_semua_prestasi'] : 0) ?>">
                                                    <div class=" invalid-feedback">
                                                        Tingkat kegiatan harap dipilih
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tglPelaksanaan">Tanggal Pelaksanaan</label>
                                                    <input type="date" class="form-control datepicker" id="tglPelaksanaan" name="tglPelaksanaan" value="<?= $kegiatan['tanggal_kegiatan'] ?>" required>
                                                    <div class="invalid-feedback">
                                                        Tanggal pelaksanaan harap diisi
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tempatPelaksanaan">Tempat Pelaksanaan</label>
                                                    <input type="text" class="form-control" id="tempatPelaksanaan" name="tempatPelaksanaan" value="<?= $kegiatan['lokasi_kegiatan'] ?>" required>
                                                    <div class="invalid-feedback">
                                                        Tempat pelaksanaan harap diisi
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($jenis_revisi == 0 || $jenis_revisi == 2 || $jenis_revisi == 3 || $jenis_revisi == 4) : ?>
                                            <div class="bagian-acara mt-5">
                                                <h5>Anggota Kegiatan</h5>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group row mb-4">
                                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Anggota</label>
                                                            <div class="col-lg-2">
                                                                <input type="number" class="form-control" name="jumlahAnggota" id="jumlahAnggota" value="<?= count($tingkat) ?>" required readonly>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-6">
                                                        <a class="btn btn-icon btn-primary mb-3 text-white daftarMahasiswa" style="float:right" data-toggle="modal" data-target="#daftarMahasiswa">
                                                            Pilih Anggota <i class="fas fa-plus pl-2 text-white"></i></a>
                                                        <input type="hidden" value="<?= count($tingkat) ?>" name="jumlahAnggota" id="jumlahAnggota">
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
                                                            <?php if ($tingkat) : ?>
                                                                <?php $index = 1;
                                                                        $id = 1;
                                                                        foreach ($tingkat as $a) : ?>
                                                                    <tr class="d-m" id="data-<?= $a['nim'] ?>">
                                                                        <td><?= $index++ ?></td>
                                                                        <td><?= $a['nim'] ?>
                                                                            <input type="hidden" name="nim_<?= $a['nim'] ?>" value="<?= $a['nim'] ?>" id="nim_<?= $a['nim'] ?>">
                                                                        </td>
                                                                        <td><?= $a['nama'] ?></td>
                                                                        <td><?= $a['nama_prestasi'] ?>
                                                                            <input type="hidden" name="prestasi_<?= $a['nim'] ?>" value="<?= $a['id_semua_prestasi'] ?>" id="nim_<?= $a['nim']; ?>">
                                                                        </td>
                                                                        <td> <button type="button" data-id="<?= $a['nim'] ?>" class="btn btn-danger hps-mhs"><i class="fas fa-trash-alt"></i></button></td>
                                                                    </tr>
                                                                <?php $id++;
                                                                        endforeach; ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($jenis_revisi == 0 || $jenis_revisi == 2 || $jenis_revisi == 3 || $jenis_revisi == 4 || $jenis_revisi == 5) : ?>
                                            <div class=" bagian-upload mt-5">
                                                <h5>Informasi Upload</h5>

                                                <div class="form-group">
                                                    <label for="fileProposal">Upload File Proposal - <a class="btn btn-primary" href="<?= base_url('assets/pdfjs/web/viewer.html?file=../../../file_bukti/proposal/') . $kegiatan['proposal_kegiatan'] ?>" target="_blank">Lihat</a></label>
                                                    <input type="file" class="form-control-file btn" id="fileProposal" name="fileProposal">
                                                    <small id="anggaranHelp" class="form-text text-muted">Silahkan
                                                        Upload File Dokumen Dalam Bentuk File PDF Maksimal 2
                                                        Mega,
                                                        Format File : Tahun_Nama_Proposal Contoh :
                                                        2019_AdityaYusrilFikri_Proposal. Format Proposal
                                                        <span><a href="#">Disini</a></span></small>

                                                </div>
                                                <div class="form-group">
                                                    <label for="beritaProposal">Upload Berita Kegiatan
                                                        Proposal - <a class="btn btn-primary" href="<?= base_url('assets/pdfjs/web/viewer.html?file=../../../file_bukti/berita_proposal/') . $kegiatan['berita_proposal'] ?>" target="_blank">Lihat</a></label>
                                                    <input type="file" class="form-control-file btn" name="beritaProposal" id="beritaProposal">

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
                                                    <label for="gambarKegiatanProposal1">Upload Gambar Kegiatan 1 / Acara Pendukung - <a class="btn btn-primary" href="<?= base_url('file_bukti/foto_proposal/') . $dokumentasi['d_proposal_1'] ?>" target="_blank">Lihat</a></label>
                                                    <input type="file" class="form-control-file btn" name="gambarKegiatanProposal1" id="gambarKegiatanProposal1">
                                                    <small class="form-text text-muted">
                                                        Format Gambar JPG/JPEG Ukuran Maksimal 2 mega
                                                    </small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gambarKegiatanProposal2">Upload Gambar Kegiatan 2 / Acara Pendukung - <a class="btn btn-primary" href="<?= base_url('file_bukti/foto_proposal/') . $dokumentasi['d_proposal_2'] ?>" target="_blank">Lihat</a></label>
                                                    <input type="file" class="form-control-file btn" name="gambarKegiatanProposal2" id="gambarKegiatanProposal2">
                                                    <small class="form-text text-muted">
                                                        Format Gambar JPG/JPEG Ukuran Maksimal 2 mega
                                                    </small>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="action-button">
                                            <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                                Edit Proposal <i class="fas fa-plus"></i></button>
                                            <input type="hidden" value="<?= $jenis_revisi ?>" name="jenis_revisi">
                                            <a href="<?= base_url('Mahasiswa/pengajuanProposal') ?>" style="float:right" class="btn btn-icon btn-secondary">
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

<!-- Modal daftar mahasiswa -->
<div class="modal fade" tabindex="-1" role="dialog" id="daftarMahasiswa">
    <div class="modal-dialog modal-xl" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Mahasiswa FEB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table-mhs">
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit-mhs" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>