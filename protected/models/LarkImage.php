<?php

/**
 * This is the model class for table "lark_image".
 *
 * The followings are the available columns in table 'lark_image':
 * @property integer $id
 * @property integer $panoramio_id
 * @property string $src
 * @property string $title
 */
class LarkImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LarkImage the static model class
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
		return 'lark_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('panoramio_id, src', 'required'),
			array('panoramio_id', 'numerical', 'integerOnly'=>true),
			array('src', 'length', 'max'=>300),
			array('title', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, panoramio_id, src, title', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'panoramio_id' => 'Panoramio',
			'src' => 'Src',
			'title' => 'Title',
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
		$criteria->compare('panoramio_id',$this->panoramio_id);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}