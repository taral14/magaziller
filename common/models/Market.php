<?php

/**
 * This is the model class for table "{{market}}".
 *
 * The followings are the available columns in table '{{market}}':
 * @property integer $id
 * @property string $name
 * @property integer $description_type
 * @property string $description
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Market extends CActiveRecord
{
    const STATUS_DISABLED=2;
    const STATUS_ENABLED=1;

    const TYPE_CUSTOM=1;
    const TYPE_SUMMARY=2;
    const TYPE_DESCRIPTION=3;
    const TYPE_NONE=4;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Market the static model class
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
		return '{{market}}';
	}

    public function behaviors(){
  	    return array(
  		    'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior'),
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
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
			array('description_type, name, status', 'required'),
			array('description_type, status, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
            array('name', 'match', 'pattern'=>'#^[a-zA-Z0-9]+$#', 'message'=>'Название должно содержать только латинские буквы и цифры'),
            array('name', 'unique'),
            array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, status, create_time, update_time', 'safe', 'on'=>'search'),
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
            'categories'=>array(self::MANY_MANY, 'Category', '{{market_category}}(market_id, category_id)'),
            //'products'=>array(self::HAS_MANY, 'Product', 'product_id', 'through'=>'categories'),
		);
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);

        $scopes=array(

        );

        if(IS_FRONTED)
            $scopes['condition']="$alias.status=".Market::STATUS_ENABLED;

        return $scopes;
    }

    public function getProducts() {
        $criteria=new CDbCriteria;
        $criteria->join='JOIN {{market_category}} AS t2 ON t2.category_id=t.category_id';
        $criteria->compare('t2.market_id', $this->id);
        return Product::model()->findAll($criteria);
    }

    public function hasCategory($id) {
        foreach($this->categories as $category)
            if($category->id==$id) return true;
        return false;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
            'description_type' => 'Вид описания',
			'description' => 'Описание',
			'status' => 'Состояние',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
            'url' => 'Адрес',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getUrl() {
        $urlManager=(IS_BACKEND)?Yii::app()->frontendUrlManager:Yii::app()->urlManager;
        return $urlManager->createUrl('market/view', array('name'=>$this->name));
    }

    public function getFilename() {
        return $this->name.'.xml';
    }
}