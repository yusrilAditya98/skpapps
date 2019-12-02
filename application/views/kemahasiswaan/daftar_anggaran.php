<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permintaan Pengajuan Lpj Kegiatan</h4>

                    </div>
                    <div class="card-body">
                        <a href="#" data-toggle="modal" data-target="#tambahAnggaran" data-id="" class="btn btn-icon icon-left btn-success float-right tambahAnggaran"><i class="fas fa-plus"></i>Tambah Anggaran Lembaga</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="text"> No</th>
                                        <th>Tahun Periode</th>
                                        <th>Nama Lembaga Pengaju</th>
                                        <th>Total Dana Pagu </th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lembaga as $l) : ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $l['tahun_pengajuan'] ?></td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td><?= $l['anggaran_kemahasiswaan'] ?></td>

                                            <td>

                                                <a href="<?= base_url('Mahasiswa/editAnggaran/') . $l['id_rancangan']  ?>" class="btn btn-icon btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('Mahasiswa/deleteAnggaran/') . $l['id_rancangan']  ?>" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
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


<!-- Info revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahAnggaran">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Penambahan Dana Pagu Lembaga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Kemahasiswaan/tambahAnggaranKegiatan') ?>" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th class="text"> No</th>
                                        <th>Nama Lembaga Pengaju</th>
                                        <th>Dana Pagu </th>
                                    </tr>
                                </thead>
                                <tbody class="data-lembaga">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <div class="input-group">
                        <select class="custom-select" id="tahun" name="tahun_rancangan" required>
                            <option value="">Pilih tahun pengajuan proker...</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>