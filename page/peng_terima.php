<?php
require_once "config.php";
$sesi = $_SESSION["admin_username"];
$ino = $connection->query("SELECT nim from user where username='$sesi'");
$getpwd = $ino->fetch_assoc()["nim"];
?>

<div class="row">
    <div class="col-md-12">
            <?php $query = $connection->query("SELECT b.*, n.status AS statue, m.nama AS namih, h.nilai AS hasill FROM beasiswa b LEFT JOIN nilai n ON b.kd_beasiswa = n.kd_beasiswa INNER JOIN mahasiswa m ON m.nim = n.nim INNER JOIN hasil h ON m.nim = h.nim WHERE n.nim='$getpwd' AND n.status='Diterima' GROUP BY b.kd_beasiswa");
            while ($row = $query->fetch_assoc()) : ?>
                <div class="row g-3 mt-2">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                <div class="row">
                                    <div class="col d-flex justify-content-start" name="bsw">
                                        <h3>Anda Diterima <?= $row['nama'] ?></h3>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <a href="page/cetak3.php" target="_blank" class="btn btn-dark"><i class="fa fa-file-pdf-o"></i> &nbsp CETAK</a>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body" name="nama">
                                <p>
                                    Selamat, <?= $row['namih'] ?> Anda telah diterima di beasiswa ini dengan total nilai <?= $row['hasill'] ?>, silahkan cetak surat panggilan penerimaan beasiswa.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
    </div>
</div>