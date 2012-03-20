<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property integer $delivery_id
 * @property float $delivery_price
 * @property integer $payment_id
 * @property float $discountPrice
 * @property integer $status
 * @property integer $user_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $referer
 * @property string $search_terms
 * @property string $ip
 * @property string $salt
 * @property string $create_time
 * @property string $update_time
 */
class Order extends CActiveRecord
{
    const STATUS_NEW=1;
    const STATUS_PROCESSING=2;
    const STATUS_COMPLETE=3;
    const STATUS_DELETE=4;
    const STATUS_ABSENT=5;

    const PAYMENT_STATUS_NOT_PAID=1;
    const PAYMENT_STATUS_SUCCESS=2;
    const PAYMENT_STATUS_FAILURE=3;
    const PAYMENT_STATUS_WAIT_SECURE=4;

    private $_products;
    private $_payHandler;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Order the static model class
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
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules=array(
            array('name, phone, email, address, comment', 'filter', 'filter'=>'strip_tags'),
			array('name, phone, email, address', 'required'),
			array('payment_status, delivery_id, payment_id, status, user_id', 'numerical', 'integerOnly'=>true),
			array('delivery_price, discountPrice', 'numerical'),
            array('delivery_id', 'exist', 'className'=>'Delivery', 'attributeName'=>'id', 'message'=>'Такого способа доставки нету'),
            array('payment_id', 'exist', 'className'=>'Payment', 'attributeName'=>'id', 'message'=>'Такой формы оплаты нету'),
			array('name, address, phone, email', 'length', 'max'=>255),
            array('email', 'email'),
			array('ip', 'length', 'max'=>15),
            // установка значений полей по умолчанию
            array('payment_status', 'default', 'value'=>Order::PAYMENT_STATUS_NOT_PAID),
            array('status', 'default', 'value'=>Order::STATUS_NEW),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, delivery_id, delivery_price, payment_id, status, user_id, name, address, phone, email, comment, ip, create_time, update_time', 'safe', 'on'=>'search'),
		);

        if(Yii::app()->config['payment_required']) {
            $rules[]=array('payment_id', 'required');
        }

        if(Yii::app()->config['delivery_required']) {
            $rules[]=array('delivery_id', 'required');
        }

        return $rules;
	}

    public function behaviors(){
  	    return array(
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
  		    )
  	    );
    }

    public function defaultScope() {
        return array(
            'order'=>'create_time DESC',
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
            'delivery'=>array(self::BELONGS_TO, 'Delivery', 'delivery_id'),
            'payment'=>array(self::BELONGS_TO, 'Payment', 'payment_id'),
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'delivery_id' => 'Доставка',
			'delivery_price' => 'Стоимость доставки',
			'payment_id' => 'Оплата',
            'payment_status' => 'Состояние оплаты',
            'discountPrice' => 'Скидка',
			'status' => 'Состояние',
			'user_id' => 'Пользователь',
			'name' => 'Ф.И.О.',
			'phone' => 'Телефон',
			'email' => 'Ел. почта',
			'comment' => 'Комментарий',
			'ip' => 'IP адрес',
			'address' => 'Адрес',
			'create_time' => 'Поступление',
			'update_time' => 'Редактировался',
            'referer' => 'Пришел с сайта',
            'search_terms' => 'По запросу',
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
		$criteria->compare('delivery_id',$this->delivery_id);
		$criteria->compare('delivery_price',$this->delivery_price);
		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('ip',$this->ip,true);

        if(is_array($this->create_time) && isset($this->create_time['from']) && isset($this->create_time['till'])) {
            $criteria->compare('FROM_UNIXTIME(create_time)','>='.$this->create_time['from']);
            $criteria->compare('FROM_UNIXTIME(create_time)','<='.$this->create_time['till']);
        } else {
            $criteria->compare('FROM_UNIXTIME(create_time)',$this->create_time);
        }

        if(is_array($this->create_time) && isset($this->update_time['from']) && isset($this->update_time['till'])) {
            $criteria->compare('FROM_UNIXTIME(update_time)','>='.$this->update_time['from']);
            $criteria->compare('FROM_UNIXTIME(update_time)','<='.$this->update_time['till']);
        } else {
            $criteria->compare('FROM_UNIXTIME(update_time)',$this->update_time);
        }

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getEncodeKey() {
        if($this->isNewRecord)
            throw new CException('"encodeKey" еще не определен');
        return md5($this->salt . $this->id);
    }

    public function findByEncodeKey($key) {
        $criteria=$this->getCommandBuilder()->createCriteria("MD5(CONCAT(salt,id))=:key", array(
            ':key'=>$key
        ));
		return $this->query($criteria);
    }

    public function getCost($withDiscount = true) {
        $price=$this->delivery_price;
        foreach ($this->products as $product)
        {
            $price += $product->getSumPrice($withDiscount);
        }

        if($withDiscount)
            $price -= $this->discountPrice;

        return $price;
    }

    public function addProduct(Product $product) {
        if($product->asa('CartBehavior')==false) {
            throw new CException('Товар должен содержать поведение "CartBehavior"');
        }

        $sql="INSERT INTO {{order_product}} (order_id, product_id, price, discountPrice, quantity) VALUES (:order_id,:product_id,:price,:discountPrice,:quantity) " .
             "ON DUPLICATE KEY UPDATE price=:price, discountPrice=:discountPrice, quantity=:quantity";

        Yii::app()->db->createCommand($sql)->execute(array(
            ':order_id'=>$this->id,
            ':product_id'=>$product->id,
            ':price'=>$product->getOrderPrice(),
            ':discountPrice'=>$product->getDiscountPrice(),
            ':quantity'=>$product->getQuantity(),
        ));
    }

    public function getProducts() {
        if($this->_products==null) {
            $this->_products=array();

            $rows=Yii::app()->db->createCommand()
                ->select('t.*, t2.quantity, t2.price as orderPrice, t2.discountPrice')
                ->from('{{product}} as t')
                ->join('{{order_product}} as t2', 't2.product_id=t.id')
                ->where('t2.order_id=:id', array(':id'=>$this->id))
                ->queryAll();

            foreach($rows as $row) {
                $product=Product::model()->populateRecord($row);
                $product->attachBehavior("CartBehavior", new CartBehavior);
                $product->setQuantity($row['quantity']);
                $product->setOrderPrice($row['orderPrice']);
                $product->setDiscountPrice($row['discountPrice']);
                array_push($this->_products, $product);
            }
        }
        return $this->_products;
    }

    public function getCountProducts() {
        $count=0;
        foreach($this->products as $product)
            $count+=$product->quantity;
        return $count;
    }

    public function getHasProducts() {
        return $this->countProducts>0;
    }

    public function status($status) {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'status=:status',
            'params'=>array(
                ':status'=>$status
            )
        ));
        return $this;
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->salt=$this->generateSalt();
            }
            return true;
        }
        else
            return false;
    }
    
	protected function generateSalt()
	{
		return uniqid('',true);
	}

    public function getRefererHost() {
        return CArray::get(parse_url($this->referer), 'host');
    }

    public function getUrl() {
        return Yii::app()->createUrl('order/view', array('key'=>$this->encodeKey));
    }

    public function renderPayForm() {
        if($handler=$this->getPayHandler()) {
            return $handler->renderPayForm();
        }
        return '';
    }

    public function checkPayResponse($data) {
        if($handler=$this->getPayHandler()) {
            return $handler->renderPayForm();
        }
        return true;
    }

    public function getPayHandler() {
        if(empty($this->payment)) {
            return false;
        }
        if(empty($this->payment->handler)) {
            return false;
        }
        if($this->_payHandler===null) {
            $config=$this->payment->getHandlerParams();
            is_array($config) or $config=array();
            $config['class']=$this->payment->handler;
            $config['order']=$this;
            $this->_payHandler=Yii::createComponent($config);
        }
        return $this->_payHandler;
    }

    public function getPaymentsList() {
        return CHtml::listData($this->getPayments(), 'id', 'name');
    }

    public function getPayments() {
        if($this->delivery_id && $this->delivery) {
            return $this->delivery->payments;
        }
        return Payment::model()->findAll();
    }
}