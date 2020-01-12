<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Poin SKP Mahasiswa</h1>
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
                        <h4>Daftar Poin SKP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Total Poin SKP</th>
                                        <th>Predikat Perolehan SKP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($mahasiswa as $m) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $m['nama'] ?></td>
                                            <td><?= $m['total_poin_skp'] ?></td>
                                            <td>
                                                <?php
                                                    if ($m['p_poin_skp'] == 1 || $m['p_poin_skp'] == 2 || $m['p_poin_skp'] == 3 || $m['p_poin_skp'] == 4) {
                                                        echo '<p class="text-success">' . $m['predikat_poin_skp'] . '</p>';
                                                    } else {
                                                        echo '<p class="text-danger">' . $m['predikat_poin_skp'] . '</p>';
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary detail-SKP" data-toggle="modal" data-target=".modalDetailSKP" data-id="<?= $m['nim'] ?>">Detail</button>
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

<!-- Awal Modal Detail Profil -->
<div class="modal fade bd-example-modal-lg modalDetailSKP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title clr-white ml-4" id="exampleModalLabel">Detail Poin SKP</span></h5>
                <button type="button" class="close clr-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h6 class="card-title nama_mahasiswa"></h6>
                                <h6 class="card-title nim_mahasiswa"></h6>
                                <h6 class="card-title prodi_mahasiswa"></h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Prestasi</th>
                                                <th>Tingkatan</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Bidang</th>
                                                <th>Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-skp">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modeal Detail Profil -->