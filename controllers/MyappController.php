<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;

use app\models\User;
use app\models\Friend;

use yii\db\ActiveQuery;

class MyappController extends \yii\web\Controller
{
    

    public function actionIndex(){

        $user = User::findOne(Yii::$app->user->identity->id);

        $query = User::find()->where(['<>', 'id' , Yii::$app->user->identity->id]);
        $FRIENDquery = Friend::find();

        $status_ACCEPTED = FRIEND::ACCEPTED;
        $status_PENDING = FRIEND::PENDING;

        
       $pagination = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $query->count(),
        ]);

        $users = $query->orderBy('id')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

       //Render view
        return $this->render('index', [
            'user' => $user,
            'users' => $users,
            'pagination' => $pagination,
            'FRIENDquery' =>$FRIENDquery,
            'status_ACCEPTED' => $status_ACCEPTED,
            'status_PENDING' => $status_PENDING
        ]);
    }

     public function actionAdd($id)
     {

         $query = Friend::find()->where(['user_id' => Yii::$app->user->identity->id])->where(['friend_id' => $id]);
         if($query->count() == 0){
            $add = new Friend();
            $add->user_id = Yii::$app->user->identity->id;
            $add->friend_id = $id;
            $add->status = Friend::PENDING;
           
            $add->save();         
            Yii::$app->getSession()->setFlash('success', 'Friend rquest have been sent');
            return $this->redirect('index.php?r=myapp');
         }elseif($query->count() > 0){
            $add = $query->one();
            $add->status = Friend::PENDING;           
            $add->save();
            Yii::$app->getSession()->setFlash('sucess', 'Friend rquest have been sent');
            return $this->redirect('index.php?r=myapp');
         }else{

            Yii::$app->getSession()->setFlash('error', 'Unable to add friend');
            return $this->redirect('index.php?r=myapp');
         }
            
                

     }
      public function actionOutgoing($id){
         //get outgoing friend request
        $user = User::findOne($id);

       
        /*foreach($user->outgoingfriends as $friends){
            echo User::findOne($friends->friend_id)->first_name." - ".$friends->user_id;
            echo '<br>';
        }*/
        

        //Render View
        return $this->render('outgoing', ['user'=> $user]);
     }
     public function actionCancle($id, $friend)
     {
        
        $check = Friend::find()->where(['user_id' => $id])->where(['friend_id' => $friend])->count();

         if($check == 1){     

            $cancle = Friend::find()
            ->where(
                ['user_id' => $id]
            )->where(['friend_id' => $friend])
            ->one();

           $cancle->status = Friend::REJECTED;

            $cancle->save();         
            Yii::$app->getSession()->setFlash('sucess', 'Friend rquest cancled');

            return $this->redirect('index.php?r=myapp/outgoing&id='.$id);

            
         }else{
            Yii::$app->getSession()->setFlash('error', 'An error occur');
            return $this->redirect('index.php?r=myapp');
         }

     }

      

    
      public function actionIncoming($id){
         //get outgoing friend request
        $user = User::findOne($id);

        //Render View
        return $this->render('incoming', ['user'=> $user]);
     }

     public function actionAccept($id, $friend)
     {
        $check = Friend::find()->where(['user_id' => $id])->where(['friend_id' => $friend])->count();

         if($check > 0){     

            $Accept = Friend::find()->where(['user_id' => $id])->where(['friend_id' => $friend])->one();
            $Accept->status = Friend::ACCEPTED;
           

            $Accept->save();         
            Yii::$app->getSession()->setFlash('success', 'Friend Request ACCEPTED');
            return $this->redirect('index.php?r=myapp');
         }else{
            Yii::$app->getSession()->setFlash('error', 'An error occur');
            return $this->redirect('index.php?r=myapp');
        }

     }

     public function actionReject($id, $friend)
     {
         $check = Friend::find()->where(['user_id' => $id])->where(['friend_id' => $friend])->count();

         if($check > 0){     

            $Reject = Friend::find()->where(['user_id' => $id])->where(['friend_id' => $friend])->one();
            $Reject->status = Friend::REJECTED;
           

            $Reject->save();         
            Yii::$app->getSession()->setFlash('success', 'Friend Request REJECTED');
            return $this->redirect('index.php?r=myapp');
         }else{
            Yii::$app->getSession()->setFlash('error', 'An error occur');
            return $this->redirect('index.php?r=myapp');
        }

     }
     
     public function actionMyfriends($id){
        $query = Friend::find()->where(['or', 'user_id' => $id, 'friend_id' => $id])->all();
        $status_PENDING = FRIEND::PENDING;
        $status_REJECTED = FRIEND::REJECTED;
        return $this->render('myfriends', 
            [
                'query'=> $query,
                'status_REJECTED' => $status_REJECTED,
                'status_PENDING' => $status_PENDING
            ]
        );
            
     }

     
     


}
