-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2012 at 03:15 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `magaziller`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accessory`
--

CREATE TABLE IF NOT EXISTS `tbl_accessory` (
  `product_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`accessory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_accessory`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_article`
--

CREATE TABLE IF NOT EXISTS `tbl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_article`
--

INSERT INTO `tbl_article` (`id`, `title`, `content`, `tags`, `status`, `create_time`, `update_time`) VALUES
(1, 'О нас', 'р', '', 1, 1331837949, NULL),
(2, 'Оплата и Доставка', 'а', '', 1, 1331985151, NULL),
(3, 'Для партнеров', '<a href="../menuItem/19">Для партнеров</a>', '', 1, 1331988024, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE IF NOT EXISTS `tbl_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_brand`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `parent_id`, `level`, `description`, `image`, `position`, `status`, `create_time`, `update_time`) VALUES
(1, 'Для жінок', NULL, 0, '', NULL, 0, 1, 1331831021, NULL),
(2, 'Для чоловіків', NULL, 0, '', NULL, 1, 1, 1331831031, NULL),
(3, 'Для дітей', NULL, 0, '', NULL, 2, 1, 1331831039, NULL),
(4, 'Взуття', NULL, 0, '', NULL, 3, 1, 1331831047, NULL),
(5, 'Аксесуари', NULL, 0, '', NULL, 4, 1, 1331831055, NULL),
(6, 'Домашній затишок', NULL, 0, '', NULL, 5, 1, 1331831064, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_competitor`
--

CREATE TABLE IF NOT EXISTS `tbl_competitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `url` varchar(255) NOT NULL,
  `jquery_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_competitor`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_competitor_product`
--

CREATE TABLE IF NOT EXISTS `tbl_competitor_product` (
  `competitor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `price` float DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`competitor_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_competitor_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE IF NOT EXISTS `tbl_config` (
  `id` smallint(1) NOT NULL,
  `shop_name` varchar(64) NOT NULL,
  `company` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `main_text` text,
  `contact_text` longtext,
  `contact_map` longtext,
  `contact_use_captcha` smallint(1) NOT NULL,
  `counters` text,
  `price_accuracy` smallint(1) NOT NULL,
  `currency_default` int(2) NOT NULL,
  `currency_basic` int(2) NOT NULL,
  `product_show_absent` smallint(1) NOT NULL,
  `product_catalog_limit` int(3) NOT NULL,
  `product_catalog_order` varchar(16) NOT NULL,
  `product_search_limit` smallint(1) NOT NULL,
  `product_search_order` varchar(16) NOT NULL,
  `product_image_small_width` int(4) NOT NULL,
  `product_image_small_height` int(4) NOT NULL,
  `product_image_large_width` int(4) NOT NULL,
  `product_image_large_height` int(4) NOT NULL,
  `brand_image_small_width` int(4) NOT NULL,
  `brand_image_small_height` int(4) NOT NULL,
  `brand_image_large_width` int(4) NOT NULL,
  `brand_image_large_height` int(4) NOT NULL,
  `category_image_small_width` int(4) NOT NULL,
  `category_image_small_height` int(4) NOT NULL,
  `category_image_large_width` int(4) NOT NULL,
  `category_image_large_height` int(4) NOT NULL,
  `feature_pack_image_width` int(4) NOT NULL,
  `feature_pack_image_height` int(4) NOT NULL,
  `news_image_small_width` int(4) NOT NULL,
  `news_image_small_height` int(4) NOT NULL,
  `news_image_large_width` int(4) NOT NULL,
  `news_image_large_height` int(4) NOT NULL,
  `promotion_image_small_width` int(4) NOT NULL,
  `promotion_image_small_height` int(4) NOT NULL,
  `promotion_image_large_width` int(4) NOT NULL,
  `promotion_image_large_height` int(4) NOT NULL,
  `similar_price_accuracy` float(2,2) NOT NULL,
  `news_catalog_limit` smallint(1) NOT NULL,
  `mailing_new_order_to_admin` smallint(1) NOT NULL,
  `mailing_new_order_to_user` smallint(1) NOT NULL,
  `mailing_new_order_subject` varchar(255) DEFAULT NULL,
  `mailing_new_order_pattern` text,
  `smsing_new_order_to_admin` smallint(1) NOT NULL,
  `smsing_new_order_phones` text NOT NULL,
  `payment_required` smallint(1) NOT NULL,
  `delivery_required` smallint(1) NOT NULL,
  `vkontakte_api_id` int(11) DEFAULT NULL,
  `vkontakte_poll_id` varchar(32) DEFAULT NULL,
  `enterprise_1c_login` varchar(32) DEFAULT NULL,
  `enterprise_1c_password` varchar(255) DEFAULT NULL,
  `enterprise_1c_export_orders_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_config`
--

INSERT INTO `tbl_config` (`id`, `shop_name`, `company`, `admin_email`, `contact_email`, `contact_phone`, `contact_address`, `main_text`, `contact_text`, `contact_map`, `contact_use_captcha`, `counters`, `price_accuracy`, `currency_default`, `currency_basic`, `product_show_absent`, `product_catalog_limit`, `product_catalog_order`, `product_search_limit`, `product_search_order`, `product_image_small_width`, `product_image_small_height`, `product_image_large_width`, `product_image_large_height`, `brand_image_small_width`, `brand_image_small_height`, `brand_image_large_width`, `brand_image_large_height`, `category_image_small_width`, `category_image_small_height`, `category_image_large_width`, `category_image_large_height`, `feature_pack_image_width`, `feature_pack_image_height`, `news_image_small_width`, `news_image_small_height`, `news_image_large_width`, `news_image_large_height`, `promotion_image_small_width`, `promotion_image_small_height`, `promotion_image_large_width`, `promotion_image_large_height`, `similar_price_accuracy`, `news_catalog_limit`, `mailing_new_order_to_admin`, `mailing_new_order_to_user`, `mailing_new_order_subject`, `mailing_new_order_pattern`, `smsing_new_order_to_admin`, `smsing_new_order_phones`, `payment_required`, `delivery_required`, `vkontakte_api_id`, `vkontakte_poll_id`, `enterprise_1c_login`, `enterprise_1c_password`, `enterprise_1c_export_orders_time`) VALUES
(1, 'Magaziller', 'Magaziller', 'pasechnikbs@gmail.com', 'pasechnikbs@gmail.com', '<span>(044) </span>205 16 22 <span>(044) </span>205 16 22', '</strong>Красноармейская 42б, тел. <strong>(044) </strong>239-88-22', '', 'Пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.', '', 1, '', 2, 1, 1, 1, 10, 'price DESC', 10, 'price', 160, 130, 250, 250, 200, 200, 600, 600, 200, 200, 600, 600, 60, 60, 200, 200, 400, 400, 200, 200, 400, 600, 0.03, 10, 0, 0, 'вввввввв', '<p>Здравствуйте, {{order.name}}!</p>\r\n<h3>Ваша заявка принята. Для подтверждения заказа наш менеджер свяжется с вами в ближайшее время.</h3>\r\n<p>Заявке присвоен номер: #{{order.id}}</p>\r\n<p>Статус заявки вы можете отследить <a href="{{order.url}}">по этой ссылке</a></p>\r\n<p>Будем рады ответить на ваши вопросы по телефонам:</p>\r\n<p>{{app.config.contact_phone}}</p>\r\n{% for product in order.products %}\r\n<b>{{product.name}}</b> - {{app.priceFormatter.format(product.orderPrice, true)}} * {{product.quantity}} = {{app.priceFormatter.format(product.sumPrice, true)}}<br>\r\n{% endfor %}\r\n{% if order.delivery_price %}\r\n<b>Доставка:</b> {{app.priceFormatter.format(order.delivery_price, true)}}\r\n{% endif %}\r\n<b>Сумма:</b> {{app.priceFormatter.format(order.cost, true)}}\r\n', 0, '(067)333-33-33, (068)101-67-09', 1, 1, NULL, '11523323_5d36689bb421102619', 'user', 'password', 1331808585);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `prefix` varchar(20) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `ratio_from` float(6,3) NOT NULL DEFAULT '1.000',
  `ratio_to` float(6,3) NOT NULL DEFAULT '1.000',
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`id`, `name`, `prefix`, `suffix`, `code`, `ratio_from`, `ratio_to`, `position`) VALUES
(1, 'Доллары', '$', '', 'USD', 1.000, 1.000, 5),
(4, 'Гривны', '', ' грн', 'UAH', 8.000, 1.000, 1),
(11, 'Рубли', '', ' руб', 'RUB', 35.000, 1.000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery`
--

CREATE TABLE IF NOT EXISTS `tbl_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `free_from` float DEFAULT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_delivery`
--

INSERT INTO `tbl_delivery` (`id`, `name`, `description`, `free_from`, `price`, `status`) VALUES
(1, 'Курьером', '<p>Курьерская доставка осуществляется на следующий день после оформления заказа, если товар есть в наличии. Курьерская доставка осуществляется в пределах Томска и Северска ежедневно с 10.00 до 21.00. Заказ на сумму свыше 300 рублей доставляется бесплатно.   Стоимость бесплатной доставки раcсчитывается от суммы заказа с учтенной скидкой. В случае если сумма заказа после применения скидки менее 300р, осуществляется платная доставка.   При сумме заказа менее 300 рублей стоимость доставки составляет от 50 рублей.</p>', 800, 15, 1),
(2, 'Самовывоз', '<p>Удобный, бесплатный и быстрый способ получения заказа.  Адрес офиса: Адрес офиса: Москва, ул. Арбат, 1/3, офис 419.</p>', NULL, 40, 1),
(3, 'Укр. почтой', '', NULL, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_delivery_payment` (
  `delivery_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`delivery_id`,`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_delivery_payment`
--

INSERT INTO `tbl_delivery_payment` (`delivery_id`, `payment_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 4),
(3, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount`
--

CREATE TABLE IF NOT EXISTS `tbl_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `handler` varchar(32) NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_discount`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature`
--

CREATE TABLE IF NOT EXISTS `tbl_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_1c` varchar(255) DEFAULT NULL,
  `alowed_values` text,
  `unit` varchar(45) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `hide_name` smallint(1) NOT NULL,
  `type` smallint(1) NOT NULL,
  `unique` smallint(1) NOT NULL,
  `required` smallint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_feature`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature_category`
--

CREATE TABLE IF NOT EXISTS `tbl_feature_category` (
  `feature_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `in_detail` smallint(1) NOT NULL DEFAULT '1',
  `in_summary` smallint(1) NOT NULL DEFAULT '1',
  `in_compare` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`feature_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_feature_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature_pack`
--

CREATE TABLE IF NOT EXISTS `tbl_feature_pack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_feature_pack`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature_value`
--

CREATE TABLE IF NOT EXISTS `tbl_feature_value` (
  `product_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`,`feature_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_feature_value`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_filter`
--

CREATE TABLE IF NOT EXISTS `tbl_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `attribute` varchar(32) NOT NULL,
  `type` int(11) NOT NULL,
  `alowed_values` text,
  `category_id` int(11) NOT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_filter`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE IF NOT EXISTS `tbl_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `small_width` int(11) DEFAULT NULL,
  `small_height` int(11) DEFAULT NULL,
  `large_width` int(11) DEFAULT NULL,
  `large_height` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_gallery`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery_image`
--

CREATE TABLE IF NOT EXISTS `tbl_gallery_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `description` text,
  `gallery_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_gallery_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE IF NOT EXISTS `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_lookup`
--

CREATE TABLE IF NOT EXISTS `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `code` varchar(16) CHARACTER SET utf8 NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=106 ;

--
-- Dumping data for table `tbl_lookup`
--

INSERT INTO `tbl_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, 'Опубликована', '1', 'ArticleStatus', 1),
(2, 'Черновик', '2', 'ArticleStatus', 2),
(8, 'Опубликована', '1', 'NewsStatus', 1),
(9, 'Черновик', '2', 'NewsStatus', 2),
(10, 'Архив', '3', 'NewsStatus', 3),
(11, 'Включена', '1', 'CategoryStatus', 1),
(12, 'Отключена', '2', 'CategoryStatus', 2),
(13, 'Включен', '1', 'ProductStatus', 1),
(14, 'Отключен', '2', 'ProductStatus', 2),
(15, 'Активный', '1', 'DeliveryStatus', 1),
(16, 'Отключен', '2', 'DeliveryStatus', 2),
(17, 'Активна', '1', 'PaymentStatus', 1),
(18, 'Отключена', '2', 'PaymentStatus', 2),
(19, 'Нет на складе', '3', 'ProductStatus', 3),
(20, 'Новый', '1', 'OrderStatus', 1),
(21, 'В обработке', '2', 'OrderStatus', 2),
(22, 'Выполнен', '3', 'OrderStatus', 3),
(23, 'Удален', '4', 'OrderStatus', 4),
(24, 'Нет в наличии', '5', 'OrderStatus', 5),
(25, 'Строка', '1', 'PropertyType', 1),
(26, 'Число', '2', 'PropertyType', 2),
(27, 'Целое число', '3', 'PropertyType', 3),
(28, 'Выбор значения', '4', 'PropertyType', 4),
(30, 'Да / Нет', '6', 'PropertyType', 6),
(31, 'Включен', '1', 'PropertyStatus', 1),
(32, 'Отключен', '2', 'PropertyStatus', 2),
(33, 'Активен', '1', 'PriceListStatus', 1),
(34, 'Отключен', '2', 'PriceListStatus', 2),
(35, 'Артикул', '1', 'PriceListColumn', 1),
(36, 'Наличие на складе', '2', 'PriceListColumn', 2),
(37, 'Количество', '3', 'PriceListColumn', 3),
(38, 'Наличие/Количество', '4', 'PriceListColumn', 4),
(39, 'Цена', '5', 'PriceListColumn', 5),
(40, 'Информационная', '6', 'PriceListColumn', 6),
(41, 'Активен', '1', 'UserStatus', 1),
(42, 'Забанен', '2', 'UserStatus', 2),
(47, 'Клиент', 'client', 'UserRole', 1),
(48, 'Менеджер', 'manager', 'UserRole', 2),
(49, 'Контент менеджер', 'content', 'UserRole', 3),
(50, 'Администратор', 'admin', 'UserRole', 4),
(51, 'Строка', '1', 'FeatureType', 1),
(52, 'Число', '2', 'FeatureType', 2),
(53, 'Целое число', '3', 'FeatureType', 3),
(54, 'Выбор значения', '4', 'FeatureType', 4),
(55, 'Да / Нет', '5', 'FeatureType', 5),
(56, 'Включена', '1', 'FeatureStatus', 1),
(57, 'Отключена', '2', 'FeatureStatus', 2),
(58, 'Главная страница', 'site/index', 'SEORoute', 1),
(59, 'Страница ошибки', 'site/error', 'SEORoute', 2),
(60, 'Контакты', 'site/contact', 'SEORoute', 3),
(61, 'Авторизация', 'site/login', 'SEORoute', 4),
(62, 'Каталог статей', 'article/index', 'SEORoute', 5),
(65, 'Архив новостей', 'news/archive', 'SEORoute', 8),
(67, 'Оформление заказа', 'order/index', 'SEORoute', 10),
(68, 'Корзина пуста', 'order/clear', 'SEORoute', 11),
(69, 'Заказ оформлен', 'order/view', 'SEORoute', 12),
(71, 'Результаты поиска', 'search/result', 'SEORoute', 14),
(72, 'Регистрация', 'user/register', 'SEORoute', 15),
(73, 'Активна', '1', 'GalleryStatus', 1),
(74, 'Скрыта', '2', 'GalleryStatus', 2),
(75, 'Активен', '1', 'MarketStatus', 1),
(76, 'Отключен', '2', 'MarketStatus', 2),
(80, 'В ручную', '1', 'MarketDescriptionType', 1),
(81, 'Краткое описание товара', '2', 'MarketDescriptionType', 2),
(82, 'Полное описание товара', '3', 'MarketDescriptionType', 3),
(83, 'Не выводить', '4', 'MarketDescriptionType', 4),
(84, 'Текстовое поле', '1', 'FilterType', 1),
(85, 'Выпадающий список', '2', 'FilterType', 2),
(86, 'Слайдер', '3', 'FilterType', 3),
(87, 'Диапазон от и до', '4', 'FilterType', 4),
(88, 'Ссылки', '5', 'FilterType', 5),
(89, 'Флажки', '6', 'FilterType', 6),
(90, 'Слайдер и диапазон', '7', 'FilterType', 7),
(91, 'Цена', '8', 'FeatureType', 8),
(92, 'Активна', '1', 'PromotionStatus', 1),
(93, 'Отключена', '2', 'PromotionStatus', 2),
(94, 'Не оплачен', '1', 'OrderPaymentStatus', 1),
(95, 'Оплачен', '2', 'OrderPaymentStatus', 2),
(96, 'Отклонен', '3', 'OrderPaymentStatus', 3),
(97, 'Проверяется', '4', 'OrderPaymentStatus', 4),
(98, 'Подробнее товара', 'product/view', 'SEORoute', 16),
(99, 'Подробнее статьи', 'article/view', 'SEORoute', 17),
(100, 'Подробнее новости', 'news/view', 'SEORoute', 18),
(101, 'Подробнее галереи', 'gallery/view', 'SEORoute', 19),
(102, 'Подробнее акции', 'promotion/view', 'SEORoute', 20),
(103, 'Подробнее категории', 'category/view', 'SEORoute', 21),
(105, 'Подробнее бренда', 'brand/view', 'SEORoute', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_market`
--

CREATE TABLE IF NOT EXISTS `tbl_market` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description_type` int(11) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_market`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_market_category`
--

CREATE TABLE IF NOT EXISTS `tbl_market_category` (
  `market_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`market_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_market_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_item`
--

CREATE TABLE IF NOT EXISTS `tbl_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_menu_item`
--

INSERT INTO `tbl_menu_item` (`id`, `name`, `uri`, `parent_id`, `level`, `position`) VALUES
(1, 'Верхнее меню', '/magaziller/index.php/article/1', NULL, 1, NULL),
(2, 'Меню футера', '', NULL, NULL, NULL),
(3, 'Боковое меню', '', NULL, NULL, NULL),
(4, 'Дополнительное меню', '', NULL, NULL, NULL),
(5, 'Каталог', 'http://localhost/srusi', 4, 1, 8),
(11, 'Оплата и Доставка', 'article/2', 1, 2, 3),
(12, 'О нас', 'article/1', 1, 2, 2),
(13, 'test', 'hhhh', 5, 2, 1),
(14, 'О нас', 'article/1', 2, 1, 1),
(15, 'Контакты', 'site/contact', 1, 1, 5),
(17, 'Оплата и Доставка', 'article/2', 2, 1, 2),
(18, 'Контакты', 'd', 2, 1, 3),
(19, 'Для партнеров', 'article/3', 2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `annotation` text NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(1024) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_news`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `delivery_price` float NOT NULL,
  `payment_id` int(11) NOT NULL,
  `payment_status` smallint(1) NOT NULL,
  `payment_time` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `comment` text,
  `referer` varchar(1024) DEFAULT NULL,
  `search_terms` varchar(255) DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_product`
--

CREATE TABLE IF NOT EXISTS `tbl_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `additional_params` text NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_order_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `currency_id` int(11) DEFAULT NULL,
  `handler` varchar(32) NOT NULL,
  `_handlerParams` text,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `name`, `description`, `currency_id`, `handler`, `_handlerParams`, `status`) VALUES
(1, 'Наличными курьеру', 'Возможна при получении курьером или в офисе.', 4, 'Receipt', 'a:8:{s:9:"recipient";s:20:"Получатель";s:3:"inn";s:27:"ИНН получателя";s:7:"account";s:29:"Счет получателя";s:4:"bank";s:29:"Банк получателя";s:3:"bik";s:6:"БИК";s:21:"correspondent_account";s:16:"Кор. счет";s:8:"banknote";s:6:"грн";s:5:"pense";s:6:"коп";}', 1),
(2, 'WebMoney', 'Универсальное средство для расчетов в Сети, среда и технология для ведения бизнеса и электронной коммерции. Система обеспечивает равноправие контрагентов, высокую скорость выполнения транзакций. Работает в Украине с 2003 года, используется более чем 2 млн наших соотечественников.', 1, '', NULL, 1),
(4, 'LiqPay', 'Сервис моментальных платежей LiqPay дает возможность совершать <a href="https://www.liqpay.com/?do=pages&amp;p=instant_payment">моментальные выплаты</a> с использованием банковских карт Visa и MasterCard. Для создания моментальных платежей в одной из самых распространенных платежных сервисов вам понадобится только мобильный телефон и банковская карта.', 1, 'LiqPay', 'a:2:{s:11:"merchant_id";s:3:"777";s:9:"signature";s:3:"999";}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_price_list`
--

CREATE TABLE IF NOT EXISTS `tbl_price_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `description` text,
  `availability_true` varchar(45) DEFAULT NULL,
  `availability_false` varchar(45) DEFAULT NULL,
  `upload_time` int(11) DEFAULT NULL,
  `columns` text,
  `checksum` varchar(36) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_price_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_price_list_row`
--

CREATE TABLE IF NOT EXISTS `tbl_price_list_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `information` varchar(255) DEFAULT NULL,
  `availability` smallint(1) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price_list_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `upload_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_price_list_row`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `other_price` float DEFAULT NULL,
  `price` float NOT NULL,
  `unit` varchar(16) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `summary` text,
  `description` longtext,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `hit` int(11) NOT NULL,
  `shopwindow` int(11) NOT NULL,
  `original_id` int(11) DEFAULT NULL,
  `variation` varchar(255) DEFAULT NULL,
  `enterprise_1c_id` varchar(255) DEFAULT NULL,
  `browse` int(11) DEFAULT NULL,
  `priority` int(2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_image`
--

CREATE TABLE IF NOT EXISTS `tbl_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `description` text,
  `product_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_product_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_promotion`
--

CREATE TABLE IF NOT EXISTS `tbl_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `annotation` text NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_promotion`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_promotion_product`
--

CREATE TABLE IF NOT EXISTS `tbl_promotion_product` (
  `promotion_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`promotion_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_promotion_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrap`
--

CREATE TABLE IF NOT EXISTS `tbl_scrap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `route` varchar(32) NOT NULL,
  `limit_items` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_scrap`
--

INSERT INTO `tbl_scrap` (`id`, `name`, `route`, `limit_items`) VALUES
(1, 'Слайдер на главной', 'site/index', 4),
(2, '4 блока на главной', 'site/index', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrap_item`
--

CREATE TABLE IF NOT EXISTS `tbl_scrap_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scrap_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_scrap_item`
--

INSERT INTO `tbl_scrap_item` (`id`, `scrap_id`, `template_id`, `image`, `product_id`, `news_id`, `promotion_id`, `category_id`, `brand_id`, `title`, `url`, `content`) VALUES
(1, 1, 1, '16Mar2012_14-23-14slider_png.png', NULL, NULL, NULL, NULL, NULL, 'РУБАШКИ, ШОРТЫ, ТУФЛИ', 'd', '<h2>Все модели нового сезона уже в продаже</h2>'),
(2, 1, 1, '16Mar2012_14-23-15slider_png.png', NULL, NULL, NULL, NULL, NULL, 'РУБАШКИ, ШОРТЫ, ТУФЛИ', 'dd', '<h2>Все модели нового сезона уже в продаже</h2>'),
(3, 1, 1, '16Mar2012_14-23-16slider_png.png', NULL, NULL, NULL, NULL, NULL, 'РУБАШКИ, ШОРТЫ, ТУФЛИ', 'dd', '<h2>Все модели нового сезона уже в продаже</h2>'),
(4, 1, 1, '16Mar2012_14-23-17slider_png.png', NULL, NULL, NULL, NULL, NULL, 'РУБАШКИ, ШОРТЫ, ТУФЛИ', 'dd', '<h2>Все модели нового сезона уже в продаже</h2>'),
(5, 2, 2, '16Mar2012_15-52-36index_nav_item1_png.png', NULL, NULL, NULL, NULL, NULL, 'Женская одежда', 'о', 'КАТАЛОГ ОДЕЖДЫ 2012'),
(6, 2, 2, '16Mar2012_15-53-28index_nav_item2_png.png', NULL, NULL, NULL, NULL, NULL, 'Декорирование', 'о', ''),
(7, 2, 2, '16Mar2012_15-53-28index_nav_item3_png.png', NULL, NULL, NULL, NULL, NULL, 'Детская одежда', 'о', ''),
(8, 2, 3, '16Mar2012_15-53-28index_nav_item4_png.png', NULL, NULL, NULL, NULL, NULL, 'СПЕЦПРЕДЛОЖЕНИЯ ', 'лл', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrap_template`
--

CREATE TABLE IF NOT EXISTS `tbl_scrap_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scrap_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `use_image` smallint(1) NOT NULL,
  `image_width` int(4) DEFAULT NULL,
  `image_height` int(4) DEFAULT NULL,
  `use_news` smallint(1) NOT NULL,
  `use_product` smallint(1) NOT NULL,
  `use_promotion` smallint(1) NOT NULL,
  `use_category` smallint(1) NOT NULL,
  `use_brand` smallint(1) NOT NULL,
  `use_title` smallint(1) NOT NULL,
  `use_content` smallint(1) NOT NULL,
  `use_url` smallint(1) NOT NULL,
  `template` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_scrap_template`
--

INSERT INTO `tbl_scrap_template` (`id`, `scrap_id`, `name`, `use_image`, `image_width`, `image_height`, `use_news`, `use_product`, `use_promotion`, `use_category`, `use_brand`, `use_title`, `use_content`, `use_url`, `template`) VALUES
(1, 1, 'Основной', 1, 770, 355, 0, 0, 0, 0, 0, 1, 1, 1, '<a href="{{url}}">\r\n<div class="slider_pic">\r\n    <img src="{{image_url}}" />\r\n</div>\r\n<div class="slider_label">\r\n    {{title}}\r\n</div>\r\n<div class="slider_text">\r\n    {{content}}\r\n</div>\r\n</a>'),
(2, 2, 'Основной', 1, 235, 145, 0, 0, 0, 0, 0, 1, 1, 1, '<a href="{{ url }}"><div class="index_nav_item">\r\n    <div class="index_nav_item_pic">\r\n                <img src="{{ image_url }}" />\r\n    </div>\r\n    <div class="index_nav_item_label">\r\n         {{ title }}\r\n    </div>\r\n    <div class="index_nav_item_text">\r\n         {{ content }}\r\n    </div>\r\n</div></a>'),
(3, 2, 'Альтернативный', 1, 235, 145, 0, 0, 0, 0, 0, 1, 1, 1, '<a href="{{ url }}"><div class="index_nav_item">\r\n    <div class="index_nav_item_pic">\r\n                <img src="{{ image_url }}" />\r\n    </div>\r\n    <div class="index_nav_item_label special">\r\n         {{ title }}\r\n    </div>\r\n    <div class="index_nav_item_text">\r\n         {{ content }}\r\n    </div>\r\n</div></a>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_search`
--

CREATE TABLE IF NOT EXISTS `tbl_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_search`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_seo`
--

CREATE TABLE IF NOT EXISTS `tbl_seo` (
  `route` varchar(16) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '0',
  `metaTitle` varchar(500) DEFAULT NULL,
  `metaKeywords` varchar(500) DEFAULT NULL,
  `metaDescription` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`route`,`entity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_seo`
--

INSERT INTO `tbl_seo` (`route`, `entity`, `metaTitle`, `metaKeywords`, `metaDescription`) VALUES
('site/error', 0, '{shop_name} - Страницы не существует', '', ''),
('site/index', 0, '{shop_name} - Главная страница', '', ''),
('site/contact', 0, '{shop_name} - Наши контакты', '', ''),
('site/login', 0, '{shop_name} - Авторизация', '', ''),
('article/index', 0, '{shop_name} - Статьи', '', ''),
('news/archive', 0, '{shop_name} - Архив новостей', '', ''),
('order/index', 0, '{shop_name} - Оформление заказа', '', ''),
('order/clear', 0, '{shop_name} - Корзина пуста', '', ''),
('order/view', 0, '{shop_name} - Состояние заказа', '', ''),
('search/result', 0, '{shop_name} - Результаты поиска "{query}"', '', ''),
('user/register', 0, '{shop_name} - Регистрация', '', ''),
('product/view', 0, '{shop_name} - {category} {brand} {name}', '', ''),
('article/view', 0, '{shop_name} - {title}', '', ''),
('news/view', 0, '{shop_name} - {title}', '', ''),
('gallery/view', 0, '{shop_name} - {name}', '', ''),
('promotion/view', 0, '{shop_name} - {title}', '', ''),
('category/view', 0, '{shop_name} - {name}', '', ''),
('brand/view', 0, '{shop_name} - {name}', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `frequency` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('client','manager','content','admin') COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `salt` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `authoriz_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `role`, `group_id`, `salt`, `email`, `phone`, `address`, `comment`, `status`, `create_time`, `authoriz_time`) VALUES
(1, 'admin', '2e5c7db760a33498023813489cfadc0b', 'admin', 2, '28b206548469ce62182048fd9cf91760', 'webmaster@example.com', '(068) 101 67 09', 'ул. 3-й микрорайон д. 13 кв. 81', 'комент', 1, NULL, NULL),
(2, 'taral', '50d1fba591ad2a3430b091d6731996e0', 'admin', NULL, '', 'pasechnikbs@gmail.com', '', '', '', 1, NULL, NULL),
(3, 'user1', '96e79218965eb72c92a549dd5a330112', 'client', NULL, '', 'user@ukr.net', '99240549', '', '', 1, NULL, NULL);
