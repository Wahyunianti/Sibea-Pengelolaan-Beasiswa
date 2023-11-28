<?php
require_once "config.php";
$sesi = $_SESSION["admin_username"];
$ino = $connection->query("SELECT nim from user where username='$sesi'");
$getpwd = $ino->fetch_assoc()["nim"];
?>
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
        $sql2 = "UPDATE user SET nama_user='$_POST[nama]', username='$_POST[usr]' WHERE password='$_GET[key]'";
        $connection->query($sql);
        $connection->query($sql2);
    } else {
        $sql = "INSERT INTO mahasiswa VALUES ('$_POST[nim]', '$_POST[nama]', '$_POST[usr]', '$_POST[alamat]', '$_POST[jenis_kelamin]', '" . date("Y") . "')";
        $sql2 = "INSERT INTO user VALUES ('NULL', '$_POST[nama]', '$_POST[usr]', '$_POST[nim]', '1')";
        $connection->query($sql);
        $connection->query($sql2);
        $validasi = true;
    }
    if ($validasi) {
        $q = $connection->query("SELECT nim FROM mahasiswa WHERE nim=$_POST[nim]");
        if ($q->num_rows) {
            echo alert($_POST["nim"] . " sudah terdaftar!", "?page=data_mhs");
            $err = true;
        }
    }
    if (!$err) {
        $message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=data_mhs";
        });';
        echo "<script type='text/javascript'>$message</script>";
    } else {
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM mahasiswa WHERE nim=$_GET[key]");
}
?>

<div class="container">
    <div class="row g-3 mt-2">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h3 class="mb-4">Edit Data Mahasiswa</h3>
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                        <div class="row">
                            <?php if ($query = $connection->query("SELECT * FROM mahasiswa where nim = '$getpwd'")) : ?>
                                <?php while ($row = $query->fetch_assoc()) : ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nim</label>
                                            <input type="text" name="nim" class="form-control" value="<?= $row['nim'] ?>" <?= (!$update) ?: 'value="' . $row["nim"] . '"' ?> readonly="on">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="usr" class="form-control" value="<?= $row['username'] ?>" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?> readonly="on">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <?php if (!$update) : ?>
                                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> readonly="on">
                                            <?php else : ?>
                                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?>>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <?php if (!$update) : ?>
                                                <input type="text" name="alamat" class="form-control" value="<?= $row['alamat'] ?>" <?= (!$update) ?: 'value="' . $row["alamat"] . '"' ?> readonly="on">
                                            <?php else : ?>
                                                <input type="text" name="alamat" class="form-control" value="<?= $row['alamat'] ?>" <?= (!$update) ?: 'value="' . $row["alamat"] . '"' ?>>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (!$update) : ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <input type="text" name="alamat" class="form-control" value="<?= $row['jenis_kelamin'] ?>" readonly="on">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($update) : ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelamin">
                                                    <option>---</option>
                                                    <option value="Laki-laki" <?= (!$update) ?: (($row["jenis_kelamin"] != "Laki-laki") ?: 'selected="on"') ?>>Laki-laki</option>
                                                    <option value="Perempuan" <?= (!$update) ?: (($row["jenis_kelamin"] != "Perempuan") ?: 'selected="on"') ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endwhile ?>
                            <?php endif ?>

                        </div><br>
                        <div>
                            <?php if (!$update) : ?>
                                <a href="?page=data_mhs&action=update&key=<?= $getpwd ?>" class="btn btn-light btn-xs">Edit</a><?php endif; ?>
                            <?php if ($update) : ?>
                                <button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>