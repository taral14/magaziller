<?php
    foreach($features as $i=>$feature):
    $name='Product['.$feature->attribute.']';
    if(!isset($features[$i-1]) || $features[$i-1]->pack_id!=$feature->pack_id):
?>

<fieldset>
   <legend><?php echo $feature->pack->name; ?></legend>

<?php endif; ?>

    <div class="row">
        <?php echo CHtml::label($feature->name, 'Product_'.$feature->attribute, array('required'=>$feature->required)) ?>
        <?php
        switch($feature->type) {
            case Feature::TYPE_BOOL:
                echo CHtml::openTag('label');
                echo CHtml::radioButton($name, false, array('value'=>$feature->trueValue, 'uncheckValue'=>null));
                echo $feature->trueValue;
                echo CHtml::closeTag('label');
                echo CHtml::openTag('label');
                echo CHtml::radioButton($name, false, array('value'=>$feature->falseValue, 'uncheckValue'=>null));
                echo $feature->falseValue;
                echo CHtml::closeTag('label');
                if(!$feature->required) {
                    echo CHtml::openTag('label');
                    echo CHtml::radioButton($name, true, array('value'=>'', 'uncheckValue'=>null));
                    echo 'Не заполнено';
                    echo CHtml::closeTag('label');
                }
            break;
            case Feature::TYPE_SELECT:
                echo CHtml::dropDownList($name, null, $feature->selectValues, array('empty'=>'','style'=>'width:370px;'));
            break;
            /*case Feature::TYPE_IMAGE:
            case Feature::TYPE_FILE:
                $this->widget('ElFinderInput', array(
                    'name'=>$name,
                ));
            break;*/
            default:
                echo CHtml::textField($name, null, array('size'=>60));
        }
        ?>
        <?php echo $feature->unit; ?>
   	</div>

<?php if(!isset($features[$i+1]) || $features[$i+1]->pack_id!=$feature->pack_id): ?>
</fieldset>
<?php endif; ?>

<?php endforeach; ?>