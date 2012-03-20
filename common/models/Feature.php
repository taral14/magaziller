<?php

/**
 * This is the model class for table "{{feature}}".
 *
 * The followings are the available columns in table '{{feature}}':
 * @property string $pack_id
 * @property string $name
 * @property string $id_1c
 * @property string $alowed_values
 * @property string $unit
 * @property integer $status
 * @property integer $hide_name
 * @property integer $type
 * @property integer $unique
 * @property integer $required
 */
class Feature extends CActiveRecord
{
    const TYPE_STRING=1;
    const TYPE_FLOAT=2;
    const TYPE_INT=3;
    const TYPE_SELECT=4;
    const TYPE_BOOL=5;
    const TYPE_IMAGE=6;
    const TYPE_FILE=7;
    const TYPE_PRICE=8;
    const TYPE_COLOR=9;

    const IN_DETAIL='in_detail';
    const IN_SUMMARY='in_summary';
    const IN_COMPARE='in_compare';

    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    public $category_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Feature the static model class
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
		return '{{feature}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Feature::STATUS_ENABLED;

        return $scopes;
    }

    public function behaviors(){
  	    return array(
  		    'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior'),
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
            array('alowed_values, name, unit', 'filter', 'filter'=>'strip_tags'),
			array('pack_id, name, status, hide_name, type, unique, required', 'required'),
			array('pack_id, status, hide_name, type, unique, required', 'numerical', 'integerOnly'=>true),
            array('pack_id', 'exist', 'className'=>'FeaturePack', 'attributeName'=>'id', 'message'=>'Такой группы нету'),
            array('id_1c, name', 'length', 'max'=>255),
            array('name', 'uniqueName'),
            array('id_1c', 'unique', 'message'=>'Такое название уже используется'),
            array('unit', 'length', 'max'=>45),
            array('categoryIds', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, pack_id, name, alowed_values, unit, status, hide_name, type, unique, required', 'safe', 'on'=>'search'),
		);
	}

    public function uniqueName() {
        $model=Feature::model()->find('name=? AND pack_id=? AND id!=?',array($this->name, $this->pack_id, $this->id));
        if($model)
            $this->addError('name','Характеристика с таким названием уже есть.');
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'categories'=>array(self::MANY_MANY, 'Category', '{{feature_category}}(feature_id, category_id)'),
            'pack'=>array(self::BELONGS_TO, 'FeaturePack', 'pack_id'),
		);
	}

    public function hasCategory($id) {
        return in_array($id, $this->categoryIds);
    }

    public function getCategoryIds() {
        $ids = array();
        foreach($this->categories as $category) {
            array_push($ids, $category->id);
        }
        return $ids;
    }

    public function setCategoryIds($ids) {
        $this->categories=empty($ids)?array():Category::model()->findAllByAttributes(array('id'=>$ids));
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pack_id' => 'Группа',
			'name' => 'Название',
			'alowed_values' => 'Допустимые значения',
			'unit' => 'Ед. измерения',
			'status' => 'Состояние',
            'hide_name' => 'Скрывать название характеристики',
			'type' => 'Тип значения',
			'unique' => 'Уникальная',
			'required' => 'Обязательная',
            'category_id' => 'Категория',
            'id_1c' => 'Название в 1С',
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

        if($this->category_id) {
            $criteria->join="JOIN {{feature_category}} as t2 ON t2.feature_id=t.id";
            $criteria->compare('t2.category_id', $this->category_id);
        }

		$criteria->compare('pack_id',$this->pack_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alowed_values',$this->alowed_values,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('hide_name',$this->hide_name);
		$criteria->compare('type',$this->type);
		$criteria->compare('unique',$this->unique);
		$criteria->compare('required',$this->required);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getTrueValue() {
        return empty($this->selectValues[0])?'Да':$this->selectValues[0];
    }

    public function getFalseValue() {
        return empty($this->selectValues[1])?'Нет':$this->selectValues[1];
    }

    public function getSelectValues() {
        $values=array();
        foreach(explode("\n", $this->alowed_values) as $value) {
            $value=trim($value);
            empty($value) or $values[$value]=$value;
        }
        return $values;
    }

    public function getAttribute() {
        return 'feature'.$this->id;
    }

    public function getValueValidatorList() {
        $validators=new CList;

        $validators->add(CValidator::createValidator('length', $this, $this->attribute, array(
            'max'=>255,
            'message'=>'Характеристика "'.$this->name.'" должна быть короче 255 символов.',
        )));

        $validators->add(CValidator::createValidator('filter', $this, $this->attribute, array(
            'filter'=>'trim'
        )));

        if($this->unique) {
            $validators->add(CValidator::createValidator('unique', $this, $this->attribute, array(
                'className'=>'FeatureValue',
                'criteria'=>array(
                    'condition'=>'feature_id=:id',
                    'params'=>array(':id'=>$this->id),
                ),
                'attributeName'=>'value',
                'message'=>'Характеристика "'.$this->name.'" должна содержать уникальное значение.'
            )));
        }

        if($this->required) {
            $validators->add(CValidator::createValidator('required', $this, $this->attribute, array(
                'message'=>'Характеристика "'.$this->name.'" обязательна для заполнения.'
            )));
        }

        switch($this->type) {
            case Feature::TYPE_INT:
                    $validators->add(CValidator::createValidator('numerical', $this, $this->attribute, array(
                        'integerOnly'=>true,
                        'message'=>'Характеристика "'.$this->name.'" должна быть целым числом.'
                    )));
                break;
            case Feature::TYPE_FLOAT:
            case Feature::TYPE_PRICE:
                    $validators->add(CValidator::createValidator('numerical', $this, $this->attribute, array(
                        'message'=>'Характеристика "'.$this->name.'" должна быть числом.'
                    )));
                break;
            case Feature::TYPE_SELECT:
                    $validators->add(CValidator::createValidator('in', $this, $this->attribute, array(
                        'on'=>$this->selectValues,
                        'message'=>'Характеристика "'.$this->name.'" должна быть из списка.'
                    )));
                break;
        }

        return $validators;
    }
}