<?php
class RegForm extends CFormModel {
	public $nickname;
	public $password;
	public $repeat;
	public $email;
	public $verifycode;
	
	public function rules() {
		return array(
			array('nickname, password, repeat, email, verifycode', 'required', 'message'=>'请填写{attribute}'),
			array('email', 'CEmailValidator', 'message'=>'邮箱格式错误!'),
			array('email', 'ext.validators.EmailUniqueValidator','message'=>'该邮箱已被注册!'),
			array('password', 'compare', 'compareAttribute'=>'repeat', 'message'=>'两次输入密码不一致!'),
			array('password, repeat', 'length', 'max'=>20, 'min'=>6, 'tooLong'=>'密码不超过20字符!', 'tooShort'=>'密码必须多于6个字符!'),
			array('nickname', 'length', 'max'=>20, 'min'=>2, 'tooLong'=>'昵称长度不超过20字符!', 'tooShort'=>'昵称必须多于2个字符!'),
			array('verifycode', 'captcha', 'captchaAction'=>'site/captcha', 'message'=>'验证码不正确!'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'email' => '邮箱',
			'nickname' => '昵称',
			'password' => '登录密码',
			'repeat' => '确认密码',
			'verifycode' => '验证码',
		);
	}
}