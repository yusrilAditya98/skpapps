<!-- QUERY MENU -->

<?php
$role_id = $this->session->userdata('user_profil_kode');
$queryMenu = "SELECT `user_menu`.`id`, `menu`
                FROM `user_menu` JOIN `user_access_menu`
                ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                WHERE `user_access_menu`.`user_profil_kode` = $role_id
                ORDER BY `user_access_menu`.`menu_id` ASC
                ";
$menu = $this->db->query($queryMenu)->result_array();

$menuId = [];
$temp = [];
$i = 0;
foreach ($menu as $m) {
    $menuId[$i++] = $m['id'];
}

$j = 0;
foreach ($menuId as $m) {
    $querySubMenu = "SELECT user_sub_menu.* FROM `user_sub_menu` JOIN `user_menu` 
                                ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                            WHERE `user_sub_menu`.`menu_id`= $m
                            ";
    $temp[$j++] = $this->db->query($querySubMenu)->result_array();
}
$k = 0;
foreach ($temp as $t) {
    foreach ($t as $ts) {
        $subMenu[$k++] = $ts;
    }
}



$querySubSubMenu = "SELECT * FROM `user_sub_sub_menu` 
";

$subSubMenu = $this->db->query($querySubSubMenu)->result_array();

?>

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="<?= base_url('assets/img/skpapps.png') ?>" alt="" width="200dp" class="mt-2"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SKP</a>
        </div>
        <ul class="sidebar-menu">
            <?php foreach ($menu as $m) : ?>
                <li class="menu-header mt-2"><?= $m['menu'] ?></li>
                <?php foreach ($subMenu as $sb) : ?>
                    <?php if ($sb['menu_id'] == $m['id']) : ?>
                        <?php if ($title == $sb['judul']) : ?>
                            <li class="nav-item active dropdown">
                            <?php else : ?>
                            <li class="nav-item dropdown">
                            <?php endif; ?>

                            <?php if ($sb['has_sub'] == 1) : ?>
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="<?= $sb['ikon'] ?>"></i><span><?= $sb['judul']  ?></span></a>
                            <?php else : ?>
                                <a href="<?= base_url() . $sb['url'] ?>" class="nav-link "><i class="<?= $sb['ikon'] ?>"></i><span><?= $sb['judul']  ?></span></a>
                            <?php endif; ?>


                            <ul class="dropdown-menu">
                                <?php foreach ($subSubMenu as $ssb) : ?>
                                    <?php if ($ssb['id_sub_menu'] == $sb['id']) : ?>
                                        <li>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <a class="nav-link" href="<?= base_url() . $ssb['url'] ?>">
                                                        <?= $ssb['nama'] ?>
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 float-right">
                                                    <!-- notif rancangan -->
                                                    <?php if ($ssb['id_sub_sub_menu'] == 8 && $notif['notif_kmhs_rancangan'] != 0) : ?>
                                                        <span class="badge badge-warning"><?= $notif['notif_kmhs_rancangan'] ?></span>
                                                    <?php endif; ?>
                                                    <!-- notif proposal -->
                                                    <?php if ($ssb['id_sub_sub_menu'] == 9 && $notif['notif_kmhs_proposal'] != 0) : ?>
                                                        <span class="badge badge-warning"><?= $notif['notif_kmhs_proposal'] ?></span>
                                                    <?php endif; ?>
                                                    <!-- notif lpj -->
                                                    <?php if ($ssb['id_sub_sub_menu'] == 10 && $notif['notif_kmhs_lpj'] != 0) : ?>
                                                        <span class="badge badge-warning"><?= $notif['notif_kmhs_lpj'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                    <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                        <i class="fas fa-rocket"></i> Documentation
                    </a>
                </div>
    </aside>
</div>