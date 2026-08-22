-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 21 2026 г., 19:12
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `law_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'individual',
  `name` varchar(255) NOT NULL,
  `bin_iin` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Казахстан',
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `bank_name` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `codexes`
--

CREATE TABLE `codexes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `title`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Казахстан', 'KZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 'Россия', 'RU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 'Узбекистан', 'UZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(4, 'Кыргызстан', 'KG', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(5, 'Беларусь', 'BY', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(6, 'Азербайджан', 'AZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(7, 'Армения', 'AM', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(8, 'Грузия', 'GE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(9, 'Молдова', 'MD', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(10, 'Таджикистан', 'TJ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(11, 'Туркменистан', 'TM', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(12, 'Украина', 'UA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(13, 'Австралия', 'AU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(14, 'Австрия', 'AT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(15, 'Албания', 'AL', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(16, 'Алжир', 'DZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(17, 'Андорра', 'AD', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(18, 'Ангола', 'AO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(19, 'Аргентина', 'AR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(20, 'Афганистан', 'AF', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(21, 'Багамы', 'BS', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(22, 'Бангладеш', 'BD', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(23, 'Барбадос', 'BB', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(24, 'Бахрейн', 'BH', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(25, 'Бельгия', 'BE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(26, 'Белиз', 'BZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(27, 'Бенин', 'BJ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(28, 'Болгария', 'BG', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(29, 'Боливия', 'BO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(30, 'Босния и Герцеговина', 'BA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(31, 'Бразилия', 'BR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(32, 'Бруней', 'BN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(33, 'Буркина-Фасо', 'BF', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(34, 'Бурунди', 'BI', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(35, 'Бутан', 'BT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(36, 'Вануату', 'VU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(37, 'Ватикан', 'VA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(38, 'Великобритания', 'GB', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(39, 'Венгрия', 'HU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(40, 'Венесуэла', 'VE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(41, 'Вьетнам', 'VN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(42, 'Германия', 'DE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(43, 'Гондурас', 'HN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(44, 'Греция', 'GR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(45, 'Дания', 'DK', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(46, 'Египет', 'EG', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(47, 'Израиль', 'IL', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(48, 'Индия', 'IN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(49, 'Индонезия', 'ID', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(50, 'Иордания', 'JO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(51, 'Ирак', 'IQ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(52, 'Иран', 'IR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(53, 'Ирландия', 'IE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(54, 'Исландия', 'IS', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(55, 'Испания', 'ES', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(56, 'Италия', 'IT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(57, 'Йемен', 'YE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(58, 'Камбоджа', 'KH', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(59, 'Камерун', 'CM', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(60, 'Канада', 'CA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(61, 'Катар', 'QA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(62, 'Кипр', 'CY', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(63, 'Китай', 'CN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(64, 'Колумбия', 'CO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(65, 'Корея (Южная)', 'KR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(66, 'Куба', 'CU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(67, 'Кувейт', 'KW', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(68, 'Латвия', 'LV', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(69, 'Ливан', 'LB', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(70, 'Литва', 'LT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(71, 'Лихтенштейн', 'LI', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(72, 'Люксембург', 'LU', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(73, 'Малайзия', 'MY', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(74, 'Мальта', 'MT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(75, 'Мексика', 'MX', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(76, 'Монако', 'MC', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(77, 'Монголия', 'MN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(78, 'Мьянма', 'MM', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(79, 'Непал', 'NP', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(80, 'Нидерланды', 'NL', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(81, 'Новая Зеландия', 'NZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(82, 'Норвегия', 'NO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(83, 'ОАЭ', 'AE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(84, 'Оман', 'OM', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(85, 'Пакистан', 'PK', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(86, 'Панама', 'PA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(87, 'Перу', 'PE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(88, 'Польша', 'PL', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(89, 'Португалия', 'PT', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(90, 'Румыния', 'RO', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(91, 'Саудовская Аравия', 'SA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(92, 'Сербия', 'RS', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(93, 'Сингапур', 'SG', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(94, 'Сирия', 'SY', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(95, 'Словакия', 'SK', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(96, 'Словения', 'SI', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(97, 'США', 'US', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(98, 'Таиланд', 'TH', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(99, 'Тайвань', 'TW', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(100, 'Тунис', 'TN', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(101, 'Турция', 'TR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(102, 'Филиппины', 'PH', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(103, 'Финляндия', 'FI', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(104, 'Франция', 'FR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(105, 'Хорватия', 'HR', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(106, 'Черногория', 'ME', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(107, 'Чехия', 'CZ', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(108, 'Швейцария', 'CH', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(109, 'Швеция', 'SE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(110, 'Шри-Ланка', 'LK', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(111, 'Эстония', 'EE', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(112, 'ЮАР', 'ZA', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(113, 'Япония', 'JP', '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `title`, `created_at`, `updated_at`) VALUES
(1, 'KZT', 'Казахстанский тенге', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 'USD', 'Доллар США', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 'EUR', 'Евро', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(4, 'RUB', 'Российский рубль', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(5, 'GBP', 'Британский фунт', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(6, 'CNY', 'Китайский юань', '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Полиграфическое подразделение', 'poligraphy', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 'Переводческое подразделение', 'translation', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 'Юридическое подразделение', 'legal', '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `iin` varchar(12) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `salary` int(11) DEFAULT NULL,
  `hired_at` date DEFAULT NULL,
  `fired_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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
-- Структура таблицы `instances`
--

CREATE TABLE `instances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
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
-- Структура таблицы `job_batches`
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
-- Структура таблицы `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Азербайджанский', 'azerbaidzanskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 'Английский', 'angliiskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 'Арабский', 'arabskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(4, 'Армянский', 'armianskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(5, 'Белорусский', 'belorusskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(6, 'Болгарский', 'bolgarskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(7, 'Венгерский', 'vengerskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(8, 'Вьетнамский', 'vetnamskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(9, 'Греческий', 'greceskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(10, 'Грузинский', 'gruzinskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(11, 'Датский', 'datskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(12, 'Иврит', 'ivrit', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(13, 'Индонезийский', 'indoneziiskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(14, 'Испанский', 'ispanskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(15, 'Итальянский', 'italianskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(16, 'Казахский', 'kazaxskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(17, 'Китайский', 'kitaiskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(18, 'Корейский', 'koreiskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(19, 'Кыргызский', 'kyrgyzskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(20, 'Латышский', 'latysskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(21, 'Литовский', 'litovskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(22, 'Немецкий', 'nemeckii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(23, 'Нидерландский', 'niderlandskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(24, 'Норвежский', 'norvezskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(25, 'Польский', 'polskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(26, 'Португальский', 'portugalskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(27, 'Румынский', 'rumynskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(28, 'Русский', 'russkii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(29, 'Сербский', 'serbskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(30, 'Словацкий', 'slovackii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(31, 'Словенский', 'slovenskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(32, 'Таджикский', 'tadzikskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(33, 'Татарский', 'tatarskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(34, 'Турецкий', 'tureckii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(35, 'Узбекский', 'uzbekskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(36, 'Украинский', 'ukrainskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(37, 'Финский', 'finskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(38, 'Французский', 'francuzskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(39, 'Чешский', 'cesskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(40, 'Японский', 'iaponskii', '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `legal_cases`
--

CREATE TABLE `legal_cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_10_073723_create_categories_table', 1),
(5, '2026_08_10_073748_create_tags_table', 1),
(6, '2026_08_10_073800_create_posts_table', 1),
(7, '2026_08_10_073856_create_post_tag_table', 1),
(8, '2026_08_10_075024_create_regions_table', 1),
(9, '2026_08_10_075108_create_roles_table', 1),
(10, '2026_08_10_075150_create_codexes_table', 1),
(11, '2026_08_10_075199_create_role_user_table', 1),
(12, '2026_08_10_075200_create_tenants_table', 1),
(13, '2026_08_10_075201_create_employees_table', 1),
(14, '2026_08_10_075257_create_legal_cases_table', 1),
(15, '2026_08_10_075311_create_tasks_table', 1),
(16, '2026_08_10_075323_create_requests_table', 1),
(17, '2026_08_10_075335_create_clients_table', 1),
(18, '2026_08_10_081222_create_permissions_table', 1),
(19, '2026_08_10_083840_create_service_types_table', 1),
(20, '2026_08_10_083932_create_proceeding_types_table', 1),
(21, '2026_08_10_084008_create_instances_table', 1),
(22, '2026_08_10_084038_create_stages_table', 1),
(23, '2026_08_11_151800_add_thumbnail_original_name_to_posts_table', 1),
(24, '2026_08_20_064207_create_languages_table', 1),
(25, '2026_08_20_131847_create_translator_module_tables', 1),
(26, '2026_08_20_145508_create_currencies_table', 1),
(27, '2026_08_20_153022_create_countries_table', 1),
(28, '2026_08_21_061155_create_nomenclatures_table', 1),
(29, '2026_08_21_061225_create_nomenclature_prices_table', 1),
(30, '2026_08_21_070250_add_units_to_nomenclatures_table', 1),
(31, '2026_08_21_070311_create_nomenclature_boms_table', 1),
(32, '2026_08_21_074027_create_poligraphy_purchases_table', 1),
(33, '2026_08_21_074030_create_poligraphy_orders_table', 1),
(34, '2026_08_21_154030_create_departments_table', 1),
(35, '2026_08_21_154301_add_department_id_to_nomenclatures_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `nomenclatures`
--

CREATE TABLE `nomenclatures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('folder','item') NOT NULL DEFAULT 'folder',
  `category_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `base_unit` varchar(255) NOT NULL DEFAULT 'шт',
  `purchase_unit` varchar(255) DEFAULT NULL,
  `conversion_factor` decimal(10,4) NOT NULL DEFAULT 1.0000,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `nomenclatures`
--

INSERT INTO `nomenclatures` (`id`, `parent_id`, `name`, `type`, `category_type`, `created_at`, `updated_at`, `base_unit`, `purchase_unit`, `conversion_factor`, `department_id`) VALUES
(1, NULL, 'Материалы', 'folder', 'Материалы', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(2, NULL, 'Товары', 'folder', 'Товары', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(3, NULL, 'Услуги', 'folder', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(4, 3, 'Юридические услуги', 'folder', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(5, 3, 'Переводческие услуги', 'folder', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(6, 3, 'Полиграфические услуги', 'folder', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(7, 1, 'Бумага А4 Svetocopy (500л)', 'item', 'Материалы', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'лист', 'пачка', 500.0000, NULL),
(8, 6, 'Распечатка/Копирование ч/б А4', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(9, 6, 'Распечатка/Копирование цв. А4', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(10, 6, 'Сканирование А4', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(11, 6, 'Ламинирование А4', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'шт', NULL, 1.0000, NULL),
(12, 4, 'Консультация', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'усл', NULL, 1.0000, NULL),
(13, 4, 'Представительство в суде 1 инстанции (простое дело)', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'дело', NULL, 1.0000, NULL),
(14, 5, 'Перевод с казахского на русский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(15, 5, 'Перевод с русского на казахский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(16, 5, 'Перевод с английского на русский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(17, 5, 'Перевод с русского на английский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(18, 5, 'Перевод с турецкого на русский/казахский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(19, 5, 'Перевод с китайского на русский/казахский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL),
(20, 5, 'Перевод с немецкого/французского на русский язык', 'item', 'Услуги', '2026-08-21 11:25:10', '2026-08-21 11:25:10', 'стр.', NULL, 1.0000, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `nomenclature_boms`
--

CREATE TABLE `nomenclature_boms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_item_id` bigint(20) UNSIGNED NOT NULL,
  `material_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,4) NOT NULL DEFAULT 1.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `nomenclature_boms`
--

INSERT INTO `nomenclature_boms` (`id`, `parent_item_id`, `material_item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 8, 7, 1.0000, '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 9, 7, 1.0000, '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 10, 7, 1.0000, '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(4, 11, 7, 1.0000, '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `nomenclature_prices`
--

CREATE TABLE `nomenclature_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomenclature_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `nomenclature_prices`
--

INSERT INTO `nomenclature_prices` (`id`, `nomenclature_id`, `purchase_price`, `selling_price`, `effective_date`, `created_at`, `updated_at`) VALUES
(1, 7, 3450.00, 0.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 8, 0.00, 50.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(3, 9, 0.00, 100.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(4, 10, 0.00, 100.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(5, 11, 0.00, 350.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(6, 12, 0.00, 10000.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(7, 13, 0.00, 100000.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(8, 14, 0.00, 2000.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(9, 15, 0.00, 2200.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(10, 16, 0.00, 2500.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(11, 17, 0.00, 2800.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(12, 18, 0.00, 3000.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(13, 19, 0.00, 3500.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(14, 20, 0.00, 3000.00, '2026-08-21', '2026-08-21 11:25:10', '2026-08-21 11:25:10');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `poligraphy_orders`
--

CREATE TABLE `poligraphy_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomenclature_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `material_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `poligraphy_purchases`
--

CREATE TABLE `poligraphy_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomenclature_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `thumbnail_original_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `proceeding_types`
--

CREATE TABLE `proceeding_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `title`, `slug`) VALUES
(1, 'Абайская область', 'abaiskaia-oblast'),
(2, 'Акмолинская область', 'akmolinskaia-oblast'),
(3, 'Актюбинская область', 'aktiubinskaia-oblast'),
(4, 'Алматинская область', 'almatinskaia-oblast'),
(5, 'Атырауская область', 'atyrauskaia-oblast'),
(6, 'Восточно-Казахстанская область', 'vostocno-kazaxstanskaia-oblast'),
(7, 'Жамбылская область', 'zambylskaia-oblast'),
(8, 'Жетысуская область', 'zetysuskaia-oblast'),
(9, 'Западно-Казахстанская область', 'zapadno-kazaxstanskaia-oblast'),
(10, 'Карагандинская область', 'karagandinskaia-oblast'),
(11, 'Костанайская область', 'kostanaiskaia-oblast'),
(12, 'Кызылординская область', 'kyzylordinskaia-oblast'),
(13, 'Мангистауская область', 'mangistauskaia-oblast'),
(14, 'Павлодарская область', 'pavlodarskaia-oblast'),
(15, 'Северо-Казахстанская область', 'severo-kazaxstanskaia-oblast'),
(16, 'Туркестанская область', 'turkestanskaia-oblast'),
(17, 'Улытауская область', 'ulytauskaia-oblast'),
(18, 'город Астана', 'gorod-astana'),
(19, 'город Алматы', 'gorod-almaty'),
(20, 'город Шымкент', 'gorod-symkent');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `outgoing_number` varchar(100) DEFAULT NULL,
  `outgoing_date` date NOT NULL,
  `deadline_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'sent',
  `description` text DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `title`, `slug`) VALUES
(1, 'Администратор', 'admin'),
(2, 'Юрист', 'lawyer'),
(3, 'Переводчик', 'translator'),
(4, 'Клиент', 'client'),
(5, 'Пользователь', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 5, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `service_types`
--

CREATE TABLE `service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
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
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ZIGo0QX3eesGPidsGeRZHaTVsF9sIFhkpZoliVrl', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYkhPODJTZzFUQ0I0NU5rYnZIZTU5cWZzSlg0TFQ2RkxhM1NCalpEZCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdHJhbnNsYXRvcnMiO3M6NToicm91dGUiO3M6MjM6ImFkbWluLnRyYW5zbGF0b3JzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1787330389);

-- --------------------------------------------------------

--
-- Структура таблицы `stages`
--

CREATE TABLE `stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `executor_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `legal_form` varchar(255) NOT NULL,
  `bin_iin` varchar(12) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `registration_region` varchar(255) NOT NULL,
  `location_region` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `actual_address` varchar(255) NOT NULL,
  `director_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `translators`
--

CREATE TABLE `translators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Казахстан',
  `photo_path` varchar(255) DEFAULT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `diploma_path` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `card_type` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `messengers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`messengers`)),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `internal_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `translator_language_pairs`
--

CREATE TABLE `translator_language_pairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translator_id` bigint(20) UNSIGNED NOT NULL,
  `source_language_id` bigint(20) UNSIGNED NOT NULL,
  `target_language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `translator_price_history`
--

CREATE TABLE `translator_price_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_pair_id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(10) NOT NULL,
  `written_price_1800` decimal(12,2) DEFAULT NULL,
  `consecutive_price_hour` decimal(12,2) DEFAULT NULL,
  `simultaneous_price_hour` decimal(12,2) DEFAULT NULL,
  `notarial_fee` decimal(12,2) DEFAULT NULL,
  `editing_price_1800` decimal(12,2) DEFAULT NULL,
  `effective_from` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `verification_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Альжан Исмагулов', 'admin@legalcore.kz', NULL, '$2y$12$ZRG3mmPVHdglJ85YwIE7EeFAupckacI5r1twta37U8eJI9HGH6fGi', NULL, NULL, '2026-08-21 11:25:10', '2026-08-21 11:25:10'),
(2, 'Пользователь', 'test@example.com', NULL, '$2y$12$8/AMO.davF.z2i.KbDTUguFevD7T4rLtRDWaooyLrGQidHfpUEmCu', NULL, NULL, '2026-08-21 11:25:10', '2026-08-21 11:25:10');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Индексы таблицы `codexes`
--
ALTER TABLE `codexes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codexes_slug_unique` (`slug`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_title_unique` (`title`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_slug_unique` (`slug`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_iin_unique` (`iin`),
  ADD UNIQUE KEY `employees_phone_unique` (`phone`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_role_id_foreign` (`role_id`),
  ADD KEY `employees_region_id_foreign` (`region_id`),
  ADD KEY `employees_tenant_id_foreign` (`tenant_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_slug_unique` (`slug`);

--
-- Индексы таблицы `legal_cases`
--
ALTER TABLE `legal_cases`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nomenclatures`
--
ALTER TABLE `nomenclatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomenclatures_parent_id_foreign` (`parent_id`),
  ADD KEY `nomenclatures_department_id_foreign` (`department_id`);

--
-- Индексы таблицы `nomenclature_boms`
--
ALTER TABLE `nomenclature_boms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomenclature_boms_parent_item_id_foreign` (`parent_item_id`),
  ADD KEY `nomenclature_boms_material_item_id_foreign` (`material_item_id`);

--
-- Индексы таблицы `nomenclature_prices`
--
ALTER TABLE `nomenclature_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomenclature_prices_nomenclature_id_foreign` (`nomenclature_id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Индексы таблицы `poligraphy_orders`
--
ALTER TABLE `poligraphy_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poligraphy_orders_nomenclature_id_foreign` (`nomenclature_id`);

--
-- Индексы таблицы `poligraphy_purchases`
--
ALTER TABLE `poligraphy_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poligraphy_purchases_nomenclature_id_foreign` (`nomenclature_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Индексы таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `proceeding_types`
--
ALTER TABLE `proceeding_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_slug_unique` (`slug`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requests_tenant_id_foreign` (`tenant_id`),
  ADD KEY `requests_legal_case_id_foreign` (`legal_case_id`),
  ADD KEY `requests_employee_id_foreign` (`employee_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Индексы таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_tenant_id_foreign` (`tenant_id`),
  ADD KEY `tasks_legal_case_id_foreign` (`legal_case_id`),
  ADD KEY `tasks_creator_id_foreign` (`creator_id`),
  ADD KEY `tasks_executor_id_foreign` (`executor_id`);

--
-- Индексы таблицы `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_bin_iin_unique` (`bin_iin`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`);

--
-- Индексы таблицы `translators`
--
ALTER TABLE `translators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translators_email_unique` (`email`);

--
-- Индексы таблицы `translator_language_pairs`
--
ALTER TABLE `translator_language_pairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translator_language_pairs_translator_id_foreign` (`translator_id`);

--
-- Индексы таблицы `translator_price_history`
--
ALTER TABLE `translator_price_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translator_price_history_language_pair_id_foreign` (`language_pair_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `codexes`
--
ALTER TABLE `codexes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `instances`
--
ALTER TABLE `instances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `legal_cases`
--
ALTER TABLE `legal_cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `nomenclatures`
--
ALTER TABLE `nomenclatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `nomenclature_boms`
--
ALTER TABLE `nomenclature_boms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `nomenclature_prices`
--
ALTER TABLE `nomenclature_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `poligraphy_orders`
--
ALTER TABLE `poligraphy_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `poligraphy_purchases`
--
ALTER TABLE `poligraphy_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `proceeding_types`
--
ALTER TABLE `proceeding_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stages`
--
ALTER TABLE `stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `translators`
--
ALTER TABLE `translators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `translator_language_pairs`
--
ALTER TABLE `translator_language_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `translator_price_history`
--
ALTER TABLE `translator_price_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `employees_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `employees_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `nomenclatures`
--
ALTER TABLE `nomenclatures`
  ADD CONSTRAINT `nomenclatures_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nomenclatures_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `nomenclature_boms`
--
ALTER TABLE `nomenclature_boms`
  ADD CONSTRAINT `nomenclature_boms_material_item_id_foreign` FOREIGN KEY (`material_item_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nomenclature_boms_parent_item_id_foreign` FOREIGN KEY (`parent_item_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `nomenclature_prices`
--
ALTER TABLE `nomenclature_prices`
  ADD CONSTRAINT `nomenclature_prices_nomenclature_id_foreign` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poligraphy_orders`
--
ALTER TABLE `poligraphy_orders`
  ADD CONSTRAINT `poligraphy_orders_nomenclature_id_foreign` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poligraphy_purchases`
--
ALTER TABLE `poligraphy_purchases`
  ADD CONSTRAINT `poligraphy_purchases_nomenclature_id_foreign` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclatures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `requests_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requests_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `tasks_executor_id_foreign` FOREIGN KEY (`executor_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `tasks_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `translator_language_pairs`
--
ALTER TABLE `translator_language_pairs`
  ADD CONSTRAINT `translator_language_pairs_translator_id_foreign` FOREIGN KEY (`translator_id`) REFERENCES `translators` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `translator_price_history`
--
ALTER TABLE `translator_price_history`
  ADD CONSTRAINT `translator_price_history_language_pair_id_foreign` FOREIGN KEY (`language_pair_id`) REFERENCES `translator_language_pairs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
