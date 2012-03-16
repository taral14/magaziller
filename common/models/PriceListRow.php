<?php

/**
 * This is the model class for table "{{pricelist}}".
 *
 * The followings are the available columns in table '{{pricelist}}':
 * @property integer $id
 * @property string $article
 * @property double $price
 * @property string $information
 * @property integer $availability
 * @property integer $quantity
 * @property integer $product_id
 * @property integer $price_list_id
 * @property integer $create_time
 * @property integer $upload_time
 */
class PriceListRow extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pricelist the static model class
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
		return '{{price_list_row}}';
	}

    public function defaultScope() {
        $alias = $this->getTableAlias(false,false);
        return array(
            'order'=>"$alias.create_time DESC",
        );
    }

    public function behaviors(){
  	    return array(
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => null,
  		    )
  	    );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article, price, availability, quantity, price_list_id', 'required'),
			array('availability, quantity, product_id, price_list_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('article, information', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article, price, information, availability, quantity, product_id, price_list_id', 'safe', 'on'=>'search'),
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
            'priceList'=>array(self::BELONGS_TO, 'PriceList', 'price_list_id'),
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
			'article' => 'Article',
			'price' => 'Price',
			'information' => 'Information',
			'availability' => 'Availability',
			'quantity' => 'Quantity',
			'product_id' => 'Product',
			'price_list_id' => 'Прайс-лист',
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
		$criteria->compare('article',$this->article,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('information',$this->information,true);
		$criteria->compare('availability',$this->availability);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('price_list_id',$this->price_list_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function findAllMinPrice() {
        $criteria=new CDbCriteria;
        $criteria->select='MIN(price) AS price, product_id';
        $criteria->group='product_id';
        $criteria->addCondition('product_id!=0');
        $criteria->addCondition('product_id IS NOT NULL');
        $criteria->join='JOIN {{price_list}} as t2 ON t2.id=t.price_list_id';
        $criteria->compare('t2.status', PriceList::STATUS_ENABLED);
        return $this->findAll($criteria);
    }
}