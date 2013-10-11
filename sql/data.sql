-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 07 2013 г., 01:55
-- Версия сервера: 5.5.29
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;

--
-- База данных: `logika_partener_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) unsigned NOT NULL DEFAULT '0',
  `barcode` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) unsigned NOT NULL,
  `id_category` int(11) unsigned NOT NULL,
  `id_category_parent` int(11) unsigned NOT NULL,
  `translit` varchar(255) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `id_cat_alternative` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_shop` (`id_shop`),
  KEY `id_category` (`id_category`),
  KEY `id_category_parent` (`id_category_parent`),
  KEY `id_cat_alternative` (`id_cat_alternative`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories_alternative`
--

CREATE TABLE IF NOT EXISTS `categories_alternative` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `translit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_currency` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `plus` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_currency` (`id_currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `currescies_translations`
--

CREATE TABLE IF NOT EXISTS `currescies_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_currency` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rus_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_currency` (`id_currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `datatour`
--

CREATE TABLE IF NOT EXISTS `datatour` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) unsigned NOT NULL,
  `dataTour` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ips_blocked`
--

CREATE TABLE IF NOT EXISTS `ips_blocked` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) CHARACTER SET utf8 NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `param`
--

CREATE TABLE IF NOT EXISTS `param` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) unsigned NOT NULL,
  `param_name` varchar(255) NOT NULL,
  `param_unit` varchar(255) NOT NULL,
  `param_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) unsigned NOT NULL,
  `id_category` int(11) unsigned NOT NULL,
  `id_currency` varchar(255) NOT NULL,
  `id_product` int(11) unsigned NOT NULL,
  `translit` varchar(255) NOT NULL,
  `url` varchar(512) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `store` enum('false','true') NOT NULL,
  `pickup` enum('false','true') NOT NULL,
  `delivery` enum('false','true') NOT NULL,
  `local_delivery_cost` decimal(65,2) unsigned NOT NULL,
  `typePrefix` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `vendorCode` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `sales_notes` varchar(255) NOT NULL,
  `manufacturer_warranty` enum('true','false') NOT NULL,
  `age` enum('0','6','12','16','18') NOT NULL,
  `adult` enum('true','false') NOT NULL,
  `country_of_origin` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `available` enum('true','false') NOT NULL,
  `downloadable` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `series` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `ISBN` varchar(255) NOT NULL,
  `volume` int(11) NOT NULL,
  `part` int(11) NOT NULL,
  `language` varchar(64) NOT NULL,
  `binding` varchar(255) NOT NULL,
  `page_extent` int(11) NOT NULL,
  `table_of_contents` varchar(255) NOT NULL,
  `performed_by` varchar(255) NOT NULL,
  `performance_type` varchar(255) NOT NULL,
  `storage` varchar(255) NOT NULL,
  `format` varchar(255) NOT NULL,
  `recording_length` varchar(32) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `media` varchar(255) NOT NULL,
  `starring` varchar(255) NOT NULL,
  `director` varchar(255) NOT NULL,
  `originalName` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `worldRegion` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `days` int(11) NOT NULL,
  `hotel_stars` varchar(64) NOT NULL,
  `room` varchar(32) NOT NULL,
  `meal` varchar(32) NOT NULL,
  `included` varchar(255) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `hall` varchar(255) NOT NULL,
  `hall_url` varchar(255) NOT NULL,
  `hall_part` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `is_premiere` tinyint(1) NOT NULL,
  `is_kids` tinyint(1) NOT NULL,
  `bid` int(11) NOT NULL,
  `cbid` int(11) NOT NULL,
  `on_main` tinyint(1) unsigned NOT NULL,
  `new_sign` tinyint(1) unsigned NOT NULL,
  `spesial_sign` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_shop` (`id_shop`),
  KEY `id_category` (`id_category`),
  KEY `id_product` (`id_product`),
  KEY `id_currency` (`id_currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='товары из разных интернет магазинов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_cyr_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_value` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `agency` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `local_delivery_cost` decimal(65,2) DEFAULT NULL,
  `offer_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `currescies_translations` (`id`, `id_currency`, `rus_name`) VALUES
(1, 'UAH', 'грн'),
(2, 'RUR', 'руб'),
(3, 'RUB', 'руб'),
(4, 'BYR', 'руб'),
(5, 'KZT', 'тенге'),
(6, 'USD', 'USD'),
(7, 'EUR', 'EUR');

CREATE TABLE IF NOT EXISTS `counts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `script` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `counts`
--

INSERT INTO `counts` (`id`, `name`, `script`) VALUES
(1, 'google_analitics', ''),
(2, 'yandex_metrika', '');


COMMIT;
SET AUTOCOMMIT=1;