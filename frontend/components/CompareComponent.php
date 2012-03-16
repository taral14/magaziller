<?php
class CompareComponent extends CMap {

    public function init(){
        $this->restoreFromSession();
    }

    public function restoreFromSession() {
        $data = Yii::app()->user->getState(__CLASS__);
        if(is_array($data) && count($data)) {
            foreach(Product::model()->findAllByAttributes(array('id'=>$data)) as $product) {
                $this->put($product);
            }
        }
    }

    public function put(Product $product) {
        parent::add($product->id, $product);
        $this->saveState();
    }

    public function remove($key) {
        parent::remove($key);
        $this->onRemovePosition(new CEvent($this));
        $this->saveState();
    }

    protected function saveState() {
        $arr=array();
        foreach($this->toArray() as $product) {
            $arr[]=$product->id;
        }
        Yii::app()->user->setState(__CLASS__, $arr);
    }

    public function getCategoriesCount() {
        $ids=array();
        foreach($this->getProducts() as $product) {
            in_array($product->category_id, $ids) or array_push($ids, $product->category_id);
        }
        return count($ids);
    }

    public function onRemovePosition($event) {
        $this->raiseEvent('onRemovePosition', $event);
    }

    public function onUpdatePosition($event) {
        $this->raiseEvent('onUpdatePosition', $event);
    }

    public function getProducts()
    {
       return $this->toArray();
    }

    public function getProductsGroupByCategories()
    {
        $result=array();
        foreach($this->toArray() as $product) {
            if(empty($result[$product->category_id])) {
                $result[$product->category_id]=array(
                    0=>$product->category,
                    1=>array($product),
                );
            } else
                array_push($result[$product->category_id][1], $product);
        }
        return $result;
    }

    public function getCategories() {
        $categories=array();
        foreach($this->getProducts() as $product) {
            in_array($product->category, $categories) or array_push($categories, $product->category);
        }
        return count($categories);
    }

    public function getIsEmpty()
    {
       return !(bool)$this->getCount();
    }
}