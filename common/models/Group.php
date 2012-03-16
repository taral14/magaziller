<?php

/**
 * This is the model class for table "{{group}}".
 *
 * The followings are the available columns in table '{{group}}':
 * @property integer $id
 * @property string $name
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Group the static model class
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
		return '{{group}}';
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
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
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
		);
	}

    public function findAllGroupByFirstLetters() {
        $this->beforeFind();
        $groups=array();
        $criteria=new CDbCriteria;
        $criteria->select='*, UPPER(LEFT(name,1)) AS letter';
        $criteria->order='name ASC';
        $command=$this->getCommandBuilder()->createFindCommand('{{group}}',$criteria);
        foreach($command->queryAll() as $record)
            $groups[$record['letter']][]=$this->populateRecord($record);

		return $groups;
    }
}