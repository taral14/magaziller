<?php

/**
 * This is the model class for table "{{currency}}".
 *
 * The followings are the available columns in table '{{currency}}':
 * @property integer $id
 * @property string $name
 * @property string $prefix
 * @property string $suffix
 * @property string $code
 * @property double $ratio_from
 * @property double $ratio_to
 * @property integer $position
 */
class Currency extends CActiveRecord
{
    protected static $_items;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Currency the static model class
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
		return '{{currency}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, prefix, suffix, code', 'filter', 'filter'=>'strip_tags'),
			array('name', 'required'),
            array('name', 'unique', 'message'=>'Такая валюта уже есть'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('ratio_from, ratio_to', 'numerical'),
			array('name, prefix, suffix', 'length', 'max'=>20),
			array('code', 'length', 'max'=>3),
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
			'prefix' => 'Префикс',
			'suffix' => 'Суффикс',
			'code' => 'Код ISO',
			'ratio_from' => 'Курс от',
			'ratio_to' => 'Курс к',
			'position' => 'Порядок',
		);
	}

    public static function item($id)
    {
        self::$_items===NULL and self::loadItems();
        return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }

	private static function loadItems()
	{
		self::$_items=array();
		$models=self::model()->findAll();
		foreach($models as $model)
			self::$_items[$model->id]=$model;
	}

}