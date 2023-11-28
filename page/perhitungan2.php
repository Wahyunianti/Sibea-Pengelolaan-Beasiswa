<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="row">
	<div class="row g-3 mt-2">
		<div class="col-12 col-md-12 col-lg-8 col-xl-8">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<div class="col-md-12">
						<?php $query2 = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa=$_GET[beasiswa]");
						$lim = $query2->fetch_assoc()["kuota"]; ?>
						<?php if (isset($_GET["beasiswa"])) {
							$sqlKriteria = "";
							$namaKriteria = [];
							$queryKriteria = $connection->query("SELECT a.kd_kriteria, a.nama FROM kriteria a JOIN model b USING(kd_kriteria) WHERE b.kd_beasiswa=$_GET[beasiswa]");
							while ($kr = $queryKriteria->fetch_assoc()) {
								$sqlKriteria .= "SUM(
				IF( c.kd_kriteria=" . $kr["kd_kriteria"] . ",
					IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization/nilai.nilai), 0
				)
			) AS " . strtolower(str_replace(" ", "_", $kr["nama"])) . ",";
								$namaKriteria[] = strtolower(str_replace(" ", "_", $kr["nama"]));
							}
							$sql = "SELECT
			(SELECT nama FROM mahasiswa WHERE nim=mhs.nim) AS nama,
			(SELECT nim FROM mahasiswa WHERE nim=mhs.nim) AS nim,
			(SELECT status FROM nilai WHERE nim=mhs.nim group by nim) AS status,
			(SELECT tahun_mengajukan FROM mahasiswa WHERE nim=mhs.nim) AS tahun,
			$sqlKriteria
			SUM(
				IF(
						c.sifat = 'max',
						nilai.nilai / c.normalization,
						c.normalization / nilai.nilai
				) * c.bobot
			) AS rangking
		FROM
			nilai
			JOIN mahasiswa mhs USING(nim)
			JOIN (
				SELECT
						nilai.kd_kriteria AS kd_kriteria,
						kriteria.sifat AS sifat,
						(
							SELECT bobot FROM model WHERE kd_kriteria=kriteria.kd_kriteria AND kd_beasiswa=beasiswa.kd_beasiswa
						) AS bobot,
						ROUND(
							IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1
						) AS normalization
					FROM nilai
					JOIN kriteria USING(kd_kriteria)
					JOIN beasiswa ON kriteria.kd_beasiswa=beasiswa.kd_beasiswa
					WHERE beasiswa.kd_beasiswa=$_GET[beasiswa]
				GROUP BY nilai.kd_kriteria
			) c USING(kd_kriteria)
		WHERE kd_beasiswa=$_GET[beasiswa]
		GROUP BY nilai.nim
		ORDER BY rangking DESC limit $lim"; ?>
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="text-center">
										<h2 class="text-center"><?php $query = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa=$_GET[beasiswa]");
																$rows = $query->fetch_assoc();
																$paymentDate = date('Y-m-d');
																$paymentDate = date('Y-m-d', strtotime($paymentDate));
																//echo $paymentDate; // echos today! 
																$contractDateBegin = $rows['mulai'];
																$contractDateEnd = $rows['tutup'];
																$values = '';
																$namihh = $rows["nama"];
																if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
																	$values = "Dibuka";
																} else {
																	$values = "Ditutup";
																}
																echo ''.$namihh.' ('.$values.') '; ?></h2>
									</h3>
								</div>
								<div class="panel-body">
									<!-- <form action="" method="POST">
									<div class="form-group">
											<label for="kuota">Kuota</label>
											<input type="text" name="kuota" class="form-control">
										</div>
										<button type="submit" id="simpan" class="btn btn-block btn-block">simpan</button>
									</form> -->
									<table class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>NIM</th>
												<th>Nama</th>
												<?php //$query = $connection->query("SELECT nama FROM kriteria WHERE kd_beasiswa=$_GET[beasiswa]"); while($row = $query->fetch_assoc()): 
												?>
												<!-- <th><? //=$row["nama"]
															?></th> -->
												<?php //endwhile 
												?>
												<th>Nilai</th>
												<th>Status</th>
												<th>Info</th>
											</tr>
										</thead>
										<tbody>
											<?php $query = $connection->query($sql);
											while ($row = $query->fetch_assoc()) : ?>
												<?php
												$rangking = number_format((float) $row["rangking"], 0, '');
												$q = $connection->query("SELECT nim FROM hasil WHERE nim='$row[nim]' AND kd_beasiswa='$_GET[beasiswa]' AND tahun='$row[tahun]'");
												if (!$q->num_rows) {
													$connection->query("INSERT INTO hasil VALUES(NULL, '$_GET[beasiswa]', '$row[nim]', '" . $rangking . "', '$row[tahun]')");
												}
												?>
												<tr>
													<td><?= $row["nim"] ?></td>
													<td><?= $row["nama"] ?></td>
													<?php for ($i = 0; $i < count($namaKriteria); $i++) : ?>
														<? //=number_format((float) $row[$namaKriteria[$i]], 8, '.', '');
														?></th>
													<?php endfor ?>
													<td><?= $rangking ?></td>
													<td><?= $row["status"] ?></td>
													<td>
														<a href="?page=perhitungan2&beasiswa=<?= $_GET['beasiswa'] ?>&action=update&yek=<?= $row['nim'] ?>" class="btn btn-dark btn-xs">Detail</a>

													</td>
												</tr>
											<?php endwhile; ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php } else { ?>
							<h1>Beasiswa belum dipilih...</h1>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>


		<div class="col-12 col-md-12 col-lg-4 col-xl-4">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="text-center">Detail</h3>
							</div>
							<div class="panel-body">

								<?php
								if (isset($_GET['action']) and $_GET['action'] == 'update') :
									// $connection->query("DELETE FROM nilai WHERE kd_nilai='$_GET[key]'");
									// echo "Berhasil!";

								?><table class="table table-condensed">
										<thead>
											<tr>
												<th>No</th>
												<th>Beasiswa</th>
												<th>Kriteria</th>
												<th>Nilai</th>
												<th style="width: 20%;">Bobot</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; ?>

											<?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama AS nama_beasiswa, b.nama AS nama_kriteria, e.keterangan AS ket, d.nim, d.nama AS nama_mahasiswa, a.nilai FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim JOIN penilaian e ON e.kd_kriteria=a.kd_kriteria WHERE d.nim=$_GET[yek] AND a.kd_beasiswa=$_GET[beasiswa] AND e.bobot=a.nilai")) : ?>
												<?php while ($row = $query->fetch_assoc()) : ?>
													<tr>
														<td><?= $no++ ?></td>
														<td><?= $row['nama_beasiswa'] ?></td>
														<td><?= $row['nama_kriteria'] ?></td>
														<td><?= $row['ket'] ?></td>
														<td><?= $row['nilai'] ?></td>
													</tr>
												<?php endwhile ?>
											<?php endif ?>
										</tbody>
									</table>
									<?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama AS nama_beasiswa, b.nama AS nama_kriteria, d.nim, d.nama AS nama_mahasiswa, a.nilai, a.berkas as bks FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim where d.nim=$_GET[yek] and a.kd_beasiswa=$_GET[beasiswa]")) : ?>
										<?php while ($row = $query->fetch_assoc()) : ?>
											<div class="form-group">
												<label for="berkas">Berkas Pendukung <?= $row['nama_kriteria'] ?></label>
												<a href="<?= $row['bks'] ?>" target="_blank"><?= $row['bks'] ?></a>
											</div> <br>
										<?php endwhile ?>
									<?php endif ?>
									<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
										<div class="form-group">
											<label for="status">Status Penerimaan (<?php $query = $connection->query("SELECT d.nim as nam, a.kd_nilai, c.nama AS nama_beasiswa, b.nama AS nama_kriteria, d.nim, d.nama AS nama_mahasiswa, a.nilai, a.berkas as bks FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim where d.nim=$_GET[yek] and a.kd_beasiswa=$_GET[beasiswa] group by d.nim");
																					echo $nimih = $query->fetch_assoc()["nam"]; ?>)</label>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" checked>
												<label class="form-check-label" for="flexRadioDefault1">
													Diterima
												</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" checked>
												<label class="form-check-label" for="flexRadioDefault2">
													Ditolak
												</label>
											</div>
										</div> <br>
										<button type="submit" id="simpan" class="btn btn-dark btn-block">Simpan</button>
									<?php endif ?>
									<!-- <button type="submit" class="btn btn-btn-block">Simpan</button> -->
									</form>

									<?php

									$kode = isset($_GET['beasiswa']);
									if ($_SERVER["REQUEST_METHOD"] == "POST") {
										$validasi = false;
										$err = false;
										if (isset($_POST['status']) == 'Diterima') {
											$acece = 'Diterima';
										} else {
											$acece = 'Ditolak';
										}

										$sql = "UPDATE nilai SET status='$acece' WHERE nim=$nimih and kd_beasiswa=$_GET[beasiswa]";


										if (!$err and $connection->query($sql)) {
											$message = 'swal(
										"Sukses",
										"Data telah diterima",
										"success"
									).then(function() {
										window.location = "?page=perhitungan2&beasiswa=' . $kode . '";
									});';
											echo "<script type='text/javascript'>$message</script>";
										} else {
											$message = 'swal(
										"Gagal",
										"Update Data",
										"error"
									).then(function() {
										window.location = "?page=perhitungan2&beasiswa=' . $kode . '";
									});';
											echo "<script type='text/javascript'>$message</script>";
										}
									}

									?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>