<?php
class MobileValidator extends CValidator
{
	/**
	 * 号段规则
	 * 截止到2011年12月9日
	 * @var string
	 */
	public $pattern='/^(1[3|5][0-9]|18[0|2|3|6-9])\d{8}$/';
	
	protected function validateAttribute($object, $attribute){
		$value=$object->$attribute;
		if(preg_match($this->pattern,$value) !== 1)
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} is not a valid mobile number.');
			$this->addError($object,$attribute,$message);
		}
	}
}