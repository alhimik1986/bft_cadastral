<?php

namespace alhimik1986\bftcadastral\controllers;

use Yii;
use alhimik1986\bftcadastral\models\Cadastral;
use alhimik1986\bftcadastral\models\CadastralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CadastralController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new CadastralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
