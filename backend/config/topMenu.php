<?php
return array(
                array('label'=>'Главная', 'url'=>array('site/index')),
                array('label'=>'Заказы ('.Order::model()->status(Order::STATUS_NEW)->count().')', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_NEW)), 'items'=>array(
                    array('label'=>'Заказы', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_NEW)), 'items'=>array(
                        array('label'=>'Новые', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_NEW))),
                        array('label'=>'В обработке', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_PROCESSING))),
                        array('label'=>'Выполненные', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_COMPLETE))),
                        array('label'=>'Нет в наличии', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_ABSENT))),
                        array('label'=>'Удаленные', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_DELETE)), 'visible'=>Yii::app()->user->role==User::ROLE_ADMIN),
                    )),
                    array('label'=>'Доставка', 'url'=>array('delivery/index')),
                    array('label'=>'Оплата', 'url'=>array('payment/index')),
                )),

                array('label'=>'Контент', 'url'=>array('article/index'), 'items'=>array(
                    array('label'=>'Статьи', 'url'=>array('article/index')),
                    array('label'=>'Новости', 'url'=>array('news/index')),
                    array('label'=>'Элементы страниц', 'url'=>array('scrap/index')),
                    array('label'=>'Галереи изображений', 'url'=>array('gallery/index')),
                    array('label'=>'Акции', 'url'=>array('promotion/index')),
                    array('label'=>'Пункты меню', 'url'=>array('menuItem/index')),
                )),

                array('label'=>'Товары', 'url'=>array('product/index'), 'items'=>array(
                    array('label'=>'Товары', 'url'=>array('product/index')),
                    array('label'=>'Категории', 'url'=>array('category/index')),
                    array('label'=>'Бренды', 'url'=>array('brand/index')),
                    array('label'=>'Группы характеристик', 'url'=>array('featurePack/index')),
                    array('label'=>'Характеристики', 'url'=>array('feature/index')),
                    array('label'=>'Фильтры', 'url'=>array('filter/index')),
                    array('label'=>'Прайс-листы', 'url'=>array('priceList/index')),
                    array('label'=>'Яндекс.Маркет', 'url'=>array('market/index')),
                    array('label'=>'Мониторинг конкурентов', 'url'=>array('competitor/index')),
                    array('label'=>'Интеграция с 1С', 'url'=>array('enterprise1c/index')),
                )),

                array('label'=>'Пользователи', 'url'=>array('user/index'), 'items'=>array(
                    array('label'=>'Пользователи', 'url'=>array('user/index'), 'items'=>array(
                        array('label'=>'Клиенты', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_CLIENT))),
                        array('label'=>'Менеджеры', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_MANAGER))),
                        array('label'=>'Контент менеджеры', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_CONTENT))),
                        array('label'=>'Администраторы', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_ADMIN))),
                    )),
                    array('label'=>'Группы', 'url'=>array('group/index')),
                )),

                array('label'=>'Настройки', 'url'=>array('config/index'), 'items'=>array(
                    array('label'=>'Параметры', 'url'=>array('config/index'), 'items'=>array(
                        array('label'=>'Основные', 'url'=>array('config/index', 'section'=>'basic')),
                        array('label'=>'SEO информация', 'url'=>array('config/seo')),
                        array('label'=>'Изображения', 'url'=>array('config/index', 'section'=>'images')),
                        array('label'=>'Контент', 'url'=>array('config/index', 'section'=>'content')),
                        array('label'=>'Страницы', 'url'=>array('config/index', 'section'=>'pages')),
                        array('label'=>'Интеграция', 'url'=>array('config/index', 'section'=>'integration')),
                        array('label'=>'Заказы', 'url'=>array('config/index', 'section'=>'order')),
                    )),
                    array('label'=>'Валюта', 'url'=>array('currency/index')),
                    array('label'=>'Обновить цены', 'url'=>array('priceListRow/updateProductPrice', 'returnUrl'=>Yii::app()->request->requestUri)),
                    array('label'=>'Файловый менеджер', 'url'=>array('site/elfinder')),
                    array('label'=>'Статистика', 'url'=>array('analytic/index')),
                )),

                array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
);