<?php foreach($categories as $category): ?>
        <li>
        <?php if($category->hasChildren): ?>
            <b><?php echo $category->name; ?></b>
            <ul>
            <?php $this->renderPartial('_categories', array(
                'categories'=>$category->children,
                'model'=>$model,
            ))?>
            </ul>
        <?php else: ?>
            <label><?php echo CHtml::checkBox("Feature[categoryIds][]", in_array($category->id, $model->categoryIds), array('value'=>$category->id)) ?> <?php echo $category->name; ?></label>
        <?php endif; ?>
        </li>
<?php endforeach; ?>