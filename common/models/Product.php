<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $name
 * @property double $other_price
 * @property double $price
 * @property string $image
 * @property string $summary
 * @property string $description
 * @property integer $category_id
 * @property integer $brand_id
 * @property integer $status
 * @property integer $hit
 * @property integer $shopwindow
 * @property integer $browse
 * @property integer $priority
 */
class Product extends CActiveRecord
{
    const STATUS_ABSENT=3;
    const STATUS_DISABLED=2;
    const STATUS_ENABLED=1;

    private $_feature_values;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{product}}';
	}

    public function defaultScope() {
        $alias=$this->getTableAlias(false,false);

        $scopes=array(

        );

        if(IS_FRONTED) {
            if(Yii::app()->config['product_show_absent'])
                $scopes['condition']="$alias.status IN(".Product::STATUS_ENABLED.",".Product::STATUS_ABSENT.")";
            else
                $scopes['condition']="$alias.status=".Product::STATUS_ENABLED;

            $scopes['order']="$alias.priority DESC";
        }
        
        return $scopes;
    }

    public function behaviors(){
  	    return array(
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'image',
                'nameAttribute' => 'name',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg'),
                    'small' => array('storage/product', Yii::app()->config['product_image_small_width'], Yii::app()->config['product_image_small_height'], 'required'=>'small.jpg', 'prefix'=>'small_'),
                    'large' => array('storage/product', Yii::app()->config['product_image_large_width'], Yii::app()->config['product_image_large_height'], 'prefix'=>'large_'),
                ),
            ),
  		    'CTimestampBehavior' => array(
  		  	    'class' => 'zii.behaviors.CTimestampBehavior',
  		  	    'createAttribute' => 'create_time',
  			    'updateAttribute' => 'update_time',
  		    ),
            'SEOBehavior' => array(
                'class' => 'SEOBehavior',
                'route' => 'product/view',
                'params'=> array('id'=>$this->id),
            ),
            'CAdvancedArBehavior' => array('class' => 'CAdvancedArBehavior')
  	    );
    }

    public function scopes()
    {
        return array(
            'hit'=>array(
                'condition'=>'hit = 1',
            ),
            'shopwindow'=>array(
                'condition'=>'shopwindow = 1',
            ),
            'last'=>array(
                'order'=>'create_time DESC',
            ),
        );
    }

	public function rules()
	{
		$rules=array(
            array('name', 'filter', 'filter'=>'strip_tags'),
            array('name', 'filter', 'filter'=>'trim'),
            array('summary, description','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('name, price, category_id, status, hit, shopwindow', 'required'),
			array('category_id, brand_id, status, hit, shopwindow, browse', 'numerical', 'integerOnly'=>true),
            array('priority', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>99),
            array('category_id', 'exist', 'className'=>'Category', 'attributeName'=>'id', 'message'=>'Такой категории нету'),
            array('brand_id', 'exist', 'className'=>'Brand', 'attributeName'=>'id', 'message'=>'Такого бренда нету'),
			array('other_price, price', 'numerical'),
			array('variation, name, enterprise_1c_id', 'length', 'max'=>255),
            array('unit', 'length', 'max'=>16),
            array('name', 'uniqueName'),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
            array('accessoryNames, generalProductNames, promotionNames', 'safe'),

			array('id, name, url, other_price, price, description, category_id, brand_id, status, hit, shopwindow, browse, priority', 'safe', 'on'=>'search'),
		);

        return $rules;
	}

    public function uniqueName() {
        $count=Product::model()->count("name=?", array($this->name));
        if($count>count($this->getVariations())) {
            $this->addError('name', 'Название "'.CHtml::encode($this->name).'" уже занято.');
        }

    }

	public function relations()
	{
		return array(
            'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
            'brand'=>array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'original'=>array(self::BELONGS_TO, 'Product', 'original_id'),

            'images'=>array(self::HAS_MANY, 'ProductImage', 'product_id'),
            'priceListRows'=>array(self::HAS_MANY, 'PriceListRow', 'product_id', 'index'=>'price_list_id'),

            'accessories'=>array(self::MANY_MANY, 'Product', '{{accessory}}(product_id,accessory_id)'),
            'generalProducts'=>array(self::MANY_MANY, 'Product', '{{accessory}}(accessory_id,product_id)'),
            'promotions'=>array(self::MANY_MANY, 'Promotion', '{{promotion_product}}(product_id,promotion_id)'),

            'countImages'=>array(self::STAT, 'ProductImage', 'product_id'),
            'countAccessories'=>array(self::STAT, 'Product', '{{accessory}}(product_id,accessory_id)'),
            'countGeneralProducts'=>array(self::STAT, 'Product', '{{accessory}}(accessory_id,product_id)'),
            'countPromotions'=>array(self::STAT, 'Promotion', '{{promotion_product}}(product_id,promotion_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'other_price' => 'Другая цена',
			'price' => 'Цена',
			'image' => 'Изображение',
            'summary' => 'Краткое описание',
			'description' => 'Описание',
			'category_id' => 'Категория',
			'brand_id' => 'Бренд',
			'status' => 'Состояние',
			'hit' => 'Хит продаж',
			'shopwindow' => 'Витрина',
			'browse' => 'Просмотров',
			'priority' => 'Приоритет',

            'variation' => 'Вариация',
            'enterprise_1c_id'=>'Ид в 1С:Управлением торговлей',

            'accessoryNames' => 'Аксессуары товара',
            'generalProductNames' => 'Аксессуар для товаров',
            'promotionNames' => 'Используется в акциях',

            'unit' => 'Единицы измерения',
		);
	}

	public function search()
	{
        $price=$this->price;
        if(IS_FRONTED) {
            if(is_array($price)) {
                foreach($price as $key=>$val) {
                    !empty($price[$key]) && $price[$key]=Yii::app()->priceFormatter->toBasic($val);
                }
            } else {
                !empty($price) && $price=Yii::app()->priceFormatter->toBasic($price);
            }
        }

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

        if(is_array($price) && isset($price['from']) && isset($price['till'])) {
            $criteria->compare('price','>='.$price['from']);
            $criteria->compare('price','<='.$price['till']);
        } else {
            $criteria->compare('price',$price);
        }

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('hit',$this->hit);
		$criteria->compare('shopwindow',$this->shopwindow);

        if($this->_feature_values!==null && $this->category_id) {
            $featureCriteria=new CDbCriteria;
            $count=0;
            $features=$this->category?$this->category->features:array();
            foreach($features as $feature) {
                $value=$this->getFeatureValue($feature->id);
                if(empty($value)) {
                    continue;
                }

                if(IS_FRONTED && $feature->type==Feature::TYPE_PRICE) {
                    if(is_array($value)) {
                        foreach($value as $key=>$val) {
                            !empty($value[$key]) && $value[$key]=Yii::app()->priceFormatter->toBasic($val);
                        }
                    } else {
                        !empty($value) && $value=Yii::app()->priceFormatter->toBasic($value);
                    }
                }

                $valueCriteria=new CDbCriteria;
                $valueCriteria->compare('f.feature_id', $feature->id);

                if(is_array($value) && isset($value['from']) && isset($value['till'])) {
                    $valueCriteria->compare('f.value','>='.$value['from']);
                    $valueCriteria->compare('f.value','<='.$value['till']);
                } else {
                    $valueCriteria->compare('f.value',$value);
                }

                $featureCriteria->mergeWith($valueCriteria, false);

                $count++;
            }

            if($count) {
                $criteria->join="JOIN {{feature_value}} AS f ON t.id=f.product_id";
                $criteria->group = "t.id";
                $criteria->having="COUNT(*)=".$count;
                $criteria->mergeWith($featureCriteria);
            }
        }

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
	}

    public function getAccessoryNames() {
        return implode(', ', CArray::pluck($this->accessories,'name'));
    }

    public function getGeneralProductNames() {
        return implode(', ', CArray::pluck($this->generalProducts,'name'));
    }

    public function getPromotionNames() {
        return implode(', ', CArray::pluck($this->promotions,'title'));
    }

    public function setAccessoryNames($value) {
        $this->accessories=empty($value)?array():Product::model()->findAllByAttributes(array('name'=>array_map('trim',explode(',',$value))));
    }

    public function setGeneralProductNames($value) {
        $this->generalProducts=empty($value)?array():Product::model()->findAllByAttributes(array('name'=>array_map('trim',explode(',',$value))));
    }

    public function setPromotionNames($value) {
        $this->promotions=empty($value)?array():Promotion::model()->findAllByAttributes(array('title'=>array_map('trim',explode(',',$value))));
    }

    public function limit($limit) {
        $this->getDbCriteria()->mergeWith(array('limit'=>$limit));
        return $this;
    }

    public function addImage(ProductImage $image) {
        $image->product_id=$this->id;
        $image->save();
    }

    public function getPriceListRow($price_list_id) {
        return array_key_exists($price_list_id, $this->priceListRows)?$this->priceListRows[$price_list_id]:null;
    }

    public function getFeatures($scope=null) {
        if(empty($this->category_id)) {
            return array();
        }

        $criteria=new CDbCriteria;
        $criteria->join='JOIN {{feature_value}} as fv ON fv.feature_id=t.id';
        $criteria->compare('fv.product_id', $this->id);

        if(IS_FRONTED) {
            $criteria->compare('t.status', Feature::STATUS_ENABLED);
        }
        $criteria->join.=' JOIN {{feature_category}} as fc ON fc.feature_id=t.id';
        $criteria->compare('fc.category_id', $this->category_id);
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

        $features=Feature::model()->findAll($criteria);
        foreach($features as $feature)
            $feature->attachBehavior("FeatureValueBehavior", new FeatureValueBehavior($this));

        return $features;
    }

    public function getSimilars() {
        return $this->similars();
    }

    public function similars($criteria2=null) {
        $accuracy=Yii::app()->config['similar_price_accuracy'];

        $criteria=new CDbCriteria;
        $criteria->params=array(
            ':price_from'=>max(0, $this->price*(1-$accuracy)),
            ':price_till'=>$this->price*(1+$accuracy),
        );

        if($this->brand_id)
            $criteria->compare('brand_id', $this->brand_id);

        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('id', '<>'.$this->id);
        $criteria->addCondition('price>=:price_from AND price<=:price_till');

        if($criteria2)
            $criteria->mergeWith($criteria2);

        return Product::model()->findAll($criteria);
    }

    public function getCountSimilars() {
        return count($this->similars);
    }

    public function getHasAccessories() {
        return $this->countAccessories>0;
    }

    public function getHasGeneralProducts() {
        return $this->countGeneralProducts>0;
    }

    public function getHasSimilars() {
        return $this->countSimilars>0;
    }

    public function getHasImages() {
        return $this->countImages>0;
    }

    public function getHasPromotions() {
        return $this->countPromotions>0;
    }

    public function beforeValidate() {
        if(parent::beforeValidate()) {
            $validators=$this->getValidatorList();

            $features=$this->category?$this->category->features:array();
            foreach($features as $feature)
                $validators->mergeWith($feature->getValueValidatorList());

            return true;
        } else {
            return false;
        }
    }

    public function __get($name) {
        if(preg_match('#^feature([0-9]+)$#', $name, $matches))
            $val=$this->getFeatureValue($matches[1]);
        else
            $val=parent::__get($name);

        if(IS_FRONTED && empty($val) && !empty($this->original_id) && !empty($this->original->{$name})) {
            $val=$this->original->{$name};
        }

        return $val;
    }

    public function __set($name, $value) {
        if(preg_match('#^feature([0-9]+)$#', $name, $matches))
            $this->setFeatureValue($matches[1], $value);
        else
            parent::__set($name, $value);
    }

    public function __isset($name) {
        if(preg_match('#^feature([0-9]+)$#', $name, $matches))
            return true;
        else
            return parent::__isset($name);
    }

    public function getVariations() {
        if($this->getIsNewRecord()) {
            return array();
        }

        if($this->original_id) {
            return Product::model()->findAll('id=:oid OR original_id=:oid OR id=:id', array(':oid'=>$this->original_id, ':id'=>$this->id));
        } else {
            return Product::model()->findAll('original_id=:id OR id=:id', array(':id'=>$this->id));
        }
    }

    public function getHasVariations() {
        return count($this->variations)>1;
    }

    public function setAttributes($values,$safeOnly=true) {
        if(!is_array($values))
			return;
		$attributes=array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		foreach($values as $name=>$value)
		{
            if(preg_match('#^feature([0-9]+)$#', $name, $matches))
                $this->setFeatureValue($matches[1], $value);
			if(isset($attributes[$name]))
				$this->$name=$value;
			else if($safeOnly)
				$this->onUnsafeAttribute($name,$value);
		}
    }

    public function getHasFeatureValue($feature_id) {
        $v=$this->getFeatureValues()->itemAt($feature_id);
        return !empty($v);
    }

    public function getFeatureValue($feature_id) {
        return $this->getFeatureValues()->itemAt($feature_id);
    }

    public function setFeatureValue($feature_id, $value) {
        $this->getFeatureValues()->add($feature_id, $value);
    }

    public function getFeatureValues() {
        if($this->_feature_values===null) {
            $this->_feature_values=new CMap;
            if($this->isNewRecord==false) {
                $query=Yii::app()->db->createCommand()
                        ->select('feature_id, value')
                        ->from('{{feature_value}}')
                        ->where('product_id=:pid', array(':pid'=>$this->id))
                        ->queryAll();

                foreach($query as $row)
                    $this->_feature_values->add($row['feature_id'], $row['value']);
            }
        }
        return $this->_feature_values;
    }

    protected function afterSave() {
        parent::afterSave();
        $features=$this->category?$this->category->features:array();
        $valid_ids=CArray::pluck($features, 'id');
        $exist_ids=array();

        foreach($this->getFeatureValues()->toArray() as $feature_id => $value) {
            if(in_array($feature_id, $valid_ids) && !empty($value)) {
                $sql='INSERT INTO {{feature_value}} (product_id,feature_id,value) VALUES (:pid,:fid,:val) ON DUPLICATE KEY UPDATE value=:val';
                Yii::app()->db->createCommand($sql)->execute(array(
                    ':pid'=>$this->id,
                    ':fid'=>$feature_id,
                    ':val'=>$value,
                ));
                array_push($exist_ids, $feature_id);
            }
        }
        $sql='DELETE FROM {{feature_value}} WHERE product_id=?';
        if(count($exist_ids))
            $sql.=' AND feature_id NOT IN ('.implode(', ', $exist_ids).')';
        Yii::app()->db->createCommand($sql)->execute(array($this->id));

        if(!$this->original_id) {
            $products=Product::model()->findAll('original_id=?',array($this->id));
            foreach($products as $product) {
                $product->category_id=$this->category_id;
                $product->brand_id=$this->brand_id;
                $product->name=$this->name;
                $product->save(false);
            }
        }
    }

    public function beforeDelete() {
        if(parent::beforeDelete()) {
            Yii::app()->db->createCommand('DELETE FROM {{feature_value}} WHERE product_id=?')->execute(array($this->id));
            if(!$this->original_id) {
                $products=Product::model()->findAll('original_id=?',array($this->id));
                foreach($products as $product)
                    $product->delete();
            }
            return true;
        } else {
            return false;
        }
    }
}