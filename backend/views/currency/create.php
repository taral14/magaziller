<?php
$this->breadcrumbs=array(
	'Валюты'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог валют', 'url'=>array('index')),
);
?>

<h1>Добавление валюты</h1>

<?php $this->widget('CTabView', array(
    'activeTab'=>'tab2',
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'Каталог',
            'url'=>$this->createUrl('index'),
        ),
        'tab2'=>array(
            'title'=>'Добавить валюту',
            'view'=>'_form',
            'data'=>array('model'=>$model)
        ),
    )
));?>
