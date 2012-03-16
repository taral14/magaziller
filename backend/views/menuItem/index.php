<?php
$this->breadcrumbs=array(
	'Пункты меню',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Пункт меню</h1>

<?php
$tabs=array();
foreach($menuItems as $menuItem) {
    $tabs['tab'.$menuItem->id]=array(
        'title'=>$menuItem->name,
        'view'=>'_view',
        'data'=>array(
            'model'=>$menuItem,
        )
    );
}
?>

<?php $this->widget('CTabView', array(
	'tabs' => $tabs,
)); ?>