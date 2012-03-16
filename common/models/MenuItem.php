<?php

/**
 * This is the model class for table "{{menu_item}}".
 *
 * The followings are the available columns in table '{{menu_item}}':
 * @property integer $id
 * @property string $name
 * @property string $uri
 * @property integer $parent_id
 * @property integer $type
 * @property integer $level
 * @property integer $position
 */
class MenuItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MenuItem the static model class
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
		return '{{menu_item}}';
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
			array('name, uri, parent_id', 'required'),
			array('parent_id, level, position', 'numerical', 'integerOnly'=>true),
			array('name, uri', 'length', 'max'=>255),
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
        return array(
            'order'=>'position',
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
            'countChildren'=>array(self::STAT, 'MenuItem', 'parent_id'),
            'children'=>array(self::HAS_MANY, 'MenuItem', 'parent_id'),
            'parent'=>array(self::BELONGS_TO, 'MenuItem', 'parent_id'),
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
			'uri' => 'URL адрес',
			'parent_id' => 'Размещение',
			'level' => 'Вложенность',
			'position' => 'Порядок',
		);
	}

    public function getText() {
        return CHtml::link(CHtml::encode($this->name), array('update', 'id'=>$this->id));
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
            if($this->parent->isNewRecord) {
                $this->level = 0;
            } else {
                $this->level = $this->parent->level + 1;
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
                $this->position=self::model()->find($criteria)->position + 1;
            }
            return true;
        }
        else
            return false;
    }

    public function getHasChildren() {
        return $this->countChildren>0;
    }

    private $_neighbors;

    public function getNeighbors() {
        if($this->_neighbors==null) {
            if($this->isRooted) {
                $this->_neighbors=MenuItem::model()->rooted()->findAll();
            } else {
                $this->_neighbors=MenuItem::model()->findAllByAttributes(array(
                    'parent_id'=>$this->parent_id,
                ));
            }
        }
        return $this->_neighbors;
    }

    public function getIsRooted() {
        return empty($this->parent_id);
    }

    public function getRooted() {
        $parent=$this;
        while($parent->parent) {
            $parent=$parent->parent;
        }
        return $parent;
    }

    public function getUrl() {
        $urlManager=(IS_BACKEND)?Yii::app()->frontendUrlManager:Yii::app()->urlManager;
        if(empty($this->uri)) {
            return $urlManager->baseUrl;
        }

        if(strpos($this->uri, 'www.')===0 || strpos($this->uri, 'http://')===0) {
            return $this->uri;
        } else {
            return $urlManager->createUrl($this->uri);
        }
    }
}