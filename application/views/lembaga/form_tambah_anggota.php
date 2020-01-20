<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penambahan Anggota</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Anggota</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Kegiatan/tambahRancanganAnggota/') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="bagian-personality">
                                            <h5>Informasi Personality</h5>
                                            <div class="form-group">
                                                <label for="namaLembaga">Nama Lembaga</label>
                                                <input type="text" class="form-control" id="namaLembaga" name="namaLembaga" value="<?= $this->session->userdata('nama') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_lembaga">Id Lembaga</label>
                                                <input type="text" class="form-control" id="id_lembaga" name="id_lembaga" value="<?= $this->session->userdata('username') ?>" readonly>
                                                <input type="hidden" id="jenis_lembaga" name="jenis_lembaga" value="<?= $jenis_lembaga ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="periode">Periode</label>
                                                <select class="form-control" id="periode" name="periode">
                                                    <option value="" selected hidden>Pilih Periode</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="bagian-acara mt-5">
                                            <h5>Anggota Lembaga</h5>
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
                                                    <a class="btn btn-icon btn-primary mb-3 text-white daftarMahasiswaLembaga" style="float:right" data-toggle="modal" data-target="#daftarMahasiswaLembaga">
                                                        Pilih Anggota <i class="fas fa-plus pl-2 text-white"></i></a>
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
                                        <div class="action-button">
                                            <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                                Ajukan Rancangan Anggota <i class="fas fa-plus"></i></button>

                                            <a href="<?= base_url('Kegiatan/rancanganAnggota') ?>" style="float:right" class="btn btn-icon btn-secondary">
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

<!-- Modal daftar mahasiswa - Anggota Lembaga -->
<div class="modal fade" tabindex="-1" role="dialog" id="daftarMahasiswaLembaga">
    <div class="modal-dialog modal-xl" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Mahasiswa FEB</h5>
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
                <button type="button" class="btn btn-primary submit-mhs-lembaga" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>