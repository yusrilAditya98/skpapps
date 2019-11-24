<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pengajuan Rancangan</h1>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4">
				<div class="card">
					<div class="card-header">
						<h4>Tambah Rancangan Kegiatan</h4>
					</div>
					<div class="card-body text-center">
						<?php if ($lembaga['status_rencana_kegiatan'] == 1) : ?>
							<a href="<?= base_url('Kegiatan/tambahRancanganKegiatan') ?>" class="btn btn-icon btn-success mb-3">
								Tambah Rancangan Kegiatan <i class="fas fa-plus pl-2"></i></a>
						<?php else : ?>
							Rancangan Kegiatan disable
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-5">
				<div class="card">
					<div class="card-header">
						<h4>Panduan Pengajuan Rancangan Kegiatan</h4>
					</div>
					<div class="card-body text-center">
						<a href="form_tambah_proposal.html" class="btn btn-icon btn-primary mb-3">
							Download Panduan <i class="fas fa-download pl-2"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Tambah Rancangan Kegiatan</h4>
					</div>
					<div class="card-body">
						<?php if ($lembaga['status_rencana_kegiatan'] == 1) : ?>
							<div class="alert alert-warning mb-3" role="alert" style="opacity: 1; color:black; background-color:rgba(35, 182, 246, 0.4)">
								<div class="row">
									<div class="col-12 col-lg-8 mt-2">
										<span class="font-weight-bold">Perhatian!</span> Pastikan anda memeriksa
										kembali
										data kegiatan
										sebelum diajakun
									</div>
									<div class="col-12 col-lg-4">
										<a href="#" class="btn btn-icon btn-success" style="box-shadow: none; float:right">
											Ajukan Kegiatan <i class="fab fa-telegram-plane pl-2"></i></a>
									</div>
								</div>
							</div>
						<?php endif ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead class="text-center">
									<tr>
										<th scope="col">No</th>
										<th scope="col">Tahun Periode</th>
										<th scope="col">Nama Kegiatan</th>
										<th scope="col">Dana Anggaran</th>
										<th scope="col">Validasi</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($rancangan as $r) : ?>
										<tr class="text-center">
											<th scope="row">1</th>
											<td><?= $r['tahun_rancangan'] ?></td>
											<td><a href=""><?= $r['nama_proker'] ?></a>
											</td>
											<td>Rp.<?= $r['anggaran_kegiatan'] ?> ,-</td>
											<td>
												<?php if ($r['status_rancangan'] == 1) :  ?>
													<i class="fa fa-check text-success" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 2) : ?>
													<div class="btn btn-warning circle-content detail-revisi" data-toggle="modal" data-target="#i-revisi" data-id="<?= $r['id'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
												<?php elseif ($r['status_rancangan'] == 4) : ?>
													<i class="fa fa-circle text-primary" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 0) : ?>
													<i class="fa fa-circle text-secondary" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 3) : ?>
													<i class="fa fa-minus" aria-hidden="true"></i>
												<?php endif; ?>
											</td>
											<td>
												<div class="row">
													<div class="col-lg-6">
														<a href="#" class="btn btn-icon btn-info"> <i class="fas fa-edit"></i></a>
													</div>
													<div class="col-lg-6">
														<a href="#" class="btn btn-icon btn-danger"> <i class="fas fa-trash"></i></a>
													</div>
												</div>
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