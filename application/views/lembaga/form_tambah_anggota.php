<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penambahan Anggota</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Anggota</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-tambah-skp">
                                    <form action="<?= base_url('Kegiatan/tambahRancanganAnggota/') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="bagian-personality">
                                            <h5>Informasi Personality</h5>
                                            <div class="form-group">
                                                <label for="namaLembaga">Nama Lembaga</label>
                                                <input type="text" class="form-control" id="namaLembaga" name="namaLembaga" value="<?= $this->session->userdata('nama') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_lembaga">Id Lembaga</label>
                                                <input type="text" class="form-control" id="id_lembaga" name="id_lembaga" value="<?= $this->session->userdata('username') ?>" readonly>
                                                <input type="hidden" id="jenis_lembaga" name="jenis_lembaga" value="<?= $jenis_lembaga ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="periode">Periode</label>
                                                <input input type="text" class="form-control" id="periode" name="periode" value="<?= $tahun ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="buktiPengajuan">Bukti Pengajuan - <?php if ($pengajuan) : ?>
                                                        <a target="_blank" href="<?= base_url('file_bukti/sk_lembaga/' . $pengajuan['bukti_pengajuan']) ?>" class="btn btn-primary">Lihat</a>
                                                    <?php endif; ?>
                                                </label>
                                                <?php if ($pengajuan == null) { ?>
                                                    <input type="file" class="form-control" id="buktiPengajuan" name="buktiPengajuan" required>
                                                <?php } else { ?>
                                                    <input type="file" class="form-control" id="buktiPengajuan" name="buktiPengajuan">
                                                    <small class="text-danger">* Bukti pengajuan sudah ada</small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="bagian-acara mt-5">
                                            <h5>Anggota Lembaga</h5>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group row mb-4">
                                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Anggota</label>
                                                        <div class="col-lg-2">
                                                            <input type="number" class="form-control jumlahAnggota" name="jumlahAnggota" id="jumlahAnggota" value="<?= count($anggota) ?>" readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <a class="btn btn-icon btn-primary mb-3 text-white daftarMahasiswaLembaga" style="float:right" data-toggle="modal" data-target="#daftarMahasiswaLembaga">
                                                        Pilih Anggota <i class="fas fa-plus pl-2 text-white"></i></a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="rancanganTambahAnggota">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nim</th>
                                                            <th>Nama</th>
                                                            <th>Prodi</th>
                                                            <th>Jurusan</th>
                                                            <th>Posisi</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="daftar-mhs">
                                                        <?php $i = 1;
                                                        foreach ($anggota as $a) : ?>
                                                            <tr class="d-m" id="data-<?= $a['nim'] ?>">
                                                                <td class="nomorid-data-<?= $a['nim'] ?>"><?= ($i++) ?></td>
                                                                <td><?= $a['nim'] ?>
                                                                    <input type="hidden" name="nim_<?= $a['nim'] ?>" value="<?= $a['nim'] ?>" id="nim_<?= $a['nim'] ?>">
                                                                </td>
                                                                <td><?= $a['nama'] ?></td>
                                                                <td><?= $a['nama_jurusan'] ?></td>
                                                                <td><?= $a['nama_prodi'] ?></td>
                                                                <td><?= $a['nama_prestasi'] ?>
                                                                    <input type="hidden" name="prestasi_<?= $a['nim'] ?>" value="<?= $a['id_sm_prestasi'] ?>" id="nim_<?= $a['nim'] ?>">
                                                                </td>
                                                                <td> <button onclick="hpsAnggotaLembaga(<?= $a['nim'] ?>)" type="button" data-id="<?= $a['nim'] ?>" class="btn btn-danger hps-mhs-1"><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="action-button">
                                            <button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
                                                Ajukan Rancangan Anggota <i class="fas fa-plus"></i></button>

                                            <a href="<?= base_url('Kegiatan/rancanganAnggota?tahun=' . $tahun) ?>" style="float:right" class="btn btn-icon btn-secondary">
                                                Kembali <i class="fas fa-arrow-left"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal daftar mahasiswa - Anggota Lembaga -->
<div class="modal fade" tabindex="-1" role="dialog" id="daftarMahasiswaLembaga">
    <div class="modal-dialog modal-xl" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Mahasiswa FEB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table-mhs">
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit-mhs-anggota" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>