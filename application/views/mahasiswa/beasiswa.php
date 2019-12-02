<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Form Penerima Beasiswa</h1>
		</div>
		<div class="row">
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
												<input type="text" required name="nimMahasiswa" class="form-control" id="nimMahasiswa" value="<?= $this->session->userdata('username') ?>">
												<div class="invalid-feedback">
													Nim harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="tlpnMahasiswa">No Telepon / Whatsapp</label>
												<input type="text" name="tlpnMahasiswa" class="form-control" id="tlpnMahasiswa" required>
												<div class="invalid-feedback">
													No telpon harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="alamatKos">Alamat Kos</label>
												<input type="text" name="alamatKos" required class="form-control" id="alamatKos">
												<div class="invalid-feedback">
													Alamat kod harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="alamatRumah">Alamat Rumah</label>
												<textarea style="height:100px" required name="alamatRumah" class="form-control" id="alamatRumaha"></textarea>
												<div class="invalid-feedback">
													Alamat rumah harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="emailMahasiswa">Email</label>
												<input type="email" required class="form-control" id="emailMahasiswa">
												<div class="invalid-feedback">
													Email harap di Isi
												</div>
											</div>
										</div>
										<div class="bagian-beasiswa mt-5">
											<h5>Informasi Beasiswa</h5>
											<div class="form-group">
												<label for="jenisBeasiswa">Jenis Beasiswa</label>
												<input type="text" required class="form-control" id="jenisBeasiswa">
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
												<label for="tahunMeneriam">Tahun Menerima Beasiswa</label>
												<input type="text" class="form-control" name="tahunMenerima" id="tahunMeneriam" required>
												<div class="invalid-feedback">
													Tahun meneriam beasiswa harap di Isi
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
													Upload PDF atau JPG Maksimal 2 Mega. Silahkan di isikan
													lampiran Surat Tidak Pernah Menerima Beasiswa dari
													tempat lain/Bermaterai 6000. Format surat
													<span><a href="#">Disini</a></span></small>
												<div class="invalid-feedback">
													Lampiran harap di Isi
												</div>
											</div>
											<div class="form-group">
												<label for="uploadBukti">Bukti Penerima Beasiswa
													Proposal</label>
												<input type="file" class="form-control-file btn" name="uploadBukti" id="uploadBukti" required>
												<small id="anggaranHelp" class="form-text text-muted">File
													Upload PDF atau JPG Maksimal 2 Mega. </small>
												<div class="invalid-feedback">
													bukti harapa harap di Isi
												</div>
											</div>
										</div>
										<div class="action-button">
											<button type="submit" style="width:auto; float:right" class="btn btn-icon btn-success ml-3">
												Kirim <i class="fab fa-telegram-plane"></i></button>
											<a href="dashboard.html" style="float:right" class="btn btn-icon btn-secondary">
												Kembali <i class="fas fa-arrow-left"></i></a>
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