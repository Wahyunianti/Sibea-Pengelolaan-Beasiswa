<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
//kode untuk memilih data kriteria beasiswa yang akan diupdate 
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM kriteria WHERE kd_kriteria='$_GET[key]'");
	$row = $sql->fetch_assoc();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false;
	$err = false;

	//kode untuk update dan tambah data kriteria beasiswa berdasarkan kode primary key
	if ($update) {
		$sql = "UPDATE kriteria SET kd_beasiswa=$_POST[kd_beasiswa], nama='$_POST[nama]', sifat='Max' WHERE kd_kriteria='$_GET[key]'";
	} else {
		$sql = "INSERT INTO kriteria VALUES (NULL, $_POST[kd_beasiswa], '$_POST[nama]', 'Max')";
		$validasi = true;
	}

	//kode untuk select data kriteria pada tabel kriteria
	if ($validasi) {
		$q = $connection->query("SELECT kd_kriteria FROM kriteria WHERE kd_beasiswa=$_POST[kd_beasiswa] AND nama LIKE '%$_POST[nama]%'");
		if ($q->num_rows) {
			$err = true;
		}
	}

	//jika koneksi berhasil maka akan tampilkan halaman kriteria
	if (!$err and $connection->query($sql)) {
		$message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=kriteria";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
	} else {
		$message = 'swal(
            "Gagal",
            "Update Data",
            "failed"
        ).then(function() {
            window.location = "?page=kriteria";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
	}
}

//kode untuk menghapus data kriteria pada tabel
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM kriteria WHERE kd_kriteria='$_GET[key]'");
	$message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=kriteria";
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
										<select class="form-control" name="kd_beasiswa" required>
											<?php $query = $connection->query("SELECT * FROM beasiswa");
											while ($data = $query->fetch_assoc()) : ?>
												<option value="<?= $data["kd_beasiswa"] ?>" <?= (!$update) ?: (($row["kd_beasiswa"] != $data["kd_beasiswa"]) ?: 'selected="on"') ?>><?= $data["nama"] ?></option>
											<?php endwhile; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="nama">Nama</label>
										<input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> required>
									</div><br>
									<button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
									<!-- jika update data dibatalkan maka akan kembali pada halaman kriteria -->
									<?php if ($update) : ?>
										<a href="?page=kriteria" class="btn btn-dark btn-block">Batal</a>
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
								<h3 class="text-center">DAFTAR KRITERIA</h3>
							</div>
							<div class="panel-body">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>No</th>
											<th>Beasiswa</th>
											<th>Kriteria</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<!-- kode untuk select tabel  -->
										<?php $no = 1; ?>
										<?php if ($query = $connection->query("SELECT a.nama AS kriteria, b.nama AS beasiswa, a.kd_kriteria, a.sifat FROM kriteria a JOIN beasiswa b USING(kd_beasiswa)")) : ?>
											<?php while ($row = $query->fetch_assoc()) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $row['beasiswa'] ?></td>
													<td><?= $row['kriteria'] ?></td>
													<td>
														<div class="btn-group">
															<a href="?page=kriteria&action=update&key=<?= $row['kd_kriteria'] ?>" class="btn btn-primary btn-xs">Edit</a>
															<a href="?page=kriteria&action=delete&key=<?= $row['kd_kriteria'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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