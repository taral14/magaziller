<?php

/**
 * This is the model class for table "{{discount}}".
 *
 * The followings are the available columns in table '{{discount}}':
 * @property integer $id
 * @property string $name
 * @property string $handler
 * @property string $_handlerParams
 * @property double $rate
 * @property integer $rate_type
 * @property string $start_date
 * @property string $finish_date
 */
class Discount extends CActiveRecord
{
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, handler, rate, rate_type', 'required'),
			array('rate_type', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('handler', 'length', 'max'=>32),
			array('_handlerParams, start_date, finish_date', 'safe'),
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
			'name' => 'Name',
			'handler' => 'Handler',
			'_handlerParams' => 'Handler Params',
			'rate' => 'Rate',
			'rate_type' => 'Rate Type',
			'start_date' => 'Start Date',
			'finish_date' => 'Finish Date',
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
		$criteria->compare('handler',$this->handler,true);
		$criteria->compare('_handlerParams',$this->_handlerParams,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('rate_type',$this->rate_type);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('finish_date',$this->finish_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}