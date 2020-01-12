<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
                            <img alt="image" src="<?= base_url() ?>/assets/img/avatar/avatar-4.png" class="rounded-circle mr-1">
                        <?php else : ?>
                            <img alt="image" src="<?= base_url() ?>/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                        <?php endif; ?>

                        <div class="d-sm-none d-lg-inline-block">Hi, <?= $this->session->userdata('nama') ?></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if ($this->session->userdata('user_profil_kode') == 1 || $this->session->userdata('user_profil_kode') == 2 || $this->session->userdata('user_profil_kode') == 3) : ?>
                            <a href="<?= base_url($this->uri->segment(1) . '/profil') ?>" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item has-icon text-danger logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                    </div>
                </li>
            </ul>
        </nav>