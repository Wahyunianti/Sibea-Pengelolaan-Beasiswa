<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
//kode untuk select data beasiswa guna update
if ($update) {
    $sql = $connection->query("SELECT * FROM info_bsw WHERE id_info='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    if ($update) {
        //kode untuk update nama beasiswa yang ditambahkan
        $sql = "UPDATE info_bsw SET deskripsi='$_POST[desc]'  WHERE id_info='$_GET[key]'";
    } else {
        //kode untuk menambahkan nama beasiswa yang diinputkan
        $sql = "INSERT INTO info_bsw VALUES (NULL, '$_POST[idb]', '$_POST[desc]')";
        $validasi = true;
    }

    //kode untuk memvalidasi nama beasiswa sudah ada atau belum
    if ($validasi) {
        $q = $connection->query("SELECT id_info FROM info_bsw WHERE id_beasiswa LIKE '%$_POST[idb]%'");
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
            window.location = "?page=info_bsw";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
    } else {
        $message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=info_bsw";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM info_bsw WHERE id_info='$_GET[key]'");
    $message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=info_bsw";
    });';
    echo "<script type='text/javascript'>$message</script>";

}

?>
<div class="row">    
<div class="row g-3 mt-2">
        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
    <div class="col-lg-12">
        <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
            <div class="panel-heading">
                <h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php if (!$update) : ?>
                    <div class="form-group">
                        <label for="idb">Id Beasiswa</label>
                        <select class="form-select" name="idb" aria-label="Default select example" <?= (!$update) ?: $row["id_beasiswa"]?>>
                        <?php $query = $connection->query("SELECT b.* FROM beasiswa b LEFT JOIN info_bsw i ON b.kd_beasiswa = i.id_beasiswa WHERE i.id_info IS NULL");
                         while ($data = $query->fetch_assoc()) : ?>
                            <!-- <option name="idb"><?= $row["kd_beasiswa"] ?></option> -->
                            <option value="<?= $data["kd_beasiswa"] ?>" <?= (!$update) ? "" : (($row["kd_beasiswa"] != $data["kd_beasiswa"]) ? "" : 'selected="selected"') ?>><?= $data["nama"] ?></option>
                        <?php endwhile; ?>
                        </select>
                        </div><br>
                    <?php endif; ?>
                    <?php if (!$update) : ?>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label><br>
                        <textarea class="form-control" name="desc" id="exampleFormControlTextarea1" rows="10" required></textarea>
                        
                    </div>
                    <?php endif; ?>
                    <?php if ($update) : ?>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label><br>
                        <textarea class="form-control" name="desc" id="exampleFormControlTextarea1" rows="10"> <?= (!$update) ?: $row["deskripsi"] ?> required</textarea>
                        
                    </div>
                    <?php endif; ?>
                    <br>
                    <button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
                    <?php if ($update) : ?>
                        <a href="?page=info_bsw" class="btn btn-dark btn-block">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div></div></div>
    </div>
    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="text-center">Informasi Beasiswa</h3>
            </div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- kode untuk menampilkan data beasiswa dari tabel beasiswa pada tabel daftar!-->
                        <?php $no = 1; ?>
                        <?php if ($query = $connection->query("SELECT i.id_info as inpo, i.id_beasiswa as inpone, b.nama as nami, i.deskripsi as deskripsih FROM beasiswa b, info_bsw i where i.id_beasiswa=b.kd_beasiswa")) : ?>
                            <?php while ($row = $query->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nami'] ?></td>
                                    <td><?= $row['deskripsih'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="?page=info_bsw&action=update&key=<?= $row['inpo'] ?>" class="btn btn-primary btn-xs">Edit</a>
                                            <a href="?page=info_bsw&action=delete&key=<?= $row['inpo'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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
                </div></div></div></div>
</div>