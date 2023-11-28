
<div class="row">
	<div class="row g-3 mt-2">
		<div class="col-12 col-md-12 col-lg-12 col-xl-12">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					
				<div class="col-md-12">
					<div class="panel-heading">
						<div class="row">
							<div class="col d-flex justify-content-start">
								<h2>Data Pendaftar Keseluruhan</h2>
							</div>
							<div class="col d-flex justify-content-end">
								<a href="page/cetak1.php" target="_blank" class="btn btn-dark"><i class="fa fa-file-pdf-o"></i>PRINT</a>
							</div>
						</div>
					</div>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>No</th>
										<th>NIM</th>
										<th>Nama</th>
										<th>Beasiswa</th>
										<th>Nilai</th>
										<th>Tahun</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; ?>
									<?php if ($query = $connection->query("SELECT b.nama AS beasiswa, a.nim, a.nilai, a.tahun, c.nama FROM hasil a JOIN beasiswa b USING(kd_beasiswa) JOIN mahasiswa c ON a.nim=c.nim ORDER BY a.nilai DESC")) : ?>
										<?php while ($row = $query->fetch_assoc()) : ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $row["nim"] ?></td>
												<td><?= $row["nama"] ?></td>
												<td><?= $row["beasiswa"] ?></td>
												<td><?= $row["nilai"] ?></td>
												<td><?= $row['tahun'] ?></td>
											</tr>
										<?php endwhile ?>
									<?php endif ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
