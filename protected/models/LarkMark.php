<?php

/**
 * This is the model class for table "lark_mark".
 *
 * The followings are the available columns in table 'lark_mark':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property double $latitude
 * @property double $longitude
 * @property integer $display
 */
class LarkMark extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LarkMark the static model class
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
		return 'lark_mark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, latitude, longitude', 'required'),
			array('display', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('title', 'length', 'max'=>200),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, latitude, longitude, display', 'safe', 'on'=>'search'),
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
			'content' => 'Content',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'display' => 'Display',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('display',$this->display);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// 过滤器
	public function getFilter($attributes = null, $isAll = false) {
		$request = Yii::app()->request;
		$filter = $this->attributes;
		foreach($this->attributes as $key => $val) {
			$filter[$key] = $request->getParam($key, null);
		}
		
		return $filter;
	}
	
	// 筛选器
	public function getCriteria($filter) {
		$criteria=new CDbCriteria;
		
		foreach($this->attributes as $key => $val) {
			$fuzzy = in_array($key, array('latitude', 'longitude', 'title', 'content'));
			if($filter[$key] !== null) $criteria->compare($key, $filter[$key], $fuzzy);
		}
		$criteria->order = "`id` DESC";
		return $criteria;
	}
}