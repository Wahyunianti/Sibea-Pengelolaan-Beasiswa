<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
//kode untuk select data beasiswa guna update
if ($update) {
    $sql = $connection->query("SELECT * FROM info_umum WHERE id_umum='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    if ($update) {
        //kode untuk update nama beasiswa yang ditambahkan
        $sql = "UPDATE info_umum SET keterangan='$_POST[ket]', informasi='$_POST[inpone]' WHERE id_umum='$_GET[key]'";
    } else {
        //kode untuk menambahkan nama beasiswa yang diinputkan
        $sql = "INSERT INTO info_umum VALUES (NULL, '$_POST[ket]', '$_POST[inpone]')";
        $validasi = true;
    }

    //kode untuk memvalidasi nama beasiswa sudah ada atau belum
    if ($validasi) {
        $q = $connection->query("SELECT id_umum FROM info_umum WHERE keterangan LIKE '%$_POST[ket]%'");
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
            window.location = "?page=info_png";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
    } else {
        $message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=info_png";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM info_umum WHERE id_umum='$_GET[key]'");
    $message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=info_png";
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
                                    <div class="form-group">
                                        <label for="nama">Keterangan</label>
                                        <input type="text" name="ket" class="form-control" <?= (!$update) ?: 'value="' . $row["keterangan"] . '"' ?>>
                                    </div><br>
                                    <?php if (!$update) : ?>
                                        <div class="form-group">
                                            <label for="mulai">Informasi</label>
                                            <textarea class="form-control" name="inpone" id="exampleFormControlTextarea1" rows="10"></textarea>
                                        </div><br>
                                    <?php endif; ?>
                                    <?php if ($update) : ?>
                                        <div class="form-group">
                                            <label for="mulai">Informasi</label>
                                            <textarea class="form-control" name="inpone" id="exampleFormControlTextarea1" rows="10"> <?= (!$update) ?: $row["informasi"] ?></textarea>
                                        </div><br>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
                                    <?php if ($update) : ?>
                                        <a href="?page=info_png" class="btn btn-info btn-block">Batal</a>
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
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="text-center">Informasi Umum</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ket.</th>
                                            <th>Informasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- kode untuk menampilkan data beasiswa dari tabel beasiswa pada tabel daftar!-->
                                        <?php $no = 1; ?>
                                        <?php if ($query = $connection->query("SELECT * FROM info_umum")) : ?>
                                            <?php while ($row = $query->fetch_assoc()) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $row['keterangan'] ?></td>
                                                    <td><?= $row['informasi'] ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="?page=info_png&action=update&key=<?= $row['id_umum'] ?>" class="btn btn-primary btn-xs">Edit</a>
                                                            <a href="?page=info_png&action=delete&key=<?= $row['id_umum'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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