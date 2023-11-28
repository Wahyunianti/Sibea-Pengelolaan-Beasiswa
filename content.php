
                <!-- start: Sidebar -->
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo text-uppercase fw-bold text-decoration-none text-indigo fs-4">SIBEA</a>
            <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
        </div>
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <?php if (in_array("kl_user", $_SESSION['admin_akses'])) { ?>
            <li class="sidebar-menu-item active">
                <a href="?page=homea">
                    <i class="ri-home-5-line sidebar-menu-item-icon"></i>
                    Beranda
                </a>
            </li>
            <?php } ?>
            <?php if (in_array("a_penguji", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-scales-3-line sidebar-menu-item-icon"></i>
                        Assesment
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <?php $query = $connection->query("SELECT * FROM beasiswa");
                        while ($row = $query->fetch_assoc()) : ?>
                            <li><a href="?page=perhitungan2&beasiswa=<?= $row["kd_beasiswa"] ?>"><?= $row["nama"] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("m_bsw", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item">
                    <a href="?page=data_mhs">
                        <i class="ri-contacts-line sidebar-menu-item-icon"></i>
                        Data Mahasiswa
                    </a>
                </li>
            <?php } ?>
            <?php if (in_array("kl_user", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item">
                    <a href="?page=user">
                        <i class="ri-group-line sidebar-menu-item-icon"></i>
                        Kelola User
                    </a>
                </li>
            <?php } ?>
            
            <?php if (in_array("m_bsw", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item">
                    <a href="?page=daftar_bsw">
                        <i class="ri-git-repository-commits-line sidebar-menu-item-icon"></i>
                        Daftar Beasiswa
                    </a>
                </li>
            <?php } ?>
            <?php if (in_array("m_bsw", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item">
                    <a href="?page=peng_terima">
                        <i class="ri-award-line sidebar-menu-item-icon"></i>
                        Pengumuman
                    </a>
                </li>
            <?php } ?>
            <?php if (in_array("m_srt", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-draft-line sidebar-menu-item-icon"></i>
                        Syarat & Ketentuan
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <?php $query = $connection->query("SELECT * FROM beasiswa");
                        while ($row = $query->fetch_assoc()) : ?>
                            <li><a href="?page=pengumuman_bsw&beasiswa=<?= $row["kd_beasiswa"] ?>"><?= $row["nama"] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("a_rank", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-bar-chart-2-line sidebar-menu-item-icon"></i>
                        Hasil Ranking
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <?php $query = $connection->query("SELECT * FROM beasiswa");
                        while ($row = $query->fetch_assoc()) : ?>
                            <li><a href="?page=perhitungan&beasiswa=<?= $row["kd_beasiswa"] ?>"><?= $row["nama"] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("a_lprn", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-folder-info-line sidebar-menu-item-icon"></i>
                        Kelola Informasi
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=info_bsw">
                                Informasi Beasiswa
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=info_png">
                                Informasi Umum
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("a_klbsw", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-book-3-line sidebar-menu-item-icon"></i>
                        Kelola Data Beasiswa
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=beasiswa">
                                Data Beasiswa
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=mahasiswa">
                                Data Mahasiswa
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=kriteria">
                                Kriteria
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=model">
                                Model
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=penilaian">
                                Penilaian
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=nilai">
                                Daftar Pendaftar
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("a_lprn", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-file-text-line sidebar-menu-item-icon"></i>
                        Laporan
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=lap_pendaftaran">
                                Daftar Mahasiswa
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=penerima">
                                Keseluruhan
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("a_penguji2", $_SESSION['admin_akses'])) { ?>
                <li class="sidebar-menu-item has-dropdown">
                    <a href="#">
                        <i class="ri-file-info-line sidebar-menu-item-icon"></i>
                        Laporan
                        <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                    </a>
                    <ul class="sidebar-dropdown-menu">
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=lap_pendaftaran">
                                Daftar Mahasiswa
                            </a>
                        </li>
                        <li class="sidebar-dropdown-menu-item">
                            <a href="?page=penerima">
                                Keseluruhan
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li class="sidebar-menu-item">
                <a href="logout.php">
                    <i class="ri-door-open-line sidebar-menu-item-icon"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- end: Sidebar -->