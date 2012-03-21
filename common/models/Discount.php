<?php

/**
 * This is the model class for table "{{discount}}".
 *
 * The followings are the available columns in table '{{discount}}':
 * @property integer $id
 * @property string $name
 * @property string $handler
 * @property string $_handlerParams
 * @property float $rate
 * @property integer $rate_type
 * @property integer $status
 * @property string $start_date
 * @property string $finish_date
 */
class Discount extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    const RATE_PERCENT=1;
    const RATE_NUMBER=2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Discount the static model class
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
		return '{{discount}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array();

        if(IS_FRONTED) {
            $scopes['condition']="$alias.status=:status AND $alias.start_date<=:date AND $alias.finish_date>=:date";
            $scopes['params']=array(
                ':date'=>date('Y-m-d'),
                ':status'=>Discount::STATUS_ENABLED
            );
        }

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
			array('name, handler, rate, rate_type, status, start_date, finish_date', 'required'),
			array('rate_type, status', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('handler', 'length', 'max'=>32),
			array('handlerParams', 'safe'),
            array('start_date, finish_date', 'date', 'format'=>'yyyy-mm-dd'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, handler, _handlerParams, rate, rate_type, start_date, finish_date', 'safe', 'on'=>'search'),
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
			'handler' => 'Обработчик скидки',
			'_handlerParams' => 'Параметры обработчика',
			'rate' => 'Величина скидки',
			'rate_type' => 'Тип скидки',
            'status' => 'Состояние',
			'start_date' => 'Дата начала скидки',
			'finish_date' => 'Дата конца скидки',
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
		$criteria->compare('handler',$this->handler);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('rate_type',$this->rate_type);
        $criteria->compare('status',$this->status);

        if($this->start_date)
		    $criteria->compare('start_date','<='.$this->start_date);
		if($this->finish_date)
            $criteria->compare('finish_date','>='.$this->finish_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getHandlerList() {
        return array(
            'QuantityDiscount'=>'Скидка после определенного количества товаров в корзине',
            /*'GroupDiscount'=>'Скидка на группу пользователей',
            'BuyTogetherDiscount'=>'Скидка на покупку некоторых товаров вместе',
            'CouponDiscount'=>'Купоны на получение скидки',*/
            // TODO сделать скидки на остальные обработчики
        );
    }

    public function getHandlerParams() {
        return unserialize($this->_handlerParams);
    }

    public function setHandlerParams($val) {
        $this->_handlerParams=serialize($val);
    }
}