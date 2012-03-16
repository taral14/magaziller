<?php /*
  *
  * $category - категория
  * $children - подкатегории текущей категории
  *
  * */ ?>

<?php foreach($children as $child) : ?>
    <h3><a href="<?php echo $child->url; ?>"><?php echo $child->name; ?></a></h3>
<?php endforeach; ?>