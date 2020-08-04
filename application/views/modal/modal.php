<!-- modal revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="i-revisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-revisi" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-description">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tanggal Revisi</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control d-tgl" value="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Reviewer</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control d-reviewer" value="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Catatan Revisi</label>
                                    <div class="col-sm-9">
                                        <textarea name="catatan" class="form-control d-catatan" style="height:200px" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal detail kegiatan -->
<!-- modal detail kegiatan -->
<div class="modal fade" tabindex="-1" role="dialog" id="i-kegiatan">
    <div class="modal-dialog modal-xl" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <ul class="nav nav-pills" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="personality-tab3" data-toggle="tab" href="#personality" role="tab" aria-controls="personalitya" aria-selected="true">Data Pemohon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dana-tab3" data-toggle="tab" href="#dana" role="tab" aria-controls="dana" aria-selected="false">Dana</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="acara-tab3" data-toggle="tab" href="#acara" role="tab" aria-controls="acara" aria-selected="false">Acara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="anggota-tab3" data-toggle="tab" href="#anggota" role="tab" aria-controls="anggota" aria-selected="false">Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="file-tab3" data-toggle="tab" href="#file" role="tab" aria-controls="file" aria-selected="false">File</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade active show" id="personality" role="tabpanel" aria-labelledby="personality-tab3">
                        <div class="form-group">
                            <label for="namaMahasiswa">Nama Pengaju</label>
                            <input type="text" class="form-control k-pengaju" id="namaMahasiswa" name="namaMahasiswa" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nim">Jenis Pengajuan</label>
                            <input type="text" class="form-control k-nim" id="nim" name="nim" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="noTlpm">No Telepon / Whatsapp</label>
                            <input type="number" class="form-control k-notlpn" id="noTlpm" name="noTlpn" value="" readonly>
                            <div class="invalid-feedback">
                                No Telepon / Whatsapp harap diisi
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="dana" role="tabpanel" aria-labelledby="dana-tab3">
                        <div class="form-group">
                            <label for="danaKegiatan">Besar Anggaran</label>
                            <input type="text" class="form-control k-dana uang" id="danaKegiatan" name="danaKegiatan" value="" readonly>
                            <div class="invalid-feedback">
                                Besar anggaran harap diisi
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="danaKegiatanDiterima">Anggran Diterima</label>
                            <input type="text" class="form-control k-dana-cair" id="danaKegiatanDiterima" name="danaKegiatanDiterima" value="" readonly>
                            <small id="anggaranHelp" class="form-text text-muted">Dana
                                anggaran yang akan diterima</small>
                        </div>
                        <div class="form-group f-proposal">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="acara" role="tabpanel" aria-labelledby="acara-tab3">
                        <div class="form-group">
                            <label for="namaKegiatan">Judul Acara / Kegiatan</label>
                            <input type="text" class="form-control k-nama_kegiatan" id="namaKegiatan" name="namaKegiatan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="namaPenyelenggara">Nama Penyelenggara</label>
                            <input type="text" class="form-control k-nama_penyelenggara" id="namaPenyelenggara" name="namaPenyelenggara" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="urlPenyelenggara">URL Penyelenggara</label>
                            <input type="text" class="form-control k-url_penyelenggara" id="urlPenyelenggara" name="urlPenyelenggara" value="ce" readonly>
                        </div>
                        <div class="form-group">
                            <label for="deskripsiKegiatan">Deskripsi Kegiatan</label>
                            <textarea class="form-control k-deskripsi_kegiatan" id="deskripsiKegiatan" name="deskripsiKegiatan" style="height: 100px;" readonly></textarea>
                        </div>
                        <div class=" form-group">
                            <label for="bidangKegiatan">Bidang Kegiatan</label>
                            <input type="text" class="form-control k-bidang_kegiatan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenisKegiatan">Jenis Kegiatan</label>
                            <input type="text" class="form-control k-jenis_kegiatan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tingkatKegiatan">Tingkat Kegiatan</label>
                            <input type="text" class="form-control k-tingkat_kegiatan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tglPelaksanaan">Tanggal Mulai Pelaksanaan</label>
                            <input type="date" class="form-control k-tgl_kegiatan" id="tglPelaksanaan" name="tglPelaksanaan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tglSelesaiPelaksanaan">Tanggal Selesai Pelaksanaan</label>
                            <input type="date" class="form-control k-tgl_selesai_kegiatan" id="tglSelesaiPelaksanaan" name="tglSelesaiPelaksanaan" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tempatPelaksanaan">Tempat Pelaksanaan</label>
                            <input type="text" class="form-control k-tempat" id="tempatPelaksanaan" name="tempatPelaksanaan" value="" readonly>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="anggota" role="tabpanel" aria-labelledby="anggota-tab3">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Prodi</th>
                                        <th class="th-posisi">Posisi</th>
                                        <th class="th-bobot">Bobot</th>
                                        <th>Keaktifan</th>
                                    </tr>
                                </thead>
                                <tbody class="daftar-mhs">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab3">
                        <div class="form-group">
                            <label for="fileProposal"> File - <a target="_blank" class="btn btn-primary k-proposal" href="">Lihat</a></label>
                        </div>
                        <div class="form-group">
                            <label for="beritaProposal"> Berita Kegiatan
                                - <a class="btn btn-primary k-berita-p" target="_blank" href="">Lihat</a></label>
                        </div>
                        <div class="form-group">
                            <label for="gambarKegiatanProposal1"> Gambar Kegiatan 1 / Acara Pendukung - <a class="btn btn-primary k-gmbr-1" href="" target="_blank">Lihat</a></label>
                        </div>
                        <div class="form-group">
                            <label for="gambarKegiatanProposal2"> Gambar Kegiatan 2 / Acara Pendukung - <a target="_blank" class="btn btn-primary k-gmbr-2">Lihat</a></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer br t-validasi">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>


        </div>
    </div>
</div>

<!-- modal revisi -->
<div class="modal fade infoRevisi" tabindex="-1" role="dialog" id="infoRevisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-revisi" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-description">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Catatan Revisi</label>
                                    <div class="col-sm-9">
                                        <textarea name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
                                    <input type="hidden" name="revisi" value="2">
                                    <input type="hidden" name="jenis_validasi" class="jenis_validasi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>