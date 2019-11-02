<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Friend;
use yii\helpers\JSON;
//use yii\web\Request;

use yii\rest\ActiveController;

class ApiController extends \yii\web\Controller
{
    public function actionUser(){
       $modelClass = User::find()->all();       
       return JSON::encode($modelClass);
    }
    
    public function actionJsonpage(){
        return $this->render('jsonPage');
     }
     
     public function actionCreateusers()

    {    
      \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
      $user = new User();
      $user->scenario = User:: SCENARIO_CREATE;
      $user->attributes = \yii::$app->request->post();
      if($user->validate())
      {
       $user->save();
       return array('status' => true, 'data'=> 'User record is successfully updated');
      }else{
       return array('status'=>false,'data'=>$user->getErrors());
      }

    }
    public function actionGetusers()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $user = User::find()->all();
       
        if(count($user) > 0 )
        {
        return array('status' => true, 'data'=> $user);
        }
        else
        {
        return array('status'=>false,'data'=> 'No user Found');
        }
    }
    public function actionUpdateuser()
   {
           \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;     
         $attributes = \yii::$app->request->post();
       
         $user = User::find()->where(['ID' => $attributes['id'] ])->one();
          if(count($user) > 0 )
          {
           $user->attributes = \yii::$app->request->post();
           $user->save();
           return array('status' => true, 'data'=> 'User record is updated successfully');
          
          }
        else
        {
           return array('status'=>false,'data'=> 'No User Found');
        }
   }
   public function actionDeleteuser()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $attributes = \yii::$app->request->post();
            $user = User::find()->where(['ID' => $attributes['id'] ])->one();  
            if(count($user) > 0 )
        {
            $user->delete();
        return array('status' => true, 'data'=> 'User record is successfully deleted'); 
            }
        else
        {
        return array('status'=>false,'data'=> 'No User Found');
        }
    }
}
