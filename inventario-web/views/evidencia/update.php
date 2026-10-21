<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Evidencia $model */

$this->title = 'Update Evidencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Evidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evidencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
