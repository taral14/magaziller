<?php if(Yii::app()->compare->isEmpty): ?>
<span>Товаров нет в сравнении</span>
<?php else: ?>

<a href="<?php echo $this->createUrl('compare/index'); ?>">
    <span>В сравнении <?php echo Yii::t('app', '{n} товар|{n} товара|{n} товаров|{n} товар', Yii::app()->compare->count); ?></span>
</a>

<?php endif; ?>