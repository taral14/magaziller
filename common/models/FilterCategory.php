<?php

/**
 * This is the model class for table "{{filter_category}}".
 *
 * The followings are the available columns in table '{{filter_category}}':
 * @property integer $filter_id
 * @property integer $category_id
 * @property integer $position
 */
class FilterCategory extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return FilterCategory the static model class
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
        return '{{filter_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('filter_id, category_id, position', 'required'),
            array('filter_id, category_id, position', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('filter_id, category_id, position', 'safe', 'on'=>'search'),
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
            'filter'=>array(self::BELONGS_TO, 'Filter', 'filter_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'filter_id' => 'Filter',
            'category_id' => 'Category',
            'position' => 'Position',
        );
    }

    public function defaultScope() {
        $alias = $this->getTableAlias(false,false);
        return array(
            'order'=>"$alias.position",
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

        $criteria->compare('filter_id',$this->filter_id);
        $criteria->compare('category_id',$this->category_id);
        $criteria->compare('position',$this->position);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
}