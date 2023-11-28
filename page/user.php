<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM user WHERE id_user='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;
    if ($update) {
        $sql = "UPDATE user u, akses_user a SET u.nama_user='$_POST[nama]', u.username='$_POST[usr]', u.id_akses=a.id_akses WHERE u.id_user='$_GET[key]' and a.akses_id='$_POST[ida]'";
    } else {
        $value = '';
        if(isset($_POST['ida']) == 'admin'){
            $value = 1;
        }if(isset($_POST['ida']) == 'penguji'){
            $value = 3;
        }else{
            $value = 2;
        }
        $sql = "INSERT INTO user VALUES ('null', '$_POST[nama]', '$_POST[usr]', md5('$_POST[pwd]'), 'null', '$value')";
        $validasi = true;
    }

    if ($validasi) {
        $q = $connection->query("SELECT id_user FROM user WHERE username LIKE '%$_POST[usr]%'");
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
            window.location = "?page=user";
        });';
        echo "<script type='text/javascript'>$message</script>";
	
    } else {
        $message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=user";
        });';
        echo "<script type='text/javascript'>$message</script>";
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM user WHERE id_user=$_GET[key]");
    $message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=user";
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
                                        <label for="nama">Nama User</label>
                                        <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="' . $row["nama_user"] . '"' ?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Username</label>
                                        <input type="text" name="usr" class="form-control" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?>>
                                    </div>
                                    <?php if (!$update) : ?>
                                    <div class="form-group">
                                        <label for="pwd">Password</label>
                                        <input type="text" name="pwd" class="form-control" <?= (!$update) ?: 'value="' . $row["password"] . '"' ?>>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="ida">Akses</label>
                                        <select class="form-select" aria-label="Default select example" name="ida" <?= (!$update) ?: $row["id_akses"] ?>>
                                            <?php $query = $connection->query("SELECT * FROM akses_user");
                                            while ($row = $query->fetch_assoc()) : ?>
                                                <option name="ida"><?= $row["akses_id"]; ?> </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div><br>
                                    <button type="submit" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block">Simpan</button>
                                    <?php if ($update) : ?>
                                        <a href="?page=user" class="btn btn-info btn-block">Batal</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="text-center">DAFTAR USER</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Akses</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php if ($query = $connection->query("SELECT * FROM user")) : ?>
                                            <?php while ($row = $query->fetch_assoc()) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $row['nama_user'] ?></td>
                                                    <td><?= $row['username'] ?></td>
                                                    <td><?= $row['id_akses'] ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="?page=user&action=update&key=<?= $row['id_user'] ?>" class="btn btn-primary btn-xs">Edit</a>
                                                            <a href="?page=user&action=delete&key=<?= $row['id_user'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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