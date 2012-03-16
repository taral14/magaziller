<?php
$this->layout='column1';
$this->Widget('ext.highcharts.HighchartsWidget', array(
     'options'=>array(
        'title' => array('text' => 'Отчет за месяц'),
        'xAxis' => array(
           'categories' => array('Яблоки', 'Бананы', 'Апельсины')
        ),
        'yAxis' => array(
           'title' => array('text' => 'Продуктивность работы')
        ),
        'series' => array(
           array('name' => 'Джейн', 'data' => array(1, 0, 4)),
           array('name' => 'Анна', 'data' => array(5, 7, 3))
        )
     )
));
?>