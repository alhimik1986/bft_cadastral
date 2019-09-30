<?php

namespace app\modules\cadastral\controllers;

use Yii;
use app\modules\cadastral\models\Cadastral;
use app\modules\cadastral\models\CadastralSearch;
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
