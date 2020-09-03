<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengaturan File Download</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengaturan File Download</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-icon btn-success float-right" data-toggle="modal" data-target="#modalTambahFile" data-whatever="@mdo">
                                    Tambah File<i class="fas fa-plus pl-2"> </i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped  table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Dilihat Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($file_download as $fd) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $fd['nama_file'] ?></td>
                                                    <td><a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>"><i class="fas fa-file-alt" style="font-size: 25px;"></i></a></td>
                                                    <td><?= $fd['status_file'] ?></td>
                                                    <td><?= $fd['dilihat_oleh'] ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-primary edit-file" data-toggle="modal" data-target="#modalEditFile" data-id="<?= $fd['id_file']  ?>" data-nama="<?= $fd['nama_file'] ?>" data-dir="<?= $fd['dir_file'] ?>" data-status="<?= $fd['status_file'] ?>" data-lihat="<?= $fd['dilihat_oleh'] ?>">Edit</button>
                                                            <a href="<?= base_url('Kemahasiswaan/hapusFileDownload/' . $fd['id_file']) ?>?nama_file=<?= $fd['dir_file']  ?>" class="btn btn-danger">Hapus</a>
                                                        </div>
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
            </div>

        </div>


        <div class="card">
            <div class="card-header">
                <h4>KOP Header Transkrip SKP</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                </div>
                <table class="table ">

                    <tbody>
                        <tr>
                            <td>
                                <a target="_blank" href="<?= base_url('/assets/img/kop/kop.png') ?>"><img src="<?= base_url('/assets/img/kop/kop.png') ?>" class="img-thumbnail" alt=""></a></td>
                            <td>
                                <form action="<?= base_url('Kemahasiswaan/uploadKop') ?>" method="post" enctype="multipart/form-data">
                                    <input type="file" name="kop">
                                    <small>KOP harus berformat .png dengan maksimal size 1024kb</small>
                                    <button class="btn btn-primary mt-2">Ubah KOP</button>
                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modalTambahFile" tabindex="-1" role="dialog" aria-labelledby="modalTambahFileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahFileLabel">Tambah File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Kemahasiswaan/tambahFileDownload') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_file" class="col-form-label">Nama File:</label>
                        <input type="text" name="nama_file" class="form-control" id="nama_file" required>
                        <div class="invalid-feedback">
                            Nama file harap diisi!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dir_file" class="col-form-label">File:</label>
                        <input type="file" name="dir_file" class="form-control" id="dir_file" required>
                        <span>File upload berupa pdf|png|jpg|jpeg|pdf|doc|docx dengan max 2048 kb</span>
                        <div class="invalid-feedback">
                            File harap diisi!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_file" class="col-form-label">Status:</label>
                        <select name="status_file" class="form-control" id="status_file" required>
                            <option value="">-- pilih status --</option>
                            <option value="panduan">panduan</option>
                            <option value="template">template</option>
                        </select>
                        <div class="invalid-feedback">
                            Status file harap diisi!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dilihat_oleh" class="col-form-label">Dilihat Oleh:</label>
                        <select name="dilihat_oleh" class="form-control" id="dilihat_oleh" required>
                            <option selected value="all">semua</option>
                            <option value="mahasiswa">mahasiswa</option>
                            <option value="lembaga">lembaga</option>
                            <option value="bem">bem</option>
                            <option value="kemahasiswaan">kemahasiswaan</option>
                            <option value="psik">psik</option>
                            <option value="keuangan">keuangan</option>
                        </select>
                        <div class="invalid-feedback">
                            Status file harap diisi!
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditFile" tabindex="-1" role="dialog" aria-labelledby="modalEditFileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditFileLabel">Edit File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Kemahasiswaan/editFileDownload') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                <input type="hidden" name="id_file" id="id_file_edit">
                <input type="hidden" name="dir_lama" id="dir_lama">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_file" class="col-form-label">Nama File:</label>
                        <input type="text" name="nama_file" class="form-control" id="nama_file_edit" required>
                        <div class="invalid-feedback">
                            Nama file harap diisi!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dir_file" class="col-form-label">File: <a id="file_edit"><i class="fas fa-file"></i></a></label>
                        <input type="file" name="dir_file" class="form-control" id="dir_file_edit">

                    </div>
                    <div class="form-group">
                        <label for="status_file" class="col-form-label">Status:</label>
                        <select name="status_file" class="form-control" id="status_file_edit" required>

                        </select>
                        <div class="invalid-feedback">
                            Status file harap diisi!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dilihat_oleh_edit" class="col-form-label">Dilihat Oleh:</label>
                        <select name="dilihat_oleh" class="form-control" id="dilihat_oleh_edit" required>

                        </select>
                        <div class="invalid-feedback">
                            Status file harap diisi!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>