<?php

/**
 * This is the model class for table "{{payment}}".
 *
 * The followings are the available columns in table '{{payment}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $currency_id
 * @property integer $status
 */
class Payment extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    protected $_handlerObject;

    public function behaviors(){
  	    return array(
  		    'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior')
  	    );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Payment the static model class
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
		return '{{payment}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Payment::STATUS_ENABLED;

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
			array('currency_id, name, status', 'required'),
			array('currency_id, status', 'numerical', 'integerOnly'=>true),
            array('currency_id', 'exist', 'className'=>'Currency', 'attributeName'=>'id', 'message'=>'Такой валюты нету'),
			array('name', 'length', 'max'=>255),
            array('handler', 'length', 'max'=>32),
            array('name', 'unique', 'message'=>'Такая форма оплаты уже есть'),
            array('deliveryIds', 'safe'),
            array('handlerParams', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status', 'safe', 'on'=>'search'),
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
            'deliveries'=>array(self::MANY_MANY, 'Delivery', '{{delivery_payment}}(payment_id,delivery_id)'),
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
            'currency_id' => 'Валюта в которой производится оплата',
            'handler' => 'Обработка платежа',
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
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function in(array $ids) {
        $this->getDbCriteria()->addInCondition('id', $ids);
        return $this;
    }

    public function getDeliveryIds() {
        $ids=array();
        foreach($this->deliveries as $model) {
            array_push($ids, $model->id);
        }
        return $ids;
    }

    public function getCurrencyList() {
        return CHtml::listData(Currency::model()->findAll(),'id','name');
    }

    public function setDeliveryIds($ids) {
        $this->deliveries=empty($ids)?array():Delivery::model()->findAllByAttributes(array('id'=>$ids));
    }

    public function getHandlerList() {
        return array(
            'LiqPay'=>'Платежный сервис LiqPay',
            'Receipt'=>'Печать квитанции',
        );
    }

    public function getUrl() {
        $urlManager=(IS_BACKEND)?Yii::app()->frontendUrlManager:Yii::app()->urlManager;
        return $urlManager->createUrl('payment/view', array(
            'id'=>$this->id,
            'title'=>Yii::app()->translitFormatter->formatUrl($this->name)
        ));
    }

    public function getHandlerParams() {
        return unserialize($this->_handlerParams);
    }

    public function setHandlerParams($val) {
        $this->_handlerParams=serialize($val);
    }
}