<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\VarDumper;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }

    public function actionPopulate()
    {
        $npiPage = Yii::$app->params['npiFilesDownloadPage'];
        return $this->render('populate', [
            'npiPage' => $npiPage
        ]);
    }

    public function actionLaunchPopulating()
    {
        $monthlyLog = Yii::getAlias('@runtime/monthly.log');
        if (is_file($monthlyLog))
            unlink($monthlyLog);

        $command = 'php ' . Yii::getAlias('@app') . '/yii fill/populate > ' . $monthlyLog;
        exec($command);
    }

    public function actionGetMonthlyLog()
    {
        $monthlyLog = Yii::getAlias('@runtime/monthly.log');
        if (is_file($monthlyLog))
            return file_get_contents($monthlyLog);
    }
}