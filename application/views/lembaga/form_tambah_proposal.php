<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Pengajuan Proposal</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Point SKP</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Kegiatan/tambahProposal/') . $proker['id_daftar_rancangan'] ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="bagian-personality">
                                            <h5>Data Pemohon</h5>
                                            <div class="form-group">
                                                <label for="namaLembaga">Nama Lembaga</label>
                                                <input type="text" class="form-control" id="namaLembaga" name="namaLembaga" value="<?= $this->session->userdata('nama') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nim">Id Lembaga</label>
                                                <input type="text" class="form-control" id="nim" name="nim" value="<?= $this->session->userdata('username') ?>" readonly>
                                                <input type="hidden" name="id_rancangan" value="<?= $proker['id_daftar_rancangan'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="penanggungJawab">Nama Penanggung Jawab</label>
                                                <input type="text" class="form-control" id="penanggungJawab" name="penanggungJawab" required>
                                                <div class="invalid-feedback">
                                                    Nama penanggung jawab harap diisi!
                                                </div>
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
                                                <input type="number" class="form-control" id="danaKegiatan" name="danaKegiatan" value="<?= $proker['anggaran_kegiatan'] ?>" required readonly>
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

                                        </div>
                                        <div class="bagian-acara mt-5">
                                            <h5>Informasi Acara</h5>
                                            <div class="form-group">
                                                <label for="namaKegiatan">Judul Acara / Kegiatan</label>
                                                <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" value="<?= $proker['nama_proker'] ?>" readonly required>
                                                <div class="invalid-feedback">
                                                    Nama kegiatan harap diisi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="namaPenyelenggara">Nama Penyelenggara</label>
                                                <input type="text" class="form-control" id="namaPenyelenggara" name="namaPenyelenggara">
                                                <div class="invalid-feedback">
                                                    Nama penyelenggara harap diisi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="urlPenyelenggara">URL Penyelenggara</label>
                                                <input type="text" class="form-control" id="urlPenyelenggara" name="urlPenyelenggara">
                                                <div class="invalid-feedback">
                                                    URL penyelenggara harap diisi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tahun_kegiatan">Periode Pengajuan</label>
                                                <input type="text" class="form-control" id="tahun_kegiatan" name="tahun_kegiatan" value="<?= $proker['tahun_kegiatan'] ?>" readonly required>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsiKegiatan">Deskripsi Kegiatan</label>
                                                <textarea class="form-control" id="deskripsiKegiatan" name="deskripsiKegiatan" style="height: 100px;" required></textarea>
                                                <div class="invalid-feedback">
                                                    Deskripsi kegiatan harap diisi
                                                </div>
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
                                                    <option value="0">-- Pilih Tingkat Kegiatan --</option>
                                                </select>
                                                <div class=" invalid-feedback">
                                                    Tingkat kegiatan harap dipilih
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tglPelaksanaan">Tanggal Mulai Pelaksanaan</label>
                                                <input type="text" class="form-control datepicker" id="tglPelaksanaan" name="tglPelaksanaan" required>
                                                <div class="invalid-feedback">
                                                    Tanggal mulai pelaksanaan harap diisi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tglPelaksanaan">Tanggal Selesai Pelaksanaan</label>
                                                <input type="text" class="form-control datepicker" id="tglSelesaiPelaksanaan" name="tglSelesaiPelaksanaan" required>
                                                <div class="invalid-feedback">
                                                    Tanggal selesai pelaksanaan harap diisi
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
                                                <div class="col-lg-6">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Anggota</label>
                                                        <div class="col-lg-2">
                                                            <input type="number" class="form-control jumlahAnggota" name="jumlahAnggota" id="jumlahAnggota" readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <a class="btn btn-icon btn-primary mb-3 text-white daftarMahasiswa" style="float:right" data-toggle="modal" data-target="#daftarMahasiswa">
                                                        Pilih Anggota <i class="fas fa-plus pl-2 text-white"></i></a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nim</th>
                                                            <th>Nama</th>
                                                            <th>Jurusan</th>
                                                            <th>Prodi</th>
                                                            <th>Posisi</th>
                                                            <th>Aksi</th>
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
                                                <label for="fileProposal">Upload File Proposal</label>
                                                <input type="file" class="form-control-file btn" id="fileProposal" name="fileProposal" required>
                                                <div class="invalid-feedback">
                                                    File proposal harap diisi
                                                </div>
                                                <small id="anggaranHelp" class="form-text text-muted">Silahkan
                                                    Upload File Dokumen Dalam Bentuk File PDF Maksimal 2
                                                    Mega,
                                                    Format File : Tahun_Nama_Proposal Contoh :
                                                    2019_AdityaYusrilFikri_Proposal. Format Proposal
                                                    <span><a href="#">Disini</a></span></small>

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
                                                    Format Gambar JPG/JPEG Ukuran Maksimal 2 mega. Upload gambar dapat berupa poster, undangan, LOA dan pelengkap lainnya.
                                                </small>
                                            </div>
                                            <div class="form-group">
                                                <label for="gambarKegiatanProposal2">Upload Gambar Kegiatan 2 / Acara
                                                    Pendukung</label>
                                                <input type="file" class="form-control-file btn" name="gambarKegiatanProposal2" id="gambarKegiatanProposal2">
                                                <small class="form-text text-muted">
                                                    Format Gambar JPG/JPEG Ukuran Maksimal 2 mega. Upload gambar dapat berupa poster, undangan, LOA dan pelengkap lainnya.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="action-button">
                                            <button onclick="return confirm('Apakah anda sudah yakin ?')" type="submit" onclick="return confirm('Apakah anda sudah yakin ?')" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                                Kirim Proposal <i class="fas fa-plus"></i></button>

                                            <a href="<?= base_url('Kegiatan/pengajuanProposal') ?>" style="float:right" class="btn btn-icon btn-secondary">
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