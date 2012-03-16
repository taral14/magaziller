<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $level
 * @property string $description
 * @property string $image
 * @property integer $position
 * @property integer $status
 */
class Category extends CActiveRecord
{
    const STATUS_DISABLED=2;
    const STATUS_ENABLED=1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return '{{category}}';
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
                'nameAttribute' => 'name',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg', 'prefix'=>'category_'),
                    'small' => array('storage/category', Yii::app()->config['category_image_small_width'], Yii::app()->config['category_image_small_height'], 'required'=>'small.jpg', 'prefix'=>'small_'),
                    'large' => array('storage/category', Yii::app()->config['category_image_large_width'], Yii::app()->config['category_image_large_height'], 'prefix'=>'large_'),
                ),
            ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'category/view',
                'params'=> array('id'=>$this->id),
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
			array('name, status', 'required'),
			array('parent_id, level, position, status', 'numerical', 'integerOnly'=>true),
            array('parent_id', 'exist', 'className'=>'Category', 'attributeName'=>'id', 'message'=>'Такой категории нету'),
			array('name', 'length', 'max'=>255),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent_id, level, position, status', 'safe', 'on'=>'search'),
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
            'countChildren'=>array(self::STAT, 'Category', 'parent_id'),
            'countProducts'=>array(self::STAT, 'Product', 'category_id'),
            'children'=>array(self::HAS_MANY, 'Category', 'parent_id'),
            'parent'=>array(self::BELONGS_TO, 'Category', 'parent_id'),
            'products'=>array(self::HAS_MANY, 'Product', 'category_id'),
            'features'=>array(self::MANY_MANY, 'Feature', '{{feature_category}}(category_id, feature_id)',
                                'order'=>'features_features.position',
                                'condition'=>'features.status=:status',
                                'params'=>array(':status'=>Feature::STATUS_ENABLED),
            ),
            'featureCategories'=>array(self::HAS_MANY, 'FeatureCategory', 'category_id', 'index'=>'feature_id',),
            'filters'=>array(self::HAS_MANY, 'Filter', 'category_id'),
            'countFilters'=>array(self::STAT, 'Filter', 'category_id'),

            'brands'=>array(self::HAS_MANY, 'Brand', array('brand_id'=>'id'), 'through'=>'products', 'group'=>'brands.id'),
        );
	}

    public function getNeighbors() {
        return $this->neighbors();
    }

    public function neighbors($addCriteria=null) {
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', $this->parent_id);
        if($addCriteria) {
            $criteria->mergeWith($addCriteria);
        }
        return self::model()->findAll($criteria);
    }

    public function getBrands() {
        $criteria=new CDbCriteria;
        $criteria->compare('p.category_id', $this->id);
        $criteria->join='JOIN {{product}} as p ON p.brand_id=t.id';
        $criteria->distinct='p.id';
        return Brand::model()->findAll($criteria);
    }


    public function getIsRooted() {
        return empty($this->parent_id);
    }

    public function isFeatureEnabled(Feature $feature, $in) {
        return !empty($this->featureCategories[$feature->id]->$in);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'parent_id' => 'Родитель',
			'level' => 'Вложенность',
			'description' => 'Описание',
			'image' => 'Изображение',
			'position' => 'Порядок',
			'status' => 'Состояние',
            'countProducts' => 'Кол. товаров',
		);
	}

    public function scopes()
    {
        return array(
            'rooted'=>array(
                'condition'=>'parent_id IS NULL'
            )
        );
    }

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);
        $scopes=array(
            'order'=>"$alias.position",
        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Category::STATUS_ENABLED;

        return $scopes;
    }

    public function getText() {
        return CHtml::link(CHtml::encode($this->name), array('category/update', 'id'=>$this->id));
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeDelete() {
        if(parent::beforeDelete()) {
            self::model()->deleteAll('parent_id=:parent_id', array('parent_id'=>$this->id));
            return true;
        } else {
            return false;
        }
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->parent_id) {
                $this->level = $this->parent->level + 1;
            } else {
                $this->level = 0;
            }
            if($this->isNewRecord) {
                $criteria=new CDbCriteria;
                $criteria->select='position';
                $criteria->order = 'position DESC';
                if($this->parent_id) {
                    $criteria->condition='parent_id=:parent_id';
                    $criteria->params=array(':parent_id'=>$this->parent_id);
                } else {
                    $criteria->condition='parent_id IS NULL';
                }
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

    public function getCountFeatures() {
        return count($this->features);
    }

    public function getHasProducts() {
        return $this->countProducts>0;
    }

    public function getHasChildren() {
        return $this->countChildren>0;
    }

    public function getHasFeatures() {
        return $this->countFeatures>0;
    }

    public function getHasFilters() {
        return $this->countFilters>0;
    }

    public function getCountBrands() {
        return count($this->brands);
    }

    public function getHasBrands() {
        return $this->countBrands>0;
    }

    public function getFeatures($scope=null) {
        $criteria=new CDbCriteria;

        if(IS_FRONTED) {
            $criteria->compare('t.status', Feature::STATUS_ENABLED);
        }
        $criteria->join.=' JOIN {{feature_category}} as fc ON fc.feature_id=t.id';
        $criteria->compare('fc.category_id', $this->id);
        $criteria->order='fc.position';
        switch($scope) {
            case Feature::IN_COMPARE:
                $criteria->addCondition('fc.in_compare=1');
                break;
            case Feature::IN_DETAIL:
                $criteria->addCondition('fc.in_detail=1');
                break;
            case Feature::IN_SUMMARY:
                $criteria->addCondition('fc.in_summary=1');
                break;
        }

        return Feature::model()->findAll($criteria);
    }

}