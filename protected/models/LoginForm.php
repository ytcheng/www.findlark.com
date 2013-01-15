<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
	public $email;
	public $password;
	public $keep;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(
			array('email, password', 'required', 'message'=>'请正确填写{attribute}!'),
			array('keep', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'email'=>'邮箱',
			'password'=>'密码',
			'keep'=>'Keep login statu',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params) {
		if(!$this->hasErrors()) {
			$this->_identity=new UserIdentity($this->email, $this->password);
			
			if(!$this->_identity->authenticate()){
				if($this->_identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID){
					$this->addError('email','无效的邮箱地址!');
				}
				
				if($this->_identity->errorCode == UserIdentity::ERROR_PASSWORD_INVALID){
					$this->addError('password', '无效的密码!');
				}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login() {
		if($this->_identity===null) {
			$this->_identity=new UserIdentity($this->email, $this->password);
			if(!$this->_identity->authenticate()) {
				switch($this->_identity->errorCode) {
					case UserIdentity::ERROR_USERNAME_INVALID: $this->addError('email', '无效的邮箱地址!'); break;
					case UserIdentity::ERROR_PASSWORD_INVALID: $this->addError('password', '无效的密码!'); break;
					case UserIdentity::ERROR_NOT_ACTIVE: $this->addError('email', '您的帐号尚未激活!'); break;
					default: $this->addError('email', '登录失败!'); break;
				}
			}
		}
		
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = $this->keep ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		} else {
			return false;
		}
	}
}
