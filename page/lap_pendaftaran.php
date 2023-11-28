<div class="row">
	<div class="row g-3 mt-2">
		<div class="col-12 col-md-12 col-lg-12 col-xl-12">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<div  class="row ">
									<div class="col d-flex justify-content-start">
										<h2>Daftar Mahasiswa Yang Mengajukan</h2>
									</div>
									<div class="col d-flex justify-content-end">
										<a href="page/cetak2.php" target="_blank" class="btn btn-dark"><i class="fa fa-file-pdf-o"></i> &nbsp PRINT</a>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div id="printableTable">
									<table class="table table-condensed">
										<thead>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama</th>
												<th>Alamat</th>
												<th>Jenis Kelamin</th>
												<th>Tahun Mengajukan</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; ?>
											<?php if ($query = $connection->query("SELECT * FROM mahasiswa WHERE nim IN(SELECT nim FROM nilai)")) : ?>
												<?php while ($row = $query->fetch_assoc()) : ?>
													<tr>
														<td><?= $no++ ?></td>
														<td data-toggle="tooltip"><?= $row["nim"] ?></td>
														<td><?= $row["nama"] ?></td>
														<td><?= $row['alamat'] ?></td>
														<td><?= $row['jenis_kelamin'] ?></td>
														<td><?= $row['tahun_mengajukan'] ?></td>
													</tr>
												<?php endwhile ?>
											<?php endif ?>
										</tbody>
									</table>
								</div>
								<iframe name="print_frame" width="1" height="1" frameborder="1" src="about:blank"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<style>
	@media print {
		* {
			display: none;
		}

		.printableTable {
			display: block;
		}
	}
</style>


<script>
	function printDiv() {
		window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
		window.frames["print_frame"].window.focus();
		window.frames["print_frame"].window.print();
	};
</script>