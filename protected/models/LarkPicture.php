<?php

/**
 * This is the model class for table "lark_picture".
 *
 * The followings are the available columns in table 'lark_picture':
 * @property string $id
 * @property string $title
 * @property string $tag
 * @property string $desc
 * @property integer $timeline
 * @property integer $width
 * @property integer $height
 * @property string $dir
 * @property string $name
 * @property string $ext
 * @property string $histogram
 * @property string $properties
 * @property string $hash
 * @property string $share_times
 * @property string $score
 */
class LarkPicture extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LarkPicture the static model class
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
		return 'lark_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, timeline, dir, name, ext, hash', 'required'),
			array('timeline, width, height', 'numerical', 'integerOnly'=>true),
			array('title, tag', 'length', 'max'=>100),
			array('desc', 'length', 'max'=>300),
			array('dir', 'length', 'max'=>200),
			array('name', 'length', 'max'=>8),
			array('ext', 'length', 'max'=>5),
			array('hash', 'length', 'max'=>16),
			array('share_times, score', 'length', 'max'=>10),
			array('histogram, properties', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, tag, desc, timeline, width, height, dir, name, ext, histogram, properties, hash, share_times, score', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'tag' => 'Tag',
			'desc' => 'Desc',
			'timeline' => 'Timeline',
			'width' => 'Width',
			'height' => 'Height',
			'dir' => 'Dir',
			'name' => 'Name',
			'ext' => 'Ext',
			'histogram' => 'Histogram',
			'properties' => 'Properties',
			'hash' => 'Hash',
			'share_times' => 'Share Times',
			'score' => 'Score',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('timeline',$this->timeline);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('dir',$this->dir,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('histogram',$this->histogram,true);
		$criteria->compare('properties',$this->properties,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('share_times',$this->share_times,true);
		$criteria->compare('score',$this->score,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}