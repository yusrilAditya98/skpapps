<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profil Lembaga</h4>
                    </div>
                    <div class="card-body">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="<?= base_url('assets/img/avatar/avatar-2.png') ?>" class=" profile-widget-picture">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Jenis Lembaga</div>
                                        <div class="profile-widget-item-value"><?= $lembaga['jenis_lembaga'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-description text-left">
                                <div class="profile-widget-name"><?= $lembaga['nama_lembaga'] ?><div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> <span>ID : <?= $lembaga['id_lembaga'] ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <i class="fas fa-user-alt"></i> Nama Ketua
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $lembaga['nama_ketua'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-user-friends"></i> Jumlah Anggota
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $lembaga['jumlah_anggota'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-phone"></i> Telfon
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $lembaga['no_hp_lembaga'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-key"></i> Status
                                    </div>
                                    <div class="col-lg-9">
                                        <?php if ($user['is_active'] == 1) : ?>
                                            <span class="badge badge-primary"> Aktif</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger"> Tidak Aktif</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <button href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit-profil" aria-hidden="true"><i class="fas fa-edit"></i> Edit Profil</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- modal edit profil lembaga -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit-profil">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profil Lembaga</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form action="<?= base_url('Kegiatan/editProfil/') . $lembaga['id_lembaga'] ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_lembaga" class="col-form-label">Jenis Lembaga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-rocket"></i>
                                </div>

                            </div>
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
                    </div>
                    <div class="form-group">
                        <label for="ketua_lembaga" class="col-form-label">Ketua Lembaga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-user-alt"></i>
                                </div>
                            </div>
                            <?php if ($lembaga['nama_ketua']) : ?>
                                <input class="form-control" name="ketua_lembaga" id="ketua_lembaga" value="<?= $lembaga['nama_ketua'] ?>" required></input>
                            <?php else : ?>
                                <input class="form-control" name="ketua_lembaga" id="ketua_lembaga" required></input>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ketua_lembaga" class="col-form-label">Jumlah Anggota</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                            </div>
                            <input type="number" class="form-control" name="jumlah_anggota" id="jumlah_anggota" value="<?= $lembaga['jumlah_anggota'] ?>" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_hp" class="col-form-label">No Hp</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <input type="num" class="form-control" name="no_hp" id="no_hp" value="<?= $lembaga['no_hp_lembaga'] ?>" required></input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke"> <button type="submit" class="btn btn-primary btn-shadow" id="">Submit</button></div>
            </form>
        </div>
    </div>
</div>
<!-- akhir modal edit profil lembaga -->