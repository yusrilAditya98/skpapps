<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message');  ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <a href="#" class="btn btn-primary float-right pl-3 text-white tambah-user" data-toggle="modal" data-target=".modalTambahUser">
                                    <i class="fas fa-plus"></i><span> Tambah User</span>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped text-wrap table-kategori text-center" id="tabel-user">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Status User</th>
                                        <th>Status Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($user as $u) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td><?= $u['username'] ?></td>
                                            <td><?= $u['nama'] ?></td>
                                            <td><?= $u['jenis_user'] ?></td>
                                            <td>
                                                <?php
                                                    if ($u['is_active'] == 1) {
                                                        echo '<p class="text-success">Aktif</p>';
                                                    } else {
                                                        echo '<p class="text-danger">Tidak Aktif</p>';
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-success edit-user" data-toggle="modal" data-target=".modalEditUser" data-id="<?= $u['id_user'] ?>"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger hapus-user" data-id="<?= $u['id_user'] ?>" data-nama="<?= $u['nama'] ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


<!-- Awal Modal Tambah User -->
<div class="modal fade bd-example-modal-lg modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Tambah User</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('admin/tambahUser') ?>" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="status_user" class="col-form-label">Status User</label>
                                    <select class="form-control" id="status_user" name="status_user" placeholder="status_user">
                                        <option value="0" disabled selected hidden>Pilih Status User</option>
                                    </select>
                                </div>
                                <div class="form-group" id="prodi-extend">
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif" class="col-form-label">Status Aktif</label>
                                    <select class="form-control" id="status_aktif" name="status_aktif" placeholder="status_aktif">
                                        <option value="0" disabled selected hidden>Pilih Status Aktif</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Tambah User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Tambah User -->

<!-- Awal Modal Edit User -->
<div class="modal fade bd-example-modal-lg modalEditUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">Edit
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white" id="exampleModalLabel">Edit User</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <form action="<?= base_url('admin/editUser') ?>" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username_edit" name="username" placeholder="Masukkan Username">
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama_edit" name="nama" placeholder="Masukkan Nama">
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="status_user" class="col-form-label">Status User</label>
                                    <select class="form-control" id="status_user_edit" name="status_user" placeholder="status_user">
                                        <option value="0" disabled selected hidden>Pilih Status User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif" class="col-form-label">Status Aktif</label>
                                    <select class="form-control" id="status_aktif_edit" name="status_aktif" placeholder="status_aktif">
                                        <option value="0" disabled selected hidden>Pilih Status Aktif</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Edit User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Edit User -->