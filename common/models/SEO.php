<?php

/**
 * This is the model class for table "{{seo}}".
 *
 * The followings are the available columns in table '{{seo}}':
 * @property integer $id
 * @property string $route
 * @property string $entity
 * @property string $metaTitle
 * @property string $metaKeywords
 * @property string $metaDescription
 */
class SEO extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SEO the static model class
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
		return '{{seo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('metaTitle, metaKeywords, metaDescription, route', 'filter', 'filter'=>'strip_tags'),
            array('route', 'required'),
            array('metaTitle, metaKeywords, metaDescription', 'length', 'max'=>500),
            array('route', 'exist', 'className'=>'Lookup', 'attributeName'=>'code', 'criteria'=>array('condition'=>"type='SEORoute'"), 'message'=>'Недопустимое значение'),
            array('entity', 'numerical', 'integerOnly'=>true),
            array('metaTitle, metaKeywords, metaDescription, entity, route', 'safe', 'on'=>'search'),
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
			'route' => 'Route',
			'entity' => 'Связь',
			'metaTitle' => 'Meta Title',
			'metaKeywords' => 'Meta Keywords',
			'metaDescription' => 'Meta Description',
		);
	}

    public function findByRoute($route, $entity=null) {
        $criteria=new CDbCriteria;
        $criteria->compare('route', $route);
        if($entity)
            $criteria->compare('entity', $entity);
		return $this->query($criteria);
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

		$criteria->compare('route',$this->route);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('metaTitle',$this->metaTitle,true);
		$criteria->compare('metaKeywords',$this->metaKeywords,true);
		$criteria->compare('metaDescription',$this->metaDescription,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

}