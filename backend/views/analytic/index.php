<?php
$this->breadcrumbs=array(
	'Статистика',
);
?>

    <h3>10 самых продаваемых товаров за месяц</h3>
        
    <table>
        <tbody>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество покупок</th>
                <th>Сумма</th>
            </tr>
        </tbody>
        <tbody>
<?php foreach($bestSellingProducts as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo Yii::app()->priceFormatter->format($product['price']); ?></td>
                <td><?php echo $product['quantity']; ?></td>
                <td><?php echo Yii::app()->priceFormatter->format($product['price']*$product['quantity']); ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <h3>10 сайтов генераторов заказов</h3>

    <table>
        <tbody>
            <tr>
                <th>Сайты</th>
                <th>Количество заказов</th>
            </tr>
        </tbody>
        <tbody>
    <?php foreach($bestReferers as $referer): ?>
            <tr>
                <td><?php echo $referer['referer']; ?></td>
                <td><?php echo $referer['count']; ?></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>

    <h3>10 самых популярных запросов, по которым ваш сайт находят покупатели</h3>

    <table>
        <tbody>
            <tr>
                <th>Ключевые слова</th>
                <th>Количество заказов</th>
            </tr>
        </tbody>
        <tbody>
<?php foreach($bestSearchings as $bestSearch): ?>
            <tr>
                <td><?php echo $bestSearch['search_terms']; ?></td>
                <td><?php echo $bestSearch['count']; ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <h3>Статистика количества заказов за текущий месяц</h3>

    <?php $this->widget('ext.highcharts.HighchartsWidget', array(
        'options'=>array(
            'title' => array('text' => ''),
            'yAxis' => array(
                'title' => array('text' => 'Количество продаж')
            ),
            'xAxis' => array(
                 'type' => 'datetime',
                 'dateTimeLabelFormats' => array(
                    'month' => '%e.%m.%Y',
                    'year' => '%Y'
                 ),
            ),
            'tooltip'=> array(
                'formatter'=>"js:function() {
                    return '<b>'+ this.series.name +'</b><br/>'+Highcharts.dateFormat('%e.%m.%Y', this.x)+': заказов '+ this.y;
                }"
            ),
            'series' => array(
                array('name' => 'Текущий месяц', 'data' => $quantityOrderThisMonth),
            )
        )
    )); ?>

    <h3>Статистика количества заказов за прошлый месяц</h3>

    <?php $this->widget('ext.highcharts.HighchartsWidget', array(
        'options'=>array(
            'title' => array('text' => ''),
            'yAxis' => array(
                'title' => array('text' => 'Количество продаж')
            ),
            'xAxis' => array(
                 'type' => 'datetime',
                 'dateTimeLabelFormats' => array(
                    'month' => '%e.%m.%Y',
                    'year' => '%Y'
                 ),
            ),
            'tooltip'=> array(
                'formatter'=>"js:function() {return '<b>'+ this.series.name +'</b><br/>'+Highcharts.dateFormat('%e. %b', this.x) +': заказов '+ this.y;}"
            ),
            'series' => array(
                array('name' => 'Предыдущий месяц', 'data' => $quantityOrderLastMonth)
            )
        )
    )); ?>