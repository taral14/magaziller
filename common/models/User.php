<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property integer $group_id
 * @property string $salt
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $comment
 * @property integer $status
 */
class User extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    const ROLE_CLIENT='client';
    const ROLE_MANAGER='manager';
    const ROLE_CONTENT='content';
    const ROLE_ADMIN='admin';

    public $rPassword;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            // register, changePassword
            array('password, rPassword', 'required', 'on'=>'register, changePassword'),
            array('password', 'length', 'min'=>6, 'on'=>'register, changePassword'),
            array('password', 'length', 'max'=>128, 'on'=>'register, changePassword'),
            array('rPassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Не верное подтверждение пароля', 'on'=>'register, changePassword'),
            array('password', 'filter', 'filter'=>array($this, 'hashPassword'), 'on'=>'register, changePassword'),
            // register
			array('username', 'required', 'on'=>'register'),
            array('username', 'length', 'min'=>3, 'on'=>'register'),
			array('username', 'length', 'max'=>128, 'on'=>'register'),
            array('username', 'match', 'pattern'=>'#^[a-z0-9]+$#i', 'message'=>'Можно использовать только латинские буквы и цифры', 'on'=>'register'),
            array('username', 'match', 'pattern'=>'#^[a-z][a-z0-9]+$#i', 'message'=>'Первой должна идти латинская буква', 'on'=>'register'),
            array('username', 'unique', 'on'=>'register'),

			array('role, email, status', 'required'),
            array('phone, comment, address', 'filter', 'filter'=>'strip_tags'),
			array('group_id, status', 'numerical', 'integerOnly'=>true),
            array('group_id', 'exist', 'className'=>'Group', 'attributeName'=>'id', 'message'=>'Такой группы нету'),
			array('email', 'length', 'max'=>128),
            array('email', 'email'),
            array('email', 'unique'),
			array('role', 'in', 'range'=>array('client','manager','content','admin')),
			array('phone, address', 'length', 'max'=>255),
			array('comment', 'safe'),
            array('status', 'default', 'value'=>User::STATUS_ENABLED),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, role, group_id, email, phone, address, comment, status', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'user_id'),
            'group'=>array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Логин',
			'password' => 'Пароль',
            'rPassword' => 'Подтверждение пароля',
			'role' => 'Права доступа',
			'group_id' => 'Группа',
			'salt' => 'Salt',
			'email' => 'E-mail',
			'phone' => 'Телефон',
			'address' => 'Адрес',
			'comment' => 'Коментарий',
			'status' => 'Состояние',
            'authoriz_time' => 'Посещение',
            'create_time' => 'Зарегестрирован',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password)===$this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @param string salt
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return md5($this->salt.$password);
	}
}