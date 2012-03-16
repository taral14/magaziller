<?php

/**
 * This is the model class for table "{{promotion}}".
 *
 * The followings are the available columns in table '{{promotion}}':
 * @property integer $id
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property string $tags
 * @property string $image
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Promotion extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    private $_oldTags;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Promotion the static model class
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
		return '{{promotion}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);

        $scopes=array(
            'order'=>"$alias.create_time DESC"
        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".self::STATUS_ENABLED;

        return $scopes;
    }

    public function behaviors(){
  	    return array(
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
  		    ),
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'image',
                'nameAttribute' => 'title',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'storage/required/thumb.jpg', 'prefix'=>'promotion_'),
                    'small' => array('storage/promotion', Yii::app()->config['promotion_image_small_width'], Yii::app()->config['promotion_image_small_height'], 'required'=>'small.jpg', 'prefix'=>'small_'),
                    'large' => array('storage/promotion', Yii::app()->config['promotion_image_large_width'], Yii::app()->config['promotion_image_large_height'], 'prefix'=>'large_'),
                ),
            ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'promotion/view',
                'params'=> array('id'=>$this->id),
            ),
            'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior')
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
            array('tags, title', 'filter', 'filter'=>'strip_tags'),
            array('annotation, content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('title, annotation, content, status', 'required'),
            array('productNames', 'required'),
			array('status, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('title, image', 'length', 'max'=>255),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
            array('tags', 'length', 'max'=>1024),
            array('tags', 'match', 'pattern'=>'/^[\w\s,0-9]+$/', 'message'=>'Теги могут содержать только символы и цифры.'),
            array('tags', 'normalizeTags'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, annotation, content, tags, image, status, create_time, update_time', 'safe', 'on'=>'search'),
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
            'products'=>array(self::MANY_MANY, 'Product', '{{promotion_product}}(promotion_id,product_id)'),
            'countProducts'=>array(self::STAT, 'Product', '{{promotion_product}}(promotion_id,product_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'title' => 'Заглавие',
            'annotation' => 'Краткое описание',
            'content' => 'Полное описание',
            'tags' => 'Теги (через запятую)',
            'image' => 'Изображение',
            'status' => 'Состояние',
            'create_time' => 'Создана',
            'update_time' => 'Изменена',
            'productNames' => 'Применяется к товарам',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('annotation',$this->annotation,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status);

        if(is_array($this->create_time) && isset($this->create_time['from']) && isset($this->create_time['till'])) {
            $criteria->compare('create_time','>='.$this->create_time['from']);
            $criteria->compare('create_time','<='.$this->create_time['till']);
        } else {
            $criteria->compare('create_time',$this->create_time);
        }

		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getHasProducts() {
        return $this->countProducts>0;
    }

    public function getProductNames() {
        return implode(', ', CArray::pluck($this->products,'name'));
    }

    public function setProductNames($value) {
        $this->products=empty($value)?array():Product::model()->findAllByAttributes(array('name'=>array_map('trim',explode(',',$value))));
    }

    public function normalizeTags($attribute,$params)
   	{
   		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
   	}

    protected function afterFind()
   	{
   		parent::afterFind();
   		$this->_oldTags=$this->tags;
   	}

    protected function afterSave()
   	{
   		parent::afterSave();
   		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
   	}

    protected function afterDelete()
   	{
   		parent::afterDelete();
   		Tag::model()->updateFrequency($this->tags, '');
   	}

    public function containTag($tag) {
        if(empty($tag))
            return $this;
        $criteria=new CDbCriteria;
        $criteria->addSearchCondition('tags', $tag);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function containTags(array $tags) {
        if(empty($tags))
            return $this;

        $criteria=new CDbCriteria;
        foreach($tags as $tag)
            $criteria->addSearchCondition('tags', $tag, true, 'OR');
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

}