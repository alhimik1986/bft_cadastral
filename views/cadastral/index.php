<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\cadastral\models\CadastralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Получение кадастровых данных';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cadastral-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['method'=>'get']) ?>
        <?= $form->field($searchModel, 'cadastral_number')->textInput() ?>
        <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>

    <br>

    <?php if($dataProvider->totalCount): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'cadastral_number',
                'address',
                'price',
                'area',
            ],
        ]); ?>
    <?php endif ?>

</div>
