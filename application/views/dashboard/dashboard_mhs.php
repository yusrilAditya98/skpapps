<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4>Riwayat Poin SKP</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              <?php foreach ($poinskp as $p) : ?>
                <li class="media">
                  <img class="mr-3" src=" <?= base_url() ?>/assets/img/medal.png" style="width: 40px" class="rounded-circle profile-widget-picture" alt=" Generic placeholder image">
                  <div class="media-body">
                    <h5 class="mt-0 mb-1"><?= $p['nama_kegiatan']; ?> -
                      <?php if ($p['validasi_prestasi'] == 0) : ?>
                        <div class="badge badge-primary">Proses</div>
                      <?php elseif ($p['validasi_prestasi'] == 1) : ?>
                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                      <?php elseif ($p['validasi_prestasi'] == 2) : ?>
                        <div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi" data-id="<?= $p['id_poin_skp'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                      <?php endif; ?>
                    </h5>
                    <p>Kegiatan <?= $p['nama_kegiatan']; ?> dilaksanakan pada tanggal <?= $p['tgl_pelaksanaan'] ?> yang bertempat di <?= $p['tempat_pelaksanaan'] ?></p>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
            <a class="float-right" href="<?= base_url('Mahasiswa/poinSkp') ?>">Lihat Selengkapnya</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Poin Satuan Kredit Prestasi</h4>
          </div>
          <div class="card-body text-center mb-2" style="margin-top:-1rem;">
            Jumlah poin skp yang anda peroleh
            <h1 class="display-3 mb-4" style="color: black;"><?= $mahasiswa[0]['total_poin_skp'] ?><span style="font-size: 1rem; margin-left: 0.5rem;">points</span>
            </h1>
            Kategori poin skp:
            <?php if ($mahasiswa[0]['total_poin_skp'] >= 100 && $mahasiswa[0]['total_poin_skp'] <= 150) : ?>
              <span class="badge badge-warning"> Cukup</span>
            <?php elseif ($mahasiswa[0]['total_poin_skp'] >= 151 && $mahasiswa[0]['total_poin_skp'] <= 200) : ?>
              <span class="badge badge-primary">Baik</span>
            <?php elseif ($mahasiswa[0]['total_poin_skp'] >= 201 && $mahasiswa[0]['total_poin_skp'] <= 300) : ?>
              <span class="badge badge-success"> Sangat Baik</span>
            <?php elseif ($mahasiswa[0]['total_poin_skp'] > 300) : ?>
              <span class="badge badge-info"> Dengan Pujian</span>
            <?php else : ?>
              <span class="badge badge-danger"> Kurang</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>