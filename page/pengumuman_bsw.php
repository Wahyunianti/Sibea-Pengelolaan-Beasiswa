
<div class="row">
    <div class="col-md-12">
        <?php if (isset($_GET["beasiswa"])) {
            $sqlKriteria = "";
            $namaKriteria = [];
            $query = $connection->query("SELECT i.deskripsi FROM info_bsw i, beasiswa b WHERE i.id_beasiswa=$_GET[beasiswa]"); ?>
            <?php while ($row = $query->fetch_assoc()) : ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="text-center">
                            <h2 class="text-center"><?php $query = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa=$_GET[beasiswa]");
                                                    echo $query->fetch_assoc()["nama"]; ?></h2>
                        </h3>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-12 col-md-12 col-xl-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                Persyaratan Beasiswa
                            </div>
                            <div class="card-body">
                                <p>
                                    <?= $row['deskripsi'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        <?php } else { ?>
            <h1>Beasiswa belum dipilih...</h1>
        <?php } ?>
    </div>
</div>