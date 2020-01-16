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
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <!-- Awal Modal Tambah User -->
                        <form class="needs-validation" action="<?= base_url('admin/editPimpinan/') . $pimpinan['id'] ?>" method="post" novalidate="">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="nip">Nip</label>
                                    <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan nip" value="<?= $pimpinan['nip']; ?>" required>
                                    <?= form_error('nip', '<small class="text-danger">', '</small>'); ?>
                                    <div class="invalid-feedback">
                                        nip harap diisikan !
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $pimpinan['nama']  ?>" required>
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="<?= $pimpinan['jabatan']  ?>" required>
                                    <?= form_error('jabatan', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                <a href="<?= base_url('Admin/daftarPimpinan') ?>" class="btn btn-secondary mr-2 float-right">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>