<?php
$this->breadcrumbs=array(
	'Пользователи',
);

$this->menu=array(
	array('label'=>'Добавить пользователя', 'url'=>array('create', 'User[role]'=>$model->role)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить пользователя?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
");
?>

<h3 class="order-status-menu">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items'=>array(
        array('label'=>'Все', 'url'=>array('user/index'), 'active'=>empty($_GET)),
        array('label'=>'Клиенты', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_CLIENT))),
        array('label'=>'Менеджеры', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_MANAGER))),
        array('label'=>'Контент менеджеры', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_CONTENT))),
        array('label'=>'Администраторы', 'url'=>array('user/index', 'User'=>array('role'=>User::ROLE_ADMIN))),
    ),
));
?>
</h3>
<b class="clearb"></b>
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'sortableAttributes'=>($model->role==User::ROLE_CLIENT)?array('username', 'email', 'group_id', 'authoriz_time', 'create_time'):array('username', 'email', 'authoriz_time', 'create_time'),
)); ?>
