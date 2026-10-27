<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mantenimiento $model */

$this->title = 'Create Mantenimiento';
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mantenimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
