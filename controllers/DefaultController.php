<?php

namespace app\modules\yii2transconv\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex($message = "Hello World")
    {
		echo $message . "\n";
        //return $this->render('index');
    }
}
