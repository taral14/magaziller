<?php
$this->breadcrumbs=array(
	'Валюты',
);
?>

<h1>Валюты</h1>

<?php $this->beginClip('form'); ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'currency-batch-form',
)); ?>

<table class="currency-batch-table">
  <thead>
    <tr>
      <th>Название</th>
      <th>Префикс</th>
      <th>Суффикс</th>
      <th>Код ISO</th>
      <th>Курс от</th>
      <th>Курс к</th>
      <th class="button-column">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($currencies as $i=>$currency):?>
    <tr>
        <td><?php echo $form->textField($currency, "[$i]name"); ?></td>
        <td><?php echo $form->textField($currency, "[$i]prefix"); ?></td>
        <td><?php echo $form->textField($currency, "[$i]suffix"); ?></td>
        <td><?php echo $form->textField($currency, "[$i]code"); ?></td>
        <td><?php echo $form->textField($currency, "[$i]ratio_from"); ?></td>
        <td><?php echo $form->textField($currency, "[$i]ratio_to"); ?></td>
        <td class="button-column">
            <?php echo CHtml::link('<img alt="Удалить" src="'.$this->assetsUrl.'/images/delete.png">', '#', array('submit'=>array('delete','id'=>$currency->id),'confirm'=>'Вы уверены что хотите удалить валюту?'));?>
        </td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
<?php $this->endWidget(); ?>
</div><!-- form -->

<?php $this->endClip(); ?>

<?php $this->widget('CTabView', array(
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'Каталог',
            'content'=>$this->clips['form'],
        ),
        'tab2'=>array(
            'title'=>'Добавить валюту',
            'url'=>$this->createUrl('create'),
        ),
    )
));?>