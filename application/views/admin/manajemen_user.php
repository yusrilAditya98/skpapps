<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <a href="<?= base_url('admin/tambahUser') ?>" class="btn btn-success float-right pl-3 text-white">
                                    <i class="fas fa-plus"></i><span> Tambah User</span>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-user">
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
                                            <?php if ($u['is_active'] == 1) : ?>
                                                <td class="text-success">Aktif</td>
                                            <?php else : ?>
                                                <td class="text-primary">Tidak Aktif</td>
                                            <?php endif; ?>
                                            <td>
                                                <a href="<?= base_url('admin/editUser/') . $u['username'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <button href="<?= base_url('admin/hapusUser/') . $u['id_user'] ?>" class="btn btn-danger confirm-hapus"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>