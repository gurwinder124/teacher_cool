-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2023 at 09:31 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teachercool`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `profile`, `contact`, `address`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, NULL, NULL, 'superadmin@email.com', NULL, '$2y$10$XSXltVf5gnulBN5ne7hon.lvbJSHveUh6UhKCuF6ovRR1wF7uNvyG', 0, 1, NULL, '2022-09-02 08:52:29', NULL),
(2, 'shrey dhall', NULL, '8284836959', 'seasia', 'dhallshrey@yopmail.com', NULL, '$2y$10$/paR9PwphgwkdE0IHLpJhe6xnsMIVyKCNsq9GsdHVKxab9fLrOg7u', 1, 1, NULL, '2023-01-25 18:00:14', '2023-01-25 18:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `assignment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `category` tinyint NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assingment_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_answer` longtext COLLATE utf8mb4_unicode_ci,
  `assignment_answer_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_status` tinyint NOT NULL,
  `is_paid_to_teacher` tinyint NOT NULL,
  `due_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `assignment_id`, `user_id`, `teacher_id`, `question`, `category`, `title`, `keyword`, `assingment_path`, `assignment_answer`, `assignment_answer_path`, `assignment_status`, `is_paid_to_teacher`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 'ASG001', 4, 2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, ', 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s', 'Lorem,Ipsum ', NULL, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', NULL, 0, 0, '2023-01-27 08:05:31', NULL, NULL),
(2, 'ASG022', 1, 3, 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 2, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.', ' variations, passages', NULL, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', NULL, 0, 0, '2023-01-27 08:05:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `content_types_id` bigint UNSIGNED NOT NULL,
  `content_category` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_by_admin` tinyint NOT NULL DEFAULT '0',
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `user_id`, `content_types_id`, `content_category`, `name`, `path`, `uploaded_by_admin`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:07:42', '2023-01-27 06:07:42'),
(2, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:35:11', '2023-01-27 06:35:11'),
(3, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:06', '2023-01-27 06:42:06'),
(4, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:07', '2023-01-27 06:42:07'),
(5, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:09', '2023-01-27 06:42:09'),
(6, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:10', '2023-01-27 06:42:10'),
(7, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:15', '2023-01-27 06:42:15'),
(8, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:20', '2023-01-27 06:42:20'),
(9, 0, 2, 1, 'soc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:42:24', '2023-01-27 06:42:24'),
(10, 0, 2, 2, 'doc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:46:01', '2023-01-27 06:46:01'),
(11, 0, 2, 2, 'doc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:46:03', '2023-01-27 06:46:03'),
(12, 0, 2, 2, 'doc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:46:04', '2023-01-27 06:46:04'),
(13, 0, 2, 2, 'doc', 'content/!qhlogs.doc', 1, 1, '2023-01-27 06:46:06', '2023-01-27 06:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE `content_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Books', 'books', '2023-01-25 14:23:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_histories`
--

CREATE TABLE `email_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(32, '2023_01_13_110506_create_news_letter_histories_table', 2),
(201, '2014_10_12_000000_create_users_table', 3),
(202, '2014_10_12_100000_create_password_resets_table', 3),
(203, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(204, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(205, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(206, '2016_06_01_000004_create_oauth_clients_table', 3),
(207, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(208, '2019_08_19_000000_create_failed_jobs_table', 3),
(209, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(210, '2023_01_09_044231_create_admins_table', 3),
(211, '2023_01_10_064738_create_subscriptions_table', 3),
(212, '2023_01_10_064837_create_subscription_plans_table', 3),
(213, '2023_01_11_052043_create_user_details_table', 3),
(214, '2023_01_11_071602_create_content_types_table', 3),
(215, '2023_01_11_071618_create_contents_table', 3),
(216, '2023_01_13_094921_create_email_histories_table', 3),
(217, '2023_01_13_110342_create_email_templates_table', 3),
(218, '2023_01_17_064043_create_orders_table', 3),
(219, '2023_01_17_064645_create_subscribed_users_table', 3),
(220, '2023_01_19_083516_create_rewards_table', 3),
(221, '2023_01_19_122414_create_teacher_settings_table', 3),
(222, '2023_01_24_060037_create_jobs_table', 3),
(223, '2023_01_25_102648_create_assignments_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `news_letter_histories`
--

CREATE TABLE `news_letter_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_letter_histories`
--

INSERT INTO `news_letter_histories` (`id`, `message`, `created_at`, `updated_at`) VALUES
(1, 'hello gsfgfhsf shfg jsf sf gshfggfs', '2023-01-13 04:06:06', '2023-01-13 04:06:06'),
(2, 'hello  adasdad asdasd asda sdasda sda dshfg jsf sf gshfggfs', '2023-01-13 04:06:47', '2023-01-13 04:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00d379cdf992bd6c7061b554a7aad862623483c1a08c26e3b3d15fa0e43a36af35a8e329e70d468d', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:23:14', '2023-01-31 06:23:15', '2024-01-31 06:23:14'),
('00e1aec7de565af81fa30e0bf8bf255200369b35ef0b1004a46b2181a42d0cb8c77ced539b5b1d35', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:27:18', '2023-01-31 11:27:18', '2024-01-31 11:27:18'),
('01ed11f3c402ab0f64159b7e9385fdaf1fe59c7acddf23d449e3e64de4492b982f6b13c3cb04b134', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 06:02:16', '2023-02-01 06:02:17', '2024-02-01 06:02:16'),
('02a0e91c397979ec5b9a5df72f0e5aa568a2a24b48a4d9fbcc26b26c7c8ac8cd35e549a3f87b2e80', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:14:54', '2023-01-31 11:14:55', '2024-01-31 11:14:54'),
('03233a448fe7c6d995b7bf161e79bef6a503a350f10869e7469986f9f88f705d75a5c479ecc7b8a5', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 16:38:43', '2023-01-27 16:38:43', '2024-01-27 16:38:43'),
('0459f4b1a501f513dd97152665e3d051345f626b4446682d9ced7dd2343a570f7bf1de7762799f04', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 05:08:12', '2023-02-01 05:08:14', '2024-02-01 05:08:12'),
('05bd8574e73a24b2f2f3470478c868e0f99ee21583f6f1ee5421d3ceac828d879fbcbbb1c4f6773d', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 16:36:23', '2023-01-30 16:36:23', '2024-01-30 16:36:23'),
('093c58435ee4260a23226738214837456fba7d06a1d551db167ec969c71619843bd70ad1261db85d', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:16:53', '2023-01-31 11:16:53', '2024-01-31 11:16:53'),
('097007dd22ad879685462bf3afcc43ca2f3d2003f0adc445ddc18f67b371cfe7b5b31984e4bfea8e', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:58:15', '2023-02-01 06:58:16', '2024-02-01 06:58:15'),
('0a2a503cc107659435f64f8bfd6ac9888773f73ee0b01d7e06f022b1eec50343281b740b0e1b996d', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 04:22:50', '2023-01-27 04:22:51', '2024-01-27 04:22:50'),
('0d7a20322be42341a918b4875a9f71204c0a2a6dde949dc2639a7457551a8dee8ada61ac8fce089b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:18:21', '2023-01-31 06:18:22', '2024-01-31 06:18:21'),
('0e0f1193fdce67c2bd9142f5f81922fed1def7e2a8b2ed18ce6b88967d8b11e3ce3228a8ee1936c9', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:20:13', '2023-01-31 06:20:13', '2024-01-31 06:20:13'),
('0e8d5270c04fecc69fb50759938665a060e9c34f76d0b1c8b27ac9fe74eeda17de30252e1f8dbd44', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 13:56:32', '2023-01-30 13:56:33', '2024-01-30 13:56:32'),
('0f481ca6194508c0e1cc5fc1cdc6056146926f088225e0999c8750fe83d9366b9e9647d9e567d20b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:09:47', '2023-01-31 11:09:47', '2024-01-31 11:09:47'),
('0fac4bc281df56e16a5743015265ad8200a5ee5719cb306c9ac145e90558c68d4c87945e784b098d', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:23:13', '2023-01-31 06:23:13', '2024-01-31 06:23:13'),
('137798fe6ee31206753ba87bd44cc1b68b451bd27f85a5d232af9572340b1d718072f01cb86b91ab', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:16:44', '2023-02-01 07:16:44', '2024-02-01 07:16:44'),
('143669a7a9ab026ccd6ac2b411801cf2ab8d4b1985be506668b36fa669037517858e68d77e6c1b75', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:38:57', '2023-01-31 06:38:57', '2024-01-31 06:38:57'),
('14f849aa82c30caa616a6d5759ecc2c8d492d8012c9ed7d121eaf6fc4855164be894ad6321661b68', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 09:58:46', '2023-01-27 09:58:46', '2024-01-27 09:58:46'),
('18553e81e660647409f7bc32e903ec2dffcc36ae9bfee2a62b537c59aade008b1b09cfe03add3b01', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:32:22', '2023-01-31 11:32:22', '2024-01-31 11:32:22'),
('1a4d9b3d9b3bf318bcc558c27ead9c424522e591f732fced596c8ef53a5072aa3f4fd878c40bfe80', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:43:06', '2023-01-31 11:43:06', '2024-01-31 11:43:06'),
('1a91c82a50b4c1539353b4a5e9e43756ac59c480f0a9eb31258457ae7239fa0ee6e1d8baee5f3469', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:04:44', '2023-02-01 09:04:45', '2024-02-01 09:04:44'),
('1b5d2c5b20cea9557aabaa4c76cd0da33903f6060ad2a2fb83f53c9c23ed130fc1a9ea71fcddb88e', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:18:29', '2023-01-31 11:18:29', '2024-01-31 11:18:29'),
('1bb00325656449fa0520a9729b1d6083a900c9db25d0a52a0fdd629842d7d5202dbefcfc0c8ced5c', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 09:25:47', '2023-01-31 09:25:48', '2024-01-31 09:25:47'),
('1bb096b08741d7a1618f2bdfb0c6e29b6d8ec61235c7807c7e8309177226a8f302773c41e06ed602', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 12:59:24', '2023-01-27 12:59:24', '2024-01-27 12:59:24'),
('1e14fda44559aeae54e776c6c97101572b9af7d69837b86c7acfb03f7e98add725832ed09b1ff31d', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:26:12', '2023-01-31 11:26:13', '2024-01-31 11:26:12'),
('1f1b37e2a08cc0f37ca2f4fe8acb8d30f7d9fd67e038d717ac1d8fd2135aa7fba98e64cb867dcacd', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:21:46', '2023-02-01 07:21:47', '2024-02-01 07:21:46'),
('1fc22312751dd73a2552dfd7c6387aae6e7f520d9988eb2662716682e5fa06176de1bc782dc9a89d', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:19:06', '2023-01-31 11:19:06', '2024-01-31 11:19:06'),
('206f1c27f4d087e1eeff0eaa44f0867b849f135f2c991368fe9843ee8051bd4d2531e0788c14608b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:27:04', '2023-01-31 11:27:04', '2024-01-31 11:27:04'),
('2226b8497709a484f521c59b892051ac173d44e3533d20cfb0ed848d83b3f327506b83a89d6309a1', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 08:38:15', '2023-01-31 08:38:16', '2024-01-31 08:38:15'),
('24271c352f46409574f39e7f77d747260c5b45384b115c2387bef1d3fd51cf871f203a8a6272d1c3', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 09:14:27', '2023-01-31 09:14:27', '2024-01-31 09:14:27'),
('24a60d4ae9ca1a66313117419bc1a38bebf3fc3cd7d80b64cb964b34328d3c185010c0152646a64c', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:48:57', '2023-01-31 06:48:58', '2024-01-31 06:48:57'),
('263e0f1d2c4ae72694844c96086fda74d7d7b042a03f93627536d7e26ebbb939a73a51a60a7be954', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 06:55:19', '2023-02-01 06:55:20', '2024-02-01 06:55:19'),
('276dfedf818168018550f91daa8cf42552e9142710e9126e528a253ac939f5465494241a2213747e', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:13:04', '2023-02-01 09:13:05', '2024-02-01 09:13:04'),
('27904260d357fda55812cb01fb1a28c6a3b864260405a721b78b645642945832beb1459610b62d74', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:42:35', '2023-01-30 09:42:36', '2024-01-30 09:42:35'),
('27cd802e9cc21e6a28de7de668200c4ecc9739668bb0a7222eac5aebdb170995334da38359978efb', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 10:05:15', '2023-01-30 10:05:15', '2024-01-30 10:05:15'),
('294365d9c02d7fbf3188f3dbf196aa9f013ef5a6c4b8b101f2d25ad8446885de9cebf0a3c35c0380', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:21:42', '2023-01-31 06:21:44', '2024-01-31 06:21:42'),
('2b61fb1fe6b98a1428f8184b3e9cb92f778d27e8ea1b97e10f90be5cfa72b8c6e1ef94ad13205d7b', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:33:18', '2023-01-31 11:33:18', '2024-01-31 11:33:18'),
('2befcd073490c433c68119ec040c514377cffa1697debdd94802577917dac1d2ee296283f49d27cd', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 05:10:00', '2023-01-31 05:10:00', '2024-01-31 05:10:00'),
('2c781636ac387d665acbdd802bae0974c5b7ba8778703d17e236644cc771ae0c096cbdc8e57c8a91', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 08:41:59', '2023-02-01 08:41:59', '2024-02-01 08:41:59'),
('2f1cd1591d5024e6aff1661f0ea89f228e7473d973f6e38af30a33672520f337574e20fd18dc4986', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:08:08', '2023-01-31 11:08:08', '2024-01-31 11:08:08'),
('30730064d916ad96278a428897cda18adf1088d0cb0f9050b301090b56f1237e1d5523063070356b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:23:46', '2023-01-31 06:23:47', '2024-01-31 06:23:46'),
('328c8b122c0e014f7f18fd33aa8053774fa1a88d26b2b39f30f716e8b597977c3901dc39ce7f0dd3', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 13:57:28', '2023-01-30 13:57:28', '2024-01-30 13:57:28'),
('34761758eb9a743223d09419349d6a13064365d42b0b639600012dc5de8c0c5f2184de9038325bd0', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 09:47:30', '2023-01-31 09:47:30', '2024-01-31 09:47:30'),
('355db7647601eeb1c1fbb67eedb25987ab1b0b8bb65ef3a9ff02b47a517b9646b38701300d61983c', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 16:59:19', '2023-01-27 16:59:19', '2024-01-27 16:59:19'),
('3583a5edd0db493b033cdac844b97b516f101f0761adba20209c1dd0001c75357061ff0d8db1e9f0', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:59:59', '2023-01-30 10:00:00', '2024-01-30 09:59:59'),
('3585ff4f1cfb8bf5cef4f73d6fcabd31318517c17a7984f56ef925019d15e6bb6d6811e391cba7b2', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:06:50', '2023-02-01 09:06:51', '2024-02-01 09:06:50'),
('35b84764635bcc2deaccb140ea71b0ebbd12632d3cc9c2f2f929d12fc326bf72e8d970f7abd05980', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:48:32', '2023-01-30 09:48:32', '2024-01-30 09:48:32'),
('36f7ce3a5958999f97b64fac90e98e77e79a4761e60fa3bf65c22933e94d2e3e8779059750d5ac78', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 09:31:59', '2023-01-31 09:31:59', '2024-01-31 09:31:59'),
('377992f3c9d5263884b5e6cd0af0324d4150f0f9ee5ff0b5592cd25ce6da3432ef8b105833ef2443', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:12:55', '2023-01-31 06:12:55', '2024-01-31 06:12:55'),
('38eda64163d516cdf801c20d8022b01d796cfba302e09246851c8e7a8764c0d7eb2d8bccebe102b3', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 08:42:09', '2023-02-01 08:42:10', '2024-02-01 08:42:09'),
('3a1a54f32eada286866032c782c991726b77473fed64f1b67600a9fd9263e3884ef3f2dd31f559dd', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:32:44', '2023-01-31 06:32:45', '2024-01-31 06:32:44'),
('3a5402addc63480752b49a7220a78fb58a25077f284225f4c00e04eb51d6f40efe38bee68f2c9dc4', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 11:06:37', '2023-01-27 11:06:37', '2024-01-27 11:06:37'),
('3b848cb2e484f1b9c04575d5fd3ee8d2d374f8d7f68affba62e8c17e841cc4dcbb6f3ba427de65b5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 07:14:33', '2023-02-01 07:14:34', '2024-02-01 07:14:33'),
('3cad0c18c6c0f284f20139031644912554084f9c5e8c67b6aac0aaf95ed277985cf007479b1f65f5', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-25 17:58:05', '2023-01-25 17:58:05', '2024-01-25 17:58:05'),
('3cdd3080f43e4c5c39cde8d6b457d86ad915eca8b8bf815aa0254bf815b50641a933e9d8c736ad0b', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 04:38:39', '2023-01-31 04:38:40', '2024-01-31 04:38:39'),
('3d4653f7453f9c819005728b333ba6e8d3de674db6e2d7216d68bfb972bd0fb9284835c88511a7b2', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-25 14:25:58', '2023-01-25 14:25:59', '2024-01-25 14:25:58'),
('3d83fabf7a83817b3f79767ed8c09c89d457e696a6a827235d2383322fdc2425ac2f2431897b7d1f', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 06:52:42', '2023-02-01 06:52:42', '2024-02-01 06:52:42'),
('4163052d0ccc5a72ca63dcfc59dfa3938cdb4c78d7b64f4a26e95355fcc0d44af6ce35400d8ad046', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:20:55', '2023-01-31 11:20:56', '2024-01-31 11:20:55'),
('42494c415b0ed44fbf1fa8210b9e590961e39aec0674aa56853b7a38afcc94a091b8e60369956c57', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 08:34:55', '2023-02-01 08:34:55', '2024-02-01 08:34:55'),
('42a142a0db18f9e23842fac628d20942e0de1fd83d1773333eeff796199d18b6cc26e420091cf1d8', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:20:27', '2023-02-01 09:20:28', '2024-02-01 09:20:27'),
('4624a8fe601cba42bd41af72d1dee5fb5df45948f7b4a65d0c419844ad3ac456bd91261dc34e31bd', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:58:25', '2023-01-31 06:58:27', '2024-01-31 06:58:25'),
('46ab9fe702cc037266bdd38eb836f3c381eb860bba433e8fb274c43dc54898dd451afa9d21ede5cd', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:35:22', '2023-01-30 09:35:23', '2024-01-30 09:35:22'),
('46feb575e0e9abf0c0c6622b2ab0c98e0a53a918f93f06f42f7cb2d4a19512b1fbc578edc8575426', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 08:37:54', '2023-01-31 08:37:54', '2024-01-31 08:37:54'),
('4721596743916c1d7b70c15efdae918aa0ff24db2949d1fbecbe70bac2468ccba7e163ef0d136ec3', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:16:04', '2023-01-31 06:16:04', '2024-01-31 06:16:04'),
('47f5f2634af51601957311b457527ddcb3568f5ec2357e8d26959cbc492b9299f2b1c0e9913310d7', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:17:24', '2023-01-31 06:17:25', '2024-01-31 06:17:24'),
('486f818a41bfa0d150a2ea982b88504e1e0453e013c58232932c43c424134bdc90dfb3c843d513ac', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:45:15', '2023-01-30 09:45:15', '2024-01-30 09:45:15'),
('48a203cb5b8c8717f223d549c2ad199ea98a1f57e8177b9b4b7ce108ca959ed23102e46921d1b7aa', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 12:29:06', '2023-01-31 12:29:06', '2024-01-31 12:29:06'),
('49e49aad5cdb04a930276750fcf13966f14d0678c817b8581947f53a977db68f0a05dd9a325208a2', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:37:04', '2023-02-01 07:37:04', '2024-02-01 07:37:04'),
('4aac412f554bf9395abd4a3b21c2d2a223e629578b38b3ef5f9d6505b73c8b9f91403c24c491100b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:38:08', '2023-01-31 11:38:08', '2024-01-31 11:38:08'),
('4e85016ef070b7b2d9d092ab1098683e97b752df94b9a3352addd02010e6f7cc0b4c282127e39bd5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:27:04', '2023-01-31 11:27:05', '2024-01-31 11:27:04'),
('4f82432d4c0df3d4f6db97918d06891065f899b2414b6f7ed825f0effe2e51fc29439c11f156d70a', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:05:03', '2023-01-31 10:05:03', '2024-01-31 10:05:03'),
('5107df6662c1fd11172b44520ca0fde38f7442fe3a1a6fdace45c7327daec3d4b21a7672bdeaf254', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:08:45', '2023-01-31 11:08:46', '2024-01-31 11:08:45'),
('5251203a33aac2a56d6239b63ad64eade9253c3168e882fd4291f8b378d29dc7f727e6f8181de261', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:43:19', '2023-01-31 11:43:19', '2024-01-31 11:43:19'),
('530054ec4e9bc3264677c89ab6011702088df00d7748da5ab6dd63f5750d84ee324f11a6ee7cac2b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:18:22', '2023-01-31 06:18:22', '2024-01-31 06:18:22'),
('539a9c330fe5e9b7161d119e2cd0c79939ee9073f48060d150ab4b08bd8d074c6c3130aa70480fb1', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 10:16:59', '2023-01-30 10:17:00', '2024-01-30 10:16:59'),
('546cfdc9b85a01c33a84333d977df602d72fc16e183d619789a3f02d9d58a0d6e699d2c60fd856d1', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:03:55', '2023-02-01 09:03:56', '2024-02-01 09:03:55'),
('54c920fdab0e19781ec9d5a1d92ce18e3ec056e06ef01edf0bb3415e6b243ae93bf3a143a24e3e8f', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:03:59', '2023-01-31 06:03:59', '2024-01-31 06:03:59'),
('5605b17fc2e3cc92f1be44b5a4c924cfb437000fac6b02e5110923e8993ddad243166a837242e5c7', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:33:28', '2023-01-31 10:33:28', '2024-01-31 10:33:28'),
('56666cf09df623e3160b3f229a948b8b0985ff1cae8219f9b7d8e694a704e670e4ff7a3b50def89e', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:36:56', '2023-01-31 06:36:56', '2024-01-31 06:36:56'),
('59958d53f8c37c6c09ee7b6d23026453e039ee5e3f1bf994454215891155f67a449923f5796ab8f6', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:22:55', '2023-02-01 09:22:56', '2024-02-01 09:22:55'),
('5b308c38caaf20dc1f47f281f4acd1a74bf8e0d1c30d5fe95cbca3a080bfa7985287092196c64d23', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:42:12', '2023-01-31 11:42:12', '2024-01-31 11:42:12'),
('5bb75ea85a3b6a831356e4287962634e9100b47d96a5260fb42d9e8e50101f5cf813615857d7e6bf', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:58:18', '2023-01-31 10:58:18', '2024-01-31 10:58:18'),
('5be2d96ee6c158bb540e1cfd6ba5c7555ebe176468e9b1a0b875a172a243529d92401c8a58ad25d2', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:48:44', '2023-02-01 06:48:45', '2024-02-01 06:48:44'),
('5e92d692f581b6ce19f6a8da1deb8cb32f748c737864cc32b82ba1e8d5ce5f97ca995400a654de79', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:50:26', '2023-01-30 09:50:27', '2024-01-30 09:50:26'),
('5f0d80c1d5ba1b5a5487e5dde73e0f606f7cd5a41f743681d90d54735990b6d5ce17fda130c05794', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:23:25', '2023-01-31 10:23:26', '2024-01-31 10:23:25'),
('5f449303a8bc0988f668ecc3d530608bbd903790d6540f4db95248ca9178bf8c53fca711a1ce5703', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:30:49', '2023-02-01 06:30:50', '2024-02-01 06:30:49'),
('6132b87d27ea9e11bb8508d94a338d09129c275ff8d8473a466f78003eb05592e8ec3b7433e1492b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:42:49', '2023-01-31 11:42:49', '2024-01-31 11:42:49'),
('61ecf95cecc09b2f178c11b4c6123932a6c64c54c2b4336e3032bc65a3698c5fc73f4805b1affdcf', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:42:30', '2023-01-31 11:42:30', '2024-01-31 11:42:30'),
('61fcf93c6667497354a046d1fe1d01097ecf14d67c20af4e22f76381eb429052c8675073dd517c41', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:11:32', '2023-02-01 09:11:33', '2024-02-01 09:11:32'),
('6204170f7477e2fb77f96cc16b36f359f4d08595ebac94842606f4bcb7f65050782f5b1d0c281580', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:26:13', '2023-01-31 11:26:14', '2024-01-31 11:26:13'),
('6235cdb5c10e850ec608a5bc0b3055c7e159f90ba038f55efdacbd39fb20e63a92abc5789b73348f', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 07:32:47', '2023-02-01 07:32:47', '2024-02-01 07:32:47'),
('631c47cf45dab8c06be9cfc50d9b8c9f75924103c390a938dc0f96fc41b358589909303fb1ab3823', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 04:42:23', '2023-02-01 04:42:24', '2024-02-01 04:42:23'),
('6456e741ddf9384a91df522e511fc6bf0e80df109cb3244c71ea7582e926b8a5c44f5efca065768d', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:29:50', '2023-02-01 06:29:51', '2024-02-01 06:29:50'),
('661783d27deccdd8f15e9347d750fd8c840fee05205624c4f06a67a2bf31cd561df6b58875811210', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:15:09', '2023-02-01 09:15:09', '2024-02-01 09:15:09'),
('66726cd8d3eb68f949a66815bb6b5e58e9d0442a5f164c7d04812b59f65f3b7364cc1f7a8ff48aa1', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:39:08', '2023-01-31 11:39:09', '2024-01-31 11:39:08'),
('675b8b8e1ece5a5847d04f8c7056b72f0d7514ff5a94ebb248636fdff95e8297a8a6a4a10ba0c4af', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:46:55', '2023-01-31 06:46:55', '2024-01-31 06:46:55'),
('68ce430d525d83934995ef3a8b7f0ff6e5a971d3abb9a30fccb1385b0660ad3b67a2f5b97f13b225', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:04:53', '2023-01-31 11:04:53', '2024-01-31 11:04:53'),
('69493c468d77590a3302d150e215f3cc1d23cbc972e0c099f5ac221b51f0585cd688794a91538a52', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:25:32', '2023-01-31 10:25:33', '2024-01-31 10:25:32'),
('6bde0cdd357dfa647462e99c698c950919bda5b5ebb7cc8283367ace10f2110ff4f80d0543f7e9b0', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 09:36:41', '2023-01-31 09:36:43', '2024-01-31 09:36:41'),
('6c018b30ad7915d511038dfaf8054f88df72460aba3b6cb04fdfd4640aea04be6c44be73182a2914', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:33:33', '2023-01-30 09:33:34', '2024-01-30 09:33:33'),
('6eccbdfe9feba4ad4f280b96e5fa72a78ce2ed43544edaebbfce092e71985b2bc26976b0b10976e0', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:41:41', '2023-01-31 11:41:41', '2024-01-31 11:41:41'),
('70a0c99d07bb7568313de94b9552e41d63f3ecd8abd7485fb6418d8d69688c561bea0d331e5f31f6', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:35:16', '2023-01-31 06:35:17', '2024-01-31 06:35:16'),
('74470e885009371a407066e3ae162896785883d4be9c10380ef7fc5d24bc83580e9d320213600b47', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:20:38', '2023-01-31 11:20:38', '2024-01-31 11:20:38'),
('74df2c5eb434acc2d3ad53398b1b86fadf5ddc31bf9b7b6a01e72a951fadea6a9800f757f648afb8', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 07:44:53', '2023-02-01 07:44:54', '2024-02-01 07:44:53'),
('792aa5bb233fd69a64a51334de790a9c5a4ba446f746f3d6c92fac6a2161cabd7f129d568a63ec90', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 10:17:40', '2023-01-30 10:17:40', '2024-01-30 10:17:40'),
('7a5dbf595db71740d4fd9b17cd46fcd66af7a5302153792d4d5af59297793ff4e9459c2ec08615c6', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:49:03', '2023-01-31 10:49:04', '2024-01-31 10:49:03'),
('7a80aa00865b0a049e2955d1ef9061da0a36d42c93e8b4d889c0158b69f8ef80ff4b23c59ff1ed93', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:00:49', '2023-01-31 11:00:50', '2024-01-31 11:00:49'),
('7aacb4f313b4b34ed1b1cb0c25e4368c7269c6fefb3b72c7b445d67dab175dfbdfff2331197788b3', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:38:08', '2023-01-31 11:38:08', '2024-01-31 11:38:08'),
('7aed592ba3ee3054e6a367fd9f4a4f14d6b0d349aaef8c0bb8ed382457f69ef3f865e408cb5d8ac5', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:22:00', '2023-01-31 11:22:00', '2024-01-31 11:22:00'),
('7be8625e2b26110f05ff4e57f712acf2a6a3404fd4716049985d0bd8650aaac1f8f98b02086eb550', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:26:37', '2023-01-31 11:26:37', '2024-01-31 11:26:37'),
('7d1042fb95ff64b4c6f1487bfe89769a40a9736c0e37d926b59e797cebeb1bc4b93c294df1bbed17', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:44:15', '2023-01-31 10:44:15', '2024-01-31 10:44:15'),
('7e47c2220d7d6ddd7a44c20a74df606e0cd3427006275f0d77a141144c4e461f1598e0835704d22d', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:21:37', '2023-01-31 06:21:39', '2024-01-31 06:21:37'),
('7fd7962847f667fea4bb7f9b69912da27cad5271079ca00fd9da0c312e92a2a9185e5aa023d10d7f', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:12:35', '2023-02-01 07:12:36', '2024-02-01 07:12:35'),
('80a61cdc1eca24c992e680310c12f75f6ec3554ac7eb6cba55b7d8ef90ec6a01fd11dfa38caabb24', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 16:38:44', '2023-01-27 16:38:44', '2024-01-27 16:38:44'),
('814cedeafeab62d17ed619e6e0e22b643b141c463a3a99faff90eb508813bffb111ab4fd8fc0c26f', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:48:02', '2023-01-30 09:48:02', '2024-01-30 09:48:02'),
('816f7d1f632db09902246bce6899e360cdd7cbc62828bc44f909d43e66ecff6aabc411045fa68d03', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:05:29', '2023-01-31 10:05:29', '2024-01-31 10:05:29'),
('81f344d35845d1c0a4f1d79186ec946b75dc6d1966f8e9758728377252de9b140027354d6439ab09', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 10:05:14', '2023-01-30 10:05:14', '2024-01-30 10:05:14'),
('8365a715d58e83e982ce9c42a0ae6a5b230bbc549d307fe2d1794c8502cc1178b799a6c65c3ca285', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:13:23', '2023-01-31 11:13:24', '2024-01-31 11:13:23'),
('83a23bbcd253b1875ac109a3562dc6d2a3bef1acce9bea46d17a51942170382d589f173559e6e5dc', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:34:09', '2023-01-31 06:34:09', '2024-01-31 06:34:09'),
('83ba4292809264391e49745b304c5fff8bab3f0a9ec9ae78e48ebda5530a491c9e63370f016c0dc1', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:24:56', '2023-01-31 11:24:56', '2024-01-31 11:24:56'),
('8439c86a32ddf5cc9de9f2eca15799fae7ae4fa1872f1d056d73b64802a2dba0dacf5dca0cdffaec', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 05:08:45', '2023-01-31 05:08:45', '2024-01-31 05:08:45'),
('84bd2d59ab1cd04f530f8a1956a9b2ec22c0e0d07f8b57062d11d498b6df38afdf2bef4c2b6cdfc8', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:20:36', '2023-01-31 11:20:37', '2024-01-31 11:20:36'),
('84dd2c31cfd17c7b9429f5e397237599baa370aa52f527242e596589eb401e18fd2568dd7657bf5b', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 05:56:33', '2023-01-30 05:56:33', '2024-01-30 05:56:33'),
('8524533aa662c8e1e653bceb4f46f4a7ebb9080345d46dcfd65a607129d38bbcf40bc0c5da8c6ab4', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 04:39:41', '2023-01-27 04:39:41', '2024-01-27 04:39:41'),
('853430d20d195c119919a8360ef49a8c852ad87d323e5d2c489d392f40f56acf8dd9e42d69f60eb1', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:14:23', '2023-01-31 11:14:23', '2024-01-31 11:14:23'),
('865e30207bd168148087d6943f2ae48a57fe53795a98b93a0fe336fb075fa437d553bf1ea392ab0a', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:20:37', '2023-01-31 10:20:38', '2024-01-31 10:20:37'),
('894942ef98e121a9bd9209b35052f4d0b4c1aecb9e39a0e30782ed590e457f460eca881abe40fb8e', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 07:12:53', '2023-02-01 07:12:54', '2024-02-01 07:12:53'),
('8dab521f5fe77dafa2c2a7451daca8aa5985466718ae66659c9cf98a085b087d9e0ecc8c9c97e8a5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:11:47', '2023-02-01 09:11:47', '2024-02-01 09:11:47'),
('8db53873963f806f8ef23536d6c1943bb5d9b3b7cc463ca467602437da63519d52e69440c3842279', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:18:15', '2023-02-01 07:18:15', '2024-02-01 07:18:15'),
('906da254526bb5437a3db341579fd873db87cbddb8437363d8e882aa8e69a31b78e3b41addcf3396', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:57:03', '2023-01-31 06:57:05', '2024-01-31 06:57:03'),
('915348440872c5bfb5003befa4a3e4c773485cf077f66417f6c5972f06c1f52c88edbad7134e78f5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:27:21', '2023-01-31 06:27:22', '2024-01-31 06:27:21'),
('96ac61505af37cc411fc7a1c626088e875640d46ce5970a57a31b8cb8c114ea4c9ee6c24707a63db', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:19:51', '2023-01-31 11:19:52', '2024-01-31 11:19:51'),
('96b7c4a02d3fadef9d6194d229d99f1921b1d46b6f515fab45c598cd434629fac2cc6bab4b683854', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 11:23:08', '2023-01-31 11:23:08', '2024-01-31 11:23:08'),
('9bc29c3a2febf1428b8dba265790832950101e737a5dedb26b5bff66283f09a830a8ac499e0eee97', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 13:42:49', '2023-01-30 13:42:49', '2024-01-30 13:42:49'),
('9d5cff78ab7ab0f3c0ed120836205e789e3f314fd3f5c069c0789d5ebfb5be55814380f4f0a06226', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:38:07', '2023-01-31 11:38:08', '2024-01-31 11:38:07'),
('9e61a8b30435c5ea664ef2054c5890e4e4939d3c67c600b0d2acd40071d14652d001719352f44cfb', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:00:57', '2023-02-01 06:00:58', '2024-02-01 06:00:57'),
('a0605f1ade48c3d21c656ce55ab7dcf2117f4667e5a3b7e0bf7e03fe51607e36323578aaeba81dcd', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:26:38', '2023-01-31 11:26:39', '2024-01-31 11:26:38'),
('a0e5c82f1a836f1a3672867eb718e14353b67129c450b91ce5a05f418cef8febf8bbde5fb07156f5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:49:52', '2023-01-31 06:49:52', '2024-01-31 06:49:52'),
('a3c016a16582c299014e04d1e38fc12d8799efdd2b97de3badae47bb570e943b8ff78fe69f2f7b03', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 16:51:56', '2023-01-30 16:51:56', '2024-01-30 16:51:56'),
('a42b685d6336224ce52c260945c6eb4f3828da8a29b527afc85f7e10c64389202d63e151959254bc', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-26 08:17:59', '2023-01-26 08:17:59', '2024-01-26 08:17:59'),
('a8b9c143a84458f1c3a2def4cc3432b0deab38f7936382ef295e1cee3cb26d3a090d2a9f6c82ee4c', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:49:44', '2023-01-30 09:49:45', '2024-01-30 09:49:44'),
('a917d9aa4209a1657e2fe474f4dc319b2a9cc9318af61b81c08b913cd40de9a5d5eab6573b335420', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 06:17:36', '2023-01-30 06:17:37', '2024-01-30 06:17:36'),
('aa0556275d4495bdbd33df487e0ff251960807d2fe460da86dc8c021c50c025a134ccb8a2234525f', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 05:00:44', '2023-01-31 05:00:45', '2024-01-31 05:00:44'),
('ab2d331d656b19f9ac4e74ba9f17fc2916fc1e44a050c27e2e3daaa50167b2ddc1e2df6b0a4ee0f0', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 08:57:18', '2023-02-01 08:57:18', '2024-02-01 08:57:18'),
('accf7e94428a2749d8e08bc18c96d284ac0e7a6c2ef650c66939287d0ff50094258ba0688147fd79', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 07:12:21', '2023-01-31 07:12:21', '2024-01-31 07:12:21'),
('ad2ba272bbb4345346f2867b3a82d03ea27e22de9d1ce1b6961fc91b381ffcac28f326d8ca89db15', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 12:39:44', '2023-01-31 12:40:11', '2024-01-31 12:39:44'),
('ad521197be30e491cbdcffbe4f098638486c4670290b23fea8c9035731ad303ca04c2846ac944815', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 05:11:46', '2023-01-31 05:11:46', '2024-01-31 05:11:46'),
('af1a74a16f2dd66756d6cb40bb0be9ef61dd9f03c5044fadbee0c69a6795b39905537cc4397d4673', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 06:28:13', '2023-02-01 06:28:13', '2024-02-01 06:28:13'),
('b048f9f8d0654ed502bc0f41966c3a4da7a50bb5cd4ae71cc098684975223e444b5f7fc59c3fc3f9', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:25:18', '2023-01-31 11:25:18', '2024-01-31 11:25:18'),
('b107076c1e0267bd893a9ac38dde5b9d3bd856bc5d8fe3e5349a6af8b0f0376a4a10e277198f123e', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:03:55', '2023-02-01 09:03:56', '2024-02-01 09:03:55'),
('b21a0e13828a562b89540a32d816190c32fbc66ec26d4db724f2a82cedfae893f6c74b90e81ed87b', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 10:59:06', '2023-01-31 10:59:06', '2024-01-31 10:59:06'),
('b2644a63d21d71215009adeed691d55dd07bd9e97934d9201463bb01419ff38ee8defd7442958cc2', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:13:19', '2023-01-31 06:13:19', '2024-01-31 06:13:19'),
('b40b833c028e10fef470ded0d9920e96d4b47250792825b57b1c38865206f8e2bb8ab79f29ee731f', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:34:42', '2023-01-31 11:34:42', '2024-01-31 11:34:42'),
('b4b6ef16c4414cba34a30b1da39883be246824cbb77852969318c0d6ad17f78dae16a1f4864877fd', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:45:24', '2023-01-31 06:45:25', '2024-01-31 06:45:24'),
('b63535c004f0784216359d6674163f770113854b5ea952b8f7cbe209f5135e31a98c483fe22650be', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:10:54', '2023-01-31 11:10:54', '2024-01-31 11:10:54'),
('b7e2bacb29b08ee3bfa7e65b9858451e09a608a3b39c714de8dd20ad936fa6a9ae3787d1eaf21490', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 10:47:51', '2023-01-31 10:47:51', '2024-01-31 10:47:51'),
('b80b1247e6e9dfc488f7fb69bb3d81ac77b2ac9b2ae7f55d36c2376ed5a587e000b08001ce8ceaa1', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:27:18', '2023-01-31 11:27:19', '2024-01-31 11:27:18'),
('b88e32a2831768f37691be40e2fc3794ee305db37cc1ae4a0956ff7976ba7c0ea20249ddad154ba6', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:18:07', '2023-01-31 11:18:07', '2024-01-31 11:18:07'),
('b8c3601a43232c1c2dfc4c66ded4577f62d55ed3b4e47a66d0e0b67a4263241e6104dee8bf3081e6', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:21:24', '2023-02-01 09:21:26', '2024-02-01 09:21:24'),
('ba4d758dcf8c11b31aa54b6bc03d86d412e43a9935bb22c0c4656f1b129e9aa08e655491d08cf9b8', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 08:36:56', '2023-02-01 08:36:57', '2024-02-01 08:36:56'),
('bac09105aefb25701f8c1d5cdbb6b5c4020d2a690e4c8f0dd4050cb100538be5bf55c54fe6e04678', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-25 14:38:10', '2023-01-25 14:38:10', '2024-01-25 14:38:10'),
('bbff5ac3312863af65a314c2bacab0946b8ac9419522eaef08bac4951247ebfabf2939dce1eef3f5', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:38:08', '2023-01-31 11:38:08', '2024-01-31 11:38:08'),
('bcfcb3667f016fe8c12b93e87f1208aa82d85b0afe2a83173131a67a9ae9e395b52861d0636c98ac', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 18:23:53', '2023-01-27 18:23:53', '2024-01-27 18:23:53'),
('bd756da7d6becb3bad92e1577026c8e808a9853814b070629fe9484951bf87ce4d0eee2a3b1d5460', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 05:19:57', '2023-01-30 05:19:58', '2024-01-30 05:19:57'),
('c03c76f461118e0b9621f7ee4a801fb3bac45f0e76955617754282164335b8467e3bc8b180c3dfb7', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 07:14:04', '2023-02-01 07:14:04', '2024-02-01 07:14:04'),
('c4d60fd63d8a68af04c4045c95597326f6151ac61704558c932e00b8d7c7a1ab55e892f8052f8928', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 10:00:32', '2023-01-30 10:00:32', '2024-01-30 10:00:32'),
('c8457df9eda8b9215bd82f261f7d1e10474d4000103aa3075604cd3efd03108319ea147d8830b2eb', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 09:09:29', '2023-02-01 09:09:30', '2024-02-01 09:09:29'),
('c94f56e11f184277333b22fe4ea8d04845b3854e1bbea6be2a09b7e75447a48d089dc53ce60a3042', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:12:51', '2023-02-01 09:12:52', '2024-02-01 09:12:51'),
('cb584d06ca4eef08cc0c3f76bbcf1d9520b7f318ce14a6ef65ddbdc4416e466e626bdd00e3d34538', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:16:14', '2023-02-01 06:16:14', '2024-02-01 06:16:14'),
('cf435efc634b42be9e708749ca63eebd294fbc63e41a638037c69eecb44315ad8bdc8a54eb7158c3', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-26 05:32:32', '2023-01-26 05:32:32', '2024-01-26 05:32:32'),
('cfb40ac29d55c777bd0b9e5855b6b302f0195aa20e116c523508cb2b20f4cc9c5dcf8369363fc367', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 09:05:44', '2023-02-01 09:05:44', '2024-02-01 09:05:44'),
('d254796db02ed7327171732600fb70cacc18f9429d73b52dbf0a3058cf61ac438b832fd486b87968', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:31:06', '2023-01-31 11:31:07', '2024-01-31 11:31:06'),
('d2947e3ed32c8bee0fa53e12589acafa2fff8d1b61efc6cc901de89880645dc53871995b749ad751', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 08:46:06', '2023-02-01 08:46:07', '2024-02-01 08:46:06'),
('d54612a3986e4220791974e3e950f9cb6309e8ac3adf918f50e87d60a6b2b6de7368d3248ba69be1', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:37:56', '2023-01-31 11:37:56', '2024-01-31 11:37:56'),
('d745840843d4d4d0e373e7420c882d006914f9311802911427d9c1daf93f7a8bbfdb9438ab52dc60', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:38:53', '2023-01-31 11:38:54', '2024-01-31 11:38:53'),
('d76af1c803b249635b9da70b7a2897f4f8b280bd39176c746ab9007964a7dd29bff759bcd09876f9', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 04:23:06', '2023-01-27 04:23:07', '2024-01-27 04:23:06'),
('da39fd8028b823c556ac8e69665f946468e52fabed5c68eb1184b42bda412a49d02b32d4443980f6', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:57:29', '2023-01-31 06:57:29', '2024-01-31 06:57:29'),
('dac12bbffa5dd09ad4c7f0c5f41c4966bb22b5bc0b9830a5c914f934c0b1bec5d216b312e2426336', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 13:50:20', '2023-01-30 13:50:20', '2024-01-30 13:50:20'),
('de2854fbec9998fde1c1fbf98eb6e6ce8ab268a86a9a4191f1adf9ec4a40e304e4ed7f5e8b9a8608', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:22:39', '2023-01-31 10:22:39', '2024-01-31 10:22:39'),
('e132be8d1fdf04e9d8855f21167f63d451ab9be654ebbcb5273215395b8d79cd93a35a85b6ca6860', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 11:01:29', '2023-01-31 11:01:29', '2024-01-31 11:01:29'),
('e1573f8b707c8ef58005f83df4e28e9c1ba604d0ce9dab09d11883a81a4162f23301878f086de21c', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 17:02:27', '2023-01-30 17:02:27', '2024-01-30 17:02:27'),
('e16eb889655e723f14848f40041f30a5a8f853cc14ffee3749f692919b5bc3d73b5715c52bf2eac0', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 04:44:19', '2023-02-01 04:44:20', '2024-02-01 04:44:19'),
('e1d38737c9f833b5e69d45961fdf4f0f4fbc4e0184f4ad9d865db7d8b34e6f6c297daef080b38db9', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 13:28:56', '2023-01-27 13:28:56', '2024-01-27 13:28:56'),
('e3ce6ef63b790c2b26e2ccb67a912f5caa86d5d402e1d92b4eaa53822c6f2202f51c0c06e4ded599', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:30:08', '2023-01-31 06:30:09', '2024-01-31 06:30:08'),
('e5d56273b36a2e93930ec7dbeaca84446a488d01be491a14e97a6293cb1e3c9d7e2bca98bc9e9881', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:40:27', '2023-01-30 09:40:27', '2024-01-30 09:40:27'),
('e6d6f65bd80ca0a8016ab02ba4d29de712edba11a6675c4395d1f2c9acf5ca5be426ec3172881c7b', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 10:37:04', '2023-01-31 10:37:04', '2024-01-31 10:37:04'),
('e90e37e2dfef1c5596a5bc0127ee9f8dadd01191c204a6e5c9b4aaeb7b9c8f8bd6383e21f1c8800c', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 06:11:49', '2023-01-31 06:11:49', '2024-01-31 06:11:49'),
('ebe5054e8d099e01b5d5af8e09b4ff5dd2fc3ac6ae6cb6899bffa23a854d366492330bdb795e1538', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-02-01 05:12:24', '2023-02-01 05:12:24', '2024-02-01 05:12:24'),
('edf383dafdfad3dc1dc4760fba9b4c243707a7eb553de92369794c7d2e64cd78807a8bf697cbc5e3', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 11:14:21', '2023-01-27 11:14:21', '2024-01-27 11:14:21'),
('f08e24178d4e6094868a484f3ef7a86ef1aa23dc1f3a99fd666bb2e376ae30dba74158e962fc3dd5', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 04:16:08', '2023-01-30 04:16:08', '2024-01-30 04:16:08'),
('f12db34db094025756d7a4b2de3f17b2ae4aa719bcfd406fd66cbb61b4170d9f872973299aef21a0', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:44:16', '2023-01-31 06:44:17', '2024-01-31 06:44:16'),
('f5fd9db462db7cc3e32ca3ad84b296bec57aeab7cd07f6358ba7bdaea96d5fb0d132d7315b2327d4', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:26:19', '2023-01-31 06:26:20', '2024-01-31 06:26:19'),
('f713d279a6753f29a5305277016a7399669c1b79f5689c0187d1ee7ec241ac41dc75ee22929b8152', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-28 03:07:12', '2023-01-28 03:07:12', '2024-01-28 03:07:12'),
('f84a0051cade38501d4e7de4ddc066500b492ae9817b38c5eccab0f67b1e37f43dacb0f19ca23e20', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 06:17:04', '2023-01-31 06:17:05', '2024-01-31 06:17:04'),
('f86e014ded607d8faa59a4c48dda16ac56d2ab2b76e3c284d91d32e48b600ce8633e55e0acabffba', 54, 1, 'accessToken', '[\"teacher\"]', 0, '2023-01-31 12:39:12', '2023-01-31 12:39:17', '2024-01-31 12:39:12'),
('fb30c789b35f6fbabd435bc5e6ccedadc9121846c3e309015ace6721947fb37d36852520e87d19a9', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-30 09:44:27', '2023-01-30 09:44:28', '2024-01-30 09:44:27'),
('fbdde855371152b07d375a7417dff2eea6bd7d1ea8578965121f7aa81738ed9b7b4b15af22232403', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-31 05:29:48', '2023-01-31 05:29:48', '2024-01-31 05:29:48'),
('fc81f6a91eadf8d4377a2664a429c946913625cb7b244b834480fab9e495a65dbf1c15b2d273f5ff', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-02-01 06:13:23', '2023-02-01 06:13:23', '2024-02-01 06:13:23'),
('fe54713f3cbf40177eb450dec0d9023451e6e7be29fc6cff6eec2f7341ac11b7bc445252c75d4908', 1, 1, 'accessToken', '[\"admin\"]', 0, '2023-01-27 13:07:54', '2023-01-27 13:07:54', '2024-01-27 13:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'UpbZV4fO2LsxmCbhjobbyVcTu7F3BfiovsC3aQwJ', NULL, 'http://localhost', 1, 0, 0, '2023-01-25 14:23:43', '2023-01-25 14:23:43'),
(2, NULL, 'Laravel Password Grant Client', 'sBS2wzIhzzXBSYXgmbBvgKoJCWXie8YrXtKNImcZ', 'users', 'http://localhost', 0, 1, 0, '2023-01-25 14:23:44', '2023-01-25 14:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-01-25 14:23:43', '2023-01-25 14:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_plan_id` bigint UNSIGNED DEFAULT NULL,
  `content_id` bigint UNSIGNED DEFAULT NULL,
  `order_type` tinyint NOT NULL,
  `is_paid` tinyint NOT NULL DEFAULT '0' COMMENT 'not-paid=2; paid=1',
  `total_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `transection_type` tinyint NOT NULL DEFAULT '1' COMMENT 'Credit=1; Debit=2',
  `reward_type` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribed_users`
--

CREATE TABLE `subscribed_users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_plan_id` bigint UNSIGNED NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_platinum` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `name`, `slug`, `is_platinum`, `created_at`, `updated_at`) VALUES
(1, 'Platinum', 'platinum', 1, '2023-01-23 07:01:26', NULL),
(2, 'Gold', 'gold', 0, NULL, NULL),
(3, 'Silver', 'silver', 0, NULL, NULL),
(4, 'Diamond', 'diamond', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'In Days',
  `assignment_request` int NOT NULL,
  `file_download` int NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `subscription_id`, `name`, `duration`, `assignment_request`, `file_download`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '6 month plan', '135000', 3, 3, 0, '2023-01-23 06:52:09', '2023-01-30 04:40:45'),
(2, 2, '9 Months Plan', '270', 75, 75, 1, '2023-01-23 06:55:28', '2023-01-23 06:55:28'),
(4, 3, '3 Months Plan', '300', 25, 25, 0, '2023-01-23 06:56:08', '2023-01-24 08:56:01'),
(8, 4, '12 month plan', '900', 22, 12, 0, '2023-01-23 17:00:30', '2023-01-24 08:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_settings`
--

CREATE TABLE `teacher_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `id_proof` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_hours` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_income` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_settings`
--

INSERT INTO `teacher_settings` (`id`, `user_id`, `id_proof`, `document_path`, `working_hours`, `expected_income`, `preferred_currency`, `subject`, `category`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '8', '8', 'USD', 'data structure', 'it', NULL, NULL),
(2, 2, NULL, NULL, '5', '16', 'USD', 'data structure', 'it', NULL, NULL),
(3, 3, NULL, NULL, '8', '10', 'USD', 'data structure', 'it', NULL, NULL),
(4, 4, NULL, NULL, '5', '15', 'USD', 'data structure', 'it', NULL, NULL),
(5, 5, NULL, NULL, '7', '11', 'USD', 'data structure', 'it', NULL, NULL),
(6, 6, NULL, NULL, '8', '17', 'USD', 'data structure', 'it', NULL, NULL),
(7, 7, NULL, NULL, '4', '10', 'USD', 'data structure', 'it', NULL, NULL),
(8, 8, NULL, NULL, '6', '19', 'USD', 'data structure', 'it', NULL, NULL),
(9, 9, NULL, NULL, '7', '19', 'USD', 'data structure', 'it', NULL, NULL),
(10, 10, NULL, NULL, '4', '12', 'USD', 'data structure', 'it', NULL, NULL),
(11, 51, '', '', NULL, NULL, NULL, 'English', 'i', '2023-01-25 14:38:30', '2023-01-25 14:38:30'),
(12, 52, '', '', NULL, NULL, NULL, 'English', 'i', '2023-01-27 06:58:41', '2023-01-27 06:58:41'),
(13, 53, '', '', NULL, NULL, NULL, 'English', 'i', '2023-01-27 12:02:38', '2023-01-27 12:02:38'),
(14, 54, 'teacher/1674821045.jpg', 'teacher/1674821045.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-27 12:04:05', '2023-01-27 12:04:05'),
(15, 55, 'teacher/1674823677.jpg', 'teacher/1674823677.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-27 12:48:02', '2023-01-27 12:48:02'),
(16, 58, '', '', NULL, NULL, NULL, 'It', NULL, '2023-01-31 06:08:51', '2023-01-31 06:08:51'),
(17, 59, 'teacher/1675148596.jpg', 'teacher/1675148596.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-31 07:03:17', '2023-01-31 07:03:17'),
(18, 60, 'teacher/1675149930.jpg', 'teacher/1675149930.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-31 07:25:32', '2023-01-31 07:25:32'),
(19, 61, 'teacher/1675154080.jpg', 'teacher/1675154080.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-31 08:34:41', '2023-01-31 08:34:41'),
(20, 62, 'teacher/1675154109.jpg', 'teacher/1675154109.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-31 08:35:09', '2023-01-31 08:35:09'),
(21, 63, 'teacher/1675154126.jpg', 'teacher/1675154126.jpg', NULL, NULL, NULL, 'English', 'i', '2023-01-31 08:35:26', '2023-01-31 08:35:26'),
(22, 64, '', '', NULL, NULL, NULL, 'It', NULL, '2023-02-01 07:20:54', '2023-02-01 07:20:54'),
(23, 65, '', '', NULL, NULL, NULL, 'It', NULL, '2023-02-01 07:30:08', '2023-02-01 07:30:08'),
(24, 66, '', '', NULL, NULL, NULL, 'It', NULL, '2023-02-01 09:21:05', '2023-02-01 09:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` tinyint NOT NULL DEFAULT '2' COMMENT 'Teacher=1; Student=2',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `teacher_status` tinyint NOT NULL DEFAULT '0',
  `requested_for_teacher` tinyint NOT NULL DEFAULT '0',
  `is_newsletter_subscriber` tinyint NOT NULL DEFAULT '0',
  `reffer_user_id` int DEFAULT NULL,
  `reffer_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verify_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_subscribe` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_path`, `user_type`, `email_verified_at`, `password`, `is_active`, `teacher_status`, `requested_for_teacher`, `is_newsletter_subscriber`, `reffer_user_id`, `reffer_code`, `email_verify_code`, `is_subscribe`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Florine Bosco', 'lesch.bette@example.com', NULL, 2, '2023-01-25 14:23:02', '$2y$10$Oh2njtnBIpjowOjeGuwEV.4uN6F.025deAbq1skzDZc4dddjTbQ5S', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:22:30', '2023-01-25 14:23:05'),
(2, 'Eleanore Thompson DVM', 'rylan.brown@example.org', NULL, 1, '2023-01-25 14:23:02', '$2y$10$BNJ8Sh0x6CnM9.37YPj7ouQhx3/wH1SHHgYP.VDsEsc1H29IBThkG', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:10:00', '2023-01-25 14:23:05'),
(3, 'Suzanne Schaefer', 'ruecker.lourdes@example.net', NULL, 1, '2023-01-25 14:23:02', '$2y$10$5BZc2g0DlscxcuaheGub6u1DO0z7oXxVUsI0t6oBxuP3.vV8IqfQu', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:26:50', '2023-01-25 14:23:05'),
(4, 'Ivory Kreiger V', 'ortiz.craig@example.org', NULL, 2, '2023-01-25 14:23:02', '$2y$10$xWFQbZFDJ5YR7a./RdINMuUlOB3JsHbElfc3NNoSYrp0BL24gyWAu', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:44:08', '2023-01-25 14:23:05'),
(5, 'Leda Emard', 'rrobel@example.net', NULL, 1, '2023-01-25 14:23:02', '$2y$10$OetuQkknfTaIkO9Bm/2gUO26Vxz8w6yC207GU8g6oJ5bND9asfug2', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:01:15', '2023-01-25 14:23:06'),
(6, 'Adrian Morar', 'bins.billy@example.com', NULL, 2, '2023-01-25 14:23:02', '$2y$10$ng/VhGN.vnuGpppI0MDQPefivYt37EpNMH1DwPquPs1HRB.oG12e.', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:16:26', '2023-01-25 14:23:06'),
(7, 'Dr. Bennie Prohaska', 'jacobi.eugenia@example.net', NULL, 2, '2023-01-25 14:23:02', '$2y$10$//pnO.LbpMW3MJAgvR4dJ.JbY5alvag3AD7w5B7uo2rjee6l4cyIm', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:47:07', '2023-01-25 14:23:06'),
(8, 'Wilton Hyatt', 'rhiannon72@example.com', NULL, 1, '2023-01-25 14:23:02', '$2y$10$ZuSHhTwxvamrh06n4IKi2O0crNuVaxBIxyWL/jYIvQfgh/J/zg6km', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:12:18', '2023-01-25 14:23:06'),
(9, 'Landen Kerluke', 'olson.lenora@example.net', NULL, 2, '2023-01-25 14:23:02', '$2y$10$qqfDT072Z4apgRd90NVEOu2S4Woav3BN.7kBNTlNofFFvG2bBaUhO', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:25:35', '2023-01-25 14:23:06'),
(10, 'Gonzalo Nolan', 'bsteuber@example.com', NULL, 2, '2023-01-25 14:23:02', '$2y$10$JdiuGjmMJhly/k7tYr6ymeY6oe4N2tUQkxNysrKzcUKcXFoYImGiC', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:34:43', '2023-01-25 14:23:06'),
(12, 'Taya Powlowski DDS', 'laron.dicki@example.com', NULL, 1, '2023-01-25 14:23:02', '$2y$10$FpYCcRuLy8rp6kWoOt770eLIMIEWffvSh60CendBUyvRcwIE1ZILS', 1, 2, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:40:03', '2023-01-27 06:58:52'),
(13, 'Hilbert Dooley I', 'adelia.herman@example.net', NULL, 1, '2023-01-25 14:23:02', '$2y$10$QyJcyMIBblQCrWObG6BMH.m.qMZQhknMwLOEBJ1wyy5NFo3n/7HgO', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:33:00', '2023-01-25 14:23:07'),
(14, 'Ms. Tyra Dickens', 'littel.ashton@example.net', NULL, 2, '2023-01-25 14:23:02', '$2y$10$U3dcs4GQ2zVO0hBtpFn0h.6GujKCMmHVBIHRWvngvvvavtTT8433i', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:32:05', '2023-01-25 14:23:07'),
(15, 'Jacinto Robel', 'gerlach.carlos@example.org', NULL, 1, '2023-01-25 14:23:02', '$2y$10$X88SDERq73P5k/UQzEMaZePIawMi3jd7D6T6bH1bEx4CaM2vKnjJG', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:33:21', '2023-01-25 14:23:07'),
(16, 'Carolanne Feest', 'halvorson.melba@example.com', NULL, 2, '2023-01-25 14:23:02', '$2y$10$Ixi0FQVYWOCdUL3EQT/.BupNjcrdh7bOb5MjNl/uB0lmhilj.tcT6', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:28:37', '2023-01-25 14:23:08'),
(17, 'Ms. Michele Brakus', 'addie.rodriguez@example.org', NULL, 1, '2023-01-25 14:23:03', '$2y$10$KPaBrH/bYoS3.jHfL61SMOUqnhQMvx50NJBg7j1qzdKBozB8LYDqS', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:51:31', '2023-01-25 14:23:08'),
(18, 'Lolita Kuhlman V', 'bryce.durgan@example.com', NULL, 2, '2023-01-25 14:23:03', '$2y$10$bVRIqNDu0g.zUq22BQMBc.79Q5/9a9ZWx9/uQe5VIUb/tTlEUwubW', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:29:41', '2023-01-25 14:23:08'),
(19, 'Zion Beer', 'arely.ullrich@example.org', NULL, 2, '2023-01-25 14:23:03', '$2y$10$TYwy49Z8n6C0DVMN/9a7t.Q.b35AgWCARZ8QlpuXtFHq5MNG/CPSi', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:33:45', '2023-01-25 14:23:08'),
(20, 'Prof. Angelo Murazik', 'alyce17@example.com', NULL, 2, '2023-01-25 14:23:03', '$2y$10$ssHIG4Mnjomg04Ur3DajseRa6MtiUk1.zLTX.hosTmJnWgVGea0L6', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:55:45', '2023-01-25 14:23:09'),
(21, 'Mr. Marquis Metz IV', 'rowe.brice@example.org', NULL, 1, '2023-01-25 14:23:03', '$2y$10$BaX..Gl48DmUsrBw8OVNuud/dCphS9adXEebBfZ1fcVTzv4Lkgfje', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:10:02', '2023-01-25 14:23:09'),
(22, 'Ms. Vita Walker', 'torey53@example.org', NULL, 1, '2023-01-25 14:23:03', '$2y$10$lPlSK2fMVZ6XKHHL7R3a6OflkIm7zGyRstXJJSk99qMhHPjwBPVx6', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:37:30', '2023-01-25 14:23:09'),
(23, 'Rafaela Pfeffer', 'lrunolfsson@example.net', NULL, 2, '2023-01-25 14:23:03', '$2y$10$GdatsrnsCrBfCPhjMmoKBOY0qigyOHjlw8pdZhI7ZpUsOAisahnsW', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:21:35', '2023-01-25 14:23:09'),
(24, 'Buck Kuvalis', 'emerald70@example.com', NULL, 1, '2023-01-25 14:23:03', '$2y$10$McAID8tlptGux80VyGjiXOkVz7utdsELvmW8/0ydxus6MTgJUzBni', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:50:38', '2023-01-25 14:23:09'),
(25, 'Prof. Saige Torp', 'jessika26@example.net', NULL, 1, '2023-01-25 14:23:03', '$2y$10$IUYz.kVXecSU7AIyVpOJhe.cqAd59cXc0xhe3odl8ktNPJ2JxRcym', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:31:00', '2023-01-25 14:23:10'),
(26, 'Christiana Rohan', 'lenore41@example.net', NULL, 2, '2023-01-25 14:23:03', '$2y$10$.piX6.5lX03gmIdLReAO6eqlbBG0Dj1.5UeUjgAL34A57TAxSUzpi', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:14:52', '2023-01-25 14:23:10'),
(27, 'Forrest Rohan', 'cmoore@example.net', NULL, 2, '2023-01-25 14:23:03', '$2y$10$bEVc9SE3eT1MD7xyHSJtxOZQdoy94qCYLxQ8h6BCmAx8kWuyodlIm', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:19:26', '2023-01-25 14:23:10'),
(28, 'Roy Stiedemann I', 'oschmitt@example.com', NULL, 2, '2023-01-25 14:23:03', '$2y$10$3s5f8hUWc.JAKg3VBfNhYurWV8mYDfy2LoK7qStVL9DyYOGGrVnji', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:02:30', '2023-01-25 14:23:10'),
(29, 'Wyatt McCullough', 'dasia.botsford@example.net', NULL, 2, '2023-01-25 14:23:03', '$2y$10$KDuw6toTJZ1EbMzEcSpnkeVO3U6E.Vd4lJsVsAxKIfOuRlrbWU8EC', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:12:59', '2023-01-25 14:23:10'),
(30, 'Nya Ferry', 'franecki.camden@example.org', NULL, 2, '2023-01-25 14:23:03', '$2y$10$Pwhlpcfc7YjxOjPhZ/Kihul.CFyi8LJQ7kBnKgxY3obcv2.iowKKa', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:59:56', '2023-01-25 14:23:11'),
(31, 'Gudrun Dach', 'destany.johnston@example.net', NULL, 1, '2023-01-25 14:23:03', '$2y$10$Mu3sDmx.WgasTNDefUkmc.oQw.6zsND9DWHuoo7rRjsbIuGZC8/c.', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:08:13', '2023-01-25 14:23:11'),
(32, 'Dorcas Streich III', 'elisha13@example.org', NULL, 1, '2023-01-25 14:23:03', '$2y$10$p9lf.9RoU48GOpz1iM6Dx.03Mq3AnTY7oKl1A4b1eNRVNSBw3vZ8u', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:19:51', '2023-01-25 14:23:11'),
(33, 'Mrs. Zoey Jast PhD', 'alex.kuphal@example.net', NULL, 2, '2023-01-25 14:23:03', '$2y$10$WG0rj37JIPLWs3UcVEF6m.54ue3MEdQqmU5PBwCGiz1V9p0eQEzXu', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:55:08', '2023-01-25 14:23:11'),
(34, 'Lillie Sawayn', 'adams.maryam@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$HZ64Os4L5WWSkh83vkU2dO76bgtn/XpjRksdzt4xrhTPMcroIWvne', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:44:06', '2023-01-25 14:23:12'),
(35, 'Ms. Violet Vandervort III', 'jast.heber@example.com', NULL, 1, '2023-01-25 14:23:04', '$2y$10$k0XlFihbXTI9NqgZ1NP.EObJ2qsqsgjRVDPscJAJjiNw4DC03TKXy', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:49:15', '2023-01-25 14:23:12'),
(36, 'Prof. Wilford Davis', 'jemard@example.com', NULL, 2, '2023-01-25 14:23:04', '$2y$10$6hfrxfFZq02HhIHDCu4UYePBWQbBbA5CCOzi/hJBXAYBcTxA1Om/6', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:32:41', '2023-01-25 14:23:12'),
(37, 'Aglae Friesen', 'stracke.katelin@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$M0uqKclRPXNP7sRJN3/hXuSEKzFLxnEfPjzaDAkJ2mRC7LBgwj76m', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 10:08:50', '2023-01-25 14:23:12'),
(38, 'Aaron Reichert', 'consuelo72@example.com', NULL, 1, '2023-01-25 14:23:04', '$2y$10$yXshqGx4cVYuCfp8Kp.ENOsf/.6uWhlnqH4J8tL/3.6ANknnMZtqu', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:19:50', '2023-01-25 14:23:12'),
(39, 'Vickie Romaguera', 'harley.dibbert@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$ekVlfcIQVCKw0kMhmN9lCuanensoP/l9Vo3Fu2buoZCCPrTvk4K8m', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:34:05', '2023-01-25 14:23:12'),
(40, 'Carlos Graham', 'weber.alvena@example.net', NULL, 1, '2023-01-25 14:23:04', '$2y$10$5xC1JnR3yt9jwSQWmonRP.Cgh3HKbb7RPfVu4.QozOCGGU1Xx7Wsq', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:59:30', '2023-01-25 14:23:13'),
(41, 'Jada Glover II', 'markus.wisozk@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$P/LsBNM1lchzYEVHqNXFKuHggOo8awElYNq7.4D3hfcvkGZjGp4r6', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:01:04', '2023-01-25 14:23:13'),
(42, 'Tiana Walker', 'dankunding@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$oYo/hNM0fSXnc09/77eIhOCy0fhD8sWNpMDbPnvLD7/DlUyCSIli2', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 09:04:20', '2023-01-25 14:23:13'),
(43, 'Tatyana Nolan', 'frodriguez@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$Arc/XFy7Khjv7AwCi/Ey1uMDgOXTHyR5xWrMgoPydZ0G4FPHvK1FS', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 06:58:36', '2023-01-25 14:23:13'),
(44, 'Mrs. Lorine Abbott MD', 'dmorissette@example.com', NULL, 1, '2023-01-25 14:23:04', '$2y$10$MZ/SwUib9v1ZsnlPCGyKKu4e1vEe8jDL2ECTKqYrQKFAe8z/EaQOK', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:14:13', '2023-01-25 14:23:13'),
(45, 'Dr. Jaydon Beer', 'raquel26@example.org', NULL, 1, '2023-01-25 14:23:04', '$2y$10$OsLL9HHCA6mhNLQablM1ZOppKOidHJCaKSbwlQ835p1PtpSdsdXo.', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:16:32', '2023-01-25 14:23:14'),
(46, 'Berta Spencer', 'larry38@example.org', NULL, 1, '2023-01-25 14:23:04', '$2y$10$Xgbv2uYu5iux3sKdH4iWguuodY4VLxEm6U/7skSR4ZiD7wU10zg0a', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:10:02', '2023-01-25 14:23:14'),
(47, 'Elnora Toy Sr.', 'alebsack@example.net', NULL, 2, '2023-01-25 14:23:04', '$2y$10$E07aOMjbrE/rSOzRsG4r/OE1GouzV33h4PLlTuE9LENIZKqLnBtkm', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:47:14', '2023-01-25 14:23:14'),
(48, 'Thomas Ortiz', 'tromp.elmer@example.org', NULL, 2, '2023-01-25 14:23:04', '$2y$10$ZAclh8Ws.z1UQAB0vwFLS.kVjoqFkGOefw69muE8jRC9V1Wt43r42', 1, 3, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 08:29:55', '2023-01-25 14:23:14'),
(49, 'Prof. Elton McLaughlin IV', 'hyatt.princess@example.com', NULL, 2, '2023-01-25 14:23:04', '$2y$10$TaYye6bZ6lqtuW2eJ.X5g.vjl.EJDnfQDXXVC0.zFqRH1m81K9Uae', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:41:19', '2023-01-25 14:23:14'),
(50, 'Bernie Hettinger', 'emmett85@example.com', NULL, 2, '2023-01-25 14:23:04', '$2y$10$mKk7j0HFqVxSpZFjD4Zq..3c9TBuL1wX9zo8tZ8OBGrzmg36olSIu', 1, 1, 0, 0, NULL, NULL, NULL, 0, NULL, '2022-09-02 07:06:29', '2023-01-25 14:23:15'),
(51, 'Ariamaa', 'testhariamaa@email.com', '', 1, NULL, '$2y$10$nwvcGDdzVV9tFMItOlv/d.5ihCUAYJ5toGLIK/J5dwBWKyWP4zfp2', 1, 2, 1, 0, NULL, NULL, 'tV16hSJoho', 0, NULL, '2023-01-25 14:38:30', '2023-01-31 07:23:37'),
(52, 'Arikia', 'testharikia@email.com', '', 2, NULL, '$2y$10$nboBW/kXF4ahI9E13r7fV.BNH/aQF/uNogbuBXA4aJwFdfI6MNvfq', 1, 3, 1, 0, NULL, NULL, 'BKIV6Oyd76', 0, NULL, '2023-01-27 06:58:39', '2023-01-31 07:22:32'),
(53, 'Shivanshu', 'shivanshu1572@yopmail.com', '', 1, NULL, '$2y$10$4TBOHWs2sFRgFFlxUUpnOe7aTE39XwykK.PlBeWyP8YI9pVsvdJDK', 1, 2, 1, 0, NULL, NULL, 'uMFsDtlM22', 0, NULL, '2023-01-27 12:02:38', '2023-01-31 07:20:29'),
(54, 'Shivanshu', 'shivanshu15@yopmail.com', 'profile/1674821045.jpg', 1, '2023-01-26 18:37:38', '$2y$10$WLkjchWLBBGYl6TiGO1VFOS1oegZFAhHSUSFpqICJruHBzqt5yQNm', 1, 2, 1, 0, NULL, NULL, 'TOIMB31mXL', 0, NULL, '2023-01-27 12:04:05', '2023-01-27 12:28:20'),
(55, 'Shiva', 'shivanshu2@yopmail.com', 'profile/1674823675.jpg', 1, NULL, '$2y$10$TjTXQFBcvciUIDLl.MDKzuOCyeQvoRQlSyobyeagL6ny8HlM8TzFC', 1, 2, 1, 0, NULL, NULL, 'gjXKKdtFrn', 0, NULL, '2023-01-27 12:47:55', '2023-01-31 07:21:56'),
(56, 'rajat', 'rajat@gmail.com', '', 1, NULL, '$2y$10$PNKMhm0WuArpKTwx.LivEu/L0LpjzYy.9HE54Sw4fGSnnnUPR3wXC', 1, 2, 1, 0, NULL, NULL, '3w1ggYlXX0', 0, NULL, '2023-01-31 06:03:16', '2023-01-31 07:19:27'),
(57, 'rajat', 'Rajat1234@gmail.com', '', 1, NULL, '$2y$10$iGwN018z3vnbqswsStR.l.FsCm/ptmlOu7Fs8wFAW6aeFPFSr83ta', 1, 2, 1, 0, NULL, NULL, 'vJRWqaaSEM', 0, NULL, '2023-01-31 06:07:09', '2023-01-31 07:19:20'),
(58, 'rajat', 'Rajat12@gmail.com', '', 1, NULL, '$2y$10$gEHIdvEosKjarbWLC1oKaeK0y5VNy6bWKbxKY.6PpPIU87gphQkIq', 1, 2, 1, 0, NULL, NULL, 'zHOKOPeGyM', 0, NULL, '2023-01-31 06:08:51', '2023-01-31 07:16:33'),
(59, 'King', 'ankitKing@yopmail.com', 'profile/1675148596.jpg', 1, NULL, '$2y$10$f0wOOWkzDxytF3W6ml36ReMSzm8oOJObZhh5ZzzOtBF9V3.YjxurO', 1, 2, 1, 0, NULL, NULL, '40OndPHKJt', 0, NULL, '2023-01-31 07:03:16', '2023-01-31 07:13:19'),
(60, 'Veer', 'veer@yopmail.com', 'profile/1675149929.jpg', 2, NULL, '$2y$10$LzXmeZgrPYBLfkVb2cEb8OfGApclrdiVhfoMoob1kAxLBzCtiG6Oy', 1, 3, 1, 0, NULL, NULL, 'KFWP3sP0BW', 0, NULL, '2023-01-31 07:25:29', '2023-01-31 08:33:42'),
(61, 'Veera', 'veera@yopmail.com', 'profile/1675154079.jpg', 2, NULL, '$2y$10$69gHnV1qDAOBsP04hbzfj.yzcf496zIwVdmp1IE8.Yy5uSHVWQcm2', 1, 1, 1, 0, NULL, NULL, 'xs6oU36BSX', 0, NULL, '2023-01-31 08:34:39', '2023-01-31 08:34:39'),
(62, 'Bob', 'Bob@yopmail.com', 'profile/1675154108.jpg', 2, NULL, '$2y$10$gmUJ06V88l1J.OEb1d5SpuFbhh9MYDhCNDTU0g/tkchjT2nl8zhSu', 1, 1, 1, 0, NULL, NULL, 'L7lFAGWvfF', 0, NULL, '2023-01-31 08:35:08', '2023-01-31 08:35:08'),
(63, 'Boby', 'Boby@yopmail.com', 'profile/1675154125.jpg', 1, NULL, '$2y$10$237ilMyGwJ7shjGVn5/UNOVT.ZoqiUp5oMSnt02iBPQERStaIch3.', 1, 3, 1, 0, NULL, NULL, 'l5YaD2dR79', 0, NULL, '2023-01-31 08:35:25', '2023-02-01 08:52:41'),
(64, 'sukh', 'sukh@gmail.com', '', 2, NULL, '$2y$10$GMpNI55B4HkP02tsSaN6VOxMvv.BhsuoarcRth5BpxO3G1MktUmBC', 1, 3, 1, 0, NULL, NULL, 'NeG4ITgAte', 0, NULL, '2023-02-01 07:20:52', '2023-02-01 08:50:47'),
(65, 'Abbey', 'Abbey@gmail.con', '', 1, NULL, '$2y$10$cNfnX.uFgdClciC6SO9O2OZNUNglrd6KFP854p5osLQRghJnx5iAK', 1, 2, 1, 0, NULL, NULL, 'Uf1PV1QEy0', 0, NULL, '2023-02-01 07:30:07', '2023-02-01 08:35:03'),
(66, 'william', 'william@yopmail.com', '', 1, NULL, '$2y$10$rzfpzcFzxGOMQmIQC1UkiO5l0JE4wSXlU2.uD72CjAxrJrImSvyBe', 1, 3, 1, 0, NULL, NULL, '01vnWp9gVP', 0, NULL, '2023-02-01 09:21:03', '2023-02-01 09:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `university` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `gender`, `age`, `contact`, `city`, `state`, `country`, `qualification`, `university`, `created_at`, `updated_at`) VALUES
(1, 1, 'male', 25, '8513054368', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:24:33', NULL),
(2, 2, 'male', 25, '7838773149', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:20:50', NULL),
(3, 3, 'male', 25, '8644613701', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:24:37', NULL),
(4, 4, 'male', 25, '8142928704', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:21:55', NULL),
(5, 5, 'male', 25, '8036048807', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 06:53:04', NULL),
(6, 6, 'male', 25, '8884395632', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:42:55', NULL),
(7, 7, 'male', 25, '7443297104', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:46:19', NULL),
(8, 8, 'male', 25, '8326696056', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:32:43', NULL),
(9, 9, 'male', 25, '9032795753', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:12:43', NULL),
(10, 10, 'male', 25, '8362972248', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 06:52:53', NULL),
(11, 11, 'male', 25, '9538795738', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:35:15', NULL),
(12, 12, 'male', 25, '9836772366', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:04:22', NULL),
(13, 13, 'male', 25, '7939268357', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:44:23', NULL),
(14, 14, 'male', 25, '9639715954', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:52:57', NULL),
(15, 15, 'male', 25, '8747408417', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:19:44', NULL),
(16, 16, 'male', 25, '8038017418', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:02:27', NULL),
(17, 17, 'male', 25, '7837677649', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:14:36', NULL),
(18, 18, 'male', 25, '9141151182', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:37:13', NULL),
(19, 19, 'male', 25, '9285925139', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 10:01:45', NULL),
(20, 20, 'male', 25, '8608391698', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:38:58', NULL),
(21, 21, 'male', 25, '8253426448', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:18:29', NULL),
(22, 22, 'male', 25, '8533361293', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:08:27', NULL),
(23, 23, 'male', 25, '8581873954', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:54:57', NULL),
(24, 24, 'male', 25, '9876329966', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:47:04', NULL),
(25, 25, 'male', 25, '9852365529', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:48:29', NULL),
(26, 26, 'male', 25, '8990882507', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:07:09', NULL),
(27, 27, 'male', 25, '8507814184', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:36:16', NULL),
(28, 28, 'male', 25, '7388485973', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:35:17', NULL),
(29, 29, 'male', 25, '7600266741', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:16:12', NULL),
(30, 30, 'male', 25, '8903766302', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:59:00', NULL),
(31, 31, 'male', 25, '9111518297', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:19:07', NULL),
(32, 32, 'male', 25, '7510633160', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:58:42', NULL),
(33, 33, 'male', 25, '7484927670', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:02:14', NULL),
(34, 34, 'male', 25, '8200228763', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:20:22', NULL),
(35, 35, 'male', 25, '7988569357', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 06:27:08', NULL),
(36, 36, 'male', 25, '7656985860', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:44:39', NULL),
(37, 37, 'male', 25, '7205040995', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:27:21', NULL),
(38, 38, 'male', 25, '9090107177', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:42:12', NULL),
(39, 39, 'male', 25, '8892798940', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:26:48', NULL),
(40, 40, 'male', 25, '8772032028', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:07:35', NULL),
(41, 41, 'male', 25, '7189392347', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:45:28', NULL),
(42, 42, 'male', 25, '7839683990', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:08:42', NULL),
(43, 43, 'male', 25, '8713730624', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 10:04:13', NULL),
(44, 44, 'male', 25, '8998921536', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:39:17', NULL),
(45, 45, 'male', 25, '7823342783', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:28:48', NULL),
(46, 46, 'male', 25, '7196052293', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:02:41', NULL),
(47, 47, 'male', 25, '7565956375', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 06:29:57', NULL),
(48, 48, 'male', 25, '9095820886', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 08:39:26', NULL),
(49, 49, 'male', 25, '7382058749', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 07:31:44', NULL),
(50, 50, 'male', 25, '8794907011', 'mohali', 'punjab', 'india', 'BA', 'PU', '2022-09-02 09:26:42', NULL),
(51, 51, 'male', 22, '8796566654', 'Austriam', 'Punbyum', 'India', 'B CA', 'PU', '2023-01-25 14:38:30', '2023-01-25 14:38:30'),
(52, 52, 'male', 22, '8798855654', 'Austrimn', 'Pugut', 'India', 'B CA', 'PU', '2023-01-27 06:58:39', '2023-01-27 06:58:39'),
(53, 53, 'male', 22, '8798855654', 'Austrimn', 'Pugut', 'India', 'B CA', 'PU', '2023-01-27 12:02:38', '2023-01-27 12:02:38'),
(54, 54, 'male', 22, '8798855654', 'Austrimn', 'Pugut', 'India', 'B CA', 'PU', '2023-01-27 12:04:05', '2023-01-27 12:04:05'),
(55, 55, 'male', 22, '879885666', 'Austak', 'Pugut', 'India', 'B CA', 'PU', '2023-01-27 12:47:57', '2023-01-27 12:47:57'),
(56, 57, NULL, NULL, '7056928781', NULL, NULL, 'India', 'Phd', NULL, '2023-01-31 06:07:10', '2023-01-31 06:07:10'),
(57, 58, NULL, NULL, '7056928781', NULL, NULL, 'India', 'Phd', NULL, '2023-01-31 06:08:51', '2023-01-31 06:08:51'),
(58, 59, 'male', 22, '879885644', 'Austaki', 'Puguti', 'India', 'B CA', 'PU', '2023-01-31 07:03:17', '2023-01-31 07:03:17'),
(59, 60, 'male', 22, '879565623', 'Austuht', 'Puguti', 'India', 'B CA', 'PU', '2023-01-31 07:25:30', '2023-01-31 07:25:30'),
(60, 61, 'male', 22, '879565623', 'Austuht', 'Puguti', 'India', 'B CA', 'PU', '2023-01-31 08:34:40', '2023-01-31 08:34:40'),
(61, 62, 'male', 22, '579565623', 'Austuht', 'Puguti', 'India', 'B CA', 'PU', '2023-01-31 08:35:09', '2023-01-31 08:35:09'),
(62, 63, 'male', 22, '579562623', 'Austuht', 'Puguti', 'India', 'BBA', 'PU', '2023-01-31 08:35:26', '2023-01-31 08:35:26'),
(63, 64, NULL, NULL, '3242342342342', NULL, NULL, 'India', 'Phd', NULL, '2023-02-01 07:20:53', '2023-02-01 07:20:53'),
(64, 65, NULL, NULL, '34234234234', NULL, NULL, 'India', 'Phd', NULL, '2023-02-01 07:30:07', '2023-02-01 07:30:07'),
(65, 66, NULL, NULL, '2384412343', NULL, NULL, 'India', 'Phd', NULL, '2023-02-01 09:21:04', '2023-02-01 09:21:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_types`
--
ALTER TABLE `content_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_types_slug_unique` (`slug`);

--
-- Indexes for table `email_histories`
--
ALTER TABLE `email_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_templates_slug_unique` (`slug`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_letter_histories`
--
ALTER TABLE `news_letter_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribed_users`
--
ALTER TABLE `subscribed_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_slug_unique` (`slug`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_settings`
--
ALTER TABLE `teacher_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_settings_user_id_unique` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_details_user_id_unique` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `content_types`
--
ALTER TABLE `content_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_histories`
--
ALTER TABLE `email_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `news_letter_histories`
--
ALTER TABLE `news_letter_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribed_users`
--
ALTER TABLE `subscribed_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher_settings`
--
ALTER TABLE `teacher_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
