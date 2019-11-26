<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2019 <div class="bullet"></div> Kemahasiswaan FEB UB
    </div>
    <div class="footer-right">
        2.3.0
    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url() ?>assets/modules/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/modules/select/select2.full.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/modules/ionicons/modules-ion-icons.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url() ?>assets/js/page/modules-datatables.js"></script>

<!-- Template JS File -->
<script src="<?= base_url() ?>assets/js/scripts.js"></script>
<script src="<?= base_url() ?>assets/js/custom.js"></script>
<script src="<?= base_url() ?>assets/js/kegiatan.js"></script>
<script src="<?= base_url() ?>assets/js/kategori.js"></script>
<script src="<?= base_url() ?>assets/js/skp.js"></script>

<?php if ($this->session->userdata('user_profil_kode') == 1) : ?>
    <script src="<?= base_url() ?>assets/js/mahasiswa/mahasiswa.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 2 || $this->session->userdata('user_profil_kode') == 3) : ?>
    <script src="<?= base_url() ?>assets/js/lembaga/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 4) : ?>
    <script src="<?= base_url() ?>assets/js/kemahasiswaan/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 5) : ?>
    <script src="<?= base_url() ?>assets/js/pimpinana/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 6) : ?>
    <script src="<?= base_url() ?>assets/js/keuangan/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 7) : ?>
    <script src="<?= base_url() ?>assets/js/psik/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 8) : ?>
    <script src="<?= base_url() ?>assets/js/akademik/script.js"></script>
<?php elseif ($this->session->userdata('user_profil_kode') == 9) : ?>
    <script src="<?= base_url() ?>assets/js/admin/script.js"></script>
<?php endif; ?>

<!-- Sweet alert custom -->
<script src="<?= base_url('assets/') ?>js/sweet-alert.js"></script>

</body>

</html>