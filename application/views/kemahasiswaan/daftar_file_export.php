<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengaturan File Download</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar File Export</h4>
                    </div>
                    <div class="card-body">
                        <h5>Rancangan Kegiatan</h5>
                        <form class="m-t-20" action="<?= base_url('Export/exportRancanganKegiatan') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-12 input-group mb-3">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option value="" selected="">Pilih tahun</option>
                                        <?php foreach ($filter as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <h5>Proposal Kegiatan</h5>
                        <form class="m-t-20" action="<?= base_url('Export/exportProposalKegiatan') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-12 input-group mb-3">
                                    <select class="custom-select" id="kategori" name="kategori">
                                        <option selected value="null">Semua Kategori</option>
                                        <option value="mhs">Non Lembaga</option>
                                        <option value="lbg">Lembaga</option>

                                    </select>
                                    <select class="custom-select" id="tahun" name="tahun">
                                        <option value="kosong">Semua Periode</option>
                                        <?php foreach ($filter as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <h5>LPJ Kegiatan</h5>
                        <form class="m-t-20" action="<?= base_url('Export/exportLpjKegiatan') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-12 input-group mb-3">
                                    <select class="custom-select" id="kategori" name="kategori">
                                        <option selected value="null">Semua Kategori</option>
                                        <option value="mhs">Non Lembaga</option>
                                        <option value="lbg">Lembaga</option>

                                    </select>
                                    <select class="custom-select" id="tahun" name="tahun">
                                        <option value="kosong">Semua Periode</option>
                                        <?php foreach ($filter as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <h5>Poin SKP</h5>
                        <form class=" m-t-20" action="<?= base_url('Export/exportPoinSkp') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-12 input-group mb-3  ">
                                    <input type="date" name="tgl_pengajuan_start" id="tgl_pengajuan_start" class="form-control">
                                    <input type="date" name="tgl_pengajuan_end" id="tgl_pengajuan_date" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <h5>Beasiswa</h5>
                        <a href="<?= base_url('Kemahasiswaan/exportBeasiswa') ?>" class="btn btn-success"><i class="fas fa-file-excel mr-2 "></i>Export to excel</a>

                        <h5 class="mt-3">Serapan Keuangan</h5>
                        <form action="<?= base_url('Export/laporanSerapan') ?>" method="post">
                            <div class="form-group ">
                                <div class="input-group">
                                    <select class="custom-select" name="tahun">
                                        <option selected value="<?= $filter[0]['tahun_pengajuan'] ?>">Pilih tahun</option>
                                        <?php foreach ($filter as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h5 class="mt-3">Rekapitulasi Prestasi</h5>
                        <form action="<?= base_url('Export/exportRekapitulasiSKP') ?>" method="get">
                            <div class="row">
                                <div class="col-lg-12 input-group mb-3  ">
                                    <input name="start_date" type="date" class="form-control">
                                    <input name="end_date" type="date" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h5 class="mt-3">Rekapitulasi Tingkatan</h5>
                        <form action="<?= base_url('Export/exportRekapitulasiTingkatan') ?>" method="get">
                            <div class="form-group ">
                                <div class="input-group">
                                    <select name="tahun" class="custom-select" id="inputGroupSelect04">
                                        <option selected value="<?= $filter[0]['tahun_pengajuan'] ?>">Pilih tahun</option>
                                        <?php foreach ($filter as $t) : ?>
                                            <option value="<?= $t['tahun_pengajuan'] ?>"><?= $t['tahun_pengajuan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"><i class="fas fa-file-excel mr-2"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>