<?php

/**
 * This is the model class for table "{{feature_category}}".
 *
 * The followings are the available columns in table '{{feature_category}}':
 * @property integer $feature_id
 * @property integer $category_id
 * @property integer $position
 * @property integer $in_product
 * @property integer $in_summary
 * @property integer $in_compare
 */
class FeatureCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FeatureCategory the static model class
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
		return '{{feature_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('feature_id, category_id, position, in_detail, in_summary, in_compare', 'required'),
			array('feature_id, category_id, position, in_detail, in_summary, in_compare', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('feature_id, category_id, position, in_detail, in_summary, in_compare', 'safe', 'on'=>'search'),
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
            'feature'=>array(self::BELONGS_TO, 'Feature', 'feature_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'feature_id' => 'Feature',
			'category_id' => 'Category',
			'position' => 'Position',
			'in_detail' => 'In Product',
			'in_summary' => 'In Filter',
			'in_compare' => 'In Compare',
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

		$criteria->compare('feature_id',$this->feature_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('in_detail',$this->in_detail);
		$criteria->compare('in_summary',$this->in_summary);
		$criteria->compare('in_compare',$this->in_compare);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}