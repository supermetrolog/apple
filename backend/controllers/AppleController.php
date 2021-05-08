<?php

namespace backend\controllers;

use app\models\Apple;

class AppleController extends \yii\web\Controller
{
    const EVENT_CHECK_SPOILED = 'CHECK_SPOILED';
    public function actionIndex()
    {
        return $this->render('index', [
            'apples' => Apple::find()->all()
        ]);
    }
    public function beforeAction($action)
    {
        $this->on(self::EVENT_CHECK_SPOILED, ['app\models\Apple', 'CHECK_SPOILED']);
        $this->trigger(self::EVENT_CHECK_SPOILED);
        return true;
    }
    public function actionGenerate()
    {
        $model = new Apple();
        $model->generateApples();
        return $this->renderAjax('generate', [
            'apples' => $model->find()->all()
        ]);
    }
    public function actionDrop()
    {
        if ($this->request->post() && $model = Apple::findOne($this->request->post('id'))) {
            if ($model->drop()) {
                return $this->renderAjax('generate', [
                    'apples' => $model->find()->all()
                ]);
            }
        }
        return json_encode($model->getErrors());
    }
    public function actionEat()
    {
        if ($this->request->post() && $model = Apple::findOne($this->request->post('id'))) {
            if ($model->eat($this->request->post('eaten'))) {
                return $this->renderAjax('generate', [
                    'apples' => $model->find()->all()
                ]);
            }
        }
        return json_encode($model->getErrors());
    }
}
