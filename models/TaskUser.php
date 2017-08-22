<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taskuser".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property smallinteger $role
 *
 */
class TaskUser extends \yii\db\ActiveRecord
{
    const TASK_DEVELOPER  = 1;
    //代码审核人员
    const TASK_REVIEWER  = 2;
    const TASK_DEPLOYER  = 3;
    const TASK_TESTER  = 4;
    const TASK_PRODUCT  = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taskuser';
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id',]);
    }

    public static function isTester($taskId,$uid){
        $isTester = static::find()
            ->where(['user_id' => $uid, 'role' => TaskUser::TASK_TESTER,'task_id'=>$taskId]);
        return $isTester->count();
    }
    public static function isDeveloper($taskId,$uid){
        $isTester = static::find()
            ->where(['user_id' => $uid, 'role' => TaskUser::TASK_DEVELOPER,'task_id'=>$taskId]);
        return $isTester->count();
    }
}