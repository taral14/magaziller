<?php

/**
 * This is the model class for table "{{filter}}".
 *
 * The followings are the available columns in table '{{filter}}':
 * @property integer $id
 * @property string $name
 * @property string $attribute
 * @property integer $type
 * @property string $alowed_values
 * @property integer $category_id
 * @property integer $position
 */
class Filter extends CActiveRecord
{
    const TYPE_INPUT=1;
    const TYPE_SELECT=2;
    const TYPE_SLIDER=3;
    const TYPE_RANGE=4;
    const TYPE_LINKS=5;
    const TYPE_CHECKBOX=6;
    const TYPE_RANGE_SLIDER=7;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Filter the static model class
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
		return '{{filter}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, attribute, type, category_id', 'required'),
			array('type, category_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('attribute', 'length', 'max'=>32),
			array('alowed_values', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, attribute, type, alowed_values, category_id', 'safe', 'on'=>'search'),
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
            'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'attribute' => 'Атрибут',
			'type' => 'Тип',
			'alowed_values' => 'Допустимые значения',
			'category_id' => 'Категория',
			'position' => 'Position',
		);
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(
            'order'=>"$alias.position",
        );

        return $scopes;
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
		$criteria->compare('attribute',$this->attribute,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('alowed_values',$this->alowed_values,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getAttributeList() {
        $list=array(
            'id'=>'ID товара',
            'name'=>'Название',
            'brand_id'=>'Бренд',
            'status'=>'Состояние',
            'price'=>'Цена',
        );

        if($this->category_id) {
            foreach($this->category->features as $feature) {
                $list[$feature->attribute]=$feature->pack->name.': '.$feature->name;
            }
        }

        return $list;
    }

    public function getTypeList() {
        $select_list=array(
            self::TYPE_SELECT=>Lookup::item('FilterType', self::TYPE_SELECT),
            self::TYPE_LINKS=>Lookup::item('FilterType', self::TYPE_LINKS),
            self::TYPE_CHECKBOX=>Lookup::item('FilterType', self::TYPE_CHECKBOX),
        );
        $range_list=array(
            self::TYPE_SLIDER=>Lookup::item('FilterType', self::TYPE_SLIDER),
            self::TYPE_RANGE=>Lookup::item('FilterType', self::TYPE_RANGE),
            self::TYPE_RANGE_SLIDER=>Lookup::item('FilterType', self::TYPE_RANGE_SLIDER),
        );
        $equal_list=array(
            self::TYPE_INPUT=>Lookup::item('FilterType', self::TYPE_INPUT),
        );


        if(in_array($this->attribute, array('id', 'name'))) {
            return $equal_list;
        }

        if(in_array($this->attribute, array('brand_id', 'status'))) {
            return $select_list;
        }

        if(in_array($this->attribute, array('price'))) {
            return $range_list;
        }

        if(preg_match('#^feature([0-9]+)$#', $this->attribute, $matches)==false) {
            return array();
        }

        $feature=Feature::model()->findByPk($matches[1]);

        if($feature==false) {
            return array();
        }

        switch($feature->type) {
            case Feature::TYPE_STRING:
                return $equal_list;
                break;
            case Feature::TYPE_BOOL:
            case Feature::TYPE_SELECT:
                return $select_list;
                break;
            case Feature::TYPE_FLOAT:
            case Feature::TYPE_INT:
            case Feature::TYPE_PRICE:
                return $range_list;
                break;
        }

        return array();
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord) {
                $criteria=new CDbCriteria;
                $criteria->select='position';
                $criteria->order = 'position DESC';
                if($model=self::model()->find($criteria))
                    $this->position=$model->position + 1;
                else
                    $this->position=0;
            }
            return true;
        }
        else
            return false;
    }

    public function getSelectValues() {
        $values=array();
        foreach(explode("\n", $this->alowed_values) as $value) {
            $value=trim($value);
            if(empty($value)) {
                continue;
            }
            if(strpos($value, '=')===false) {
                $values[$value]=$value;
            } else {
                list($key, $value)=explode('=',$value);
                $values[$key]=$value;
            }
        }
        return $values;
    }

    public function getFromValue() {
        return max((int)CArray::get(explode("\n", $this->alowed_values), 0), 0);
    }

    public function getTillValue() {
        return max((int)CArray::get(explode("\n", $this->alowed_values), 1), 1);
    }

    public function createField($params) {
        is_array($params) or $params=array();
        $fieldName='Product['.$this->attribute.']';
        $value=isset($params['Product'][$this->attribute])?$params['Product'][$this->attribute]:null;

        $field='';
        switch($this->type) {
            case Filter::TYPE_INPUT:
                $field=CHtml::textField($fieldName, $value);
                break;
            case Filter::TYPE_LINKS:
                is_array($value) or $value=array($value);
                $route=Yii::app()->controller->route;
                $i=0;
                foreach($this->selectValues as $fieldValue=>$fieldLabel) {
                    $link_params=$params;
                    if(in_array($fieldValue, $value)) {
                        $field.=CHtml::hiddenField($fieldName."[$i]", $fieldValue);
                        unset($link_params['Product'][$this->attribute][$i]);
                        $field.=CHtml::link($fieldLabel, array($route)+$link_params, array('class'=>'active'));
                    } else {
                        $link_params['Product'][$this->attribute][$i]=$fieldValue;
                        $field.=CHtml::link($fieldLabel, array($route)+$link_params);
                    }
                    $i++;
                }
                break;
            case Filter::TYPE_CHECKBOX:
                $values=is_array($value)?$value:array($value);
                foreach($this->selectValues as $fieldValue=>$fieldLabel) {
                    $field.=CHtml::openTag('label');
                    $field.=CHtml::checkBox($fieldName.'[]', in_array($fieldValue,$values), array('uncheckValue'=>null, 'value'=>$fieldValue));
                    $field.=' '.$fieldLabel;
                    $field.=CHtml::closeTag('label');
                    $field.=CHtml::tag('br');
                }
                break;
            case Filter::TYPE_RANGE:
                $field='от '.CHtml::textField($fieldName.'[from]', CArray::get($value, 'from'), array('size'=>5));
                $field.=' до '.CHtml::textField($fieldName.'[till]', CArray::get($value, 'till'), array('size'=>5));
                break;
            case Filter::TYPE_SELECT:
                $field=CHtml::dropDownList($fieldName, $value, $this->selectValues, array('empty'=>''));
                break;
            case Filter::TYPE_RANGE_SLIDER:
                $from=isset($value['from'])?max((int)$value['from'], $this->FromValue):$this->FromValue;
                $till=isset($value['till'])?min((int)$value['till'], $this->TillValue):$this->TillValue;

                $idFrom=CHtml::getIdByName($fieldName.'[from]');
                $idTill=CHtml::getIdByName($fieldName.'[till]');
                $id=CHtml::getIdByName($fieldName);

                $field=CHtml::textField($fieldName.'[from]', $from, array(
                    'size'=>3,
                    'maxlength'=>strlen($this->TillValue),
                    'onchange'=>"$('#$id').slider('values', [$('#$idFrom').val(), $('#$idTill').val()])",
                ));
                $field.=' - ';
                $field.=CHtml::textField($fieldName.'[till]', $till, array(
                    'size'=>3,
                    'maxlength'=>strlen($this->TillValue),
                    'onchange'=>"$('#$id').slider('values', [$('#$idFrom').val(), $('#$idTill').val()])",
                ));
                $field.=Yii::app()->controller->widget('zii.widgets.jui.CJuiSlider', array(
                    'options'=>array(
                        'range'=>true,
                        'min'=>$this->FromValue,
                        'max'=>$this->TillValue,
                        'values'=>array($from, $till),
                        'slide'=>"js:function(event, ui){
                            $('#$idFrom').val(ui.values[0]);
                            $('#$idTill').val(ui.values[1]);
                        }",
                    ),
                    'htmlOptions'=>array(
                        'id'=>$id,
                    )
                ),true);
                break;
            case Filter::TYPE_SLIDER:
                $from=isset($value['from'])?max((int)$value['from'], $this->FromValue):$this->FromValue;
                $till=isset($value['till'])?min((int)$value['till'], $this->TillValue):$this->TillValue;

                $idFrom=CHtml::getIdByName($fieldName.'[from]');
                $idTill=CHtml::getIdByName($fieldName.'[till]');
                $id=CHtml::getIdByName($fieldName);

                $field=CHtml::hiddenField($fieldName.'[from]', $from);
                $field.=CHtml::hiddenField($fieldName.'[till]', $till);
                $field.=CHtml::tag('div', array('id'=>$id), "$from - $till");
                $field.=Yii::app()->controller->widget('zii.widgets.jui.CJuiSlider', array(
                    'options'=>array(
                        'range'=>true,
                        'min'=>$this->FromValue,
                        'max'=>$this->TillValue,
                        'values'=>array($from, $till),
                        'slide'=>"js:function(event, ui){
                            $('#$idFrom').val(ui.values[0]);
                            $('#$idTill').val(ui.values[1]);
                            $('#$id').text(ui.values[0]+' - '+ui.values[1]);
                        }",
                    ),
                ),true);
                break;
        }
        return $field;
    }
}