<?php /*
  *
  * $news - новость
  *
  * */ ?>

<div id="page_title">
	     
    <h1 class="float_left" category_id="32" tooltip="category"><?php echo $news->title; ?></h1>

    <div id="path">
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?>
    </div>
</div>
<div id="news_main"><?php echo $news->content; ?></div>