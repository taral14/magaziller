<?php /*
  *
  * $dataProvider - новости
  *
  * */ ?>

<div class="best-head">Новости</div>

<b class="clearb"></b>

<?php $this->widget('zii.widgets.CBreadcrumbs', array(
    'links'=>$this->breadcrumbs,
)); ?>
<?php echo $dataProvider->sort->link('publish_date', 'Публикация'); ?>
<?php echo $dataProvider->sort->link('title', 'Название'); ?>

<ul>
    <?php foreach($dataProvider->data as $news): ?>
    <li>
    <h3>
        <a href="<?php echo $news->url; ?>">
            <?php echo Yii::app()->dateFormatter->format('dd MMMM y', $news->publish_date); ?>: 
            <?php echo $news->title; ?>
        </a>
    </h3>
    <p><img src="<?php echo $news->getImageUrl('small'); ?>" border="0" width="100" align="left"></p>
    <p><?php echo $news->annotation; ?></p>
    <div class="clear"></div>
  </li>
  <?php endforeach; ?>
</ul>

<?php $this->widget('CLinkPager', array(
     'pages'=>$dataProvider->pagination,
)); ?>