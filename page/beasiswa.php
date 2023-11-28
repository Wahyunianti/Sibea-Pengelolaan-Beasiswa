<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
//kode untuk select data beasiswa guna update
if ($update) {
	$sql = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false;
	$err = false;
	if ($update) {
		//kode untuk update nama beasiswa yang ditambahkan
		$sql = "UPDATE beasiswa SET nama='$_POST[nama]', kuota=$_POST[kuota], mulai='$_POST[mulai]', tutup='$_POST[tutup]' WHERE kd_beasiswa='$_GET[key]'";
	} else {
		//kode untuk menambahkan nama beasiswa yang diinputkan
		$sql = "INSERT INTO beasiswa VALUES (NULL, '$_POST[nama]', '$_POST[kuota]', '$_POST[mulai]', '$_POST[tutup]')";
		$validasi = true;
	}

	//kode untuk memvalidasi nama beasiswa sudah ada atau belum
	if ($validasi) {
		$q = $connection->query("SELECT kd_beasiswa FROM beasiswa WHERE nama LIKE '%$_POST[nama]%'");
		if ($q->num_rows) {
			$err = true;
		}
	}

	//jika koneksi berhasil maka akan diarahkan ulang ke halaman beasiswa
	if (!$err and $connection->query($sql)) {
		$message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=beasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
	} else {
		$message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=beasiswa";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
	}
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM beasiswa WHERE kd_beasiswa='$_GET[key]'");
	$message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=beasiswa";
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
										<label for="nama">Nama</label>
										<input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?>>
									</div>
									<div class="form-group">
										<label for="kuota">Kuota</label>
										<input type="text" name="kuota" class="form-control" <?= (!$update) ?: 'value="' . $row["kuota"] . '"' ?>>
									</div>
									<div class="form-group">
										<label for="mulai">Tanggal Dibuka</label>
										<input type="date" name="mulai" class="form-control" <?= (!$update) ?: 'value="' . $row["mulai"] . '"' ?>>
									</div>
									<div class="form-group">
										<label for="tutup">Tanggal Ditutup</label>
										<input type="date" name="tutup" class="form-control" <?= (!$update) ?: 'value="' . $row["tutup"] . '"' ?>>
									</div><br>
									<button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
									<?php if ($update) : ?>
										<a href="?page=beasiswa" class="btn btn-dark btn-block">Batal</a>
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
											<th>Nama</th>
											<th>Dibuka</th>
											<th>Ditutup</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<!-- kode untuk menampilkan data beasiswa dari tabel beasiswa pada tabel daftar!-->
										<?php $no = 1; ?>
										<?php if ($query = $connection->query("SELECT * FROM beasiswa")) : ?>
											<?php while ($row = $query->fetch_assoc()) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $row['nama'] ?></td>
													<td><?= $row['mulai'] ?></td>
													<td><?= $row['tutup'] ?></td>
													<td><?php
														$paymentDate = date('Y-m-d');
														$paymentDate = date('Y-m-d', strtotime($paymentDate));
														//echo $paymentDate; // echos today! 
														$contractDateBegin = $row['mulai'];
														$contractDateEnd = $row['tutup'];

														if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
															echo "Aktif";
														} else {
															echo "Nonaktif";
														}
														?></td>
													<td>
														<div class="btn-group">
															<a href="?page=beasiswa&action=update&key=<?= $row['kd_beasiswa'] ?>" class="btn btn-primary btn-xs">Edit</a>
															<a href="?page=beasiswa&action=delete&key=<?= $row['kd_beasiswa'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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