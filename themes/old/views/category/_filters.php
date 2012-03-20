<?php /*
  *
  * $category - категория
  * $sort - обьект для генерации сортировки
  *
  * */ ?>

<b>Сортировать</b>
<a href="<?php echo $sort->createUrl($this, array('browse'=>true)); ?>">По популярности</a>
<a href="<?php echo $sort->createUrl($this, array('price'=>false)); ?>">По цене (сначала дешёвые)</a>
<a href="<?php echo $sort->createUrl($this, array('price'=>true)); ?>">По цене (сначала дорогие)</a>
<a href="<?php echo $sort->createUrl($this, array('name'=>false)); ?>">По названию</a>

<form action="">
<?php foreach($filters as $filter): ?>

    <b><?php echo $filter->name; ?></b><br>

    <?php echo $filter->createField($_GET); ?><br>

<?php endforeach; ?>
    <button type="submit">Поиск</button>
</form>