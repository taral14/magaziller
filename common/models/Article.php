<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Article extends CActiveRecord
{
    const STATUS_PUBLISHED=1;
    const STATUS_DRAFT=2;

    private $_oldTags;

    public function behaviors(){
  	    return array(
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
  		    ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'article/view',
                'params'=> array('id'=>$this->id),
            )
  	    );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Article the static model class
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
		return '{{article}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array();

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Article::STATUS_PUBLISHED;

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
            array('content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('title, content, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
            array('status', 'in', 'range'=>Lookup::codes('ArticleStatus')),
			array('title', 'length', 'max'=>255),
            array('tags', 'length', 'max'=>1024),
            array('tags', 'match', 'pattern'=>'/^[\w\s,0-9]+$/', 'message'=>'Теги могут содержать только символы и цифры.'),
            array('tags', 'normalizeTags'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, tags, status', 'safe', 'on'=>'search'),
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
			'content' => 'Содержание',
            'tags' => 'Теги (через запятую)',
			'status' => 'Состояние',
			'create_time' => 'Добавлена',
			'update_time' => 'Изменена',
            'url' => 'URL адрес',
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

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'update_time DESC',
			),
		));
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