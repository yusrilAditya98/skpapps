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
                        <h4>Profil Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="<?= base_url('assets/img/avatar/avatar-1.png') ?>" class=" profile-widget-picture">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Jurusan</div>
                                        <div class="profile-widget-item-value"><?= $mahasiswa[0]['nama_jurusan'] ?></div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Prodi</div>
                                        <div class="profile-widget-item-value"><?= $mahasiswa[0]['nama_prodi'] ?></div>
                                    </div>

                                </div>
                            </div>
                            <div class="profile-widget-description text-left">
                                <div class="profile-widget-name"><?= $mahasiswa[0]['nama'] ?><div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> <span>NIM : <?= $mahasiswa[0]['nim'] ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <i class="fas fa-at"></i> Email
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $mahasiswa[0]['email'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-map-marker-alt"></i> Alamat Rumah
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $mahasiswa[0]['alamat_rumah'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-home"></i> Alamat Saat ini
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $mahasiswa[0]['alamat_kos'] ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <i class="fas fa-phone"></i> Telfon
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $mahasiswa[0]['nomor_hp'] ?>
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