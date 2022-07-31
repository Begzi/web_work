-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 31 2022 г., 21:02
-- Версия сервера: 5.7.20-log
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE `address` (
  `region_id` varchar(50) NOT NULL,
  `district` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `street` varchar(50) DEFAULT NULL,
  `num` varchar(25) DEFAULT NULL,
  `branch` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `child_customer` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`region_id`, `district`, `city`, `street`, `num`, `branch`, `customer_id`, `id`, `child_customer`) VALUES
('1', '', 'Красноярск', 'Пр. Свободный 76и', '', '1', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1659267947),
('admin', '2', 1659267947),
('admin', '3', 1659267947),
('admin', '6', 1659267947),
('admin', '9', 1659267947),
('manager', '5', 1659267947),
('TZI', '3', 1659267947),
('TZI', '4', 1659267947),
('TZI', '7', 1659267947);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1659267947, 1659267947),
('logList', 2, 'Право на просмотр Журнала обращения', NULL, NULL, 1659267947, 1659267947),
('manager', 1, 'Менеджер', NULL, NULL, 1659267947, 1659267947),
('TZI', 1, 'Техподдержка', NULL, NULL, 1659267947, 1659267947);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'logList'),
('TZI', 'logList'),
('admin', 'manager'),
('TZI', 'manager');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cert`
--

CREATE TABLE `cert` (
  `num` varchar(50) NOT NULL,
  `st_date` date NOT NULL,
  `ex_date` date NOT NULL,
  `sc_link` varchar(250) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cert_group_name_id` int(11) DEFAULT NULL,
  `parent_customer` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cert`
--

INSERT INTO `cert` (`num`, `st_date`, `ex_date`, `sc_link`, `customer_id`, `cert_group_name_id`, `parent_customer`, `id`) VALUES
('1', '2022-06-27', '2023-06-27', '1-000000000.png', 1, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `cert_group_name`
--

CREATE TABLE `cert_group_name` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `st_date` date DEFAULT NULL,
  `ex_date` date NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `sended` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cert_uz`
--

CREATE TABLE `cert_uz` (
  `id` int(11) NOT NULL,
  `cert_id` int(11) NOT NULL,
  `uz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cert_uz`
--

INSERT INTO `cert_uz` (`id`, `cert_id`, `uz_id`) VALUES
(0, 2, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

CREATE TABLE `contact` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `position` varchar(100) NOT NULL,
  `w_tel` varchar(40) NOT NULL,
  `m_tel` varchar(40) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `ityn` tinyint(1) NOT NULL,
  `description` varchar(200) NOT NULL,
  `department` int(11) NOT NULL,
  `child_customer` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`customer_id`, `name`, `position`, `w_tel`, `m_tel`, `mail`, `ityn`, `description`, `department`, `child_customer`, `id`) VALUES
(1, '', '', '51', '', '', 0, '', 2, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `contact_position`
--

CREATE TABLE `contact_position` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contact_position`
--

INSERT INTO `contact_position` (`id`, `name`) VALUES
(1, 'Остальные'),
(2, 'Бугхалтера'),
(3, 'Приёмная'),
(4, 'Администрация'),
(5, 'IT'),
(6, 'ИБ отдел');

-- --------------------------------------------------------

--
-- Структура таблицы `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `shortname` varchar(50) NOT NULL,
  `leg_address` varchar(50) NOT NULL,
  `uz_list_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `UHH` int(11) NOT NULL,
  `CPP` int(11) NOT NULL,
  `doc_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `customer`
--

INSERT INTO `customer` (`id`, `fullname`, `shortname`, `leg_address`, `uz_list_id`, `description`, `UHH`, `CPP`, `doc_type_id`) VALUES
(1, 'Первый', '1', 'Красноярск', 0, '', 1231231231, 123123123, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `doc_type`
--

CREATE TABLE `doc_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `doc_type`
--

INSERT INTO `doc_type` (`id`, `name`) VALUES
(1, 'Бумажный'),
(2, 'Электронный');

-- --------------------------------------------------------

--
-- Структура таблицы `kbase_list`
--

CREATE TABLE `kbase_list` (
  `name` varchar(500) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `solution` varchar(3000) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kbase_list`
--

INSERT INTO `kbase_list` (`name`, `description`, `solution`, `id`) VALUES
('Первое знание', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `log_event`
--

CREATE TABLE `log_event` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `reg_date` datetime NOT NULL,
  `text_description` varchar(500) NOT NULL,
  `res_person` int(11) NOT NULL,
  `next_date` date DEFAULT NULL,
  `next_date_description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `log_ticket_list`
--

CREATE TABLE `log_ticket_list` (
  `status` int(11) NOT NULL,
  `customer_id` int(6) NOT NULL,
  `reg_date` datetime NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `topic` varchar(250) NOT NULL,
  `res_person` int(11) NOT NULL,
  `kbase_link` varchar(200) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL DEFAULT '2',
  `description` varchar(1000) NOT NULL,
  `solution_time` int(11) NOT NULL DEFAULT '0',
  `uz_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_ticket_list`
--

INSERT INTO `log_ticket_list` (`status`, `customer_id`, `reg_date`, `contact_id`, `topic`, `res_person`, `kbase_link`, `priority`, `type`, `description`, `solution_time`, `uz_id`, `id`) VALUES
(2, 1, '2022-07-31 06:55:13', NULL, 'Первое обиращение', 3, '1', 2, 2, '', 15, NULL, 1),
(1, 1, '2022-07-31 07:03:19', 0, 'Второе', 3, NULL, 1, 2, '', 0, 5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `log_ticket_priority`
--

CREATE TABLE `log_ticket_priority` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_ticket_priority`
--

INSERT INTO `log_ticket_priority` (`id`, `name`) VALUES
(1, 'Низкий'),
(2, 'Средний'),
(3, 'Высокий');

-- --------------------------------------------------------

--
-- Структура таблицы `log_ticket_type`
--

CREATE TABLE `log_ticket_type` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_ticket_type`
--

INSERT INTO `log_ticket_type` (`id`, `name`) VALUES
(1, 'Консультация');

-- --------------------------------------------------------

--
-- Структура таблицы `lws_users`
--

CREATE TABLE `lws_users` (
  `name` varchar(40) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(16) NOT NULL,
  `hash` varchar(60) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lws_users`
--

INSERT INTO `lws_users` (`name`, `login`, `password`, `hash`, `id`) VALUES
('Администратор', 'Admin', 'crabhorsechicken', '$2y$13$fvZoZggZ8j7Jz1I2lrdi6OIAXk/QusqjzeIDW6KDmRL1/xHZpKZj2', 1),
('Эчи', 'TZI1', 'Z123456z', '$2y$13$cCR76naFfgYDolIX6HBykeu5KnXmRwl72ucKC7aQnA1HVudNOxNEe', 3),
('Жека', 'TZI2', 'B123456b', '$2y$13$qDBAcDghet1fqsYL4IS2eOpDCG9n/arL6F0m93L3zhNblArzqEkqm', 4),
('Ане', 'office', 'O123456o', '$2y$13$YStZ0C/VFtZp1F.1PcGrh.9yDSYh8qK/TyfeA7A9XrdeGsBaMiexO', 5),
('Кате', 'loginloginovich', 'bu1bu2bu3', '$2y$13$Wn57yfiF2131GE9y5c552uy8Xb4Diz/VYDjBSGczUzzU.zREsv/SG', 6),
('Ване', 'TZI3', 'asd', '$2y$13$Oi71QinsHfp3NlOzGx.5VuOzxhRA4Zf/bfLCf.Dtm4GbRx76zQUcO', 7),
('Не админ', 'admin', 'admin', '$2y$13$9PVKbokFS1XYxMzu3gyvw.lr6vYMReUTHptj3icAwElR3FKnCmgOC', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE `mail` (
  `id` int(11) NOT NULL,
  `cert_id` int(11) NOT NULL,
  `st_date_send` date NOT NULL,
  `sended` tinyint(1) NOT NULL,
  `st_date` date NOT NULL DEFAULT '2018-01-01',
  `state` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_base`
--

CREATE TABLE `mail_base` (
  `id` int(11) NOT NULL,
  `uz_id` int(11) NOT NULL,
  `st_date_send` int(11) DEFAULT '2021',
  `sended` tinyint(4) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1631003739),
('m140506_102106_rbac_init', 1631003741),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1631003741),
('m180523_151638_rbac_updates_indexes_without_prefix', 1631003741),
('m200409_110543_rbac_update_mssql_trigger', 1631003741);

-- --------------------------------------------------------

--
-- Структура таблицы `net_list`
--

CREATE TABLE `net_list` (
  `num` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `net_list`
--

INSERT INTO `net_list` (`num`, `name`, `id`) VALUES
(0, 'Все', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `region`
--

INSERT INTO `region` (`id`, `name`) VALUES
(0, 'Красноярск');

-- --------------------------------------------------------

--
-- Структура таблицы `scheme`
--

CREATE TABLE `scheme` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sc_link` varchar(250) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `child_customer` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='scheme';

-- --------------------------------------------------------

--
-- Структура таблицы `uz_list`
--

CREATE TABLE `uz_list` (
  `customer_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `net_id` int(11) NOT NULL,
  `support_a` int(11) DEFAULT NULL,
  `supply_time` date DEFAULT '2018-01-01',
  `description` varchar(250) DEFAULT NULL,
  `supply_ex_time` date NOT NULL,
  `address_id` int(11) DEFAULT '0',
  `child_customer` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uz_list`
--

INSERT INTO `uz_list` (`customer_id`, `type_id`, `net_id`, `support_a`, `supply_time`, `description`, `supply_ex_time`, `address_id`, `child_customer`, `id`) VALUES
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 1),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 2),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 3),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 4),
(1, 0, 0, 2, '2022-06-30', NULL, '2023-06-30', 0, NULL, 5),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 6),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 7),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 8),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 9),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 10),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 11),
(1, 0, 0, NULL, '2022-06-30', NULL, '2023-06-30', 0, NULL, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `uz_type`
--

CREATE TABLE `uz_type` (
  `name` varchar(200) NOT NULL,
  `type` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uz_type`
--

INSERT INTO `uz_type` (`name`, `type`, `id`) VALUES
('Хром', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `uz_type_categoria`
--

CREATE TABLE `uz_type_categoria` (
  `name` varchar(25) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uz_type_categoria`
--

INSERT INTO `uz_type_categoria` (`name`, `id`) VALUES
('ПО', 1),
('Аппаратное', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `cert`
--
ALTER TABLE `cert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cert_group_name_id` (`cert_group_name_id`);

--
-- Индексы таблицы `cert_group_name`
--
ALTER TABLE `cert_group_name`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cert_uz`
--
ALTER TABLE `cert_uz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact_position`
--
ALTER TABLE `contact_position`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `doc_type`
--
ALTER TABLE `doc_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kbase_list`
--
ALTER TABLE `kbase_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log_ticket_list`
--
ALTER TABLE `log_ticket_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log_ticket_priority`
--
ALTER TABLE `log_ticket_priority`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log_ticket_type`
--
ALTER TABLE `log_ticket_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lws_users`
--
ALTER TABLE `lws_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uz_list`
--
ALTER TABLE `uz_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uz_type_categoria`
--
ALTER TABLE `uz_type_categoria`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cert`
--
ALTER TABLE `cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `kbase_list`
--
ALTER TABLE `kbase_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `log_ticket_list`
--
ALTER TABLE `log_ticket_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `log_ticket_priority`
--
ALTER TABLE `log_ticket_priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `log_ticket_type`
--
ALTER TABLE `log_ticket_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `lws_users`
--
ALTER TABLE `lws_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `uz_list`
--
ALTER TABLE `uz_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `uz_type_categoria`
--
ALTER TABLE `uz_type_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
