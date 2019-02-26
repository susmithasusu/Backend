<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $phone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','password','email','phone'],'required'],
            ['name', 'trim'],
            ['name', 'required'],
           
            ['name', 'string', 'min' => 2, 'max' => 200],
            [['name'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['phone'],'match','pattern'=>  '/^[6-9][0-9]{9}$/' ],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 200],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 5],
            [['password'],'match','pattern'=> '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{5,16}$/m', 'message' => 'password should contain atleast one uppercase letter, digit and a special charecter.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {

            Yii::$app->api->sendFailedResponse($this->errors);
            //return null;
        }
        
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone=$this->phone;
        $user->setPassword($this->password);
        $user->status = 0;
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
