<?php
class FeatureValueBehavior extends CActiveRecordBehavior {

    protected $product;

    public function __construct(Product $product) {
        $this->product=$product;
    }

    public function getValue() {
        return $this->product->getFeatureValue($this->owner->id);
    }
}
