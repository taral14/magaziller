<h2>Интеграция с 1С</h2>
<p>Настройка интеграции характеристик товаров с 1С.</p>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm'); ?>

    <table>
    <tr>
        <th>Название на сайте</th>
        <th>Название в 1С</th>
    </tr>
    <?php foreach($items as $i=>$item): ?>
    <tr>
        <td><?php echo $item->pack->name; ?>: <?php echo $item->name; ?> <?php if($item->unit) echo '('.$item->unit.')'; ?></td>
        <td>
            <?php echo $form->textField($item, "[$i]id_1c",array('size'=>60,'maxlength'=>255));?>
            <?php echo $form->error($item,'id_1c'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
   	</div>

    <?php $this->endWidget(); ?>


</div>