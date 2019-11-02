<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\user;
class UserController extends \yii\web\Controller
{
	
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionRegister()
    {
	     $user = new user();

	    if ($user->load(Yii::$app->request->post())) {
	        if ($user->validate()) {
	            // Save Record
	            $user->save();
	            //send message
	            yii::$app->getSession()->setFlash('success', 'You are Registered');

	            return $this->redirect('index.php');
	        }
	    }

	    return $this->render('register', [
	        'user' => $user,
	    ]);
    }

}
