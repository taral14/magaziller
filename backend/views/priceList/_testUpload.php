<?php echo CHtml::errorSummary($model); ?>

<table style="width:675px;">
    <tbody>
<?php for($i=0; $i<=10; $i++): ?>
    <tr>
        <?php for($n=0; $n<7; $n++): ?>
        <td title="<?php echo empty($model->rows[$i][$n])?'ячейка пуста':CHtml::encode($model->rows[$i][$n]); ?>" style="width:70px;overflow:hidden;">
            <?php echo empty($model->rows[$i][$n])?'&nbsp;':CHtml::encode($model->rows[$i][$n]); ?>
        </td>
        <?php endfor; ?>
    </tr>
<?php endfor; ?>
    </tbody>
</table>