<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Diagnostico $model */

$this->title = 'Create Diagnostico';
$this->params['breadcrumbs'][] = ['label' => 'Diagnosticos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diagnostico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
