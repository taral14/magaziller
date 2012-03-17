<?php

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property integer $id
 * @property string $shop_name
 * @property string $admin_email
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $contact_address
 * @property string $counters
 * @property integer $price_accuracy
 * @property integer $currency_default
 * @property integer $currency_basic
 * @property integer $product_show_absent
 * @property integer $product_catalog_limit
 * @property string $product_catalog_order
 * @property integer $product_search_limit
 * @property string $product_search_order
 * @property double $similar_price_accuracy
 * @property integer $news_catalog_limit
 */
class Config extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return Config the static model class
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
		return '{{config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        $image_size=array('integerOnly'=>true, 'min'=>16, 'max'=>1600);
        $html_purifier=array('filter'=>array(new CHtmlPurifier,'purify'));
        $product_order=array('range'=>array('price','price DESC','name','hit DESC','browse DESC'));

        return array(
            'shop_name' => array(
                'filter'=>array('filter'=>'strip_tags'),
                'required',
                'length'=>array('max'=>64)
            ),
            'company' => array(
                'filter'=>array('filter'=>'strip_tags'),
                'required',
                'length'=>array('max'=>255)
            ),
            'admin_email' => array(
                'required',
                'email',
                'length'=>array('max'=>255)
            ),
            'contact_email' => array(
                'required',
                'email',
                'length'=>array('max'=>255)
            ),
            'contact_phone' => array(
                'length'=>array('max'=>255)
            ),
            'contact_address' => array(
                'length'=>array('max'=>500)
            ),
            'main_text' => array(
                'filter'=>$html_purifier
            ),
            'contact_text' => array(
                'filter'=>$html_purifier
            ),
            'contact_map'=>array('safe'),
            'contact_use_captcha' => array('required', 'boolean'),
            'counters'=>array('safe'),
            'price_accuracy'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
            ),
            'currency_default'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
                'exist'=>array('className'=>'Currency', 'attributeName'=>'id', 'message'=>'Такой валюты не существует'),
            ),
            'currency_basic'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
                'exist'=>array('className'=>'Currency', 'attributeName'=>'id', 'message'=>'Такой валюты не существует'),
            ),
            'product_show_absent'=>array(
                'required',
                'boolean'
            ),
            'product_catalog_limit'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
            ),
            'product_catalog_order'=>array(
                'required',
                'in'=>$product_order
            ),
            'product_search_limit'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
            ),
            'product_search_order'=>array(
                'required',
                'in'=>$product_order
            ),
            // product
            'product_image_small_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'product_image_small_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'product_image_large_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'product_image_large_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            // brand
            'brand_image_small_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'brand_image_small_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'brand_image_large_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'brand_image_large_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            // category
            'category_image_small_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'category_image_small_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'category_image_large_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'category_image_large_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            // feature_pack
            'feature_pack_image_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'feature_pack_image_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            // news
            'news_image_small_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'news_image_small_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'news_image_large_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'news_image_large_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            // promotion
            'promotion_image_small_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'promotion_image_small_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'promotion_image_large_width'=>array(
                'required',
                'numerical'=>$image_size,
            ),
            'promotion_image_large_height'=>array(
                'required',
                'numerical'=>$image_size,
            ),

            'similar_price_accuracy'=>array(
                'required',
                'numerical'=>array('min'=>0.005, 'max'=>1),
            ),
            'news_catalog_limit'=>array(
                'required',
                'numerical'=>array('integerOnly'=>true),
            ),
            'mailing_new_order_to_admin'=>array(
                'required',
                'boolean'
            ),
            'mailing_new_order_to_user'=>array(
                'required',
                'boolean'
            ),
            'mailing_new_order_subject' => array(
                'filter'=>array('filter'=>'strip_tags'),
                'length'=>array('max'=>255)
            ),
            'mailing_new_order_pattern'=>array(
                'safe'
            ),
            'smsing_new_order_to_admin'=>array(
                'required',
                'boolean'
            ),
            'smsing_new_order_phones'=>array(
                'match'=>array('pattern'=>'#^\((068|039|050|067)\)[0-9]{3}-[0-9]{2}-[0-9]{2}(,\s*\((068|039|050|067)\)[0-9]{3}-[0-9]{2}-[0-9]{2})*$#', 'message'=>'Не верный формат записи телефонов'),
            ),
            'payment_required'=>array(
                'required',
                'boolean'
            ),
            'delivery_required'=>array(
                'required',
                'boolean'
            ),
            'vkontakte_api_id'=>array(
                'numerical'=>array('integerOnly'=>true),
                'length'=>array('max'=>11),
            ),
            'vkontakte_poll_id'=>array(
                'length'=>array('max'=>32),
            ),
            'enterprise_1c_login'=>array(
                'required',
                'length'=>array('min'=>3, 'max'=>32),
                'match'=>array('pattern'=>'#^[a-zA-Z]+[a-zA-Z0-9]*$#', 'message'=>'Логин должен состоять из латинских букв и цифр'),
            ),
            'enterprise_1c_password'=>array(
                'required',
                'length'=>array('min'=>6, 'max'=>255),
            ),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'shop_name' => 'Название интернет магазина',
            'company' => 'Полное наименование компании',
			'admin_email' => 'Основной E-mail',
			'contact_email' => 'Контактный E-mail',
            'contact_phone' => 'Контактный телефон',
            'contact_address' => 'Контактный адрес',
            'main_text' => 'Текст на главной',
            'contact_text' => 'Текст в контактах',
            'contact_map' => 'Код карты в контактах',
            'contact_use_captcha' => 'Используется капча',

			'counters' => 'Коды счетчиков',
			'price_accuracy' => 'Точность цены',
			'currency_default' => 'Валюта по умолчанию',
			'currency_basic' => 'Базовая валюта',

			'product_show_absent' => 'Показывать отсутствующие товары',
			'product_catalog_limit' => 'Товаров на страницу',
			'product_catalog_order' => 'Сортировка по умолчанию',
			'product_search_limit' => 'Товаров на страницу',
			'product_search_order' => 'Сортировка по умолчанию',
			'similar_price_accuracy' => 'Точность определения похожих товаров',
			'news_catalog_limit' => 'Новостей на страницу',

            // product
            'product_image_small' => 'Небольшое изображение товара',
            'product_image_large' => 'Большое изображение товара',
            'product_image_small_width' => 'Ширина',
            'product_image_small_height' => 'Высота',
            'product_image_large_width' => 'Ширина',
            'product_image_large_height' => 'Ширина',
            // brand
            'brand_image_small' => 'Небольшое изображение бренда',
            'brand_image_large' => 'Большое изображение бренда',
            'brand_image_small_width' => 'Ширина',
            'brand_image_small_height' => 'Высота',
            'brand_image_large_width' => 'Ширина',
            'brand_image_large_height' => 'Ширина',
            // category
            'category_image_small' => 'Небольшое изображение категории',
            'category_image_large' => 'Большое изображение категории',
            'category_image_small_width' => 'Ширина',
            'category_image_small_height' => 'Высота',
            'category_image_large_width' => 'Ширина',
            'category_image_large_height' => 'Ширина',
            // feature_pack
            'feature_pack_image' => 'Небольшое изображение группы характеристик',
            'feature_pack_image_width' => 'Ширина',
            'feature_pack_image_height' => 'Высота',
            // news
            'news_image_small' => 'Небольшое изображение новости',
            'news_image_large' => 'Большое изображение новости',
            'news_image_small_width' => 'Ширина',
            'news_image_small_height' => 'Высота',
            'news_image_large_width' => 'Ширина',
            'news_image_large_height' => 'Ширина',
            // promotion
            'promotion_image_small' => 'Небольшое изображение акции',
            'promotion_image_large' => 'Большое изображение акции',
            'promotion_image_small_width' => 'Ширина',
            'promotion_image_small_height' => 'Высота',
            'promotion_image_large_width' => 'Ширина',
            'promotion_image_large_height' => 'Ширина',


            'vkontakte_api_id' => 'Ключ API',
            'vkontakte_poll_id' => 'Идентификатор опроса',

            'mailing_new_order_to_admin' => 'Оповещать администратора на ел. почту при оформлении заказа',
            'mailing_new_order_to_user' => 'Оповещать клиента на ел. почту при оформлении заказа',
            'mailing_new_order_subject' => 'Тема сообщения которое получит пользователь оформив заказ',
            'mailing_new_order_pattern' => 'Шаблон сообщения которое получит пользователь оформив заказ',
            'payment_required' => 'Форма оплаты обязательна для заполнения',
            'delivery_required' => 'Способ доставки обязателен для заполнения',

            'smsing_new_order_to_admin' => 'Отправлять sms при оформлении заказа',
            'smsing_new_order_phones' => 'Телефоны на которые отправлять sms',

            'enterprise_1c_login'=>'Пользователь',
            'enterprise_1c_password'=>'Пароль',
        );
	}

    public function getCurrencyList() {
        return CHtml::listData(Currency::model()->findAll(),'id','name');
    }

    public function createValidators()
   	{
   		$validators=new CList;
   		foreach($this->rules() as $attribute=>$rules)
   		{
            foreach($rules as $rule=>$params) {
                if(is_int($rule)) {
                    $rule=$params;
                    $params=array();
                }
                $validators->add(CValidator::createValidator($rule,$this,$attribute,$params));
            }
   		}
   		return $validators;
   	}
}