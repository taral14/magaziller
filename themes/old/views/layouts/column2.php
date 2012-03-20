<?php $this->beginContent('//layouts/main'); ?>
<div class="content-catalog">
    	<div class="cont-menu">
        	<div class="cont-menu-head">
            	<b>Меню</b>
            </div>
            <b class="clearb"></b>
            <div class="zeleny"></div>
            <div class="catalog-menu-body">
                <?php foreach(Category::model()->rooted()->findAll() as $category): ?>
            	<a onclick="return false;" href="#"><strong><?php echo $category->name; ?></strong></a>
            		<ul>
                        <?php foreach($category->children as $child): ?>
                    	<li><a href="<?php echo $child->url; ?>"><?php echo $child->name; ?></a></li>
                        <?php endforeach; ?>
                	</ul>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="best">
        	<?php echo $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>