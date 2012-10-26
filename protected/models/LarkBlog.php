<?php

/**
 * This is the model class for table "lark_blog".
 *
 * The followings are the available columns in table 'lark_blog':
 * @property string $id
 * @property string $title
 * @property string $tag
 * @property string $content
 * @property string $summary
 * @property integer $classify
 * @property string $pic
 * @property string $attach
 * @property string $attach_name
 * @property integer $timeline
 * @property integer $display
 */
class LarkBlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LarkBlog the static model class
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
		return 'lark_blog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, tag, content, summary, timeline', 'required'),
			array('classify, timeline, display', 'numerical', 'integerOnly'=>true),
			array('title, pic, attach', 'length', 'max'=>200),
			array('tag, attach_name', 'length', 'max'=>100),
			array('summary', 'length', 'max'=>400),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, tag, content, summary, classify, pic, attach, attach_name, timeline, display', 'safe', 'on'=>'search'),
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
			'content' => 'Content',
			'summary' => 'Summary',
			'classify' => 'Classify',
			'pic' => 'Pic',
			'attach' => 'Attach',
			'attach_name' => 'Attach Name',
			'timeline' => 'Timeline',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('classify',$this->classify);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('attach',$this->attach,true);
		$criteria->compare('attach_name',$this->attach_name,true);
		$criteria->compare('timeline',$this->timeline);
		$criteria->compare('display',$this->display);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}