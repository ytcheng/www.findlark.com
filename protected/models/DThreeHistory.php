<?php

/**
 * This is the model class for table "3d_history".
 *
 * The followings are the available columns in table '3d_history':
 * @property integer $id
 * @property integer $timeline
 * @property integer $n1
 * @property integer $n2
 * @property integer $n3
 */
class DThreeHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DThreeHistory the static model class
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
		return '3d_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, timeline, n1, n2, n3', 'required'),
			array('id, timeline, n1, n2, n3', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timeline, n1, n2, n3', 'safe', 'on'=>'search'),
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
			'timeline' => 'Timeline',
			'n1' => 'N1',
			'n2' => 'N2',
			'n3' => 'N3',
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
		$criteria->compare('timeline',$this->timeline);
		$criteria->compare('n1',$this->n1);
		$criteria->compare('n2',$this->n2);
		$criteria->compare('n3',$this->n3);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}