<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Poin Skp Mahasiswa</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">

                    <div class="card-body">

                        <div class="row float-right">
                            <div class="col-lg-12">
                                <div class="kategori-filter align-middle  mb-2">
                                    <select name="jurusan" id="filter_jurusan" class="form-control-sm">
                                        <option value="" selected>Semua Jurusan..</option>
                                        <?php foreach ($filter_skp['jurusan'] as $j) : ?>
                                            <option value="<?= $j ?>"><?= $j ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="prodi" id="filter_prodi" class="form-control-sm">
                                        <option value="" selected>Semua prodi..</option>
                                        <?php foreach ($filter_skp['prodi'] as $j) : ?>
                                            <option value="<?= $j ?>"><?= $j ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="kategori" id="filter_kategori" class="form-control-sm">
                                        <option value="" selected>Semua kategori..</option>
                                        <option value="kurang">Kurang</option>
                                        <option value="cukup">Cukup</option>
                                        <option value="baik">Baik</option>
                                        <option value="sangat baik">Sangat Baik</option>
                                        <option value="dengan pujian">Dengan Pujian</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row float-left">
                            <form class=" m-t-20" action="<?= base_url('Export/exportPoinSkp') ?>" method="get">
                                <!-- <span>Range Tanggal Pengajuan</span> -->
                                <div class="col-lg-12 input-group mb-3  ">
                                    <input type="date" name="tgl_pengajuan_start" id="tgl_pengajuan_start" class="form-control">
                                    <input type="date" name="tgl_pengajuan_end" id="tgl_pengajuan_date" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="dataTabelPoinSkp">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">No</th>
                                        <th style="width: 10%;">Nim</th>
                                        <th style="width: 40%;">Nama</th>
                                        <th style="width: 10%;">Jurusan</th>
                                        <th style="width: 10%;">Prodi</th>
                                        <th style="width: 5%;">Poin SKP</th>
                                        <th style="width: 10%;">Kategori</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Awal Modal Detail Profil -->
<div class="modal fade bd-example-modal-lg modalDetailSKP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Poin SKP</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_mahasiswa"></h6>
                                <h6 class="card-title nim_mahasiswa"></h6>
                                <h6 class="card-title prodi_mahasiswa"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead style="background-color: rgb(39, 60, 117);color: #fff;">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Prestasi</th>
                                                <th>Tingkatan</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Bidang</th>
                                                <th>Bobot</th>
                                                <th>Nilai Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-skp">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Profil -->

<!-- modal revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="infoRevisi">
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
                                        <textarea readonly name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
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