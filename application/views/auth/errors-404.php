<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>404 &mdash; SKP</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>404</h1>
            <div class="page-description">
              The page you were looking for could not be found.
            </div>
            <div class="page-search">

              <div class="mt-3">
                <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                  <a href="<?= base_url("Mahasiswa") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 2 || $this->session->userdata('user_profil_kode') == 3) : ?>
                  <a href="<?= base_url("Kegiatan") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 4) : ?>
                  <a href="<?= base_url("Kemahasiswaan") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 5) : ?>
                  <a href="<?= base_url("Pimpinan") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 6) : ?>
                  <a href="<?= base_url("Publikasi") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 7) : ?>
                  <a href="<?= base_url("Keuangan") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 8) : ?>
                  <a href="<?= base_url("Akademik") ?>">Back to Dasboard</a>
                <?php elseif ($this->session->userdata('user_profil_kode') == 9) : ?>
                  <a href="<?= base_url("Admin") ?>">Back to Dasboard</a>
                <?php else : ?>
                  <a href="<?= base_url("Auth") ?>">Back to Dasboard</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
          Copyright &copy; 2019 by Kemahasiswaan FEB UB
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

  <!-- Page Specific JS File -->
</body>

</html>