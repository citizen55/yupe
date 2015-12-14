<?php

class MultistoreBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index']],
            ['deny'],
        ];
    }

    public function actionIndex()
    {
        $this->render('index', ['multistoreModule' => $this->module]);
    }



}
