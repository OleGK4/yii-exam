<?php

use app\models\Request;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category.name',
            'user.full_name',
//            'category_id',
//            'user_id',
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
                'label' => 'Статус',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->status == 0) return 'Новая' . ' ' . Html::a('Отменить',"/basic/request/cancel?id=$data->id") . ' ' . Html::a('Решить',"/basic/request/success?id=$data->id");
                    if ($data->status == 1) return 'Решена';
                    if ($data->status == 2) return 'Отклонена';
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
    <p>
        <?= Html::a('Управление категорями', ['/category'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
