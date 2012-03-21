<?php
/**
 * Test discount is applied when there are more than one item in position:
 * if there are two items in the same position (two equal products), add $rate % discount
 * to the first item.
 */
class QuantityDiscount extends SDiscount {

    public $minCartQuantity;
    public $minProductQuantity;

    public function apply() {
        $quantity=$this->cart->getItemsCount();
        if($this->minCartQuantity>0 && $quantity >= $this->minCartQuantity) {
            $discountPrice=$this->getDiscountPrice($this->cart->getCost(false));
            $this->cart->addDiscountPrice($discountPrice);
        } elseif($this->minProductQuantity>0) {
            foreach ($this->cart as $product) {
                $quantity = $product->getQuantity();
                if ($quantity >= $this->minProductQuantity) {
                    $discountPrice=$this->getDiscountPrice($product->getOrderPrice() * $quantity);
                    $product->addDiscountPrice($discountPrice);
                }
            }
        }
    }
}