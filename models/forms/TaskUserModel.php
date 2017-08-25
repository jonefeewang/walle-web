<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class TaskUserModel extends Model
{
    public $developer;
    public $reviewer;
    public $deployer;
    public $tester;
    public $product;

    public function init()
    {
        $this->developer = \Yii::$app->user->getId();
        $this->deployer = \Yii::$app->user->getId();
        parent::init();
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['developer', 'reviewer', 'deployer', 'tester','product'], 'required'],
            // rememberMe must be a boolean value
        ];
    }


}
