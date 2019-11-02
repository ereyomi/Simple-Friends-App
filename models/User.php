<?php

namespace app\models;

use yii;
use yii\base\Model;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use app\models\Friend;

class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;

    /* API*/
    const SCENARIO_CREATE = 'create';
    /*----*/

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }
    /*  
    * API
    *
    */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['first_name','Last_Name', 'username', 'email', 'password']; 
        return $scenarios; 
    }
    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function validatePassword($password)
    {
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
            // all good, logging user in
            return true;
        } else {
            // wrong password
            return false;
        }
    }

    public function findByEmail($email){
        return User::findOne(['email' => $email]);
    }
    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            /*if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }*/
            if (isset($this->password)) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                return parent::beforeSave($insert);
            }
        }
        return true;
    }


    public function getFriends(){
        return $this->hasMany(Friend::className(), ['user_id' => 'id']);
    }

    public function getOutgoingfriends(){
        return $this->hasMany(Friend::className(), ['user_id' => 'id'])->where(['status' => Friend::PENDING]);
    }
    
    public function getIncomingfriends(){
        return $this->hasMany(Friend::className(), ['friend_id' => 'id'])->where(['status' => Friend::PENDING]);
    }
    
    public function getfriendsAccepted(){
        return $this->hasMany(Friend::className(), ['user_id' => 'id'])->where(['status' => Friend::ACCEPTED]);
    }
    public function getAcceptedfriends(){
        return $this->hasMany(Friend::className(), ['friend_id' => 'id'])->where(['status' => Friend::ACCEPTED]);
    }
}