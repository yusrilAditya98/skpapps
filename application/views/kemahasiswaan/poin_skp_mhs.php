<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Validasi Pengajuan Lpj Kegiatan</h1>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Prodi</th>
                                        <th>Poin SKP</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1;
                                    foreach ($mahasiswa as $m) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $m['nim'] ?></td>
                                            <td><?= $m['nim'] ?></td>
                                            <td><?= $m['nama_jurusan'] ?></td>
                                            <td><?= $m['nama_prodi'] ?></td>
                                            <td>
                                                <?= $m['total_poin_skp'] ?>
                                            </td>
                                            <td>
                                                <?php if ($m['total_poin_skp'] >= 100 && $m['total_poin_skp'] <= 150) : ?>
                                                    <span>Cukup</span>
                                                <?php elseif ($m['total_poin_skp'] >= 151 && $m['total_poin_skp'] <= 200) : ?>
                                                    <span>Baik</span>
                                                <?php elseif ($m['total_poin_skp'] >= 201 && $m['total_poin_skp'] <= 300) : ?>
                                                    <span>Sangat Baik</span>
                                                <?php elseif ($m['total_poin_skp'] > 300) : ?>
                                                    <span>Dengan Pujian</span>
                                                <?php else : ?>
                                                    <span>Kurang</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>