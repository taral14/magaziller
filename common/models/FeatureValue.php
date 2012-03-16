<?php

/**
 * This is the model class for table "{{feature_value}}".
 *
 * The followings are the available columns in table '{{feature_value}}':
 * @property integer $attribute
 * @property integer $product_id
 * @property string $value
 */
class FeatureValue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FeatureValue the static model class
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
		return '{{feature_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(

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
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id'),
            'feature'=>array(self::BELONGS_TO, 'Feature', 'attribute'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attribute' => 'Feature',
			'product_id' => 'Product',
			'value' => 'Значение',
		);
	}

    public function getIsEmpty() {
        return empty($this->value);
    }

    public function findValues($feature_id) {
        $query=Yii::app()->db->createCommand()
            ->select('value')
            ->from('{{feature_value}}')
            ->where('feature_id=:fid', array(':fid'=>$feature_id))
            ->group('value')
            ->queryAll();
        return CArray::pluck($query, 'value');
    }
}