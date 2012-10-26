<?php
class ExtensionsBase{
	private static $_models = array();
	
	public static function model($className = __CLASS__) {
		if(!isset(self::$_models[$className])) {
			self::$_models[$className] = new $className();
		}
		return self::$_models[$className];
	}
}