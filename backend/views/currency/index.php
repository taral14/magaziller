<?php
$this->breadcrumbs=array(
	'Валюты',
);

$this->menu=array(
	array('label'=>'Добавить валюту', 'url'=>array('create')),
);
?>

<h1>Валюты</h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'currency-batch-form',
)); ?>

<table>
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
        <td><?php echo $form->textField($currency, "[$i]name", array('style'=>'width:100%')); ?></td>
        <td><?php echo $form->textField($currency, "[$i]prefix", array('style'=>'width:100%')); ?></td>
        <td><?php echo $form->textField($currency, "[$i]suffix", array('style'=>'width:100%')); ?></td>
        <td><?php echo $form->textField($currency, "[$i]code", array('style'=>'width:100%')); ?></td>
        <td><?php echo $form->textField($currency, "[$i]ratio_from", array('style'=>'width:100%')); ?></td>
        <td><?php echo $form->textField($currency, "[$i]ratio_to", array('style'=>'width:100%')); ?></td>
        <td class="button-column">
            <?php echo CHtml::link('<img alt="Удалить" src="'.$this->assetsUrl.'/images/delete.png">', '#', array('submit'=>array('delete','id'=>$currency->id),'confirm'=>'Вы уверены что хотите удалить валюту?'));?>
        </td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php echo  ?>
<?php $this->endWidget(); ?>
</div><!-- form -->