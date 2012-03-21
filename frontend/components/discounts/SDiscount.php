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

    public $model;
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
        if($this->model->rate_type==Discount::RATE_NUMBER) {
            return $this->model->rate;
        } else {
            return $price*$this->model->rate/100;
        }
    }

}
