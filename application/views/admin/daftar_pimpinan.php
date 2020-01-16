<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-user">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($pimpinan as $u) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td><?= $u['nip'] ?></td>
                                            <td><?= $u['nama'] ?></td>
                                            <td><?= $u['jabatan'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/editPimpinan/') . $u['id'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
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