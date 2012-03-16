<?php

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $small_width
 * @property integer $small_height
 * @property integer $large_width
 * @property integer $large_height
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Gallery extends CActiveRecord
{
    const STATUS_DISABLED=2;
    const STATUS_ENABLED=1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Gallery the static model class
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
		return '{{gallery}}';
	}

    public function behaviors(){
  	    return array(
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
  		    ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'gallery/view',
                'params'=> array('id'=>$this->id),
            )
  	    );
    }

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Gallery::STATUS_ENABLED;

        return $scopes;
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
			array('small_width, small_height', 'numerical', 'integerOnly'=>true, 'max'=>'800', 'min'=>'32', 'tooBig'=>'{attribute} должна быть меньше {max}', 'tooSmall'=>'{attribute} должна быть больше {min}'),
            array('large_width, large_height', 'numerical', 'integerOnly'=>true, 'max'=>'2000', 'min'=>'64'),
			array('name', 'length', 'max'=>255),
			array('status', 'numerical', 'integerOnly'=>true),
            array('status', 'in', 'range'=>Lookup::codes('GalleryStatus')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status', 'safe', 'on'=>'search'),
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
            'imagesCount'=>array(self::STAT, 'GalleryImage', 'gallery_id'),
            'images'=>array(self::HAS_MANY, 'GalleryImage', 'gallery_id'),
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
			'description' => 'Описание',
			'small_width' => 'Ширина превью',
			'small_height' => 'Высота превью',
			'large_width' => 'Ширина',
			'large_height' => 'Высота',
			'status' => 'Состояние',
			'create_time' => 'Добавлена',
			'update_time' => 'Изменена',
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
		$criteria->compare('small_width',$this->small_width);
		$criteria->compare('small_height',$this->small_height);
		$criteria->compare('large_width',$this->large_width);
		$criteria->compare('large_height',$this->large_height);
        $criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getHasImages() {
        return $this->imagesCount>0;
    }

    public function addImage(GalleryImage $image) {
        $image->gallery_id=$this->id;
        $image->save();
    }
}