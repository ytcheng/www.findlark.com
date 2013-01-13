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
 * @property integer $timeline
 * @property string $author
 * @property string $icon
 */
class LarkMark extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
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
			array('title, latitude, longitude, timeline', 'required'),
			array('display, timeline', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('title', 'length', 'max'=>100),
			array('author', 'length', 'max'=>20),
			array('icon', 'length', 'max'=>10),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, latitude, longitude, display, timeline, author, icon', 'safe', 'on'=>'search'),
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
			'timeline' => 'Timeline',
			'author' => 'Author',
			'icon' => 'Icon',
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
		$criteria->compare('timeline',$this->timeline);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('icon',$this->icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function getFilter($attributes = null, $isAll = false) {
		$request = Yii::app()->request;
		$filter = $this->attributes;
		foreach($this->attributes as $key => $val) {
			$filter[$key] = $request->getParam($key, null);
		}
		
		return $filter;
	}
	
	public function getCriteria($filter) {
		$criteria=new CDbCriteria;
		
		foreach($this->attributes as $key => $val) {
			$fuzzy = in_array($key, array('latitude', 'longitude', 'title', 'content'));
			if($filter[$key] !== null) $criteria->compare($key, $filter[$key], $fuzzy);
		}
		$criteria->order = "`id` DESC";
		return $criteria;
	}
	
	public function getDayMarks() {
		$time = time() - 86400;
		$criteria = new CDbCriteria;
		$criteria->compare('timeline', '>'.$time);
		$criteria->compare('display', 1);
		$criteria->limit = 400;
		$criteria->order = "`id` DESC";
		
		return $this->findAll($criteria);
	}
}