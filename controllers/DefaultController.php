<?php

namespace funson86\setting\controllers;

use funson86\setting\models\Setting;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        //if(!Yii::$app->user->can('readPost')) throw new HttpException(403, 'No Auth');

        if(Yii::$app->request->isPost)
        {
            $setting = Yii::$app->request->post('Setting');
            foreach($setting as $key => $value) {
                Setting::updateAll(['value' => $value], ['code' => $key]);
            }
        }

        $settingParent = Setting::find()->where(['parent_id' => 0])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('index', [
            'settingParent' => $settingParent,
        ]);
    }
}
