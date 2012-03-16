<?php

/**
 * This is the model class for table "{{scrap_item}}".
 *
 * The followings are the available columns in table '{{scrap_item}}':
 * @property integer $id
 * @property integer $scrap_id
 * @property integer $template_id
 * @property string $image
 * @property integer $product_id
 * @property integer $news_id
 * @property string $title
 * @property string $content
 */
class ScrapItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ScrapItem the static model class
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
		return '{{scrap_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_id, scrap_id', 'required'),
			array('template_id, scrap_id, brand_id, category_id, promotion_id, product_id, news_id', 'numerical', 'integerOnly'=>true),
			array('title, url', 'length', 'max'=>255),
			array('content', 'safe'),
		);
	}

    public function behaviors(){
  	    return array(
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'image',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg'),
                    'default' => array('storage/scrap', 400, 400, 'resize'=>'fill'),
                ),
            ),
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
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id'),
            'news'=>array(self::BELONGS_TO, 'News', 'news_id'),
            'brand'=>array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
            'promotion'=>array(self::BELONGS_TO, 'Promotion', 'promotion_id'),

            'template'=>array(self::BELONGS_TO, 'ScrapTemplate', 'template_id'),
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
            'template_id' => 'Шаблон',
			'image' => 'Изображение',
			'product_id' => 'Товар',
            'news_id' => 'Новость',
            'brand_id' => 'Бренд',
            'category_id' => 'Категория',
            'promotion_id' => 'Акция',
			'title' => 'Заголовок',
            'url' => 'URL адрес',
			'content' => 'Содержание',
		);
	}

    public function beforeValidate() {
        if(parent::beforeValidate()) {
            $validators=$this->getValidatorList();
            if($this->template) {
                $rules= array();

                if($this->template->use_image)
                    $rules[]=array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true);

                if($this->template->use_news)
                    $rules[]=array('news_id', 'required');

                if($this->template->use_product)
                    $rules[]=array('product_id', 'required');

                if($this->template->use_brand)
                    $rules[]=array('brand_id', 'required');

                if($this->template->use_category)
                    $rules[]=array('category_id', 'required');

                if($this->template->use_promotion)
                    $rules[]=array('promotion_id', 'required');

                if($this->template->use_title)
                    $rules[]=array('title', 'required');

                if($this->template->use_url)
                    $rules[]=array('url', 'required');

                foreach($rules as $rule)
                    $validators->add(CValidator::createValidator($rule[1],$this,$rule[0],array_slice($rule,2)));
            }
            return true;
        } else {
            return false;
        }
    }

    public function renderTemplate($data=array()) {
        $data['title']=$this->title;
        $data['content']=$this->content;
        $data['url']=$this->url;

        if($this->template->use_image) {
            $data['image_url']=$this->getImageUrl();
        }

        if($this->template->use_product)
            $data['product']=$this->product;

        if($this->template->use_news)
            $data['news']=$this->news;

        if($this->template->use_brand)
            $data['brand']=$this->brand;

        if($this->template->use_category)
            $data['category']=$this->category;

        if($this->template->use_promotion)
            $data['promotion']=$this->promotion;

        return Yii::app()->twig->render($this->template->template, $data);
    }
}