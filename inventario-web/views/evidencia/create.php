<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Evidencia $model */

$this->title = 'Create Evidencia';
$this->params['breadcrumbs'][] = ['label' => 'Evidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evidencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
