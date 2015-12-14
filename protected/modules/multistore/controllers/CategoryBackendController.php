<?php

class CategoryBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'MultistoreCategory',
                'validAttributes' => [
                    'status',
                    'slug'
                ]
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'MultistoreCategory',
                'attribute' => 'sort'
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Multistore.CategoryBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Multistore.CategoryBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Multistore.CategoryBackend.Create'],],
            ['allow', 'actions' => ['update', 'inline', 'sortable'], 'roles' => ['Multistore.CategoryBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Multistore.CategoryBackend.Delete'],],
            ['deny',],
        ];
    }

    /**
     * Отображает категорию по указанному идентификатору
     *
     * @param integer $id Идинтификатор категорию для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель категории.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new MultistoreCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('MultistoreCategory')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MultistoreModule.multistore', 'Record was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        // Указан ID новости страницы, редактируем только ее
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('MultistoreCategory')) !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('MultistoreCategory'));

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MultistoreModule.multistore', 'Category was changed!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model->id,
                        ]
                    )
                );
            }
        }

        $this->render(
            'update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Удаяет модель категории из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор категории, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                // поддерживаем удаление только из POST-запроса
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

                $transaction->commit();

                if (!isset($_GET['ajax'])) {
                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();

                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('MultistoreModule.multistore', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }

    /**
     * Управление категориями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new MultistoreCategory('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['MultistoreCategory'])) {
            $model->attributes = $_GET['MultistoreCategory'];
        }

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id идентификатор нужной модели
     *
     * @return MultistoreCategory $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = MultistoreCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('MultistoreModule.multistore', 'Page was not found!'));
        }
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param MultistoreCategory $model модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(MultistoreCategory $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
