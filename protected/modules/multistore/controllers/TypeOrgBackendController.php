<?php
/**
* Класс TypeOrgController:
*
*   @category Yupeyupe\components\controllers\BackController
*   @package  yupe
*   @author   Yupe Team
<team@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     http://yupe.ru
**/
class TypeOrgBackendController extends yupe\components\controllers\BackController
{
/**
* Отображает Типа организации по указанному идентификатору
*
* @param integer $id Идинтификатор Типа организации для отображения
*
* @return void
*/
public function actionView($id)
{
	$this->render('view', array('model' => $this->loadModel($id)));
}

/**
* Создает новую модель Типа организации.
* Если создание прошло успешно - перенаправляет на просмотр.
*
* @return void
*/
public function actionCreate()
{
	$model = new TypeOrg;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['TypeOrg']))
	{
		$model->attributes = $_POST['TypeOrg'];

		if ($model->save())
		{
			Yii::app()->user->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,Yii::t('multistore', 'Запись добавлена!'));

			if (!isset($_POST['submit-type']))
			$this->redirect(array('update', 'id' => $model->id));
			else
			$this->redirect(array($_POST['submit-type']));
		}
	}
	$this->render('create', array('model' => $model));
}

/**
* Редактирование Типа организации.
*
* @param integer $id Идинтификатор Типа организации для редактирования
*
* @return void
*/
public function actionUpdate($id)
{
$model = $this->loadModel($id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['TypeOrg']))
	{
		$model->attributes = $_POST['TypeOrg'];

		if ($model->save())
		{
			Yii::app()->user->setFlash(
			yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
			Yii::t('multistore', 'Запись обновлена!')
			);

			if (!isset($_POST['submit-type']))
			$this->redirect(array('update', 'id' => $model->id));
			else
			$this->redirect(array($_POST['submit-type']));
		}
	}
	$this->render('update', array('model' => $model));
}

/**
* Удаляет модель Типа организации из базы.
* Если удаление прошло успешно - возвращется в index
*
* @param integer $id идентификатор Типа организации, который нужно удалить
*
* @return void
*/
public function actionDelete($id)
{
if (Yii::app()->getRequest()->getIsPostRequest())
{
	// поддерживаем удаление только из POST-запроса
	$this->loadModel($id)->delete();

	Yii::app()->user->setFlash(
	yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
	Yii::t('multistore', 'Запись удалена!')
	);

	// если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
	if (!isset($_GET['ajax']))
	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
} else
	throw new CHttpException(400, Yii::t('multistore', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
}

/**
* Управление Типами организаций.
*
* @return void
*/
public function actionIndex()
{
	$model = new TypeOrg('search');
	$model->unsetAttributes(); // clear any default values
	if (isset($_GET['TypeOrg']))
	$model->attributes = $_GET['TypeOrg'];
	$this->render('index', array('model' => $model));
}

/**
* Возвращает модель по указанному идентификатору
* Если модель не будет найдена - возникнет HTTP-исключение.
*
* @param integer идентификатор нужной модели
*
* @return void
*/
public function loadModel($id)
{
	$model = TypeOrg::model()->findByPk($id);
	if ($model === null)
	throw new CHttpException(404, Yii::t('multistore', 'Запрошенная страница не найдена.'));

	return $model;
}

/**
* Производит AJAX-валидацию
*
* @param CModel модель, которую необходимо валидировать
*
* @return void
*/
protected function performAjaxValidation(TypeOrg $model)
{
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'type-org-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}
}
