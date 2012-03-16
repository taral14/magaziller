<?php

/**
 * This is the model class for table "{{scrap_template}}".
 *
 * The followings are the available columns in table '{{scrap_template}}':
 * @property integer $id
 * @property string $scrap_id
 * @property string $name
 * @property integer $use_image
 * @property integer $image_width
 * @property integer $image_height
 * @property integer $use_news
 * @property integer $use_product
 * @property integer $use_promotion
 * @property integer $use_category
 * @property integer $use_brand
 * @property integer $use_title
 * @property integer $use_content
 * @property integer $use_url
 * @property string $template
 */
class ScrapTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ScrapTemplate the static model class
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
		return '{{scrap_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, use_image, use_news, use_product, use_promotion, use_category, use_brand, use_title, use_content, use_url, template', 'required'),
			array('scrap_id, use_image, image_width, image_height, use_news, use_product, use_promotion, use_category, use_brand, use_title, use_content, use_url', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
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
            'scrap'=>array(self::BELONGS_TO, 'Scrap', 'scrap_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'scrap_id' => 'Слайдер',
			'name' => 'Название',
			'use_image' => 'Используется изображение',
            'image' => 'Изображение',
			'image_width' => 'Ширина',
			'image_height' => 'Высота',
            'use_news' => 'Используется новость',
            'use_product' => 'Используется товар',
            'use_promotion' => 'Используется акция',
            'use_category' => 'Используется категория',
            'use_brand' => 'Используется бренд',
			'use_title' => 'Используется заглавие',
			'use_content' => 'Используется контент',
            'use_url' => 'Используется URL',
			'template' => 'Текст шаблона',
		);
	}

    public function getHasList() {
        $list=array();
        if($this->use_image)
            array_push($list, 'image');
        if($this->use_news)
            array_push($list, 'news');
        if($this->use_product)
            array_push($list, 'product');
        if($this->use_title)
            array_push($list, 'title');
        if($this->use_content)
            array_push($list, 'content');
        if($this->use_promotion)
            array_push($list, 'promotion');
        if($this->use_category)
            array_push($list, 'category');
        if($this->use_brand)
            array_push($list, 'brand');
        if($this->use_url)
            array_push($list, 'url');
        return $list;
    }
}