<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Mantenimiento $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos'];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mantenimiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver al equipo',
                    ['/equipo/view', 'id' => $model->equipo_id],
                    ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'equipo_id',
            'fecha',
            'tipo',
            'descripcion:ntext',
            'resultado:ntext',
            'pendientes:ntext',
        ],
    ]) ?>

</div>
