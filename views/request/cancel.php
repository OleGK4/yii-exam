<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Request $model */

$this->title = 'Отмена заявки: ' . $model->name;

?>
    <div class="request-update">

        <h1><?= Html::encode($this->title) ?></h1>
        <div class="request-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'description_denied')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
<?php
