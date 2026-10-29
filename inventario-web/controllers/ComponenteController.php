<?php

namespace app\controllers;

use app\models\Componente;
use app\models\ComponenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Transaction;

/**
 * ComponenteController implements the CRUD actions for Componente model.
 */
class ComponenteController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Componente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComponenteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Componente model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Componente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Componente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Componente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect([
                '/equipo/view',
                'id' => $model->equipo_id,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Componente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
  
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


    public function actionMultiple($equipo_id)
    {
        $equipo = \app\models\Equipo::findOne($equipo_id);

        if ($equipo === null) {
            throw new NotFoundHttpException('El equipo no existe.');
        }

        $componentes = [new Componente()];

        if ($this->request->isPost) {
            $post = $this->request->post();
            $filas = $post['Componente'] ?? [];

            $componentes = [];

            foreach ($filas as $fila) {
                $componente = new Componente();
                $componente->equipo_id = $equipo->id;

                if ($componente->load(['Componente' => $fila])) {
                    $componentes[] = $componente;
                }
            }

            $validos = !empty($componentes);

            foreach ($componentes as $componente) {
                $componente->equipo_id = $equipo->id;

                if (!$componente->validate()) {
                    $validos = false;
                }
            }

            if ($validos) {
                $transaccion = \Yii::$app->db->beginTransaction();

                try {
                    foreach ($componentes as $componente) {
                        if (!$componente->save(false)) {
                            throw new \RuntimeException(
                                'No se pudo guardar un componente.'
                            );
                        }
                    }

                    $transaccion->commit();

                    return $this->redirect([
                     '/diagnostico/create',
                     'equipo_id' => $equipo->id,
                    ]);
                } catch (\Throwable $e) {
                    $transaccion->rollBack();
                    throw $e;
                }
            }
        }

        return $this->render('multiple', [
            'equipo' => $equipo,
            'componentes' => $componentes,
        ]);
    }

    

    public function actionEditarMultiple($equipo_id)
    {
        $equipo = \app\models\Equipo::findOne($equipo_id);

        if ($equipo === null) {
            throw new NotFoundHttpException('El equipo no existe.');
        }

        $componentes = Componente::find()
            ->where(['equipo_id' => $equipo->id])
            ->all();

        if (empty($componentes)) {
            $componentes = [new Componente()];
        }

        if ($this->request->isPost) {
            $post = $this->request->post();
            $filas = $post['Componente'] ?? [];
            $componentesActualizados = [];
            $validos = !empty($filas);

            foreach ($filas as $indice => $fila) {
                // Si la fila tiene ID, buscamos el componente existente.
                if (!empty($fila['id'])) {
                    $componente = Componente::findOne([
                        'id' => $fila['id'],
                        'equipo_id' => $equipo->id,
                    ]);

                    if ($componente === null) {
                        throw new NotFoundHttpException(
                            'Uno de los componentes no pertenece a este equipo.'
                        );
                    }
                } else {
                    // Las filas sin ID representan componentes nuevos.
                    $componente = new Componente();
                    $componente->equipo_id = $equipo->id;
                }

                $componente->load(['Componente' => $fila]);
                $componente->equipo_id = $equipo->id;

                if (!$componente->validate()) {
                    $validos = false;
                }

                $componentesActualizados[] = $componente;
            }

            if ($validos) {
                $transaccion = Yii::$app->db->beginTransaction();

                try {
                    foreach ($componentesActualizados as $componente) {
                        if (!$componente->save(false)) {
                            throw new \RuntimeException(
                                'No se pudo guardar un componente.'
                            );
                        }
                    }

                    $transaccion->commit();

                    return $this->redirect([
                        '/equipo/view',
                        'id' => $equipo->id,
                    ]);
                } catch (\Throwable $e) {
                    if ($transaccion->isActive) {
                        $transaccion->rollBack();
                    }

                    throw $e;
                }
            }

            $componentes = $componentesActualizados;
        }

        return $this->render('multiple', [
            'equipo' => $equipo,
            'componentes' => $componentes,
            'modoEdicion' => true,
        ]);
    }
    
    /**
     * Finds the Componente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Componente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Componente::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
