<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pengajuan Rancangan</h1>
		</div>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
		<div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
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
							<span class="badge badge-warning" style="font-size: 15px"> Sudah Mengajukan Kegiatan !</span>
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
						<?php if ($this->input->get('tahun')) : ?>
							<h4>Dana Pagu Lembaga / Periode <?= $this->input->get('tahun') ?></h4>
						<?php else : ?>
							<h4>Dana Pagu Lembaga / Periode <?= $lembaga['tahun_rancangan'] ?></h4>
						<?php endif; ?>
					</div>
					<div class="card-body text-left">
						<div class="row">
							<div class="col-lg-2 col-md-2">
								<img class="icon-caret-left" style="width: 1.5rem" src="<?= base_url('assets/img/icon/money-bag.png') ?>" alt="">
							</div>
							<div class="col-lg-10 col-md-8">
								<span style="font-size: 18px">Rp.<?= number_format($dana_pagu['anggaran_kemahasiswaan'], 0, ',', '.') ?>
									(Dana Pagu)</span>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-lg-2 col-sm-2">
								<img class="icon-caret-left" style="width: 1.5rem" src="<?= base_url('assets/img/icon/money.png') ?>" alt="">
							</div>
							<div class="col-lg-10 col-sm-10">
								<span style="font-size: 18px">Rp.<?= number_format($dana_pagu['anggaran_kemahasiswaan'] - $dana_pagu['anggaran_lembaga'], 0, ',', '.')   ?>
									(Sisa Dana)
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Daftar Rancangan Kegiatan</h4>
					</div>
					<div class="card-body">
						<!-- jika status rancangan diberikan hak akses untuk mengajukan -->
						<?php if ($lembaga['status_rencana_kegiatan'] == 1) : ?>
							<div class="alert alert-warning mb-3" role="alert" style="opacity: 1; color:black; background-color:rgba(35, 182, 246, 0.4)">
								<div class="row">
									<div class="col-12 col-lg-8 mt-2">
										<span class="font-weight-bold">Perhatian!</span> Pastikan anda memeriksa
										kembali
										data kegiatan
										sebelum diajukan
									</div>
									<div class="col-12 col-lg-4">
										<form action="<?= base_url('Kegiatan/ajukanRancangan') ?>" method="post">
											<input type="hidden" class="t-anggaran" name="totalAnggaran">
											<input type="hidden" class="t-pengajuan" name="tahunPengajuan" value="<?= $lembaga['tahun_rancangan'] ?>">
											<button type="submit" onclick="return confirm('Apakah anda sudah yakin dengan rancangan kegiatan anda ?')" class="btn btn-icon btn-success" style="box-shadow: none; float:right">
												Ajukan Kegiatan <i class="fab fa-telegram-plane pl-2"></i></button>
										</form>
									</div>
								</div>
							</div>
						<?php else : ?>
							<div class="alert alert-warning mb-3" role="alert" style="opacity: 1; color:black; background-color:rgba(35, 182, 246, 0.4)">
								<div class="row">
									<div class="col-12 col-lg-8 mt-2">
										<span class="font-weight-bold">Sudah Mengajukan Kegiatan!</span> Menunggu validasi kemahasiswaan
									</div>
								</div>
							</div>
						<?php endif ?>
						<div class="float-right">
							<form action="<?= base_url('Kegiatan/pengajuanRancangan') ?>" method="get">
								<div class="form-group">
									<div class="input-group">

										<select name="tahun" class="custom-select" id="inputGroupSelect04">
											<option value="" selected="">Tahun...</option>
											<?php foreach ($tahun as $t) : ?>
												<option value="<?= $t['tahun_kegiatan'] ?>"><?= $t['tahun_kegiatan'] ?></option>
											<?php endforeach; ?>
										</select>
										<div class="input-group-append">
											<button class="btn btn-outline-primary" type="submit">cari</button>
										</div>

									</div>
								</div>
							</form>
						</div>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead class="text-center">
									<tr>
										<th scope="col">No</th>
										<th scope="col">Tahun Periode</th>
										<th scope="col">Tanggal Pelaksanaan</th>
										<th scope="col">Nama Kegiatan</th>
										<th scope="col">Kategori Kegiatan</th>
										<th scope="col">Anggaran Kegiatan (Rp)</th>
										<th scope="col">Status Kegiatan</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody class="text-center">

									<?php $temp = 0;
									$i = 1;
									foreach ($rancangan as $r) : ?>

										<tr>
											<th scope="row"><?= $i++ ?></th>
											<td><?= $r['tahun_kegiatan'] ?>
											<td class="text-left">
												<?php $date = date_create($r['tanggal_mulai_pelaksanaan']);
												echo date_format($date, "d M Y"); ?>
												-
												<?php $date = date_create($r['tanggal_selesai_pelaksanaan']);
												echo date_format($date, "d M Y"); ?>
											</td>

											<td class="text-left"><?= $r['nama_proker'] ?></td>
											<td class="text-left"><?= $r['kategori_kegiatan'] ?></td>
											<?php $temp += $r['anggaran_kegiatan']; ?>
											<td><?= number_format($r['anggaran_kegiatan'], 2, ',', '.') ?> </td>
											<td>
												<?php if ($r['status_rancangan'] == 1 || $r['status_rancangan'] == 4) :  ?>
													<i class="fa fa-check text-success" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 2) : ?>
													<div class="btn btn-warning circle-content detail-revisi-rancangan" data-toggle="modal" data-target="#i-revisi" data-catatan="<?= $r['catatan_revisi'] ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
												<?php elseif ($r['status_rancangan'] == 3) : ?>
													<i class="fa fa-circle text-primary" aria-hidden="true"></i>
												<?php elseif ($r['status_rancangan'] == 0) : ?>
													<i class="fa fa-circle text-secondary" aria-hidden="true"></i>
												<?php endif; ?>
											</td>
											<td>
												<div class="row">
													<!-- 5 kegiatan telah selesai -->
													<?php if ($r['status_rancangan'] == 0 || $r['status_rancangan'] == 2) : ?>
														<div class="col-lg-6">
															<a href="<?= base_url('Kegiatan/editRancanganKegiatan/') . $r['id_daftar_rancangan'] ?>" class="btn btn-icon btn-info"> <i class="fas fa-edit"></i></a>
														</div>
														<div class="col-lg-4">
															<a href="<?= base_url('Kegiatan/hapusRancanganKegiatan/') . $r['id_daftar_rancangan'] ?>" class="btn btn-icon btn-danger confirm-hapus"> <i class="fas fa-trash"></i></a>
														</div>
													<?php elseif ($r['status_rancangan'] == 1) : ?>
														<div class="col-lg-12">
															<a href="<?= base_url('Kegiatan/tambahProposal/') . $r['id_daftar_rancangan'] ?>" class="badge btn btn-outline-success">Ajukan Proposal</a>
														</div>
													<?php elseif ($r['status_rancangan'] == 3) : ?>
														<div class="col-lg-12">
															<span class="text-primary">Proses</span>
														</div>
													<?php elseif ($r['status_rancangan'] == 4) : ?>
														<div class="col-lg-12">
															<span class="text-warning">Sedang Berlangsung</span>
														</div>
													<?php elseif ($r['status_rancangan'] == 5) : ?>
														<div class="col-lg-12">
															<span class="text-success">Telah Terlaksana</span>
														</div>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
									<tr class="text-center">
										<td scope="col" colspan="5">Total Anggaran (Rp)</td>
										<td scope="col"><span class="total-anggaran"> <?= number_format($temp, 2, ',', '.') ?> </span></td>
									</tr>
								</tbody>
							</table>
							<table>
								<thead>
									<tr>
										<td><b>Keterangan</b></td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class=" text-center"> <i class="fa fa-check text-success" aria-hidden="true"></i></td>
										<td> : Telah Divalidasi</td>
									</tr>
									<tr>
										<td class="text-center"> <i class="fa fa-circle text-primary" aria-hidden="true"></i></td>
										<td> : Proses Validasi</td>
									</tr>
									<tr>
										<td class="text-center"> <i class="fa fa-circle text-secondary" aria-hidden="true"></i></td>
										<td> : Menunggu Pengajuan</td>
									</tr>
									<tr>
										<td class="text-center"> <span class="btn btn-warning circle-content"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span></td>
										<td> : Revisi (Menampilkan Catatan Revisi)</td>
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

<div class="modal fade" tabindex="-1" role="dialog" id="i-revisi">
	<div class="modal-dialog modal-lg" role=" document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Revisi Rancangan Kegiatan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card profile-widget">
						<div class="profile-widget-description">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Catatan Revisi</label>
								<div class="col-sm-9">
									<textarea readonly name="catatan" class="form-control d-catatan" style="height:200px"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-whitesmoke br">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>