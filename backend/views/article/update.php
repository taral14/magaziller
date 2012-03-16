<?php
$this->breadcrumbs=array(
	'Статьи'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Каталог статей', 'url'=>array('index')),
	array('label'=>'Добавить статью', 'url'=>array('create')),
	array('label'=>'Удалить статью', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить статью?')),
    array(
        'label'=>'Просмотр',
        'url'=>Yii::app()->frontendUrlManager->createUrl('article/view', array('id'=>$model->id)),
        'linkOptions'=>array('target'=>'_blank'),
        'visible'=>$model->status==Article::STATUS_PUBLISHED
    ),
    array('label'=>'Добавить в меню', 'url'=>'#', 'linkOptions'=>array('id'=>'add-to-menu', 'onclick'=>"$('#add-to-menu-dialog').dialog('open'); return false;")),
);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'add-to-menu-dialog',
'options'=>array(
    'title'=>'Добавить в меню',
    'width'=>'450px',
    'autoOpen'=>false,
),
));
?>
<?php echo CHtml::beginForm(array('menuItem/remote')); ?>

<div class="form">

    <?php echo CHtml::hiddenField('returnUrl', Yii::app()->request->getRequestUri()); ?>
    <?php echo CHtml::hiddenField('MenuItem[uri]', $model->url); ?>

    <div class="row">
           <label for="MenuItem_id">Выберите пункт меню</label>
           <?php
           $this->widget('McDropdown',array(
               'name'=>'MenuItem_id',
               'data' => MenuItem::model()->rooted()->findAll(),
           ));
           ?>
    </div>

    <div class="row">
           <label for="MenuItem_name">Текст ссылки</label>
           <?php echo CHtml::textField('MenuItem[name]', $model->title, array('size'=>55,'maxlength'=>255)); ?>
    </div>

    <div class="row buttons">
   		<?php echo CHtml::submitButton('Добавить в', array('name'=>'create', 'class'=>'save_button')); ?> |
        <?php echo CHtml::submitButton('Заменить', array('name'=>'update', 'class'=>'save_button')); ?>
   	</div>

</div>

<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<h1>Статья "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>