<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\AuthItem;
use app\models\SearchUser;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                [
                  'allow' => true,
                  'actions' => ['index', 'create', 'view', 'update', 'delete'],
                  'roles' => ['admin'],
                ],
              ],
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $role = new AuthItem;
        if ($model->load(Yii::$app->request->post()) && $model->save() && $role->load(Yii::$app->request->post())) {
            $this->assignRoleToUser($role->name, $model->getId());
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $roles = $this->getPossibleRoles();
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
                'role' => $role,
            ]);
        }
    }

    public function assignRoleToUser($roleName, $userId)
    {
      $auth = Yii::$app->authManager;
      $authorRole = $auth->getRole($roleName);
      $auth->assign($authorRole, $userId);
    }

    public function getPossibleRoles(){
      return Yii::$app->authManager->getRoles();
    }

    public function getUserRole($user_id){
      return key(Yii::$app->authManager->getRolesByUser($user_id));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $role = new AuthItem;
        $role->load(Yii::$app->request->post());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->removeAllUserRoles($id);
            $this->assignRoleToUser($role->name, $id);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $role = AuthItem::findByName($this->getUserRole($id))->one();
            $roles = $this->getPossibleRoles();
            
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles,
                'role' => $role
            ]);
        }
    }

    public function removeAllUserRoles($id)
    {
      Yii::$app->authManager->revokeAll($id);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->removeAllUserRoles($id);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
