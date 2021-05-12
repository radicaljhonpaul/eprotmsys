-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2021 at 07:34 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eprotrackmo`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dtrack_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_end_user` int(11) NOT NULL,
  `doc_current_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_current_location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forwarded_to` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_received` int(11) NOT NULL DEFAULT 0,
  `final_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Processing',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `created_at`, `updated_at`, `dtrack_no`, `doc_type`, `doc_end_user`, `doc_current_status`, `doc_current_location`, `forwarded_to`, `is_received`, `final_status`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-11 01:35:59', '111', 'Purchase Request', 4, 'Accomplished PR - Processing for PO', '3,0,54', '3,5,55', 1, 'Completed', NULL),
(2, '2021-05-09 16:25:41', '2021-05-11 17:11:55', '112', 'Accomplishment Report', 4, 'Receiving for Processing', '3,5,55', NULL, 1, 'Processing', NULL),
(3, '2021-05-11 01:35:59', '2021-05-11 01:57:50', '111', 'Purchase Order', 4, 'Accomplished PO', '3,0,59', NULL, 1, 'Completed', NULL),
(4, '2021-05-11 17:21:05', '2021-05-11 17:38:47', '113', 'Purchase Request', 4, 'Receiving for Processing', '3,5,55', NULL, 1, 'Processing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents_mutation`
--

CREATE TABLE `documents_mutation` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dtrack_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_end_user` int(11) NOT NULL,
  `doc_current_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_current_location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forwarded_to` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_received` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents_mutation_logs`
--

CREATE TABLE `documents_mutation_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dtrack_id_fk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_from` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_to` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_type_from` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_type_to` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_mutation_logs`
--

INSERT INTO `documents_mutation_logs` (`id`, `created_at`, `updated_at`, `dtrack_id_fk`, `doc_from`, `doc_to`, `doc_type_from`, `doc_type_to`, `deleted_at`) VALUES
(1, '2021-05-11 01:26:45', '2021-05-11 01:26:45', '111', '111-2021', NULL, 'Purchase Request', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents_mutation_status_logs`
--

CREATE TABLE `documents_mutation_status_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `document_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtrack_id_fk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` int(11) NOT NULL,
  `cluster` int(11) NOT NULL,
  `office` int(11) NOT NULL,
  `forwarded_to` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents_status_logs`
--

CREATE TABLE `documents_status_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doc_id` int(11) NOT NULL,
  `document_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtrack_id_fk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` int(11) NOT NULL,
  `cluster` int(11) NOT NULL,
  `office` int(11) NOT NULL,
  `forwarded_to` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_mutated` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents_status_logs`
--

INSERT INTO `documents_status_logs` (`id`, `created_at`, `updated_at`, `doc_id`, `document_status`, `dtrack_id_fk`, `doc_notes`, `division`, `cluster`, `office`, `forwarded_to`, `receiver_id`, `status`, `is_mutated`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-07 07:57:01', 1, 'For Approval', '111', NULL, 3, 0, 52, '3,0,49', 1, 'origin', 'No', NULL),
(2, '2021-05-09 16:25:41', '2021-05-09 16:25:41', 2, 'For Signature', '112', 'Pa perma ko mam Ai.', 3, 0, 52, '3,0,49', 1, 'origin', 'No', NULL),
(27, '2021-05-09 20:19:31', '2021-05-10 02:28:03', 1, 'Receiving for Processing', '111', 'Pa receive ko mam cecille', 3, 0, 49, '3,5,55', 3, 'forwarded', 'No', NULL),
(28, '2021-05-10 02:32:23', '2021-05-10 06:42:43', 2, 'Receiving for Processing', '112', NULL, 3, 0, 49, '3,5,55', 3, 'forwarded', 'No', NULL),
(29, '2021-05-10 06:33:09', '2021-05-10 10:30:13', 1, 'For CAF & Signature', '111', NULL, 3, 5, 55, '3,5,58', 2, 'forwarded', 'No', NULL),
(30, '2021-05-10 10:31:04', '2021-05-11 01:21:48', 1, 'For Signature', '111', NULL, 3, 5, 58, '3,5,57', 7, 'forwarded', 'No', NULL),
(31, '2021-05-11 01:23:47', '2021-05-11 01:24:42', 1, 'For PR Numbering', '111', NULL, 3, 5, 57, '3,0,54', 9, 'forwarded', 'No', NULL),
(32, '2021-05-11 01:25:13', '2021-05-11 01:26:45', 1, 'For Resolution', '111', NULL, 3, 0, 54, '3,0,53', 10, 'forwarded', 'No', NULL),
(33, '2021-05-11 01:28:07', '2021-05-11 01:29:25', 1, 'For RFQ', '111', NULL, 3, 0, 53, '3,0,54', 9, 'forwarded', 'No', NULL),
(34, '2021-05-11 01:29:37', '2021-05-11 01:30:28', 1, 'For Abstract as Read', '111', NULL, 3, 0, 54, '3,0,53', 10, 'forwarded', 'No', NULL),
(35, '2021-05-11 01:30:42', '2021-05-11 01:34:48', 1, 'For Purchase Order (PO)', '111', NULL, 3, 0, 53, '3,0,54', 9, 'forwarded', 'No', NULL),
(36, '2021-05-11 01:34:58', '2021-05-11 01:34:58', 1, NULL, '111', NULL, 3, 0, 54, NULL, NULL, 'received', 'No', NULL),
(37, '2021-05-11 01:35:59', '2021-05-11 01:35:59', 3, 'Receiving for Processing', '111', 'Please forward to accounting', 3, 0, 54, '3,5,55', 3, 'forwarded', 'No', NULL),
(38, '2021-05-11 01:36:19', '2021-05-11 01:37:39', 3, 'For Signature', '111', NULL, 3, 5, 55, '3,5,57', 7, 'forwarded', 'No', NULL),
(39, '2021-05-11 01:37:54', '2021-05-11 01:49:01', 3, 'For Review', '111', NULL, 3, 5, 57, '3,5,58', 2, 'forwarded', 'No', NULL),
(40, '2021-05-11 01:49:21', '2021-05-11 01:53:02', 3, 'For Signature', '111', NULL, 3, 5, 58, '3,5,57', 7, 'forwarded', 'No', NULL),
(41, '2021-05-11 01:53:19', '2021-05-11 01:54:01', 3, 'For Approval', '111', NULL, 3, 5, 57, '3,0,49', 1, 'forwarded', 'No', NULL),
(42, '2021-05-11 01:54:06', '2021-05-11 01:54:51', 3, 'For Approval', '111', NULL, 3, 0, 49, '1,0,1', 6, 'forwarded', 'No', NULL),
(43, '2021-05-11 01:54:56', '2021-05-11 01:57:44', 3, 'For Shopping', '111', NULL, 1, 0, 1, '3,0,59', 12, 'forwarded', 'No', NULL),
(44, '2021-05-11 01:57:50', '2021-05-11 01:57:50', 3, NULL, '111', NULL, 3, 0, 59, NULL, NULL, 'received', 'No', NULL),
(45, '2021-05-11 17:11:55', '2021-05-11 17:11:55', 2, NULL, '112', NULL, 3, 5, 55, NULL, NULL, 'received', 'No', NULL),
(46, '2021-05-11 17:21:05', '2021-05-11 17:21:05', 4, 'For Approval', '113', NULL, 3, 0, 52, '3,0,49', 1, 'origin', 'No', NULL),
(47, '2021-05-11 17:21:30', '2021-05-11 17:38:18', 4, 'Receiving for Processing', '113', NULL, 3, 0, 49, '3,5,55', 3, 'forwarded', 'No', NULL),
(48, '2021-05-11 17:38:47', '2021-05-11 17:38:47', 4, NULL, '113', NULL, 3, 5, 55, NULL, NULL, 'received', 'No', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `img_logs`
--

CREATE TABLE `img_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_status_logs_id_fk` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `img_logs`
--

INSERT INTO `img_logs` (`id`, `created_at`, `updated_at`, `filename`, `path`, `document_status_logs_id_fk`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-07 07:57:01', 'giphy.gif', 'profile/attachments/3,0,52/111/4/Img_Logs/giphy.gif', 1, NULL),
(2, '2021-05-09 16:25:41', '2021-05-09 16:25:41', '5.webp', 'profile/attachments/3,0,52/112/4/Img_Logs/5.webp', 2, NULL),
(3, '2021-05-10 02:28:03', '2021-05-10 02:28:03', '4.webp', 'profile/attachments/3,,0/111/1/Img_Logs/4.webp', 27, NULL),
(4, '2021-05-10 06:42:43', '2021-05-10 06:42:43', '9.webp', 'profile/attachments/3,0,49/112/1/Img_Logs/9.webp', 28, NULL),
(5, '2021-05-10 10:30:13', '2021-05-10 10:30:13', '2.webp', 'profile/attachments/3,5,55/111/3/Img_Logs/2.webp', 29, NULL),
(6, '2021-05-11 01:21:48', '2021-05-11 01:21:48', '4.webp', 'profile/attachments/3,5,58/111/2/Img_Logs/4.webp', 30, NULL),
(7, '2021-05-11 01:24:42', '2021-05-11 01:24:42', '13.webp', 'profile/attachments/3,5,57/111/7/Img_Logs/13.webp', 31, NULL),
(8, '2021-05-11 01:26:45', '2021-05-11 01:26:45', '7.webp', 'profile/attachments/3,0,54/111/9/Img_Logs/7.webp', 32, NULL),
(9, '2021-05-11 01:29:25', '2021-05-11 01:29:25', '10.webp', 'profile/attachments/3,0,53/111/10/Img_Logs/10.webp', 33, NULL),
(10, '2021-05-11 01:30:28', '2021-05-11 01:30:28', '11.webp', 'profile/attachments/3,0,54/111/9/Img_Logs/11.webp', 34, NULL),
(11, '2021-05-11 01:35:59', '2021-05-11 01:35:59', '3.webp', 'profile/attachments/3,0,54/111/9/Img_Logs/3.webp', 37, NULL),
(12, '2021-05-11 01:37:39', '2021-05-11 01:37:39', '9.webp', 'profile/attachments/3,5,55/111/3/Img_Logs/9.webp', 38, NULL),
(13, '2021-05-11 01:49:01', '2021-05-11 01:49:01', 'giphy.gif', 'profile/attachments/3,5,57/111/7/Img_Logs/giphy.gif', 39, NULL),
(14, '2021-05-11 01:53:02', '2021-05-11 01:53:02', '12.webp', 'profile/attachments/3,5,58/111/2/Img_Logs/12.webp', 40, NULL),
(15, '2021-05-11 01:54:01', '2021-05-11 01:54:01', '2.webp', 'profile/attachments/3,5,57/111/7/Img_Logs/2.webp', 41, NULL),
(16, '2021-05-11 01:54:51', '2021-05-11 01:54:51', '12.webp', 'profile/attachments/3,0,49/111/1/Img_Logs/12.webp', 42, NULL),
(17, '2021-05-11 01:57:44', '2021-05-11 01:57:44', '12.webp', 'profile/attachments/1,0,1/111/6/Img_Logs/12.webp', 43, NULL),
(18, '2021-05-11 17:21:05', '2021-05-11 17:21:05', '740full-ivana-alawi.jpg', 'profile/attachments/3,0,52/113/4/Img_Logs/740full-ivana-alawi.jpg', 46, NULL),
(49, '2021-05-11 17:38:18', '2021-05-11 17:38:18', '3.webp', 'profile/attachments/3,0,49/113/1/Img_Logs/3.webp', 47, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2021_03_16_084122_create_documents_status_logs_table', 1),
(8, '2021_03_16_084122_create_documents_table', 1),
(9, '2021_03_16_084122_create_particulars_table', 1),
(10, '2021_03_21_134239_create_sessions_table', 1),
(11, '2021_04_16_091336_create_notifications_table', 1),
(12, '2021_04_16_092315_create_events_table', 1),
(13, '2021_05_06_100355_create_offices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dtrack_id_fk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `created_at`, `updated_at`, `dtrack_id_fk`, `from`, `to`, `is_open`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-07 07:57:01', '111', 4, 1, 0, NULL),
(2, '2021-05-09 16:25:41', '2021-05-09 16:25:41', '112', 4, 1, 0, NULL),
(3, '2021-05-09 20:19:31', '2021-05-09 20:19:31', '111', 1, 4, 0, NULL),
(4, '2021-05-09 20:19:31', '2021-05-09 20:19:31', '111', 1, 4, 0, NULL),
(5, '2021-05-10 02:28:03', '2021-05-10 02:28:03', '111', 1, 4, 0, NULL),
(6, '2021-05-10 02:28:05', '2021-05-10 02:28:05', '111', 1, 3, 0, NULL),
(7, '2021-05-10 02:32:23', '2021-05-10 02:32:23', '112', 1, 4, 0, NULL),
(8, '2021-05-10 02:32:23', '2021-05-10 02:32:23', '112', 1, 4, 0, NULL),
(9, '2021-05-10 06:33:09', '2021-05-10 06:33:09', '111', 3, 4, 0, NULL),
(10, '2021-05-10 06:33:09', '2021-05-10 06:33:09', '111', 3, 1, 0, NULL),
(11, '2021-05-10 06:42:43', '2021-05-10 06:42:43', '112', 1, 4, 0, NULL),
(12, '2021-05-10 06:42:43', '2021-05-10 06:42:43', '112', 1, 3, 0, NULL),
(13, '2021-05-10 10:30:13', '2021-05-10 10:30:13', '111', 3, 4, 0, NULL),
(14, '2021-05-10 10:30:15', '2021-05-10 10:30:15', '111', 3, 2, 0, NULL),
(15, '2021-05-10 10:31:04', '2021-05-10 10:31:04', '111', 2, 4, 0, NULL),
(16, '2021-05-10 10:31:04', '2021-05-10 10:31:04', '111', 2, 3, 0, NULL),
(17, '2021-05-11 01:21:48', '2021-05-11 01:21:48', '111', 2, 4, 0, NULL),
(18, '2021-05-11 01:21:49', '2021-05-11 01:21:49', '111', 2, 7, 0, NULL),
(19, '2021-05-11 01:23:48', '2021-05-11 01:23:48', '111', 7, 4, 0, NULL),
(20, '2021-05-11 01:23:48', '2021-05-11 01:23:48', '111', 7, 2, 0, NULL),
(21, '2021-05-11 01:24:42', '2021-05-11 01:24:42', '111', 7, 4, 0, NULL),
(22, '2021-05-11 01:24:42', '2021-05-11 01:24:42', '111', 7, 9, 0, NULL),
(23, '2021-05-11 01:25:13', '2021-05-11 01:25:13', '111', 9, 4, 0, NULL),
(24, '2021-05-11 01:25:13', '2021-05-11 01:25:13', '111', 9, 7, 0, NULL),
(25, '2021-05-11 01:26:45', '2021-05-11 01:26:45', '111', 9, 4, 0, NULL),
(26, '2021-05-11 01:26:45', '2021-05-11 01:26:45', '111', 9, 10, 0, NULL),
(27, '2021-05-11 01:28:07', '2021-05-11 01:28:07', '111', 10, 4, 0, NULL),
(28, '2021-05-11 01:28:07', '2021-05-11 01:28:07', '111', 10, 9, 0, NULL),
(29, '2021-05-11 01:29:25', '2021-05-11 01:29:25', '111', 10, 4, 0, NULL),
(30, '2021-05-11 01:29:25', '2021-05-11 01:29:25', '111', 10, 9, 0, NULL),
(31, '2021-05-11 01:29:37', '2021-05-11 01:29:37', '111', 9, 4, 0, NULL),
(32, '2021-05-11 01:29:37', '2021-05-11 01:29:37', '111', 9, 10, 0, NULL),
(33, '2021-05-11 01:30:28', '2021-05-11 01:30:28', '111', 9, 4, 0, NULL),
(34, '2021-05-11 01:30:28', '2021-05-11 01:30:28', '111', 9, 10, 0, NULL),
(35, '2021-05-11 01:30:42', '2021-05-11 01:30:42', '111', 10, 4, 0, NULL),
(36, '2021-05-11 01:30:42', '2021-05-11 01:30:42', '111', 10, 9, 0, NULL),
(37, '2021-05-11 01:34:48', '2021-05-11 01:34:48', '111', 10, 4, 0, NULL),
(38, '2021-05-11 01:34:48', '2021-05-11 01:34:48', '111', 10, 9, 0, NULL),
(39, '2021-05-11 01:34:58', '2021-05-11 01:34:58', '111', 9, 4, 0, NULL),
(40, '2021-05-11 01:34:58', '2021-05-11 01:34:58', '111', 9, 10, 0, NULL),
(41, '2021-05-11 01:36:00', '2021-05-11 01:36:00', '111', 9, 4, 0, NULL),
(42, '2021-05-11 01:36:00', '2021-05-11 01:36:00', '111', 9, 3, 0, NULL),
(43, '2021-05-11 01:36:19', '2021-05-11 01:36:19', '111', 3, 4, 0, NULL),
(44, '2021-05-11 01:36:19', '2021-05-11 01:36:19', '111', 3, 9, 0, NULL),
(45, '2021-05-11 01:37:39', '2021-05-11 01:37:39', '111', 3, 4, 0, NULL),
(46, '2021-05-11 01:37:39', '2021-05-11 01:37:39', '111', 3, 7, 0, NULL),
(47, '2021-05-11 01:37:54', '2021-05-11 01:37:54', '111', 7, 4, 0, NULL),
(48, '2021-05-11 01:37:54', '2021-05-11 01:37:54', '111', 7, 3, 0, NULL),
(49, '2021-05-11 01:49:01', '2021-05-11 01:49:01', '111', 7, 4, 0, NULL),
(50, '2021-05-11 01:49:01', '2021-05-11 01:49:01', '111', 7, 2, 0, NULL),
(51, '2021-05-11 01:49:21', '2021-05-11 01:49:21', '111', 2, 4, 0, NULL),
(52, '2021-05-11 01:49:21', '2021-05-11 01:49:21', '111', 2, 7, 0, NULL),
(53, '2021-05-11 01:53:02', '2021-05-11 01:53:02', '111', 2, 4, 0, NULL),
(54, '2021-05-11 01:53:03', '2021-05-11 01:53:03', '111', 2, 7, 0, NULL),
(55, '2021-05-11 01:53:19', '2021-05-11 01:53:19', '111', 7, 4, 0, NULL),
(56, '2021-05-11 01:53:19', '2021-05-11 01:53:19', '111', 7, 2, 0, NULL),
(57, '2021-05-11 01:54:01', '2021-05-11 01:54:01', '111', 7, 4, 0, NULL),
(58, '2021-05-11 01:54:02', '2021-05-11 01:54:02', '111', 7, 1, 0, NULL),
(59, '2021-05-11 01:54:06', '2021-05-11 01:54:06', '111', 1, 4, 0, NULL),
(60, '2021-05-11 01:54:06', '2021-05-11 01:54:06', '111', 1, 7, 0, NULL),
(61, '2021-05-11 01:54:51', '2021-05-11 01:54:51', '111', 1, 4, 0, NULL),
(62, '2021-05-11 01:54:51', '2021-05-11 01:54:51', '111', 1, 6, 0, NULL),
(63, '2021-05-11 01:54:56', '2021-05-11 01:54:56', '111', 6, 4, 0, NULL),
(64, '2021-05-11 01:54:56', '2021-05-11 01:54:56', '111', 6, 1, 0, NULL),
(65, '2021-05-11 01:57:44', '2021-05-11 01:57:44', '111', 6, 4, 0, NULL),
(66, '2021-05-11 01:57:44', '2021-05-11 01:57:44', '111', 6, 12, 0, NULL),
(67, '2021-05-11 01:57:50', '2021-05-11 01:57:50', '111', 12, 4, 0, NULL),
(68, '2021-05-11 01:57:50', '2021-05-11 01:57:50', '111', 12, 6, 0, NULL),
(69, '2021-05-11 17:11:55', '2021-05-11 17:11:55', '112', 3, 4, 0, NULL),
(70, '2021-05-11 17:11:57', '2021-05-11 17:11:57', '112', 3, 1, 0, NULL),
(71, '2021-05-11 17:21:05', '2021-05-11 17:21:05', '113', 4, 1, 0, NULL),
(72, '2021-05-11 17:21:30', '2021-05-11 17:21:30', '113', 1, 4, 0, NULL),
(73, '2021-05-11 17:21:30', '2021-05-11 17:21:30', '113', 1, 4, 0, NULL),
(74, '2021-05-11 17:38:18', '2021-05-11 17:38:18', '113', 1, 4, 0, NULL),
(75, '2021-05-11 17:38:18', '2021-05-11 17:38:18', '113', 1, 3, 0, NULL),
(76, '2021-05-11 17:38:47', '2021-05-11 17:38:47', '113', 3, 4, 0, NULL),
(77, '2021-05-11 17:38:48', '2021-05-11 17:38:48', '113', 3, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_events`
--

CREATE TABLE `notification_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_text` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id_fk` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_events`
--

INSERT INTO `notification_events` (`id`, `created_at`, `updated_at`, `event_type`, `event_text`, `event_id_fk`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-07 07:57:01', 'Created a Document', 'Gladys Buladaco created a Purchase Request Document forwarded to you. Subject for: For Approval', 1, NULL),
(2, '2021-05-09 16:25:41', '2021-05-09 16:25:41', 'Created a Document', 'Gladys Buladaco created a Accomplishment Report Document forwarded to you. Subject for: For Signature', 2, NULL),
(3, '2021-05-09 20:19:31', '2021-05-09 20:19:31', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-07 03:57:01', 3, NULL),
(4, '2021-05-09 20:19:31', '2021-05-09 20:19:31', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-07 03:57:01', 4, NULL),
(5, '2021-05-10 02:28:03', '2021-05-10 02:28:03', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 10:28:03', 5, NULL),
(6, '2021-05-10 02:28:05', '2021-05-10 02:28:05', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 10:28:03', 6, NULL),
(7, '2021-05-10 02:32:23', '2021-05-10 02:32:23', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 112 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-10 12:25:41', 7, NULL),
(8, '2021-05-10 02:32:23', '2021-05-10 02:32:23', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 112 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-10 12:25:41', 8, NULL),
(9, '2021-05-10 06:33:09', '2021-05-10 06:33:09', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-10 10:28:03', 9, NULL),
(10, '2021-05-10 06:33:09', '2021-05-10 06:33:09', 'Logged a Document', 'Greetings Ms. Sacol, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-10 10:28:03', 10, NULL),
(11, '2021-05-10 06:42:43', '2021-05-10 06:42:43', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 112 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 02:42:43', 11, NULL),
(12, '2021-05-10 06:42:43', '2021-05-10 06:42:43', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 112 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 02:42:43', 12, NULL),
(13, '2021-05-10 10:30:13', '2021-05-10 10:30:13', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 06:30:13', 13, NULL),
(14, '2021-05-10 10:30:15', '2021-05-10 10:30:15', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-10 06:30:13', 14, NULL),
(15, '2021-05-10 10:31:04', '2021-05-10 10:31:04', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Budget\n Received Date: 2021-05-10 06:30:13', 15, NULL),
(16, '2021-05-10 10:31:04', '2021-05-10 10:31:04', 'Logged a Document', 'Greetings Ms. Cecille, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Budget\n Received Date: 2021-05-10 06:30:13', 16, NULL),
(17, '2021-05-11 01:21:48', '2021-05-11 01:21:48', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:21:48', 17, NULL),
(18, '2021-05-11 01:21:49', '2021-05-11 01:21:49', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:21:48', 18, NULL),
(19, '2021-05-11 01:23:48', '2021-05-11 01:23:48', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:21:48', 19, NULL),
(20, '2021-05-11 01:23:48', '2021-05-11 01:23:48', 'Logged a Document', 'Greetings Ms. Pingal, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:21:48', 20, NULL),
(21, '2021-05-11 01:24:42', '2021-05-11 01:24:42', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:24:42', 21, NULL),
(22, '2021-05-11 01:24:42', '2021-05-11 01:24:42', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:24:42', 22, NULL),
(23, '2021-05-11 01:25:13', '2021-05-11 01:25:13', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:24:42', 23, NULL),
(24, '2021-05-11 01:25:13', '2021-05-11 01:25:13', 'Logged a Document', 'Greetings Mr. Wilkinson, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:24:42', 24, NULL),
(25, '2021-05-11 01:26:45', '2021-05-11 01:26:45', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:26:45', 25, NULL),
(26, '2021-05-11 01:26:45', '2021-05-11 01:26:45', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:26:45', 26, NULL),
(27, '2021-05-11 01:28:07', '2021-05-11 01:28:07', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: BACSec\n Received Date: 2021-05-11 09:26:45', 27, NULL),
(28, '2021-05-11 01:28:07', '2021-05-11 01:28:07', 'Logged a Document', 'Greetings Ms. Peck, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: BACSec\n Received Date: 2021-05-11 09:26:45', 28, NULL),
(29, '2021-05-11 01:29:25', '2021-05-11 01:29:25', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:29:25', 29, NULL),
(30, '2021-05-11 01:29:25', '2021-05-11 01:29:25', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:29:25', 30, NULL),
(31, '2021-05-11 01:29:37', '2021-05-11 01:29:37', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:29:25', 31, NULL),
(32, '2021-05-11 01:29:37', '2021-05-11 01:29:37', 'Logged a Document', 'Greetings Mr. Lindsey, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:29:25', 32, NULL),
(33, '2021-05-11 01:30:28', '2021-05-11 01:30:28', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:30:28', 33, NULL),
(34, '2021-05-11 01:30:28', '2021-05-11 01:30:28', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:30:28', 34, NULL),
(35, '2021-05-11 01:30:42', '2021-05-11 01:30:42', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: BACSec\n Received Date: 2021-05-11 09:30:28', 35, NULL),
(36, '2021-05-11 01:30:42', '2021-05-11 01:30:42', 'Logged a Document', 'Greetings Ms. Peck, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: BACSec\n Received Date: 2021-05-11 09:30:28', 36, NULL),
(37, '2021-05-11 01:34:48', '2021-05-11 01:34:48', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:34:48', 37, NULL),
(38, '2021-05-11 01:34:48', '2021-05-11 01:34:48', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:34:48', 38, NULL),
(39, '2021-05-11 01:34:58', '2021-05-11 01:34:58', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:34:48', 39, NULL),
(40, '2021-05-11 01:34:58', '2021-05-11 01:34:58', 'Logged a Document', 'Greetings Mr. Lindsey, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Procurement Unit\n Received Date: 2021-05-11 09:34:48', 40, NULL),
(41, '2021-05-11 01:36:00', '2021-05-11 01:36:00', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 41, NULL),
(42, '2021-05-11 01:36:00', '2021-05-11 01:36:00', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 42, NULL),
(43, '2021-05-11 01:36:19', '2021-05-11 01:36:19', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-11 09:35:59', 43, NULL),
(44, '2021-05-11 01:36:19', '2021-05-11 01:36:19', 'Logged a Document', 'Greetings Ms. Peck, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-11 09:35:59', 44, NULL),
(45, '2021-05-11 01:37:39', '2021-05-11 01:37:39', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 45, NULL),
(46, '2021-05-11 01:37:39', '2021-05-11 01:37:39', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 46, NULL),
(47, '2021-05-11 01:37:54', '2021-05-11 01:37:54', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:37:39', 47, NULL),
(48, '2021-05-11 01:37:54', '2021-05-11 01:37:54', 'Logged a Document', 'Greetings Ms. Cecille, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:37:39', 48, NULL),
(49, '2021-05-11 01:49:01', '2021-05-11 01:49:01', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 49, NULL),
(50, '2021-05-11 01:49:01', '2021-05-11 01:49:01', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 50, NULL),
(51, '2021-05-11 01:49:21', '2021-05-11 01:49:21', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Budget\n Received Date: 2021-05-11 09:49:01', 51, NULL),
(52, '2021-05-11 01:49:21', '2021-05-11 01:49:21', 'Logged a Document', 'Greetings Mr. Wilkinson, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Budget\n Received Date: 2021-05-11 09:49:01', 52, NULL),
(53, '2021-05-11 01:53:02', '2021-05-11 01:53:02', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 53, NULL),
(54, '2021-05-11 01:53:03', '2021-05-11 01:53:03', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Legal\n Forward Date: 2021-05-11 09:35:59', 54, NULL),
(55, '2021-05-11 01:53:19', '2021-05-11 01:53:19', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:53:02', 55, NULL),
(56, '2021-05-11 01:53:19', '2021-05-11 01:53:19', 'Logged a Document', 'Greetings Ms. Pingal, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Accounting\n Received Date: 2021-05-11 09:53:02', 56, NULL),
(57, '2021-05-11 01:54:01', '2021-05-11 01:54:01', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 57, NULL),
(58, '2021-05-11 01:54:02', '2021-05-11 01:54:02', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 58, NULL),
(59, '2021-05-11 01:54:06', '2021-05-11 01:54:06', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-11 09:54:01', 59, NULL),
(60, '2021-05-11 01:54:06', '2021-05-11 01:54:06', 'Logged a Document', 'Greetings Mr. Wilkinson, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-11 09:54:01', 60, NULL),
(61, '2021-05-11 01:54:51', '2021-05-11 01:54:51', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: RD/ARD DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 61, NULL),
(62, '2021-05-11 01:54:51', '2021-05-11 01:54:51', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: RD/ARD DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 62, NULL),
(63, '2021-05-11 01:54:56', '2021-05-11 01:54:56', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: RD/ARD DIVISION\n Cluster: N/A\n Office: RD\'s Office\n Received Date: 2021-05-11 09:54:51', 63, NULL),
(64, '2021-05-11 01:54:56', '2021-05-11 01:54:56', 'Logged a Document', 'Greetings Ms. Sacol, the document with the DTRAK No. 111 has been received by Division: Division: RD/ARD DIVISION\n Cluster: N/A\n Office: RD\'s Office\n Received Date: 2021-05-11 09:54:51', 64, NULL),
(65, '2021-05-11 01:57:44', '2021-05-11 01:57:44', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 65, NULL),
(66, '2021-05-11 01:57:44', '2021-05-11 01:57:44', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: N/A\n Forward Date: 2021-05-11 09:35:59', 66, NULL),
(67, '2021-05-11 01:57:50', '2021-05-11 01:57:50', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Supply Unit\n Received Date: 2021-05-11 09:57:44', 67, NULL),
(68, '2021-05-11 01:57:50', '2021-05-11 01:57:50', 'Logged a Document', 'Greetings Mr. Cassion, the document with the DTRAK No. 111 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: Supply Unit\n Received Date: 2021-05-11 09:57:44', 68, NULL),
(69, '2021-05-11 17:11:55', '2021-05-11 17:11:55', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 112 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-10 02:42:43', 69, NULL),
(70, '2021-05-11 17:11:57', '2021-05-11 17:11:57', 'Logged a Document', 'Greetings Ms. Sacol, the document with the DTRAK No. 112 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-10 02:42:43', 70, NULL),
(71, '2021-05-11 17:21:05', '2021-05-11 17:21:05', 'Created a Document', 'Gladys Buladaco created a Purchase Request Document forwarded to you. Subject for: For Approval', 71, NULL),
(72, '2021-05-11 17:21:30', '2021-05-11 17:21:30', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 113 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-12 01:21:05', 72, NULL),
(73, '2021-05-11 17:21:30', '2021-05-11 17:21:30', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 113 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: N/A\n Office: MSD Division Chief Office\n Received Date: 2021-05-12 01:21:05', 73, NULL),
(74, '2021-05-11 17:38:18', '2021-05-11 17:38:18', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 113 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Forward Date: 2021-05-12 01:38:18', 74, NULL),
(75, '2021-05-11 17:38:18', '2021-05-11 17:38:18', 'Received and Route a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 113 has been forwarded to Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Forward Date: 2021-05-12 01:38:18', 75, NULL),
(76, '2021-05-11 17:38:47', '2021-05-11 17:38:47', 'Logged a Document', 'Greetings Ms. Buladaco, the document with the DTRAK No. 113 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-12 01:38:18', 76, NULL),
(77, '2021-05-11 17:38:48', '2021-05-11 17:38:48', 'Logged a Document', 'Greetings Ms. Sacol, the document with the DTRAK No. 113 has been received by Division: Division: MANAGEMENT SUPPORT DIVISION\n Cluster: FINANCE SECTION\n Office: Finance Receiving Office\n Received Date: 2021-05-12 01:38:18', 77, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offices_cluster`
--

CREATE TABLE `offices_cluster` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `offices_division_id_fk` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signatory` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices_cluster`
--

INSERT INTO `offices_cluster` (`id`, `offices_division_id_fk`, `name`, `signatory`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'GOVERNANCE CLUSTER', 0, NULL, NULL, NULL),
(2, 2, 'INFECTIOUS CLUSTER', 0, NULL, NULL, NULL),
(3, 2, 'FAMILY HEALTH CLUSTER', 0, NULL, NULL, NULL),
(4, 2, 'NonCom/NVBSP/ENVIRONMENTAL CLUSTER', 0, NULL, NULL, NULL),
(5, 3, 'FINANCE SECTION', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offices_division`
--

CREATE TABLE `offices_division` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signatory` bigint(20) NOT NULL,
  `has_cluster` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices_division`
--

INSERT INTO `offices_division` (`id`, `name`, `signatory`, `has_cluster`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'RD/ARD DIVISION', 0, 0, NULL, NULL, NULL),
(2, 'LHSD DIVISION', 0, 1, NULL, NULL, NULL),
(3, 'MANAGEMENT SUPPORT DIVISION', 0, 1, NULL, NULL, NULL),
(4, 'RLED DIVISION', 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offices_office`
--

CREATE TABLE `offices_office` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `offices_division_id_fk` bigint(20) NOT NULL,
  `offices_cluster_id_fk` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signatory` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices_office`
--

INSERT INTO `offices_office` (`id`, `offices_division_id_fk`, `offices_cluster_id_fk`, `name`, `signatory`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'RD\'s Office', 0, NULL, NULL, NULL),
(2, 1, 0, 'ARD\'s Office', 0, NULL, NULL, NULL),
(3, 1, 0, 'Planning', 0, NULL, NULL, NULL),
(4, 1, 0, 'PACD', 0, NULL, NULL, NULL),
(5, 1, 0, 'Legal', 0, NULL, NULL, NULL),
(6, 1, 0, 'QMS', 0, NULL, NULL, NULL),
(7, 1, 0, 'RESU-HEMS', 0, NULL, NULL, NULL),
(8, 1, 0, 'RESEARCH', 0, NULL, NULL, NULL),
(9, 1, 0, 'PolyClinic', 0, NULL, NULL, NULL),
(10, 1, 0, 'PDOHO-ADN', 0, NULL, NULL, NULL),
(11, 1, 0, 'CDOHO', 0, NULL, NULL, NULL),
(12, 1, 0, 'PDOHO-ADS', 0, NULL, NULL, NULL),
(13, 1, 0, 'PDOHO-PDI', 0, NULL, NULL, NULL),
(14, 1, 0, 'PDOHO-SDN', 0, NULL, NULL, NULL),
(15, 1, 0, 'PDOHO-SDS', 0, NULL, NULL, NULL),
(16, 2, 0, 'LHSD Division Chief Office', 0, NULL, NULL, NULL),
(17, 2, 1, 'Governance Cluster Head Office', 0, NULL, NULL, NULL),
(18, 2, 1, 'BHW', 0, NULL, NULL, NULL),
(19, 2, 1, 'IP-GIDA', 0, NULL, NULL, NULL),
(20, 2, 1, 'LIPH', 0, NULL, NULL, NULL),
(21, 2, 1, 'UHC & HLGP', 0, NULL, NULL, NULL),
(22, 2, 1, 'PD', 0, NULL, NULL, NULL),
(23, 2, 1, 'MAIP', 0, NULL, NULL, NULL),
(24, 2, 1, 'HFEP', 0, NULL, NULL, NULL),
(25, 2, 1, 'Helpline Desk', 0, NULL, NULL, NULL),
(26, 2, 2, 'Infectious Cluster', 0, NULL, NULL, NULL),
(27, 2, 2, 'Rabies & Leprosy', 0, NULL, NULL, NULL),
(28, 2, 2, 'HIV', 0, NULL, NULL, NULL),
(29, 2, 2, 'TB', 0, NULL, NULL, NULL),
(30, 2, 2, 'Filariasis/Schisto/STH/FWBD', 0, NULL, NULL, NULL),
(31, 2, 2, 'Malaria', 0, NULL, NULL, NULL),
(32, 2, 2, 'EREID', 0, NULL, NULL, NULL),
(33, 2, 2, 'Dengue', 0, NULL, NULL, NULL),
(34, 2, 2, 'Hospital Operations', 0, NULL, NULL, NULL),
(35, 2, 3, 'Family Health Cluster Head Office', 0, NULL, NULL, NULL),
(36, 2, 3, 'MNCHN', 0, NULL, NULL, NULL),
(37, 2, 3, 'FP', 0, NULL, NULL, NULL),
(38, 2, 3, 'EPI and Child Injury', 0, NULL, NULL, NULL),
(39, 2, 3, 'NBS', 0, NULL, NULL, NULL),
(40, 2, 3, 'Adolescent', 0, NULL, NULL, NULL),
(41, 2, 3, 'Nutrition', 0, NULL, NULL, NULL),
(42, 2, 3, 'Oral Health', 0, NULL, NULL, NULL),
(43, 2, 3, 'Sr. Citizen', 0, NULL, NULL, NULL),
(44, 2, 4, 'NonCom/NVBSP/Environmental Cluster Head Office', 0, NULL, NULL, NULL),
(45, 2, 4, 'NonCommunicable Diseases', 0, NULL, NULL, NULL),
(46, 2, 4, 'Person with Disability', 0, NULL, NULL, NULL),
(47, 2, 4, 'Environmental & Occupational Health', 0, NULL, NULL, NULL),
(48, 2, 4, 'NVBSP', 0, NULL, NULL, NULL),
(49, 3, 0, 'MSD Division Chief Office', 0, NULL, NULL, NULL),
(50, 3, 0, 'Health Promotion', 0, NULL, NULL, NULL),
(51, 3, 0, 'HRDMU', 0, NULL, NULL, NULL),
(52, 3, 0, 'KMICT/Records', 0, NULL, NULL, NULL),
(53, 3, 0, 'BACSec', 0, NULL, NULL, NULL),
(54, 3, 0, 'Procurement Unit', 0, NULL, NULL, NULL),
(55, 3, 5, 'Finance Receiving Office', 0, NULL, NULL, NULL),
(56, 3, 5, 'Cashier', 0, NULL, NULL, NULL),
(57, 3, 5, 'Accounting', 0, NULL, NULL, NULL),
(58, 3, 5, 'Budget', 0, NULL, NULL, NULL),
(59, 3, 0, 'Supply Unit', 0, NULL, NULL, NULL),
(60, 3, 0, 'Transport', 0, NULL, NULL, NULL),
(61, 3, 0, 'General Services', 0, NULL, NULL, NULL),
(62, 3, 0, 'GAD', 0, NULL, NULL, NULL),
(63, 4, 0, 'RLED Division Chief ', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `particulars`
--

CREATE TABLE `particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Item` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_qty` int(11) NOT NULL,
  `item_unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_amount` double(8,2) NOT NULL,
  `dtrack_id_fk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `particulars`
--

INSERT INTO `particulars` (`id`, `created_at`, `updated_at`, `Item`, `item_qty`, `item_unit`, `item_amount`, `dtrack_id_fk`, `purpose`, `deleted_at`) VALUES
(1, '2021-05-07 07:57:01', '2021-05-07 07:57:01', 'Molestias ex anim it', 20, 'unit', 175000.00, '111', 'Nulla unde reprehend', NULL),
(2, '2021-05-11 17:21:05', '2021-05-11 17:21:05', 'Flashdrive', 250, 'pcs', 62500.00, '113', 'char', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7yP5kv3pzJ0C9o6nKCOlTq0dO83a5MgJwf81nA2Y', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNHpKRzFQUTJ0YUdidm9helppNnZ1cEM0V0JVdW53SE1vb0V0VHhsSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kb2gucHJvdHJhaWxtaXMuY28vb2ZmaWNlL2luZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJGl2LmM5Y2R5bS4xR1gwRmZmNDk4N2VZWHhaSk1BczRxdUpHak50cHNBZVpRZnBEaS8xcjd1IjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRpdi5jOWNkeW0uMUdYMEZmZjQ5ODdlWVh4WkpNQXM0cXVKR2pOdHBzQWVaUWZwRGkvMXI3dSI7fQ==', 1620790048),
('nJoIKbmd4Nl1HSSEyOiYPzrwDWw761Z0XW9X1RZ5', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQWNBcjdOcE1hU0xBWVdMa21QRlNmY29ENHA3QVFrTU9PaTJHZzBrTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kb2gucHJvdHJhaWxtaXMuY28vb2ZmaWNlL2luZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEZtSEI3TWlEY3NnRlhMLmc5VnY0R2VoZEdKcE1nSnFIY3JJRUg1cHk3YTdlQlouUjRlYlhxIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRGbUhCN01pRGNzZ0ZYTC5nOVZ2NEdlaGRHSnBNZ0pxSGNySUVINXB5N2E3ZUJaLlI0ZWJYcSI7fQ==', 1620791591),
('viPlh0ajGMUfiIE0UGvhP6ayaUvGWTUhsx99LgJF', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicDUxMmFmbWQ0c1RrWlJwRlZ6YlQ2MG1PRm1xcFJ6REU0Q1M0MWdSOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9kb2gucHJvdHJhaWxtaXMuY28vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkUzkwWVVkSWdlUzZ1dXpKQ052YVV5ZXViVmxSVnk4UC83YjBvQ2R6M21qWUNFM1A5Vkp5SHUiO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFM5MFlVZElnZVM2dXV6SkNOdmFVeWV1YlZsUlZ5OFAvN2Iwb0NkejNtallDRTNQOVZKeUh1Ijt9', 1620791312);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `user_role`, `remember_token`, `current_team_id`, `profile_photo_path`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'aileen@gmail.com', NULL, '$2y$10$MMzA9uvyU7he7xI2vZJ6Ee8zep/jhgtW6srpvLA01K5Kbnj8jtZRW', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-07 05:38:18', '2021-05-07 05:38:18'),
(2, 'jeanpingal@gmail.com', NULL, '$2y$10$S90YUdIgeS6uuzJCNvaUyeubVlRVy8P/7b0oCdz3mjYCE3P9VJyHu', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-07 05:39:49', '2021-05-07 05:39:49'),
(3, 'cecille@gmail.com', NULL, '$2y$10$FmHB7MiDcsgFXL.g9Vv4GehdGJpMgJqHcrIEH5py7a7eBZ.R4ebXq', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-07 05:40:55', '2021-05-07 05:40:55'),
(4, 'gladysdb@gmail.com', NULL, '$2y$10$iv.c9cdym.1GX0Fff4987eYXxZJMAs4quJGjNtpsAeZQfpDi/1r7u', NULL, NULL, 'office', NULL, NULL, 'profile-photos/G2Trf8B317NId6czshSzQ2my2ShzjxPfbfQR12QV.jpg', NULL, '2021-05-07 06:39:30', '2021-05-07 08:13:57'),
(5, 'ceojhonpaul@gmail.com', NULL, '$2y$10$GDjDKl1cGmb1d/c9g.oX4eKwuYGp1VGMCJTNr2O/PlL.4UOoQzkRW', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-07 07:13:50', '2021-05-07 07:13:50'),
(6, 'Ceasar@gmail.com', NULL, '$2y$10$orZuObYurpnkj.3L1diJw.loYWbEyNqGiMZdfNzZRvOTTRTDLa/iW', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-10 09:47:38', '2021-05-10 09:47:38'),
(7, 'accounting@gmail.com', NULL, '$2y$10$25anRybtnq/vq5FlvFLlJO6oYNnmqCgJaCsLjFlUehi9TEe09fmRu', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:15:02', '2021-05-11 01:15:02'),
(8, 'cashier@gmail.com', NULL, '$2y$10$lk9SqOjYJACXXCvYARN8XeDd/xdY5oFFNyFExklCQS9RilzPXL3gO', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:16:23', '2021-05-11 01:16:23'),
(9, 'procurement@gmail.com', NULL, '$2y$10$rM6e.GgxjzqZbUOLFzQ92eUIT/A7uq6a25CR6X1Of7dY61w6NRLRu', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:18:46', '2021-05-11 01:18:46'),
(10, 'bacsec@gmail.com', NULL, '$2y$10$mS9Ybl.cBz1bGEZdiALKvOJf.Ow3zLFV6a.tivzv9f75JeV4jW62i', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:20:02', '2021-05-11 01:20:02'),
(11, 'ard@gmail.com', NULL, '$2y$10$pQHUO/hHJwXN3jl7FTylfefUQ2MtCUwB/iMCyjR1krkcRYmY4YJrS', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:21:04', '2021-05-11 01:21:04'),
(12, 'supply@gmail.com', NULL, '$2y$10$8aVglbFnLaVHubuM9nui/OGKW.8V5lV6uCd.vRpCO/k4ns37.QBS6', NULL, NULL, 'office', NULL, NULL, NULL, NULL, '2021-05-11 01:56:20', '2021-05-11 01:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id_fk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cluster` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_details`
--

INSERT INTO `users_details` (`id`, `user_id_fk`, `fname`, `mname`, `lname`, `gender`, `contact`, `cluster`, `office`, `division`, `position`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '1', 'Aileen', 'S.', 'Sacol', 'Female', '09272677689', '0', '49', '3', 'AO 4', NULL, '2021-05-07 05:38:18', '2021-05-07 05:38:18'),
(2, '2', 'Jean', 'P.', 'Pingal', 'Female', '09272677689', '5', '58', '3', 'Budget Officer', NULL, '2021-05-07 05:39:49', '2021-05-07 05:39:49'),
(3, '3', 'Cecille', 'C.', 'Cecille', 'Female', '09272677689', '5', '55', '3', 'AA 1', NULL, '2021-05-07 05:40:55', '2021-05-07 05:40:55'),
(4, '4', 'Gladys', 'Dalago', 'Buladaco', 'Female', '09272677689', '0', '52', '3', 'dsdsds', NULL, '2021-05-07 06:39:30', '2021-05-07 08:13:57'),
(5, '5', 'John Paul', 'Amper', 'Quiñal', 'Female', '09272677689', '0', '52', '3', 'CP 1', NULL, '2021-05-07 07:13:50', '2021-05-07 07:13:50'),
(6, '6', 'Ceasar', 'RD CASSION', 'Cassion', 'Male', '09272677689', '0', '1', '1', 'Regional Director', NULL, '2021-05-10 09:47:38', '2021-05-10 09:47:38'),
(7, '7', 'Gisela', 'Mohammad Alexander', 'Wilkinson', 'Male', '09272677689', '5', '57', '3', 'Accounting Officer', NULL, '2021-05-11 01:15:02', '2021-05-11 01:15:02'),
(8, '8', 'Donna', 'Destiny Brennan', 'Garcia', 'Female', '09272677689', '5', '56', '3', 'Cashier', NULL, '2021-05-11 01:16:23', '2021-05-11 01:16:23'),
(9, '9', 'Colt', 'Debra Weiss', 'Peck', 'Female', '09272677689', '0', '54', '3', 'Procurement Officer', NULL, '2021-05-11 01:18:46', '2021-05-11 01:18:46'),
(10, '10', 'Branden', 'Malachi Sutton', 'Lindsey', 'Male', '09272677689', '0', '53', '3', 'BAC SEC', NULL, '2021-05-11 01:20:02', '2021-05-11 01:20:02'),
(11, '11', 'Emerald', 'Plato Grimes', 'Valenzuela', 'Female', '0927267689', '0', '2', '1', 'ARD', NULL, '2021-05-11 01:21:04', '2021-05-11 01:21:04'),
(12, '12', 'Henry', 'Lance Cooper', 'Moore', 'Female', '09272677689', '0', '59', '3', 'Supply Officer', NULL, '2021-05-11 01:56:20', '2021-05-11 01:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_mutation`
--
ALTER TABLE `documents_mutation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_mutation_logs`
--
ALTER TABLE `documents_mutation_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_mutation_status_logs`
--
ALTER TABLE `documents_mutation_status_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_status_logs`
--
ALTER TABLE `documents_status_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `img_logs`
--
ALTER TABLE `img_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_events`
--
ALTER TABLE `notification_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices_cluster`
--
ALTER TABLE `offices_cluster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices_division`
--
ALTER TABLE `offices_division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices_office`
--
ALTER TABLE `offices_office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `particulars`
--
ALTER TABLE `particulars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents_mutation`
--
ALTER TABLE `documents_mutation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents_mutation_logs`
--
ALTER TABLE `documents_mutation_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents_mutation_status_logs`
--
ALTER TABLE `documents_mutation_status_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents_status_logs`
--
ALTER TABLE `documents_status_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_logs`
--
ALTER TABLE `img_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `notification_events`
--
ALTER TABLE `notification_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `offices_cluster`
--
ALTER TABLE `offices_cluster`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `offices_division`
--
ALTER TABLE `offices_division`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offices_office`
--
ALTER TABLE `offices_office`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `particulars`
--
ALTER TABLE `particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
