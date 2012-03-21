<?php
/**
 * Discount abstract class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 *
 */
abstract class SDiscount {

    public $rate=0;
    public $rate_type=Discount::RATE_NUMBER;

    protected $cart;

    public function setCart(CartComponent $cart) {
        $this->cart = $cart;
    }

    /**
     * Apply discount
     *
     * @abstract
     * @return void
     */
    abstract public function apply();

    public function getDiscountPrice($price) {
        if($this->rate_type==Discount::RATE_NUMBER) {
            return $this->rate;
        } else {
            return $price*$this->rate/100;
        }
    }

}
