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
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="list-group">
                                    <?php foreach ($file_download as $fd) : ?>
                                        <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                                            <?php if ($fd['dilihat_oleh'] == 'mahasiswa' || $fd['dilihat_oleh'] == 'semua') : ?>
                                                <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 2) : ?>
                                            <?php if ($fd['dilihat_oleh'] == 'lembaga' || $fd['dilihat_oleh'] == 'semua') : ?>
                                                <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 3) : ?>
                                            <?php if ($fd['dilihat_oleh'] == 'bem' || $fd['dilihat_oleh'] == 'semua') : ?>
                                                <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 5) : ?>
                                            <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 6) : ?>
                                            <?php if ($fd['dilihat_oleh'] == 'keuangan' || $fd['dilihat_oleh'] == 'semua') : ?>
                                                <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 7) : ?>
                                            <?php if ($fd['dilihat_oleh'] == 'psik' || $fd['dilihat_oleh'] == 'semua') : ?>
                                                <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($this->session->userdata('user_profil_kode') == 8) : ?>
                                            <a href="<?= base_url('file_bukti/file_download/' . $fd['dir_file']) ?>" class="list-group-item list-group-item-action">Download <?= $fd['nama_file'] ?></a>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>