<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM model WHERE kd_model='$_GET[key]'");
	$row = $sql->fetch_assoc();
}



if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["save"])) {
	$validasi = false;
	$krit = isset($_POST['kd_kriteria']);
	$bbt = isset($_POST['bobot']);
	$err = false;
	if (empty($krit) || empty($bbt)) {
		$message = 'swal(
			"Gagal",
			"Data tidak ada",
			"error"
		).then(function() {
			window.location = "?page=model";
		});';
		echo "<script type='text/javascript'>$message</script>";
	} else {
	if ($update) {
		$sql = "UPDATE model SET kd_kriteria='$_POST[kd_kriteria]', kd_beasiswa='$_POST[kd_beasiswa]', bobot='$_POST[bobot]' WHERE kd_model='$_GET[key]'";
	} else {
		
			$sql = "INSERT INTO model VALUES (NULL, '$_POST[kd_beasiswa]', '$_POST[kd_kriteria]', '$_POST[bobot]')";

			$validasi = true;
		
	}

	if ($validasi) {
		$q = $connection->query("SELECT kd_model FROM model WHERE kd_beasiswa=$_POST[kd_beasiswa] AND kd_kriteria=$_POST[kd_kriteria] AND bobot LIKE '%$_POST[bobot]%'");
		if ($q->num_rows) {
			$err = true;
		}
	}

	if (!$err and $connection->query($sql)) {
		$message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=model";
        });';
		echo "<script type='text/javascript'>$message</script>";
	} else {
		$message = 'swal(
            "Gagal",
            "Update Data",
            "failed"
        ).then(function() {
            window.location = "?page=model";
        });';
		echo "<script type='text/javascript'>$message</script>";
	}}
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM model WHERE kd_model='$_GET[key]'");
	$message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=model";
    });';
	echo "<script type='text/javascript'>$message</script>";
}
?>
<div class="row">
	<div class="row g-3 mt-2">
		<div class="col-12 col-md-12 col-lg-4 col-xl-4">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body">
					<div class="col-md-12">
						<div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
							<div class="panel-heading">
								<h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3>
							</div>
							<div class="panel-body">
								<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
									<div class="form-group">
										<label for="kd_beasiswa">Beasiswa</label>
										<?php if ($_POST) : ?>
											<?php $q = $connection->query("SELECT nama FROM beasiswa WHERE kd_beasiswa=$_POST[kd_beasiswa]"); 
											
											?>
											<input type="text" value="<?= $q->fetch_assoc()["nama"] ?>" class="form-control" readonly="on">
											<input type="hidden" name="kd_beasiswa" value="<?= $_POST["kd_beasiswa"] ?>">
										<?php else : ?>
											<select class="form-control" name="kd_beasiswa" id="beasiswa">
												<?php $sql = $connection->query("SELECT * FROM beasiswa");
												while ($data = $sql->fetch_assoc()) : ?>
													<option value="<?= $data["kd_beasiswa"] ?>" <?= (!$update) ? "" : (($row["kd_beasiswa"] != $data["kd_beasiswa"]) ? "" : 'selected="selected"') ?>><?= $data["nama"] ?></option>
												<?php endwhile; ?>
											</select>
										<?php endif; ?>
									</div>
									<?php if ($_POST) : ?>
										<div class="form-group">
											<label for="nilai">Kriteria</label>
											<select class="form-control" name="kd_kriteria" id="kriteria">
												<?php $sql = $connection->query("SELECT k.* FROM kriteria k LEFT JOIN model m ON k.kd_kriteria = m.kd_kriteria WHERE k.kd_beasiswa=$_POST[kd_beasiswa] AND m.kd_beasiswa IS NULL");
												while ($data = $sql->fetch_assoc()) : ?>
													<option name="kd_kriteria" value="<?= $data["kd_kriteria"] ?>" <?= (!$update) ?: 'value="' . $row["kd_kriteria"] . '"' ?>><?= $data["nama"] ?></option>
												<?php endwhile; ?>
											</select>
										</div>
										<div class="form-group">
											<label for="bobot">Bobot</label>
											<input type="text" name="bobot" class="form-control" <?= (!$update) ?: 'value="' . $row["bobot"] . '"' ?>>
										</div>
										<input type="hidden" name="save" value="true">
									<?php endif; ?>
									<br>
									<button type="submit" id="simpan" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block"><?= ($_POST) ? "Simpan" : "Tampilkan" ?></button>
									<?php if ($_POST) : ?>
										<a href="?page=model" class="btn btn-dark btn-block">Batal</a>
									<?php endif; ?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-8 col-xl-8">
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
											<th>Beasiswa</th>
											<th>Kriteria</th>
											<th>Bobot</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php if ($query = $connection->query("SELECT c.nama AS nama_beasiswa, b.nama AS nama_kriteria, a.bobot, a.kd_model FROM model a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa")) : ?>
											<?php while ($row = $query->fetch_assoc()) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $row['nama_beasiswa'] ?></td>
													<td><?= $row['nama_kriteria'] ?></td>
													<td><?= $row['bobot'] ?></td>
													<td>
														<div class="btn-group">
															<!-- <a href="?page=model&action=update&key=<?= $row['kd_model'] ?>" class="btn btn-warning btn-xs">Edit</a> -->
															<a href="?page=model&action=delete&key=<?= $row['kd_model'] ?>" class="btn btn-danger btn-xs">Hapus</a>
														</div>
													</td>
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
</script>