<?php /*
  *
  * $category - категория
  * $dataProvider - товары текущей категории
  *
  * */ ?>
<div class="top_filters">
   <div class="top_filters_l">
       Сортировать по:
        <select>
           <option>По популярности</option>
        </select>
    </div>
    <div class="top_filters_r">
       <span>НА СТРАНИЦЕ</span>
        <ul>
           <li class="active"><a href="#">24</a></li>
            <li><a href="#">48</a></li>
            <li><a href="#">96</a></li>
        </ul>
    </div>
</div>
<div class="catalog">
    <?php foreach($dataProvider->data as $product): ?>
        <?php $this->renderPartial('/product/_view', array('product'=>$product)); ?>
    <?php endforeach; ?>
</div>
<div class="bottom_filters">
   <div class="top_filters_l">
       <?php $this->widget('CLinkPager', array(
            'pages'=>$dataProvider->pagination,
       )); ?>
    </div>
    <div class="top_filters_r">
       <span>НА СТРАНИЦЕ</span>
        <ul>
           <li class="active"><a href="#">24</a></li>
            <li><a href="#">48</a></li>
            <li><a href="#">96</a></li>
        </ul>
    </div>
</div>