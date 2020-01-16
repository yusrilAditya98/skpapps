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

        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;
            font-size: 12px
        }

        p {
            font-size: 12px
        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }

        .k-1,
        .k-2 {
            margin-top: 4rem
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
                                    <h6>REKAPITULASI PENGAJUAN <span></span> TA <span></span></h6>
                                </div>
                                <div class="col-12">
                                    <h6>FAKULTAS EKONOMI DAN BISNIS UNIVERSITAS BRAWIJAYA</h6>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6>SUB UNIT</h6>
                                </div>
                                <div class="col-6">: Kemahasiswaan</div>
                                <div class="col-6">
                                    <h6>WAKTU PELAKSANAAN</h6>
                                </div>
                                <div class="col-6">: </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">
                                <table class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="align-middle" scope="col" rowspan="2"><span>NO</span></th>
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
                                                <td class="text-center font-cetak"><?= $index++ ?></td>
                                                <td><?= date("d-m-Y", strtotime($k['tanggal_kegiatan']))  ?></td>
                                                <td><?= $k['nama_kegiatan'] ?></td>
                                                <td><?= $k['deskripsi_kegiatan'] ?></td>
                                                <td>Rp.<?= number_format($k['dana_kegiatan'], 0, ',', '.') ?> ,-</td>
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
                                    <p style="margin-bottom: 0.1rem;">Mengetahui,</p>
                                    <p><?= $pimpinan[3]['jabatan'] ?></p>
                                    <p style="margin-bottom: 0.1rem;" class="k-1"><?= $pimpinan[3]['nama'] ?></p>
                                    <p>NIP. <?= $pimpinan[3]['nip'] ?></p>
                                </div>
                                <div class="col-2" style="margin-left: 20%;">
                                    <p style="margin-bottom: 0.1rem;">Malang, <?= date('d-m-Y') ?></p>
                                    <p><?= $pimpinan[4]['jabatan'] ?></p>
                                    <p style="margin-bottom: 0.1rem;" class="k-2"><?= $pimpinan[4]['nama'] ?></p>
                                    <p>NIP. <?= $pimpinan[4]['nip'] ?></p>
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