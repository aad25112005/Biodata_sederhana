-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Agu 2023 pada 15.06
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int(30) NOT NULL,
  `nisn` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(50) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `hobi` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `nisn`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `agama`, `email`, `kelas`, `jurusan`, `no_hp`, `hobi`, `alamat`) VALUES
(13, '0067967348', 'Athariq Ahmad Day', 'Laki-Laki', 'Padang', '2005-11-25', 'Islam', 'athariqahmadday@gmail.com', 'XII', 'PPLG', '0895602588130', 'Main Game', 'sdaada'),
(14, '0087315151', 'Rangga', 'Laki-Laki', 'Padang', '2006-07-04', 'Islam', 'rangga@gmail.com', 'X', 'PPLG', '082376842962', 'Main Game', 'xzxcs'),
(15, '0067965353', 'Arjuna', 'Laki-Laki', 'Padang', '2023-01-31', 'Islam', 'arjuna@gmail.com', 'X', 'PPLG', '082355768893', 'Memasak', 'sadasda'),
(16, '00898765442', 'Putri', 'Perempuan', 'Padang', '2006-11-25', 'Kristen Katolik', 'zva@gmail.com', 'XI', 'ULP', '082677881135', 'Berenang', 'xzvxxv');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
