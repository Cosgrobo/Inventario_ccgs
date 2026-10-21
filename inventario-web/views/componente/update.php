<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Componente $model */

$this->title = 'Update Componente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Componentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="componente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
