<?php

/**
 * This is the model class for table "{{feature_pack}}".
 *
 * The followings are the available columns in table '{{feature_pack}}':
 * @property integer $id
 * @property string $name
 */
class FeaturePack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EavGroup the static model class
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
		return '{{feature_pack}}';
	}

    public function behaviors() {
  	    return array(
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'image',
                'nameAttribute' => 'name',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 40, 40, 'resize'=>'fill', 'required'=>'thumb.jpg', 'prefix'=>'feature_'),
                    'default' => array('storage/feature', Yii::app()->config['feature_pack_image_width'], Yii::app()->config['feature_pack_image_height']),
                ),
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
            array('name', 'filter', 'filter'=>'strip_tags'),
            array('description','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
            array('name', 'required'),
            array('name', 'length', 'max'=>255),
            array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('image', 'unsafe'),
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
            'image' => 'Изображение',
            'description' => 'Описание',
		);
	}

    public function findAllGroupByFirstLetters() {
        $this->beforeFind();
        $groups=array();
        $criteria=new CDbCriteria;
        $criteria->select='*, UPPER(LEFT(name,1)) AS letter';
        $criteria->order='name ASC';
        $command=$this->getCommandBuilder()->createFindCommand('{{feature_pack}}',$criteria);
        foreach($command->queryAll() as $record)
            $groups[$record['letter']][]=$this->populateRecord($record);

		return $groups;
    }
}