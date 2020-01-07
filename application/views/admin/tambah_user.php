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
                        <!-- Awal Modal Tambah User -->
                        <form class="needs-validation" action="<?= base_url('admin/tambahUser') ?>" method="post" novalidate="">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?= set_value('username'); ?>" required>
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                    <div class="invalid-feedback">
                                        username harap diisikan !
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= set_value('nama'); ?>" required>
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input required type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input required type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status_user" class="col-form-label">Status User</label>
                                    <select required class="form-control" id="status_user" name="status_user" placeholder="status_user">
                                        <option value="null" selected>Pilih Status User</option>
                                        <?php foreach ($status_user as $s) : ?>
                                            <option value="<?= $s['user_profil_kode'] ?>"><?= $s['jenis_user'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group" id="prodi-extend">
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif" class="col-form-label">Status Aktif</label>
                                    <select required class="form-control" id="status_aktif" name="status_aktif" placeholder="status_aktif">
                                        <option value="0" disabled selected hidden>Pilih Status Aktif</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>

                                <div class="form-group" id="jenis-lembaga-extend">

                                </div>
                                <div class="form-group" id="ketua-lembaga-extend">

                                </div>
                                <div class="form-group" id="hp-lembaga-extend">

                                </div>

                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>