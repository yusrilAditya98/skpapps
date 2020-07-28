<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Export Beasiswa | &mdash; SKPAPPS</title>
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
    <!-- Main Content -->
    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data skp.xls");
    ?>
    <div class="main-content">
        <section class="section">
            <table class="table table-bordered" id="table-2">
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
                            <td><?= $m['nama'] ?></td>
                            <td><?= $m['nama_jurusan'] ?></td>
                            <td><?= $m['nama_prodi'] ?></td>
                            <td>
                                <?= $m['total_poin_skp'] ?>
                            </td>
                            <?php if ($m['total_poin_skp'] >= 100 && $m['total_poin_skp'] <= 150) : ?>
                                <td> Cukup</td>
                            <?php elseif ($m['total_poin_skp'] >= 151 && $m['total_poin_skp'] <= 200) : ?>
                                <td>Baik</td>
                            <?php elseif ($m['total_poin_skp'] >= 201 && $m['total_poin_skp'] <= 300) : ?>
                                <td> Sangat Baik</td>
                            <?php elseif ($m['total_poin_skp'] > 300) : ?>
                                <td> Dengan Pujian</td>
                            <?php else : ?>
                                <td> Kurang</td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
</body>

</html>