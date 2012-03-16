<?php

class CartBehavior extends CActiveRecordBehavior {

    /**
     * Positions number
     * @var int
     */
    private $quantity = 0;

    /**
     * Order price
     * @var float
     */
    private $orderPrice = 0;

    /**
     * Update model on session restore?
     * @var boolean
     */
    private $refresh = true;

    /**
     * Position discount sum
     * @var float
     */
    private $discountPrice = 0.0;

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getSumPrice($withDiscount = true) {
        $fullSum = $this->orderPrice * $this->quantity;
        if($withDiscount)
            $fullSum -=  $this->discountPrice;
        return $fullSum;
    }

    /**
     * Returns quantity.
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setQuantity($newVal) {
        $this->quantity = $newVal;
    }

    /**
     * Updates order price.
     * @return float
     */
    public function getOrderPrice() {
        return $this->orderPrice;
    }

    /**
     * Returns order price.
     * @return float
     */
    public function setOrderPrice($price) {
        $this->orderPrice = $price;
    }

    /**
     * Magic method. Called on session restore.
     */
    public function __wakeup() {
        if ($this->refresh === true)
            $this->owner->refresh();
    }

    /**
     * If we need to refresh model on restoring session.
     * Default is true.
     * @param boolean $refresh
     */
    public function setRefresh($refresh) {
        $this->refresh = $refresh;
    }

    /**
     * Add $price to position discount sum
     * @param float $price
     * @return void
     */
    public function addDiscountPrice($price) {
        $this->discountPrice += $price;
    }

    /**
     * Set position discount sum
     * @param float $price
     * @return void
     */
    public function setDiscountPrice($price) {
        $this->discountPrice = $price;
    }
}
