<?php

namespace app\controllers;

use app\models\Evidencia;
use app\models\EvidenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Yii;

/**
 * EvidenciaController implements the CRUD actions for Evidencia model.
 */
class EvidenciaController extends Controller
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
     * Lists all Evidencia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EvidenciaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evidencia model.
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
     * Creates a new Evidencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
 

    public function actionDiagnosticosPorEquipo($equipo_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return \app\models\Diagnostico::find()
            ->select(['id', 'fecha', 'tipo', 'resultado'])
            ->where(['equipo_id' => $equipo_id])
            ->orderBy(['fecha' => SORT_DESC])
            ->asArray()
            ->all();
    }




    public function actionCreate($equipo_id = null, $diagnostico_id = null)
    {
        $model = new Evidencia();

        // Si viene un diagnóstico, verificar que exista y obtener su equipo.
        if ($diagnostico_id !== null) {
            $diagnostico = \app\models\Diagnostico::findOne(
                (int) $diagnostico_id
            );

            if ($diagnostico === null) {
                throw new \yii\web\NotFoundHttpException(
                    'El diagnóstico solicitado no existe.'
                );
            }

            if (
                $equipo_id !== null
                && (int) $equipo_id !== (int) $diagnostico->equipo_id
            ) {
                throw new \yii\web\BadRequestHttpException(
                    'El diagnóstico no pertenece al equipo seleccionado.'
                );
            }

            // El equipo del diagnóstico es la referencia correcta.
            $equipo_id = $diagnostico->equipo_id;
        }

        if ($equipo_id !== null) {
            $equipo = \app\models\Equipo::findOne((int) $equipo_id);

            if ($equipo === null) {
                throw new \yii\web\NotFoundHttpException(
                    'El equipo solicitado no existe.'
                );
            }

            $model->equipo_id = $equipo->id;
        }

        if ($diagnostico_id !== null) {
            $model->diagnostico_id = (int) $diagnostico_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // No permitir cambiar el equipo o diagnóstico de la URL.
                if ($equipo_id !== null) {
                    $model->equipo_id = (int) $equipo_id;
                }

                if ($diagnostico_id !== null) {
                    $model->diagnostico_id = (int) $diagnostico_id;
                }

                $model->archivoSubido = UploadedFile::getInstance(
                    $model,
                    'archivoSubido'
                );

                if ($model->archivoSubido !== null) {
                    $model->nombre_archivo = $model->archivoSubido->name;
                    $model->ruta_relativa = 'uploads/evidencias/'
                        . Yii::$app->security->generateRandomString(16)
                        . '.' . strtolower($model->archivoSubido->extension);
                }

                if ($model->validate()) {
                    if ($model->archivoSubido === null) {
                        $model->addError(
                            'archivoSubido',
                            'Debes seleccionar un archivo.'
                        );
                    } else {
                        $directorio = Yii::getAlias(
                            '@webroot/uploads/evidencias'
                        );

                        FileHelper::createDirectory($directorio);

                        $rutaFisica = Yii::getAlias(
                            '@webroot/' . $model->ruta_relativa
                        );


                        if ($model->archivoSubido->saveAs($rutaFisica)) {

                            // El archivo ya fue validado antes de guardarlo.
                            // Evitar que save() intente validar de nuevo el archivo temporal.
                            $model->archivoSubido = null;

                            if ($model->save()) {
                                return $this->redirect([
                                    '/equipo/view',
                                    'id' => $model->equipo_id,
                                ]);
                            }

                            // Si falla el registro, eliminar el archivo físico.
                            if (is_file($rutaFisica)) {
                                unlink($rutaFisica);
                            }

                        } else {
                            $model->addError(
                                'archivoSubido',
                                'No fue posible guardar el archivo en el servidor.'
                            );
                        }


                    }
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->fecha_captura = date('Y-m-d');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Evidencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Evidencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionMantenimientosPorEquipo($equipo_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $mantenimientos = \app\models\Mantenimiento::find()
            ->where(['equipo_id' => (int) $equipo_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $resultado = [];

        foreach ($mantenimientos as $mantenimiento) {
            $resultado[] = [
                'id' => $mantenimiento->id,
                'fecha' => $mantenimiento->fecha,
                'tipo' => $mantenimiento->tipo,
            ];
        }

        return $resultado;
    }


    /**
     * Finds the Evidencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Evidencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evidencia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
