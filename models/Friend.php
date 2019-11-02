<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "friend".
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Friend extends \yii\db\ActiveRecord
{
     /*echo self::PENDING;*/

    const PENDING=0,
        ACCEPTED = 1,
        REJECTED = 2;
    /**
     * {@inheritdoc}
     */
   
    public static function tableName()
    {
        return 'friend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id', 'status'], 'required'],
            [['user_id', 'friend_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
   

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getFriend(){
        return $this->hasOne(User::className(), ['id' => 'friend_id']);
    }

}

