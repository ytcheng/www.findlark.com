<?php

/**
 * This is the model class for table "lark_user".
 *
 * The followings are the available columns in table 'lark_user':
 * @property integer $uid
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property integer $active
 * @property integer $jointime
 * @property string $avatar
 */
class LarkUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LarkUser the static model class
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
		return 'lark_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, jointime', 'required'),
			array('active, jointime', 'numerical', 'integerOnly'=>true),
			array('nickname', 'length', 'max'=>20),
			array('email, avatar', 'length', 'max'=>100),
			array('password', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, nickname, email, password, active, jointime, avatar', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'nickname' => 'Nickname',
			'email' => 'Email',
			'password' => 'Password',
			'active' => 'Active',
			'jointime' => 'Jointime',
			'avatar' => 'Avatar',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('jointime',$this->jointime);
		$criteria->compare('avatar',$this->avatar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// 用户注册
	public function register($formModel) {
		$userModel = LarkUser::model();
		$dataModel = LarkUserData::model();
		$logModel = LarkUserLog::model();
		
		$transaction = $this->getDbConnection()->beginTransaction();
		
		$jointime = time();
		$userModel->attributes = array(
			'email'=> $formModel->email,
			'nickname'=> $formModel->nickname,
			'jointime'=> $jointime,
			'password' => md5( md5($formModel->password).$jointime ),
			'active'=>1,
			'avatar'=>''
		);
		$userModel->uid = null;
		$userModel->isNewRecord = true;
		
		try{
			if(!$userModel->save()) throw new CException( var_export($this->getErrors(), true) );
			
			$dataModel->uid = $userModel->uid;
			if(!$dataModel->save()) throw new CException( var_export($dataModel->getErrors(), true) );
			$logModel->uid = $userModel->uid;
			if(!$logModel->save()) throw new CException( var_export($logModel->getErrors(), true) );
			
			$transaction->commit();
			error_log(__FUNCTION__."register commit");
			return true;
		} catch(Exception $e) {
			$transaction->rollback();
			error_log(__FUNCTION__."register rollback.message:".$e->getMessage());
			return false;
		}
	}
}