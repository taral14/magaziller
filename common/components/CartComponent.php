<?php

class CartComponent extends CMap {

    /**
     * Update the model on session restore?
     * @var boolean
     */
    public $refresh = true;

    /**
     * Cart-wide discount sum
     * @var float
     */
    protected $discountPrice = 0.0;

    public function init(){
        $config=require Yii::getPathOfAlias('common.config.handlers').'.php';
        foreach($config as $event=>$handlers) {
            if($this->hasEvent($event)) {
                foreach($handlers as $handler)
                    $this->attachEventHandler($event, $handler);
            }
        }
        $this->restoreFromSession();
    }

    public function getDiscounts() {
        $discounts=array();
        $models=Discount::model()->findAll();
        foreach($models as $model) {
            $config=CMap::mergeArray(array(
                'class'=>$model->handler,
                'model'=>$model,
            ), $model->handlerParams);
            array_push($discounts, $config);
        }
        return $discounts;
    }
    /**
     * Restores the shopping cart from the session
     */
    public function restoreFromSession() {
        $data = Yii::app()->user->getState(__CLASS__, array());
        foreach ($data as $product_id => $quantity) {
            $this->put(Product::model()->findByPk($product_id), $quantity);
        }
    }

    /**
     * Add item to the shopping cart
     * If the position was previously added to the cart,
     * then information about it is updated, and count increases by $quantity
     * @param Product $product
     * @param int count of elements positions
     */
    public function put(Product $product, $quantity = 1) {
        $key = $product->id;
        if ($this->itemAt($key) instanceof Product) {
            $product = $this->itemAt($key);
            $oldQuantity = $product->getQuantity();
            $quantity += $oldQuantity;
        }

        $this->update($product, $quantity);
    }

    /**
     * Removes position from the shopping cart of key
     * @param mixed $key
     */
    public function remove($key) {
        parent::remove($key);
        $this->applyDiscounts();
        $this->onRemovePosition(new CEvent($this));
        $this->saveState();
    }


    /**
     * Updates the position in the shopping cart
     * If position was previously added, then it will be updated in shopping cart,
     * if position was not previously in the cart, it will be added there.
     * If count is less than 1, the position will be deleted.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function update(Product $product, $quantity) {
        $key = $product->id;

        $product->attachBehavior("CartBehavior", new CartBehavior());
        $product->setRefresh($this->refresh);
        $product->setQuantity($quantity);
        $product->setOrderPrice($product->price);

        if ($product->getQuantity() < 1)
            $this->remove($key);
        else
            parent::add($key, $product);

        $this->applyDiscounts();
        $this->onUpdatePosition(new CEvent($this));
        $this->saveState();
    }

    /**
     * Saves the state of the object in the session.
     * @return void
     */
    protected function saveState() {
        Yii::app()->user->setState(__CLASS__, CHtml::listData($this->products, 'id', 'quantity'));
    }

    /**
     * Returns count of items in shopping cart
     * @return int
     */
    public function getItemsCount() {
        $count = 0;
        foreach ($this as $product)
        {
            $count += $product->getQuantity();
        }

        return $count;
    }


    /**
     * Returns total price for all items in the shopping cart.
     * @param bool $withDiscount
     * @return float
     */
    public function getCost($withDiscount = true) {
        $price = 0.0;
        foreach ($this as $product)
        {
            $price += $product->getSumPrice($withDiscount);
        }

        if($withDiscount)
            $price -= $this->discountPrice;

        return $price;
    }

    /**
     * onRemovePosition event
     * @param  $event
     * @return void
     */
    public function onRemovePosition($event) {
        $this->raiseEvent('onRemovePosition', $event);
    }

    /**
     * onUpdatePosition event
     * @param  $event
     * @return void
     */
    public function onUpdatePosition($event) {
        $this->raiseEvent('onUpdatePosition', $event);
    }

    /**
     * Apply discounts to all positions
     * @return void
     */
    protected function applyDiscounts() {
        foreach ($this->discounts as $discount)
        {
            $discountObj = Yii::createComponent($discount);
            $discountObj->setCart($this);
            $discountObj->apply();
        }
    }

    /**
     * Set cart-wide discount sum
     *
     * @param float $price
     * @return void
     */
    public function setDiscountPrice($price){
        $this->discountPrice = $price;
    }

    /**
     * Add $price to cart-wide discount sum
     *
     * @param float $price
     * @return void
     */
    public function addDiscountPrice($price){
        $this->discountPrice += $price;
    }

    /**
     * Returns array all positions
     * @return array
     */
    public function getProducts()
    {
        return $this->toArray();
    }

    /**
     * Returns if cart is empty
     * @return bool
     */

    public function getIsEmpty()
    {
        return !(bool)$this->getCount();
    }

}
