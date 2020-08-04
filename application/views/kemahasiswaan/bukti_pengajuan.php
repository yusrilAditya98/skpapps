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
<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
} ?>

<body>

    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="font-weight-bold text-uppercase invisible">
                            <h5>
                                kementrian pendidikan dan kebudayaan <br>
                                <span class="h3">universitas brawijaya</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-3" style="float:right">
                        <div class="font-weight-bold text-capitalize invisible">

                            ................................................... <br>
                            Bukti Kas No : <br>
                            Tahun Anggaran : <?= $kegiatan['periode'] ?><br>
                        </div>
                    </div>
                </div>
                <form class="mt-3">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label invisible">Sudah Terima Dari</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="PEJABAT PEMBUAT KOMITMEN FAKULTAS EKONOMI DAN BISNIS - UNIVERSITAS BRAWIJAYA">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label invisible">Banyaknya
                            Uang</label>
                        <div class="col-sm-4 text-uppercase">
                            <input type="text" readonly class="form-control-plaintext text-uppercase" id="staticEmail" value="<?= terbilang($kegiatan['dana'])  ?> rupiah">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label invisible">
                            Untuk Pembayaran</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="inputPassword" value="<?= $kegiatan['nama_kegiatan'] ?>" placeholder="Untuk Pembayaran">
                        </div>
                    </div>
                </form>

                <div class="row mt-5">
                    <div class="col-3 invisible">
                        <div class="header-ttd">
                            Mengetahui / Menyetujui, <br>
                            <?= $pimpinan[0]['jabatan'] ?>
                        </div>
                        <div class="field-ttd" style="margin-top: 5rem">
                            <?= $pimpinan[0]['nama'] ?> <br>
                            NIP. <?= $pimpinan[0]['nip'] ?>
                        </div>
                    </div>
                    <div class="col-3 invisible">
                        <div class="header-ttd">
                            Mengetahui <br>
                            <?= $pimpinan[1]['jabatan'] ?>
                        </div>
                        <div class="field-ttd" style="margin-top: 5rem">
                            <?= $pimpinan[1]['nama'] ?> <br>
                            NIP. <?= $pimpinan[1]['nip'] ?>
                        </div>
                    </div>
                    <div class="col-4 invisible">
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
                        <span class="d-none">Malang, </span><br>
                        <span class="d-none">Nama : </span><?= $kegiatan['nama_penanggung_jawab'] ?> <br>
                        <span class="d-none">Alamat :</span>
                    </div>
                    <div class="col-12">
                        <h3>Rp.<?= number_format($kegiatan['dana'], 2, ',', '.')  ?></h3>
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