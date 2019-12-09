<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="kop-surat mt-2 pb-2" style="border-bottom: 3px solid black;">
        <div class="row">
            <div class="col-3">
                <div id="logo-ub"><img src="https://kadowisudaku.com/wp-content/uploads/2016/11/Logo-Universitas-Brawijaya-UB.jpg" alt="logo ub" style="width: 150px;"></div>
            </div>
            <div class="col-6 text-center">
                <span class="h5 font-weight-normal">KEMENTERIAN RISET,TEKNOLOGI, DAN PENDIDIKAN TINGGI</span> <br>
                <span class="h5 font-weight-normal">UNIVERSITAS BRAWIJAYA</span> <br>
                <span class="font-weight-bold">FAKULTAS ILMU EKONOMI DAN BISNIS</span> <br>
                <!-- yang ini nanti disesuaikan dengan fakultas ekonomi nya -->
                <span class="p" style="font-size: 14px;">
                    Jl. Veteran No.8, Malang, 65145, Indonesia
                    <br> Telp.: +62-341-577911; Fax : +62-341577911
                    <br> http://feb.ub.ac.id E-mail : feb@ub.ac.id
                </span>
            </div>
        </div>
    </div>
    <div class="judul text-center mt-3">
        <h5>DRAFT TRANSKRIP NON AKADEMIK</h5>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <form action="">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">Nama</label>
                    <div class="col-sm-1 col-form-label">:</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $mahasiswa[0]['nama'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">NIM</label>
                    <div class="col-sm-1 col-form-label">:</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $mahasiswa[0]['nim'] ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <form action="" style="margin-left: 15em;">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Program Studi :</label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $mahasiswa[0]['nama_prodi'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Jurusan :</label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $mahasiswa[0]['nama_jurusan'] ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <?php foreach ($bidang as $b) :  ?>
            <div class="organisasi col-lg-12">
                <h5>Bidang <span><?= $b['nama_bidang'] ?></span></h5>
                <div class="table-responsive-sm">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Tanggal Pelaksanaan</th>
                                <th scope="col">Tingkat</th>
                                <th scope="col">Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            <?php foreach ($poinskp as $p) : ?>
                                <?php if ($p['validasi_prestasi'] == 1) : ?>
                                    <?php if ($p['id_bidang'] == $b['id_bidang']) : ?>
                                        <tr>
                                            <td><?= $index++; ?></td>
                                            <td><?= $p['nama_kegiatan'] ?></td>
                                            <td><?= $p['nama_prestasi'] ?></td>
                                            <td><?= $p['tgl_pelaksanaan'] ?></td>
                                            <td><?= $p['nama_tingkatan'] ?></td>
                                            <td><?= $p['bobot'] ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="row mt-3">
        <div class="col-4">
            <form action="">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Total Poin: </label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $mahasiswa[0]['total_poin_skp'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Predikat :

                    </label>
                    <div class="col-sm-8">
                        <?php if ($mahasiswa[0]['total_poin_skp'] >= 100 && $mahasiswa[0]['total_poin_skp'] <= 150) : ?>
                            Cukup
                        <?php elseif ($mahasiswa[0]['total_poin_skp'] >= 151 && $mahasiswa[0]['total_poin_skp'] <= 200) : ?>
                            Baik
                        <?php elseif ($mahasiswa[0]['total_poin_skp'] >= 201 && $mahasiswa[0]['total_poin_skp'] <= 300) : ?>
                            Sangat Baik
                        <?php elseif ($mahasiswa[0]['total_poin_skp'] > 300) : ?>
                            Dengan Pujian
                        <?php else : ?>
                            Kurang
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-4 mt-5">
            <img style="width: 100px;" src="http://siakad.ub.ac.id/siam/biodata.fotobynim.php?nim=<?= $this->session->userdata('username') ?>&key=MzIxZm90b3V5ZTEyMysyMDE5LTEyLTAyIDEzOjA4OjI4" class=" profile-widget-picture">
        </div>
        <div class="col-4">
            <?= date('d M Y') ?> <br>
            Mahasiswa,<br>
            <p style="margin-top:100px;"><?= $mahasiswa[0]['nama'] ?> <br> NIM. <?= $mahasiswa[0]['nim'] ?></p>
        </div>
    </div>
</body>

</html>