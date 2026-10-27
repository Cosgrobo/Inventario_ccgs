<?php

namespace app\controllers;

use Yii;
use app\models\Equipo;
use app\models\Mantenimiento;
use app\models\MantenimientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class MantenimientoController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new MantenimientoSearch();
        $dataProvider = $searchModel->search(
            $this->request->queryParams
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($equipo_id = null)
    {
        $model = new Mantenimiento();

        if ($equipo_id !== null) {
            $equipo = Equipo::findOne($equipo_id);

            if ($equipo === null) {
                throw new NotFoundHttpException(
                    'El equipo seleccionado no existe.'
                );
            }

            if ($equipo->estado_registro !== 'Activo') {
                throw new ForbiddenHttpException(
                    'No se pueden registrar mantenimientos para equipos dados de baja.'
                );
            }

            $model->equipo_id = $equipo->id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Si se abrió desde un equipo, no permitir cambiarlo
                // manipulando el formulario enviado.
                if ($equipo_id !== null) {
                    $model->equipo_id = $equipo_id;
                }

                if ($model->save()) {
                    return $this->redirect([
                        '/equipo/view',
                        'id' => $model->equipo_id,
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->fecha = date('Y-m-d');

            if ($equipo_id !== null) {
                $model->equipo_id = $equipo_id;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (
            $this->request->isPost
            && $model->load($this->request->post())
            && $model->save()
        ) {
            return $this->redirect([
                '/equipo/view',
                'id' => $model->equipo_id,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $equipoId = $model->equipo_id;

        $model->delete();

        return $this->redirect([
            '/equipo/view',
            'id' => $equipoId,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Mantenimiento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'El mantenimiento solicitado no existe.'
        );
    }
}
