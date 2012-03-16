<?php

/**
 * This is the model class for table "{{brand}}".
 *
 * The followings are the available columns in table '{{brand}}':
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 */
class Brand extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Brand the static model class
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
		return '{{brand}}';
	}

    public function behaviors(){
  	    return array(
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'brand/view',
                'params'=> array('id'=>$this->id),
            ),
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'image',
                'nameAttribute' => 'name',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg', 'prefix'=>'brand_'),
                    'small' => array('storage/brand', Yii::app()->config['brand_image_small_width'], Yii::app()->config['brand_image_small_height'], 'required'=>'small.jpg', 'prefix'=>'small_'),
                    'large' => array('storage/brand', Yii::app()->config['brand_image_large_width'], Yii::app()->config['brand_image_large_height'], 'prefix'=>'large_'),
                ),
            ),
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
            array('name', 'filter', 'filter'=>'strip_tags'),
            array('description','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
            array('name', 'required'),
            array('name', 'length', 'max'=>255),
            array('name', 'unique', 'message'=>'Такой бренд уже есть'),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
            'products'=>array(self::HAS_MANY, 'Product', 'brand_id'),
            'categories'=>array(self::HAS_MANY, 'Category', array('category_id'=>'id'), 'through'=>'products', 'group'=>'categories.id'),
            'countProducts'=>array(self::STAT, 'Product', 'brand_id'),
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
			'description' => 'Описание',
            'image' => 'Изображение',
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
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function findAllGroupByFirstLetters() {
        $this->beforeFind();
        $brands=array();
        $criteria=new CDbCriteria;
        $criteria->select='*, UPPER(LEFT(name,1)) AS letter';
        $criteria->order='name ASC';
        $command=$this->getCommandBuilder()->createFindCommand('{{brand}}',$criteria);
        foreach($command->queryAll() as $record)
            $brands[$record['letter']][]=$this->populateRecord($record);

		return $brands;
    }

    public function getCountCategories() {
        return count($this->categories);
    }

    public function getHasCategories() {
        return $this->countCategories>0;
    }

    public function getHasProducts() {
        return $this->countProducts>0;
    }
}