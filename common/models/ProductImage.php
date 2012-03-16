<?php

/**
 * This is the model class for table "{{image}}".
 *
 * The followings are the available columns in table '{{image}}':
 * @property integer $id
 * @property string $filename
 * @property string $description
 * @property integer $product_id
 * @property integer $position
 */
class ProductImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Image the static model class
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
		return '{{product_image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('description','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('product_id', 'required'),
			array('position, product_id', 'numerical', 'integerOnly'=>true),
            array('product_id', 'exist', 'className'=>'Product', 'attributeName'=>'id', 'message'=>'Товара не существует'),
			array('filename', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
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

    public function behaviors(){
  	    return array(
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'filename',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 150, 150, 'resize'=>'fill', 'prefix'=>'product_'),
                    'small' => array('storage/product', Yii::app()->config['product_image_small_width'], Yii::app()->config['product_image_small_height'], 'prefix'=>'small_'),
                    'large' => array('storage/product', Yii::app()->config['product_image_large_width'], Yii::app()->config['product_image_large_height'], 'prefix'=>'large_'),
                ),
            ),
  	    );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'filename' => 'Filename',
			'description' => 'Description',
			'product_id' => 'Product',
		);
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(
            'order'=>"$alias.position",
        );

        return $scopes;
    }

}