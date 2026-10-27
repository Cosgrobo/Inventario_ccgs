<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mantenimiento $model */

$this->title = 'Update Mantenimiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos'];
$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mantenimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
