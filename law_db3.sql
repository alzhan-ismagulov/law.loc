-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 20 2026 г., 11:53
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

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Категория 1', 'kategoriia-1', 'Описание категории 1', '2026-08-10 09:51:01', '2026-08-10 09:51:01'),
(3, 'Категория 2', 'kategoriia-2', 'Описание категории 2', '2026-08-10 09:51:13', '2026-08-10 09:51:13');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'individual',
  `name` varchar(255) NOT NULL,
  `iin_bin` varchar(12) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `id_card_number` varchar(20) DEFAULT NULL,
  `id_card_date` date DEFAULT NULL,
  `id_card_issuer` varchar(255) DEFAULT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
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
(1, 'Азербайджанский', 'azerbaidzanskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(2, 'Английский', 'angliiskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(3, 'Арабский', 'arabskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(4, 'Армянский', 'armianskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(5, 'Белорусский', 'belorusskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(6, 'Болгарский', 'bolgarskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(7, 'Венгерский', 'vengerskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(8, 'Вьетнамский', 'vetnamskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(9, 'Греческий', 'greceskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(10, 'Грузинский', 'gruzinskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(11, 'Датский', 'datskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(12, 'Иврит', 'ivrit', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(13, 'Индонезийский', 'indoneziiskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(14, 'Испанский', 'ispanskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(15, 'Итальянский', 'italianskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(16, 'Казахский', 'kazaxskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(17, 'Китайский', 'kitaiskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(18, 'Корейский', 'koreiskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(19, 'Кыргызский', 'kyrgyzskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(20, 'Латышский', 'latysskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(21, 'Литовский', 'litovskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(22, 'Немецкий', 'nemeckii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(23, 'Нидерландский', 'niderlandskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(24, 'Норвежский', 'norvezskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(25, 'Польский', 'polskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(26, 'Португальский', 'portugalskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(27, 'Румынский', 'rumynskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(28, 'Русский', 'russkii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(29, 'Сербский', 'serbskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(30, 'Словацкий', 'slovackii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(31, 'Словенский', 'slovenskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(32, 'Таджикский', 'tadzikskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(33, 'Татарский', 'tatarskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(34, 'Турецкий', 'tureckii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(35, 'Узбекский', 'uzbekskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(36, 'Украинский', 'ukrainskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(37, 'Финский', 'finskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(38, 'Французский', 'francuzskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(39, 'Чешский', 'cesskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(40, 'Японский', 'iaponskii', '2026-08-20 04:23:51', '2026-08-20 04:23:51');

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
(23, '2026_08_11_151800_add_thumbnail_original_name_to_posts_table', 2),
(24, '2026_08_20_064207_create_languages_table', 3);

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
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `thumbnail_original_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `description`, `content`, `category_id`, `views`, `thumbnail`, `thumbnail_original_name`, `created_at`, `updated_at`) VALUES
(5, 'Переводы между Казахстаном и Россией ждут большие изменения', 'perevody-mezdu-kazaxstanom-i-rossiei-zdut-bolsie-izmeneniia', 'Объём международных денежных переводов через системы денежных переводов (СДП) в Казахстане продолжает сокращаться.', '<p><strong>За&nbsp;январь-июнь </strong>2026-го из&nbsp;страны за&nbsp;рубеж отправили 303,1 млрд тг&nbsp;— на&nbsp;5,6% меньше, чем&nbsp;годом ранее. Объём переводов, полученных из-за&nbsp;рубежа, уменьшился на&nbsp;8,4%, до&nbsp;96,5 млрд&nbsp;тг. В&nbsp;результате исходящие переводы превысили входящие в&nbsp;3,1 раза. Более чем&nbsp;трёхкратный разрыв сохраняется третий год подряд.<br><br>Сокращение продолжается после рекордных показателей 2022 года, когда за&nbsp;январь-июнь за&nbsp;рубеж отправили 495,8 млрд тг, а&nbsp;из-за&nbsp;рубежа получили 270,7 млрд&nbsp;тг. К&nbsp;текущему году объём исходящих переводов относительно этого уровня уменьшился на&nbsp;38,9%, а&nbsp;объём входящих&nbsp;— в&nbsp;2,8 раза. При&nbsp;этом за&nbsp;десять лет динамика двух направлений заметно различалась. По&nbsp;сравнению с&nbsp;январём-июнем 2016 года объём отправленных за&nbsp;рубеж средств вырос на&nbsp;87,5%, тогда как объём полученных из-за&nbsp;рубежа, напротив, сократился на&nbsp;13%.</p><p>&nbsp;</p><p>Основным направлением для&nbsp;отправки денег осталась Россия. За&nbsp;первое полугодие 2026-го туда перевели 119 млрд&nbsp;тг. Второе место занял Узбекистан (73,2 млрд тг), третье&nbsp;— Турция (47,3 млрд тг). В&nbsp;Грузию отправили 19,2 млрд тг, в&nbsp;Кыргызстан&nbsp;— 9,5 млрд тг, в&nbsp;Китай&nbsp;— 7,2 млрд тг, в&nbsp;Азербайджан&nbsp;— 6,9 млрд тг, в&nbsp;Армению&nbsp;— 5,2 млрд тг, в&nbsp;Южную Корею&nbsp;— 3,2 млрд&nbsp;тг. На&nbsp;прочие страны суммарно пришлось 12,4 млрд&nbsp;тг.</p><p>&nbsp;</p><p>Россия лидировала и&nbsp;по&nbsp;объёму поступающих в&nbsp;Казахстан переводов, однако сумма оказалась значительно меньше. За&nbsp;январь-июнь текущего года из&nbsp;РФ поступило 22,2 млрд&nbsp;тг. Далее расположились <a href=\"https://news.mail.ru/card/1405/\">США</a> (16,3 млрд тг), Турция (12,5 млрд тг), Узбекистан (9,7 млрд тг) и&nbsp;Германия (7,6 млрд тг). Из&nbsp;Южной Кореи поступило 4,7 млрд тг, из&nbsp;Кыргызстана&nbsp;— 3,6 млрд тг, из&nbsp;Грузии&nbsp;— 3,5 млрд тг, из&nbsp;Азербайджана&nbsp;— 1,5 млрд&nbsp;тг. На&nbsp;прочие страны совокупно пришлось 14,9 млрд&nbsp;тг.<br><br>В&nbsp;текущем году переводы из&nbsp;Казахстана в&nbsp;Россию заметно выросли. За&nbsp;январь-июнь их&nbsp;объём увеличился на&nbsp;16,8%, а&nbsp;доля&nbsp;РФ в&nbsp;общем объёме отправленных за&nbsp;рубеж средств выросла с&nbsp;31,7% до&nbsp;39,3%. Показатель практически вернулся к&nbsp;уровню 2024 года, когда в&nbsp;Россию было отправлено 119,6 млрд&nbsp;тг.</p><p>&nbsp;</p><p>Обратный поток продолжил сокращаться. Объём переводов из&nbsp;России в&nbsp;Казахстан уменьшился за&nbsp;год на&nbsp;12,3%, а&nbsp;их&nbsp;доля в&nbsp;общем объёме полученных из-за&nbsp;границы средств сократилась с&nbsp;24% до&nbsp;23%. Это минимальный объём поступлений из&nbsp;РФ за&nbsp;январь-июнь с&nbsp;2016 года. После 2022-го, когда из&nbsp;России было получено больше денег, чем&nbsp;отправлено туда, ситуация вновь изменилась: с&nbsp;2023 года за&nbsp;январь-июнь через&nbsp;СДП из&nbsp;РК в&nbsp;РФ ежегодно отправляется значительно больше средств, чем&nbsp;поступает в&nbsp;обратном направлении.</p><p>&nbsp;</p><p>При&nbsp;этом&nbsp;уже после окончания рассматриваемого отчётного периода переводы из&nbsp;России в&nbsp;Казахстан столкнулись с&nbsp;дополнительными ограничениями. 24&nbsp;июля СДП «Золотая Корона» перестала проводить переводы из&nbsp;РФ в&nbsp;РК. Днём ранее <a href=\"https://news.mail.ru/card/1177/\">Евросоюз</a> принял 21-й пакет санкций против России, в&nbsp;который вошла РНКО «Платёжный центр», обслуживающая систему «Золотая Корона». Казахстан также перестал быть доступным направлением для&nbsp;онлайн-переводов из&nbsp;России через&nbsp;сервис. Поскольку эти ограничения появились только в&nbsp;июле, статистика за&nbsp;первое полугодие их&nbsp;ещё не&nbsp;отражала.<br><br>Ключевой системой международных переводов в&nbsp;первой половине текущего года оставалась именно «Золотая Корона». За&nbsp;январь-июнь 2026-го через&nbsp;неё из&nbsp;Казахстана за&nbsp;рубеж отправили 251,6 млрд тг&nbsp;— на&nbsp;4,4% меньше, чем&nbsp;годом ранее. При&nbsp;этом доля системы в&nbsp;общем объёме исходящих переводов выросла с&nbsp;81,9% до&nbsp;83%. То&nbsp;есть объём операций через&nbsp;«Золотую Корону» сократился, но&nbsp;медленнее, чем&nbsp;рынок СДП в&nbsp;целом.</p><p>&nbsp;</p><p>Среди поступающих из-за&nbsp;рубежа переводов роль «Золотой Короны» была несколько менее заметной. За&nbsp;первое полугодие 2026-го через&nbsp;эту СДП было получено 44 млрд тг&nbsp;— на&nbsp;12,5% меньше, чем&nbsp;годом ранее. Её&nbsp;доля сократилась с&nbsp;47,7% до&nbsp;45,7%. Таким образом, через&nbsp;«Золотую Корону» проходила подавляющая часть средств, отправляемых через&nbsp;СДП, и&nbsp;почти половина поступающих переводов.</p><p>&nbsp;</p><p>При&nbsp;этом уменьшение объёма операций через&nbsp;«Золотую Корону» не&nbsp;обязательно приведёт к&nbsp;сопоставимому сокращению всех переводов между странами: часть денежных потоков может перейти в&nbsp;другие СДП или в&nbsp;банковские каналы. В&nbsp;результате во&nbsp;второй половине года изменения могут проявиться прежде всего в&nbsp;перераспределении переводов между способами отправки денег, а&nbsp;не&nbsp;только в&nbsp;уменьшении их&nbsp;общего объёма.</p>', 2, 26, 'thumbnails/1786467188_6316.webp', 'Картинка.webp.webp', '2026-08-11 10:27:33', '2026-08-12 05:13:53');

-- --------------------------------------------------------

--
-- Структура таблицы `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `post_tag`
--

INSERT INTO `post_tag` (`id`, `tag_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 2, 5, NULL, NULL),
(2, 3, 5, NULL, NULL);

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
(9, 1, 1, NULL, NULL),
(10, 5, 2, NULL, NULL);

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
('8lyw6AiV1uEJwHHcra15XpsTR5aEwvCfbqexh11Z', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVFmYzlJU0twdnV4cVVqWXdNcTN4Rk1mQ2wzVmRWTDVxajFRakgxYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTQ6InVzZXIuZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1787219566);

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

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(2, 'Медицина', 'medicina', '2026-08-10 12:51:22', '2026-08-10 12:51:22'),
(3, 'Наука', 'nauka', '2026-08-11 10:30:31', '2026-08-11 10:30:31');

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

--
-- Дамп данных таблицы `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `legal_form`, `bin_iin`, `specialization`, `license_number`, `registration_region`, `location_region`, `city`, `actual_address`, `director_name`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(2, 'Исмагулов Альжан Тулеуович', 'Адвокат', '111111111111', 'Юридический консалтинг', '11111111111', 'Астана', 'Астана', 'Астана', 'Шанырак', 'Исмагулов Альжан Тулеуович', 'tenant1@legalcore.kz', '+77052050774', '$2y$12$/Kcbr478/1CCiDYDUfZKNe/sQEf.kjiEhWL.pgVQWwEYbKmv2wxSG', '2026-08-13 13:33:51', '2026-08-13 13:33:51');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Альжан Исмагулов', 'admin@legalcore.kz', NULL, '$2y$12$Lz/LcT5kXDfZvLX7xqUne.C.231jAvekc6Og5Aos2Wv5Uwq954uYq', NULL, '2026-08-20 04:23:51', '2026-08-20 04:23:51'),
(2, 'Пользователь', 'test@example.com', NULL, '$2y$12$2twq64RW/h6o3rZf5sl5ze4IjADf/fza0riU1r9NaiA4doxjker7G', NULL, '2026-08-20 04:23:52', '2026-08-20 04:23:52');

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
  ADD UNIQUE KEY `clients_iin_bin_unique` (`iin_bin`),
  ADD KEY `clients_tenant_id_foreign` (`tenant_id`),
  ADD KEY `clients_region_id_foreign` (`region_id`);

--
-- Индексы таблицы `codexes`
--
ALTER TABLE `codexes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codexes_slug_unique` (`slug`);

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
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Индексы таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`),
  ADD KEY `post_tag_post_id_foreign` (`post_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `clients_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `employees_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `employees_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
