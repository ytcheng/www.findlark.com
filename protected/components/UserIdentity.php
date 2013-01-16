<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	public $uid;
	public $email;
	//public $nickname;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$criteria=new CDbCriteria;
		$criteria->compare('email', $this->email);
		$model = LarkUser::model()->find($criteria);
		
		if(empty($model)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			return !$this->errorCode;
		}

		$passwordMd5 = md5( md5($this->password).$model->jointime );
		if($passwordMd5 != $model->password) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			return !$this->errorCode;
		}
		$this->errorCode=self::ERROR_NONE;
		$this->uid = $model->uid;
		//$this->nickname = $model->nickname;
		$this->email = $model->email;
		
		$this->setState('uid', $model->uid);
		$this->setState('nickname', $model->nickname);
		$this->setState('email', $model->email);
		$this->setState('password', $model->password);
		$this->setState('avatar', $model->avatar);
		return !$this->errorCode;
	}

	public function getName() {
		return $this->email;
	}
}