<?php

/**
 * This is the model class for table "{{scrap}}".
 *
 * The followings are the available columns in table '{{scrap}}':
 * @property integer $id
 * @property string $name
 * @property string $route
 */
class Scrap extends CActiveRecord
{
    public $limit_items=1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Scrap the static model class
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
		return '{{scrap}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('limit_items, name', 'required'),
            array('limit_items', 'numerical', 'integerOnly'=>true, 'max'=>14),
            array('route', 'length', 'max'=>32),
            array('route', 'match', 'pattern'=>'#[a-z]+[0-9a-z]*\/[a-z]+[0-9a-z]*#'),
			array('name', 'length', 'max'=>255),
            //array('name', 'unique', 'message'=>'Такой слайдер уже есть'),
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
            'countItems'=>array(self::STAT, 'ScrapItem', 'scrap_id'),
            'items'=>array(self::HAS_MANY, 'ScrapItem', 'scrap_id'),
            'templates'=>array(self::HAS_MANY, 'ScrapTemplate', 'scrap_id'),
            'countTemplates'=>array(self::STAT, 'ScrapTemplate', 'scrap_id'),
		);
	}

    public function scopes()
    {
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
			'name' => 'Название',
            'route' => 'Маршрут URL',
            'limit_items' => 'Количество слайдов',
		);
	}

    public function getLimitItemsList() {
        return array_slice(range(0,30), 1);
    }

    public function getTemplatesList() {
        return CHtml::listData($this->templates, 'id', 'name');
    }

    public function afterSave() {
        parent::afterSave();
        if($this->limit_items>0 && $this->countItems!=$this->limit_items) {
            if($this->countItems>$this->limit_items) {
                $count=$this->countItems-$this->limit_items;
                Yii::app()->db->createCommand()->delete('{{scrap_item}}', "scrap_id=:sid ORDER BY id DESC LIMIT $count", array(':sid'=>$this->id));
            } else if($this->countItems<$this->limit_items) {
                $count=$this->limit_items-$this->countItems;
                for($i=0;$i<$count;$i++) {
                    $scrapItem=new ScrapItem;
                    $scrapItem->scrap_id=$this->id;
                    $scrapItem->save(false);
                }
            }
        }
    }

    public function getHasTemplates() {
        return $this->countTemplates>0;
    }
}