<?php

use app\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание заявки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'category_id',
//            'user_id',
            'category.name',
            'name',
            'description:ntext',
            //'photo_to',
            //'status',
            [
                'attribute' => 'datetime',
                'format' => ['date', 'php:Y-m-d']
            ],
            //'description_denied:ntext',
            //'photo_after',
            [
                'label' => 'Фото до',
                'attribute' => 'photo_to',
                'format' => ['html'],
                'value' => function ($data) {
                    return "<img src='$data->photo_to' style='width: 50px' alt='Фото до'>";
                }
            ],
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'value' => function ($data) {
                    if($data->status == 0) return 'Новая';
                    if($data->status == 1) return 'Решена';
                    if($data->status == 2) return 'Отклонена';
                },
                'filter' => ['0' => 'Новая', '1' => 'Решена', '2' => 'Отклонена'],
                'filterInputOptions' => ['prompt' => 'Все статусы', 'class' => 'form-control', 'id' => null]
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Request $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
