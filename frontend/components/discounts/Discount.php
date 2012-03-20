<?php
/**
 * Discount abstract class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 *
 */
abstract class Discount {

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

}
