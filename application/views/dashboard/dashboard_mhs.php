<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Data Diri Mahasiswa</h4>
          </div>
          <div class="card-body text-center mb-2" style="margin-top:-1rem;">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="http://siakad.ub.ac.id/siam/biodata.fotobynim.php?nim=<?= $this->session->userdata('username') ?>&key=MzIxZm90b3V5ZTEyMysyMDE5LTEyLTAyIDEzOjA4OjI4" class=" profile-widget-picture">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Jumlah Kegiatan</div>
                    <div class="profile-widget-item-value"><?= count($poinskp) ?></div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Followers</div>
                    <div class="profile-widget-item-value">6,8K</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Following</div>
                    <div class="profile-widget-item-value">2,1K</div>
                  </div>
                </div>
              </div>
              <div class="profile-widget-description text-left">
                <div class="profile-widget-name"><?= $mahasiswa[0]['nama'] ?><div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div> <?= $mahasiswa[0]['nim'] ?>
                  </div>
                </div>
                Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Poin Satuan Kredit Prestasi</h4>
          </div>
          <div class="card-body text-center mb-2" style="margin-top:-1rem;">
            <h1 class="display-3 mb-4" style="color: black;"><?= $mahasiswa[0]['total_poin_skp'] ?><span style="font-size: 1rem; margin-left: -1rem;">points</span>
            </h1>
            <a href="#" class="btn btn-icon btn-success" style="width:100%">
              Tambah Point SKP <i class="fas fa-plus pl-2"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-12">
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
            <a class="float-right" href="">Lihat Selengkapnya</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>