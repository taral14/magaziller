<?php

/**
 * This is the model class for table "{{price_list}}".
 *
 * The followings are the available columns in table '{{price_list}}':
 * @property integer $id
 * @property string $name
 * @property integer $currency_id
 * @property string $description
 * @property string $availability_true
 * @property string $availability_false
 * @property integer $upload_time
 * @property integer $status
 */
class PriceList extends CActiveRecord
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=2;

    const COLUMN_ARTICLE=1;
    const COLUMN_AVAILABILITY=2;
    const COLUMN_QUANTITY=3;
    const COLUMN_AVAILABILITY_QUANTITY=4;
    const COLUMN_PRICE=5;
    const COLUMN_INFORMATION=6;

    private $_columnsArray;

	/**
	 * Returns the static model of the specified AR class.
	 * @return PriceList the static model class
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
		return '{{price_list}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, status, currency_id', 'required'),
			array('upload_time, status, currency_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
            array('availability_true, availability_false', 'length', 'max'=>45),
            array('columns', 'filter', 'filter'=>array('CJSON', 'encode')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, upload_time, status', 'safe', 'on'=>'search'),
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
            'rows'=>array(self::HAS_MANY, 'PriceListRow', 'price_list_id'),
            'countRows'=>array(self::STAT, 'PriceListRow', 'price_list_id'),
            'currency'=>array(self::BELONGS_TO, 'Currency', 'currency_id'),
		);
	}

    public function getColumnsArray() {
        if($this->_columnsArray===null) {
            $columns=function_exists('json_decode')?json_decode($this->columns):CJSON::decode($this->columns);
            $this->_columnsArray=is_array($columns)?$columns:array();
        }
        return $this->_columnsArray;
    }

    public function getColumn($number) {


        return array_key_exists($number, $this->columnsArray)?$this->columnsArray[$number]:null;
    }

    public function getArticleColumn() {
        return array_search(self::COLUMN_ARTICLE, $this->columnsArray);
    }

    public function importRows(array $data) {
        foreach($data as $row) {
            $article=trim(CArray::get($row, $this->articleColumn));
            if(empty($article)) {
                continue;
            }
            $model=PriceListRow::model()->findByAttributes(array(
                'price_list_id'=>$this->id,
                'article'=>$article,
            ));
            if($model===null) {
                $model=new PriceListRow;
                $model->price_list_id=$this->id;
                $model->article=$article;
            }
            $this->updateRow($model, $row);
        }
    }

    public function updateRow(PriceListRow $model, array $data) {
        $model->availability=1;
        $model->quantity=0;
        foreach($this->columnsArray as $number=>$column) {
            switch($column) {
                case self::COLUMN_AVAILABILITY:
                    $find=CArray::get($data, $number, 0);
                    if($this->availability_true) {
                        $model->availability=($this->availability_true==$find)?1:0;
                    } else if($this->availability_false) {
                        $model->availability=($this->availability_false==$find)?0:1;
                    } else {
                        $model->availability=((int)$find>0)?1:0;
                    }
                    break;
                case self::COLUMN_QUANTITY:
                    $model->quantity=(int)CArray::get($data, $number, 0);
                    break;
                case self::COLUMN_AVAILABILITY_QUANTITY:
                    $model->quantity=(int)CArray::get($data, $number, 0);
                    $model->availability=$model->quantity>0;
                    break;
                case self::COLUMN_PRICE:
                    $price=CArray::get($data, $number, 0);
                    $price=str_replace(',', '.', $price);
                    $price=preg_replace('#[^0-9.]+#u', '', $price);
                    $model->price=Yii::app()->priceFormatter->convert((float)$price, true, $this->currency_id);
                    break;
                case self::COLUMN_INFORMATION:
                    $model->information=CArray::get($data, $number);
                    break;
            }
        }
        $model->upload_time=new CDbExpression('NOW()');
        $model->save();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
            'currency_id'=>'Валюта позиций прайса',
			'description' => 'Описание',
            'availability_true' => 'Наличие на складе',
            'availability_false' => 'Отсутствие на складе',
			'upload_time' => 'Время последней загрузки',
			'status' => 'Состояние',
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
		$criteria->compare('upload_time',$this->upload_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function getHasRows() {
        return $this->countRows>0;
    }
}