-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 06:56 PM
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
-- Database: `emart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_code` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_users`
--

CREATE TABLE `block_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `blocked_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(512) NOT NULL,
  `slug` varchar(512) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(512) NOT NULL,
  `tags` varchar(191) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `parent_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `sequence`, `name`, `image`, `parent_category_id`, `description`, `status`, `created_at`, `updated_at`, `slug`) VALUES
(1, NULL, 'sdf32', 'C:\\xampp\\tmp\\php2596.tmp', NULL, 'dsf', 0, '2025-02-13 12:35:20', '2025-02-13 13:22:06', 'sdf'),
(2, NULL, 'Restaurants', 'category/67ae3415d9ad67.287528171739469845.png', 1, NULL, 0, '2025-02-13 13:04:07', '2025-02-13 13:04:07', 'restaurants');

-- --------------------------------------------------------

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `item_offer_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(191) DEFAULT NULL,
  `file` varchar(191) DEFAULT NULL,
  `audio` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_code` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `country_code` char(2) NOT NULL,
  `latitude` decimal(8,2) DEFAULT NULL,
  `longitude` decimal(8,2) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL,
  `wikiDataId` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numeric_code` char(3) DEFAULT NULL,
  `iso2` char(2) DEFAULT NULL,
  `phonecode` varchar(255) DEFAULT NULL,
  `capital` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `currency_name` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  `tld` varchar(255) DEFAULT NULL,
  `native` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `subregion` varchar(255) DEFAULT NULL,
  `subregion_id` int(11) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `timezones` text DEFAULT NULL,
  `translations` text DEFAULT NULL,
  `latitude` decimal(8,2) DEFAULT NULL,
  `longitude` decimal(8,2) DEFAULT NULL,
  `emoji` varchar(191) DEFAULT NULL,
  `emojiU` varchar(191) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL,
  `wikiDataId` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `values` text DEFAULT NULL,
  `min_length` int(11) DEFAULT NULL,
  `max_length` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `name`, `type`, `image`, `required`, `values`, `min_length`, `max_length`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TEST', 'textbox', 'custom-fields/67aede9917fec6.362457621739513497.png', 0, NULL, 22, 12, 0, '2025-02-14 01:11:39', '2025-02-14 01:11:39'),
(2, 'Rental Service', 'fileinput', 'custom-fields/67aedf9ea57e24.505634071739513758.jpeg', 0, NULL, 12, 123, 0, '2025-02-14 01:15:58', '2025-02-14 01:15:58'),
(3, 'hassannasir12361236', 'number', 'custom-fields/67aee14771cf63.980101541739514183.png', 0, NULL, 213, 123, 0, '2025-02-14 01:23:06', '2025-02-14 01:23:06'),
(4, 'hassannasir12361236', 'fileinput', 'custom-fields/67aee19c6da712.310091371739514268.png', 0, NULL, 34, 32, 0, '2025-02-14 01:24:28', '2025-02-14 01:24:28'),
(5, 'TEST', 'number', 'custom-fields/67aee32f937f65.874215071739514671.png', 0, NULL, 23, 23, 0, '2025-02-14 01:31:11', '2025-02-14 01:31:11'),
(6, 'Restaurants', 'number', 'custom-fields/67aee36f8fb463.629878521739514735.png', 0, NULL, 34, 34, 0, '2025-02-14 01:32:15', '2025-02-14 01:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_categories`
--

CREATE TABLE `custom_field_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `custom_field_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_field_categories`
--

INSERT INTO `custom_field_categories` (`id`, `category_id`, `custom_field_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2025-02-14 01:32:15', '2025-02-14 01:32:15'),
(2, 2, 6, '2025-02-14 01:32:15', '2025-02-14 01:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) NOT NULL,
  `answer` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `featured_items`
--

CREATE TABLE `featured_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `user_purchased_package_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feature_sections`
--

CREATE TABLE `feature_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `filter` varchar(191) NOT NULL,
  `value` varchar(191) DEFAULT NULL,
  `style` varchar(191) NOT NULL,
  `min_price` int(11) DEFAULT NULL,
  `max_price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` varchar(191) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(191) NOT NULL,
  `show_only_to_premium` tinyint(1) NOT NULL,
  `status` enum('review','approved','rejected','sold out') NOT NULL,
  `rejected_reason` varchar(191) DEFAULT NULL,
  `video_link` varchar(191) DEFAULT NULL,
  `city` varchar(191) NOT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) NOT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sold_to` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `all_category_ids` varchar(512) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `clicks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_custom_field_values`
--

CREATE TABLE `item_custom_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `custom_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_offers`
--

CREATE TABLE `item_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `name_in_english` varchar(32) NOT NULL,
  `app_file` varchar(191) NOT NULL,
  `panel_file` varchar(191) NOT NULL,
  `web_file` varchar(191) NOT NULL,
  `rtl` tinyint(1) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `name_in_english`, `app_file`, `panel_file`, `web_file`, `rtl`, `image`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'English', 'en_app.json', 'en.json', 'en_web.json', 0, 'language/en.svg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_03_18_033231_create_users_table', 1),
(3, '2023_03_18_033352_create_password_resets_table', 1),
(4, '2023_03_18_033442_create_failed_jobs_table', 1),
(5, '2024_02_19_120210_create_permission_tables', 1),
(6, '2024_02_20_051429_v1.0.0', 1),
(7, '2024_04_09_095310_v1.0.1', 1),
(8, '2024_04_25_075053_v1.0.2', 1),
(9, '2024_05_31_080315_v1.1.0', 1),
(10, '2024_05_31_080315_v1.1.0_data_changes', 1),
(11, '2024_06_21_122400_v2.0.0', 1),
(12, '2024_07_03_061134_v2.1.0', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `image` text NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `send_to` enum('all','selected') NOT NULL,
  `user_id` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `final_price` double NOT NULL,
  `discount_in_percentage` double(8,2) NOT NULL DEFAULT 0.00,
  `price` double NOT NULL DEFAULT 0,
  `duration` varchar(191) NOT NULL,
  `item_limit` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `icon` varchar(191) NOT NULL,
  `description` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ios_product_id` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `final_price`, `discount_in_percentage`, `price`, `duration`, `item_limit`, `type`, `icon`, `description`, `status`, `ios_product_id`, `created_at`, `updated_at`) VALUES
(1, 'TEST', 108.78, 2.00, 111, '12', 'unlimited', 'item_listing', 'packages/67af1fb31ce681.077984811739530163.png', 'hassan', 1, '123234', '2025-02-14 05:49:26', '2025-02-14 05:59:32'),
(2, 'Rental Service', 121.77, 1.00, 123, '2', 'unlimited', 'advertisement', 'packages/67af2266db53e5.740471301739530854.png', 'Hassan', 1, '123234', '2025-02-14 06:00:55', '2025-02-14 06:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_configurations`
--

CREATE TABLE `payment_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(191) NOT NULL,
  `api_key` varchar(191) NOT NULL,
  `secret_key` varchar(191) NOT NULL,
  `webhook_secret_key` varchar(191) NOT NULL,
  `currency_code` varchar(128) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 - Disabled, 1 - Enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_gateway` varchar(128) NOT NULL,
  `order_id` varchar(191) DEFAULT NULL COMMENT 'order_id / payment_intent_id',
  `payment_status` enum('failed','succeed','pending') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `routes` varchar(255) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `guard_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `permission`, `routes`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 0, '', '', 'role-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(2, 0, '', '', 'role-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(3, 0, '', '', 'role-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(4, 0, '', '', 'role-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(5, 0, '', '', 'staff-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(6, 0, '', '', 'staff-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(7, 0, '', '', 'staff-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(8, 0, '', '', 'staff-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(9, 0, '', '', 'category-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(10, 0, '', '', 'category-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(11, 0, '', '', 'category-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(12, 0, '', '', 'category-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(13, 0, '', '', 'custom-field-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(14, 0, '', '', 'custom-field-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(15, 0, '', '', 'custom-field-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(16, 0, '', '', 'custom-field-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(17, 0, '', '', 'item-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(18, 0, '', '', 'item-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(19, 0, '', '', 'item-listing-package-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(20, 0, '', '', 'item-listing-package-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(21, 0, '', '', 'item-listing-package-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(22, 0, '', '', 'item-listing-package-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(23, 0, '', '', 'advertisement-package-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(24, 0, '', '', 'advertisement-package-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(25, 0, '', '', 'advertisement-package-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(26, 0, '', '', 'advertisement-package-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(27, 0, '', '', 'user-package-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(28, 0, '', '', 'payment-transactions-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(29, 0, '', '', 'slider-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(30, 0, '', '', 'slider-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(31, 0, '', '', 'slider-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(32, 0, '', '', 'feature-section-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(33, 0, '', '', 'feature-section-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(34, 0, '', '', 'feature-section-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(35, 0, '', '', 'feature-section-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(36, 0, '', '', 'report-reason-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(37, 0, '', '', 'report-reason-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(38, 0, '', '', 'report-reason-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(39, 0, '', '', 'report-reason-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(40, 0, '', '', 'user-reports-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(41, 0, '', '', 'notification-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(42, 0, '', '', 'notification-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(43, 0, '', '', 'notification-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(44, 0, '', '', 'notification-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(45, 0, '', '', 'customer-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(46, 0, '', '', 'customer-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(47, 0, '', '', 'settings-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(48, 0, '', '', 'tip-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(49, 0, '', '', 'tip-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(50, 0, '', '', 'tip-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(51, 0, '', '', 'tip-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(52, 0, '', '', 'blog-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(53, 0, '', '', 'blog-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(54, 0, '', '', 'blog-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(55, 0, '', '', 'blog-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(56, 0, '', '', 'country-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(57, 0, '', '', 'country-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(58, 0, '', '', 'country-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(59, 0, '', '', 'country-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(60, 0, '', '', 'state-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(61, 0, '', '', 'state-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(62, 0, '', '', 'state-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(63, 0, '', '', 'state-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(64, 0, '', '', 'city-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(65, 0, '', '', 'city-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(66, 0, '', '', 'city-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(67, 0, '', '', 'city-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(68, 0, '', '', 'area-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(69, 0, '', '', 'area-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(70, 0, '', '', 'area-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(71, 0, '', '', 'area-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(72, 0, '', '', 'faq-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(73, 0, '', '', 'faq-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(74, 0, '', '', 'faq-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(75, 0, '', '', 'faq-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(76, 0, '', '', 'seller-verification-field-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(77, 0, '', '', 'seller-verification-field-create', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(78, 0, '', '', 'seller-verification-field-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(79, 0, '', '', 'seller-verification-field-delete', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(80, 0, '', '', 'seller-verification-request-list', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(81, 0, '', '', 'seller-verification-request-update', 'web', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(101, 1, 'section-service', 'section-service.list', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(102, 1, 'section-service', 'section.service.save', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(103, 1, 'section-service', 'section.service.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(104, 1, 'section-service', 'section.service.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(105, 1, 'roles', 'role.index', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(106, 1, 'roles', 'role.save', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(107, 1, 'roles', 'role.store', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(108, 1, 'roles', 'role.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(109, 1, 'roles', 'role.update', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(110, 1, 'roles', 'role.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(111, 1, 'admins', 'admin.users', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(112, 1, 'admins', 'admin.users.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(113, 1, 'admins', 'admin.users.store', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(114, 1, 'admins', 'admin.users.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(115, 1, 'admins', 'admin.users.update', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(116, 1, 'admins', 'admin.users.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(117, 1, 'users', 'users', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(118, 1, 'users', 'users.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(119, 1, 'users', 'users.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(120, 1, 'users', 'users.view', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(121, 1, 'users', 'users.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(122, 1, 'vendors', 'vendors', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(123, 1, 'vendors', 'vendors.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(124, 1, 'stores', 'stores', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(125, 1, 'stores', 'stores.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(126, 1, 'stores', 'stores.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(127, 1, 'stores', 'stores.view', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(128, 1, 'stores', 'stores.copy', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(129, 1, 'stores', 'stores.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(130, 1, 'drivers', 'drivers', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(131, 1, 'drivers', 'drivers.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(132, 1, 'drivers', 'drivers.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(133, 1, 'drivers', 'drivers.view', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(134, 1, 'drivers', 'drivers.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(135, 1, 'categories', 'categories', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(136, 1, 'categories', 'categories.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(137, 1, 'categories', 'categories.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(138, 1, 'categories', 'categories.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(139, 1, 'brands', 'brands', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(140, 1, 'brands', 'brands.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(141, 1, 'brands', 'brands.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(142, 1, 'brands', 'brands.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(143, 1, 'destinations', 'destinations', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(144, 1, 'destinations', 'destinations.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(145, 1, 'destinations', 'destinations.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(146, 1, 'destinations', 'destinations.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(147, 1, 'item-attributes', 'item.attributes', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(148, 1, 'item-attributes', 'item.attributes.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(149, 1, 'item-attributes', 'item.attributes.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(150, 1, 'item-attributes', 'item.attributes.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(151, 1, 'review-attributes', 'review.attributes', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(152, 1, 'review-attributes', 'review.attributes.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(153, 1, 'review-attributes', 'review.attributes.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(154, 1, 'review-attributes', 'review.attributes.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(155, 1, 'report', 'sales', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(156, 1, 'items', 'items', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(157, 1, 'items', 'items.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(158, 1, 'items', 'items.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(159, 1, 'items', 'items.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(160, 1, 'god-eye', 'map', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(161, 1, 'orders', 'orders', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(162, 1, 'orders', 'orders.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(163, 1, 'orders', 'orders.print', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(164, 1, 'orders', 'orders.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(165, 1, 'gift-cards', 'gift-card.index', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(166, 1, 'gift-cards', 'gift-card.save', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(167, 1, 'gift-cards', 'gift-card.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(168, 1, 'gift-cards', 'gift-card.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(169, 1, 'coupons', 'coupons', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(170, 1, 'coupons', 'coupons.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(171, 1, 'coupons', 'coupons.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(172, 1, 'coupons', 'coupons.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(173, 1, 'banners', 'banners', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(174, 1, 'banners', 'banners.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(175, 1, 'banners', 'banners.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(176, 1, 'banners', 'banners.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(177, 1, 'parcel-service-god-eye', 'parcel-service-map', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(178, 1, 'parcel-categories', 'parcel.categories', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(179, 1, 'parcel-categories', 'parcel.categories.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(180, 1, 'parcel-categories', 'parcel.categories.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(181, 1, 'parcel-categories', 'parcel.categories.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(182, 1, 'parcel-weight', 'parcel.weight', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(183, 1, 'parcel-weight', 'parcel.weight.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(184, 1, 'parcel-weight', 'parcel.weight.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(185, 1, 'parcel-weight', 'parcel.weight.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(186, 1, 'parcel-coupons', 'parcel.coupons', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(187, 1, 'parcel-coupons', 'parcel.coupons.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(188, 1, 'parcel-coupons', 'parcel.coupons.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(189, 1, 'parcel-coupons', 'parcel.coupons.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(190, 1, 'parcel-orders', 'parcel.orders', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(191, 1, 'parcel-orders', 'parcel.orders.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(192, 1, 'parcel-orders', 'parcel.orders.print', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(193, 1, 'parcel-orders', 'parcel.orders.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(194, 1, 'cab-service-god-eye', 'cab-service-map', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(195, 1, 'rides', 'rides', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(196, 1, 'rides', 'rides.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(197, 1, 'rides', 'rides.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(198, 1, 'sos-rides', 'sos.rides', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(199, 1, 'sos-rides', 'sos.rides.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(200, 1, 'sos-rides', 'sos.rides.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(201, 1, 'cab-promo', 'cab.promo', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(202, 1, 'cab-promo', 'cab.promo.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(203, 1, 'cab-promo', 'cab.promo.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(204, 1, 'cab-promo', 'cab.promo.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(205, 1, 'complaints', 'complaints', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(206, 1, 'complaints', 'complaints.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(207, 1, 'complaints', 'complaints.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(208, 1, 'cab-vehicle-type', 'cab-vehicle-type', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(209, 1, 'cab-vehicle-type', 'cab-vehicle-type.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(210, 1, 'cab-vehicle-type', 'cab-vehicle-type.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(211, 1, 'cab-vehicle-type', 'cab-vehicle-type.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(212, 1, 'rental-plural-god-eye', 'rental-plural-map', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(213, 1, 'rental-vehicle-type', 'rental-vehicle-type', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(214, 1, 'rental-vehicle-type', 'rental-vehicle-type.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(215, 1, 'rental-vehicle-type', 'rental-vehicle-type.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(216, 1, 'rental-vehicle-type', 'rental-vehicle-type.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(217, 1, 'rental-discount', 'rental-discount', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(218, 1, 'rental-discount', 'rental-discount.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(219, 1, 'rental-discount', 'rental-discount.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(220, 1, 'rental-discount', 'rental-discount.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(221, 1, 'rental-orders', 'rental-orders', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(222, 1, 'rental-orders', 'rental-orders.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(223, 1, 'rental-orders', 'rental-orders.print', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(224, 1, 'rental-orders', 'rental-orders.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(225, 1, 'rental-vehicle', 'rental-vehicle', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(226, 1, 'rental-vehicle', 'rental-vehicle.view', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(227, 1, 'make', 'make', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(228, 1, 'make', 'make.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(229, 1, 'make', 'make.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(230, 1, 'make', 'make.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(231, 1, 'model', 'model', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(232, 1, 'model', 'model.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(233, 1, 'model', 'model.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(234, 1, 'model', 'model.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(235, 1, 'general-notifications', 'notification', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(236, 1, 'general-notifications', 'notification.send', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(237, 1, 'general-notifications', 'notification.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(238, 1, 'dynamic-notifications', 'dynamic-notification.index', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(239, 1, 'dynamic-notifications', 'dynamic-notification.save', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(240, 1, 'email-template', 'email-templates.index', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(241, 1, 'email-template', 'email-templates.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(242, 1, 'cms', 'cms', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(243, 1, 'cms', 'cms.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(244, 1, 'cms', 'cms.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(245, 1, 'cms', 'cms.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(246, 1, 'stores-payment', 'stores.payment', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(247, 1, 'stores-payout', 'stores.payout', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(248, 1, 'stores-payout', 'stores.payout.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(249, 1, 'drivers-payment', 'drivers.payment', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(250, 1, 'drivers-payout', 'drivers.payout', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(251, 1, 'drivers-payout', 'drivers.payout.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(252, 1, 'wallet-transaction', 'wallet-transaction', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(254, 1, 'global-setting', 'settings.app.globals', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(255, 1, 'currency', 'currencies', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(256, 1, 'currency', 'currencies.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(257, 1, 'currency', 'currencies.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(258, 1, 'currency', 'currency.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(259, 1, 'payment-method', 'payment-method', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(260, 1, 'admin-commission', 'settings.app.adminCommission', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(261, 1, 'radius', 'settings.app.radiusConfiguration', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(262, 1, 'tax', 'tax', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(263, 1, 'tax', 'tax.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(264, 1, 'tax', 'tax.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(265, 1, 'tax', 'tax.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(266, 1, 'delivery-charge', 'settings.app.deliveryCharge', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(267, 1, 'language', 'language', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(268, 1, 'language', 'language.create', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(269, 1, 'language', 'language.edit', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(270, 1, 'language', 'language.delete', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(271, 1, 'special-offer', 'setting.specialOffer', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(272, 1, 'terms', 'termsAndConditions', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(273, 1, 'privacy', 'privacyPolicy', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(274, 1, 'home-page', 'homepageTemplate', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(275, 1, 'footer', 'footerTemplate', NULL, NULL, '2023-12-08 06:08:51', '2023-12-08 06:08:51'),
(350, 1, 'payout-request-driver', 'payout-request.driver', NULL, NULL, '2023-12-08 06:45:44', '2023-12-08 06:45:44'),
(351, 1, 'payout-request-vendor', 'payout-request.vendor', NULL, NULL, '2023-12-08 06:45:57', '2023-12-08 06:45:57'),
(1309, 1, 'ondemand-categories', 'ondemand.categories', NULL, NULL, '2024-01-24 08:07:48', '2024-01-24 08:07:48'),
(1310, 1, 'ondemand-categories', 'ondemand.categories.create', NULL, NULL, '2024-01-24 08:10:04', '2024-01-24 08:10:04'),
(1311, 1, 'ondemand-categories', 'ondemand.categories.edit', NULL, NULL, '2024-01-24 08:11:57', '2024-01-24 08:11:57'),
(1315, 1, 'ondemand-categories', 'ondemand.categories.delete', NULL, NULL, '2024-01-24 08:40:27', '2024-01-24 08:40:27'),
(1320, 1, 'providers', 'providers', NULL, NULL, '2024-01-30 04:48:08', '2024-01-30 04:48:08'),
(1321, 1, 'providers', 'providers.create', NULL, NULL, '2024-01-30 04:48:25', '2024-01-30 04:48:25'),
(1322, 1, 'providers', 'providers.edit', NULL, NULL, '2024-01-30 04:48:47', '2024-01-30 04:48:47'),
(1323, 1, 'ondemand-coupons', 'ondemand.coupons', NULL, NULL, '2024-02-02 00:14:41', '2024-02-02 00:14:41'),
(1324, 1, 'ondemand-coupons', 'ondemand.coupons.create', NULL, NULL, '2024-02-02 00:14:59', '2024-02-02 00:14:59'),
(1325, 1, 'ondemand-coupons', 'ondemand.coupons.edit', NULL, NULL, '2024-02-02 00:15:21', '2024-02-02 00:15:21'),
(1326, 1, 'ondemand-coupons', 'ondemand.coupons.delete', NULL, NULL, '2024-02-02 02:08:07', '2024-02-02 02:08:07'),
(1327, 1, 'providers', 'providers.delete', NULL, NULL, '2024-02-02 02:40:43', '2024-02-02 02:40:43'),
(1504, 1, 'ondemand-services', 'ondemand.services.index', NULL, NULL, '2024-02-13 06:12:18', '2024-02-13 06:12:18'),
(1505, 1, 'ondemand-services', 'ondemand.services.create', NULL, NULL, '2024-02-13 06:12:18', '2024-02-13 06:12:18'),
(1506, 1, 'ondemand-services', 'ondemand.services.edit', NULL, NULL, '2024-02-13 06:12:18', '2024-02-13 06:12:18'),
(1507, 1, 'ondemand-services', 'ondemand.services.delete', NULL, NULL, '2024-02-13 06:12:18', '2024-02-13 06:12:18'),
(1508, 1, 'ondemand-bookings', 'ondemand.bookings.index', NULL, NULL, '2024-02-13 07:41:11', '2024-02-13 07:41:11'),
(1509, 1, 'ondemand-bookings', 'ondemand.bookings.print', NULL, NULL, '2024-02-13 07:41:11', '2024-02-13 07:41:11'),
(1510, 1, 'ondemand-bookings', 'ondemand.bookings.edit', NULL, NULL, '2024-02-13 07:41:11', '2024-02-13 07:41:11'),
(1511, 1, 'ondemand-bookings', 'ondemand.bookings.delete', NULL, NULL, '2024-02-13 07:41:11', '2024-02-13 07:41:11'),
(1512, 1, 'ondemand-workers', 'ondemand.workers.index', NULL, NULL, '2024-02-13 09:03:46', '2024-02-13 09:03:46'),
(1513, 1, 'ondemand-workers', 'ondemand.workers.create', NULL, NULL, '2024-02-13 09:03:46', '2024-02-13 09:03:46'),
(1514, 1, 'ondemand-workers', 'ondemand.workers.edit', NULL, NULL, '2024-02-13 09:03:46', '2024-02-13 09:03:46'),
(1515, 1, 'ondemand-workers', 'ondemand.workers.delete', NULL, NULL, '2024-02-13 09:03:46', '2024-02-13 09:03:46'),
(1518, 1, 'providers', 'providers.view', NULL, NULL, '2024-04-02 03:05:58', '2024-04-02 03:05:58'),
(1519, 1, 'payout-request-provider', 'payout-request.provider', NULL, NULL, '2024-04-03 03:16:58', '2024-04-03 03:16:58'),
(1520, 1, 'provider-payout', 'provider.payout', NULL, NULL, '2024-04-03 05:30:21', '2024-04-03 05:30:21'),
(1521, 1, 'provider-payout', 'provider.payout.create', NULL, NULL, '2024-04-03 05:31:23', '2024-04-03 05:31:23'),
(1522, 1, 'provider-payment', 'provider.payment', NULL, NULL, '2024-04-03 06:55:11', '2024-04-03 06:55:11'),
(1523, 1, 'on-board', 'onboard.list', NULL, NULL, '2024-04-22 05:03:06', '2024-04-22 05:03:06'),
(1524, 1, 'on-board', 'onboard.edit', NULL, NULL, '2024-04-22 05:03:39', '2024-04-22 05:03:39'),
(2309, 1, 'app-banners-setting', 'settings.app.banners', NULL, NULL, '2024-09-23 07:23:15', '2024-09-23 07:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_reasons`
--

CREATE TABLE `report_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', '2023-11-27 00:10:43', '2023-11-27 01:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(191) DEFAULT NULL,
  `custom_role` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `role_name`, `guard_name`, `custom_role`, `created_at`, `updated_at`) VALUES
(1, 'User', '', 'web', 0, '2025-02-08 09:08:17', '2025-02-08 09:08:17'),
(2, 'Super Admin', '', 'web', 0, '2025-02-08 09:08:17', '2025-02-08 09:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_ratings`
--

CREATE TABLE `seller_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `review` varchar(191) DEFAULT NULL,
  `ratings` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `keywords` varchar(191) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `type` enum('string','file') NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'banner_ad_id_android', '', 'string', NULL, '2025-02-08 09:08:18'),
(2, 'banner_ad_id_ios', '', 'string', NULL, '2025-02-08 09:08:18'),
(3, 'banner_ad_status', '', 'string', NULL, '2025-02-08 09:08:18'),
(4, 'interstitial_ad_id_android', '', 'string', NULL, '2025-02-08 09:08:18'),
(5, 'interstitial_ad_id_ios', '', 'string', NULL, '2025-02-08 09:08:18'),
(6, 'interstitial_ad_status', '', 'string', NULL, '2025-02-08 09:08:18'),
(7, 'currency_symbol', '$', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(8, 'ios_version', '1.0.0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(9, 'default_language', 'en', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(10, 'force_update', '0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(11, 'android_version', '1.0.0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(12, 'number_with_suffix', '0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(13, 'maintenance_mode', '0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(14, 'privacy_policy', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(15, 'contact_us', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(16, 'terms_conditions', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(17, 'about_us', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(18, 'company_tel1', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(19, 'company_tel2', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(20, 'system_version', '2.1.0', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(21, 'company_email', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(22, 'company_name', 'Eclassify', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(23, 'company_logo', 'assets/images/logo/sidebar_logo.png', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(24, 'favicon_icon', 'assets/images/logo/favicon.png', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(25, 'login_image', 'assets/images/bg/login.jpg', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(26, 'pinterest_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(27, 'linkedin_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(28, 'facebook_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(29, 'x_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(30, 'instagram_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(31, 'google_map_iframe_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(32, 'app_store_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(33, 'play_store_link', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(34, 'footer_description', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(35, 'web_theme_color', '#00B2CA', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(36, 'firebase_project_id', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(37, 'company_address', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(38, 'place_api_key', '', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(39, 'placeholder_image', 'assets/images/logo/placeholder.png', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(40, 'header_logo', 'assets/images/logo/Header Logo.svg', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(41, 'footer_logo', 'assets/images/logo/Footer Logo.svg', 'file', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(42, 'default_latitude', '-23.2420', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(43, 'default_longitude', '-69.6669', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18'),
(44, 'file_manager', 'public', 'string', '2025-02-08 09:08:18', '2025-02-08 09:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) NOT NULL,
  `sequence` varchar(191) NOT NULL,
  `third_party_link` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `model_type` varchar(191) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_logins`
--

CREATE TABLE `social_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `firebase_id` varchar(512) NOT NULL,
  `type` enum('google','email','phone','apple') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_code` char(2) NOT NULL,
  `fips_code` varchar(255) DEFAULT NULL,
  `iso2` varchar(255) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `latitude` decimal(8,2) DEFAULT NULL,
  `longitude` decimal(8,2) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL,
  `wikiDataId` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

CREATE TABLE `tips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(512) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tips`
--

INSERT INTO `tips` (`id`, `description`, `sequence`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sdfsadf', NULL, '2025-02-14 02:24:25', '2025-02-14 02:24:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tip_translations`
--

CREATE TABLE `tip_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tip_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(512) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profile` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT 'remove in next update',
  `password` varchar(191) NOT NULL,
  `fcm_id` varchar(191) NOT NULL COMMENT 'remove this in next update',
  `notification` tinyint(1) NOT NULL DEFAULT 0,
  `firebase_id` varchar(191) DEFAULT NULL COMMENT 'remove in next update',
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `country_code` varchar(191) DEFAULT NULL,
  `show_personal_details` tinyint(1) NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `mobile`, `email_verified_at`, `profile`, `type`, `password`, `fcm_id`, `notification`, `firebase_id`, `address`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `country_code`, `show_personal_details`, `is_verified`) VALUES
(1, 1, 'admin', 'admin@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$4D/Oi3x7gxPwZ/zxCKtgCOlPNujUnUER0vkMjQ0moL7l3cAJwTIJa', '', 0, NULL, NULL, NULL, '2025-02-08 09:08:18', '2025-02-08 09:08:18', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_fcm_tokens`
--

CREATE TABLE `user_fcm_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fcm_token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform_type` enum('Android','iOS') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_purchased_packages`
--

CREATE TABLE `user_purchased_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `total_limit` int(11) DEFAULT NULL,
  `used_limit` int(11) NOT NULL DEFAULT 0,
  `payment_transactions_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
--

CREATE TABLE `user_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_reason_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `other_message` longtext DEFAULT NULL,
  `reason` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verification_fields`
--

CREATE TABLE `verification_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `values` text DEFAULT NULL,
  `min_length` int(11) DEFAULT NULL,
  `max_length` int(11) DEFAULT NULL,
  `status` enum('review','approved','rejected','sold out','featured') NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_fields`
--

INSERT INTO `verification_fields` (`id`, `name`, `type`, `values`, `min_length`, `max_length`, `status`, `is_required`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '23', 'number', NULL, 34, 34, 'review', 0, '2025-02-14 11:13:06', '2025-02-14 11:20:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verification_field_values`
--

CREATE TABLE `verification_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `verification_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `verification_request_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verification_requests`
--

CREATE TABLE `verification_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','resubmitted') NOT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_city_id_foreign` (`city_id`),
  ADD KEY `areas_state_id_foreign` (`state_id`),
  ADD KEY `areas_country_id_foreign` (`country_id`);

--
-- Indexes for table `block_users`
--
ALTER TABLE `block_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `block_users_user_id_blocked_user_id_unique` (`user_id`,`blocked_user_id`),
  ADD KEY `block_users_blocked_user_id_foreign` (`blocked_user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translations_category_id_language_id_unique` (`category_id`,`language_id`),
  ADD KEY `category_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_item_offer_id_foreign` (`item_offer_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_name_state_id_country_id_unique` (`name`,`state_id`,`country_id`),
  ADD KEY `cities_state_id_foreign` (`state_id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field_categories`
--
ALTER TABLE `custom_field_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_categories_category_id_foreign` (`category_id`),
  ADD KEY `custom_field_categories_custom_field_id_foreign` (`custom_field_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favourites_user_id_foreign` (`user_id`),
  ADD KEY `favourites_item_id_foreign` (`item_id`);

--
-- Indexes for table `featured_items`
--
ALTER TABLE `featured_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `featured_items_item_id_package_id_unique` (`item_id`,`package_id`),
  ADD KEY `featured_items_package_id_foreign` (`package_id`),
  ADD KEY `featured_items_user_purchased_package_id_foreign` (`user_purchased_package_id`);

--
-- Indexes for table `feature_sections`
--
ALTER TABLE `feature_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_slug_unique` (`slug`),
  ADD KEY `items_user_id_foreign` (`user_id`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_area_id_foreign` (`area_id`),
  ADD KEY `items_sold_to_foreign` (`sold_to`);

--
-- Indexes for table `item_custom_field_values`
--
ALTER TABLE `item_custom_field_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_custom_field_values_item_id_custom_field_id_unique` (`item_id`,`custom_field_id`),
  ADD KEY `item_custom_field_values_custom_field_id_foreign` (`custom_field_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_images_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_offers`
--
ALTER TABLE `item_offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_offers_buyer_id_item_id_unique` (`buyer_id`,`item_id`),
  ADD KEY `item_offers_seller_id_foreign` (`seller_id`),
  ADD KEY `item_offers_item_id_foreign` (`item_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_item_id_foreign` (`item_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_configurations`
--
ALTER TABLE `payment_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_transactions_payment_gateway_order_id_unique` (`payment_gateway`,`order_id`),
  ADD KEY `payment_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `report_reasons`
--
ALTER TABLE `report_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `seller_ratings`
--
ALTER TABLE `seller_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seller_ratings_item_id_buyer_id_unique` (`item_id`,`buyer_id`),
  ADD KEY `seller_ratings_seller_id_foreign` (`seller_id`),
  ADD KEY `seller_ratings_buyer_id_foreign` (`buyer_id`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_unique` (`name`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_logins_user_id_type_unique` (`user_id`,`type`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `tips`
--
ALTER TABLE `tips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tip_translations`
--
ALTER TABLE `tip_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tip_translations_tip_id_language_id_unique` (`tip_id`,`language_id`),
  ADD KEY `tip_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_firebase_id_type_unique` (`firebase_id`,`type`);

--
-- Indexes for table `user_fcm_tokens`
--
ALTER TABLE `user_fcm_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_fcm_tokens_fcm_token_unique` (`fcm_token`),
  ADD KEY `user_fcm_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_purchased_packages`
--
ALTER TABLE `user_purchased_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_purchased_packages_user_id_foreign` (`user_id`),
  ADD KEY `user_purchased_packages_package_id_foreign` (`package_id`),
  ADD KEY `user_purchased_packages_payment_transactions_id_foreign` (`payment_transactions_id`);

--
-- Indexes for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reports_report_reason_id_foreign` (`report_reason_id`),
  ADD KEY `user_reports_user_id_foreign` (`user_id`),
  ADD KEY `user_reports_item_id_foreign` (`item_id`);

--
-- Indexes for table `verification_fields`
--
ALTER TABLE `verification_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_field_values`
--
ALTER TABLE `verification_field_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `verification_field_values_user_id_verification_field_id_unique` (`user_id`,`verification_field_id`),
  ADD KEY `verification_field_values_verification_field_id_foreign` (`verification_field_id`),
  ADD KEY `verification_field_values_verification_request_id_foreign` (`verification_request_id`);

--
-- Indexes for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_requests_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_users`
--
ALTER TABLE `block_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `custom_field_categories`
--
ALTER TABLE `custom_field_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `featured_items`
--
ALTER TABLE `featured_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feature_sections`
--
ALTER TABLE `feature_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_custom_field_values`
--
ALTER TABLE `item_custom_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_offers`
--
ALTER TABLE `item_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_configurations`
--
ALTER TABLE `payment_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2310;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_reasons`
--
ALTER TABLE `report_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seller_ratings`
--
ALTER TABLE `seller_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_logins`
--
ALTER TABLE `social_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tips`
--
ALTER TABLE `tips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tip_translations`
--
ALTER TABLE `tip_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_fcm_tokens`
--
ALTER TABLE `user_fcm_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_purchased_packages`
--
ALTER TABLE `user_purchased_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_reports`
--
ALTER TABLE `user_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_fields`
--
ALTER TABLE `verification_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verification_field_values`
--
ALTER TABLE `verification_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_requests`
--
ALTER TABLE `verification_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `areas_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `areas_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `block_users`
--
ALTER TABLE `block_users`
  ADD CONSTRAINT `block_users_blocked_user_id_foreign` FOREIGN KEY (`blocked_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `block_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_item_offer_id_foreign` FOREIGN KEY (`item_offer_id`) REFERENCES `item_offers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_field_categories`
--
ALTER TABLE `custom_field_categories`
  ADD CONSTRAINT `custom_field_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_field_categories_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `featured_items`
--
ALTER TABLE `featured_items`
  ADD CONSTRAINT `featured_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `featured_items_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `featured_items_user_purchased_package_id_foreign` FOREIGN KEY (`user_purchased_package_id`) REFERENCES `user_purchased_packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `items_sold_to_foreign` FOREIGN KEY (`sold_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_custom_field_values`
--
ALTER TABLE `item_custom_field_values`
  ADD CONSTRAINT `item_custom_field_values_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_custom_field_values_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_images`
--
ALTER TABLE `item_images`
  ADD CONSTRAINT `item_images_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_offers`
--
ALTER TABLE `item_offers`
  ADD CONSTRAINT `item_offers_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_offers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_offers_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seller_ratings`
--
ALTER TABLE `seller_ratings`
  ADD CONSTRAINT `seller_ratings_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seller_ratings_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seller_ratings_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tip_translations`
--
ALTER TABLE `tip_translations`
  ADD CONSTRAINT `tip_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tip_translations_tip_id_foreign` FOREIGN KEY (`tip_id`) REFERENCES `tips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_fcm_tokens`
--
ALTER TABLE `user_fcm_tokens`
  ADD CONSTRAINT `user_fcm_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_purchased_packages`
--
ALTER TABLE `user_purchased_packages`
  ADD CONSTRAINT `user_purchased_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_purchased_packages_payment_transactions_id_foreign` FOREIGN KEY (`payment_transactions_id`) REFERENCES `payment_transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_purchased_packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD CONSTRAINT `user_reports_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reports_report_reason_id_foreign` FOREIGN KEY (`report_reason_id`) REFERENCES `report_reasons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verification_field_values`
--
ALTER TABLE `verification_field_values`
  ADD CONSTRAINT `verification_field_values_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `verification_field_values_verification_field_id_foreign` FOREIGN KEY (`verification_field_id`) REFERENCES `verification_fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `verification_field_values_verification_request_id_foreign` FOREIGN KEY (`verification_request_id`) REFERENCES `verification_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
