<?php

/**
 * This is the model class for table "urls".
 *
 * The followings are the available columns in table 'urls':
 * @property integer $id
 * @property string $url
 * @property string $hash
 */
class Urls extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Urls the static model class
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
		return 'urls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, hash', 'required'),
			array('url', 'length', 'max'=>200),
			array('hash', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, hash', 'safe', 'on'=>'search'),
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
			'url' => 'Url',
			'hash' => 'Hash',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('hash',$this->hash,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// ±£´æÁ´½Ó
	public function saveUrl($url) {
		$model = Urls::model();
		$check = $model->find("hash='".md5($url)."'");
		if($check) return false;
		
		$model->url = $url;
		$model->hash = md5($url);
		$model->id = null;
		$model->isNewRecord = true;
		return $model->save() ? true : false;
	}
}