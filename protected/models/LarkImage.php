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
			$fuzzy = in_array($key, array('src', 'panoramio_id', 'title'));
			if($filter[$key] !== null) $criteria->compare($key, $filter[$key], $fuzzy);
		}
		$criteria->order = "`id` DESC";
		return $criteria;
	}
	
	// 查询列表
	public $pageSize = 25;
	public function getList() {
		$request = Yii::app()->request;
		$data = array('list'=>array(), 'pager'=>array());
		
		$data['filter'] = $this->getFilter($this->attributes, $isAll);
		$criteria = $this->getCriteria($data['filter']);

		$page = max($request->getParam('page', 0), 1);
		$count = $this->count($criteria);
		if($count == 0) return $data;

		$pageCount = ceil($count / $this->pageSize);
		$page = min($page, $pageCount);
		$criteria->offset = ($page - 1) * $this->pageSize;
		$criteria->limit = $this->pageSize;

		$list = $this->findAll($criteria);

		$data['pager'] = array(
			'page'=>$page,
			'count'=>$count,
			'pageCount'=>$pageCount
		);
		$data['list'] = $list;
		return $data;
	}
}