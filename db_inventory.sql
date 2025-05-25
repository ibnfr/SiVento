-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_inventory`
--

CREATE TABLE `tb_inventory` (
  `id_barang` int(10) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah_barang` int(10) DEFAULT 0,
  `satuan_barang` enum('kg','pcs','liter','meter','unit') NOT NULL,
  `harga_beli` double(20,2) DEFAULT NULL,
  `status_barang` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_inventory`
--

INSERT INTO `tb_inventory` (`id_barang`, `kode_barang`, `nama_barang`, `jumlah_barang`, `satuan_barang`, `harga_beli`, `status_barang`, `created_at`, `updated_at`) VALUES
(2, '111', 'celana jeans', 11, 'pcs', 200000.00, 1, '2025-05-23 17:22:36', '2025-05-24 10:42:46'),
(6, '11', 'air minum', 900, 'pcs', 500.00, 1, '2025-05-24 12:15:16', '2025-05-24 12:15:16'),
(7, '900', 'motor', 12, 'pcs', 12000000.00, 1, '2025-05-24 12:15:44', '2025-05-24 12:15:44'),
(8, '889', 'mobil', 2, 'unit', 200000000.00, 1, '2025-05-24 12:16:14', '2025-05-25 14:14:44'),
(9, '00', 'pita', 17, 'meter', 2000.00, 1, '2025-05-24 12:16:32', '2025-05-25 14:09:48'),
(10, '003', 'minyak', 88, 'liter', 20000.00, 1, '2025-05-24 12:18:30', '2025-05-25 14:06:24'),
(11, '890', 'beras', 100, 'kg', 70000.00, 1, '2025-05-24 12:19:00', '2025-05-24 12:19:00'),
(12, '023', 'helm', 10, 'unit', 250000.00, 1, '2025-05-24 12:19:29', '2025-05-24 12:19:29'),
(13, '90909', 'kulkas', 9, 'unit', 2000000.00, 1, '2025-05-25 14:08:29', '2025-05-25 14:08:29'),
(14, '77', 'indomie', 90, 'pcs', 2000.00, 1, '2025-05-25 14:10:40', '2025-05-25 14:10:40'),
(15, '550', 'kasur', 2, 'pcs', 1000000.00, 1, '2025-05-25 14:10:57', '2025-05-25 14:10:57'),
(16, '0980', 'mangga', 20, 'kg', 10000.00, 1, '2025-05-25 14:11:42', '2025-05-25 14:11:42'),
(17, '887', 'shampoo', 9, 'pcs', 10000.00, 1, '2025-05-25 14:12:11', '2025-05-25 14:12:11'),
(18, '776', 'minyak tanah', 9, 'liter', 8000.00, 1, '2025-05-25 14:12:28', '2025-05-25 14:12:28'),
(19, '5647', 'kertas kado', 8, 'meter', 3000.00, 1, '2025-05-25 14:12:54', '2025-05-25 14:12:54'),
(20, '666', 'deterjen cair', 10, 'liter', 50000.00, 1, '2025-05-25 14:14:33', '2025-05-25 14:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.png',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `role`, `username`, `password`, `full_name`, `email`, `no_hp`, `image`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$L8KX7YNs449Yv24fy/8JQOaMLOfnvORTGOw18ngtaUuclDFOuEquu', 'Administrator', 'admin@example.com', '081234567890', '', '2025-05-24 11:28:27', '2025-05-24 18:59:51'),
(5, 'user', 'hind_ia', '$2y$10$dIcDz/4Xn.0dwPq1MGfDZu6Q9hIMfE0cp5s62q.PyGwwU/luv//d6', 'hindia', 'hindia@yopmail.com', '087765432122', NULL, '2025-05-24 13:31:55', '2025-05-24 19:02:53'),
(7, 'user', 'undi', '$2y$10$5GSN9.PkKF9tiWeZ9jOcNuV3l2q5okZC8Rtt1yQHxLa.d2EJmSX0G', 'undi', 'undiundi@yopmail.com', '08774563778', 'default.png', '2025-05-25 21:05:21', '2025-05-25 21:05:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
