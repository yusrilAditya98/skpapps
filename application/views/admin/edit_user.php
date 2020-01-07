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
                        <form class="needs-validation" action="<?= base_url('admin/editUser/') . $user['username'] ?>" method="post" novalidate="">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?= $user['username']; ?>" required readonly>
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                    <div class="invalid-feedback">
                                        username harap diisikan !
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $user['nama']  ?>" required>
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
                                    <label class="col-form-label">Status User</label>

                                    <?php foreach ($status_user as $s) : ?>
                                        <?php if ($user['user_profil_kode'] == $s['user_profil_kode']) : ?>
                                            <input type="hidden" id="status_user" name="status_user" value="<?= $s['user_profil_kode'] ?>">
                                            <input type="text" value="<?= $s['jenis_user'] ?>" readonly class="form-control">
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Status Aktif</label>
                                    <select required class="form-control" id="status_aktif" name="status_aktif" placeholder="status_aktif">
                                        <?php if ($user['is_active'] == 1) : ?>
                                            <option value="1" selected>Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        <?php else : ?>
                                            <option value="1">Aktif</option>
                                            <option value="0" selected>Tidak Aktif</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php if ($user['user_profil_kode'] == 1) : ?>
                                    <div class="form-group">
                                        <label for="prodi" class="col-form-label">Prodi</label>
                                        <select class="form-control" id="prodi" name="prodi" placeholder="prodi">
                                            <?php foreach ($prodi as $p) : ?>
                                                <?php if ($mahasiswa['kode_prodi'] == $p['kode_prodi']) : ?>
                                                    <option value="<?= $p['kode_prodi'] ?>" selected><?= $p['nama_prodi'] ?></option>
                                                <?php endif; ?>
                                                <option value="<?= $p['kode_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_kos" class="col-form-label">Alamat Kosan</label>
                                        <input class="form-control" name="alamat_kos" id="alamat_kos" value="<?= $mahasiswa['alamat_kos'] ?>" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_rumah" class="col-form-label">Alamat Rumah</label>
                                        <input class="form-control" name="alamat_rumah" id="alamat_rumah" value="<?= $mahasiswa['alamat_rumah'] ?>" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input class="form-control" name="email" id="email" value="<?= $mahasiswa['email'] ?>" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp" class="col-form-label">No Hp</label>
                                        <input class="form-control" name="no_hp" id="no_hp" value="<?= $mahasiswa['nomor_hp'] ?>" required></input>
                                    </div>
                                <?php endif; ?>
                                <?php if ($user['user_profil_kode'] == 2 || $user['user_profil_kode'] == 3) : ?>
                                    <div class="form-group">
                                        <label for="jenis_lembaga" class="col-form-label">Jenis Lembaga</label>
                                        <select class="form-control" id="jenis_lembaga" name="jenis_lembaga" placeholder="Jenis Lembaga" required>
                                            <?php if ($lembaga['jenis_lembaga'] == "semi otonom") : ?>
                                                <option value="semi otonom" selected>semi otonom</option>
                                                <option value="otonom">otonom</option>
                                            <?php else : ?>
                                                <option value="semi otonom">semi otonom</option>
                                                <option value="otonom" selected>otonom</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ketua_lembaga" class="col-form-label">Ketua Lembaga</label>
                                        <?php if ($lembaga['nama_ketua']) : ?>
                                            <input class="form-control" name="ketua_lembaga" id="ketua_lembaga" value="<?= $lembaga['nama_ketua'] ?>" required></input>
                                        <?php else : ?>
                                            <input class="form-control" name="ketua_lembaga" id="ketua_lembaga" required></input>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp" class="col-form-label">No Hp</label>
                                        <input class="form-control" name="no_hp" id="no_hp" value="<?= $lembaga['no_hp_lembaga'] ?>" required></input>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                <a href="<?= base_url('Admin/ManagementUser') ?>" class="btn btn-secondary mr-2 float-right">Kembali</a>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>