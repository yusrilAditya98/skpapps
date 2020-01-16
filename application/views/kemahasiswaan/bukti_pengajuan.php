<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css" media="print">
        @page {
            size: landscape;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="font-weight-bold text-uppercase">
                            <h5>
                                kementerian riset, teknologi dan pendidikan tinggi <br>
                                <span class="h3">universitas brawijaya</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-3" style="float:right">
                        <div class="font-weight-bold text-capitalize">

                            ................................................... <br>
                            Bukti Kas No : <br>
                            Tahun Anggaran : <?= $kegiatan['periode'] ?><br>
                        </div>
                    </div>
                </div>
                <form class="mt-3">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Sudah Terima Dari</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="PEJABAT PEMBUAT KOMITMEN FAKULTAS EKONOMI DAN BISNIS - UNIVERSITAS BRAWIJAYA">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Banyaknya
                            Uang</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputPassword" placeholder="Rp.<?= number_format($kegiatan['dana'], 2, ',', '.')  ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">
                            Untuk Pembayaran</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="inputPassword" value="<?= $kegiatan['nama_kegiatan'] ?>" placeholder="Untuk Pembayaran">
                        </div>
                    </div>
                </form>

                <div class="row mt-5">
                    <div class="col-3">
                        <div class="header-ttd">
                            Mengetahui / Menyetujui, <br>
                            <?= $pimpinan[0]['jabatan'] ?>
                        </div>
                        <div class="field-ttd" style="margin-top: 5rem">
                            <?= $pimpinan[0]['nama'] ?> <br>
                            NIP. <?= $pimpinan[0]['nip'] ?>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="header-ttd">
                            Mengetahui <br>
                            <?= $pimpinan[1]['jabatan'] ?>
                        </div>
                        <div class="field-ttd" style="margin-top: 5rem">
                            <?= $pimpinan[1]['nama'] ?> <br>
                            NIP. <?= $pimpinan[1]['nip'] ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="header-ttd">
                            Lunas dibayar <br> Tanggal: <br>
                            <p> <?= $pimpinan[2]['jabatan'] ?></p>
                        </div>
                        <div class="field-ttd" style="margin-top: 3.5rem">
                            <?= $pimpinan[2]['nama'] ?> <br>
                            NIP. <?= $pimpinan[2]['nip'] ?>
                        </div>
                    </div>
                    <div class="col-2">
                        Malang, <br>
                        Nama : <?= $kegiatan['nama_penanggung_jawab'] ?> <br>
                        Alamat :
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    window.print();
</script>


</html>