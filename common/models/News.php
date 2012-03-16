<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $id
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $publish_date
 * @property string $create_time
 * @property string $update_time
 */
class News extends CActiveRecord
{
    const STATUS_PUBLISHED=1;
    const STATUS_DRAFT=2;
    const STATUS_ARCHIVED=3;

    private $_oldTags;

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
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg'),
                    'small' => array('storage/news', Yii::app()->config['news_image_small_width'], Yii::app()->config['news_image_small_height'], 'required'=>'small.jpg', 'prefix'=>'small_'),
                    'large' => array('storage/news', Yii::app()->config['news_image_large_width'], Yii::app()->config['news_image_large_height'], 'prefix'=>'large_'/*'watermark'=>array('watermark.jpg', -10, -10, 'opacity'=>50)*/),
                ),
            ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'news/view',
                'params'=> array('id'=>$this->id),
            ),
  	    );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
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
		return '{{news}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".News::STATUS_PUBLISHED." OR $alias.status=".News::STATUS_ARCHIVED;

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
            array('tags, title', 'filter', 'filter'=>'strip_tags'),
            array('annotation, content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('title, annotation, content, status, publish_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
            array('tags', 'length', 'max'=>1024),
            array('tags', 'match', 'pattern'=>'/^[\w\s,0-9]+$/', 'message'=>'Теги могут содержать только символы и цифры.'),
            array('tags', 'normalizeTags'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, tags, status, publish_date, create_time, update_time', 'safe', 'on'=>'search'),
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
			'title' => 'Заглавие',
			'annotation' => 'Аннотация',
			'content' => 'Содержание',
			'status' => 'Состояние',
			'image' => 'Изображение',
            'tags' => 'Теги (через запятую)',
			'publish_date' => 'Дата публикации',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);

        if(is_array($this->publish_date) && isset($this->publish_date['from']) && isset($this->publish_date['till'])) {
            $criteria->compare('publish_date','>='.$this->publish_date['from']);
            $criteria->compare('publish_date','<='.$this->publish_date['till']);
        } else {
            $criteria->compare('publish_date',$this->publish_date,true);
        }

		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function last($limit=NULL)
    {
        $criteria['order']='publish_date DESC';
        if($limit)
            $criteria['limit']=$limit;
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function limit($limit) {
        $this->getDbCriteria()->mergeWith(array('limit'=>$limit));
        return $this;
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