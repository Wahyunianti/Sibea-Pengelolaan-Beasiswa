<?php
require_once "config.php";
$sesi = $_SESSION["admin_username"];
$ino = $connection->query("SELECT nim from user where username='$sesi'");
$getpwd = $ino->fetch_assoc()["nim"];
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?
?>
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
        $query = "INSERT INTO nilai (kd_nilai, kd_beasiswa, kd_kriteria, nim, nilai, berkas) VALUES ";
        foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
            $query .= "(NULL, '$_POST[kd_beasiswa]', '$kd_kriteria', '$_POST[nim]', '$nilai', '$_POST[berkas]'),";
        }
        $sql = rtrim($query, ',');
        $validasi = true;
    }

    if ($validasi) {
        foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
            $q = $connection->query("SELECT kd_nilai FROM nilai WHERE kd_beasiswa=$_POST[kd_beasiswa] AND kd_kriteria=$kd_kriteria AND nim=$_POST[nim] AND nilai LIKE '%$nilai%'");
            if ($q->num_rows) {
                $err = true;
            }
        }
    }

    if (!$err and $connection->query($sql)) {
        $message = 'swal(
            "Sukses",
            "Update Data",
            "success"
        ).then(function() {
            window.location = "?page=daftar_bsw";
        });';
        echo "<script type='text/javascript'>$message</script>";
    } else {
        $message = 'swal(
            "Gagal",
            "Update Data",
            "error"
        ).then(function() {
            window.location = "?page=daftar_bsw";
        });';
        echo "<script type='text/javascript'>$message</script>";
    }
}

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM nilai WHERE kd_nilai='$_GET[key]'");
    $message = 'swal(
        "Sukses",
        "Hapus Data",
        "success"
    ).then(function() {
        window.location = "?page=daftar_bsw";
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
                                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
                                    <div class="form-group">
                                        <label for="nim">Mahasiswa</label>
                                        <input type="text" name="nim" value="<?= $getpwd ?>" class="form-control" <?= (!$update) ?: 'value="' . $row["nim"] . '"'  ?> readonly="on">
                                    </div>
                                    <div class="form-group">
                                        <label for="kd_beasiswa">Beasiswa</label>
                                        <?php
                                        $krik = isset($_POST["kd_beasiswa"]);
                                        if ($_POST) :
                                            if (empty($krik)) {
                                                $message = 'swal(
                                                    "Gagal",
                                                    "Data tidak ada",
                                                    "error"
                                                ).then(function() {
                                                    window.location = "?page=daftar_bsw";
                                                });';
                                                echo "<script type='text/javascript'>$message</script>";
                                            } else {
                                                $q = $connection->query("SELECT nama FROM beasiswa WHERE kd_beasiswa=$_POST[kd_beasiswa]");
                                            }
                                        ?>
                                            <input type="text" value="<?= $q->fetch_assoc()["nama"] ?>" class="form-control" readonly="on">
                                            <input type="hidden" name="kd_beasiswa" value="<?= $_POST["kd_beasiswa"] ?>">
                                        <?php else : ?>

                                            <select class="form-control" id="beasiswa" name="kd_beasiswa">
                                                <?php $sequel = $connection->query("SELECT b.nama as nami, b.kd_beasiswa as biba, babi.kd_kriteria AS bebi, k.kd_kriteria FROM kriteria k LEFT JOIN beasiswa b ON b.kd_beasiswa = k.kd_beasiswa LEFT JOIN 
(SELECT n.* FROM nilai n, beasiswa b WHERE n.kd_beasiswa = b.kd_beasiswa AND nim=$getpwd) AS babi ON babi.kd_kriteria = k.kd_kriteria WHERE babi.kd_kriteria IS NULL GROUP BY b.kd_beasiswa");
                                                while ($duta = $sequel->fetch_assoc()) : ?>
                                                    <option name="kd_beasiswa" value="<?= $duta["biba"] ?>" <?= (!$update) ? "" : (($row["kd_beasiswa"] != $duta["biba"]) ? "" : 'selected="selected"') ?>><?= $duta["nami"] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        <?php endif; ?>

                                    </div>
                                    <?php if ($_POST) : ?>
                                        <?php $q = $connection->query("SELECT b.kd_beasiswa, k.kd_kriteria as krik, k.nama as namih FROM kriteria k LEFT JOIN beasiswa b ON b.kd_beasiswa = k.kd_beasiswa LEFT JOIN 
(SELECT n.* FROM nilai n, beasiswa b WHERE n.kd_beasiswa = b.kd_beasiswa AND nim=$getpwd) AS babi ON babi.kd_kriteria = k.kd_kriteria WHERE babi.kd_kriteria IS NULL AND b.kd_beasiswa=$_POST[kd_beasiswa]");
                                        while ($r = $q->fetch_assoc()) : ?>
                                            <div class="form-group">
                                                <label for="nilai"><?= ucfirst($r["namih"]) ?></label>
                                                <select class="form-control" name="nilai[<?= $r["krik"] ?>]" id="nilai">
                                                    <option>---</option>
                                                    <?php $sql = $connection->query("SELECT * FROM penilaian WHERE kd_kriteria=$r[krik]");
                                                    while ($data = $sql->fetch_assoc()) : ?>
                                                        <option value="<?= $data["bobot"] ?>" class="<?= $data["kd_kriteria"] ?>" <?= (!$update) ? "" : (($row["kd_penilaian"] != $data["kd_penilaian"]) ? "" : ' selected="selected"') ?>><?= $data["keterangan"] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="berkas">Berkas Persyaratan</label>
                                                <input type="text" name="berkas" class="form-control" <?= (!$update) ?: 'value="' . $row["berkas"] . '"' ?>>
                                            </div>
                                            <input type="hidden" name="save" value="true">
                                        <?php endwhile; ?>

                                    <?php endif; ?>
                                    <br>
                                    <button type="submit" id="simpan" class="btn btn-<?= ($update) ? "light" : "light" ?> btn-block" ><?= ($_POST) ? "Simpan" : "Tampilkan" ?></button>
                                    <?php if ($update) : ?>
                                        <a href="?page=daftar_bsw" class="btn btn-info btn-block">Batal</a>
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
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="https://live.staticflickr.com/65535/52962504060_e62fff12c0_q.jpg" class="img-fluid rounded-start h-70">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php $query = $connection->query("SELECT * FROM mahasiswa WHERE nim='$getpwd'");
                                                                    echo $query->fetch_assoc()["nama"]; ?></h5>
                                            <p class="card-text"><small class="text-muted"><?= $getpwd ?></small></p>
                                            <p class="card-text"><?php $query = $connection->query("SELECT * FROM mahasiswa WHERE nim='$getpwd'");
                                                                    echo $query->fetch_assoc()["alamat"]; ?></p>

                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                            <th style="width: 20%;">Nilai</th>
                                            <th style="width: 20%;">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>

                                        <?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama AS nama_beasiswa, b.nama AS nama_kriteria, d.nim, d.nama AS nama_mahasiswa, a.nilai, a.status as statue FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim where d.nim='$getpwd'")) : ?>
                                            <?php while ($row = $query->fetch_assoc()) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $row['nama_beasiswa'] ?></td>
                                                    <td><?= $row['nama_kriteria'] ?></td>
                                                    <td><?= $row['nilai'] ?></td>
                                                    <td><?= $row['statue'] ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <!-- <a href="?page=daftar_bsw&action=update&key=<?= $row['kd_nilai'] ?>" class="btn btn-warning btn-xs">Edit</a> -->
                                                            <a href="?page=daftar_bsw&action=delete&key=<?= $row['kd_nilai'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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
    $("#nilai").chained("#kriteria");
</script>