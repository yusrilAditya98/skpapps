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
                                        <input type="text" class="form-control d-tgl" value="0" readonly>
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
<div class="modal fade" tabindex="-1" role="dialog" id="i-kegiatan">
    <div class="modal-dialog modal-xl" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-revisi" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-tambah-skp">

                            <input type="hidden" name="id_kegiatan" value="">
                            <div class="bagian-personality">
                                <h5>Informasi Personality</h5>
                                <div class="form-group">
                                    <label for="namaMahasiswa">Nama Pengaju</label>
                                    <input type="text" class="form-control k-pengaju" id="namaMahasiswa" name="namaMahasiswa" value="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nim">NIM</label>
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
                            <div class="bagian-dana mt-5">
                                <h5>Informasi Dana</h5>
                                <div class="form-group">
                                    <label for="danaKegiatan">Besar Anggaran</label>
                                    <input type="number" class="form-control k-dana" id="danaKegiatan" name="danaKegiatan" value="" readonly>
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
                                <div class="sumber-dana-chekboxes mb-3">
                                    <h6>Sumber Dana</h6>
                                    <div class="form-check py-1 k-sumber">
                                        <input class="form-check-input" type="hidden" value="0" id="dana" name="dana">
                                    </div>
                                </div>
                            </div>
                            <div class="bagian-acara mt-5">
                                <h5>Informasi Acara</h5>
                                <div class="form-group">
                                    <label for="namaKegiatan">Judul Acara / Kegiatan</label>
                                    <input type="text" class="form-control k-nama_kegiatan" id="namaKegiatan" name="namaKegiatan" value="" readonly>

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
                                    <label for="tglPelaksanaan">Tanggal Pelaksanaan</label>
                                    <input type="date" class="form-control k-tgl_kegiatan" id="tglPelaksanaan" name="tglPelaksanaan" value="" readonly>

                                </div>
                                <div class="form-group">
                                    <label for="tempatPelaksanaan">Tempat Pelaksanaan</label>
                                    <input type="text" class="form-control k-tempat" id="tempatPelaksanaan" name="tempatPelaksanaan" value="" readonly>

                                </div>
                            </div>

                            <div class="bagian-acara mt-5">
                                <h5>Anggota Kegiatan</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nim</th>
                                                <th>Nama</th>
                                                <th>Posisi</th>
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
                                    <label for="fileProposal"> File Proposal - <a target="_blank" class="btn btn-primary k-proposal" href="">Lihat</a></label>
                                </div>
                                <div class="form-group">
                                    <label for="beritaProposal"> Berita Kegiatan
                                        Proposal - <a class="btn btn-primary k-berita-p" target="_blank" href="">Lihat</a></label>
                                </div>
                                <div class="form-group">
                                    <label for="gambarKegiatanProposal1"> Gambar Kegiatan 1 / Acara Pendukung - <a class="btn btn-primary k-gmbr-1" href="" target="_blank">Lihat</a></label>
                                </div>
                                <div class="form-group">
                                    <label for="gambarKegiatanProposal2"> Gambar Kegiatan 2 / Acara Pendukung - <a target="_blank" class="btn btn-primary k-gmbr-2">Lihat</a></label>
                                </div>
                            </div>

                            <div class="action-button">

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