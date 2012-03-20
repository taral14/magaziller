<?php /*
  *
  * $category - категория
  * $sort - обьект для генерации сортировки
  *
  * */ ?>
<!--<?php if(false):?>

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

<?php endif; ?>-->



<div class="left_menu_head">
   <strong>Фiльтри:</strong>
</div>
<div class="left_menu_head">
   <strong>Розмiр</strong>
</div>
<div class="left_menu_select">
    <select>
        <option>S</option>
        <option>M</option>
        <option>L</option>
        <option>XL</option>
    </select>
</div>
<div class="left_menu_head">
   <strong>Материал</strong>
</div>
<div class="left_menu_select">
    <select>
        <option>Хлопок</option>
    </select>
</div>
<div class="left_menu_head">
   <strong>Фасон</strong>
</div>
<div class="left_menu_select">
    <select>
        <option>Класическая</option>
    </select>
</div>
<div class="left_menu_head">
   <strong>Цвет</strong>
</div>
<div class="colors">
    <div class="color"><a href="#"><img src="images/color1.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color2.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color3.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color4.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color5.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color6.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color7.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color8.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color9.png" /></a></div>
    <div class="color"><a href="#"><img src="images/color10.png" /></a></div>
</div>
<div class="left_menu_head">
   <strong>Цена</strong>
</div>
<div class="price_filter">
   от
    <input type="text" />
    до
    <input type="text" />
    грн
</div>
<div class="left_menu_head">
   <strong>Бренд</strong>
</div>
<ul>
   <li><a href="#">BCBGMAXAZRIA (46)</a></li>
    <li><a href="#">BCX (9)</a></li>
    <li><a href="#">Calvin Klein (40)</a></li>
    <li><a href="#">Charter Club (16)</a></li>
    <li><a href="#">Hailey Logan (23)</a></li>
    <li><a href="#">INC International (51)</a></li>
    <li><a href="#">Jessica Simpson (20)</a></li>
    <li><a href="#">Michael Kors (9)</a></li>
    <li><a href="#">Rachel Rachel Roy (16)</a></li>
</ul>
<div class="filters_submit">
   <input type="submit" value="ПОИСК" />
</div>