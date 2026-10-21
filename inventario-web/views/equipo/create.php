<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */

$this->title = 'Create Equipo';
$this->params['breadcrumbs'][] = ['label' => 'Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
