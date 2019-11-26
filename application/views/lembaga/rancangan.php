<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pengajuan Rancangan</h1>
		</div>
		<?= $this->session->flashdata('message'); ?>
		<div class="row">
			<div class="col-12 col-md-4 col-lg-4">
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
			<div class="col-12 col-md-4 col-lg-4">
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
			<div class="col-12 col-md-4 col-lg-4">
				<div class="card">
					<div class="card-header">
						<h4>Dana Pagu Lembaga / Periode <?= $lembaga['tahun_rancangan'] ?></h4>
					</div>
					<div class="card-body text-center">
						<h2>Rp.<?= number_format($dana_pagu['anggaran_kemahasiswaan'], 2, ',', '.') ?>
						</h2>
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
										<form action="<?= base_url('Kegiatan/ajukanRancangan') ?>" method="post">
											<input type="hidden" class="t-anggaran" name="totalAnggaran">
											<input type="hidden" class="t-pengajuan" name="tahunPengajuan" value="<?= $lembaga['tahun_rancangan'] ?>">
											<button type="submit" class="btn btn-icon btn-success" style="box-shadow: none; float:right">
												Ajukan Kegiatan <i class="fab fa-telegram-plane pl-2"></i></button>
										</form>
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
										<th scope="col">Nama Lembaga</th>
										<th scope="col">Anggaran Kegiatan</th>
										<th scope="col">Kegiatan tervalidasi</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $temp = 0;
									foreach ($rancangan as $r) : ?>
										<tr class="text-center">
											<th scope="row">1</th>
											<td><?= $r['tahun_rancangan'] ?></td>
											<td><a href=""><?= $r['nama_proker'] ?></a>
											</td>
											<?php $temp += $r['anggaran_kegiatan']; ?>
											<td>Rp.<?= number_format($r['anggaran_kegiatan'], 2, ',', '.') ?> ,-</td>
											<td>
												<?php if ($r['status_rancangan'] == 1) :  ?>
													<i class="fa fa-check text-success" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 2) : ?>
													<div class="btn btn-warning circle-content detail-revisi" data-toggle="modal" data-target="#i-revisi" data-id=""><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
												<?php elseif ($r['status_rancangan'] == 3) : ?>
													<i class="fa fa-circle text-primary" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 0) : ?>
													<i class="fa fa-circle text-secondary" aria-hidden="true"></i>
												<?php endif; ?>
											</td>
											<td>
												<div class="row">
													<?php if ($r['status_rancangan'] == 0 || $r['status_rancangan'] == 2) : ?>
														<div class="col-lg-6">
															<a href="<?= base_url('Kegiatan/editRancanganKegiatan/') . $r['id_daftar_rancangan'] ?>" class="btn btn-icon btn-info"> <i class="fas fa-edit"></i></a>
														</div>
														<div class="col-lg-4">
															<a href="<?= base_url('Kegiatan/hapusRancanganKegiatan/') . $r['id_daftar_rancangan'] ?>" class="btn btn-icon btn-danger"> <i class="fas fa-trash"></i></a>
														</div>
													<?php elseif ($r['status_rancangan'] == 1) : ?>
														<div class="col-lg-12">
															<a href="<?= base_url('Kegiatan/tambahProposal/') . $r['id_daftar_rancangan'] ?>" class="badge btn btn-outline-success">Ajukan Proposal</a>
														</div>
													<?php elseif ($r['status_rancangan'] == 3) : ?>
														<div class="col-lg-6">
															<span class="text-primary">Proses</span>
														</div>
													<?php elseif ($r['status_rancangan'] == 4) : ?>
														<div class="col-lg-12">
															<span class="text-primary">Sudah Mengajukan</span>
														</div>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
									<tr class="text-center">
										<td scope="col" colspan="3">Total Anggaran</td>
										<td scope="col">Rp.<span class="total-anggaran"> <?= number_format($temp, 2, ',', '.') ?> </span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>