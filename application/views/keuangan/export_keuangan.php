<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Laporan Serapan &mdash; SKPAPPS</title>
    <!-- General CSS Files -->
    <style type="text/css">
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

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>
</head>

<body>
    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Laporan_Serapan.xls");
    ?>
    <div id="app">
        <div class="main-wrapper">
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <table class=" text-center table table-striped table-bordered" id="table-2">
                        <thead>
                            <tr>
                                <th class="align-middle" rowspan="2">No</th>
                                <th class="align-middle" rowspan="2">Nama Lembaga</th>
                                <th colspan="12">Bulan</th>
                                <th class="align-middle" rowspan="2">Dana Pagu</th>
                                <th colspan="2">Jumlah Terserap</th>
                                <th colspan="2">Sisa</th>
                            </tr>
                            <tr>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>Mei</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Agu</th>
                                <th>Sep</th>
                                <th>Okt</th>
                                <th>Nov</th>
                                <th>Des</th>
                                <th>Rp</th>
                                <th>%</th>
                                <th>Rp</th>
                                <th>%</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            <?php foreach ($laporan as $l) : ?>

                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= $l['nama_lembaga'] ?></td>
                                    <?php for ($i = 1; $i < 13; $i++) : ?>
                                        <td class="text-left"><?= number_format($l[$i], 2, ',', '.'); ?></td>
                                    <?php endfor; ?>
                                    <td><?= number_format($l['dana_pagu'], 2, ',', '.');
                                            ?></td>
                                    <td><?= number_format($l['dana_terserap'], 2, ',', '.');  ?></td>
                                    <td><?= round($l['terserap_persen'], 2) ?></td>
                                    <td><?= number_format($l['dana_sisa'], 2, ',', '.');  ?></td>
                                    <td><?= round($l['sisa_terserap'], 2) ?></td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14">Total</td>
                                <td><?= number_format($total['total']['dana_pagu'], 2, ',', '.');  ?></td>
                                <td><?= number_format($total['total']['dana_terserap'], 2, ',', '.');  ?></td>
                                <td><?= round($total['total']['persen_terserap'], 2) ?></td>
                                <td><?= number_format($total['total']['dana_sisa'], 2, ',', '.'); ?></td>
                                <td><?= round($total['total']['persen_sisa'], 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </section>
            </div>
        </div>
    </div>
</body>

</html>