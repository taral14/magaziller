<?php

/**
 * This is the model class for table "{{delivery}}".
 *
 * The followings are the available columns in table '{{delivery}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property double $free_from
 * @property double $price
 * @property integer $status
 */
class Delivery extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    public function behaviors(){
  	    return array(
  		    'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior')
  	    );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Delivery the static model class
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
		return '{{delivery}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Delivery::STATUS_ENABLED;

        return $scopes;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'filter', 'filter'=>'strip_tags'),
            array('description', 'filter', 'filter'=>array($obj=new CHtmlPurifier(),'purify')),
            array('name, price, status', 'required'),
            array('name', 'length', 'max'=>255),
            array('name', 'unique', 'message'=>'Такой способ доставки уже есть'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('free_from, price', 'numerical'),
            array('paymentIds', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, status', 'safe', 'on'=>'search'),
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
            'payments'=>array(self::MANY_MANY, 'Payment', '{{delivery_payment}}(delivery_id, payment_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'free_from' => 'Бесплатно от',
			'price' => 'Стоимость',
			'status' => 'Состояние',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function in(array $ids) {
        $this->getDbCriteria()->addInCondition('id', $ids);
        return $this;
    }

    public function getPaymentIds() {
        $ids = array();
        foreach($this->payments as $payment) {
            array_push($ids, $payment->id);
        }
        return $ids;
    }

    public function setPaymentIds($ids) {
        $this->payments=empty($ids)?array():Payment::model()->findAllByAttributes(array('id'=>$ids));
    }

    public function getUrl() {
        $urlManager=(IS_BACKEND)?Yii::app()->frontendUrlManager:Yii::app()->urlManager;
        return $urlManager->createUrl('delivery/view', array(
            'id'=>$this->id,
            'title'=>Yii::app()->translitFormatter->formatUrl($this->name)
        ));
    }

    public function priceTo($price) {
        return (!$this->isNewRecord && (empty($this->free_from) || $this->free_from>$price))?$this->price:0;
    }
}