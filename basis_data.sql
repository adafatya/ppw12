/* Basis data */
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `berita` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `berita`;

CREATE TABLE `berita` (
  `id_berita` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `baris_kepala` text NOT NULL,
  `isi` text NOT NULL,
  `pengirim` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `id_kategori` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kategori` (
  `id_kategori` int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_kategori` varchar(30) NOT NULL,
  `deskripsi` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `komentar` (
  `id_berita` int(5) NOT NULL,
  `komentator` varchar(30) NOT NULL,
  `komentar` varchar(200) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Ruang angkasa', 'Kumpulan berita tentang ruang angkasa'),
(2, 'Teknologi', 'Kumpulan berita tentang teknologi');
