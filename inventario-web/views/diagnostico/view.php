<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Diagnostico $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Diagnosticos'];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="diagnostico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
    <div class="form-group">
    
        <?= Html::a(
            'Editar diagnóstico',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= Html::a(
            'Volver al equipo',
            ['/equipo/view', 'id' => $model->equipo_id],
            ['class' => 'btn btn-default']
        ) ?>

    </div>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'equipo_id',
            'fecha',
            'tipo',
            'resultado',
            'pruebas_realizadas:ntext',
            'fallas_encontradas:ntext',
            'observaciones:ntext',
        ],
    ]) ?>

</div>
