<?php
use yupe\components\WebModule;

class MultistoreModule extends WebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'multistore.models.*',
			'multistore.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	 public function getName()
    {
        return Yii::t('MultistoreModule.multistore', 'Multistore');
    }
 
    // описание модуля
    public function getDescription()
    {
        return Yii::t('MultistoreModule.multistore', 'Module for managing stores');
    }
 
    // автор модуля (Ваше Имя, название студии и т.п.)
    public function getAuthor()
    {
        return Yii::t('MultistoreModule.multistore', 'citizen_ru');
    }
 
    // контактный email автора
    public function getAuthorEmail()
    {
        return Yii::t('MultistoreModule.multistore', 'mail@citizen55.ru');
    }
 
    // сайт автора или страничка модуля
    public function getUrl()
    {
        return Yii::t('MultistoreModule.multistore', 'http://citizen_ru.ru');
    }
	public function getCategory()
{
    return Yii::t('MultistoreModule.multistore', 'Store');
}
}
