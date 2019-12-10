<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard &mdash; SKPAPPS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css" media="screen"></style>

    <style type="text/css" media="print">
        /* @page {size:landscape}  */
        @page {
            size: A4 landscape;
        }

        .main-content {
            position: relative;
            top: 20px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-body text-uppercase">
                            <div class="row">
                                <div class="col-12">
                                    <h5>REKAPITULASI PENGAJUAN <span></span> TA <span></span></h5>
                                </div>
                                <div class="col-12">
                                    <h5>FAKULTAS EKONOMI DAN BISNIS UNIVERSITAS BRAWIJAYA</h5>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h5>SUB UNIT</h5>
                                </div>
                                <div class="col-6">: cek</div>
                                <div class="col-6">
                                    <h5>WAKTU PELAKSANAAN</h5>
                                </div>
                                <div class="col-6">: cek</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="align-middle" scope="col" rowspan="2">NO</th>
                                            <th class="align-middle" scope="col" rowspan="2">TANGGAL KEGIATAN</th>
                                            <th class="align-middle" scope="col" rowspan="2">NAMA KEGIATAN</th>
                                            <th class="align-middle" scope="col" rowspan="2">KETERANGAN</th>
                                            <th class="align-middle" scope="col" rowspan="2">JUMLAH TERMASUK PAJAK</th>
                                            <th class="align-middle" scope="col" class="text-center" colspan="4">PAJAK</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" scope="col">PPN-DN</th>
                                            <th class="align-middle" scope="col">pph-21</th>
                                            <th class="align-middle" scope="col">pph-22</th>
                                            <th class="align-middle" scope="col">pph-23</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-left">
                                        <?php $index = 1; ?>
                                        <?php foreach ($kegiatan as $k) : ?>
                                            <tr>
                                                <td class="text-center"><?= $index++ ?></td>
                                                <td><?= $k['tanggal_kegiatan'] ?></td>
                                                <td><?= $k['nama_kegiatan'] ?></td>
                                                <td><?= $k['deskripsi_kegiatan'] ?></td>
                                                <td>Rp.<?= number_format($k['dana_kegiatan'], 2, ',', '.') ?> ,-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-4" style="margin-left: 20%;">
                                    <p>Mengetahui,</p>
                                    <p>Kasubag Administrasi Umum dan BMN</p>
                                    <p style="margin-top: 8rem">Suharto, SE</p>
                                    <p>NIP. -</p>
                                </div>
                                <div class="col-2" style="margin-left: 20%;">
                                    <p>Malang,</p>
                                    <p>Pelaksana,</p>
                                    <p style="margin-top: 8rem">Ninik Surwaningsih</p>
                                    <p>NIP. -</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-3">

            </div>
        </section>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>