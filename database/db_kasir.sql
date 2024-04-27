-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2024 pada 23.23
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujikomrifqy3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `diskon` tinyint(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stock`, `diskon`, `created_at`) VALUES
(4, 'P0001', 'Milku', '10000', 50, 0, '2024-04-26 17:27:50'),
(8, 'P0002', 'Biskuat', '20000', 19, 0, '2024-04-26 09:15:47'),
(9, 'P0003', 'Pota Bee', '10000', 10, 0, '2024-04-26 07:49:10'),
(11, 'P0004', 'Beng Beng', '2000', 50, 0, '2024-04-26 07:49:11'),
(12, 'P0005', 'Pulpen', '1000', 20, 0, '2024-04-26 17:19:48');

--
-- Trigger `barang`
--
DELIMITER $$
CREATE TRIGGER `kurang_stok` AFTER UPDATE ON `barang` FOR EACH ROW BEGIN
IF NEW.stock < OLD.stock THEN
INSERT INTO log_stok (kode_barang, stok_lama, stok_baru, waktu) VALUES (OLD.kode_barang, OLD.stock, NEW.stock, NOW());
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `diskon` tinyint(5) NOT NULL,
  `total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `jumlah_barang` varchar(255) NOT NULL,
  `total_harga` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `nama_petugas` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `kode_transaksi`, `jumlah_barang`, `total_harga`, `qty`, `nama_petugas`, `created_at`) VALUES
(16, 'INV431712', '1', '100000', 5, 'Furina', '2024-04-26 07:33:39'),
(17, 'INV333847', '4', '122000', 8, 'Furina', '2024-04-26 07:44:02'),
(18, 'INV754602', '1', '10000', 1, 'Furina', '2024-04-26 09:07:23'),
(19, 'INV128351', '1', '200000', 20, 'Furina', '2024-04-26 09:12:09'),
(20, 'INV650246', '1', '200000', 20, 'Furina', '2024-04-26 09:12:24'),
(21, 'INV734192', '1', '240000', 24, 'Furina', '2024-04-26 09:18:10'),
(22, 'INV297516', '1', '110000', 11, 'Furina', '2024-04-26 09:54:02'),
(23, 'INV997053', '1', '110000', 11, 'Bocchi', '2024-04-26 17:28:13'),
(24, 'INV121514', '1', '110000', 11, 'Bocchi', '2024-04-26 17:29:17'),
(25, 'INV961111', '2', '130000', 13, 'Bocchi', '2024-04-26 20:08:46'),
(26, 'INV652371', '2', '130000', 13, 'Bocchi', '2024-04-26 20:21:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `kode_petugas` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_petugas` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `level` enum('Petugas','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `kode_petugas`, `username`, `password`, `nama_petugas`, `no_telp`, `level`) VALUES
(15, 'M0001', 'admin', '$2y$10$urx9FoN.LU86e.P9KuedGOI01yfY7d4lnelIlYGqdu9eS4Y6p7sJi', 'Furina', '0821283921390', 'Admin'),
(16, 'M0002', 'user', '$2y$10$Lj5wIiGKyMRnt.x.swmw1O4MzrA5m60Olm/eDZSFS6NyNTSA3a1/C', 'Bocchi', '082141079471', 'Petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_stok`
--

CREATE TABLE `log_stok` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `stok_lama` int(11) NOT NULL,
  `stok_baru` int(11) NOT NULL,
  `waktu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `kode_member` varchar(255) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `diskon` tinyint(5) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id`, `kode_member`, `nama_member`, `diskon`, `alamat`, `no_telp`, `created_at`) VALUES
(16, 'M0001', 'Furina', 5, 'Isekai', '09210240101', '2024-04-24 06:45:45'),
(17, 'M0002', 'kasim', 10, 'Fontaine', '0821029401092', '2024-04-24 06:46:08'),
(18, 'M0003', 'Pota Bee', 50, 'zxc', '0831', '2024-04-24 07:29:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_stok`
--
ALTER TABLE `log_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `log_stok`
--
ALTER TABLE `log_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
