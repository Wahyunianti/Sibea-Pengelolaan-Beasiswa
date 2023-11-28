<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM nilai JOIN penilaian USING(kd_kriteria) WHERE kd_nilai='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["save"])) {
	$validasi = false;
	$err = false;
	if ($update) {
		$sql = "UPDATE nilai SET nim='$_POST[nim]', nilai='$_POST[nilai]' WHERE kd_nilai='$_GET[key]'";
	} else {
		$query = "INSERT INTO nilai VALUES ";
		foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
			$query .= "(NULL, '$_POST[kd_beasiswa]', '$kd_kriteria', '$_POST[nim]', '$nilai'),";
		}
		$sql = rtrim($query, ',');

		$validasi = true;
	}

	if ($validasi) {
		foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
			$q = $connection->query("SELECT kd_nilai FROM nilai WHERE kd_beasiswa=$_POST[kd_beasiswa] AND kd_kriteria=$kd_kriteria AND nim=$_POST[nim] AND nilai LIKE '%$nilai%'");
			if ($q->num_rows) {
				echo alert("Nilai untuk " . $_POST["nim"] . " sudah ada!", "?page=nilai");
				$err = true;
			}
		}
	}

	if (!$err and $connection->query($sql)) {
		echo alert("Berhasil!", "?page=nilai");
	} else {
		echo alert("Gagal!", "?page=nilai");
	}
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM nilai WHERE kd_nilai='$_GET[key]'");
	echo alert("Berhasil!", "?page=nilai");
}
?>

<div class="row">
	<div class="row g-3 mt-2">
		<div class="col-12 col-md-12 col-lg-12 col-xl-12">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="text-center">DAFTAR</h3>
							</div>
							<div class="panel-body">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>No</th>
											<th>NIM</th>
											<th>Nama</th>
											<th>Beasiswa</th>
											<th>Kriteria</th>
											<th>Nilai</th>
											<!-- <th></th> -->
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama AS nama_beasiswa, b.nama AS nama_kriteria, d.nim, d.nama AS nama_mahasiswa, a.nilai FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim")) : ?>
											<?php while ($row = $query->fetch_assoc()) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $row['nim'] ?></td>
													<td><?= $row['nama_mahasiswa'] ?></td>
													<td><?= $row['nama_beasiswa'] ?></td>
													<td><?= $row['nama_kriteria'] ?></td>
													<td><?= $row['nilai'] ?></td>
													<!-- <td>
										<div class="btn-group">
											<a href="?page=nilai&action=delete&key=<?= $row['kd_nilai'] ?>" class="btn btn-danger btn-xs">Hapus</a>
										</div>
									</td> -->
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
	</div>
</div>
<script type="text/javascript">
	$("#kriteria").chained("#beasiswa");
	$("#nilai").chained("#kriteria");
</script>