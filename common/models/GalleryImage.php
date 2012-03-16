<?php

/**
 * This is the model class for table "{{gallery_image}}".
 *
 * The followings are the available columns in table '{{gallery_image}}':
 * @property integer $id
 * @property string $filename
 * @property string $description
 * @property integer $gallery_id
 */
class GalleryImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GalleryImage the static model class
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
		return '{{gallery_image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_id', 'required'),
			array('gallery_id', 'numerical', 'integerOnly'=>true),
            array('gallery_id', 'exist', 'className'=>'Gallery', 'attributeName'=>'id', 'message'=>'Галереи не существует'),
			array('filename', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true),
            array('description', 'safe'),
		);
	}

	public function relations()
	{
		return array(
            'gallery'=>array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
		);
	}

	public function behaviors()
	{
		return array(
            'ImageUploadBehavior' => array(
                'class' => 'ImageUploadBehavior',
                'fileAttribute' => 'filename',
                'images'=> array(
                    'thumb' => array('storage/.tmb', 150, 150, 'resize'=>'fill', 'prefix'=>'gallery_'),
                    'small' => array('storage/gallery', 400, 250, 'prefix'=>'small_'),
                    'large' => array('storage/gallery', 800, 600, 'prefix'=>'large_'),
                ),
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
			'filename' => 'Filename',
			'description' => 'Description',
			'gallery_id' => 'Gallery',
		);
	}
}