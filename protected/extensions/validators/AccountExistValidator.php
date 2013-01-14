<?php
class AccountExistValidator extends CExistValidator
{
	protected function validateAttribute($object, $attribute){
		$value=$object->$attribute;
		if($this->allowEmpty && $this->isEmpty($value))
			return;
		
		$result = UserPassport::model()->findByPk($value);
		
		if(is_null($result))
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} does not exists.');
			$this->addError($object,$attribute,$message,array('{value}'=>$value));
		}
	}
	
}