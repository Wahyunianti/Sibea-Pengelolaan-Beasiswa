-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 02:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsw_fix`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_halaman`
--

CREATE TABLE `akses_halaman` (
  `id_akses` int(10) NOT NULL,
  `halaman_akses` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akses_halaman`
--

INSERT INTO `akses_halaman` (`id_akses`, `halaman_akses`) VALUES
(1, 'a_klbsw'),
(1, 'a_lprn'),
(1, 'a_rank'),
(1, 'kl_data'),
(1, 'kl_info'),
(1, 'kl_user'),
(2, 'kl_mhs'),
(2, 'm_bsw'),
(2, 'm_srt'),
(3, 'a_penguji'),
(3, 'a_penguji2');

-- --------------------------------------------------------

--
-- Table structure for table `akses_user`
--

CREATE TABLE `akses_user` (
  `id_akses` int(10) NOT NULL,
  `akses_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akses_user`
--

INSERT INTO `akses_user` (`id_akses`, `akses_id`) VALUES
(1, 'admin'),
(2, 'mahasiswa'),
(3, 'penguji');

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `kd_beasiswa` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kuota` int(11) NOT NULL,
  `mulai` date DEFAULT current_timestamp(),
  `tutup` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`kd_beasiswa`, `nama`, `kuota`, `mulai`, `tutup`) VALUES
(1, 'Beasiswa SMART Diploma', 3, '2023-06-16', '2023-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `kd_hasil` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `nim` char(10) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tahun` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`kd_hasil`, `kd_beasiswa`, `nim`, `nilai`, `tahun`) VALUES
(1, 1, '2131730117', 29, '2023'),
(2, 1, '2131730010', 75, '2023'),
(3, 1, '2131730112', 100, '2023'),
(4, 1, '2131730096', 42, '2023'),
(5, 1, '2131730135', 42, '2023');

-- --------------------------------------------------------

--
-- Table structure for table `info_bsw`
--

CREATE TABLE `info_bsw` (
  `id_info` int(11) NOT NULL,
  `id_beasiswa` int(11) NOT NULL,
  `deskripsi` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_bsw`
--

INSERT INTO `info_bsw` (`id_info`, `id_beasiswa`, `deskripsi`) VALUES
(1, 1, '     Syarat Dan Ketentuan Beasiswa KIP :<br>\r\n- IPK<br>\r\n- KTP Domisli Malang<br>'),
(2, 2, 'Syarat Dan Ketentuan Beasiswa SMART Diploma:\r\n- IPK\r\n- Semester\r\n- Penghasilan Ortu');

-- --------------------------------------------------------

--
-- Table structure for table `info_umum`
--

CREATE TABLE `info_umum` (
  `id_umum` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `informasi` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_umum`
--

INSERT INTO `info_umum` (`id_umum`, `keterangan`, `informasi`) VALUES
(1, 'Maksud & Tujuan', '  Beasiswa dalam suatu perguruan tinggi adalah bentuk bantuan keuangan yang diberikan kepada mahasiswa untuk membantu mereka dalam pembiayaan pendidikan mereka. Beasiswa ini dapat diberikan berdasarkan berbagai kriteria seperti prestasi akademik, prestasi non-akademik, kebutuhan finansial, atau faktor-faktor lain yang ditetapkan oleh lembaga pendidikan. <br><br>\r\n\r\nMaksud diadakannya beasiswa dalam suatu perguruan tinggi adalah untuk mencapai beberapa tujuan utama, antara lain:<br><br>\r\n\r\nAksesibilitas Pendidikan: Beasiswa membantu meningkatkan aksesibilitas pendidikan tinggi bagi individu yang mungkin menghadapi kendala finansial. Dengan memberikan bantuan keuangan kepada mahasiswa yang berprestasi atau memiliki kebutuhan finansial, beasiswa membantu mendorong partisipasi dan kesempatan pendidikan yang lebih luas.<br><br>\r\n\r\nPeningkatan Kualitas: Beasiswa dapat menjadi insentif bagi siswa yang berbakat dan berprestasi untuk masuk dan tetap berada dalam suatu perguruan tinggi. Dengan memberikan dukungan keuangan kepada siswa yang memiliki potensi, lembaga pendidikan dapat meningkatkan kualitas mahasiswanya dan mendorong tercapainya prestasi akademik yang lebih tinggi.<br><br>\r\n\r\nDiversitas dan Inklusivitas: Beasiswa juga dapat digunakan sebagai alat untuk mendorong keragaman dan inklusivitas di perguruan tinggi. Dengan memberikan beasiswa kepada siswa dari latar belakang yang beragam, seperti kelompok etnis minoritas, kelompok ekonomi lemah, atau kelompok marginal, lembaga pendidikan dapat menciptakan lingkungan belajar yang lebih inklusif dan mewakili.<br><br>\r\n\r\nPengembangan Sumber Daya Manusia Unggul: Melalui beasiswa, perguruan tinggi dapat membantu mendukung pembentukan sumber daya manusia yang berkualitas. Dengan memberikan kesempatan pendidikan kepada individu yang memiliki potensi, beasiswa membantu melahirkan lulusan yang berkualitas dan siap bersaing di pasar kerja.<br><br>\r\n\r\nResponsabilitas Sosial: Pemberian beasiswa juga mencerminkan tanggung jawab sosial perguruan tinggi terhadap masyarakat. Dalam masyarakat yang berkeadilan, lembaga pendidikan diharapkan turut berperan dalam memberikan kesempatan yang sama kepada semua individu, terlepas dari latar belakang sosial atau ekonomi mereka.<br><br>\r\n\r\nDalam kesimpulannya, tujuan utama diadakannya beasiswa dalam suatu perguruan tinggi adalah untuk meningkatkan aksesibilitas pendidikan, meningkatkan kualitas pendidikan, mendorong keragaman dan inklusivitas, mengembangkan sumber daya manusia berkualitas, dan menjalankan tanggung jawab sosial terhadap masyarakat.');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `kd_kriteria` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `sifat` enum('min','max') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`kd_kriteria`, `kd_beasiswa`, `nama`, `sifat`) VALUES
(1, 1, 'IPK', 'max'),
(2, 1, 'KTP Malang', 'max');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` char(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tahun_mengajukan` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `username`, `alamat`, `jenis_kelamin`, `tahun_mengajukan`) VALUES
('2131730010', 'Dhea Layna Agustiya', 'dea', 'Madiun', 'Perempuan', '2023'),
('2131730096', 'Regita Akhira Dewi Anjali', 'regita', 'Nganjuk', 'Perempuan', '2023'),
('2131730112', 'Royan Juan Aristya', 'oyan', 'Lamongan', 'Laki-laki', '2023'),
('2131730117', 'Wahyuni Anti', 'yuni', 'Ngampel', 'Perempuan', '2023'),
('2131730135', 'Muhammad Arif S.T.P', 'arif', 'Kediri', 'Laki-laki', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `kd_model` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `bobot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`kd_model`, `kd_beasiswa`, `kd_kriteria`, `bobot`) VALUES
(1, 1, 1, 50),
(2, 1, 2, 50);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `kd_nilai` int(11) NOT NULL,
  `kd_beasiswa` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nim` char(10) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `berkas` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`kd_nilai`, `kd_beasiswa`, `kd_kriteria`, `nim`, `nilai`, `berkas`, `status`) VALUES
(1, 1, 1, '2131730117', 1, '', 'Menunggu'),
(2, 1, 2, '2131730117', 1, '', 'Menunggu'),
(7, 1, 1, '2131730096', 2, '', 'Menunggu'),
(8, 1, 2, '2131730096', 1, '', 'Menunggu'),
(13, 1, 1, '2131730135', 2, 'https://drive.google.com/file/d/1vl0JpcKJiL0-nLXcHLPXOE0d-c7SLv9b/view?usp=drive_link', 'Menunggu'),
(14, 1, 2, '2131730135', 1, 'https://drive.google.com/file/d/1vl0JpcKJiL0-nLXcHLPXOE0d-c7SLv9b/view?usp=drive_link', 'Menunggu'),
(15, 1, 1, '2131730010', 2, 'https://drive.google.com/file/d/1RKihJvlBBEH0h4yn4PyDltT8EQZrTXk7/view?usp=drive_link', 'Diterima'),
(16, 1, 2, '2131730010', 3, 'https://drive.google.com/file/d/1RKihJvlBBEH0h4yn4PyDltT8EQZrTXk7/view?usp=drive_link', 'Diterima'),
(17, 1, 1, '2131730112', 1, 'https://drive.google.com/file/d/17sMNVsRNpqqZOsQHzqr_q_UGOfnprAP9/view?usp=drive_link', 'Menunggu'),
(18, 1, 2, '2131730112', 3, 'https://drive.google.com/file/d/17sMNVsRNpqqZOsQHzqr_q_UGOfnprAP9/view?usp=drive_link', 'Menunggu');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `kd_pengguna` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` enum('petugas','puket','mahasiswa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`kd_pengguna`, `username`, `password`, `status`) VALUES
(1, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'petugas'),
(2, 'puket', 'b679a71646e932b7c4647a081ee2a148', 'puket'),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `kd_penilaian` int(11) NOT NULL,
  `kd_beasiswa` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `bobot` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`kd_penilaian`, `kd_beasiswa`, `kd_kriteria`, `keterangan`, `bobot`) VALUES
(1, 1, 1, '3.00 - 3.20', 1),
(2, 1, 1, '3.21 - 3.40', 2),
(3, 1, 1, '3.41 - 3.60', 3),
(4, 1, 1, '>= 3.61', 4),
(5, 1, 2, 'ya', 3),
(6, 1, 2, 'tidak', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `id_akses` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `nim`, `id_akses`) VALUES
(4, 'firdaus', 'uus', 'a6e8c26fdaeff2c0230f864ccbc610d2', '', 1),
(24, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 1),
(25, 'Penguji', 'penguji', '827ccb0eea8a706c4c34a16891f84e7b', '', 3),
(29, 'Royan Juan Aristya', 'oyan', '483701356ee8c24d918371e5759bdd1c', '2131730112', 2),
(30, 'Dhea Layna Agustiya', 'dea', 'ba1ad6293f8c791227d5de29898de6b7', '2131730010', 2),
(31, 'Wahyuni Anti', 'yuni', '166acd9668a5c346efc7a1d1eaa35583', '2131730117', 2),
(32, 'Regita Akhira Dewi Anjali', 'regita', '66793f4a2297c200dbecf52e3ef0e6a0', '2131730096', 2),
(33, 'Muhammad Arif S.T.P', 'arif', '729cdf575efd32fafb8216e21a1c1133', '2131730135', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_halaman`
--
ALTER TABLE `akses_halaman`
  ADD PRIMARY KEY (`halaman_akses`),
  ADD KEY `id_akses` (`id_akses`);

--
-- Indexes for table `akses_user`
--
ALTER TABLE `akses_user`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`kd_beasiswa`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`kd_hasil`),
  ADD KEY `fk_mahasiswa` (`nim`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `info_bsw`
--
ALTER TABLE `info_bsw`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `info_umum`
--
ALTER TABLE `info_umum`
  ADD PRIMARY KEY (`id_umum`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kd_kriteria`),
  ADD KEY `kd_beasiswa` (`kd_beasiswa`),
  ADD KEY `kd_beasiswa_2` (`kd_beasiswa`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`kd_model`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`kd_nilai`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_mahasiswa` (`nim`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`kd_pengguna`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`kd_penilaian`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_user`
--
ALTER TABLE `akses_user`
  MODIFY `id_akses` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `kd_beasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `kd_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `info_bsw`
--
ALTER TABLE `info_bsw`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `info_umum`
--
ALTER TABLE `info_umum`
  MODIFY `id_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kd_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `kd_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `kd_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `kd_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `kd_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses_halaman`
--
ALTER TABLE `akses_halaman`
  ADD CONSTRAINT `akses_halaman_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `user` (`id_akses`);

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `fk_beasiswa` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `model_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `akses_user` (`id_akses`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
