<?php

namespace app\controllers;

use app\models\ProductForm;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductForm();
        $model->isNewRecord = true;

        if (!Yii::$app->request->isPost) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        $params = Yii::$app->request->post();
        $model->load($params);
        $model->image_path = UploadedFile::getInstance($model, 'image_path');
        if (!$model->validate()) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        $model->employee_id = Yii::$app->user->id;
        if (!$model->save()) {
            return $this->render('create', [
                'model' => $model,
            ]);

        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $model = new ProductForm();
        $model->fill($product);

        if (!Yii::$app->request->isPost) {
            return $this->render('update', ['model' => $model]);
        }

        $params = Yii::$app->request->post();
        $model->load($params);
        $model->image_path = UploadedFile::getInstance($model, 'image_path');

        if (!$model->validate()) {
            return $this->render('update', ['model' => $model]);
        }

        $model->employee_id = $product->employee_id;
        if (!$model->save($product)) {
            return $this->render('update', ['model' => $model]);
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
