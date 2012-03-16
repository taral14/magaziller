<?php
/**
 * Test discount is applied when there are more than one item in position:
 * if there are two items in the same position (two equal products), add $rate % discount
 * to the first item.
 */
class QuantityDiscount extends Discount {
    /**
     * Discount %
     */
    public $rate=0;

    public $minQuantity=1;

    public function apply() {
        foreach ($this->shoppingCart as $position) {
            $quantity = $position->getQuantity();
            if ($quantity >= $this->minQuantity) {
                $discountPrice = $this->rate * $position->getPrice() / 100;
                $position->addDiscountPrice($discountPrice);
            }
        }
    }
}