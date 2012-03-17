<?php

// changes

$yii=dirname(__FILE__).'/yii/yii.php';

if(!file_exists($yii))
    $yii=dirname(__FILE__).'/../yii/yii.php';

require_once($yii);

$webroot=dirname(__FILE__).DIRECTORY_SEPARATOR;
Yii::setPathOfAlias('common', $webroot.'common');
Yii::setPathOfAlias('frontend', $webroot.'frontend');
Yii::setPathOfAlias('backend', $webroot.'backend');

$config=include(Yii::getPathOfAlias('common.config.main').'.php');
$config=CMap::mergeArray($config, include(Yii::getPathOfAlias('backend.config.main').'.php'));
$config=CMap::mergeArray($config, include(Yii::getPathOfAlias('common.config.main-local').'.php'));

Yii::createWebApplication($config);

$connection=Yii::app()->db;

$command=$connection->createCommand(<<<EOF

--
-- Table structure for table `accessory`
--

CREATE TABLE IF NOT EXISTS `{{accessory}}` (
  `product_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`accessory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `{{article}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `{{brand}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `{{category}}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitor`
--

CREATE TABLE IF NOT EXISTS `{{competitor}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `url` varchar(255) NOT NULL,
  `jquery_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitor_product`
--

CREATE TABLE IF NOT EXISTS `{{competitor_product}}` (
  `competitor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `price` float DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`competitor_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `{{config}}` (
  `id` smallint(1) NOT NULL,
  `shop_name` varchar(64) NOT NULL,
  `company` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `main_text` text,
  `contact_text` longtext,
  `contact_map` longtext,
  `contact_use_captcha` smallint(1) NOT NULL,
  `counters` text,
  `price_accuracy` smallint(1) NOT NULL,
  `currency_default` int(2) NOT NULL,
  `currency_basic` int(2) NOT NULL,
  `main_scrap` int(11) DEFAULT NULL,
  `second_scrap` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `{{config}}` (`id`, `shop_name`, `company`, `admin_email`, `contact_email`, `contact_phone`, `main_text`, `contact_text`, `contact_map`, `contact_use_captcha`, `counters`, `price_accuracy`, `currency_default`, `currency_basic`, `main_scrap`, `second_scrap`, `product_show_absent`, `product_catalog_limit`, `product_catalog_order`, `product_search_limit`, `product_search_order`, `product_image_small_width`, `product_image_small_height`, `product_image_large_width`, `product_image_large_height`, `brand_image_small_width`, `brand_image_small_height`, `brand_image_large_width`, `brand_image_large_height`, `category_image_small_width`, `category_image_small_height`, `category_image_large_width`, `category_image_large_height`, `feature_pack_image_width`, `feature_pack_image_height`, `news_image_small_width`, `news_image_small_height`, `news_image_large_width`, `news_image_large_height`, `promotion_image_small_width`, `promotion_image_small_height`, `promotion_image_large_width`, `promotion_image_large_height`, `similar_price_accuracy`, `news_catalog_limit`, `mailing_new_order_to_admin`, `mailing_new_order_to_user`, `mailing_new_order_subject`, `mailing_new_order_pattern`, `smsing_new_order_to_admin`, `smsing_new_order_phones`, `payment_required`, `delivery_required`, `vkontakte_api_id`, `vkontakte_poll_id`) VALUES
(1, 'Magaziller', 'Magaziller', 'pasechnikbs@gmail.com', 'pasechnikbs@gmail.com', '', '', 'Пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.', '', 1, '', 2, 2, 2, NULL, NULL, 1, 10, 'price DESC', 10, 'price', 160, 130, 250, 250, 200, 200, 600, 600, 200, 200, 600, 600, 60, 60, 200, 200, 400, 400, 200, 200, 400, 600, 0.03, 10, 0, 0, 'Ваша заявка принята', '<p>Здравствуйте, {{order.name}}!</p>\r\n<h3>Ваша заявка принята. Для подтверждения заказа наш менеджер свяжется с вами в ближайшее время.</h3>\r\n<p>Заявке присвоен номер: #{{order.id}}</p>\r\n<p>Статус заявки вы можете отследить <a href="{{order.url}}">по этой ссылке</a></p>\r\n<p>Будем рады ответить на ваши вопросы по телефонам:</p>\r\n<p>{{app.config.contact_phone}}</p>\r\n{% for product in order.products %}\r\n<b>{{product.name}}</b> - {{app.priceFormatter.format(product.orderPrice, true)}} * {{product.quantity}} = {{app.priceFormatter.format(product.sumPrice, true)}}<br>\r\n{% endfor %}\r\n{% if order.delivery_price %}\r\n<b>Доставка:</b> {{app.priceFormatter.format(order.delivery_price, true)}}\r\n{% endif %}\r\n<b>Сумма:</b> {{app.priceFormatter.format(order.cost, true)}}\r\n', 0, '', 0, 0, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `{{currency}}` (
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
-- Dumping data for table `currency`
--

INSERT INTO `{{currency}}` (`id`, `name`, `prefix`, `suffix`, `code`, `ratio_from`, `ratio_to`, `position`) VALUES
(1, 'Доллары', '$', '', 'USD', 1.000, 1.000, 5),
(2, 'Гривны', '', ' грн', 'UAH', 8.000, 1.000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE IF NOT EXISTS `{{delivery}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `free_from` float DEFAULT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `delivery`
--

INSERT INTO `{{delivery}}` (`id`, `name`, `description`, `free_from`, `price`, `status`) VALUES
(1, 'Курьером', '<p>Курьерская доставка осуществляется на следующий день после оформления заказа, если товар есть в наличии.</p>', 0, 0, 1),
(2, 'Самовывоз', '<p>Удобный, бесплатный и быстрый способ получения заказа.</p>', NULL, 40, 1),
(3, 'Укр. почтой', '<p>Для пересылки посылки наложенным платежом сообщите, пожалуйста, Ваш точный почтовый адрес с индексом и ФИО получателя посылки.</p>', NULL, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_payment`
--

CREATE TABLE IF NOT EXISTS `{{delivery_payment}}` (
  `delivery_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`delivery_id`,`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_payment`
--

INSERT INTO `{{delivery_payment}}` (`delivery_id`, `payment_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE IF NOT EXISTS `{{discount}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(32) NOT NULL,
  `description` text,
  `config` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE IF NOT EXISTS `{{feature}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alowed_values` text,
  `unit` varchar(45) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `hide_name` smallint(1) NOT NULL,
  `type` smallint(1) NOT NULL,
  `unique` smallint(1) NOT NULL,
  `required` smallint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feature_category`
--

CREATE TABLE IF NOT EXISTS `{{feature_category}}` (
  `feature_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `in_detail` smallint(1) NOT NULL DEFAULT '1',
  `in_summary` smallint(1) NOT NULL DEFAULT '1',
  `in_compare` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`feature_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feature_pack`
--

CREATE TABLE IF NOT EXISTS `{{feature_pack}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feature_value`
--

CREATE TABLE IF NOT EXISTS `{{feature_value}}` (
  `product_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`,`feature_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `filter`
--

CREATE TABLE IF NOT EXISTS `{{filter}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `{{gallery}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `gallery_image`
--

CREATE TABLE IF NOT EXISTS `{{gallery_image}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `description` text,
  `gallery_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `{{group}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE IF NOT EXISTS `{{lookup}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `code` varchar(16) CHARACTER SET utf8 NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=94 ;

--
-- Dumping data for table `lookup`
--

INSERT INTO `{{lookup}}` (`id`, `name`, `code`, `type`, `position`) VALUES
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
(93, 'Отключена', '2', 'PromotionStatus', 2);

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE IF NOT EXISTS `{{market}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description_type` int(11) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `market_category`
--

CREATE TABLE IF NOT EXISTS `{{market_category}}` (
  `market_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`market_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `{{menu_item}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `{{menu_item}}` (`id`, `name`, `uri`, `parent_id`, `level`, `position`) VALUES
(1, 'Главное меню', '', NULL, NULL, NULL),
(2, 'Меню футера', '', NULL, NULL, NULL),
(3, 'Боковое меню', '', NULL, NULL, NULL),
(4, 'Дополнительное меню', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `{{news}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `{{order}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `delivery_price` float NOT NULL,
  `payment_id` int(11) NOT NULL,
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
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE IF NOT EXISTS `{{order_product}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `additional_params` text NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `{{payment}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `{{payment}}` (`id`, `name`, `description`, `status`) VALUES
(1, 'Наличными курьеру', '', 1),
(2, 'WebMoney', '', 1),
(3, 'PayPal', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `price_list`
--

CREATE TABLE IF NOT EXISTS `{{price_list}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `price_list_row`
--

CREATE TABLE IF NOT EXISTS `{{price_list_row}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `{{product}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `other_price` float DEFAULT NULL,
  `price` float NOT NULL,
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
  `browse` int(11) DEFAULT NULL,
  `priority` int(2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `{{product_image}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `description` text,
  `product_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE IF NOT EXISTS `{{promotion}}` (
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

-- --------------------------------------------------------

--
-- Table structure for table `promotion_product`
--

CREATE TABLE IF NOT EXISTS `{{promotion_product}}` (
  `promotion_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`promotion_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `{{search}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE IF NOT EXISTS `{{seo}}` (
  `route` varchar(16) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '0',
  `metaTitle` varchar(500) DEFAULT NULL,
  `metaKeywords` varchar(500) DEFAULT NULL,
  `metaDescription` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`route`,`entity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seo`
--

INSERT INTO `{{seo}}` (`route`, `entity`, `metaTitle`, `metaKeywords`, `metaDescription`) VALUES
('site/error', 0, 'Страницы не существует', '', ''),
('site/index', 0, 'Главная страница', '', ''),
('site/contact', 0, 'Наши контакты', '', ''),
('site/login', 0, 'Авторизация', '', ''),
('article/index', 0, 'Статьи', '', ''),
('news/archive', 0, 'Архив новостей', '', ''),
('order/index', 0, 'Оформление заказа', '', ''),
('order/clear', 0, 'Корзина пуста', '', ''),
('order/view', 0, 'Состояние заказа', '', ''),
('search/result', 0, 'Результаты поиска', '', ''),
('user/register', 0, 'Регистрация', '', ''),
('category/view', 2, 'Телефоны HTC', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `scrap`
--

CREATE TABLE IF NOT EXISTS `{{scrap}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `limit_items` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scrap_item`
--

CREATE TABLE IF NOT EXISTS `{{scrap_item}}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scrap_template`
--

CREATE TABLE IF NOT EXISTS `{{scrap_template}}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `{{tag}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `frequency` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `{{user}}` (
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
-- Dumping data for table `user`
--

INSERT INTO `{{user}}` (`id`, `username`, `password`, `role`, `group_id`, `salt`, `email`, `phone`, `address`, `comment`, `status`, `create_time`, `authoriz_time`) VALUES
(1, 'admin', '2e5c7db760a33498023813489cfadc0b', 'admin', NULL, '28b206548469ce62182048fd9cf91760', 'admin@example.com', '', 'ул. 3-й микрорайон д. 13 кв. 81', 'комент', 1, NULL, NULL),
(2, 'taral', '50d1fba591ad2a3430b091d6731996e0', 'admin', NULL, '', 'pasechnikbs@gmail.com', '', '', '', 1, NULL, NULL);

EOF
)->execute();