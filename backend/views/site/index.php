
<?php $this->beginWidget('Masonry'); ?>

<div class="brand-box" style="width: 200px;">
    <strong>Здравствуйте, <?php echo Yii::app()->user->name; ?></strong><br>
    <a href="<?php echo $this->createUrl('user/update', array('id'=>Yii::app()->user->id)); ?>">Профиль</a><br>
    <a href="<?php echo $this->createUrl('site/logout'); ?>">Выход</a><br>
</div>

<?php foreach($menu as $item): ?>
<?php if(isset($item['items'])): ?>
<div class="brand-box" style="width: 200px;">
    <strong><?php echo $item['label']; ?></strong><br>
    <?php foreach($item['items'] as $item): ?>
        <a href="<?php echo $this->createUrl($item['url'][0], array_slice($item['url'], 1)); ?>"><?php echo $item['label']; ?></a><br>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php $this->endWidget(); ?>