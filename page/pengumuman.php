<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row g-3 mt-2">
                    <div class="col-12 col-md-7 col-lg-12 col-xl-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                Informasi Perguruan Tinggi
                            </div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="https://psdkukediri.polinema.ac.id/wp-content/uploads/2021/05/IMG_3665-edit-min-scaled.jpg" class="img-fluid rounded-start" style="max-width: 100%;height: auto;margin-block-start: auto;margin-left: 20;margin-bottom: 10;padding-top: 20;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body" style="margin-left: 20;">
                                        <h5 class="card-title">POLITEKNIK NEGERI MALANG</h5>
                                        <p class="card-text">Politeknik Negeri Malang (POLINEMA) adalah salah satu perguruan tinggi di Indonesia yang menyelenggarakan pendidikan tinggi vokasi. Didirikan pada tanggal 1 September 1964, POLINEMA berfokus pada pengembangan sumber daya manusia yang berkualitas di bidang teknik dan vokasi.
                                            POLINEMA terletak di Malang, Jawa Timur, Indonesia. Alamat lengkap dan informasi kontak dapat ditemukan di situs web resmi POLINEMA.
                                            <hr> Sebagai perguruan tinggi vokasi, POLINEMA menjalin kemitraan dengan berbagai industri untuk memberikan pengalaman praktis kepada mahasiswa. Program magang dan kerja sama proyek dengan perusahaan-perusahaan lokal maupun nasional merupakan bagian integral dari kurikulum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <?php $query = $connection->query("SELECT keterangan, informasi FROM info_umum");
        while ($row = $query->fetch_assoc()) : ?>
            <div class="row g-3 mt-2">
                <div class="col-12 col-md-7 col-lg-12 col-xl-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <?= $row['keterangan'] ?>
                        </div>
                        <div class="card-body">
                            <p>
                                <?= $row['informasi'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>