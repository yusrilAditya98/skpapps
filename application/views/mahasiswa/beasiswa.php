<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Form Penerima Beasiswa</h1>
		</div>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
		<div class="flash-failed" data-flashdata="<?= $this->session->flashdata('failed'); ?>"></div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Daftar Pengajuan Beasiswa</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-12">
								<div class="card-body">
									<ul class="list-unstyled">
										<?php foreach ($penerima_beasiswa as $p) : ?>
											<li class="media">
												<img class="mr-3" src=" <?= base_url() ?>/assets/img/medal.png" style="width: 40px" class="rounded-circle profile-widget-picture" alt=" Generic placeholder image">
												<div class="media-body">
													<h5 class="mt-0 mb-1"><?= $p['jenis_beasiswa']; ?> -
														<?php if ($p['validasi_beasiswa'] == 0) : ?>
															<div class="badge badge-primary">Menunggung Proses Validasi</div>
														<?php elseif ($p['validasi_beasiswa'] == 1) : ?>
															<i class="fa fa-check text-success" aria-hidden="true"></i>
														<?php elseif ($p['validasi_beasiswa'] == 2) : ?>
															<div class="btn btn-warning circle-content d-revisi" data-toggle="modal" data-target="#infoRevisi"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
														<?php endif; ?>
													</h5>
													<p>Beasiswa <span><?= $p['jenis_beasiswa'] ?></span> diterima pada tanggal <span><?= date("d-m-Y", strtotime($p['tahun_menerima']))  ?></span> dan berakhir pada tanggal <span><?= date("d-m-Y", strtotime($p['lama_menerima']))  ?></span> dengan nominal anggaran beasiswa sebesar Rp.<span><?= number_format($p['nominal'], 0, ',', '.') ?></span></p>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Form Mahasiswa Penerima Beasiswa</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-12">
								<div class="form-tambah-skp">
									<form action="<?= base_url('Mahasiswa/beasiswa') ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
										<div class="bagian-personality">
											<h5>Informasi Personality</h5>
											<div class="form-group">
												<label for="namaMahasiswa">Nama Mahasiswa</label>
												<input type="text" class="form-control" name="namaMahasiswa" id="namaMahasiswa" required readonly value="<?= $this->session->userdata('nama') ?>">
												<div class="invalid-feedback">
													Nama Mahasiswa harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="nimMahasiswa">NIM</label>
												<input type="text" required name="nimMahasiswa" class="form-control" id="nimMahasiswa" value="<?= $this->session->userdata('username') ?>" readonly>
												<div class="invalid-feedback">
													Nim harap di Isi
												</div>
											</div>
										</div>
										<div class="bagian-beasiswa mt-5">
											<h5>Informasi Beasiswa</h5>
											<div class="form-group">
												<label for="jenisBeasiswa">Jenis Beasiswa</label>
												<select name="jenisBeasiswa" class="form-control" id="id-beasiswa">
													<option value="">-- Pilih Jenis Beasiswa --</option>
													<?php foreach ($beasiswa as $b) : ?>
														<option value="<?= $b['id'] ?>"><?= $b['jenis_beasiswa'] ?></option>
													<?php endforeach; ?>
												</select>
												<div class="invalid-feedback">
													Jenis beasiswa harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="namaInstansi">Nama Instansi Pemberi
													Beasiswa</label>
												<input type="text" required class="form-control" name="namaInstansi" id="namaInstansi">
												<div class="invalid-feedback">
													Nama instansi harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="tahunMenerima">Tahun Menerima Beasiswa</label>
												<input type="date" class="form-control" name="tahunMenerima" id="tahunMenerima" required>
												<div class="invalid-feedback">
													Tahun meneriam beasiswa harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="lamaMenerima">Lama Menerima Beasiswa</label>
												<input type="date" class="form-control" name="lamaMenerima" id="lamaMenerima" required>
												<div class="invalid-feedback">
													Lama meneriam beasiswa harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="nominalBeasiswa">Nominal Beasiswa</label>
												<input type="text" class="form-control" name="nominalBeasiswa" id="nominalBeasiswa" required>
												<div class="invalid-feedback">
													Nominal beasiswa di Isi
												</div>
											</div>
										</div>
										<div class="bagian-upload mt-5">
											<h5>Informasi Upload</h5>
											<div class="form-group">
												<label for="lampiran">Lampiran</label>
												<input type="file" name="lampiran" class="form-control-file btn" id="lampiran" required>
												<small id="anggaranHelp" class="form-text text-muted">File
													Upload PDF Maksimal 2 Mega. Silahkan di isikan
													lampiran Surat Tidak Pernah Menerima Beasiswa dari
													tempat lain/Bermaterai 6000.</small>
												<div class="invalid-feedback">
													Lampiran harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="uploadBukti">Bukti Penerima Beasiswa
													Proposal</label>
												<input type="file" class="form-control-file btn" name="uploadBukti" id="uploadBukti" required>
												<small id="anggaranHelp" class="form-text text-muted">File
													Upload PDF Maksimal 2 Mega. </small>
												<div class="invalid-feedback">
													bukti harapa harap di Isi
												</div>
											</div>
										</div>
										<div class="action-button">
											<button onclick="return confirm('Apakah anda sudah yakin dengan data pengajuan beasiswa ?')" type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
												Kirim <i class="fab fa-telegram-plane"></i></button>

										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</section>
</div>