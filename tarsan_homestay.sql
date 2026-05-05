-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2026 at 07:52 AM
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
-- Database: `tarsan_homestay`
--

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
(4, '2025_12_29_103925_add_role_to_users_table', 2),
(5, '2025_12_30_140812_create_rooms_table', 3),
(6, '2026_01_06_115933_add_photo_to_users_table', 4),
(7, '2026_01_09_121205_add_columns_to_rooms_table', 5),
(8, '2026_01_09_123751_create_room_images_table', 6),
(10, '2026_01_09_141459_add_facilities_to_rooms_table', 7),
(11, '2026_01_10_052826_create_vouchers_table', 7),
(12, '2026_01_11_020245_create_orders_table', 8),
(13, '2026_01_11_094238_create_reviews_table', 9),
(14, '2026_01_12_104047_add_walkin_fields_to_orders_table', 10),
(15, '2026_01_12_133957_create_order_items_table', 11),
(16, '2026_01_12_135220_fix_orders_table_structure', 12),
(17, '2026_01_15_061142_add_invoice_number_to_orders', 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `nights` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `payment_status` varchar(30) NOT NULL DEFAULT 'pending',
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `booking_status` enum('upcoming','checked_in','checked_out') NOT NULL DEFAULT 'upcoming',
  `status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
  `checked_in_at` datetime DEFAULT NULL,
  `checked_out_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_walkin` tinyint(1) NOT NULL DEFAULT 0,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_phone` varchar(255) DEFAULT NULL,
  `voucher_code` varchar(50) DEFAULT NULL,
  `voucher_amount` int(11) DEFAULT 0,
  `invoice_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `check_in`, `check_out`, `nights`, `total_price`, `gross_amount`, `payment_status`, `payment_type`, `transaction_id`, `booking_status`, `status`, `checked_in_at`, `checked_out_at`, `created_at`, `updated_at`, `is_walkin`, `guest_name`, `guest_phone`, `voucher_code`, `voucher_amount`, `invoice_number`) VALUES
(1, 'ORD-U9RYOWTEUB', 7, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 20:54:13', '2026-01-14 20:54:13', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(2, 'ORD-MBRDRNXNIY', NULL, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 20:55:51', '2026-01-14 20:55:51', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(3, 'ORD-IVU1UEUXR3', NULL, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 22:16:30', '2026-01-14 22:16:30', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(4, 'ORD-CYPIV5RR6G', NULL, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 22:16:43', '2026-01-14 22:16:43', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(5, 'ORD-5XAPI29PEH', NULL, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 22:17:12', '2026-01-14 22:17:12', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(6, 'ORD-IPFFLUJWQW', NULL, '2026-01-14 00:00:00', '2026-01-15 00:00:00', 1, 150000, 150000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-14 22:17:19', '2026-01-14 22:17:19', 0, 'Adriant', '081238105660', NULL, 0, NULL),
(7, 'ORD-PRSYREIMYI', 7, '2026-01-23 00:00:00', '2026-01-28 00:00:00', 5, 900000, 900000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-15 02:27:55', '2026-01-15 02:27:55', 0, 'Steven', '081238105660', NULL, 0, NULL),
(8, 'ORD-RWONELNSRQ', 7, '2026-01-29 00:00:00', '2026-01-30 00:00:00', 1, 180000, 180000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-29 05:58:56', '2026-01-29 05:58:56', 0, 'Ian', '081238105660', NULL, 0, NULL),
(9, 'ORD-WHGEGDKMWR', 9, '2026-01-30 00:00:00', '2026-01-31 00:00:00', 1, 280000, 280000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-29 22:31:09', '2026-01-29 22:31:09', 0, 'Tes 2', '081238105660', NULL, 0, NULL),
(10, 'ORD-3HZFRNCEQN', 10, '2026-01-30 00:00:00', '2026-01-31 00:00:00', 1, 180000, 180000, 'pending', NULL, NULL, 'upcoming', 'pending', NULL, NULL, '2026-01-30 00:20:13', '2026-01-30 00:20:13', 0, 'Ian', '081238105660', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `price_per_night` int(11) NOT NULL,
  `nights` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('putra.2205551121@student.unud.ac.id', '$2y$12$.iJjA05TlTJdQzUAUxpROuLfdn2/O3K3oGLAxsdzs2JYhNhNP9X.W', '2026-04-27 03:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `review` text NOT NULL,
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `price_per_night` int(11) NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL,
  `total_rooms` int(10) UNSIGNED NOT NULL,
  `available_rooms` int(10) UNSIGNED NOT NULL,
  `facilities` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `price_per_night`, `capacity`, `total_rooms`, `available_rooms`, `facilities`, `description`, `created_at`, `updated_at`, `is_active`) VALUES
(4, 'Backpacker', 180000, 1, 10, 10, NULL, '-', '2026-01-09 06:21:08', '2026-01-09 06:21:08', 1),
(5, 'Standard', 280000, 2, 4, 4, '-', '-', '2026-01-13 13:41:55', '2026-01-13 13:41:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`id`, `room_id`, `image`, `created_at`, `updated_at`) VALUES
(4, 4, 'rooms/gDiWrY4VNDM37PZ8uB3AssJIsHaR4x2OW6m8me9e.jpg', '2026-01-09 06:21:08', '2026-01-09 06:21:08'),
(5, 4, 'rooms/Var6xfcby23ZYOXA9765RdV6nviW0bG0IrZtIAO4.jpg', '2026-01-09 06:33:04', '2026-01-09 06:33:04'),
(6, 4, 'rooms/sOfcJwfRHCtdSPTZuuA9cqyVBxBbuFKLeaFouDQn.jpg', '2026-01-09 06:33:04', '2026-01-09 06:33:04'),
(7, 5, 'rooms/jxboy7tA1DJ0IYGOoarMINv8mlBEg45CycSX2w37.png', '2026-01-13 13:41:56', '2026-01-13 13:41:56');

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
('bpvzb5GlSsvivKTKjlQqyILzl2UBBmc7aBS4aUNO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakd2S0lwajNKcG8ybWJINHVNanpHSnNvNWNneTI2dTNnQlh3QUt4TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90YW11L3Jvb21zIjt9fQ==', 1777953678),
('jCI5oetZ4DmRmfjKrbfiBRIVNJOnHruP9u56VHAW', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMThEMWg4NUNLODVwUEJhdEs2SXl6cDNCSE12YnVNSUU5Nkl1VXZ6TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1777270587),
('VOQ3JzvvzQYU5tf860FKmdS0kMT6b7FxQuh2Ydem', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1NqdE5YTzNzOU1LQ1JKU1N0aXRjTk15NGprN1RhWHh5c0tGN2FaUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3Jnb3QtcGFzc3dvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777260506),
('wE1K0gYGXBrIZL6K7kFBt0RUwWsRzSGGaZPjJKca', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWNpOXlGRm1idndTRks5Rkdrc1BQVUtncmNYWXhNaUtjOTVodm5oeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90YW11L3Jvb21zIjt9fQ==', 1777459541);

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','resepsionis','tamu') NOT NULL DEFAULT 'tamu',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `photo`) VALUES
(2, 'Kenneth', 'kenneth@gmail.com', NULL, '$2y$12$AvxLuQckxrB3YTqZq96mZede.iPGP0exTeAs692R7a9KGJ8ZX8DVq', 'jzMf11R60Stw2BSqtb1BTkXWJA1Tna4HwusspqSXZlR8Z8RSWAQFJ3qyWKS1', '2025-12-29 02:42:50', '2026-04-27 06:16:13', 'admin', NULL),
(3, 'Mentari', 'mentari@gmail.com', NULL, '$2y$12$owsK7pZcJXxiVKz2313qxOQ7GHq/fGdt.YsvWCMpdGQ4xb0fuSt6e', NULL, '2025-12-30 22:03:32', '2026-01-06 04:54:41', 'resepsionis', 'profile-photos/1f8uIbc3fLUhwdWabfAGJgxJRKwPuhV6Qqbyt8Ox.jpg'),
(4, 'Geraldo', 'geraldo@gmail.com', NULL, '$2y$12$iN3MRraNtD9.yoHMPnI6/u/YEOPGsxW7T/l1snJxZ.cFogK6JX9Ue', NULL, '2026-01-03 18:24:28', '2026-01-09 19:20:16', 'tamu', NULL),
(5, 'Admin', 'admin@gmail.com', NULL, '$2y$12$5zt11SJ8nPdeHyHNcR09pOqTaFCyxKBagcWZZWkkCZa3HLERlifbK', NULL, '2026-01-03 18:27:04', '2026-01-03 18:27:04', 'admin', NULL),
(6, 'Tarsan', 'tarsan@gmail.com', NULL, '$2y$12$mYBSCchGnVCtUTS5L2fj/OT2be7TD/2pLYUZE3soG6W/pg8RBTajm', NULL, '2026-01-05 23:57:55', '2026-01-05 23:57:55', 'tamu', NULL),
(7, 'Steven', 'stevenkasito@gmail.com', NULL, '$2y$12$v2IAC0J0ZWivomQJA0GY9u5zrafkd1D7oqpzNxKqt1w2CqaRfztbG', NULL, '2026-01-06 04:19:53', '2026-01-12 09:30:19', 'tamu', 'profile-photos/AREYOAjC1tgYFpyVF5JWPYOp98OTJ3kAcBq7l491.jpg'),
(8, 'Adriant', 'putra.2205551121@student.unud.ac.id', NULL, '$2y$12$TOKH8o9fW.40aoomG9EY0OA3MIWG6o4SM8qvfhekn0MN7kdMMpCfy', NULL, '2026-01-07 12:57:53', '2026-01-07 12:57:53', 'tamu', NULL),
(9, 'Tes 2', 'tes2@gmail.com', NULL, '$2y$12$vAC268iHyUK0pOucisXQteM8QziAAtwHgp3eupojRx/Ey9efpxTAK', NULL, '2026-01-29 22:29:58', '2026-01-29 22:29:58', 'tamu', NULL),
(10, 'Tes', 'tes@gmail.com', NULL, '$2y$12$EfylmxLDEJmoTNlTH.4iF.SL4fONnH6LzQJUD0la/K.gOU.tVvslG', NULL, '2026-01-30 00:17:50', '2026-01-30 00:17:50', 'tamu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `amount`, `starts_at`, `ends_at`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'WELCOMEGUEST', 30000, '2026-01-10 14:27:00', '2026-01-17 14:27:00', 1, '2026-01-09 22:27:29', '2026-01-10 06:50:50'),
(4, 'UDAH', 1000, '2026-01-10 14:28:00', '2026-01-10 14:29:00', 1, '2026-01-09 22:29:10', '2026-01-09 22:29:10'),
(5, 'WELCOMEGUEST2', 1111, '2026-01-10 14:37:00', '2026-01-10 14:38:00', 0, '2026-01-10 05:38:09', '2026-01-10 06:56:39'),
(6, 'TES', 100000, '2026-01-30 06:00:00', '2026-02-28 06:00:00', 1, '2026-01-29 22:33:48', '2026-01-29 22:33:48');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_room_id_foreign` (`room_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_id_unique` (`order_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_images_room_id_foreign` (`room_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
