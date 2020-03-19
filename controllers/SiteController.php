<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\PayForm;
use app\models\Payment;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $userModel = new User();

        if ($userModel->load(Yii::$app->request->post())) {
            $userModel->status = User::STATUS_ACTIVE;
            $userModel->save();
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $payForm = new PayForm();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'userModel' => $userModel,
            'payForm' => $payForm,
        ]);
    }

    /*
    *   Pay method
    */
    public function actionPay()
    {
        $payForm = new PayForm();

        if ($payForm->load(Yii::$app->request->post()) && ($payForm->validate())) {
            $model = new Payment();
            $user = User::find()->where(['id' => $payForm->user])->orWhere(['phone' => $payForm->user])->one();
            if($user == null) {
                // TODO: handle error (alert mb?)
                return $this->redirect(['site/index']);
            }
            $model->user = $user->id;
            $model->value = $payForm->value;
            if($model->save()) {
                return $this->redirect(['site/rept']);
            } else {
                return $this->redirect(['site/index']);
            }
            
        }

        return $this->redirect(['site/index']);
    }

    /*
    * Invert status
    */
    public function actionChangeStatus($id)
    {
        $model = User::findOne($id);
        if($model != null) {
            $model->changeStatus();
        }
        // TODO: handle error
        return $this->redirect(['site/index']);
    }

    /**
     * Report page.
     *
     * @return string
     */
    public function actionRept()
    {

        if(Yii::$app->request->post()) {
            if(Yii::$app->request->post('user')) {
                //filter by user
                $user = User::find()->where(['id' => Yii::$app->request->post('user')])->orWhere(['phone' => Yii::$app->request->post('user')])->one();
                if($user) {
                    $query = Payment::find()->where(['user' => $user->id]);
                }
                // TODO: handle error if user not found
            } else if(Yii::$app->request->post('from') && Yii::$app->request->post('to')) {
                //filter by date
                $query = Payment::find()->where(['>=','created_at',Yii::$app->request->post('from') . ' 00:00:00'])->andWhere(['<=','created_at',Yii::$app->request->post('to') . ' 23:59:59']);
            } else {
                $query = Payment::find();
            }
        } else {
            $query = Payment::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $total = $query->sum('value');

        return $this->render('rept',[
            'dataProvider' => $dataProvider,
            'total' => $total,
        ]);
    }

    /*
    * Easy delete payment
    */
    public function actionDelete($id)
    {
        $model = Payment::findOne($id);
        $model->delete();
        return $this->redirect(['site/rept']);
    }
}
