<?php foreach($features as $i=>$feature): ?>

    <?php if(!isset($features[$i-1]) || $features[$i-1]->pack_id!=$feature->pack_id): ?>
        <?php if($feature->pack && $feature->pack->image): ?>
        <img src="<?php echo $feature->pack->getImageUrl(); ?>" style="float: left;">
        <?php endif; ?>
        <div class="detailed_spec">
            <h3><?php echo $feature->pack->name; ?></h3>
    <?php endif; ?>

    <p>
        <?php if(!$feature->hide_name) echo '<b>'.$feature->name.'</b>'; ?>
        <?php echo $feature->value; ?> <?php echo $feature->unit; ?>
    </p>

    <?php if(!isset($features[$i+1]) || $features[$i+1]->pack_id!=$feature->pack_id): ?>
        </div>
    <?php endif; ?>

<?php endforeach; ?>