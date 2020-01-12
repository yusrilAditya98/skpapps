<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Lembaga Fakultas Ekonomi dan Bisnis Universitas Brawijaya</h1>
        </div>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-lg-8">
                            <h4>Daftar Lembaga</h4>
                        </div>
                        <div class="col-lg-4">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lembaga</th>
                                        <th>Nama Ketua Lembaga</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($lembaga as $l) : ?>
                                        <tr>
                                            <td><?= $i++;  ?></td>
                                            <td><?= $l['nama_lembaga'] ?></td>
                                            <td><?= $l['nama_ketua'] ?></td>
                                            <td>
                                                <a class="btn btn-info" href=""><i class="fas fa-info"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- modal revisi -->
<div class="modal fade" tabindex="-1" role="dialog" id="infoRevisi">
    <div class="modal-dialog modal-lg" role=" document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-revisi" method="post">
                <div class="modal-body">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-description">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Catatan Revisi</label>
                                    <div class="col-sm-9">
                                        <textarea name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
                                    </div>
                                    <input type="hidden" name="valid" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>