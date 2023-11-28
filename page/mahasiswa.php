<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM mahasiswa WHERE nim='$_GET[key]'");
	$row = $sql->fetch_assoc();
	$sql2 = $connection->query("SELECT * FROM user WHERE password='$_GET[key]'");
	$row2 = $sql2->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false;
	$err = false;
	if ($update) {
		$sql = "UPDATE mahasiswa SET nim='$_POST[nim]', nama='$_POST[nama]', username='$_POST[usr]', alamat='$_POST[alamat]', jenis_kelamin='$_POST[jenis_kelamin]', tahun_mengajukan='" . date("Y") . "' WHERE nim='$_GET[key]'";
		$sql2 = "UPDATE user SET nama_user='$_POST[nama]', username='$_POST[usr]' WHERE nim='$_GET[key]'";
	} else {
		$sql = "INSERT INTO mahasiswa VALUES ('$_POST[nim]', '$_POST[nama]', '$_POST[usr]', '$_POST[alamat]', '$_POST[jenis_kelamin]', '" . date("Y") . "')";
		$sql2 = "INSERT INTO user VALUES ('NULL', '$_POST[nama]', '$_POST[usr]', md5('$_POST[nim]'),'$_POST[nim]','2')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT nim FROM mahasiswa WHERE nim=$_POST[nim]");
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
            window.location = "?page=mahasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	} else {
		$message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=mahasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	}

	if (!$err and $connection->query($sql2)) {
		$message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=mahasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	} else {
		$message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=mahasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	}
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM mahasiswa WHERE nim=$_GET[key]");
	$connection->query("DELETE FROM user WHERE nim=$_GET[key]");
	$message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=mahasiswa";
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
										<label for="nim">NIM</label>
										<input type="text" name="nim" class="form-control" <?= (!$update) ?: 'value="' . $row["nim"] . '"' ?> required>
									</div>
									<div class="form-group">
										<label for="nama">Nama Lengkap</label>
										<input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> required>
									</div>
									<div class="form-group">
										<label for="nama">Username</label>
										<input type="text" name="usr" class="form-control" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?> required>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat</label>
										<input type="text" name="alamat" class="form-control" <?= (!$update) ?: 'value="' . $row["alamat"] . '"' ?> required>
									</div>
									<div class="form-group">
										<label for="jenis_kelamin">Jenis Kelamin</label>
										<select class="form-control" name="jenis_kelamin">
											<option>---</option>
											<option value="Laki-laki" <?= (!$update) ?: (($row["jenis_kelamin"] != "Laki-laki") ?: 'selected="on"') ?>>Laki-laki</option>
											<option value="Perempuan" <?= (!$update) ?: (($row["jenis_kelamin"] != "Perempuan") ?: 'selected="on"') ?>>Perempuan</option>
										</select>
									</div><br>
									<button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
									<?php if ($update) : ?>
										<a href="?page=mahasiswa" class="btn btn-dark btn-block">Batal</a>
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
								<h3 class="text-center">DAFTAR MAHASISWA</h3>
							</div>
							<div class="panel-body">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>No</th>
											<th>NIM</th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Jenis Kelamin</th>
											<th>Tahun</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php if ($query = $connection->query("SELECT * FROM mahasiswa")) : ?>
											<?php while ($row = $query->fetch_assoc()) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $row['nim'] ?></td>
													<td><?= $row['nama'] ?></td>
													<td><?= $row['alamat'] ?></td>
													<td><?= $row['jenis_kelamin'] ?></td>
													<td><?= $row['tahun_mengajukan'] ?></td>
													<td>
														<div class="btn-group">
															<a href="?page=mahasiswa&action=update&key=<?= $row['nim'] ?>" class="btn btn-primary btn-xs">Edit</a>
															<a href="?page=mahasiswa&action=delete&key=<?= $row['nim'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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