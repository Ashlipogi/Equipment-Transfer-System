-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 01:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstoneproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `user_role`, `action`, `description`, `created_at`, `updated_at`) VALUES
(34, 3, 'Admin', 'admin', 'Login', 'User logged in successfully', '2025-02-21 00:30:27', '2025-02-21 00:30:27'),
(35, 3, 'Admin', 'admin', 'Delete User', 'Deleted user with details:\n- Name: Josh Aj Chin\n- Email: josh@gmail.com\n- Role: user', '2025-02-21 04:06:27', '2025-02-21 04:06:27'),
(36, 3, 'Admin', 'admin', 'Create User', 'Created new user with details:\n- Name: Josh Aj Chin\n- Email: josh@gmail.com\n- Role: user', '2025-02-21 06:15:45', '2025-02-21 06:15:45'),
(37, 3, 'Admin', 'admin', 'Update User', 'Updated user #4:\n- Role changed from \'user\' to \'admin\'', '2025-02-21 06:15:54', '2025-02-21 06:15:54'),
(38, 3, 'Admin', 'admin', 'Create User', 'Created new user with details:\n- Name: Jason Arvin Cardona\n- Email: jason@gmail.com\n- Role: admin', '2025-02-21 06:16:17', '2025-02-21 06:16:17'),
(39, 3, 'Admin', 'admin', 'Update User', 'Updated user #5:\n- Role changed from \'admin\' to \'user\'', '2025-02-21 06:21:33', '2025-02-21 06:21:33'),
(40, 3, 'Admin', 'admin', 'Login', 'User logged in successfully', '2025-02-21 11:16:08', '2025-02-21 11:16:08'),
(41, 3, 'Admin', 'admin', 'Create Items', 'Added new items to transfer #12:<br><br>Qty: 3<br>Description: <p class=\"ql-align-center\"><strong>asda</strong></p><br>Date Purchase: 02/05/2025<br>Property No: A1<br>Classification No: a<br>Unit: 12<br>Total Value: 36.00', '2025-02-21 11:19:06', '2025-02-21 11:19:06'),
(42, 3, 'Admin', 'admin', 'Update Items', 'Updated items for transfer #11', '2025-02-21 11:19:29', '2025-02-21 11:19:29'),
(43, 3, 'Admin', 'admin', 'Transfer Items', 'Transferred all items from transfer #11 to a', '2025-02-21 11:19:50', '2025-02-21 11:19:50'),
(44, 3, 'Admin', 'admin', 'Create User', 'Created new user with details:\n- Name: John Ashley D. Villanueva\n- Email: villanuevajohn519@gmail.com\n- Role: admin', '2025-02-21 11:32:10', '2025-02-21 11:32:10'),
(45, 3, 'Admin', 'admin', 'Delete Transfer', 'Deleted transfer #12 and its items:<br><br>Deleted Item #27', '2025-02-21 11:33:08', '2025-02-21 11:33:08'),
(46, 3, 'Admin', 'admin', 'Logout', 'User logged out', '2025-02-21 11:35:33', '2025-02-21 11:35:33'),
(47, 5, 'Jason Arvin Cardona', 'user', 'Login', 'User logged in successfully', '2025-02-21 11:35:41', '2025-02-21 11:35:41'),
(48, 5, 'Jason Arvin Cardona', 'user', 'Logout', 'User logged out', '2025-02-21 11:47:18', '2025-02-21 11:47:18'),
(49, 5, 'Jason Arvin Cardona', 'user', 'Login', 'User logged in successfully', '2025-02-21 11:48:57', '2025-02-21 11:48:57'),
(50, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #13:<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>PRINTER</strong> </p><p class=\"ql-align-center\"> <em>HP LaserJet Pro M404dn</em> </p><p class=\"ql-align-center\"> <em>S/N # HP1234-LJ404</em></p><br>Date Purchase: 06/08/2021<br>Property No: # 08-015<br>Classification No: B3<br>Unit: 22000<br>Total Value: 22000.00<br><br>Qty: 3<br>Description: <p class=\"ql-align-center\"><strong>DESKTOP COMPUTER</strong></p><p class=\"ql-align-center\"><em>Dell OptiPlex 7080, Intel i7, 16GB RAM, 1TB HDD</em></p><p class=\"ql-align-center\"><em>S/N # DELL7080-XYZ</em></p><br>Date Purchase: 03/03/2023<br>Property No: # 12-078<br>Classification No: <br>Unit: 45000<br>Total Value: 135000.00<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>PHOTOCOPIER</strong></p><p class=\"ql-align-center\"><em>Canon imageRUNNER 2425</em></p><p class=\"ql-align-center\"><em>S/N # CN-IR2425-5567</em></p><br>Date Purchase: 06/08/2021<br>Property No: <br>Classification No: <br>Unit: 85000<br>Total Value: 85000.00', '2025-02-21 11:50:43', '2025-02-21 11:50:43'),
(51, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #14:<br><br>Qty: 2<br>Description: <p class=\"ql-align-center\"><strong>MONITOR</strong></p><p class=\"ql-align-center\"><em>Samsung 24-inch LED</em></p><p class=\"ql-align-center\"><em>S/N # SM24F350FH</em></p><br>Date Purchase: 02/06/2019<br>Property No: <br>Classification No: A5<br>Unit: 8000<br>Total Value: 16000.00', '2025-02-21 11:52:07', '2025-02-21 11:52:07'),
(52, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #15:<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>ROUTER</strong></p><p class=\"ql-align-center\"><em>TP-Link Archer C7</em></p><p class=\"ql-align-center\"><em>S/N # TP-C7-9034</em></p><br>Date Purchase: 01/29/2025<br>Property No: # 13-054<br>Classification No: E2<br>Unit: 3500<br>Total Value: 3500.00<br><br>Qty: 4<br>Description: <p class=\"ql-align-center\"><strong>CHAIR</strong> </p><p class=\"ql-align-center\"> <em>Ergonomic Office Chair</em> </p><p class=\"ql-align-center\"> <em>S/N # CHR-ERGO-8765</em></p><br>Date Purchase: 07/11/2018<br>Property No: # 14-101<br>Classification No: F3<br>Unit: 2500<br>Total Value: 10000.00<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>TABLE</strong></p><p class=\"ql-align-center\"><em>Wooden Office Desk</em></p><p class=\"ql-align-center\"><em>S/N # TBL-WD-4590</em></p><br>Date Purchase: 03/05/2020<br>Property No: # 06-089<br>Classification No: <br>Unit: 5000<br>Total Value: 5000.00<br><br>Qty: 2<br>Description: <p class=\"ql-align-center\"><strong>LAPTOP</strong></p><p class=\"ql-align-center\"><em>Lenovo ThinkPad E15, Intel i7, 16GB RAM, 512GB SSD</em></p><p class=\"ql-align-center\"><em>S/N # LEN-E15-0098</em></p><br>Date Purchase: 02/09/2021<br>Property No: <br>Classification No: <br>Unit: 58000<br>Total Value: 116000.00', '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(53, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #16:<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>SERVER</strong></p><p class=\"ql-align-center\"><em>Dell PowerEdge T40</em></p><p class=\"ql-align-center\"><em>S/N # SRV-T40-2333</em></p><br>Date Purchase: 06/06/2023<br>Property No: # 15-076<br>Classification No: C5<br>Unit: 95000<br>Total Value: 95000.00<br><br>Qty: 5<br>Description: <p class=\"ql-align-center\"><strong>CABINET</strong></p><p class=\"ql-align-center\"><em>Metal Filing Cabinet</em></p><p class=\"ql-align-center\"><em>S/N # CAB-MTL-1234</em></p><br>Date Purchase: 06/05/2019<br>Property No: # 16-092<br>Classification No: G1<br>Unit: 3000<br>Total Value: 15000.00', '2025-02-21 11:55:36', '2025-02-21 11:55:36'),
(54, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #17:<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>WHITEBOARD</strong></p><p class=\"ql-align-center\"><em>Magnetic Whiteboard 4x6 ft</em></p><p class=\"ql-align-center\"><em>S/N # WB-MAG-7789</em></p><br>Date Purchase: 07/14/2020<br>Property No: # 17-045<br>Classification No: H2<br>Unit: 3500<br>Total Value: 3500.00', '2025-02-21 11:56:11', '2025-02-21 11:56:11'),
(55, 5, 'Jason Arvin Cardona', 'user', 'Create Items', 'Added new items to transfer #18:<br><br>Qty: 1<br>Description: <p class=\"ql-align-center\"><strong>MICROWAVE</strong></p><p class=\"ql-align-center\"><em>Panasonic NN-SN686S</em></p><p class=\"ql-align-center\"><em>S/N # MW-PANA-3366</em></p><br>Date Purchase: 07/24/2019<br>Property No: # 19-072<br>Classification No: E5<br>Unit: 7000<br>Total Value: 7000.00', '2025-02-21 11:56:49', '2025-02-21 11:56:49'),
(56, 5, 'Jason Arvin Cardona', 'user', 'Delete Transfer', 'Deleted transfer #11 and its items:<br><br>Deleted Item #28', '2025-02-21 12:03:47', '2025-02-21 12:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_purchase` date NOT NULL,
  `property_no` varchar(255) DEFAULT NULL,
  `classification_no` varchar(255) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `total_value` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `transfer_id`, `qty`, `description`, `date_purchase`, `property_no`, `classification_no`, `unit`, `total_value`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '<p class=\"ql-align-center\"><strong>AIRCON</strong></p><p class=\"ql-align-center\"><em>Condura Brand, 1 HP</em></p><p class=\"ql-align-center\"><em>S/N # 51CH2-RAC10KEC-F13P 4828</em></p>', '2019-07-05', '# 07-003', 'A2', '14000', 28000.00, '2025-02-19 12:11:16', '2025-02-19 12:11:16'),
(2, 1, 3, '<p class=\"ql-align-center\"><strong>LAPTOP</strong> </p><p class=\"ql-align-center\"> <em>Acer Aspire 5, Intel i5, 8GB RAM, 512GB SSD</em> </p><p class=\"ql-align-center\"> <em>S/N # 3A4F5T6789</em></p>', '2018-02-04', '# 10-045', 'B1', '50000', 150000.00, '2025-02-19 12:11:16', '2025-02-19 12:11:16'),
(3, 2, 1, '<p class=\"ql-align-center\"><strong>PROJECTOR</strong> </p><p class=\"ql-align-center\"> <em>Epson EB-S41, 3200 Lumens</em> </p><p class=\"ql-align-center\"> <em>S/N # EP1234567</em></p>', '2020-06-21', '# 11-009', 'C3', '25000', 25000.00, '2025-02-19 12:14:55', '2025-02-19 12:14:55'),
(4, 2, 3, '<p class=\"ql-align-center\"><strong>OFFICE CHAIR</strong></p><p class=\"ql-align-center\"><em>Ergonomic, Mesh Back, Adjustable</em></p>', '2021-05-30', '# 12-017', 'D2', '5000', 15000.00, '2025-02-19 12:14:55', '2025-02-19 12:14:55'),
(5, 2, 4, '<p class=\"ql-align-center\"><strong>PRINTER</strong></p><p class=\"ql-align-center\"><em>HP LaserJet Pro MFP M428fdw, Wireless</em></p><p class=\"ql-align-center\"><em>S/N # HP9876543</em></p>', '2023-08-12', '# 15-002', 'E5', '28000', 112000.00, '2025-02-19 12:14:55', '2025-02-19 12:14:55'),
(6, 3, 2, '<p class=\"ql-align-center\"><strong>DESKTOP COMPUTER</strong></p><p class=\"ql-align-center\"><em>Dell OptiPlex 7090, Intel i7, 16GB RAM, 1TB SSD</em></p><p class=\"ql-align-center\"><em>S/N # DELL-PC-12345</em></p>', '2024-12-22', '# 10-055', 'B2', '75000', 150000.00, '2025-02-19 12:16:26', '2025-02-19 12:16:26'),
(7, 4, 2, '<p class=\"ql-align-center\"><strong>PHOTOCOPIER</strong></p><p class=\"ql-align-center\"><em>Canon imageRUNNER ADVANCE 4525i, Laser</em></p><p class=\"ql-align-center\"><em>S/N # CANON-PH123</em></p>', '2021-08-08', '# 11-033', 'F4', '120000', 240000.00, '2025-02-19 12:19:18', '2025-02-19 12:19:18'),
(8, 4, 3, '<p class=\"ql-align-center\"><strong>TABLES</strong></p><p class=\"ql-align-center\"><em>Wooden, 4ft x 2ft, Brown Finish</em></p>', '2022-02-08', '# 13-010', 'G1', '3500', 10500.00, '2025-02-19 12:19:18', '2025-02-19 12:19:18'),
(9, 4, 1, '<p class=\"ql-align-center\"><strong>CABINETS</strong> </p><p class=\"ql-align-center\"> <em>Steel, 4-Door, Lockable</em></p>', '2017-01-09', '# 13-015', 'H3', '8000', 8000.00, '2025-02-19 12:19:18', '2025-02-19 12:19:18'),
(10, 4, 5, '<p class=\"ql-align-center\"><strong>CCTV CAMERA</strong></p><p class=\"ql-align-center\"><em>Hikvision 4MP IP Camera, Night Vision</em></p>', '2018-08-03', '# 14-008', 'I5', '12000', 60000.00, '2025-02-19 12:19:18', '2025-02-19 12:19:18'),
(11, 5, 2, '<p class=\"ql-align-center\"><strong>SOUND SYSTEM</strong></p><p class=\"ql-align-center\"><em>Yamaha MG12XU Mixer + Speakers</em></p>', '2019-02-28', '# 16-004', 'J2', '50000', 100000.00, '2025-02-19 12:21:57', '2025-02-19 12:21:57'),
(12, 5, 4, '<p class=\"ql-align-center\"><strong>MICROWAVE OVEN</strong></p><p class=\"ql-align-center\"><em>Samsung 23L Grill Microwave</em></p>', '2020-09-14', '# 17-001', 'K6', '7000', 28000.00, '2025-02-19 12:21:57', '2025-02-19 12:21:57'),
(13, 6, 1, '<p class=\"ql-align-center\"><strong>ELECTRIC FANS</strong></p><p class=\"ql-align-center\"><em>Asahi 16-inch Stand Fan</em></p>', '2023-12-22', '# 18-002', 'L3', '2500', 2500.00, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(14, 6, 2, '<p class=\"ql-align-center\"><strong>GENERATOR</strong></p><p class=\"ql-align-center\"><em>Honda 5kVA Gasoline Generator</em></p>', '2025-01-28', '# 19-006', 'M8', '75000', 150000.00, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(15, 6, 1, '<p class=\"ql-align-center\"><strong>WATER DISPENSER</strong></p><p class=\"ql-align-center\"><em>Kyowa Hot &amp; Cold Dispense</em></p>', '2021-06-08', '# 20-003', 'N4', '5500', 5500.00, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(16, 6, 3, '<p class=\"ql-align-center\"><strong>TV</strong></p><p class=\"ql-align-center\"><em>Samsung 55-inch UHD Smart TV</em></p>', '2025-01-27', '# 21-001', 'O2', '45000', 135000.00, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(17, 6, 2, '<p class=\"ql-align-center\"><strong>WHITEBOARD</strong></p><p class=\"ql-align-center\"><em>Magnetic, 6ft x 4ft, Aluminum Frame</em></p>', '2021-08-20', '# 22-007', 'P3', '6000', 12000.00, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(18, 7, 3, '<p class=\"ql-align-center\"><strong>REFRIGERATOR</strong></p><p class=\"ql-align-center\"><em>LG Inverter 10.2 cu.ft</em></p>', '2020-08-10', '# 23-002', 'Q4', '25000', 75000.00, '2025-02-19 12:25:48', '2025-02-19 12:25:48'),
(19, 8, 3, '<p class=\"ql-align-center\"><strong>WIFI ROUTER</strong></p><p class=\"ql-align-center\"><em>TP-Link Archer AX50, Dual-Band</em></p>', '2024-12-18', '# 24-005', 'R5', '7000', 21000.00, '2025-02-19 12:26:45', '2025-02-19 12:26:45'),
(20, 8, 2, '<p class=\"ql-align-center\"><strong>BIOMETRIC ATTENDANCE SYSTEM</strong></p><p class=\"ql-align-center\"><em>ZKTeco MB160 Face &amp; Fingerprint Scanner</em></p>', '2019-07-10', '# 25-008', 'S6', '18000', 36000.00, '2025-02-19 12:26:45', '2025-02-19 12:26:45'),
(21, 10, 4, '<p><strong>Example nullable or not required Property No. and Classification No.</strong></p>', '2025-02-19', NULL, NULL, '12222', 48888.00, '2025-02-19 12:44:58', '2025-02-19 12:45:11'),
(25, 4, 4, '<p>example null</p>', '2025-02-20', NULL, NULL, '1', 4.00, '2025-02-20 01:53:20', '2025-02-20 01:53:20'),
(29, 13, 1, '<p class=\"ql-align-center\"><strong>PRINTER</strong> </p><p class=\"ql-align-center\"> <em>HP LaserJet Pro M404dn</em> </p><p class=\"ql-align-center\"> <em>S/N # HP1234-LJ404</em></p>', '2021-06-08', '# 08-015', 'B3', '22000', 22000.00, '2025-02-21 11:50:43', '2025-02-21 11:50:43'),
(30, 13, 3, '<p class=\"ql-align-center\"><strong>DESKTOP COMPUTER</strong></p><p class=\"ql-align-center\"><em>Dell OptiPlex 7080, Intel i7, 16GB RAM, 1TB HDD</em></p><p class=\"ql-align-center\"><em>S/N # DELL7080-XYZ</em></p>', '2023-03-03', '# 12-078', NULL, '45000', 135000.00, '2025-02-21 11:50:43', '2025-02-21 11:50:43'),
(31, 13, 1, '<p class=\"ql-align-center\"><strong>PHOTOCOPIER</strong></p><p class=\"ql-align-center\"><em>Canon imageRUNNER 2425</em></p><p class=\"ql-align-center\"><em>S/N # CN-IR2425-5567</em></p>', '2021-06-08', NULL, NULL, '85000', 85000.00, '2025-02-21 11:50:43', '2025-02-21 11:50:43'),
(32, 14, 2, '<p class=\"ql-align-center\"><strong>MONITOR</strong></p><p class=\"ql-align-center\"><em>Samsung 24-inch LED</em></p><p class=\"ql-align-center\"><em>S/N # SM24F350FH</em></p>', '2019-02-06', NULL, 'A5', '8000', 16000.00, '2025-02-21 11:52:07', '2025-02-21 11:52:07'),
(33, 15, 1, '<p class=\"ql-align-center\"><strong>ROUTER</strong></p><p class=\"ql-align-center\"><em>TP-Link Archer C7</em></p><p class=\"ql-align-center\"><em>S/N # TP-C7-9034</em></p>', '2025-01-29', '# 13-054', 'E2', '3500', 3500.00, '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(34, 15, 4, '<p class=\"ql-align-center\"><strong>CHAIR</strong> </p><p class=\"ql-align-center\"> <em>Ergonomic Office Chair</em> </p><p class=\"ql-align-center\"> <em>S/N # CHR-ERGO-8765</em></p>', '2018-07-11', '# 14-101', 'F3', '2500', 10000.00, '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(35, 15, 1, '<p class=\"ql-align-center\"><strong>TABLE</strong></p><p class=\"ql-align-center\"><em>Wooden Office Desk</em></p><p class=\"ql-align-center\"><em>S/N # TBL-WD-4590</em></p>', '2020-03-05', '# 06-089', NULL, '5000', 5000.00, '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(36, 15, 2, '<p class=\"ql-align-center\"><strong>LAPTOP</strong></p><p class=\"ql-align-center\"><em>Lenovo ThinkPad E15, Intel i7, 16GB RAM, 512GB SSD</em></p><p class=\"ql-align-center\"><em>S/N # LEN-E15-0098</em></p>', '2021-02-09', NULL, NULL, '58000', 116000.00, '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(37, 16, 1, '<p class=\"ql-align-center\"><strong>SERVER</strong></p><p class=\"ql-align-center\"><em>Dell PowerEdge T40</em></p><p class=\"ql-align-center\"><em>S/N # SRV-T40-2333</em></p>', '2023-06-06', '# 15-076', 'C5', '95000', 95000.00, '2025-02-21 11:55:36', '2025-02-21 11:55:36'),
(38, 16, 5, '<p class=\"ql-align-center\"><strong>CABINET</strong></p><p class=\"ql-align-center\"><em>Metal Filing Cabinet</em></p><p class=\"ql-align-center\"><em>S/N # CAB-MTL-1234</em></p>', '2019-06-05', '# 16-092', 'G1', '3000', 15000.00, '2025-02-21 11:55:36', '2025-02-21 11:55:36'),
(39, 17, 1, '<p class=\"ql-align-center\"><strong>WHITEBOARD</strong></p><p class=\"ql-align-center\"><em>Magnetic Whiteboard 4x6 ft</em></p><p class=\"ql-align-center\"><em>S/N # WB-MAG-7789</em></p>', '2020-07-14', '# 17-045', 'H2', '3500', 3500.00, '2025-02-21 11:56:11', '2025-02-21 11:56:11'),
(40, 18, 1, '<p class=\"ql-align-center\"><strong>MICROWAVE</strong></p><p class=\"ql-align-center\"><em>Panasonic NN-SN686S</em></p><p class=\"ql-align-center\"><em>S/N # MW-PANA-3366</em></p>', '2019-07-24', '# 19-072', 'E5', '7000', 7000.00, '2025-02-21 11:56:49', '2025-02-21 11:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_26_122926_create_transfers_table', 1),
(5, '2025_01_26_123111_create_items_table', 1),
(6, '2025_02_03_135533_create_activity_logs_table', 1),
(7, '2025_02_04_121220_create_transferred_items_table', 1),
(8, '2025_02_18_084838_update_transferred_items_table', 1),
(9, '2025_02_18_085744_add_designated_office_name_to_transferred_items', 1),
(10, '2025_02_18_092404_add_position_fields_to_transferred_items_table', 1),
(11, '2025_02_19_204426_make_property_and_classification_nullable', 2),
(12, '2025_02_20_195754_remove_ip_address_from_activity_logs', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Fm5CN1W8y0rZi9lEhYxlm2MaslCZNtxylCHLBaHw', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZFRMeVl6QWlZUmJER3czU1cxb2xLZWdmU0RwMXJPRzVwbXljNDR1VyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZGRpdGVtIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1740139470),
('qhVYVpzJf7ydgQoCdtoYAsFq8PcE2lgNfrX9Cefq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoialNtTEpZa0xTMTdPTDlUYUlWT1h6QVBobmJhczlCbUlXU1duNnZXSSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkZGl0ZW0iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkZGl0ZW0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1740136111);

-- --------------------------------------------------------

--
-- Table structure for table `transferred_items`
--

CREATE TABLE `transferred_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_to` varchar(255) DEFAULT NULL,
  `name_designation` text DEFAULT NULL,
  `position_intended_transfer` varchar(255) DEFAULT NULL,
  `designated_office` varchar(255) DEFAULT NULL,
  `designated_office_name` varchar(255) DEFAULT NULL,
  `position_intended_office` varchar(255) DEFAULT NULL,
  `transferred_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transferred_items`
--

INSERT INTO `transferred_items` (`id`, `item_id`, `transfer_to`, `name_designation`, `position_intended_transfer`, `designated_office`, `designated_office_name`, `position_intended_office`, `transferred_at`, `created_at`, `updated_at`) VALUES
(1, 7, 'IT Department', 'John Doe', 'IT Support Specialist', 'Main Office - IT Section', 'Jane Smith', 'HR Supervisor', '2025-02-20 01:53:20', '2025-02-19 12:50:18', '2025-02-20 01:53:20'),
(2, 8, 'IT Department', 'John Doe', 'IT Support Specialist', 'Main Office - IT Section', 'Jane Smith', 'HR Supervisor', '2025-02-20 01:53:20', '2025-02-19 12:50:18', '2025-02-20 01:53:20'),
(3, 9, 'IT Department', 'John Doe', 'IT Support Specialist', 'Main Office - IT Section', 'Jane Smith', 'HR Supervisor', '2025-02-20 01:53:20', '2025-02-19 12:50:18', '2025-02-20 01:53:20'),
(4, 10, 'IT Department', 'John Doe', 'IT Support Specialist', 'Main Office - IT Section', 'Jane Smith', 'HR Supervisor', '2025-02-20 01:53:20', '2025-02-19 12:50:18', '2025-02-20 01:53:20'),
(8, 25, 'IT Department', 'John Doe', 'IT Support Specialist', 'Main Office - IT Section', 'Jane Smith', 'HR Supervisor', '2025-02-20 01:53:20', '2025-02-20 01:53:20', '2025-02-20 01:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `created_at`, `updated_at`) VALUES
(1, '2025-02-19 12:11:16', '2025-02-19 12:11:16'),
(2, '2025-02-19 12:14:55', '2025-02-19 12:14:55'),
(3, '2025-02-19 12:16:26', '2025-02-19 12:16:26'),
(4, '2025-02-19 12:19:18', '2025-02-19 12:19:18'),
(5, '2025-02-19 12:21:57', '2025-02-19 12:21:57'),
(6, '2025-02-19 12:24:58', '2025-02-19 12:24:58'),
(7, '2025-02-19 12:25:48', '2025-02-19 12:25:48'),
(8, '2025-02-19 12:26:45', '2025-02-19 12:26:45'),
(9, '2025-02-19 12:40:54', '2025-02-19 12:40:54'),
(10, '2025-02-19 12:44:58', '2025-02-19 12:44:58'),
(13, '2025-02-21 11:50:43', '2025-02-21 11:50:43'),
(14, '2025-02-21 11:52:07', '2025-02-21 11:52:07'),
(15, '2025-02-21 11:54:29', '2025-02-21 11:54:29'),
(16, '2025-02-21 11:55:35', '2025-02-21 11:55:35'),
(17, '2025-02-21 11:56:11', '2025-02-21 11:56:11'),
(18, '2025-02-21 11:56:49', '2025-02-21 11:56:49'),
(19, '2025-02-21 12:04:21', '2025-02-21 12:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Admin', 'admin@admin.com', NULL, '$2y$12$ExsKNx2HIDF2805AuMlt5OvgcHTJaCrj6793I6JS6ly5r2OL50.QK', 'admin', NULL, '2025-02-20 13:01:53', '2025-02-20 13:01:53'),
(4, 'Josh Aj Chin', 'josh@gmail.com', NULL, '$2y$12$TsQFOrH6hJCa8ATBH56bduG.bD2vXFEgx0RG6BmdoV5S4QHBWBMGa', 'admin', NULL, '2025-02-21 06:15:45', '2025-02-21 06:15:54'),
(5, 'Jason Arvin Cardona', 'jason@gmail.com', NULL, '$2y$12$UR1j0ImlO2KPqkSPDn8mNeo2hDODIzCoMZ9C5mebTpmXglGFzrrIq', 'user', NULL, '2025-02-21 06:16:17', '2025-02-21 06:21:33'),
(6, 'John Ashley D. Villanueva', 'villanuevajohn519@gmail.com', NULL, '$2y$12$AdVoYR0Iorvr648ZQqjUkeXA7f.M2URD/P/mRLmJEQdsKWHuOk/9e', 'admin', NULL, '2025-02-21 11:32:10', '2025-02-21 11:32:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_transfer_id_foreign` (`transfer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transferred_items`
--
ALTER TABLE `transferred_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transferred_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transferred_items`
--
ALTER TABLE `transferred_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transferred_items`
--
ALTER TABLE `transferred_items`
  ADD CONSTRAINT `transferred_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
