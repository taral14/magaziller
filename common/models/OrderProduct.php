<?php

/**
 * This is the model class for table "{{order_product}}".
 *
 * The followings are the available columns in table '{{order_product}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $additional_params
 * @property double $price
 * @property integer $quantity
 */
class OrderProduct extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return OrderProduct the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{order_product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, product_id, price, quantity', 'required'),
            array('order_id, product_id, quantity', 'numerical', 'integerOnly'=>true),
            array('price', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, order_id, product_id, additional_params, price, quantity', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'order_id' => 'Order',
            'product_id' => 'Product',
            'additional_params' => 'Additional Params',
            'price' => 'Price',
            'quantity' => 'Quantity',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('order_id',$this->order_id);
        $criteria->compare('product_id',$this->product_id);
        $criteria->compare('additional_params',$this->additional_params,true);
        $criteria->compare('price',$this->price);
        $criteria->compare('quantity',$this->quantity);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    public function getModel() {
        return $this->product->model;
    }

    public function getUrl() {
        return $this->product->url;
    }

    public function getCategory() {
        return $this->product->category;
    }

    public function getBrand() {
        return $this->product->brand;
    }

    public function getCurrentPrice() {
        return $this->product->price;
    }

    public function getSumPrice() {
        return $this->price*$this->quantity;
    }
}